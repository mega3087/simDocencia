<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Dashboard extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso');
		}
		
		public function index(){
			$data['titulo']='Consultar';
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'dashboard/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
			
			/*//resetear todas las cuentas
			$data = $this->usuario_model->find_all();
			foreach($data as $da => $list){
				echo $contrasena = doHash( '00000000', $list['UCorreo_electronico'] );
				echo"<br />";
				$datos= array('UContrasena' => $contrasena);
				$this->usuario_model->update($list['UNCI_usuario'],$datos);
			}
			*/
		}
		
	}