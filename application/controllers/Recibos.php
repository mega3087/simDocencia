<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Recibos extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso'); // Verificamos que el usuario tenga el permiso
		}
		
		public function index($i=''){		
			$data= post_to_array('_skip');			
			$permitido = is_permitido(null,'recibos','save');
			
			
			
			/**Consultar Plantel y tipo de plantel**/
			$plantel = $this->plantel_model->get(get_session('UPlantel'));
			$tipo_p = $plantel['CPLTipo']==36? 'E':'B';
			$UClave_servidor = $plantel['CPLTipo']==36? get_session('UClave_servidor_centro'):get_session('UClave_servidor');
			if(!$UClave_servidor)
				$UClave_servidor = "***";
		
			if( $i = $this->encrypt->decode($i) ){
				des_info_re($i);
				$this->db->where('AClave',$i);
			}
			elseif(!$data){
				$data['AAnio']=date('Y');
				$data['AMes']=date('m');
				$data['ANombre'] = $UClave_servidor;
				$this->db->like('ANombre',"_RC$tipo_p");
			}
			
			if(!$permitido){
				$data['ANombre'] = $UClave_servidor;
				$this->db->like('ANombre',"_RC$tipo_p");
			}
			
			if(nvl($data['AAnio']))
				$this->db->where('AAnio',$data['AAnio']);		
			if(nvl($data['AMes']))
				$this->db->where('AMes',$data['AMes']);
			if(nvl($data['AQuincena']))
				$this->db->where('AQuincena',$data['AQuincena']);
			if(nvl($data['ANombre']))
				$this->db->like('ANombre',"_".nvl($data['ANombre']));
			
			$data['archivos'] = $this->archivo_model->get_all();
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'recibos/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function agregar(){
			
			$data['AAnio']=date('Y');
			$data['AMes']=date('m');
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'recibos/Form_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function save(){	
			if(!$_POST){
				redirect( $this->router->fetch_class().'/index' );
				set_mensaje("No se pudo realizar ninguna acción");
			}
			
			$data= post_to_array('_skip');			
			$files = nvl($_FILES['archivos']);			
			
			
			$this->_set_rules(); //validamos los datos
			if($this->form_validation->run() === FALSE)
			{
				set_mensaje(validation_errors());
				$data['modulo'] = $this->router->fetch_class();
				$data['subvista'] = 'recibos/Form_view';			
				$this->load->view('plantilla_general', $data);
			}else{

				$config['upload_path'] = "./recibos/".$data['AAnio']."/".ver_mes($data['AMes'])."/".$data['AQuincena']."/";
				$config['allowed_types'] = 'zip|rar|pdf';
				$config['max_size'] = '51200'; //50Mb

				if (!file_exists("./recibos"))
					mkdir("./recibos");
				
				if (!file_exists("./recibos/".$data['AAnio']))
					mkdir("./recibos/".$data['AAnio']);
				
				if (!file_exists("./recibos/".$data['AAnio']."/".ver_mes($data['AMes'])))
					mkdir("./recibos/".$data['AAnio']."/".ver_mes($data['AMes']));
				
				if (!file_exists($config['upload_path']))
					mkdir($config['upload_path']);

				$this->load->library('upload', $config);
				
				$archivos = array();
				$b=0;
				$m=0;
				$files_mal='';
				if($files)
				foreach ($files['name'] as $key => $archivo) {
					$numero = 0;
					$_FILES['archivos[]']['name']= $files['name'][$key];
					$_FILES['archivos[]']['type']= $files['type'][$key];
					$_FILES['archivos[]']['tmp_name']= $files['tmp_name'][$key];
					$_FILES['archivos[]']['error']= $files['error'][$key];
					$_FILES['archivos[]']['size']= $files['size'][$key];

					$fileName = $archivo;

					$archivos[] = $fileName;
					
					$datas = array('datos_archivo' => $this->upload->data());
					$nombre_temporal = 'R'.random_string('alnum', 30);
					$extension = @end(explode(".", $fileName));  
					$config['file_name'] = $nombre_temporal.'.'.$extension;

					$this->upload->initialize($config);

					if ($this->upload->do_upload('archivos[]')) {
						$this->upload->data();
						$data['Anombre']=$fileName;
						$data['ARuta']=$config['upload_path'] .$config['file_name'];
						$data['AFecha_registro']=date('Y-m-d H:i:s');
						$data['AUsuario_registro']=get_session('UNCI_usuario');						
						
						if(!$numero = descomprimir($data['ARuta'],null,$data)){
							$this->archivo_model->insert($data);
							$b++;
						}else{
							$b=$b+$numero;
						}
						set_mensaje("Se subierón <b>$b</b> Archivos con éxito","success::");
					} else {
						$m++;
						$files_mal.= $fileName.'<br />';
					}
				}
				if($m)
				set_mensaje("<p><b>$m Archivos no fueron subidos:</b> </p> $files_mal <p><b>Formato admitido PDF, tamaño maximo 2MB.</b></p>");
				
				//redirect( $this->router->fetch_class().'/index/i' );
				$data['modulo'] = $this->router->fetch_class();
				$data['subvista'] = 'recibos/Form_view';
				$this->load->view('plantilla_general', $data);
			}
			muestra_mensaje();
		unset($_POST); 	
		}
		
		public function download($AClave_skip){
			$AClave = $this->encrypt->decode( $AClave_skip );
			$Archivo = $this->archivo_model->find("AClave = $AClave",'ARuta,ADownload');			
			$data = array('ANotificacion'=>'1','ADownload' => $Archivo['ADownload']+1 );	
			$this->db->like('ANombre',"_".get_session('UClave_servidor'));			
			$this->archivo_model->update($AClave,$data);
			redirect(base_url($Archivo['ARuta']));
		}
		
		public function delete($AClave_skip){
			$AClave = $this->encrypt->decode( $AClave_skip );
			$this->archivo_model->delete($AClave);
			set_mensaje("El registro con clave [$AClave] se borro con éxito",'success::');
			to_back();
		}
		
		function _set_rules(){
			$this->form_validation->set_rules('AAnio', 'AAnio', "trim|required|min_length[4]|max_length[4]");
			$this->form_validation->set_rules('AMes', 'Mes', "trim|required|min_length[1]|max_length[2]");
			$this->form_validation->set_rules('AQuincena', 'Quincena', "trim|required|min_length[1]|max_length[2]");
		}
		
	}