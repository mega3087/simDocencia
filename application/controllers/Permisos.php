<?php
	class Permisos extends CI_Controller 
	{	
		
		public function  __construct()
		{
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login'); // Verificamos que el usuario este logeado
			
			if( ! is_permitido() )
				redirect('usuario/negar_acceso');
			
		} //fin del constructor
		
		function index()
		{
			$this->db->join('nocaccion', 'CPEAccion=CACClave','RIGHT');
			$this->db->join('nocmodulo', 'CACModulo=CMOClave','RIGHT');
			$this->db->group_by('CPEAccion');
			$this->db->order_by('CACModulo');
			$this->db->order_by('CACDescripcion');
			$data['permisos']=$this->permiso_model->find_all();
			$data['rol']=$this->rol_model->find_all();
			$this->_mostrar_vista($data,null);    
		} // fin de la funcion agregar
		
		function save_modulo(){
			$data = post_to_array('_skip');
			
			if( $this->modulo_model->find($data) ){
				set_mensaje("El módulo <b>".$data['CMODescripcion']."</b> ya existe, verifica la información.","danger::");
			}else{
				$CMOClave = $this->modulo_model->insert($data);
				set_mensaje("El módulo <b>".$data['CMODescripcion']."</b> fue agregado exitosamente.","success::");
				$data = array(
					"CACModulo" => $CMOClave,
					"CACDescripcion" => "INDEX",
					"CACDetalle" => "Página principal de ".strtolower ($data['CMODescripcion'])
				);
				$CACClave = $this->accion_model->insert($data);
				$data = array(
					"CPEAccion" => $CACClave,
					"CPERol" => 1
				);
				$this->permiso_model->insert($data);	
			}			
			redirect(base_url('permisos'));
		}
		
		function save_accion(){
			$data = post_to_array('_skip');
			
			$CMOClave_skip = $this->input->post('CMOClave_skip');
			$CMOClave = $this->encrypt->decode( $CMOClave_skip );			
			$data['CACModulo'] = $CMOClave;
			
			if( $this->accion_model->find($data) ){
				set_mensaje("La acción <b>".$data['CACDescripcion']."</b> ya existe, verifica la información.","danger::");
			}else{
				$CACClave = $this->accion_model->insert($data);
				set_mensaje("La acción <b>".$data['CACDescripcion']."</b> fue agregada exitosamente.","success::");
				$data = array(
					"CPEAccion" => $CACClave,
					"CPERol" => 1
				);
				$this->permiso_model->insert($data);	
			}			
			redirect(base_url('permisos'));
		}
		
		function delete_accion($CACClave_skip = null){
			$CACClave = $this->encrypt->decode($CACClave_skip);
			
			$accion = $this->accion_model->get($CACClave);			
			$this->accion_model->delete($CACClave);
			set_mensaje("La acción fue borrada exitosamente.","success::");
			
			if(! $this->accion_model->find( array( "CACModulo" => $accion['CACModulo']) ) )
				$this->modulo_model->delete( $accion['CACModulo'] );
			
			redirect(base_url('permisos'));
		}
		
		function update(){
			//Limpiar la tabla de permisos
			$this->db->empty_table('nocpermiso');
			//Asignar todos los permisos al administrador
			$data = $this->accion_model->find_all();
			foreach($data as $key => $list){
				$permiso = array('CPEAccion' => $list['CACClave'], 'CPERol' => '1' );
				$this->permiso_model->insert($permiso);
			}
			
			//Asignar permisos seleccionados
			$data=post_to_array('_skip');
			foreach($data as $key => $list){
				foreach($list as $llave => $rol){
					if($rol<>1){
						$permisos=array('CPEAccion'=>$key, 'CPERol' => $rol );
						$this->permiso_model->insert($permisos);
					}
				}
			}
			set_mensaje("Permisos modificados exitosamente.","success::");
			redirect(base_url('permisos'));
		}
		
		function _mostrar_vista( $data, $accion = 'registrar' )
		{
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista']='permisos/form_view';
			$this->load->view('plantilla_general', $data);
		} //fin de la funcion _mostrar_vista 
		
	} // fin del controlador Solicitante
?>
