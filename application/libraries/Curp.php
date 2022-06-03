<?php //if (!defined("EN_SIS")) exit('No se permite el acceso directamente.');
/**
 * Code: PRODES
 * @author Miguel I. Flores Chagolla
 * @version 1.9
 *
 * Busca y verifica la CURP mediante consulta con RENAPO
 *
 * */

class Curp {

    /**
    *
    * @access private
    *
    */
    private $micurp;
    private $apepa;
    private $apema;
    private $sexo;
    private $nombre;
    private $fecha;
    private $entidad;
	
	public $estadoorigen = '15';
	public $ipserver = '201.175.34.119';
	public $curp_user = 'wsgestion'; //WS657210188
	public $curp_pass = 'wsgestion2011'; //Zt4A73b8
    /**
    * Constructor
    *
    * @param string curp
    * @access public
    */
    public function __construct( $micurp = null ) {
        $this->setMicurp($micurp);
    }

    /**
     * Set CURP
     *
     * @param cadena micurp
     * @access public
     */
    public function setMicurp( $micurp ) {
        $this->micurp = $this->convertirMayusculas($micurp);
    }

    /**
     * Set Primer Apellido
     *
     * @param cadena
     * @access public
     */
    public function setApepa( $apepa ) {
        $this->apepa = $this->convertirMayusculas($apepa);
    }

    /**
     * Set Segundo Apellido
     *
     * @param cadena
     * @access public
     */
    public function setApema( $apema ) {
        $this->apema = $this->convertirMayusculas($apema);
    }

    /**
     * Set Nombre
     *
     * @param cadena
     * @access public
     */
    public function setNombre( $nombre ) {
        $this->nombre = $this->convertirMayusculas($nombre);
    }

    /**
     * Set Sexo
     *
     * @param cadena
     * @access public
     */
    public function setSexo( $sexo ) {
        $this->sexo = $this->traduce($sexo,1);
    }

    /**
     * Set Fecha
     *
     * @param entero dia
     * @param entero mes
     * @param entero año
     * @access public
     */
    public function setFecha( $dia, $mes, $ano ) {
        $this->fecha = sprintf("%02d",$dia).'/'.sprintf("%02d",$mes).'/'.$ano;
    }

    /**
     * Set Entidad de Nacimiento
     *
     * @param cadena
     * @access public
     */
    public function setEntidad( $entidad ) {
        $this->entidad = $this->traduce($entidad,0);
    }

    /**
     * Quita los acentos exepto Ñ y convierte a mayusculas
     *
     * @param string cadena
     * @return string
     * @access private
     */
    private function convertirMayusculas( $cadena ) {

        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = strtr(utf8_decode($cadena), utf8_decode($originales), $modificadas);
        $cadena = strtoupper($cadena);

        return utf8_encode($cadena);
    }

    /**
     * Convierte numero de entidad a letra y Masculino a Hombre, segun caso
     *
     * @param cadena
     * @param entero 0,1
     * @return cadena
     * @access private
     */
    private function traduce($entra, $tipo) {

        //var
        $traduce = array();

        if ($tipo == 0) {
            $traduce = array(
                '01' => 'AS',
                '02' => 'BC',
                '03' => 'BS',
                '04' => 'CC',
                '05' => 'CL',
                '06' => 'CM',
                '07' => 'CS',
                '08' => 'CH',
                '09' => 'DF',
                '10' => 'DG',
                '11' => 'GT',
                '12' => 'GR',
                '13' => 'HG',
                '14' => 'JC',
                '15' => 'MC',
                '16' => 'MN',
                '17' => 'MS',
                '18' => 'NT',
                '19' => 'NL',
                '20' => 'OC',
                '21' => 'PL',
                '22' => 'QT',
                '23' => 'QR',
                '24' => 'SP',
                '25' => 'SL',
                '26' => 'SR',
                '27' => 'TC',
                '28' => 'TS',
                '29' => 'TL',
                '30' => 'VZ',
                '31' => 'YN',
                '32' => 'ZS'
            );
        }
        if ($tipo == 1) {
            $traduce = array(
                'M' => 'H',
                'F' => 'M',
            );
        }

        return strtr($entra, $traduce);
    }

    /**
     * Limpia la contestación del servidor
     *
     * @param cadena xml respuesta
     * @param entero tipo de consulta
     * @access private
     */
    private function limpiaRequest( $request, $tipo = 0) {

        $quita = array(
            '&lt;' => '<',
            '&gt;' => '>'
        );
        $request = strtr($request, $quita);

        if($tipo){
            $quita = array(
                '<?xml version=\'1.0\' encoding=\'UTF-8\'?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Body><ns:consultarCurpDetalleResponse xmlns:ns="http://services.wserv.ecurp.dgti.segob.gob.mx"><ns:return>' => '',
                '</ns:return></ns:consultarCurpDetalleResponse></soapenv:Body></soapenv:Envelope>' => ''
            );
        }else{
            $quita = array(
                '<?xml version=\'1.0\' encoding=\'UTF-8\'?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Body><ns:consultarPorCurpResponse xmlns:ns="http://services.wserv.ecurp.dgti.segob.gob.mx"><ns:return>' => '',
                '</ns:return></ns:consultarPorCurpResponse></soapenv:Body></soapenv:Envelope>' => ''
            );
        }
        $request = strtr($request, $quita);


        return $request;
    }

    /**
     * Prepara los datos para enviar
     *
     * @param entero tipo de consulta
     * @access private
     */
    private function postFields($tipo = 0) {
        

        $soap_request  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

        $soap_request .= "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ser=\"http://services.wserv.ecurp.dgti.segob.gob.mx\" xmlns:xsd=\"http://services.wserv.ecurp.dgti.segob.gob.mx/xsd\">\n";
        $soap_request .= "<soapenv:Header/>\n";
        $soap_request .= "<soapenv:Body>\n";
        if($tipo){
            $soap_request .= "<ser:consultarCurpDetalle>\n";
        }else{
            $soap_request .= "<ser:consultarPorCurp>\n";
        }
        $soap_request .= "<ser:datos>\n";
        if($tipo){
            $soap_request .= "<xsd:cveAlfaEntFedNac>$this->entidad</xsd:cveAlfaEntFedNac>\n";
            $soap_request .= "<xsd:fechaNacimiento>$this->fecha</xsd:fechaNacimiento>\n";
            $soap_request .= "<xsd:nombre>$this->nombre</xsd:nombre>\n";
            $soap_request .= "<xsd:primerApellido>$this->apepa</xsd:primerApellido>\n";
            $soap_request .= "<xsd:segundoApellido>$this->apema</xsd:segundoApellido>\n";
            $soap_request .= "<xsd:sexo>$this->sexo</xsd:sexo>\n";
            $soap_request .= "<xsd:cveUsuario>".$this->curp_user."</xsd:cveUsuario>\n";
        }else{
            $soap_request .= "<xsd:cveCurp>$this->micurp</xsd:cveCurp>\n";
            $soap_request .= "<xsd:usuario>".$this->curp_user."</xsd:usuario>\n";
        }
        $soap_request .= "<xsd:cveEntidadEmisora>".$this->estadoorigen."</xsd:cveEntidadEmisora>\n";
        $soap_request .= "<xsd:direccionIp>".$this->ipserver."</xsd:direccionIp>\n";
        $soap_request .= "<xsd:password>".$this->curp_pass."</xsd:password>\n";
        $soap_request .= "<xsd:tipoTransaccion>1</xsd:tipoTransaccion>\n";
        $soap_request .= "</ser:datos>";
        if($tipo){
            $soap_request .= "<ser:consultarCurpDetalle>\n";
        }else{
            $soap_request .= "<ser:consultarPorCurp>\n";
        }
        $soap_request .= "</soapenv:Body>";
        $soap_request .= "</soapenv:Envelope>";

        return $soap_request;
    }

    /**
     * Prepara el header
     *
     * @param cadena para obtener tamaño
     * @param numerico tipo 0 => CURP,1 => Detalles
     * @access private
     */
    private function header($contentl,$tipo) {

        $header = array(
            'Accept-Encoding: gzip,deflate',
            'Content-Type: text/xml;charset=UTF-8',
            'SOAPAction: '.($tipo? 'urn:consultarCurpDetalle' : 'urn:consultarPorCurp'),
            'Content-Length: '.strlen($contentl),
            'Connection: Keep-Alive',
            'Host: 201.175.34.121',
            'User-Agent: Apache-HttpClient/4.1.1 (java 1.5)',
            'Cache-Control: no-cache',
            'Pragma: no-cache'
        );

        return $header;
    }


  /**
   * Verifica la CURP con RENAPO
   *
   * @param numerico tipo 0 => CURP,1 => Detalles
   * @return string
   * @access public
   */
	public function getCurp($tipo = 0) {

		//var
		$result = array();
		$err = null;

		if(!function_exists('curl_version')) exit('Se requiere cURL');
		$soap_request = $this->postFields($tipo);
		$header = $this->header($soap_request,$tipo);

		$soap_do = curl_init();
		//IP DEL SERVICIO (PRUEBAS/PRODUCCONN)
		//desarrollo
		if($tipo){
			curl_setopt($soap_do, CURLOPT_URL, "https://websdes.curp.gob.mx/WebServicesConsulta/services/ConsultaCurpDetalleService?wsdl" );
		}else{
			curl_setopt($soap_do, CURLOPT_URL, "https://websdes.curp.gob.mx/WebServicesConsulta/services/ConsultaPorCurpService?wsdl" );
		}
		//produccion
		/*if($tipo){
			curl_setopt($soap_do, CURLOPT_URL, "https://201.159.133.77/wsCurp/services/ConsultaCurpDetalleService?wsdl" );
		}else{
			curl_setopt($soap_do, CURLOPT_URL, "https://201.159.133.77/wsCurp/services/ConsultaPorCurpService?wsdl" );
		}*/
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        60);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($soap_do, CURLOPT_POST,           true );
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $soap_request);
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

		if(curl_exec($soap_do) === false) {
			$err = 'Curl error: ' . curl_error($soap_do);
			curl_close($soap_do);
			exit($err);
		} else {
			$origin = curl_exec($soap_do);
			curl_close($soap_do);

			$response = $this->limpiaRequest($origin,$tipo);

			libxml_use_internal_errors(true);
			$xml = simplexml_load_string($response);
			if ($xml === false) {

				if(class_exists("errorHandler"))
				{
					global $error_handler;

					if(!is_object($error_handler))
					{
						require_once SIS_CORE."Error.php";
						$error_handler = new errorHandler();
					}

					$error_handler->error(E_ERROR, 'CADENA ORIGINAL: '.$origin.',<br/> RESPUESTA:'.$response,'Curp.php');
				}
				else
				{
					echo "Error Consulta\n";
					foreach(libxml_get_errors() as $error) {
						echo "\t", $error->message;
					}
				}
			}

			//var_dump($xml);
			//exit();

			if($xml['statusOper'] == 'EXITOSO'){

				if($tipo){
					$result = array(
						'error' => '0',
						'curp' => $xml->CURPStruct->CURP,
						'apellido1' => $xml->CURPStruct->apellido1,
						'apellido2' => $xml->CURPStruct->apellido2,
						'nombres' => $xml->CURPStruct->nombres,
						'sexo' => $xml->CURPStruct->sexo,
						'fechanac' => $xml->CURPStruct->fechNac,
						'nacionalidad' => $xml->CURPStruct->nacionalidad,
						'entidad' => $xml->CURPStruct->cveEntidadNac
					);

				}else{
					$result = array(
						'error' => '0',
						'curp' => $xml->CURP,
						'apellido1' => $xml->apellido1,
						'apellido2' => $xml->apellido2,
						'nombres' => $xml->nombres,
						'sexo' => $xml->sexo,
						'fechanac' => $xml->fechNac,
						'nacionalidad' => $xml->nacionalidad,
						'entidad' => $xml->cveEntidadNac
					);
				}
				//si exitoso
			}else{
				$msg = '';
				if($xml['TipoError'] == '01') $msg = 'RENAPO: CURP NO ENCONTRADA';
				if($xml['TipoError'] == '02') $msg = 'RENAPO: DESCONOCIDO';
				if($xml['TipoError'] == '03') $msg = 'RENAPO: CURP NO CUMPLE CON LA ESTRUCTURA OFICIAL';

				$result = array(
					'error' => '1',
					'tipo'  => $msg
				);
			}

			return $result;
		}
	}

}