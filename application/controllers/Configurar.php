<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Configurar extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso');
		}
		
		public function index(){
			
			$data = $this->config_model->find();
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'configurar/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function save(){
			if(! $_POST){
				set_mensaje("Los cambios no se han realizado",'danger::');
				exit();
			}
				
			$data= post_to_array('_skip');	
			
			$this->_set_rules('u',$data); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				muestra_mensaje();
			}else{
				$data['COUsuario_modificacion'] = get_session('UNCI_usuario');
				$data['COFecha_modificacion'] = date('Y-m-d H:i:s');
				$this->config_model->update(1,$data);
				set_mensaje("Los cambios se han realizado con éxito",'success::');
				echo "OK";
			}
		
		}
		
		function _set_rules($c='', $data = array()){
			
			if($c=='u'){
				$this->form_validation->set_rules('COLimite_fump', 'Limite de creación de FUMP', "trim|required|min_length[1]|max_length[2]");
				$this->form_validation->set_rules('CORango_fechas_i', 'Rango inicial FUMP', "trim|required|min_length[1]|max_length[20]");
				$this->form_validation->set_rules('CORango_fechas_f', 'Rango final FUMP', "trim|required|min_length[1]|max_length[20]");
			}
			// fin de la funcion _set_rules
		}
		
	}