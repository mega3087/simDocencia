<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Autoridad extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso');
		}
		
		public function index(){
			
			$data = array();
			$data["firmante"] = $this->firmante_model->find_all();
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'autoridad/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function save(){
			if(! $_POST)
				redirect( $this->router->fetch_class() );
				
			$data= post_to_array('_skip');
			$this->_set_rules('p',$data); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				muestra_mensaje();
			}else{
				$FIClave_skip=$this->input->post('FIClave_skip');
				$FIClave=$this->encrypt->decode($FIClave_skip);
				
				if(! $FIClave){
					$data['FIUsuario_registro']=get_session('UNCI_usuario');
					$data['FIFecha_registro']=date('Y-m-d H:i:s');
					$FIClave = $this->firmante_model->insert($data);
					set_mensaje("La autoridad con clave [<b> $FIClave </b>] se registro con éxito",'success::');
				}else{				
					$data['FIUsuario_modificacion']=get_session('UNCI_usuario');
					$data['FIFecha_modificacion']=date('Y-m-d H:i:s');
					$this->firmante_model->update($FIClave,$data);
					set_mensaje("La autoridad con clave [<b> $FIClave </b>] se actualizó con éxito",'success::');
				}
				echo "OK";
			}
		
		}
		
		
		function _set_rules($c='',$data = array()){
			
			if($c=='p'){
				$this->form_validation->set_rules('FINombre', 'Nombre', "trim|required|min_length[8]|max_length[255]");
				$this->form_validation->set_rules('FICargo', 'Cargo', "trim|required|min_length[8]|max_length[255]");
			}
			// fin de la funcion _set_rules
		}
		
	}