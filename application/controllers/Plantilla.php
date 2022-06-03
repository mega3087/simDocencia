<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Plantilla extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso');
		}
		
		public function index(){
			
			$data = array();
			
			//filtrar por planteles
			if( is_permitido(null,'personal','ver_todos') ){
			}elseif( is_permitido(null,'personal','ver_plantel') ){
				$this->db->where("PPlantel IN(".get_session('UPlanteles').")");
			}
			
			$this->db->where('PActivo', 1);
			$this->db->join('noplanteles','CPLClave=PPlantel');
			$data["plantilla"] = $this->plantilla_model->find_all();

			//contar todos los registros sin limit
			if( is_permitido(null,'personal','ver_todos') ){
				$data['planteles'] = $this->plantel_model->find_all("CPLActivo = '1'");
			}elseif( is_permitido(null,'personal','ver_plantel') ){
				$data['planteles'] = $this->plantel_model->find_all("CPLClave IN(".get_session('UPlanteles').") and CPLActivo = '1'");
			}
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'plantilla/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function load(){
			if(! $_POST)
				redirect( $this->router->fetch_class() );
			
			$data= post_to_array('_skip');
			$this->_set_rules('p',$data); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				muestra_mensaje();
			}else{
				$PClave_skip=$this->input->post('PClave_skip');
				$PClave=$this->encrypt->decode($PClave_skip);
				
				$lista_archivos = array('PPlantilla');
				$old_data = $this->plantilla_model->get($PClave); 
				mover_archivos($data,$lista_archivos,$old_data,"./documentos/plantilla/");
				
				$data['PUsuario_modificacion']=get_session('UNCI_usuario');
				$data['PFecha_modificacion']=date('Y-m-d H:i:s');
				
				if(! $PClave){
					$data['PUsuario_registro'] = get_session('UNCI_usuario');
					$PClave = $this->plantilla_model->insert($data);
					set_mensaje("La Plantilla del periodo [<b> ".$data['PPeriodo']." </b>] se registro con éxito",'success::');
				}else{
					$this->plantilla_model->update($PClave,$data);
					set_mensaje("La Plantilla con clave [<b> ".$data['PPeriodo']." </b>] se actualizó con éxito",'success::');
				}
				echo "OK";
			}
		
		}
		
		public function delete($PClave_skip=''){
			$PClave = $this->encrypt->decode( $PClave_skip );
			$data = array("PActivo" => '0' );
			$this->plantilla_model->update($PClave, $data);
			set_mensaje("La plantilla con clave [$PClave] se borro con éxito",'success::');
			to_back();
		}
		
		function _set_rules($c='',$data = array()){
			
			if($c=='p'){
				$this->form_validation->set_rules('PPeriodo', 'Periodo', "trim|required");
				$this->form_validation->set_rules('PPlantel', 'Plantel', "trim|required");
				$this->form_validation->set_rules('PPlantilla', 'Plantilla', "trim|required");
			}
			// fin de la funcion _set_rules
		}
		
	}