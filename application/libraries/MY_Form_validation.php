<?php

	if (!defined('BASEPATH'))
    exit('No direct script access allowed');

	class MY_Form_validation extends CI_Form_validation
	{

		/**
			* Convierte el texto a mayúsculas incluyendo las palabras acentuadas
			*
			* @param string
		*/
		function tom($str) {
			return strtr(strtoupper($str), "áéíóúñàèìòùÀÈÌÒÙ", "ÁÉÍÓÚÑÁÉÍÓÚÁÉÍÓÚ");
		}

		function trim_full($texto) {
			return trim(preg_replace('/\s+/', ' ', $texto));
		}


		function alpha_space($texto) {
			$CI = & get_instance();
			if (preg_match('/^[a-zá-úÁ-ÚñÑ ]+$/i', $texto)) {
					return TRUE;
				} else {
					$CI->form_validation->set_message('alpha_space', 'El campo %s debe contener sólo caracteres alfabéticos.');
					return FALSE;
			}
		}

		function caracteres_espacio($texto)
		{
			$CI = & get_instance();

			if (preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,}$/i', $texto)) {
				return TRUE;
				} else {
				$CI->form_validation->set_message('caracteres_espacio', 'El campo %s debe contener sólo caracteres alfabéticos.');
				return FALSE;
			}
		}

		function caracteres($texto)
		{
			$CI = & get_instance();

			if (preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]{1,}$/i', $texto)) {
				return TRUE;
				} else {
				$CI->form_validation->set_message('caracteres', 'El campo %s debe contener sólo caracteres alfabéticos.');
				return FALSE;
			}
		}

		//referencia http://docstore.mik.ua/orelly/webprog/pcook/ch14_06.htm
		function password_strength_checker($contrasena, $usuario = 0)
		{
			$error = "";

			if (strlen($contrasena) < 8)
			$error = 'La contraseña debe tener al menos ocho caracteres.' . br();

			// contamos cuantos caracteres en mayúcula, minúsculas, números y carácteres especiales
			// son digitados en la contraseña
			if ( ! preg_match("#[A-Z]+#", $contrasena) )
			$error .= "La contraseña debe tener al menos una mayúscula." . br();

			if ( ! preg_match("#[a-z]+#", $contrasena) )
			$error .= "La contraseña debe tener al menos una minúsculas." . br();

			if ( ! preg_match("#[0-9]+#", $contrasena) )
			$error .= "La contraseña debe tener al menos un número." . br();

			if ( ! preg_match("#\W+#", $contrasena) )
			$error .= "La contraseña debe tener al menos un carácter especial." . br();

			if (preg_match('/(.)\\1{2}/', $contrasena))
			$error .= "La contraseña no debe tener más de dos caracteres consecutivos." . br();

			$CI = & get_instance();

			$lc_pass = strtolower($contrasena);
			$denum_pass = strtr($lc_pass,'5301!@','seolla'); // also check password with numbers or punctuation subbed for letters

			$lc_nombre = strtolower( $CI->input->post('UNombre') );
			$lc_correo = strtolower( $CI->input->post('UCorreo_electronico') );

			if($usuario)
			{
				$where = array('UNCI_usuario' => $usuario);
				$usuario = $CI->usuario_model->find($where);
				$lc_nombre = strtolower($usuario['UNombre']);
				$lc_correo = strtolower($usuario['UCorreo_electronico']);
			}
			
			$error_='';
			// verificamos que la contraseña no este relacionado con el nombre
			if (preg_match("/$lc_nombre/",$lc_pass) || preg_match("/" . strrev($lc_nombre) . "/",$lc_pass) ||
			preg_match("/$lc_nombre/",$denum_pass) || preg_match("/" . strrev($lc_nombre) . "/",$denum_pass) )
			$error_ .= 'La contraseña esta basada en el nombre.' . br();

			if (preg_match("/$lc_correo/",$lc_pass) || preg_match("/" . strrev($lc_correo) . "/",$lc_pass) ||
			preg_match("/$lc_correo/",$denum_pass) || preg_match("/" . strrev($lc_correo) . "/",$denum_pass) )
			$error_ .= 'La contraseña esta basada en el correo electrónico.' . br();

			if($error)
			{
				$CI->form_validation->set_message('password_strength_checker', $error);
				return false;
			}

			return true;
		}//Fin de la función password_strength_checker

		function valida_fecha($fecha,$rango_fechas='') {
			// Falta habilitar esta funcion para que funcione con parametros de fecha tiempo 01/01/2010 11:59:00
			// la fecha se recibe en el formato: 31/12/2010 (dia/mes/año)
			// el rango se recibe como: 01/01/2010,31/12/2010; now,31/12/2010; 01/01/2010,yesterday
			// usando una variable $rango_fechas = '01/01/2010,now';
			// La llamada debe realizarse con dobles comillas         "valida_fecha[$rango_fechas]" o
			// tambien se puede usar sin doble comilla y sin variable 'valida_fecha[01/01/2010,now]'

			// Si la fecha esta vacia entonces se considera valida
			if (empty($fecha)) return true;

			$CI = & get_instance();
			// http://regexlib.com/REDetails.aspx?regexp_id=250, se eligio dado que no valida fechas invalidas
			$pattern = "/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/";
			if (!preg_match($pattern,$fecha)) {
				$CI->form_validation->set_message('valida_fecha', 'Formato inválido, digite el campo %s utilizando el formato DD/MM/AAAA');
				return false;
			}

			list($dd,$mm,$yyyy) = explode("/", $fecha);
			if (!checkdate($mm, $dd, $yyyy)) {
				$CI->form_validation->set_message('valida_fecha', 'La %s es una fecha inválida, por favor verifiquela');
				return false;
			}
			// No se permiten fecha anteriores al Enero 01 de 1900
			if ($yyyy < '1900') {
				$CI->form_validation->set_message('valida_fecha', 'La %s debe ser posterior al 1 de enero de 1900');
				return false;
			}

			if ($rango_fechas) {
				// Se recibio como parametro un rango de fechas
				$date_field =  new DateTime($yyyy.$mm.$dd);
				list($rango_inicial,$rango_final) = explode(',', $rango_fechas);

				if ($rango_inicial) {
					// Si fue definida una fecha inicial, se valida
					// Si la fecha viene en el formato d/m/y lo cambiamos a formato
					$date_inicial = strpos($rango_inicial, '/') ? fecha_format($rango_inicial,'ymd') : $rango_inicial;
					// Comparamos las fechas
					$date_inicial = new DateTime($date_inicial);

					if ($date_field < $date_inicial) {
						$CI->form_validation->set_message('valida_fecha', 'La %s debe ser igual o posterior al '.$date_inicial->format("d/m/Y"));
						return false;
					}
				}

				if ($rango_final) {
					// Si fue definida una fecha inicial, se valida
					// Si la fecha viene en el formato d/m/y lo cambiamos a formato
					$date_final = strpos($rango_final, '/') ? fecha_format($rango_final,'ymd') : $rango_final;
					// Comparamos las fechas
					$date_final = new DateTime($date_final);

					if ($date_field > $date_final) {
						$CI->form_validation->set_message('valida_fecha', 'La %s debe ser igual o anterior al '.$date_final->format("d/m/Y"));
						return false;
					}
				}
			}
		}
		
		function valida_hora($hora='') {
		
			// Si la hora esta vacia entonces se considera valida
			if (!$hora) return true;
			
			$pattern = "/^([0-9]{2})\:([0-9]{2})\:([0-9]{2})$/";
			$pattern_c = "/^([0-9]{2})\:([0-9]{2})$/";
			$CI = & get_instance();
			if (!preg_match($pattern,$hora) and !preg_match($pattern_c,$hora)) {
				$CI->form_validation->set_message('valida_hora', 'Formato inválido, digite el campo %s utilizando el formato: HH:II:SS');
				return false;
			}
			$hora = explode(":", $hora);
			$hh = $hora[0];
			$ii = $hora[1];
			$ss = @$hora[2];
			
			if (!checktime($hh, $ii, $ss)) {
				$CI->form_validation->set_message('valida_hora', "La %s es una hora inválida, por favor verifiquela");
				return false;
			}
		}

		function existe_archivo($nombre_archivo) {
			if (!file_exists($nombre_archivo)) {
				$CI = & get_instance();
				$CI->form_validation->set_message('existe_archivo', "El archivo %s no fue encontrado en el servidor, vuelva a subirlo.");
				return FALSE;
			}
			return TRUE;
		}

		/**
			* Validar que un monto sea valido
			*
			* El monto puede contener los simbolos: $, coma y punto,
			* pero estos deben ser acordes al formato de un monto ejem: $9,999.99
			*
			* @param int $monto
			* @return boolean
		*/
		function valida_monto($monto) {
			// Si el monto esta vacio entonces se considera valido
			if (!isset($monto)) {
				return true;
			}

			$CI =& get_instance();
			// http://stackoverflow.com/questions/354044/what-is-the-best-u-s-currency-regex
			// Number: Currency amount (cents optional) Optional thousands separators (coma); optional two-digit fraction
			// Se utiliza el mismo patron utilizado en ValidationEngine
			$pattern = "/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/";
			//$pattern = "/^[0-9]{1,}(?:\.[0-9]{2})?$/";
			if (!preg_match($pattern,$monto)) {
				$CI->form_validation->set_message('valida_monto', 'El campo %s es inválido, use el formato sin comas: 9999.99');
				return false;
			}

			// El monto cumple con el formato
			return  true;
		}

		function valida_curp($value=''){
			if (!isset($value))
				return true;
			// Nacidos antes del 2000 el caracter 17 debe ser numerico,
			// Nacidos en el 2000 o posterior el caracter 17 debe ser letra
			$pattern="/^([A-Z]{4})([0-9]{6})([A-Z]{6})([A-Z]|[0-9]{1})([0-9]{1})$/i"; //AAAA######AAAAAA##
			if(preg_match($pattern,$value))
				return true;
			else{
				$CI =& get_instance();
				$CI->form_validation->set_message('valida_curp', 'El campo %s es inválido, use el formato: AAAA######AAAAAA##');
				return false;
			}
		}

	    function unique($value, $table_field_extra_where) {
			// otro ejemplo similar esta en http://www.scottnelle.com/41/extending-codeigniters-validation-library/
			// http://net.tutsplus.com/tutorials/php/6-codeigniter-hacks-for-the-masters/
			$CI = & get_instance();

			// El parametro de extra_where es opcional por lo que se agrega una coma al final
			// con un valor default, evitando que el explode genere un error
			// http://php.net/manual/en/function.explode.php
			// mvpetrovich 10-Sep-2010 12:35
			list ($table, $field, $extra_where) = explode(',', $table_field_extra_where . ',1=1');

			$query = $CI->db->select($field, false)
			->from($table)
			->where($field, $value)
			->where($extra_where, null, false)
			->limit(1)
			->get();


			// $CI->form_validation->set_message('unique','The %s is already being used.');
			// El mensaje solo es mostrado si se regresa FALSE
			$CI->form_validation->set_message('unique', 'La información del campo %s [' . $value . '] ya esta registrada, revise la información capturada');

			return ($query->row()) ? FALSE : TRUE;
		}
		
		function valida_rfc($valor) {
			$CI = & get_instance();
			$valor = str_replace("-", "", $valor);
			$cuartoValor = substr($valor, 3, 1);
			//RFC Persona Moral.
			if (ctype_digit($cuartoValor) && strlen($valor) == 12) {
				$letras = substr($valor, 0, 3);
				$numeros = substr($valor, 3, 6);
				$homoclave = substr($valor, 9, 3);
				if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
					return true;
				}
			//RFC Persona Física.
			} else if (ctype_alpha($cuartoValor) && strlen($valor) == 13) {
				$letras = substr($valor, 0, 4);
				$numeros = substr($valor, 4, 6);
				$homoclave = substr($valor, 10, 3);
				if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
					return true;
				}
			}else {
				$CI->form_validation->set_message('valida_rfc', 'El campo %s tiene un formato invalido, Ejemplo: XXXXDDDDDDXXX');
				return false;
			}
		}

	}
