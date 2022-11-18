<?php
	
	function checked($value,$checked,$echo='checked') {
		// https://codex.wordpress.org/Function_Reference/checked#Source_File
		$result = '';
		if (nvl($value) == $checked) {
			$result = $echo;
		}
		echo $result;
	}
	
	function nvl(&$var, $default = "")
	{
		return (isset($var) && !empty($var)) ? $var : $default;
	}
	
	function is_login($inicio='')
	{
		if (is_null(get_session('SESSION_SCN')))
		{
			if(!$inicio)
				set_mensaje("Favor de iniciar sesión para ingresar al sistema");
			return FALSE;
		}
		return TRUE;
	}
	
	function is_permitido( $rol = '', $modulo = '', $accion = '' )
	{
		$data = array();
		$CI = & get_instance();
		
		if(! $rol )// Rol por defecto es con el que se autentifica
		$rol = get_session('URol');
		
		if(! $modulo )// Controlador por defecto es la clase actual
		$modulo = $CI->router->fetch_class();
		
		if(! $accion )// Método por defecto es index
		$accion = ($CI->router->fetch_method())? $CI->router->fetch_method() : 'index';
		
		//permitir sin revición de permisos
		if( substr($accion, strrpos($accion, '_') + 1) == 'skip' ){
			return TRUE;
		}		
		
		$modulo = strtoupper( $modulo );
		$accion = strtoupper( $accion );
		set_session( 'referencia', "$modulo/$accion");
		$where = array(
		'CPERol'         => $rol,
		'CMODescripcion' => $modulo,
		'CACDescripcion' => $accion
		);
		
		$data = $CI->permiso_model->join()->find( $where );
		if( $data )
		return TRUE;
		else
		return FALSE;
		
	} //fin de la funcion is_permitido
	
	function muestra_mensaje()
	{
		if (get_session('mensaje') != '')
		{
			list($tipo_mensaje, $mensaje) = explode('::', get_session('mensaje'));
			echo '<div class="alert alert-' . $tipo_mensaje . ' alert-dismissable no-imprimir">';
			echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
			echo $mensaje;
			echo '</div>';
			set_session('mensaje', '');
		}
	}
	
	function set_mensaje($mensaje, $tipo_mensaje = 'danger::')
	{
		set_session('mensaje', $tipo_mensaje . $mensaje);
	}
	
	function set_session($variable, $valor = '')
	{
		$_SESSION[PREFIJO_DB . $variable] = $valor;
	}
	
	function get_session($variable)
	{
		if (!isset($_SESSION[PREFIJO_DB . $variable]))
		$_SESSION[PREFIJO_DB . $variable] = NULL;
		
		return ($_SESSION[PREFIJO_DB . $variable]);
	}
	
	// Funcion que pasa las varibles del POST al arreglo data
	function post_to_array($sufijo = 'galimatias')
	{
		$CI = & get_instance();
		$data = array();
		if( $_POST )
		{
			foreach(array_keys($_POST) as $key)
			{
				if( strpos($key, $sufijo) == FALSE )
				$data[$key] = $CI->input->post($key);
			}
		}
		return $data;
	}
	
	function doHash($toHash, $user_salt, $salt = PREFIJO_DB, $iterations = 3)
	{
		$i = 0;
		$algorithms = array('sha256', 'ripemd320', 'whirlpool');
		
		// Salting
		$toHash = $user_salt . $toHash . $salt;
		do {
			// Avoid Collision Attacks with different algorithms
			$tempHash = '';
			foreach ($algorithms as $algo) {
				$tempHash .= hash($algo, $toHash);
			}
			// Reset Hash length
			$toHash = hash($algo, $tempHash);
			$i++;
		} while ($i < $iterations);
		
		return $toHash;
	}
	
	function post_to_session($sufijo = 'galimatias')
	{
		$CI = & get_instance();
		if ($_POST) {
			foreach (array_keys($_POST) as $key) {
				if (strpos($key, $sufijo) == FALSE) {
					
					$_SESSION[PREFIJO_DB . $key] = trim($CI->input->post($key));
					
				}
			}
		}
	}
	
	// Funcion que regresa el número de dias entre dos fechas, la cual no contempla sabados y domingos
	// ni un calendario de dias feriados
	function dias($fechainicio, $fechafin) {
		$diasferiados=array(
		'01-01',
		'01-02',
		'01-03',
		'01-04',
		'01-05',
		'02-02',
		'03/16',
		'04-02',
		'04-03',
		'05-01',
		'05-05',
		'09-16',
		'12-25'
		);
		// Convirtiendo en timestamp las fechas
		$fechainicio = strtotime($fechainicio);
		$fechafin = strtotime($fechafin);
		
		// Incremento en 1 dia
		$diainc = 24*60*60;
		
		// Arreglo de dias habiles, inicianlizacion
		$diashabiles = array();
		
		// Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
		for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
			// Si el dia indicado, no es sabado o domingo es habil
			if (!in_array(date('N', $midia), array(6,7))) {
				// Si no es un dia feriado entonces es habil
				if (!in_array(date('m-d', $midia), $diasferiados)) {
					array_push($diashabiles, date('m-d', $midia));
				}
			}
		}
		
		return count ($diashabiles);
	}
	
	
	/**
		* Formatea una fecha de un formato origen a un formato destino
		*
		* Nota: Se utilizan diferentes notaciones para $formato_destino y $formato_origen
		*
		* ejem: Para representar el nombre de mes abreviado
		*       $formato_destino utiliza: %b conforme a http://php.net/manual/es/datetime.createfromformat.php
		*       $formato_origen utiliza: M conforme a http://php.net/manual/es/function.strftime.php
		*
		* Sin embargo, se pueden usar notaciones predefinidas aplicables a ambos formatos
		*  ymd para y-m-d
		*  dmy para d/m/y
		*  ymd hms para y-m-d h:i:s
		*  dmy hms para d/m/y h:i:s
		*
		* @param string $fecha Valor de la fecha a formatear
		* @param string $formato_destino Formato que se aplicara a $fecha
		* @param string $formato_origen Formato actual de $fecha
		* @return string
	*/
	function fecha_format($fecha,$formato_destino='equivalent',$formato_origen='autodetect') {
		if(!$fecha or $fecha=='0000-00-00'){
			return null;
		}
		
		if ($formato_origen == 'autodetect') {
			// La autodeteccion se realiza en base al caracter usado como separador de la fecha (diagonal o guion)
			$formato_origen = strpos($fecha, '/') ? 'dmy' : 'ymd';
			// y en la cantidad de caracteres : para determinar el formato del tiempo
			$time_format = array(0=>'','1'=>' hm',2=>' hms');
			$formato_origen .= $time_format[substr_count($fecha,':')];
		}
		
		$temp_origen = $formato_origen;
		
		// Traducimos el formato origen conforme a http://php.net/manual/es/datetime.createfromformat.php
		$origenes_predefinidos = array(
        'dmy'=>'d/m/Y','dmy hm'=>'d/m/Y H:i','dmy hms'=>'d/m/Y H:i:s',
        'ymd'=>'Y-m-d','ymd hm'=>'Y-m-d H:i','ymd hms'=>'Y-m-d H:i:s'
        );
		
		if (array_key_exists($formato_origen,$origenes_predefinidos)) {
			$formato_origen = $origenes_predefinidos[$formato_origen];
		}
		
		// Creamos un objeto fecha
		$temp_fecha = date_create_from_format($formato_origen,$fecha);
		if (!$temp_fecha) {
			return false; // La creacion de la fecha fallo
		}
		
		// Traducimos el formato destino conforme a http://php.net/manual/es/function.strftime.php
		$destinos_predefinidos = array(
        'dmy'=>'%d/%m/%Y', 'dmy hm'=>'%d/%m/%Y %H:%M', 'dmy hms'=>'%d/%m/%Y %H:%M:%S',
        'ymd'=>'%Y-%m-%d', 'ymd hm'=>'%Y-%m-%d %H:%M', 'ymd hms'=>'%Y-%m-%d %H:%M:%S'
        );
		
		if ($formato_destino == 'equivalent') {
			$destino_equivalente = array(
            'dmy'=>'ymd', 'dmy hm'=>'ymd hm', 'dmy hms'=>'ymd hms',
            'ymd'=>'dmy', 'ymd hm'=>'dmy hm', 'ymd hms'=>'dmy hm'
			);
			$formato_destino = $destino_equivalente[$temp_origen];
		}
		
		if (array_key_exists($formato_destino,$destinos_predefinidos)) {
			$formato_destino = $destinos_predefinidos[$formato_destino];
		}
		
		// http://stackoverflow.com/questions/8744952/formatting-datetime-object-respecting-localegetdefault
		// strftime() doesn't work with dates before 1970, Date_time::format() doesn't work with locales
		// so we do this combination of the two. User: Jack K
		setLocale(LC_TIME, 'Spanish_Mexico');
		return strftime($formato_destino, $temp_fecha->format('U'));
	}
	
	function fecha_texto($fecha = null, $dia = null){
		if(!$fecha or $fecha=='0000-00-00'){
			return null;
		}
		
		//var
		$result = "";
		$diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		$fecha = fecha_format($fecha, '%Y/%m/%d');
		
		//Creamos las variables de la fecha
		$w = date("w", strtotime($fecha));
		$d = date("d", strtotime($fecha));
		$n = date("n", strtotime($fecha));
		$y = date("Y", strtotime($fecha));
		
		if($dia)
			$result.= $diassemana[$w]." ";
		
		$result.= $d." de ".$meses[$n-1]. " de ".$y;
		
		return  $result;
		
		//Salida: Miercoles 05 de Septiembre del 2016
	}
	
	function checktime($hour='', $min='', $sec='') {
		if ($hour < 0 || $hour > 23 || !is_numeric($hour)) {
			return false;
		}
		if ($min < 0 || $min > 59 || !is_numeric($min)) {
			return false;
		}
		if(!$sec) return true;
		if ($sec < 0 || $sec > 59 || !is_numeric($sec)) {
			return false;
		}
		return true;
	}	
	
	function forma_archivo ( $campo, $value = '' ,$texto="Anexar archivo" , $class='btn-primary', $tipo_campo='pdf')
	{
		$CI = & get_instance();
		$monitor = (empty($value)) ? "none" : "show";
		
		echo anchor( "archivo/index/$campo/$tipo_campo", $texto, "class='btn btn-md upload_file ver_archivo $class'" );
        echo  nbs(10);
		$link = base_url("files/get_file/".$CI->encrypt->encode($value));
		echo anchor($link, "Ver archivo", "id='ver_archivo_$campo' style='display:$monitor' target='_blank' ver_archivo");
		$data=array(
		'name'=>$campo,
		'value'=>$value,
		'id'=>$campo,
		'type'=>'hidden'
		);
		echo form_input( $data );
	} //fin de la funcion forma_archivo
	
	function forma_imagen ( $campo, $value ,$texto="Anexar imagen" , $class='btn-primary')
	{
		$monitor = (empty($value)) ? "none" : "show";
		
		echo anchor( "archivo_imagen/index/$campo", $texto, "class='btn btn-md upload_file ver_archivo $class'" );
        echo nbs(10);
		echo anchor(nvl($value), "Ver imagen", "id='ver_archivo_$campo' style='display:$monitor' target='_blank' ver_archivo");
		$data=array(
		'name'=>$campo,
		'value'=>$value,
		'id'=>$campo,
		'type'=>'hidden'
		);
		echo form_input( $data );
	} //fin de la funcion forma_imagen
	
	function forma_archivo_csv ( $campo, $value ,$texto="Anexar archivo", $class='btn-primary')
	{
		$monitor = (empty($value)) ? "none" : "show";
		
		echo anchor( "archivo_csv/index/$campo", $texto, "class='btn btn-md upload_file ver_archivo $class' " );
        echo nbs(10);
		echo anchor(nvl($value), "Ver archivo", "id='ver_archivo_$campo' style='display:$monitor' target='_blank' ver_archivo");
		$data=array(
		'name'=>$campo,
		'value'=>$value,
		'id'=>$campo,
		'type'=>'hidden'
		);
		echo form_input( $data );
	} //fin de la funcion forma_archivo
	
	/**
		* Mueve una lista de archivos del directorio temporal a Documentos
		*
		* Procesa una lista de archivos, verificando si existe cambio en el nombre del archivo.
		* De ser asi, mueve el nuevo archivo del directorio temporal al directorio Documentos
		* @param array $data Array con los valores de los campos del formulario
		* @param array $lista_archivos Array con lista de archivos a procesar
		* @param array $old_data Array con los datos de la base de de datos
	*/
	function mover_archivos(&$data,$lista_archivos,$old_data=array(),$ruta_destino = "./documentos/",$cambiar = true,$ftp = true) {
		$CI = & get_instance();
		//$ruta_destino = "./documentos/";
		if (!file_exists($ruta_destino))
		@mkdir($ruta_destino);
		
		foreach ($lista_archivos as $archivo) {
			//if existe el archivo en la ruta origen
			if(file_exists($data[$archivo])){
				// Si el nombre de archivo es diferente al guardado en la BD
					
				if ($data[$archivo] != nvl($old_data[$archivo])) {
					if ($data[$archivo]) {
						
						$extension = pathinfo($data[$archivo], PATHINFO_EXTENSION);
						if($cambiar){
							// Regeneramos el nombre del archivo recien subido
							$cadena = random_string('alnum', 8);
							$usuario = get_session('UNCI_usuario');
							$archivo_destino = $ruta_destino . $usuario . '-' . $archivo . $cadena . "." . $extension;
						}else{						
							$archivo_destino = $ruta_destino . $archivo . "." . $extension;
						}
						// Movemos el archivo de temporal a Documentos
						@rename($data[$archivo], $archivo_destino);
						// Cambiamos el contenido del campo
						$data[$archivo] = $archivo_destino;
					}
					
					// Borramos el archivo anterior
					if($old_data[$archivo])
					@unlink(nvl($old_data[$archivo]));
					
					if($ftp)			
					ftp_put_file($archivo_destino,$archivo_destino,'sim',nvl($old_data[$archivo]) );
					
				}
			}else{
				unset($data[$archivo]);
			}
		}
	} //fin de la funcion mover_archivos
	
	function ftp_put_file($file_path='',$file_name = 'doc.txt',$direct = 'simple',$old_file=''){
		if($file_path and FTP_DIR){
			$file_path = str_replace('./','',$file_path);
			$file_name = str_replace('./','',$file_name);
			$old_file = str_replace('./','',$old_file);
			// Primero creamos un ID de conexión a nuestro servidor
			$cid = @ftp_connect(FTP_DIR,"21")or die(exit("No se pudo conectar"));
			// Luego creamos un login al mismo con nuestro usuario y contraseña
			$resultado = @ftp_login($cid, FTP_USER,FTP_PASS);
			// Comprobamos que se creo el Id de conexión y se pudo hacer el login
			if ((!$cid) || (!$resultado)) {
				//echo "Fallo en la conexión"; die;
			} else {
				// Cambiamos a modo pasivo, esto es importante porque, de esta manera le decimos al 
				ftp_pasv ($cid, true) ;
				
				//creamos la carpeta
				$nombre = substr($file_path, strrpos($file_path, '/') + 1);
				$path = str_replace($nombre, '', $file_path);				
				ftp_chdir($cid, $direct); //directorio
				@ftp_mkdir($cid,$path);
				if($old_file)
					@ftp_delete($cid,$old_file);
				
				if (@ftp_put($cid, $file_name, $file_path, FTP_BINARY)){
					//echo "Se ha cargado el archivo $file_name \n";
					unlink($file_path);
				}else {
					//echo "Hubo un problema durante la transferencia de: $file_name\n";
				}

				ftp_close($cid);
			}
		}
	}	
	
	//Funcion que regresa el mes en letra o en numero dependiendo lo que ingrese
	function  ver_mes($mes=''){
		if($mes>12) $mes=12;
		if($mes<1) $mes=1;
		$mes*='1';
		$meses = array("Null","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		return $meses[$mes];
	}
	
	//funcion para ver el tiempo que ha transcurrido en un periodo a la fecha actual
	function nicetime($fecha_inicio='',$fecha_fin = ''){
		if(!$fecha_inicio or !$fecha_fin){
			return false ; //"Fecha no especificada";
		}
		
		$fecha_inicio = fecha_format($fecha_inicio,'%Y-%m-%d');
		$fecha_fin = fecha_format($fecha_fin,'%Y-%m-%d');
		
		$fecha_inicio = new DateTime($fecha_inicio);
		$fecha_fin = new DateTime($fecha_fin);
		
		$diferencia = $fecha_inicio->diff($fecha_fin);
		
		$meses = ( $diferencia->y * 12 ) + $diferencia->m;

		return $meses;
	} //fin funcion
	
	//funcion para regresar 
	function to_back($num="1"){
		echo "<script type='text/javascript'>history.go(-$num);</script>";
	}
	
	//funcion para recargar la pagina 
	function reload(){
		echo '<script type="text/javascript">location.reload();</script>';
	}
	
	//funcion para obtener iniciales
	function iniciales($nombre) {
    	$notocar = Array('del','de','a');
    	$trozos = explode(' ',$nombre);
    	$iniciales = '';
    	for($i=0;$i<count($trozos);$i++){
    		if(in_array($trozos[$i],$notocar)) $iniciales .= $trozos[$i];
    		else $iniciales .= substr($trozos[$i],0,1);
		}
    	return $iniciales;
	}
	
	//funcion para extraer el texto entre dos indicadores (texto,indicador inicial, indicadir final)
	// el texto extraido no incluye los indicadores
	 function obteber_texto($cadena,$texto_ini='0',$texto_fin='0'){
		$maximo= strlen ($cadena); // total de la cadena
		$ide_number=strlen($texto_ini); // total de caracteres del primer indicador
		$total= strpos($cadena,$texto_ini); //posición numérica del primer indicador

		$total2= stripos($cadena,$texto_fin); //total de caracteres finales incluyecfo antes del segundo indicador 

		$total3= ($maximo-$total2); //total de caracteres finales incluyecfo  el segundo indicador

		if(! $texto_ini and ! $texto_fin)
			$final= $cadena; //cadena central entre los indicadores
		else if(! $texto_fin)
			$final= substr ($cadena,$total+$ide_number); //cadena central entre los indicadores
		else if(! $texto_ini)	
			$final= substr ($cadena,0,-$total3); //cadena central entre los indicadores
		else
			$final= substr ($cadena,$total+$ide_number,-$total3); //cadena central entre los indicadores
		
		return $final;
	}
	
	//quitar todo el texto antes del texto_ini incluyendolo
	function quitar_texto($texto,$texto_ini=''){
		$maximo= strlen ($texto); 
		$ide_number=strlen($texto_ini);
		$total= strpos($texto,$texto_ini);

		$texto = substr($texto,$total+$ide_number);
		return $texto;
	}
		
	function tipo_requisicion($ADTipo=''){
		if($ADTipo=='1')
			return "Contrato Pedido";
		elseif($ADTipo=='2')
			return "Compras Solidarias";
		elseif($ADTipo=='3')
			return "Federal";
	}
	
	function folio($clave='',$numero='5'){
		$folio = str_pad($clave, $numero, "0", STR_PAD_LEFT);
		return ($folio);
	}

	
	function multiplo($numero='0',$salto='1',$inicio='0'){
		$mul=($numero-$inicio)/$salto;
		if(is_float($mul))
			return false;
		else
			return true;
	}
	
	function descomprimir($archivo=null,$ruta=null,$data){
		if(!file_exists($archivo))
			return false;
		if(!$ruta){
			$name = @end(explode("/", $archivo));
			$ruta = str_replace($name,'',$archivo);
		}
		//Creamos un objeto de la clase ZipArchive()
		$enzipado = new ZipArchive();
		$CI = & get_instance();
		 
		//Abrimos el archivo a descomprimir
		$enzipado->open($archivo);
		
		//Extraemos el contenido del archivo dentro de la carpeta especificada
		$extraido = @$enzipado->extractTo($ruta);
		 
		/* Si el archivo se extrajo correctamente listamos los nombres de los
		 * archivos que contenia de lo contrario mostramos un mensaje de error
		*/
		if($extraido == TRUE){
			for ($x = 0; $x < $enzipado->numFiles; $x++) {
				$archivo = $enzipado->statIndex($x);
				//echo 'Extraido: '.$archivo['name'].'</br>';
				$data['Anombre']=$archivo['name'];
				$nombre_temporal = 'R'.random_string('alnum', 30);
				$ext =  @end(explode(".", $ruta.$archivo['name']));
				$new = $ruta.$nombre_temporal.'.'.$ext;
				@rename ($ruta.$archivo['name'], $new);
				
				$data['ARuta']=$new;
				$CI->archivo_model->insert($data);
			}
		  return $enzipado->numFiles;
		  unset($_POST); 
		}
		else {
		return false;
		unset($_POST); 
		}
		
	}
	
	function cuenta_psw(){
		$CI = & get_instance();
		$usuario = $CI->usuario_model->get( get_session('UNCI_usuario') );
		set_session("psw",false);

		if(! $usuario['USeguridad'] and $CI->router->fetch_class() != 'usuario' ){
			set_session("psw",true);
			set_mensaje('Para poder usar su cuenta de usuario por primera vez, es necesario el cambio de contraseña <br />Ingrese el correo registrado para esta cuenta.','success::');
			if(!get_session('OldRol'))
				redirect("usuario/cambio_password");
		}
		
		/*if( ! get_session('refresh') ){
			set_session('refresh',true);
			header("Refresh:0");
		}*/
	}
	
	function info(){
		$CI = & get_instance();
		$data = array();
		
		//Consultar Plantel y tipo de plantel
		$plantel = $CI->plantel_model->get(get_session('UPlantel'));			
		$tipo_p = $plantel['CPLTipo']==36? 'E':'B';
		$UClave_servidor = $plantel['CPLTipo']==36? get_session('UClave_servidor_centro'):get_session('UClave_servidor');
		
		if(!$UClave_servidor)
			$UClave_servidor = '***';
		
		$CI->db->where('PDUsuario',$UClave_servidor);
		$CI->db->where('PDDelete',NULL);
		$CI->db->where('PDNotificacion',NULL);
		$CI->db->where('PDTipo_plantel',$tipo_p);
		$CI->db->join('nousuario','PDUsuario = UClave_servidor','INNER');
		$data['percepciones'] = $CI->perded_model->find_all();

		$CI->db->where('CIEstatus',1);
		$CI->db->where('CIDelete',null);
		$data['circulares'] = $CI->circular_model->find_all();
		
		$CI->db->where('ANotificacion',NULL);
		$CI->db->like('ANombre',"_".$UClave_servidor);
		$CI->db->like('ANombre',"_RC$tipo_p");
		$data['recibos'] = $CI->archivo_model->find_all();
		
		$query_plantel = "1=1";
		$zona = "1=1";
		if( is_permitido(null,'personal','ver_todos') ){
		}elseif( is_permitido(null,'personal','ver_plantel') ){
			$query_plantel = "FIND_IN_SET( FCPlantel, '".get_session('UPlanteles')."')";
		}
		
		$where = array( "acceptTerms" => "on");
		if( is_permitido(null,"fump","nivel_7") ){ //*
			$nivel = 9;
		}elseif( is_permitido(null,"fump","nivel_6") ){ //Nomina
			$nivel = 6;
		}elseif( is_permitido(null,"fump","nivel_5") ){	//D.General
			$nivel = 5;
		}
		elseif( is_permitido(null,"fump","nivel_4") ){	//Finanzas
			$nivel = 4;
		}
		elseif( is_permitido(null,"fump","nivel_3") ){	//R.H
			$nivel = 3;
		}
		elseif( is_permitido(null,"fump","nivel_2") ){	//Coordinación
			$nivel = 2;
			if($plantel['CPLNombre'] == 'COORDINACIÓN DE ZONA VALLE DE TOLUCA'){
				$zona = "FCoordinacion = 'T'";
			}
			elseif($plantel['CPLNombre'] == 'COORDINACIÓN DE ZONA VALLE DE MÉXICO'){
				$zona = "FCoordinacion = 'M'";
			}
		}
		elseif( is_permitido(null,"fump","nivel_1") ){	//enlace
			$nivel = 1;
		}else{
			$nivel = 0;
			$plantel = $CI->plantel_model->get(get_session('UPlantel'));
			$where = array( "acceptTerms" => null , "FAutorizo_1 IS NOT" => NULL);
			$CI->db->like("FPlantel", $plantel['CPLNombre']);
		}
		
		if($nivel){
			$CI->db->where("FNivel_autorizacion", $nivel);
		}
		
		$CI->db->where($query_plantel);
		$CI->db->where($zona);
		$CI->db->where(array("FActivo" => 1));
		$data['fumps'] = $CI->fump_model->find_all($where);
		
		$data['nivel_skip'] = $CI->encrypt->encode($nivel);
		return $data;
	}
	
	function des_info_pe($val=''){
		$CI = & get_instance();
		$data = array();		
		$data['PENotificacion'] = '1';
		$CI->db->where("PERuta IS NOT NULL");
		$CI->percepcion_model->update($val,$data);
	}
	
	function des_info_re($val=''){
		$CI = & get_instance();
		$data = array();		
		$data['ANotificacion'] = '1';
		$CI->archivo_model->update($val,$data);
	}

	function setDia($d = '') {
		if (strlen($d) == 2) {
			$dia = $d;
		} else {
			$dia = "0" . $d;
		}
	return $dia;
	}

	function setMes($m = '') {
		if (strlen($m) == 2) {
			$mes = $m;
		} else {
			$mes = "0" . $m;
		}
	return $mes;
	}
	
	function chat(){
		$CI = & get_instance();
		$where = "(DATE(CHFecha_registro) = DATE(CURDATE()) AND CHUsuario_recibe = '".get_session('UNCI_usuario')."' AND CHLeido = 1) or (CHUsuario_recibe = '".get_session('UNCI_usuario')."' AND CHLeido = 0)";
		$total = $CI->chat_model->find_all( $where );
		
		$CI->db->group_by("CHUsuario_envia");
		$users = $CI->chat_model->find_all( $where, null, 'CHClave DESC' );
		
		$data['total'] = count($total);
		$data['users'] = count($users);
		
		return $data;
	}
	
	function excelheaders($file = null)
    {
        //Redireccionar la salida de navegador web de un cliente ( Excel5 )
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file.'.xls"');
        header('Cache-Control: max-age=0');
        // IE 9 , a continuación, puede ser necesaria la siguiente
        header('Cache-Control: max-age=1');
        // IE a través de SSL , a continuación, puede ser necesaria la siguiente
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

    }
	
	function periodo($periodo=null){
		$CI = & get_instance();
		$where = null;
		
		if(!$periodo){
			$where = "CURDATE() BETWEEN CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) AND CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin)";
		}else{
			$where = "CPEPeriodo = '$periodo'";
		}
		
		$data = $CI->periodos_model->find($where);
		if($data){
			$periodo = array(
				"PEPeriodo" => $data['CPEPeriodo'],
				"PEFecha_inicial" => $data['CPEAnioInicio']."-".$data['CPEMesInicio']."-".$data['CPEDiaInicio'],
				"PEFecha_final" => $data['CPEAnioFin']."-".$data['CPEMesFin']."-".$data['CPEDiaFin']
			);
		}else{
			exit("Sin periodo actual!!");
		}
		return $periodo;
	}
	
	function periodo_s($periodo=null){
		$CI = & get_instance();
		$where = null;
		
		$select = "*, CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio)AS FechaInicio";
		$CI->db->order_by("FechaInicio","DESC");
		$CI->db->limit("1");
		$data = $CI->periodos_model->find("CPEStatus = 1", $select);
		
		$periodo = array(
			"PEPeriodo" => $data['CPEPeriodo'],
			"PEFecha_inicial" => $data['CPEAnioInicio']."-".$data['CPEMesInicio']."-".$data['CPEDiaInicio'],
			"PEFecha_final" => $data['CPEAnioFin']."-".$data['CPEMesFin']."-".$data['CPEDiaFin']
		);
			
		return $periodo;
	}

	
	
?>
