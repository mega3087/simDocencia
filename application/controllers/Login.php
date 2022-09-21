<?php
	class Login extends CI_Controller 
	{	
		
		public function __construct()
		{
			parent::__construct();	
		} //fin del constructor    
		
		function index(  )
		{
			//Si hay una session redirige al dashboard
			if ( is_login('dashboard') ){
				set_mensaje( "Para ingresar con otro usuario, favor de cerrar sesión" );
				redirect(base_url('dashboard'));
			}
			
			$data=array();
			$this->load->view( 'login_view', $data );
		} //fin de la funcion index 
		
		function validar()
		{
			$data = array(); 
			
			if( ! $_POST )
			redirect( $this->router->fetch_class() );
			
			$this->_set_rules();
			if( $this->form_validation->run() === FALSE) 
			{
				$data = post_to_array();
				set_mensaje(validation_errors());
				set_session("error",true);
				redirect('login');          
			}
			else
			{
				$this->logout(''); // Eliminamos cualquier otra sesion anterior
				if( ! isset($_SESSION) )
				session_start();
				
				// Obtenemos los datos del usuario; dejandolas en variables de session para su uso global en el sistema
				$correo_electronico = $this->input->post('UCorreo_electronico');
				$contrasena = $this->input->post('UContrasena');
				$data= array();
				
				$select = "UCorreo_electronico";
				$where = "(UCorreo_electronico = '$correo_electronico' or UTelefono_movil = '$correo_electronico')";
				$data_u = $this->usuario_model->find( $where, $select );
				if($data_u){
					$contrasena = doHash( $contrasena, $data_u['UCorreo_electronico'] );				
					$where = array(
					'UCorreo_electronico' => $data_u['UCorreo_electronico'],
					'UContrasena'         => $contrasena
					);
					$data = $this->usuario_model->find( $where );
				}
				if($data){
					//Guardamos los datos del usuario en la variable de sesión
					set_session('error',false);
					set_session('refresh',true);
					set_session( 'URol', $data['URol'] );
					set_session( 'UNCI_usuario', $data['UNCI_usuario'] );
					set_session( 'UContrasena', $data['UContrasena'] );
					set_session( 'UNombre', $data['UNombre']." ".$data['UApellido_pat']." ".$data['UApellido_mat'] );
					set_session( 'UClave_servidor', $data['UClave_servidor'] );
					set_session( 'UClave_servidor_centro', $data['UClave_servidor_centro'] );
					set_session( 'UCorreo_electronico', $data['UCorreo_electronico'] );
					set_session( 'UPlanteles', $data['UPlantel'] );
					set_session( 'UPlantel', $data['UPlantel_d'] );
					set_session( 'UFoto', $data['UFoto'] );
					set_session( 'UFondo', $data['UFondo'] );
					set_session( 'UTelefono_movil', $data['UTelefono_movil'] );
					
					// Actualizamos el ultimo acceso del usuario
					$datos_acceso['UUltimo_acceso'] = date("Y-m-d H:i:s");
					$this->usuario_model->update( $data['UNCI_usuario'], $datos_acceso );
					set_session('mensaje', '');
					set_session( 'SESSION_SCN','-1');
					redirect('dashboard');   
				}else{
					set_mensaje("El usuario o contrase&ntilde;a no son v&aacute;lidos, verifiquelos");
					redirect('login');
				}
				
			}
		} //fin de la funcion ingresar 
		
		function logout($redirect = 'login') 
		{
			// Eliminamos las variables de sesion del Sistema actual, no de otros sistemas
			foreach(array_keys($_SESSION) as $key)
			{
				if (strpos($key, PREFIJO_DB) > -1)  // El prefijo esta al inicio strpos = 0,1,2,3
				unset($_SESSION[$key]);
			}
			
			if ($redirect != '') 
			{
				$redirect = $this->security->xss_clean($redirect);
				redirect($redirect);
			}
		}
		
		function _set_rules() 
		{
			$this->form_validation->set_rules('UCorreo_electronico', 'Usuario', 'trim|required|min_length[5]|max_length[60]');
			$this->form_validation->set_rules('UContrasena', 'Contrase&ntilde;a', 'trim|required|min_length[8]|max_length[30]|callback__credenciales_validas');        
		} // fin de la funcion _set_rules
		
		function _credenciales_validas() 
		{
			sleep(2); // hacemos una demora para complicar los ataques de fuerza bruta
			// Verificamos que el usuario este registrados con las credenciales digitadas
			$correo_electronico = $this->input->post('UCorreo_electronico');
			$contrasena = $this->input->post('UContrasena');  
			
			// Verificamos la recepción de ambos parametros Usuario y contraseña
			if($correo_electronico == '' OR $contrasena == '') 
			{
				$this->form_validation->set_message('_credenciales_validas', 'Digite su usuario y contrase&ntilde;a');
				RETURN FALSE;
			}			
			// Obtenemos los datos del usuario; dejandolas en variables de session para su uso global en el sistema
			$data= array();	
			$select = "UCorreo_electronico";
			$where = "(UClave_servidor = '$correo_electronico' or UClave_servidor_centro = '$correo_electronico' or UTelefono_movil = '$correo_electronico' or UCorreo_electronico = '$correo_electronico')";
			$data_u = $this->usuario_model->find( $where, $select );
			if($data_u){
				$contrasena = doHash( $contrasena, $data_u['UCorreo_electronico'] );				
				$where = array(
				'UCorreo_electronico' => $data_u['UCorreo_electronico'],
				'UContrasena'         => $contrasena
				);
				$data = $this->usuario_model->find( $where );
			}	
			if( ! $data ) 
			{       
				$this->form_validation->set_message('_credenciales_validas', 'El usuario o contrase&ntilde;a no son v&aacute;lidos, verifiquelos');
				RETURN FALSE;
			}
			
			if( $data['UEstado'] == 'Inactivo' ) 
			{
				$this->form_validation->set_message('_credenciales_validas', 'El usuario ha sido dado de baja o no ha sido activado');
				RETURN FALSE;
			}
			
			RETURN TRUE;
		} // fin de la funcion _credenciales_validas 
		
	} //fin del controlador Login
?>
