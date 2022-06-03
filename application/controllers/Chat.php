<?php

class Chat extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');
			
		$this->load->library('emoji');
			
    }//fin del constructor
	
	public function index(){
		$chat_actual = get_session('chat_actual');
		
		$this->db->where("( (CHUsuario_envia = '$chat_actual' and CHUsuario_recibe = '".get_session('UNCI_usuario')."') or (CHUsuario_envia = '".get_session('UNCI_usuario')."' and CHUsuario_recibe = '$chat_actual') )");
		$this->db->where("( (DATE(CHFecha_registro) = DATE(CURDATE()) AND CHLeido = 1) OR (CHLeido = 0) )");
		$data = $this->chat_model->find_all( null, null, 'CHClave ASC' );

		foreach($data as $key => $list){
			$position = $list['CHUsuario_recibe'] == get_session('UNCI_usuario') ? 'left' : 'right';
			$status = $list['CHUsuario_recibe'] == get_session('UNCI_usuario') ? 'active' : '';
			if($list['CHUsuario_envia'] == get_session('UNCI_usuario')){
				$check = $list['CHLeido'] == '0' ? ' <i class="fa fa-check"></i>' : ' <i class="fa fa-check text-success"></i><i class="fa fa-check text-success"></i>';
			}else{
				echo $check = null;
			}
			echo"<div class='$position'>";
				echo'<div class="author-name">';
					echo $list['CHNombre'];
					echo'<small class="chat-date">';
						echo substr($list['CHFecha_registro'],10,6);
						echo $check;
					echo'</small>';
				echo'</div>';
				echo"<div class='chat-message $status'>";
					echo @Emoji::Decode( $list['CHMensaje'] );
				echo'</div>';
			echo'</div>';
		}
		
	}
	
	public function users(){
		$chat_actual = $this->input->post('usuario');
		if(!$chat_actual){
			$chat_actual = get_session('chat_actual');
		}
		
		if(! is_permitido(null,'chat','plantel') ){
			$where = "UPlantel IN (".get_session('UPlantel').") AND URol IN (3,10,12) AND UEstado = 'Activo'";
			$enlace = $this->usuario_model->find( $where );
			if($enlace){
				$chat_actual = $enlace['UNCI_usuario'];
			}
		}
		
		$this->db->where("( (CHUsuario_recibe = ".get_session('UNCI_usuario')." and CHLeido = 1 and DATE(CHFecha_registro) = DATE(CURDATE()) ) OR (CHUsuario_recibe = ".get_session('UNCI_usuario')." and CHLeido = 0) OR UNCI_usuario = '$chat_actual' )");
		$this->db->group_by("UNCI_usuario");
		$this->db->limit("5");
		$this->db->join('nousuario','UNCI_usuario = CHUsuario_envia','RIGHT');
		$data = $this->chat_model->find_all();

		foreach($data as $key => $list){
			$nombre = $list['UNombre'].' '.$list['UApellido_pat'].' '.$list['UApellido_mat'];
			if( $chat_actual==$list['UNCI_usuario'] ){ $color = "btn-success"; $active='<i class="fa fa-spinner fa-pulse"></i>'; }else{ $color = "btn-primary"; $active = ''; }
			echo '<button class="boton_chat btn '.$color.' btn-xs" onclick="users('.$list['UNCI_usuario'].');" >'.$nombre.' '.$active.'</button>&nbsp;';
		}
		echo "|$chat_actual|";
		set_session('chat_actual',$chat_actual);
	}
	
	public function noti(){
		$where = "(DATE(CHFecha_registro) = DATE(CURDATE()) AND CHUsuario_recibe = '".get_session('UNCI_usuario')."' AND CHLeido = 1) or (CHUsuario_recibe = '".get_session('UNCI_usuario')."' AND CHLeido = 0)";
		$total = $this->chat_model->find_all( $where );
		
		$this->db->where("DATE(CHFecha_registro)","DATE(CURDATE())",false);
		$this->db->group_by("CHUsuario_envia");
		$users = $this->chat_model->find_all( $where, null, 'CHClave DESC' );

		echo count($total)."|";
		echo count($users)."|";
	}
	
	public function send(){
		$data = post_to_array('_skip');
		$data['CHUsuario_envia'] = get_session('UNCI_usuario');
		$data['CHNombre'] = get_session('UNombre');
		
		$data['CHMensaje'] = Emoji::Encode( $data['CHMensaje'] );
		
		if($data['CHUsuario_recibe'] and $data['CHUsuario_recibe'] != $data['CHUsuario_envia'] ){
			$this->db->where('CHUsuario_envia',$data['CHUsuario_recibe']);
			$this->db->where('CHUsuario_recibe',get_session('UNCI_usuario'));
			$this->db->set('CHLeido',1);	
			$this->db->update('nochat');	
			
			$this->db->where("DATE(CHFecha_registro)","DATE(CURDATE())",false);
			$CHClave = $this->chat_model->insert( $data );
			$data = $this->chat_model->get( $CHClave ); 
			if($data){
				echo "OK|";
				echo $data['CHNombre']."|";
				echo substr($data['CHFecha_registro'],10,6).' <i class="fa fa-check"></i>|';
				echo Emoji::Decode( $data['CHMensaje'] )."|";
			}
		}
	}
}// fin del controlador
