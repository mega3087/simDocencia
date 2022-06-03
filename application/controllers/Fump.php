<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Fump extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso'); // Verificamos que el usuario tenga el permiso
		}
		
		public function index($UNCI_usuario_skip = null){
			$data['UNCI_usuario_skip'] = $UNCI_usuario_skip;
			$UNCI_usuario = $this->encrypt->decode( $UNCI_usuario_skip );
			
			$data['usuario'] = $this->usuario_model->get($UNCI_usuario);
			
			$data['plantel'] = $this->plantel_model->get(get_session('UPlantel'));
			
			$select = "*,(SELECT CPEPeriodo FROM nocperiodos WHERE FFecha_inicio BETWEEN CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) AND CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin) ) FPeriodo";
			
			if( is_permitido(null,"personal","ver_todos") ){
				
			}elseif( is_permitido(null,"fump","save") ){
				$this->db->where( "((acceptTerms = 'on' AND FNivel_autorizacion = 7) or FPlantel like '%".$data['plantel']['CPLNombre']."%' or FDepartamento like '%".$data['plantel']['CPLNombre']."' )" );
			}else{
				$this->db->where( "acceptTerms", 'on' );
				$this->db->where( "FNivel_autorizacion >=", '7' );
			}
			
			$this->db->where( "FUsuario", $UNCI_usuario );
			$this->db->where( "FActivo", 1);
			$data['fump'] = $this->fump_model->find_all(null,$select);
			
			$data['config'] = $this->config_model->get(1);
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'fump/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function agregar($UNCI_usuario_skip = null, $FClave_skip = null){
			
			$UNCI_usuario = $this->encrypt->decode( $UNCI_usuario_skip );
			$data['UNCI_usuario_skip'] = $UNCI_usuario_skip;
			
			$FClave = $this->encrypt->decode( $FClave_skip );
			$data['FClave_skip'] = $FClave_skip;
			
			if(! is_permitido(null,"personal","ver_todos") ){
				$this->db->where( "CPLClave", get_session('UPlantel') );
			}
			$this->db->select("*,(SELECT CPLNombre FROM noplanteles cpl2 WHERE cpl2.CPLClave = cpl1.CPLUnidad LIMIT 1 ) as direccion");
			$this->db->group_by("direccion");
			$query = $this->db->get("noplanteles cpl1");
			$data['planteles'] = $query->result_array();
			
			$this->db->where("FUsuario", $UNCI_usuario);
			$this->db->where("FNivel_autorizacion >=", 6);
			$this->db->order_by("FFecha_termino DESC");
			$data['ufumpf'] = $this->fump_model->find();
			
			$this->db->where("FUsuario", $UNCI_usuario);
			$this->db->where("FNivel_autorizacion >=", 6);
			$this->db->where("FTramite_otro NOT IN('LICENCIA PERSONAL')");
			$this->db->order_by("FFecha_termino DESC");
			$data['ufump'] = $this->fump_model->find();
			
			if(! is_permitido(null,"personal","ver_todos") ){
				$this->db->where( "CPLUnidad", $data['planteles'][0]['CPLUnidad'] );
			}
			$this->db->join("nousuario","CPLDirector = UNCI_usuario","LEFT");
			$data['departamentos'] = $this->plantel_model->find_all();
			
			if($FClave){
				$data['fump'] = $this->fump_model->get($FClave);
				$data['titulo'] = 'EDITAR FUMP';
			}else{
				$data['usuario'] = $this->usuario_model->get($UNCI_usuario);
				$data['titulo'] = "NUEVO FUMP";
			}
			
			$data['personal'] = $this->docper_model->find("DPPersonal = $UNCI_usuario");
			
			$data['estado_civil'] = $this->estciv_model->find_all();
			
			$data['datos'] = $this->usuario_model->get($UNCI_usuario);
			
			$where = array("SEFump" => $FClave, "SENivel" => 1);
			$this->db->order_by("SEClave DESC");
			$this->db->join("nousuario","SEUsuario_registro = UNCI_usuario","INNER");
			$data['seguimiento'] = $this->seguimiento_model->find_all($where);
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'fump/Form_view';
			$this->load->view('plantilla_general', $data);
		}
		
		public function departamento(){
			$data= post_to_array('_skip');
			
			$where = array ( "CPLNombre" => $data['FPlantel'] ); 
			$plantel = $this->plantel_model->find($where);
			
			$this->db->where( "CPLUnidad", $plantel['CPLClave'] );
			$data['deptos'] = $this->plantel_model->find_all();
			
			echo '<option value=""></option>';
			foreach($data['deptos'] as $key => $list){
				echo '<option value="'.$list['CPLNombre'].'">'.$list['CPLNombre'].'</option>';
			}
			
			if($plantel['CPLCorreo_electronico'])
				echo "::".$plantel['CPLCorreo_electronico'];
			else
				echo "::sin resultados -> actualizar el catalogo de planteles";
			
		}
		
		public function ver_plaza(){
			$data= post_to_array('_skip');
			
			$tipo_plantel = $this->input->post('Tipo_plantel_skip');			
			if($tipo_plantel == 35){
				$names = array('Plantel', 'Ambos');
				$this->db->where_in('PLTipo_plantel', array('Plantel', 'Ambos'));
			}elseif($tipo_plantel == 36){
				$this->db->where("PLTipo_plantel", 'Centro' );
			}elseif($tipo_plantel == 37){
				$this->db->where_in('PLTipo_plantel', array('General', 'Ambos'));
			}
			
			$tipo = $data['FTipo_plaza'];
			if($tipo=='ADMINSTRATIVO'){
				$where = array("PLTipo" => 'Administrativo');
			}elseif($tipo=='DIRECTIVO O CONFIANZA'){
				$where = array("PLTipo" => 'Directivo');
			}else{
				$PLTipo_clase = NULL;
				if(nvl($data['FTipo_asignatura'])=="CURRICULARES") {
					$PLTipo_clase = "Profesor";
				}elseif(nvl($data['FTipo_asignatura'])=="COCURRICULARES"){
					if(nvl($data['FTipo_horas_clase'])=="PROFE CB-I"){
						$PLTipo_clase = "Profesor";
					}else{
						$PLTipo_clase = "Tecnico";
					}
				}
				
				$this->db->where("PLTipo_clase", $PLTipo_clase );
				$this->db->where("PLJornada", nvl($data['FTipo_jornada']));
				$where = array("PLTipo" => 'Docente');
			}
			$this->db->where("PLActivo", 1 );
			$data = $this->plaza_model->find_all($where,null,'PLPuesto ASC');
			echo "<option value=''></option>";
			foreach($data as $key => $list){
				echo "<option value='".$list['PLPuesto']."'>".$list['PLPuesto']."</option>";
			}
		}
		
		public function plaza_sindicato(){
			$data= post_to_array('_skip');
			$FNombre_plaza = $this->input->post('FNombre_plaza');
			
			$where= array('PLPuesto'=> $FNombre_plaza);
			$data = $this->plaza_model->find($where,'PLSindicato');
			echo$data['PLSindicato'];
		}
		
		public function ver_tabla(){
			$data= post_to_array('_skip');
			
			
			$tipo_plantel = $this->input->post('Tipo_plantel_skip');			
			if($tipo_plantel == 35){
				$names = array('Plantel', 'Ambos');
				$this->db->where_in('PLTipo_plantel', array('Plantel', 'Ambos'));
			}elseif($tipo_plantel == 36){
				$this->db->where("PLTipo_plantel", 'Centro' );
			}elseif($tipo_plantel == 37){
				$this->db->where_in('PLTipo_plantel', array('General', 'Ambos'));
			}
			
			$data['numero'] = 0;
			
			if(nvl($data['FTipo_jornada']) or nvl($data['FTipo_plaza']) != "ACADÉMICO"){
				if(nvl($data['FTipo_jornada']))
					$this->db->where("PLJornada", $data['FTipo_jornada']);
				$this->db->where("PLPuesto", nvl($data['FNombre_plaza']));			
				$data['jornada'] = $this->plaza_model->find();
				$data['numero'] = 1;
			}
			
			if(nvl($data['FExtra_tecnico_cbi'])){
				$data['tecnico_cbi'] = $this->plaza_model->find(array("PLPuesto" => 'TECNICO DOCENTE CB-I'));
				$data['numero'] = 2;
			}
			if(nvl($data['FRecate_tecnico_cbii'])){
				$data['tecnico_cbii'] = $this->plaza_model->find(array("PLPuesto" => 'TECNICO DOCENTE CB-II'));
				$data['numero'] = 2;
			}
			if(nvl($data['FExtra_profe_cbi'])){
				if($data['FNombre_plaza']=="EMSAD I" or $data['FNombre_plaza']=="EMSAD II" or $data['FNombre_plaza']=="EMSAD III"){
					$data['profe_cbi'] = $this->plaza_model->find(array("PLPuesto" => 'EMSAD I'));
				}else{
					$data['profe_cbi'] = $this->plaza_model->find(array("PLPuesto" => 'PROFESOR CB-I'));
				}
				$data['numero'] = 3;
			}
			if(nvl($data['FExtra_profe_cbii']) or nvl($data['FRecate_profe_cbii'])){
				if($data['FNombre_plaza']=="EMSAD I" or $data['FNombre_plaza']=="EMSAD II" or $data['FNombre_plaza']=="EMSAD III"){
					$data['profe_cbii'] = $this->plaza_model->find(array("PLPuesto" => 'EMSAD II'));
				}else{
					$data['profe_cbii'] = $this->plaza_model->find(array("PLPuesto" => 'PROFESOR CB-II'));
				}
				$data['numero'] = 3;
			}
			if(nvl($data['FExtra_profe_cbiii']) or nvl($data['FRecate_profe_cbiii'])){
				if($data['FNombre_plaza']=="EMSAD I" or $data['FNombre_plaza']=="EMSAD II" or $data['FNombre_plaza']=="EMSAD III"){
					$data['profe_cbiii'] = $this->plaza_model->find(array("PLPuesto" => 'EMSAD III'));
				}else{
					$data['profe_cbiii'] = $this->plaza_model->find(array("PLPuesto" => 'PROFESOR CB-III'));
				}
				$data['numero'] = 3;
			}
			
			if(! $data['numero'] ){
				if($data['FTipo_horas_clase']=='TÉCNICO CB-I'){
					if($data['FNombre_plaza']=="TECNICO DOCENTE CB-I"){
						$data['FExtra_tecnico_cbi'] = nvl($data['FHoras_clase_totales']);
						$data['tecnico_cbi'] = $this->plaza_model->find(array("PLPuesto" => 'TECNICO DOCENTE CB-I'));
					}elseif($data['FNombre_plaza']=="TECNICO DOCENTE CB-II"){
						$data['FRecate_tecnico_cbii'] = nvl($data['FHoras_clase_totales']);
						$data['tecnico_cbii'] = $this->plaza_model->find(array("PLPuesto" => 'TECNICO DOCENTE CB-II'));
					}
				}elseif($data['FTipo_horas_clase']=='PROFE CB-I'){
					if($data['FNombre_plaza']=="PROFESOR CB-I"){
						$data['FExtra_profe_cbi'] = nvl($data['FHoras_clase_totales']);
						$data['profe_cbi'] = $this->plaza_model->find(array("PLPuesto" => 'PROFESOR CB-I'));
					}elseif($data['FNombre_plaza']=="PROFESOR CB-II"){
						$data['FExtra_profe_cbii'] = nvl($data['FHoras_clase_totales']);
						$data['profe_cbii'] = $this->plaza_model->find(array("PLPuesto" => 'PROFESOR CB-II'));
					}elseif($data['FNombre_plaza']=="PROFESOR CB-III"){
						$data['FExtra_profe_cbiii'] = nvl($data['FHoras_clase_totales']);
						$data['profe_cbiii'] = $this->plaza_model->find(array("PLPuesto" => 'PROFESOR CB-III'));
					}elseif($data['FNombre_plaza']=="EMSAD I"){
						$data['FExtra_profe_cbi'] = nvl($data['FHoras_clase_totales']);
						$data['profe_cbi'] = $this->plaza_model->find(array("PLPuesto" => 'EMSAD I'));
					}elseif($data['FNombre_plaza']=="EMSAD II"){
						$data['FExtra_profe_cbii'] = nvl($data['FHoras_clase_totales']);
						$data['profe_cbii'] = $this->plaza_model->find(array("PLPuesto" => 'EMSAD II'));
					}elseif($data['FNombre_plaza']=="EMSAD III"){
						$data['FExtra_profe_cbiii'] = nvl($data['FHoras_clase_totales']);
						$data['profe_cbiii'] = $this->plaza_model->find(array("PLPuesto" => 'EMSAD III'));
					}
				}
			}
			
			$this->load->view('fump/Tabla_view', $data);
		}
		
		public function correo_depto(){
			$data= post_to_array('_skip');
			$where = array ( "CPLNombre" => $data['FDepartamento'] );
			$this->db->join("nousuario","CPLDirector = UNCI_usuario","LEFT");
			$plantel = $this->plantel_model->find($where);
			if($plantel['CPLCorreo_electronico']){
				echo "::".$plantel['CPLCorreo_electronico'];
				echo "::".$plantel['CPLTipo'];
				echo "::".$plantel['CPLDirector'];
				echo "::".$plantel['CPLCoordinacion'];
			}
			else{
				echo "::sin resultados -> actualizar el catalogo de planteles";
				echo "::";
			}
			
		}
			
		public function save(){
			if(! $_POST)
				redirect( $this->router->fetch_class() );
			
			$data= post_to_array('_skip');
			
			if(!nvl($data['FHorario_trabajo'])){
				$horario_i = $this->input->post('Horario_trabajo_i_skip');
				$horario_f = $this->input->post('Horario_trabajo_f_skip');
				$data['FHorario_trabajo'] = $horario_i." A ".$horario_f." HORAS";
			}
			
			$antiguedad_a = $this->input->post('FAntiguedad_efectiva_a_skip');
			$antiguedad_m = $this->input->post('FAntiguedad_efectiva_m_skip');
			if($antiguedad_a or $antiguedad_m){
				$antiguedad_a = $antiguedad_a ? $antiguedad_a : 0;
				$antiguedad_m = $antiguedad_m ? $antiguedad_m : 0;
				
				$antiguedad_a = $antiguedad_a == 1 ? $antiguedad_a." AÑO" : $antiguedad_a." AÑOS";
				$antiguedad_m = $antiguedad_m == 1 ? $antiguedad_m." MES" : $antiguedad_m." MESES";
				
				$data['FAntiguedad_efectiva'] = $antiguedad_a." ".$antiguedad_m;
			}
			else{
				$data['FAntiguedad_efectiva'] = "0 AÑOS 0 MESES";
			}
			
			//clave nueva del fump
			$FClave_skip = $this->input->post('FClave_skip');
			$FClave = $this->encrypt->decode($FClave_skip);
		
			$this->_set_rules('u',$data); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				muestra_mensaje();
				echo"::$FClave_skip";
			}else{
				nvl($data['acceptTerms']);
				$data['FTramite'] = @implode(";",$data['FTramite']);
				
				//usuario a editar
				$UNCI_usuario_skip=$this->input->post('UNCI_usuario_skip');
				$UNCI_usuario=$this->encrypt->decode($UNCI_usuario_skip);
				
				//buscar plantel
				$where = array("CPLNombre" => $data['FPlantel']);
				$plantel = $this->plantel_model->find($where);
				
				$data['FCPlantel'] = $plantel['CPLClave'];
				$data['FNivel_autorizacion'] = 1;
				
				//Obtener datos de los firmantes
				$firmantes = $this->firmante_model->find_all();
				if($firmantes){
					$data['FDirector_finanzas'] = $firmantes['0']['FINombre']."<br />".$firmantes['0']['FICargo'];
					$data['FRecursos_humanos']  = $firmantes['1']['FINombre']."<br />".$firmantes['1']['FICargo'];
					$data['FDirector_general']  = $firmantes['2']['FINombre']."<br />".$firmantes['2']['FICargo'];
				}
				$tipo_plantel = $this->input->post("Tipo_plantel_skip");
				$CPLCoordinacion = $this->input->post("CPLCoordinacion_skip");
				if($tipo_plantel=='35'){
					$data['FDirector'] = $data['FDirector']."<br /> DIRECTOR DEL PLANTEL ".$data['FPlantel'];
					$data['FPlantel'] = "PLANTEL ".$data['FPlantel'];
					$data['FDepartamento'] = "";
					if(strpos($data['FNombre_plaza'],"DIRECTOR DE PLANTEL") !== FALSE and $data['FNombre_plaza'] != 'SECRETARIA DE DIRECTOR DE PLANTEL' and $firmantes){
						if($CPLCoordinacion=='Mexico'){
							$data['FDirector'] =  $firmantes['3']['FINombre']."<br />".$firmantes['3']['FICargo'];
							$data['FCoordinacion'] =  'M';
							
						}else{
							$data['FDirector'] =  $firmantes['4']['FINombre']."<br />".$firmantes['4']['FICargo'];
							$data['FCoordinacion'] =  'T';
						}
					}
				}else if($tipo_plantel=='36'){
					$data['FDirector'] = $data['FDirector']."<br /> REPONSABLE DEL CENTRO EMSAD ".$data['FPlantel'];
					$data['FPlantel'] = "CENTRO ".$data['FPlantel'];
					$data['FDepartamento'] = "";
					if(strpos($data['FNombre_plaza'],"RESPONSABLE DEL CENTRO") !== FALSE and $firmantes){
						$data['FDirector'] =  $firmantes['4']['FINombre']."<br />".$firmantes['4']['FICargo'];
						$data['FCoordinacion'] =  'T';
					}
				}else{
					$data['FDirector'] = "";
				}
				
				nvl($data['FISSEMYM14']);
				nvl($data['FTipo_plaza']);				
				nvl($data['FTipo_jornada']);
				nvl($data['FExtra_tecnico_cbi']);
				nvl($data['FRecate_tecnico_cbii']);
				nvl($data['FExtra_profe_cbi']);
				nvl($data['FExtra_profe_cbii']);
				nvl($data['FExtra_profe_cbiii']);
				nvl($data['FRecate_profe_cbii']);
				nvl($data['FRecate_profe_cbiii']);
				nvl($data['FHoras_clase_totales']);
				
				nvl($data['FCambio']);
				nvl($data['FCambio_adscripcion_de']);
				nvl($data['FCambio_adscripcion_a']);
				nvl($data['FPlaza_anterior']);
				nvl($data['FPlaza_actual']);
				
				nvl($data['FDatos_baja']);
				
				$lista_archivos = array(
					'FNombramiento_file',
					'FConstancia_inhabilitacion_file',
					'FAntecedentes_penales_file',
					'FEmpleo_anterior_file',
					'FRenuncia_file',
					'FActa_defuncion_file',
					'FRescision_file',
					'FResolucion_file',
					'FInhabilitacion_file',
					'FJubilacion_file',
					'FAutorizacion_licencia_file',
					'FAutorizacion_incremento_file',
					'FOtro_file'
				);
				$old_data = $this->fump_model->get($FClave);
				mover_archivos($data,$lista_archivos,$old_data,"./documentos/$UNCI_usuario/$FClave/");

				//Crear un areglo con los archivos del personal	 del arreglo principal		
				$data_dp = array(
					'DPRFC' => nvl($data['DPRFC']),
					'DPCURP' => nvl($data['DPCURP']),
					'DPCredencial_elector' => nvl($data['DPCredencial_elector']),
					'DPCertificado_estudios' => nvl($data['DPCertificado_estudios']),
					'DPMov_ISSEMYM' => nvl($data['DPMov_ISSEMYM']),
					'DPCuenta' => nvl($data['DPCuenta']),
					'DPPersonal' => $UNCI_usuario
				);				
				//Quitar los archivos del arreglo principal
				unset($data['DPRFC']);
				unset($data['DPCURP']);
				unset($data['DPCredencial_elector']);
				unset($data['DPCertificado_estudios']);
				unset($data['DPMov_ISSEMYM']);
				unset($data['DPCuenta']);
				
				//Mover los archivos de documentación del personal
				$lista_archivos = array(
					'DPRFC',
					'DPCURP',
					'DPCredencial_elector',
					'DPCertificado_estudios',
					'DPMov_ISSEMYM',
					'DPCuenta',
				);				
				$old_data = $this->docper_model->find("DPPersonal = $UNCI_usuario");
				mover_archivos($data_dp,$lista_archivos,$old_data,"./documentos/$UNCI_usuario/");
				
				//Guardar los archivos en la tabla de documentos del personal
				if( $old_data ){
					$this->docper_model->update($old_data['DPClave'],$data_dp);
				}elseif( strpos( $data['FTramite'] , 'ALTA') !== true ){
					$this->docper_model->insert($data_dp);
				}

				$data['FLogo_cobaemex'] = "logo_cobaemex_2018.png";
				
				$data['FFecha_nacimiento'] = fecha_format($data['FFecha_nacimiento']);
				$data['FFecha_inicio'] = fecha_format(nvl($data['FFecha_inicio']));
				$data['FFecha_termino'] = fecha_format(nvl($data['FFecha_termino']));
				$data['FFecha_ingreso_cobaem'] = fecha_format(nvl($data['FFecha_ingreso_cobaem']));
				$data['FFecha_ultima_promocion'] = fecha_format(nvl($data['FFecha_ultima_promocion']));
				
				if( $FClave ){
					
					//actualizar seguimiento
					if($data['acceptTerms']){
						$this->db->set('SEfecha_correcion', date('Y-m-d H:i:s'));
						$this->db->where( array('SEFump' => $FClave, 'SEfecha_correcion' => null) );
						$this->db->update( 'noseguimiento' );
					}
					
					$data['FUsuario_modificacion']=get_session('UNCI_usuario');
					$data['FFecha_modificacion']=date('Y-m-d H:i:s');
					$this->fump_model->update($FClave,$data);
					set_mensaje("El FUMP con folio [<b> ".folio($FClave)." </b>] se guardo con éxito",'success::');
					echo"::$FClave_skip";
					echo"::".folio($FClave);
					echo"::OK";
				}else{
					$data['FUsuario'] = $UNCI_usuario;
					$data['FUsuario_registro'] = get_session('UNCI_usuario');
					$FClave = $this->fump_model->insert($data);
					$FClave_skip = $this->encrypt->encode($FClave);
					echo"::$FClave_skip";
					echo"::".folio($FClave);
				}
			}
		
		}
		
		public function ver($FClave_skip = null, $pdf = false,$nivel_skip = null){
			$FClave=$this->encrypt->decode($FClave_skip);
			$nivel=$this->encrypt->decode($nivel_skip);
			if(! $FClave or $nivel<0)
				redirect( $this->router->fetch_class() );
			
			$data = array();
			$this->db->join("nousuario","FUsuario = UNCI_usuario","INNER");
			$this->db->join("nodocper","DPPersonal = FUsuario","LEFT");
			$data = $this->fump_model->get($FClave);
			
			$where = array("SEFump" => $FClave);
			if(!is_permitido(null,"fump","comentarios") ){
			$this->db->where("SENivel", 1);
			}
			$this->db->order_by("SEFecha_registro DESC");
			$this->db->join("nousuario","SEUsuario_registro = UNCI_usuario","INNER");
			$data['seguimiento'] = $this->seguimiento_model->find_all($where);
			
			if($pdf!='pdf'){
				$data['nivel'] = $nivel;
				$data['icon'] = 'tint';
				$data['titulo'] = "FORMATO ÚNICO DE MOVIMIENTOS DE PERSONAL (FUMP)";
				$data['modulo'] = $this->router->fetch_class();
				$data['subvista'] = "fump/Ver_view";
				$this->load->view('plantilla_general',$data);
			}else{
				//$data['titulo'] = "<h1>FORMATO ÚNICO DE MOVIMIENTOS DE PERSONAL (FUMP)</h1>";
				//$data['firma_pie']= "<b>COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO</b><br />DEPARTAMENTO DE RECURSOS MATERIALES Y SERVICIOS GENERALES<br />DIRECCIÓN DE ADMINISTRACIÓN DE FINANZAS";
				//$data['pie_pagina']= "2da Privada de la Libertad #102. La Merced y Alameda, Toluca, Estado de México, Teléfonos: (01722) 2.26.04.50 al 5";
				$this->load->library('dpdf');
				$data['subvista'] = 'fump/Ver_pdf_view';
				$this->dpdf->load_view('plantilla_general_pdf',$data);
				$this->dpdf->setPaper('legal', 'portrait');			
				$this->dpdf->render();
				$this->dpdf->stream("fump.pdf",array("Attachment"=>false));
			}
			
		}
		
		public function plantel(){
			$tipo= $this->input->post("CPLTipo_skip");
			
			$this->db->where("CPLTipo",$tipo);
			$this->db->order_by("CPLNombre");
			$plantel = $this->plantel_model->get_all();
			
			echo '<select id="UPlantel" name="UPlantel" placeholder="PLANTEL" class="form-control" >';
				echo '<option value=""></option>';
				foreach($plantel as $pkey => $plist){
					echo '<option value="'.$plist['CPLClave'].'">'.$plist['CPLNombre'].'</option>';
				}
			echo '</select>';	
		}
		
		public function revisar($filtro = null, $CPLClave_skip = null, $periodo = '', $tramite = ''){
			$CPLClave = $this->encrypt->decode($CPLClave_skip);
			if(!$CPLClave){
				$CPLClave = get_session('UPlantel');
			}
			
			$data['nivel'] = 0;
			$data['filtro'] = $filtro;
			$data['tramite'] = $tramite;
			
			if(!$periodo){
				$select = array("CPEPeriodo","CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) as CPEFecha_inicio","CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin) as CPEFecha_fin");
				$this->db->where("CURDATE() BETWEEN CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) AND CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin)");
				$where = array('CPEStatus' => 1);
				$data_p = $this->periodos_model->find($where,$select);
				$periodo = $data_p['CPEPeriodo'];
			}else{
				$select = array("CPEPeriodo","CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) as CPEFecha_inicio","CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin) as CPEFecha_fin");
				$where = array('CPEStatus' => 1, 'CPEPeriodo' => $periodo);
				$data_p = $this->periodos_model->find($where,$select);
			}
				
			$data['periodo'] = $periodo;
			
			$zona = null;
			$plantel = $this->plantel_model->get($CPLClave);
			$data['CPLNombre'] = $plantel['CPLNombre'];
			$data['CPLClave'] = !$CPLClave_skip?'Todos':$plantel['CPLClave'];
			
			if( is_permitido(null,"fump","nivel_8") ){ // *
				$data['nivel'] = 8;
			}if( is_permitido(null,"fump","nivel_7") ){ // Nomina
				$data['nivel'] = 7;
			}elseif( is_permitido(null,"fump","nivel_6") ){ //Usuario-Plantel
				//$data['nivel'] = 6;
			}elseif( is_permitido(null,"fump","nivel_5") ){	//D.General
				$data['nivel'] = 5;
			}
			elseif( is_permitido(null,"fump","nivel_4") ){	//Finanzas
				$data['nivel'] = 4;
			}
			elseif( is_permitido(null,"fump","nivel_3") ){	//R.H
				$data['nivel'] = 3;
			}
			elseif( is_permitido(null,"fump","nivel_2") ){	//CVM/CVT
				$data['nivel'] = 2;
				if($plantel['CPLNombre'] == 'COORDINACIÓN DE ZONA VALLE DE TOLUCA'){
					$zona = " FCoordinacion = 'T' AND ";
				}
				elseif($plantel['CPLNombre'] == 'COORDINACIÓN DE ZONA VALLE DE MÉXICO'){
					$zona = " FCoordinacion = 'M' AND ";
				}
			}
			elseif( is_permitido(null,"fump","nivel_1") ){	//Enlace
				$data['nivel'] = 1;
			}
			
			//contar todos los registros sin limit
			$data['planteles'] = $this->plantel_model->find_all("CPLActivo = '1'");
			if( is_permitido(null,'personal','ver_todos') ){
			}elseif( is_permitido(null,'personal','ver_plantel') ){
				$data['planteles'] = $this->plantel_model->find_all("CPLClave IN(".get_session('UPlanteles').") and CPLActivo = '1'");
			}
			
			$where = array( "acceptTerms" => "on");
			
			if( is_permitido(null,"fump","nivel_8") ){
				$where = array();
				if($filtro=='Todos'){
				}
				if($filtro=='Rechazados'){
					$this->db->where("( acceptTerms IS NULL AND FAutorizo_1 IS NOT NULL)");
				}elseif($filtro=='Autorizados'){
					$this->db->where("( acceptTerms = 'on' AND FNivel_autorizacion >= 5 )");
				}elseif($filtro=='Todos'){
					$this->db->where("( (acceptTerms IS NULL AND FAutorizo_1 IS NOT NULL) OR (acceptTerms = 'on') )");
				}else{
					$this->db->where("( acceptTerms = 'on' AND FNivel_autorizacion <=7 )");
				}
			}else{
				$nivel = 0;
				if(! $data['nivel']){
					$data['nivel']= 1;
					$nivel = '1';
				}
				if($filtro=='Todos'){
					$this->db->where("$zona ((FNivel_autorizacion >= ".$data['nivel']." AND acceptTerms = 'on') OR (FNivel_autorizacion <= ".$data['nivel']." AND FAutorizo_".$data['nivel']." IS NOT NULL ))");
					$where = array();
				}elseif($filtro=='Rechazados'){
					$this->db->where("$zona FNivel_autorizacion<= ".$data['nivel']." and FAutorizo_".$data['nivel']." IS NOT NULL");
					$where = array();
				}elseif($filtro=='Autorizados'){
					$this->db->where("$zona FNivel_autorizacion > '".$data['nivel']."'");
				}else{
					if(!$nivel){
						$this->db->where("$zona FNivel_autorizacion = '".$data['nivel']."'");
					}else{
						$this->db->where("$zona FAutorizo_1 IS NOT NULL AND (acceptTerms IS NULL or FNivel_autorizacion = 6)");
						$where = array();
					}
				}
				if($nivel == '1') $data['nivel']=0;
			}
			if($CPLClave_skip or !$data['nivel'] or $data['nivel'] == 1 ){
				$this->db->where( 'FCPlantel', $CPLClave );
			}
			
			$CPEFecha_inicio = $data_p['CPEFecha_inicio'];
			$CPEFecha_fin = $data_p['CPEFecha_fin'];
			
			$this->db->where("FFecha_inicio BETWEEN '$CPEFecha_inicio' AND '$CPEFecha_fin'");
			
			$this->db->like( 'FTramite', $tramite );
			$this->db->where( "FActivo", 1);
			$this->db->order_by('FNivel_autorizacion ASC');
			$data['fump'] = $this->fump_model->find_all($where);

			$data['periodos'] = $this->periodos_model->find_all("CPEStatus = '1'",null,"CPEPeriodo DESC");
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'fump/Revisar_view';
			$this->load->view('plantilla_general', $data);
		}
		
		public function comentarios(){
			if(! $_POST)
				redirect( $this->router->fetch_class() );			
			$data= post_to_array('_skip');
			
			unset($data['FFinal']);
			
			$SEFump_skip = $this->input->post('SEFump_skip');
			$SEFump = $this->encrypt->decode($SEFump_skip);
			
			if(!$SEFump){
				set_mensaje("Los comentarios no se enviarón",'danger::');
				to_back(1);
				exit;
			}
			
			$data['SEFump'] = $SEFump;
			$data['SEUsuario_registro'] = get_session('UNCI_usuario');
			$this->seguimiento_model->insert($data);
			$nivel = $data['SENivel'];
			if($nivel-1){
				$data = array(
					"FAutorizo_$nivel" => null,//get_session('UNCI_usuario'),
					"FFecha_$nivel" => date('Y-m-d H:i:s')
				);
				
				$fump = $this->fump_model->get($SEFump);
				if($nivel==3 and strpos($fump['FNombre_plaza'],"DIRECTOR DE PLANTEL") !== 0 and $fump['FNombre_plaza'] != 'SECRETARIA DE DIRECTOR DE PLANTEL')
					$data['FNivel_autorizacion']=1;
			}else{
				$data = array(
							"acceptTerms" => null,
							"FAutorizo_$nivel" =>	get_session('UNCI_usuario'),
							"FFecha_$nivel" => date('Y-m-d H:i:s')
				);
			}
			$this->db->set("FNivel_autorizacion","$nivel-1",false);
			$this->fump_model->update($SEFump,$data);
			$SEFump = folio($SEFump);
			set_mensaje("Los comentarios para el fump con clave <b>[$SEFump]</b> se enviarón con éxito",'success::');
			to_back(2);
		}
		
		public function seguimiento($SEClave_skip = '', $SEApartado = ''){
			$SEClave = $this->encrypt->decode($SEClave_skip);
			if($SEClave){
				$data = array( $SEApartado => '***');
				$this->seguimiento_model->update($SEClave,$data);
			}
			to_back();
		}
		
		public function fump(){
			$FClave_skip = $this->input->post('FClave_skip');
			$FClave = $this->encrypt->decode($FClave_skip);
			$data= post_to_array('_skip');
			
			$this->_set_rules('f'); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				to_back(1);
			}else{
				$data['FNivel_autorizacion'] = 7;
				$data['FAutorizo_6'] = get_session('UNCI_usuario');
				$data['FFecha_6'] = date('Y-m-d H:i:s');
				
				$lista_archivos = array(
					'FFinal'
				);
				mover_archivos($data,$lista_archivos,null,"./documentos/$FClave/");
				
				$this->fump_model->update($FClave,$data);
				
				set_mensaje("El fump con clave <b>[".folio($FClave)."]</b> se envió con éxito",'success::');
				to_back(2);
			}
		}
		
		public function validar($FClave_skip='',$nivel_skip=''){
			$FClave = $this->encrypt->decode($FClave_skip);
			$nivel = $this->encrypt->decode($nivel_skip);
			
			$fump = $this->fump_model->get($FClave);
			
			if(!$FClave or !$nivel){
				$data= post_to_array('_skip');
				foreach($data as $clave => $nivel){
					
					$data = array(
						"FAutorizo_$nivel" =>	get_session('UNCI_usuario'),
						"FFecha_$nivel" => date('Y-m-d H:i:s')
					);
					
					if($nivel==5)
						$data['FFecha_elaboracion'] = date('Y-m-d');
					
					if($nivel==1 and strpos($fump['FNombre_plaza'],"DIRECTOR DE PLANTEL") !== TRUE){
					$this->db->set("FNivel_autorizacion","FNivel_autorizacion+2",false);
					}else{
						$this->db->set("FNivel_autorizacion","FNivel_autorizacion+1",false);
					}
					
					$this->fump_model->update($clave,$data);
					$FClave.=folio($clave).",";
				}
				set_mensaje("El fump con clave <b>[$FClave]</b> se valido con éxito",'success::');
				to_back();
			}else{
				
				
				$data = array(
					"FAutorizo_$nivel" =>	get_session('UNCI_usuario'),
					"FFecha_$nivel" => date('Y-m-d H:i:s')
				);
				
				if($nivel==5)
					$data['FFecha_elaboracion'] = date('Y-m-d');
				
				if($nivel==1 and strpos($fump['FNombre_plaza'],"DIRECTOR DE PLANTEL") !== 0){
					$this->db->set("FNivel_autorizacion","FNivel_autorizacion+2",false);
				}else{
					$this->db->set("FNivel_autorizacion","FNivel_autorizacion+1",false);
				}
				
				$this->fump_model->update($FClave,$data);
				$FClave=folio($FClave);
				set_mensaje("El fump con clave <b>[".folio($FClave)."]</b> se valido con éxito",'success::');
				to_back(2);
			}
		}
		
		public function rechazar($FClave_skip = null){
			$FClave = $this->encrypt->decode($FClave_skip);
			$data['FNivel_autorizacion'] = 6;
			$this->fump_model->update($FClave,$data);
			set_mensaje("El fump con clave <b>[".folio($FClave)."]</b> se rechazo con éxito",'success::');
			to_back(2);
		}
		
		function open(){
			$FClave_skip = $this->input->post('FClave_skip');
			$FClave = $this->encrypt->decode($FClave_skip);
			$data= post_to_array('_skip');
			$this->_set_rules('o'); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				to_back();
			}else{
				$data['FFecha_7'] = date('Y-m-d H:i:s');
				$data['FAutorizo_7'] = get_session('UNCI_usuario');
				$this->db->set("FNivel_autorizacion","FNivel_autorizacion+1",false);
				$this->fump_model->update($FClave,$data);
				
				$UClave = $data['FUsuario'];				
				$data = array('UOpen' => $data['FOpen'] );
				$this->usuario_model->update($UClave,$data);
				$FClave = folio($FClave);
				set_mensaje("El fump con clave <b>[$FClave]</b> se guardo con éxito",'success::');
				to_back(2);
			}
		}
		
		function numero(){
			$data= post_to_array('_skip');
			$UNCI_usuario_skip = $this->input->post('UNCI_usuario_skip');
			$UNCI_usuario = $this->encrypt->decode($UNCI_usuario_skip);
			$this->db->set("UFLote","UFLote+1",false);
			$this->usuario_model->update($UNCI_usuario,$data);
			set_mensaje("Los datos se guardaron con éxito",'success::');
			echo "OK";
		}
		
		function delete($FClave_skip= null){
			$FClave = $this->encrypt->decode($FClave_skip);
			$data = array(
				"FActivo" => '0',
				"FFecha_modificacion" => date('Y-m-d H:i:s'),
				"FUsuario_modificacion" => get_session('UNCI_usuario')
			);
			$data['fump'] = $this->fump_model->update($FClave,$data);
			$FClave = folio($FClave);
			set_mensaje("El fump con clave <b>[$FClave]</b> se elimino con éxito",'success::');
			to_back();
		}
		
		function alta($periodo = null,$excel = false){
			
			if(!$periodo){
				$select = array("CPEPeriodo","CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) as CPEFecha_inicio","CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin) as CPEFecha_fin");
				$this->db->where("CURDATE() BETWEEN CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) AND CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin)");
				$where = array('CPEStatus' => 1);
				$data_p = $this->periodos_model->find($where,$select);
				$periodo = $data_p['CPEPeriodo'];
			}else{
				$select = array("CPEPeriodo","CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) as CPEFecha_inicio","CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin) as CPEFecha_fin");
				$where = array('CPEStatus' => 1, 'CPEPeriodo' => $periodo);
				$data_p = $this->periodos_model->find($where,$select);
			}
			$data['periodo'] = $periodo;
			$CPEFecha_inicio = $data_p['CPEFecha_inicio'];
			$CPEFecha_fin = $data_p['CPEFecha_fin'];
			
			$this->db->where("FFecha_inicio BETWEEN '$CPEFecha_inicio' AND '$CPEFecha_fin'");			
			$this->db->where( "acceptTerms", 'on' );
			//$this->db->where( "FOpen", null );
			$this->db->where( "FNivel_autorizacion >=", '7' );
			$this->db->where( "FActivo", 1);
			$this->db->join("nousuario","UNCI_usuario = FUsuario","INNER");
			$data['fump'] = $this->fump_model->find_all();
			$data['periodos'] = $this->periodos_model->find_all("CPEStatus = '1'");
			
			if( !$excel ){
				$data['modulo'] = $this->router->fetch_method();
				$data['subvista'] = 'fump/Alta_view';			
				$this->load->view('plantilla_general', $data);
			}else{
				
				echo'<table cellspacing="0" cellpadding="0" border="1">';
				echo"<tr>";
				echo "<th>APELLIDO PATERNO</th>";
				echo "<th>APELLIDO MATERNO</th>";
				echo "<th>NOMBRE(S)</th>";
				echo "<th>FECHA DE NACIMIENTO</th>";
				echo "<th>R.F.C.</th>";
				echo "<th>CLAVE ELECTOR</th>";
				echo "<th>CLAVE ISSEMYM</th>";
				echo "<th>CURP</th>";
				echo "<th>DOMICILIO</th>";
				echo "<th>C.P</th>";
				echo "<th>COLONIA</th>";
				echo "<th>MUNICIPIO</th>";
				echo "<th>TEL. CASA</th>";
				echo "<th>TEL. MOVIL</th>";
				echo "<th>LUGAR DE NACIMIENTO</th>";
				echo "<th>ESTADO CIVIL</th>";
				echo "<th>TRAMITE</th>";
				echo "<th>TIPO DE PLAZA</th>";
				echo "<th>NOMBRE DE LA PLAZA</th>";
				echo "<th>DIRECCION DE AREA / PLANTEL / EMSAD </th>";
				echo "<th>DEPARTAMENTO</th>";
				echo "<th>VIGENCIA</th>";
				echo "<th>TIPO DE HORAS-CLASE</th>";
				echo "<th>No. DE HORAS-CLASE TOTALES</th>";
				echo "<th>SINDICALIZADO</th>";
				echo "<th>CAMBIO DE ASDCRIPCION DE</th>";
				echo "<th>CAMBIO DE ASDCRIPCION A</th>";
				echo "<th>PLAZA ANTERIOR</th>";
				echo "<th>PLAZA ACTUAL</th>";
				echo"</tr>";
				
				foreach($data['fump'] as $key => $list){
				echo"<tr>";
				echo"<td>".$list['FApellido_pat']."</td>";
				echo"<td>".$list['FApellido_mat']."</td>";
				echo"<td>".$list['FNombre']."</td>";
				echo"<td>".fecha_format($list['FFecha_nacimiento'])."</td>";
				echo"<td>".$list['FRFC']."</td>";
				echo"<td>".$list['UClave_elector']."</td>";
				echo"<td>".$list['FISSEMYM']."</td>";
				echo"<td>".$list['FCURP']."</td>";
				echo"<td>".$list['FDomicilio']."</td>";
				echo"<td>".$list['FCP']."</td>";
				echo"<td>".$list['FColonia']."</td>";
				echo"<td>".$list['FMunicipio']."</td>";
				echo"<td>".$list['FTelefono_casa']."</td>";
				echo"<td>".$list['FTelefono_movil']."</td>";
				echo"<td>".$list['FLugar_nacimiento']."</td>";
				echo"<td>".$list['FEstado_civil']."</td>";
				echo"<td>".$list['FTramite']."</td>";
				echo"<td>".$list['FTipo_plaza']."</td>";
				echo"<td>".$list['FNombre_plaza']."</td>";
				echo"<td>".$list['FPlantel']."</td>";
				echo"<td>".$list['FDepartamento']."</td>";
				echo"<td>".fecha_format($list['FFecha_inicio'])." - ".fecha_format($list['FFecha_termino'])."</td>";
				echo"<td>".$list['FTipo_horas_clase']."</td>";
				echo"<td>".$list['FHoras_clase_totales']."</td>";
				echo"<td>".$list['FSindicalizado']."</td>";
				echo"<td>".$list['FCambio_adscripcion_de']."</td>";
				echo"<td>".$list['FCambio_adscripcion_a']."</td>";
				echo"<td>".$list['FPlaza_anterior']."</td>";
				echo"<td>".$list['FPlaza_actual']."</td>";
				echo"</tr>";
				}
				echo"</table>";
				
				$fecha = date('d-m-Y');
				
				/* $titulos = array('Oficina','Usuario','Referencia','Servicio',
				'Importe Servicio','Curp Alumno','Nombre Alumno','Captación','Estatus','Fecha Pago','Plantel','Materias','Cancelado','Fecha de Cancelación');
				
				for($i=0;$i<=20;$i++){
					$datosExcel[] = array(
						"oficina" => "algo $i",
						"usuario" => "algo $i",
						"referencia" => "algo $i",
						"concepto" => "algo $i",
						"total" => "algo $i",
						"curpAlumno" => "algo $i",
						"nombreAlumno" => "algo $i",
						"sucursal" => "algo $i",
						"estatus" => "algo $i",
						"fechaPago" => "algo $i",
						"plantel" => "algo $i",
						"materias" => "algo $i",
						"cancelado" => "algo $i",
						"canfecha" => "algo $i"
					);
				}
				
				excelheaders('Consulta_Folios_'.date('Ymd_Hi'));
				
				// Creamos un nuevo objeto
				$objPHPExcel = new PHPExcel();

				// Propiedades de Documento
				$objPHPExcel->getProperties()
				->setCreator('SIM')
				->setLastModifiedBy('SIMI')
				->setTitle("Alta Nomina");

				// Datos
				$objPHPExcel->getActiveSheet()
				->setTitle('Fecha df')
				->fromArray($titulos)
				->fromArray($datosExcel, null, 'A2')
				->setAutoFilter('A1:N1');


				// Color
				$objPHPExcel->getActiveSheet()
				->getStyle('A1:N1')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setARGB('FF808080');

				// Hoja activa
				$objPHPExcel->setActiveSheetIndex(0);

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output'); 
				exit;*/
			}
		}
		
		function _set_rules($c='',$data = array()){
			
			if($c=='u'){	
				if(!nvl($data['FTramite'])) $data['FTramite'] = array();
				$this->form_validation->set_rules('FPlantel', 'Plantel', "trim|required|min_length[5]|max_length[255]");
				$this->form_validation->set_rules('FDepartamento', 'Departamento', "trim|required|min_length[5]|max_length[255]");
				$this->form_validation->set_rules('FCorreo_electronico_plantel', 'Correo electr&oacute;nico', "trim|required|min_length[5]|max_length[255]|valid_email");
				$this->form_validation->set_rules('FNombre', 'Nombre', "trim|required|min_length[3]|max_length[255]");
				$this->form_validation->set_rules('FISSEMYM', 'ISSEMYM', "trim|max_length[60]");
				$rango_fecha = date('d/m/Y', strtotime('-100 year')) . "," . date('d/m/Y', strtotime('-18 year'));
				$this->form_validation->set_rules('FFecha_nacimiento', 'Fecha nacimiento', "trim|required|max_length[10]|valida_fecha[$rango_fecha]");
				$this->form_validation->set_rules('FRFC', 'RFC', "trim|required|min_length[13]|max_length[13]|valida_rfc");
				$this->form_validation->set_rules('FCURP', 'CURP', "trim|required|min_length[18]|max_length[18]|valida_curp");
				
				$config = $this->config_model->get(1);
				
				$rango_i = explode('|',$config['CORango_fechas_i']);
				$rango_f = explode('|',$config['CORango_fechas_f']);
				
				$rango_fechas_i = date('d/m/Y',strtotime(@$rango_i[0]) ) . "," . date('d/m/Y', strtotime(@$rango_i[1]));
				$rango_fechas_f = date('d/m/Y',strtotime(@$rango_f[0]) ) . "," . date('d/m/Y', strtotime(@$rango_f[1]));				
				$this->form_validation->set_rules('FFecha_inicio', 'vigencia inicial', "trim|exact_length[10]|valida_fecha[$rango_fechas_i]");
				$this->form_validation->set_rules('FFecha_termino', 'vigencia final', "trim|exact_length[10]|valida_fecha[$rango_fechas_f]");
				
				if($data['FProtesta']=='SI'){
					$this->form_validation->set_rules('FProtesta_file', 'Documento Oficial de Relación Laboral', "trim|required|min_length[1]|max_length[254]");
				}
				if(!$this->input->post('documentos_skip')){
					if(in_array("ALTA", $data['FTramite'])){
						$this->form_validation->set_rules('FNombramiento_file', 'de archivo Nombramiento', "trim|min_length[1]|max_length[254]");
						$this->form_validation->set_rules('FConstancia_inhabilitacion_file', 'de archivo Costancia de inhabilitación', "trim|required|min_length[1]|max_length[254]");
						$this->form_validation->set_rules('FAntecedentes_penales_file', 'de archivo Antecedentes no penales', "trim|required|min_length[1]|max_length[254]");
						$this->form_validation->set_rules('DPRFC', 'de archivo RFC', "trim|required|min_length[1]|max_length[254]");
						$this->form_validation->set_rules('DPCURP', 'de archivo CURP', "trim|required|min_length[1]|max_length[254]");
						$this->form_validation->set_rules('DPCredencial_elector', 'de archivo Credencial de elector', "trim|required|min_length[1]|max_length[254]");
						$this->form_validation->set_rules('DPCertificado_estudios', 'de archivo Certificado de estudios', "trim|required|min_length[1]|max_length[254]");
						if($data['FISSEMYM']){
							$this->form_validation->set_rules('DPMov_ISSEMYM', 'de archivo ISSEMYM', "trim|required|min_length[1]|max_length[254]");
						}
						$this->form_validation->set_rules('FEmpleo_anterior_file', 'de archivo Formato de empleo anterior', "trim|required|min_length[1]|max_length[254]");
					}
					if(in_array("BAJA", $data['FTramite'])){
						if(nvl($data['FDatos_baja'])== "RENUNCIA"){
							$this->form_validation->set_rules('FRenuncia_file', 'de archivo Renuncia', "trim|required|min_length[1]|max_length[254]");
						}
						if(nvl($data['FDatos_baja'])== "FALLECIMIENTO"){
							$this->form_validation->set_rules('FActa_defuncion_file', 'de archivo Acta de defunción', "trim|required|min_length[1]|max_length[254]");
						}
						if(nvl($data['FDatos_baja'])== "RESCISIÓN"){
							$this->form_validation->set_rules('FRescision_file', 'de archivo Acta de rescicion laboral', "trim|required|min_length[1]|max_length[254]");
						}
						if(nvl($data['FDatos_baja'])== "OTRO"){
							$this->form_validation->set_rules('FResolucion_file', 'de archivo Oficio de resolución por la contraloría', "trim|required|min_length[1]|max_length[254]");
						}
						if(nvl($data['FDatos_baja'])== "INHABILITACIÓN MÉDICA"){
							$this->form_validation->set_rules('FInhabilitacion_file', 'de archivo Dictamen de inhabilitación medica', "trim|required|min_length[1]|max_length[254]");
						}
						if(nvl($data['FDatos_baja'])== "JUBILACIÓN"){
							$this->form_validation->set_rules('FJubilacion_file', 'de archivo Dictamen de jubilación', "trim|required|min_length[1]|max_length[254]");
						}
					}
					if(in_array("LICENCIA SIN GOCE DE SUELDO", $data['FTramite'])){
						$this->form_validation->set_rules('FAutorizacion_licencia_file', 'de archivo Oficio de autorización', "trim|required|min_length[1]|max_length[254]");
					}
					if(in_array("INCREMENTO/DISMINUCIÓN DE HRS. CLASE", $data['FTramite'])){
						$this->form_validation->set_rules('FAutorizacion_incremento_file', 'de archivo Oficio de autorización', "trim|required|min_length[1]|max_length[254]");
					}
					if( in_array("OTRO", $data['FTramite']) or in_array("CAMBIO DE PLAZA", $data['FTramite']) or in_array("CAMBIO DE ADSCRIPCIÓN", $data['FTramite']) ){
						$this->form_validation->set_rules('FOtro_file', 'de archivo Oficio', "trim|required|min_length[1]|max_length[254]");
					}
				}
			}elseif($c=='ac') {
				$where =" UNCI_usuario != ".get_session('UNCI_usuario');
				$this->form_validation->set_rules('UNombre', 'Nombre', "trim|required|min_length[3]|max_length[255]|unique[nousuario,UNombre,$where]");
				$this->form_validation->set_rules('UCorreo_electronico', 'Correo electr&oacute;nico', "trim|required|max_length[60]|valid_email|unique[nousuario,UCorreo_electronico,$where]");
				$this->form_validation->set_rules('UTelefono', 'Teléfono', 'trim|required|min_length[10]|max_length[20]');
			}elseif($c=='f') {
				$this->form_validation->set_rules('FFinal', 'FUMP', "trim|required|min_length[10]|max_length[255]");
			}elseif($c=='o') {
				$this->form_validation->set_rules('FOpen', 'Clave OPEN', "trim|required|min_length[1]|max_length[11]");
			}
			// fin de la funcion _set_rules
		}
		
	}