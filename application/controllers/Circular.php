<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Circular extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso'); // Verificamos que el usuario tenga el permiso
		}
		
		public function index($CIClave_skip=''){
			$CIClave = $this->encrypt->decode($CIClave_skip);
			
			if(!is_permitido(null,'circular','save'))
				$this->db->where('CIEstatus',1);
			
			if($CIClave)
				$this->db->where('CIClave',$CIClave);
			
			$where = array( "CIDelete" => null );			
			$data['archivos'] = $this->circular_model->find_all($where,null,'CIClave DESC');
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'circular/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function save(){
			$data = post_to_array('_skip');
			$data= post_to_array('_skip');
		
			$this->_set_rules(); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				muestra_mensaje();
			}else{
				$CIClave_skip = $this->input->post('CIClave_skip');
				$CIClave = $this->encrypt->decode($CIClave_skip);
				
				$lista_archivos = array('CIRuta');
				mover_archivos($data,$lista_archivos,null,'./circulares/'); 
				
				$data['CIArchivo'] = 'Ver Circular';
				
				if($CIClave){
						$data['CIFecha_modificacion'] = date('Y-m-d H:i:s');
					$data['CIUsuario_modificacion'] = get_session('UNCI_usuario');
					$CIClave = $this->circular_model->update($CIClave,$data);
					set_mensaje("El registro con clave [$CIClave] se actualizo con éxito",'success::');
				}else{
						$data['CIFecha_registro'] = date('Y-m-d H:i:s');
					$data['CIUsuario_registro'] = get_session('UNCI_usuario');
					$CIClave = $this->circular_model->insert($data);
					set_mensaje("El registro con clave [$CIClave] se agrego con éxito",'success::');
				}
				echo "OK";
			}
			
		}
		
		public function status($CIClave_skip,$estado='0'){
			$CIClave = $this->encrypt->decode( $CIClave_skip );
			$data = array('CIEstatus' => $estado,'CIUsuario_modificacion' => get_session('UNCI_usuario'), 'CIFecha_modificacion' => date('Y-m-d H:i:s'));
			$this->circular_model->update($CIClave,$data);
			$msg='desactivo';
			if($estado)
				$msg = 'activo';
			set_mensaje("El registro con clave [$CIClave] se $msg con éxito",'success::');
			to_back();
		}
		
		public function delete($CIClave_skip){
			$CIClave = $this->encrypt->decode( $CIClave_skip );
			//$this->circular_model->delete($CIClave);
			$data = array('CIDelete' => '1');
			$this->circular_model->update($CIClave,$data);
				set_mensaje("El registro con clave [$CIClave] se borro con éxito",'success::');
			to_back();
		}
		
		function _set_rules(){
			$this->form_validation->set_rules('CIRuta', 'Archivo', "trim|required|min_length[1]|max_length[255]");
			$this->form_validation->set_rules('CIDescripcion', 'Descripción', "trim|required|min_length[1]|max_length[255]");
		}
		
	}