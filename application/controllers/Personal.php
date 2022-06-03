<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Personal extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso');
		}
		
		public function index($limit = null, $start = null, $search = null ){
			$search = base64_decode($search);
			$data['limit'] = $limit?$limit:null;
			$data['start'] = $start?$start:null;
			$data['search'] = $search?$search:null;
			
			if($_POST)	$data = post_to_array('_skip');
			
			if(! nvl($data['limit']) ) $data['limit'] = 20;
			if(! nvl($data['start']) or nvl($data['search']) ) $data['start'] = 0;
			if(! nvl($data['search'])) $data['search'] = null;
			if( is_permitido(null,'personal','ver_plantel') and !is_permitido(null,'fump','nivel_1') ){
				$PRol = get_session('URol');
				$URol = get_session('URol')+1;
				$this->db->where("CROClave IN ('$PRol','$URol')");
			}
			$data['rol'] = $this->rol_model->find_all();
			
			//busqueda con limit
			if( is_permitido(null,'personal','ver_todos') ) {
				
			}else if( is_permitido(null,'personal','ver_plantel') ){
				if(! is_permitido(null,'fump','nivel_1')){
					$this->db->where("CROClave NOT IN ('3','10','12')");	
				}			
				$this->db->where( "FIND_IN_SET( '".get_session('UPlantel')."',UPlantel)" );
				
			}else{
				$this->db->where('UNCI_usuario',get_session('UNCI_usuario'));
			} 	
				
			if($data['search'])
				$this->db->where("( 
									UClave_servidor like ('%".$data['search']."%') 
									or UClave_servidor_centro like ('%".$data['search']."%') 
								    or CONCAT( UNombre, ' ', UApellido_pat, ' ', UApellido_mat) like ('%".$data['search']."%')
									or UCorreo_electronico like ('%".$data['search']."%')
									or CPLNombre like ('%".$data['search']."%')
							)");
			$this->db->join('noplanteles','UPlantel = CPLClave','INNER');
			$this->db->join('nocrol','URol = CROClave','INNER');
			$this->db->limit($data['limit'], $data['start']);
			$this->db->order_by('UNCI_usuario ASC');
            $data["personal"] = $this->usuario_model->find_all();
			
			//contar todos los registros sin limit
			if( is_permitido(null,'personal','ver_todos') ) {
				
			}else if( is_permitido(null,'personal','ver_plantel') ){ 
				if(! is_permitido(null,'fump','nivel_1')){
					$this->db->where("CROClave NOT IN ('3','10','12')");	
				}
				$this->db->where( "FIND_IN_SET( '".get_session('UPlantel')."',UPlantel)" );
			}else{
				$this->db->where('UNCI_usuario',get_session('UNCI_usuario'));
			}
			
			if($data['search'])
				$this->db->where("( 
									UClave_servidor like ('%".$data['search']."%') 
									or UClave_servidor_centro like ('%".$data['search']."%') 
								    or CONCAT( UNombre, ' ', UApellido_pat, ' ', UApellido_mat) like ('%".$data['search']."%')
									or UCorreo_electronico like ('%".$data['search']."%')
									or CPLNombre like ('%".$data['search']."%')
							)");
			$this->db->join('noplanteles','UPlantel = CPLClave','INNER');
			$this->db->join('nocrol','URol = CROClave','INNER');
            $data["total"] = $this->usuario_model->find_all();
			$data["total"] = count($data["total"]); 
			
			$data['estado_civil'] = $this->estciv_model->find_all();

			$this->db->order_by('CPLNombre');
			$data["planteles"] = $this->plantel_model->find_all();
			
			$data["config"] = $this->config_model->find();
			
			$data["plantel"] = $this->plantel_model->get( get_session('UPlantel') );
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'personal/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function save(){
			if(! $_POST)
				redirect( $this->router->fetch_class() );
				
			$data= post_to_array('_skip');	
			if( nvl($data['UClave_servidor']) ){
				$_POST['UClave_servidor'] = folio( $data['UClave_servidor'] );
				$data['UClave_servidor'] = folio( $data['UClave_servidor'] );
			}
			if( nvl($data['UClave_servidor_centro']) ){
				$_POST['UClave_servidor_centro'] = folio( $data['UClave_servidor_centro'] );
				$data['UClave_servidor_centro'] = folio( $data['UClave_servidor_centro'] );
			}
		
			$this->_set_rules('u',$data); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				muestra_mensaje();
			}else{
				$UNCI_usuario_skip=$this->input->post('UNCI_usuario_skip');
				$UNCI_usuario=$this->encrypt->decode($UNCI_usuario_skip);

				if( @$data['UPlantel'] )
				$data['UPlantel'] = implode(",",$data['UPlantel']);
			    $data['UPlantel_d'] = @number_format($data['UPlantel']);
				$data['UFecha_nacimiento'] = fecha_format( $data['UFecha_nacimiento'] );
				
				if(! $UNCI_usuario){
					if(! is_permitido(null,'personal','ver_todos') ){
						$data['UEstado'] = 'Activo';
					}
					
					$data['UUsuario_registro']=get_session('UNCI_usuario');
					$data['UFecha_registro']=date('Y-m-d H:i:s');
					$data['UContrasena']= doHash( '00000000', $data['UCorreo_electronico'] );
					$UNCI_usuario = $this->usuario_model->insert($data);
					set_mensaje("El Usuario con clave [<b> ".$data['UClave_servidor'].$data['UClave_servidor_centro']." </b>] se agrego con éxito",'success::');
				}else{				
					$data['UUsuario_modificacion']=get_session('UNCI_usuario');
					$data['UFecha_modificacion']=date('Y-m-d H:i:s');
					$this->usuario_model->update($UNCI_usuario,$data);
					set_mensaje("El Usuario con clave [<b> ".$data['UClave_servidor'].$data['UClave_servidor_centro']." </b>] se actualizó con éxito",'success::');
				}
				echo "OK";
			}
		
		}
		
		public function delete($UNCI_usuario_skip){
			$UNCI_usuario = $this->encrypt->decode( $UNCI_usuario_skip );			
			$data = array("UEstado" => 'Inactivo' );
			$this->usuario_model->update($UNCI_usuario, $data);
			//$this->usuario_model->delete($UNCI_usuario);
			set_mensaje("El Usuario con clave [$UNCI_usuario] se borro con éxito",'success::');
			to_back();
		}
		
		public function actualizar(){
			$data = post_to_array('_skip');
			
			$this->_set_rules('ac'); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				muestra_mensaje();
			}else{
				$UContrasena = $this->input->post('UContrasena_a_skip');
				$UContrasena_n = $this->input->post('UContrasena_n_skip');
				if($data['UCorreo_electronico'] != get_session('UCorreo_electronico'))
					if(!$UContrasena){		
						set_mensaje("Al cambiar de correo, es necesario cambiar la contraseña","danger::");	
						muestra_mensaje();
						exit;
					}
					
					if($UContrasena || $UContrasena_n){
						$where = array
						(
						'UCorreo_electronico' => get_session('UCorreo_electronico'), 
						'UContrasena'         => doHash( $UContrasena, get_session('UCorreo_electronico') )              
						);
						if(!$this->usuario_model->find($where)){
							set_mensaje("La contraseña anterior no es correcta","danger::");
							muestra_mensaje();
							exit;
						}else{
							$this->_set_rules('cp'); //validamos los datos - cambiar password
							if($this->form_validation->run() === FALSE)
							{
								set_mensaje(validation_errors());
								muestra_mensaje();
								exit;
							}{
								$UContrasena = $this->input->post('UContrasena_n_skip');
								$data['UContrasena'] = doHash( $UContrasena, $data['UCorreo_electronico'] );
								echo "OK";
							}
						}
					}
					
				if(nvl($data['UFoto']) || nvl($data['UFondo'])){
					$lista_archivos = array('UFoto','UFondo');
					mover_archivos($data,$lista_archivos,null,'./fotos/',true,false); 	
				}
				
				set_session( 'UFoto', nvl($data['UFoto']) );
				set_session( 'UFondo', nvl($data['UFondo']) );
				set_session( 'UTelefono_movil', nvl($data['UTelefono_movil']) );
			
				$this->usuario_model->update(get_session('UNCI_usuario'),$data);
				set_mensaje("Tus datos se actualizarón con éxito",'success::');
				echo "OK";
			}
		}
		
		function ver_curp(){
			$curp =  new Curp;
			
			$micurp = $this->input->post('UCURP');
			$curp->setMicurp($micurp);
			
			$result = $curp->getCurp(0);
			if(nvl($result['error'])==0){
				echo "OK|";
				echo $result['apellido1']."|";
				echo $result['apellido2']."|";
				echo $result['nombres']."|";
				echo $result['fechanac']."|";
				echo $result['sexo']."|";
			}
			else{
				echo nvl($result['tipo']);
			}
		}
		
		
		function _set_rules($c='', $data = array()){
			
			if($c=='u'){
				$UNCI_usuario_skip=$this->input->post('UNCI_usuario_skip');
				$UNCI_usuario=$this->encrypt->decode($UNCI_usuario_skip);
				
				$where = "1=1";
				if($UNCI_usuario)
					$where =" UNCI_usuario != $UNCI_usuario"; 
				
				$rango_fechas = date('d/m/Y',strtotime('-100 year') ) . "," . date('d/m/Y', strtotime('+0 year'));

				$this->form_validation->set_rules('UClave_servidor', 'Clave Servidor <small>Plantel</small>', "trim|min_length[2]|max_length[5]|unique[nousuario,UClave_servidor,$where]|numeric");
				$this->form_validation->set_rules('UClave_servidor_centro', 'Clave Servidor <small>CEMSAD</small>', "trim|min_length[2]|max_length[5]|unique[nousuario,UClave_servidor_centro,$where]|numeric");
				$this->form_validation->set_rules('UNombre', 'Nombre', "trim|required|min_length[3]|max_length[255]");
				$this->form_validation->set_rules('UISSEMYM', 'ISSEMYM', "trim|min_length[2]|max_length[10]|unique[nousuario,UISSEMYM,$where]");
				$this->form_validation->set_rules('UFecha_nacimiento', 'Fecha de Nacimiento', "trim|required|max_length[10]|valida_fecha[$rango_fechas]");
				$this->form_validation->set_rules('URFC', 'RFC', "trim|required|exact_length[13]|unique[nousuario,URFC,$where]");
				$this->form_validation->set_rules('UCURP', 'CURP', "trim|required|exact_length[18]|unique[nousuario,UCURP,$where]");
				$this->form_validation->set_rules('UClave_elector', 'Clave de elector', "trim|required|exact_length[18]|unique[nousuario,UClave_elector,$where]");
				$this->form_validation->set_rules('UDomicilio', 'Domicilio', "trim|required|min_length[5]|max_length[255]");
				$this->form_validation->set_rules('UColonia', 'Colonia', "trim|required|min_length[5]|max_length[255]");
				$this->form_validation->set_rules('UMunicipio', 'Municipio', "trim|required|min_length[5]|max_length[255]");
				$this->form_validation->set_rules('UCP', 'Codigo Postal', "trim|required|min_length[5]|max_length[5]|numeric");
				$this->form_validation->set_rules('UTelefono_movil', 'Teléfono Movil', "trim|min_length[10]|max_length[15]|numeric");
				$this->form_validation->set_rules('UTelefono_casa', 'Teléfono Casa', "trim|min_length[7]|max_length[15]|numeric");
				$this->form_validation->set_rules('UCorreo_electronico', 'Correo electr&oacute;nico', "trim|required|max_length[60]|valid_email|unique[nousuario,UCorreo_electronico,$where]");
				$this->form_validation->set_rules('URed_social', 'Red social', "trim|required|min_length[5]|max_length[60]");
				$this->form_validation->set_rules('ULugar_nacimiento', 'Lugar de nacimiento', "trim|required|min_length[5]|max_length[60]");
				$this->form_validation->set_rules('UEstado_civil', 'Estado cibil', "trim|required|min_length[5]|max_length[60]");
				$this->form_validation->set_rules('USexo', 'Sexo', "trim|required|min_length[5]|max_length[6]");
				$this->form_validation->set_rules('UHijos', 'Hijos', "trim|required|min_length[1]|max_length[2]");
				if(! $UNCI_usuario )
					$this->form_validation->set_rules('UPlantel[]', 'Plantel', "trim|required|max_length[10]");
				//$this->form_validation->set_rules('URol', 'Rol', "trim|required|max_length[10]");
				$this->form_validation->set_rules('UEstado', 'Estado', "trim|required|min_length[6]|max_length[8]");
			}elseif($c=='ac') {
				$where =" UNCI_usuario != ".get_session('UNCI_usuario');
				//$this->form_validation->set_rules('UNombre', 'Nombre', "trim|required|min_length[3]|max_length[255]|unique[nousuario,UNombre,$where]");
				$this->form_validation->set_rules('UCorreo_electronico', 'Correo electr&oacute;nico', "trim|required|max_length[60]|valid_email|unique[nousuario,UCorreo_electronico,$where]");
				$this->form_validation->set_rules('UTelefono_movil', 'Teléfono', 'trim|required|min_length[10]|max_length[20]');
			}
			elseif($c=='cp') {
				$this->form_validation->set_rules('UContrasena_n_skip', 'Contrase&ntilde;a Nueva', 'trim|required|min_length[8]|max_length[30]|password_strength_checker');
			}
			// fin de la funcion _set_rules
		}
		
	}