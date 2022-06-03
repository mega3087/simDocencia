<?php

class Files extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');
			
    }//fin del constructor

    function get_file($file_path = '', $direct = 'sim',$local_path = 'temporales') 
    {
		$file_path = str_replace('./','',$this->encrypt->decode($file_path));
		if($file_path){
			$tipo =  substr($file_path, strrpos($file_path, '.') + 1);
			if(!FTP_DIR){
				if(!file_exists($file_path))
					exit("El archivo local no existe!");
				if($tipo == 'pdf' or $tipo == 'PDF'){
					header("Content-Type: application/$tipo");
					readfile($file_path); // Esto hace la magia
				}else{
					echo "<img src='".base_url($file_path)."' />";
				}
			}else{
				// Primero creamos un ID de conexión a nuestro servidor
				$cid = @ftp_connect(FTP_DIR,"21");
				// Luego creamos un login al mismo con nuestro usuario y contraseña
				$resultado = @ftp_login($cid, FTP_USER,FTP_PASS);
				// Comprobamos que se creo el Id de conexión y se pudo hacer el login
				if ((!$cid) || (!$resultado)) {
					exit("Fallo en la conexión");
				}else{
					// Cambiamos a modo pasivo, esto es importante porque, de esta manera le decimos al 
					ftp_pasv ($cid, true) ;
					
					ftp_chdir($cid, $direct); //directorio
					
					$local_file_path = $local_path."/file_temp.".$tipo;
					if (@ftp_get($cid, $local_file_path, $file_path, FTP_BINARY)){
						//echo "se ha cargado $file_path con éxito\n";
						if($tipo == 'pdf' or $tipo == 'PDF'){
							header("Content-Type: application/$tipo");
							readfile($local_file_path); // Esto hace la magia
						}else{
							echo "<img src='".base_url($local_file_path)."' />";
						}
					}else {
						//echo "El archivo remoto no existe!";
						if(!file_exists($file_path))
							exit("El archivo no existe!");
						if($tipo == 'pdf' or $tipo == 'PDF'){
							header("Content-Type: application/$tipo");
							readfile($file_path); // Esto hace la magia
						}else{
							echo "<img src='".base_url($file_path)."' />";
						}
					}
					ftp_close($cid);
				}
			}
		}
    }//fin de la funcion index
	
}// fin del controlador
