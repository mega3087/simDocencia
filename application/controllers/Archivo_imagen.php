<?php

class Archivo_imagen extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');
    }//fin del constructor

    function index($nombre_campo) 
    {
        $data = array();
        $ruta = 'temporales';
        if (isset($_FILES['userfile']))
            $data = $this->_subir_archivo($ruta);

        $data['ruta'] = $ruta;
        $data['titulo'] = "Subir imagen";
        $data['nombre_campo'] = $nombre_campo;
        $this->load->view('archivo_imagen_view', $data);
    }//fin de la funcion index

    /* +---------------------------------------------------+
     * |Realiza la subida del archivo de acuerdo a los     |
     * |parametros establecidos, en caso de cumplir con los|
     * |requisitos la función devuelve un arreglo con toda |
     * |la información del archvio                         |
     * +---------------------------------------------------+ */

    function _subir_archivo($ruta)
    {

        $data = array();
        $config['upload_path'] = "./$ruta/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png|ico';
        $config['max_size'] = '2048'; //2Mb

        if (is_permitido('archivos grandes')) 
            $config['max_size'] = '10240'; // 10Mb

        if (!file_exists($config['upload_path']))
            mkdir($config['upload_path']);

        $this->load->library('upload', $config);

        //subimos el archivo al servidor
        if ($this->upload->do_upload()) {

            $data = array('datos_archivo' => $this->upload->data());

            //verificamos que el archivo se pueda leer
            if ($this->_validar_archivo($data['datos_archivo'])) {
				
                $nombre_temporal = $config['upload_path'] .
                                   random_string('alnum', 12) .
                        $data['datos_archivo']['file_ext'];

                //renombramos el archivo que subio el usuario, para evitar 
                //archivos con acentos y caracteres especiales
                rename($config['upload_path'] . $data['datos_archivo']['file_name'], $nombre_temporal);
                $data['datos_archivo']['file_name'] = $nombre_temporal;

                set_mensaje('<i class="fa fa-check"></i> Archivo subido exitosamente, pulse el botón [Cerrar] para continuar', 'success::');
            } 
            else {
                set_mensaje('No se puede leer el archivo, favor de verificarlo');

                unlink($data['datos_archivo']['full_path']);//eliminamos el archivo ya que no se pudo leer                

                $data = array();//limpiamos los valores del archivo
            }
        } 
        else
            set_mensaje($this->upload->display_errors());

        return $data;
    }//fin de la función subir_archivo

    /* +---------------------------------------------------+
     * |Función que nos permite verificar archivos de tipo |
     * |png, gif y jpg sean correctos                      |          
     * +---------------------------------------------------+ */
    function _validar_archivo( $datos_archivo )    
    {
        $buscarPatron = "";        

        $extensionArchivo = $datos_archivo['file_ext'];
        $extensionArchivo = strtolower( $extensionArchivo );


        $contenidoArchivo = file_get_contents( $datos_archivo['full_path'], NULL, NULL, 0, 100 );

        switch( $extensionArchivo )
        {                
                case '.png':
            $buscarPatron = '/PNG/i';
                    break;
                case '.jpg':
            $buscarPatron = '/JFIF/i';
                    break;
                case '.gif':
            $buscarPatron = '/GIF/i';
                    break;
        }

        if( preg_match( $buscarPatron , $contenidoArchivo ) )
                return TRUE;
            else
                return FALSE;
    }//fin de la funcion validar_archivo

}// fin del controlador