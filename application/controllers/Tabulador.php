<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Tabulador extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso');
		}
		
		public function index(){
			
			$data = array();
			$where = array("PLActivo" => '1' );
			$data["plazas"] = $this->plaza_model->find_all($where);
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'tabulador/Mostrar_view';			
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
				$PLClave_skip=$this->input->post('PLClave_skip');
				$PLClave=$this->encrypt->decode($PLClave_skip);
				
				if(! $PLClave){
					$data['PLUsuario_registro']=get_session('UNCI_usuario');
					$data['PLFecha_registro']=date('Y-m-d H:i:s');
					$PLClave = $this->plaza_model->insert($data);
					set_mensaje("La plaza con clave [<b> $PLClave </b>] se registro con éxito",'success::');
				}else{				
					$data['PLUsuario_modificacion']=get_session('UNCI_usuario');
					$data['PLFecha_modificacion']=date('Y-m-d H:i:s');
					$this->plaza_model->update($PLClave,$data);
					set_mensaje("La Plaza con clave [<b> $PLClave </b>] se actualizó con éxito",'success::');
				}
				echo "OK";
			}
		
		}
		
		public function delete($PLClave_skip){
			$PLClave = $this->encrypt->decode( $PLClave_skip );			
			$data = array("PLActivo" => '0' );
			$this->plaza_model->update($PLClave, $data);
			set_mensaje("La Plaza con clave [$PLClave] se borro con éxito",'success::');
			to_back();
		}
		
		function _set_rules($c='',$data = array()){
			
			if($c=='p'){
				$this->form_validation->set_rules('PLTipo', 'Tipo Plaza', "trim|required|min_length[7]|max_length[14]");
				$this->form_validation->set_rules('PLTipo_plantel', 'Tipo Plantel', "trim|required|min_length[5]|max_length[7]");
				$this->form_validation->set_rules('PLTipo_clase', 'Tipo Clase', "trim|min_length[7]|max_length[8]");
				$this->form_validation->set_rules('PLPuesto', 'Puesto', "trim|required|min_length[3]|max_length[255]");
				$this->form_validation->set_rules('PLJornada', 'Jornada', "trim|min_length[18]|max_length[21]");
				$this->form_validation->set_rules('PLSindicato', 'Sindicalizable', "trim|required|exact_length[2]");
				$this->form_validation->set_rules('PLSueldo_base', 'Sueldo base', "trim|required|min_length[1]|max_length[11]");
				$this->form_validation->set_rules('PLGratificacion', 'Gratificación Burocratica', "trim|required|min_length[1]|max_length[11]");
				$this->form_validation->set_rules('PLDespensa', 'Despensa', "trim|required|min_length[1]|max_length[11]");
				$this->form_validation->set_rules('PLMaterial_dicactico', 'Material didactico', "trim|required|min_length[0]|max_length[11]");
				$this->form_validation->set_rules('PLEficiencia', 'Eficiencia', "trim|required|min_length[1]|max_length[11]");
				$this->form_validation->set_rules('PLTotal_bruto', 'Toatl Bruto', "trim|required|min_length[1]|max_length[11]");
			}
			// fin de la funcion _set_rules
		}
		
	}