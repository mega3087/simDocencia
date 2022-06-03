<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Incidencias extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso');
		}
		
		public function index($limit = 20, $start = 0, $search = null, $filtro = 'Pendientes' ){
			$search = rtrim(ltrim(base64_decode($search)));
			$data = array();
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['search'] = $search;
			$data['filtro'] = $filtro;
			$data["nivel"] = 0;
			$where = '';
			
			if($data['search']){
				$where="(
						IClave = '".$data['search']."'
						or IClave_servidor like ('%".$data['search']."%') 
						or INombre like ('%".$data['search']."%')
						or CITipo like ('%".$data['search']."%')
				)";
			}
			
			if($data['filtro']){
				$where.=$where?' AND ':'';				
				if($data['filtro']=='Pendientes')
					$where.="INivel_autorizacion BETWEEN '0' AND '1' AND IActivo = '1'";
				if($data['filtro']=='Autorizados')
					$where.="INivel_autorizacion = 1";
				if($data['filtro']=='Recibidos')
					$where.="INivel_autorizacion = 2";
				if($data['filtro']=='Registrados')
					$where.="INivel_autorizacion = 3";
				if($data['filtro']=='Cancelados')
					$where.="IActivo = '0'";
			}
			
			$this->db->join('nocincidencia','ITipo = CIClave','INNER');
			$this->db->where('IUsuario',get_session('UNCI_usuario'));
			$this->db->limit($data['limit'], $data['start']);
			$this->db->order_by('IClave DESC');
			$data["incidencias"] = $this->incidencias_model->find_all($where);
			
			$this->db->where('IUsuario',get_session('UNCI_usuario'));
			$data["total"] = count($this->incidencias_model->find_all($where));
			
			$where = array( 'CIActivo' => 1 );
			$data["cincidencia"] = $this->cincidencia_model->find_all($where);
			
			$where = array( 
				"CPLClave" => get_session('UPlantel'),
 			);
			$data["planteles"] = $this->plantel_model->find_all($where,'CPLClave, CPLNombre');
			
			$where = array( 'UNCI_usuario' => get_session('UNCI_usuario') );
			$data["usuario"] = $this->usuario_model->find($where);
			
			$data['title'] = $this->router->fetch_class();
			$data['modulo'] = $this->router->fetch_method();
			$data['subvista'] = 'incidencias/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function save(){
			if(! $_POST)
				redirect( $this->router->fetch_class() );
				
			$data= post_to_array('_skip');
		
			$this->_set_rules('i',$data); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				muestra_mensaje();
			}else{
				$IClave_skip=$this->input->post('IClave_skip');
				$IClave=$this->encrypt->decode($IClave_skip);
				
				$plantel = $this->plantel_model->get($data['IPlantel'],'CPLClave,CPLNombre,CPLDirector');

				$data['IComision'] = nvl($data['IComision']);
				$data['IUsuario'] = get_session('UNCI_usuario');
				$data['IFechai'] = fecha_format( $data['IFechai'] );
				$data['IFechaf'] = fecha_format( $data['IFechaf'] );
				$data['IFecha_creacion'] = date('Y-m-d');
				
				$data['IJefeInmediato'] = $plantel['CPLDirector']." <br /> JEFE DEL ".$plantel['CPLNombre'];
				$firmantes = $this->firmante_model->find_all();
				if($firmantes)
					$data['IJefeRH'] = $firmantes['1']['FINombre']."<br />".$firmantes['1']['FICargo'];
				
				if(!$IClave){
					$IClave = $this->incidencias_model->insert($data);
					$IClave =folio($IClave);
					set_mensaje("Se registro una nueva incidencia con el número de folio <b>$IClave</b>",'success::');
				}else{
					$this->incidencias_model->update($IClave,$data);
					$IClave =folio($IClave);
					set_mensaje("La incidencia con el número folio <b> ".$IClave." </b> se actualizó con éxito",'success::');
				}
				echo "OK";
			}
		
		}
		
		public function oficio($IClave_skip = null, $pdf = false){
			//var
			$data = array();
			
			$IClave=$this->encrypt->decode($IClave_skip);
			
			$this->db->join('nousuario','IUsuario = UNCI_usuario','INNER');
			$this->db->join('nocincidencia','ITipo = CIClave','INNER');
			$data['incidencia'] = $this->incidencias_model->get($IClave);
			
			if($pdf){
				if($data['incidencia']['CITramite']==1){
					$data['titulo'] = "<h1>&nbsp;</h1>";
					$data['subvista'] = 'incidencias/oficio_pdf_view';
				}else{
					$data['subvista'] = 'incidencias/oficio_pdf_view';
				}
				$this->load->library('dpdf');
				$this->dpdf->load_view('plantilla_general_pdf',$data);
				$this->dpdf->setPaper('letter', 'portrait');			
				$this->dpdf->render();
				$this->dpdf->stream("fump.pdf",array("Attachment"=>false));
			}
		}
		
		public function aviso($IClave_skip = null, $pdf = false){
			//var
			$data = array();
			
			$IClave=$this->encrypt->decode($IClave_skip);
			
			$this->db->join('nocincidencia','ITipo = CIClave','INNER');
			$data["incidencia"] = $this->incidencias_model->get($IClave);
			
			$this->db->where_in( 'CIActivo', array(0,1) );
			$data["cincidencia"] = $this->cincidencia_model->find_all();
			
			if($pdf){
				$data['titulo'] = "<h1>&nbsp;</h1>";
				$data['subvista'] = 'incidencias/aviso_pdf_view';
				$this->load->library('dpdf');
				$this->dpdf->load_view('plantilla_general_pdf',$data);
				$this->dpdf->setPaper('letter', 'portrait');			
				$this->dpdf->render();
				$this->dpdf->stream("fump.pdf",array("Attachment"=>false));
			}
		}
		
		public function autorizar($limit = 20, $start = 0, $search = null, $filtro = 'Pendientes' ){
			$search = rtrim(ltrim(base64_decode($search)));
			$data = array();
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['search'] = $search;
			$data['filtro'] = $filtro;
			$data["nivel"] = 1;
			$where = '';
			
			if($data['search']){
				$where="( 
						IClave = '".$data['search']."'
						or IClave_servidor like ('%".$data['search']."%') 
						or INombre like ('%".$data['search']."%')
						or CITipo like ('%".$data['search']."%')
				)";
			}
			
			if($data['filtro']){
				$where.=$where?' AND ':'';				
				if($data['filtro']=='Pendientes')
					$where.="INivel_autorizacion = '0' AND IActivo = '1'";
				if($data['filtro']=='Autorizados')
					$where.="INivel_autorizacion = 1";
				if($data['filtro']=='Recibidos')
					$where.="INivel_autorizacion = 2";
				if($data['filtro']=='Registrados')
					$where.="INivel_autorizacion = 3";
				if($data['filtro']=='Cancelados')
					$where.="IActivo = '0'";
			}
			
			$this->db->join('nocincidencia','ITipo = CIClave','INNER');
			$this->db->where('IPlantel',get_session('UPlantel'));
			$this->db->limit($data['limit'], $data['start']);
			$this->db->order_by('IClave DESC');
			$data["incidencias"] = $this->incidencias_model->find_all($where);
			
			$this->db->where('IPlantel',get_session('UPlantel'));
			$data["total"] = count($this->incidencias_model->find_all($where));
			
			$where = array( 'CIActivo' => '1' );
			$data["cincidencia"] = $this->cincidencia_model->find_all($where);
			
			$where = array( "CPLClave" => get_session('UPlantel') );
			$data["planteles"] = $this->plantel_model->find_all($where,'CPLClave, CPLNombre');
			
			$where = array( 'UNCI_usuario' => get_session('UNCI_usuario') );
			$data["usuario"] = $this->usuario_model->find($where);
			
			$data['title'] = $this->router->fetch_method()." ".$this->router->fetch_class();
			$data['modulo'] = $this->router->fetch_method();
			$data['subvista'] = 'incidencias/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function registrar($limit = 20, $start = 0, $search = null, $filtro = 'Pendientes' ){
			$search = rtrim(ltrim(base64_decode($search)));
			$data = array();
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['search'] = $search;
			$data['filtro'] = $filtro;
			$data["nivel"] = 2;
			$where = '';
			
			if($data['search']){
				$where="( 
						IClave = '".$data['search']."'
						or IClave_servidor like ('%".$data['search']."%') 
						or INombre like ('%".$data['search']."%')
						or CITipo like ('%".$data['search']."%')
				)";
			}
			
			if($data['filtro']){
				$where.=$where?' AND ':'';				
				if($data['filtro']=='Pendientes')
					$where.="INivel_autorizacion BETWEEN '1' AND '2'";
				if($data['filtro']=='Autorizados')
					$where.="INivel_autorizacion BETWEEN '2' AND '3'";
				if($data['filtro']=='Recibidos')
					$where.="INivel_autorizacion = 2";
				if($data['filtro']=='Registrados')
					$where.="INivel_autorizacion = 3";
				if($data['filtro']=='Cancelados')
					$where.="IActivo = '0'";
			}
			
			$this->db->join('nocincidencia','ITipo = CIClave','INNER');
			$this->db->where("INivel_autorizacion >= 1");
			$this->db->limit($data['limit'], $data['start']);
			$this->db->order_by('IClave DESC');
			$data["incidencias"] = $this->incidencias_model->find_all($where);
			
			$this->db->where("INivel_autorizacion >= 1");
			$this->db->where('IPlantel',get_session('UPlantel'));
			$data["total"] = count($this->incidencias_model->find_all($where));
			
			$where = array( 'CIActivo' => '1' );
			$data["cincidencia"] = $this->cincidencia_model->find_all($where);
			
			$where = array( "CPLClave" => get_session('UPlantel') );
			$data["planteles"] = $this->plantel_model->find_all($where,'CPLClave, CPLNombre');
			
			$where = array( 'UNCI_usuario' => get_session('UNCI_usuario') );
			$data["usuario"] = $this->usuario_model->find($where);
			
			$data['title'] = $this->router->fetch_method()." ".$this->router->fetch_class();
			$data['modulo'] = $this->router->fetch_method();
			$data['subvista'] = 'incidencias/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function nivel($nivel=null,$IClave_skip){
			$IClave = $this->encrypt->decode( $IClave_skip );	
			
			if($nivel==1){
				$usuario ="IUsuario_autorizo";
				$fecha ="IFecha_autorizo";
			}elseif($nivel==2){
				$usuario ="IUsuario_recibio";
				$fecha ="IFecha_recibio";
			}elseif($nivel==3){
				$usuario ="IUsuario_registro";
				$fecha  ="IFecha_registro";
			}				
			
			$data = array(
				"INivel_autorizacion"	=> $nivel,
				"$fecha"	=> date('Y-m-d H:i:s'),
				"$usuario"	=> get_session('UNCI_usuario')
			);
			
			$this->incidencias_model->update($IClave, $data);
			set_mensaje("La incidencia con folio <b>".folio($IClave)."</b> se actualizó con éxito",'success::');
			to_back();
		}
		
		public function delete($IClave_skip){
			$IClave = $this->encrypt->decode( $IClave_skip );			
			$data = array("IActivo" => '0' );
			$this->incidencias_model->update($IClave, $data);
			set_mensaje("La incidencia con folio <b>".folio($IClave)."</b> se cancelo con éxito",'success::');
			to_back();
		}
		
		public function textocomision_skip(){
			$CIClave=$this->input->post('ITipo');
			$where = array( 'CIClave' => $CIClave );
			$cincidencia = $this->cincidencia_model->find($where);
			if($cincidencia['CITramite']){
				echo $cincidencia['CITexto'];
			}else{
				echo "<em>No se necesita texto adicional.</em>";
			}
		}
		
		public function cincidencias(){
			$data = array();
			
			$data["incidencias"] = $this->cincidencia_model->find_all();
			
			$data['title'] = $this->router->fetch_class();
			$data['modulo'] = $this->router->fetch_method();
			$data['subvista'] = 'incidencias/Catalogo_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function csave(){
			if(! $_POST)
				redirect( $this->router->fetch_class() );
				
			$data= post_to_array('_skip');
			$this->_set_rules('ci',$data); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				muestra_mensaje();
			}else{
				$CIClave_skip=$this->input->post('CIClave_skip');
				$CIClave=$this->encrypt->decode($CIClave_skip);
				
				if(! $CIClave){
					$data['CIUsuario_registro']=get_session('UNCI_usuario');
					$CIClave = $this->cincidencia_model->insert($data);
					set_mensaje("La incidencia con clave [<b> $CIClave </b>] se registro con éxito",'success::');
				}else{				
					$data['CIUsuario_modifico']=get_session('UNCI_usuario');
					$data['CIFecha_modifico']=date('Y-m-d H:i:s');
					$this->cincidencia_model->update($CIClave,$data);
					set_mensaje("La Incidencia con clave [<b> $CIClave </b>] se actualizó con éxito",'success::');
				}
				echo "OK";
			}
		}	
		
		function _set_rules($c='', $data = array()){
			
			if($c=='i'){
				$fechas = $data['IFechai'].",".$data['IFechaf'];
				$horas = $data['IHorai'].",".$data['IHoraf'];
				
				$this->form_validation->set_rules('IClave_servidor', 'Clave Servidor', "trim|min_length[3]|max_length[6]|numeric");
				$this->form_validation->set_rules('INombre', 'Nombre', "trim|required|min_length[5]|max_length[255]");
				$this->form_validation->set_rules('IISSEMYM', 'ISSEMYM', "trim|min_length[3]|max_length[12]");
				$this->form_validation->set_rules('IPlaza', 'Nombre de la Plaza', "trim|required|min_length[5]|max_length[50]");
				$this->form_validation->set_rules('IPlantel', 'Departamento', "trim|required|min_length[1]|max_length[3]");
				$rango_fechas = date('d/m/Y', strtotime('0 days')) . "," . date('d/m/Y', strtotime('15 days'));
				$this->form_validation->set_rules('IFechai', 'Fecha de permiso inicial', "trim|required|max_length[10]|valida_fecha[$rango_fechas]");
				$this->form_validation->set_rules('IFechaf', 'Fecha de permiso final', "trim|required|max_length[10]|valida_fecha[$rango_fechas]|callback__fecha_mayor[$fechas]");
				$this->form_validation->set_rules('IHorai', 'Hora inicial', "trim|required|min_length[5]|max_length[8]|valida_hora|callback__validar_tiempoi[$horas]");
				$this->form_validation->set_rules('IHoraf', 'Hora final', "trim|required|min_length[5]|max_length[8]|valida_hora|callback__validar_tiempof[$horas]");
				$this->form_validation->set_rules('IExcento', 'Excento de', "trim|required|min_length[3]|max_length[16]");
				$this->form_validation->set_rules('ITipo', 'Tipo de incidencia', "trim|required|min_length[1]|max_length[3]");

			}
			if($c=='ci'){
				$this->form_validation->set_rules('ITipo', 'Tipo', "trim|min_length[3]|max_length[255]");
			}
			
			// fin de la funcion _set_rules
		}
		
		function _fecha_mayor($fecha,$fechas){
			// Si la fecha esta vacia entonces se considera valida
			if (empty($fechas)) return true;
			
			list($fecha_inicial,$fecha_final) = explode(',', $fechas);
			
			$fecha_inicial = fecha_format($fecha_inicial,'%d/%m/%Y');
			$fecha_final = fecha_format($fecha_final,'%d/%m/%Y');
			
			$fechai = strtotime($fecha_inicial);
			$fechaf = strtotime($fecha_final);
			
			if($fechai > $fechaf){
				$this->form_validation->set_message('_fecha_mayor', "La %s debe ser igual o posterior al $fecha_inicial.");
				return false;
			}
		}
		
		function _validar_tiempoi($hora,$horas){
			// Si la hora esta vacia entonces se considera valida
			if (empty($horas)) return true;
			
			list($hora_inicial,$hora_final) = explode(',', $horas);
			
			$horai = strtotime($hora_inicial);
			$horaf = strtotime($hora_final);
			
			if($horai < strtotime('07:00')){
				$this->form_validation->set_message('_validar_tiempoi', "La %s debe ser igual o posterior a 07:00");
				return false;
			}else if($horai > strtotime('20:00')){
				$this->form_validation->set_message('_validar_tiempoi', "La %s debe ser igual o anterior a 20:00.");
				return false;
			}
			
		}
		
		function _validar_tiempof($hora,$horas){
			// Si la hora esta vacia entonces se considera valida
			if (empty($horas)) return true;
			
			list($hora_inicial,$hora_final) = explode(',', $horas);
			
			$horai = strtotime($hora_inicial);
			$horaf = strtotime($hora_final);
			
			if($horaf < strtotime('07:00')){
				$this->form_validation->set_message('_validar_tiempof', "La %s debe ser igual o posterior a $hora_inicial.");
				return false;
			}else if($horaf > strtotime('20:00')){
				$this->form_validation->set_message('_validar_tiempof', "La %s debe ser igual o anterior a 20:00.");
				return false;
			}
			
			if($horai > $horaf){
				$this->form_validation->set_message('_validar_tiempof', "La %s debe ser igual o posterior a $hora_inicial.");
				return false;
			}
		}
		
	}