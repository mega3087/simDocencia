<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cambiar extends CI_Controller {
public function  __construct()
		{
			parent::__construct();
			
			set_session('modulo', $this->router->fetch_class());
			
			if ( ! is_login() )
				redirect('login'); // Verificamos que el usuario este logeado
			
			if( ! is_permitido(get_session('OldRol')) )
				redirect('usuario/negar_acceso'); // Verificamos que el usuario tenga el permiso
			
		} //fin del constructor
		
	public function index(){
		$this->db->where( "CPLClave IN(".get_session('UPlanteles').") and CPLActivo = '1'");
		$data['planteles'] = $this->plantel_model->find_all();
		
		$data['title'] = 'Cambiar';
		$data['modulo'] = $this->router->fetch_class();
		$data['subvista'] = "cambiar/Mostrar_view";
		$this->load->view('plantilla_general',$data);
	}
	
	public function save_clave(){
		if(! $_POST)
			redirect( $this->router->fetch_class() );		
		$data= post_to_array('_skip');

		$this->_set_rules('s'); //validamos los datos
		if($this->form_validation->run() === FALSE)
		{
			set_mensaje(validation_errors());
			muestra_mensaje();
		}else{
			$UClave = folio($data['UClave_servidor']);
			$where = "(UClave_servidor = $UClave or UClave_servidor_centro = $UClave)";
			$this->db->where("UEstado",'Activo');
			$data = $this->usuario_model->find( $where );
			if($data){
				//Guardamos los datos del usuario en la variable de sesión
				$URol = get_session('URol');
				
				if( ! isset($_SESSION) )
					session_start();
				if( ! get_session('OldRol') )
					set_session( 'OldRol', $URol );
				set_session('refresh',false);
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
				set_mensaje("El cambio a <b>".$data['UNombre']." ".$data['UApellido_pat']." ".$data['UApellido_mat']."</b> se realizo con exito!!",'success::');
				echo "OK";
			}else{
				set_mensaje("No se realizo la acción!!!");
				muestra_mensaje();
			}
		}
	}
	
	public function save_plantel(){
		if(! $_POST)
			redirect( $this->router->fetch_class() );		
		$data= post_to_array('_skip');

		$this->_set_rules('p'); //validamos los datos
		if($this->form_validation->run() === FALSE)
		{
			set_mensaje(validation_errors());
			muestra_mensaje();
		}else{
			//Actualizamos plantel default
			$UClave = get_session('UNCI_usuario');
			$this->usuario_model->update( $UClave, array('UPlantel_d' => $data['UPlantel']) );
			
			//Guardamos los datos del usuario en la variable de sesión del plantel actual
			set_session( 'UPlantel', $data['UPlantel'] );
			set_mensaje("El cambio de plantel se realizo con exito!!",'success::');
			echo "OK";
		}
	}
	
	function _set_rules($op='s'){
		if($op=='s'){
			$this->form_validation->set_rules('UClave_servidor', 'Clave de Servidor', "trim|required|min_length[1]|max_length[5]|numeric");
		}
		if($op=='p'){
			$this->form_validation->set_rules('UPlantel', 'plantel', "trim|required|min_length[1]|max_length[20]");
		}
		// fin de la funcion _set_rules
	}
	
}
