<?php
class Usuario extends CI_Controller 
{	
  public function __construct()
  {
    parent::__construct();    
  } // fin del constructor    

  function agregar(  )
  {	
  	$data = array();

    $this->_mostrar_vista( $data );    
  } // fin de la funcion agregar 

  function insert(  )
  {
    if( ! $_POST )
      redirect( base_url() );

    $this->_set_rules( 'registrar' );
    if( $this->form_validation->run() === FALSE )
    {
      $data = post_to_array();
      set_mensaje(validation_errors());
      $this->_mostrar_vista( $data );
    }
    else
    {
      $data = post_to_array('_skip');

      $data['UContrasena'] = doHash($data['UContrasena'], $data['UCorreo_electronico']);            
      $data['UCodigo_activacion'] = random_string('alnum', 9);      
      $data['URol'] = 2;
      $data['UUsuario_registro'] = 1;
      $data['UFecha_registro'] = date("Y-m-d H:i:s");

      $primary_usuario = $this->usuario_model->insert($data);            

      if( $primary_usuario )
      {
        $data['correo_activacion'] = $this->encrypt->encode($data['UCorreo_electronico']);
        $data['fecha_registro_codigo'] = $this->encrypt->encode(date("Y-m-d H:i:s"));
             
        $this->email->to($data['UCorreo_electronico']);
        $this->email->from('CORREO_NOTIFICACION', 'COBAEM');
        $this->email->subject('COBAEM - Datos para ingreso a ' . NOMBRE_SISTEMA);
        $this->email->message($this->load->view('usuario/enviar_cuenta_view', $data, true));
        $this->email->send();

        set_mensaje('Se ha enviado a tu correo electrónico los datos para ingresar al sistema (no olvide revisar la carpeta de correo no deseado).', 'success::');
        unset($_POST); // limpiamos los datos para no evitar que el usuario haga clic en reenviar multiples veces            
        redirect(base_url()); // Mostramos la pantalla de login  
      }
      else
        $this->_mostrar_vista( $data );
    }
  } //fin de la funcion insert 

  function activar( $correo_electronico, $fecha_registro_codigo )
  {
    $usuario = array();

    if( ! $correo_electronico and ! $fecha_registro_codigo )
        redirect(base_url());

    $fecha_registro_codigo = $this->security->xss_clean($fecha_registro_codigo);
    $correo_electronico = $this->security->xss_clean($correo_electronico);
    $correo_electronico = $this->encrypt->decode($correo_electronico);        
          
    $where = array('UCorreo_electronico' => $correo_electronico);
    $usuario = $this->usuario_model->find( $where );
    
    if( $usuario )
    {        
      $data['data'] = $usuario;    
      $data['usuario_skip'] = $this->encrypt->encode($usuario['UNCI_usuario']);
      $data['correo_skip'] = $this->encrypt->encode($usuario['UCorreo_electronico']);  
      $data['codigo_skip'] = $fecha_registro_codigo;  

      $data['subvista'] = 'usuario/activar_cuenta_view';
      $this->load->view('usuario/plantilla_view', $data);
    } 
    else
      redirect(base_url());      
  }

  function registrar_activacion()
  {       
    $data = array();

    if( ! $_POST ) 
      redirect($this->router->fetch_class());         

    $this->_set_rules( 'activar' );
    if ($this->form_validation->run() === FALSE)  
    {       
      $data = post_to_array();
      set_mensaje(validation_errors());          
      $data['subvista'] = 'usuario/activar_cuenta_view';
      $this->load->view('usuario/plantilla_view', $data);                  
    }
    else
    {      
      $usuario = $this->input->post('usuario_skip');
      $usuario = $this->encrypt->decode( $usuario );
      $data = array(
                    "UEstado"            => "Activo", 
                    "UCodigo_activacion" => NULL);
      $this->usuario_model->update( $usuario, $data ); 
      set_mensaje('Ya puedes ingresar al sistema.','success::');   
      redirect(base_url());
    }            
      
  }//fin de la funcion registrar_activacion

  function recuperar_contrasena() 
  {              
    $data = array();
    $this->_mostrar_vista( $data, 'cambiar_contrasena' );
  }

  function enviar_instrucciones($adm=null) 
  {
    if( ! $_POST )
      redirect($this->router->fetch_class());        
         
    $this->_set_rules( 'cambiar_contrasena' );
    if ($this->form_validation->run() === FALSE) 
    {
      $data = post_to_array();
      set_mensaje(validation_errors());
      $this->_mostrar_vista( $data, 'cambiar_contrasena' );            
    }
    else 
    {
		$data_ = post_to_array('_skip');

		// Recuperamos la información del usuario
		$where = array(
			'UCorreo_electronico' => $data_['UCorreo_electronico'], 
			  'UEstado'             => "Activo"
			);
		$data = $this->usuario_model->find( $where );
	  
		if($data){

		  $periodo = $this->encrypt->encode(date('Y-m-d H:i:s'));
		  $informacion = array(
							  'UCambiar_contrasena' => $periodo
							  );            
		  $this->usuario_model->update( $data['UNCI_usuario'], $informacion );                                                                

		  $primary_usuario = $this->encrypt->encode( $data['UNCI_usuario'] );
		  $data['cambiar_contrasena'] =  base_url("usuario/cambiar_contrasena/$periodo/$primary_usuario");           
		  
		  $this->email->to($data['UCorreo_electronico']);
		  $this->email->from('CORREO_NOTIFICACION', 'COBAEM');
		  $this->email->subject('Restablecer contraseña - ' . NOMBRE_SISTEMA);
		  $this->email->message($this->load->view('usuario/enviar_cambio_contrasena_view', $data, true));
		  $this->email->send();
		}      
      
		unset($_POST); // limpiamos los datos para evitar que el usuario haga clic en reenviar multiples veces
		set_mensaje('Se ha enviado al correo digitado las instrucciones para cambiar la contraseña.', 'success::');
		if(!$adm)
			redirect(base_url());
		to_back();
    }
  }//fin de la funcion enviar_instrucciones 

  function cambiar_contrasena($tiempo, $usuario)
  {
    if( ! $tiempo and ! $usuario )            
      redirect(base_url());

    $data = array();

    $tiempo = $this->security->xss_clean($tiempo);    
    $usuario = $this->security->xss_clean($usuario);  
    $usuario_ = $this->encrypt->decode($usuario);      

    $where = array(
                    'UNCI_usuario'        => $usuario_,
                    'UCambiar_contrasena' => $tiempo
					);
    $usuario = $this->usuario_model->find( $where );
	
    if( ! $usuario)
    {
      set_mensaje('La solicitud de cambio de contraseña no fue encontrada');            
      redirect(base_url());
    }
	

    $tiempo = $this->encrypt->decode($tiempo);   
    $tiempo = new DateTime($tiempo);
    $tiempo_actual = new DateTime('now');  
    $minutos = ($tiempo_actual->getTimestamp() - $tiempo->getTimestamp()) / 60;        

	if($usuario){
	
		if( $minutos < 480 )
		{
		  $data['usuario_skip'] = $this->encrypt->encode( $usuario['UNCI_usuario'] );
		  $data['correo_electronico_skip'] = $this->encrypt->encode( $usuario['UCorreo_electronico'] );
		  $this->_mostrar_vista( $data, 'actualizar_contrasena');
		}
		else
		{
		  $data['UCambiar_contrasena'] = NULL;       
		  $this->usuario_model->update( $usuario['UNCI_usuario'], $data );
		  
		  set_mensaje('Ha expirado el tiempo para camiar la contraseña. Repetir el proceso');

		  unset($_POST);
		  redirect(base_url('usuario/recuperar_contrasena'));
		}
		
	}else if($proveedor){
	
		if( $minutos < 480 )
		{
		  $data['usuario_skip'] = $this->encrypt->encode( $proveedor['PPClave'] );
		  $data['correo_electronico_skip'] = $this->encrypt->encode( $proveedor['PPCorreo'] );
		  $this->_mostrar_vista( $data, 'actualizar_contrasena');
		}
		else
		{
		  $data['UCambiar_contrasena'] = NULL;       
		  $this->usuario_model->update( $proveedor['PPClave'], $data );
		  
		  set_mensaje('Ha expirado el tiempo para camiar la contraseña. Repetir el proceso');

		  unset($_POST);
		  redirect(base_url('usuario/recuperar_contrasena'));
		}
	
	}
  } //fin de la funcion cambiar_contrasena

  function nueva_contrasena() 
  {
    if( ! $_POST )            
     redirect($this->router->fetch_class());    

    $this->_set_rules( 'actualizar_contrasena' );
    if ($this->form_validation->run() === FALSE) // run validation
    {            
      $data = post_to_array();
      set_mensaje(validation_errors());
      $this->_mostrar_vista( $data, 'actualizar_contrasena' );
    } 
    else
    {            
      $data = post_to_array('_skip');
      
      $correo_electronico = $this->input->post( 'correo_electronico_skip' );
      $correo_electronico = $this->encrypt->decode( $correo_electronico );

      $usuario = $this->input->post( 'usuario_skip' );
      $usuario = $this->encrypt->decode( $usuario );
	  
      $where=array('UNCI_usuario' => $usuario,'UCorreo_electronico' => $correo_electronico);
	  $usuario_v=$this->usuario_model->find($where);
	  
	  if($usuario_v){
		  $data['UContrasena'] = doHash($data['UContrasena'], $correo_electronico);
		  $data['UCambiar_contrasena'] = NULL;
		  $data['USeguridad'] = '1';
		  
		  $where = array( 'UCorreo_electronico' => $correo_electronico );
		  $this->db->where($where);
		  $this->usuario_model->update( $usuario, $data );   
	  }
      
      unset($_POST); // limpiamos los datos para no evitar que el usuario haga clic en reenviar multiples veces
      redirect(base_url());            
      }
  }//fin de la función nueva_contrasena

  function _mostrar_vista( $data, $accion = 'registrar' )
  { 
    switch ($accion) 
    {
      case 'cambiar_contrasena':
        $data['subvista'] = 'usuario/recuperar_contrasena_view';
        break;
      
      case 'actualizar_contrasena':
        $data['subvista'] = 'usuario/cambiar_contrasena_view';
        break;
      
      default:
        //$data['cat_municipio'] = $this->cmunicipio_model->dropdown( 'CMUClave', 'CMUDescripcion' );
        $data['subvista'] = 'usuario/agregar_view';
        break;
    }

    $this->load->view('usuario/plantilla_view', $data);
  } //fin de la funcion _mostrar_vista 

  function _set_rules( $accion ) 
  {
    if( $accion == 'registrar' )
    {
	  $this->form_validation->set_rules('UNombre', 'Nombre del responsable', "trim_full|required|tom|min_length[3]|max_length[100]|caracteres_espacio|is_unique[nousuario.UNombre]");
	  $this->form_validation->set_rules('UCorreo_electronico', 'Correo electrónico del responsable', "trim_full|required|max_length[60]|valid_email|is_unique[nousuario.UCorreo_electronico]");    
      //$this->form_validation->set_rules('UUsuario', 'Usuario', "trim_full|required|max_length[50]|is_unique[nousuario.UUsuario]");    
      $this->form_validation->set_rules('UTelefono', 'Teléfono de contacto','trim|required|min_length[10]|max_length[60]');
      $this->form_validation->set_rules('UContrasena', 'Contrase&ntilde;a', "trim_full|required|password_strength_checker");
    }

    if( $accion == 'activar' )
      $this->form_validation->set_rules('UCodigo_activacion', 'Código activación', "trim_full|required|max_length[10]|alpha_numeric|callback__codigo_valido");      

    if( $accion == 'cambiar_contrasena' )
      $this->form_validation->set_rules('UCorreo_electronico', 'Correo electrónico', 'trim|required|min_length[10]|max_length[60]|valid_email|callback__existe_usuario');

    if( $accion == 'actualizar_contrasena' )
    {
      $usuario = $this->input->post('usuario_skip');        
      $usuario = $this->encrypt->decode($usuario);
      $this->form_validation->set_rules('UContrasena', 'Nueva contraseña', "trim|required|password_strength_checker[$usuario]");
    }
  } //fin de la funcion _set_rules

  function _codigo_valido($codigo) 
  {
    $data = array();
    $usuario = $this->input->post('usuario_skip');
    $usuario = $this->encrypt->decode($usuario);

    $correo =  $this->input->post('correo_skip');
    $correo = $this->encrypt->decode($correo);

    $where = array( 
                  'UNCI_usuario'        => $usuario, 
                  'UCorreo_electronico' => $correo, 
                  'UCodigo_activacion'  => $codigo
                  );
    $data = $this->usuario_model->find($where);
    
    if ( ! $data ) 
    {            
      $this->form_validation->set_message('_codigo_valido', 'El código no es valido');
      return FALSE;
    }

    $fecha_registro_codigo = $this->input->post('codigo_skip');
    $fecha_registro_codigo = $this->encrypt->decode( $fecha_registro_codigo );
    $fecha_registro_codigo = new DateTime( $fecha_registro_codigo );
    $fecha_actual = new DateTime('now');
    $intervalo = date_diff( $fecha_registro_codigo, $fecha_actual );

    if( $intervalo->format('%d') > 2 )
    {
      $where = array( 'UCorreo_electronico' => $correo );
	  $this->db->where($where);
      $this->usuario_model->delete( $usuario );      
      $this->form_validation->set_message('_codigo_valido', 'La cuenta ha sido eliminada, debido que excedió el periodo máximo de 2 días para su activación. Favor de realizar un nuevo registro');

      return FALSE;
    }

    return TRUE;
  } // fin de la funcion _codigo_valido 

  function _existe_usuario($correo_electronico) 
  {
    $where = array
              (
                'UCorreo_electronico' => $correo_electronico, 
                'UEstado'             => "Activo"
              );
    $data = $this->usuario_model->find( $where );
    
    if ( ! $data) 
    {            
      $this->form_validation->set_message('_existe_usuario', 'El correo electrónico no esta registrado ó no esta activo');
      return FALSE;
    }

    return TRUE;
  } //fin de la funcion _existe_usuario
  
	function cambio_password(){
		$data['modulo'] = $this->router->fetch_class();
		$data['subvista']='usuario/Cambio_view';
		$this->load->view('plantilla_general', $data);
	} // fin de la funcion Cambio de Password
	
	function negar_acceso()
	{
		$data['referencia'] = get_session('referencia');
		$data['modulo'] = 'permisos';
		$data['subvista'] = 'permisos/Acceso_negado_view';
		$this->load->view('plantilla_general', $data);
	} // fin de la funcion negar_acceso

} // fin del controlador usuario
?>
