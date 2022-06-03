<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Percepciones extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso'); // Verificamos que el usuario tenga el permiso
		}
		
		public function index($i=''){		
			$data= post_to_array('_skip');
			
			$permitido = is_permitido(null,'percepciones','save');
			
			/**Consultar Plantel y tipo de plantel**/
			$plantel = $this->plantel_model->get(get_session('UPlantel'));
			$tipo_p = $plantel['CPLTipo']==36? 'E':'B';
			$UClave_servidor = $plantel['CPLTipo']==36? get_session('UClave_servidor_centro'):get_session('UClave_servidor');
			
			if(!$UClave_servidor)
			$UClave_servidor = '***';
		
			if( $i = $this->encrypt->decode($i) ){
				des_info_re($i);
				$this->db->where('PDClave',$i);
			}
			elseif(!$data){
				$data['AAnio']=date('Y');
				$data['AMes']=date('m');
				$data['ANombre']=$UClave_servidor;
				$this->db->where('PDTipo_plantel',$tipo_p);
			}
			
			if(!$permitido){
				$data['ANombre']=$UClave_servidor;
				$this->db->where('PDTipo_plantel',$tipo_p);
			}
			
			if(nvl($data['AAnio']))
				$this->db->like('PDFecha_i',$data['AAnio']);		
			if(nvl($data['AMes']))
				$this->db->where("( PDFecha_i like '%-".folio($data['AMes'],2)."-%' or PDFecha_i like '%/".folio($data['AMes'],2)."/%' )");
			if(nvl($data['AQuincena']))
				$this->db->where('PDQuincena',$data['AQuincena']);
			if(nvl($data['ANombre']))
				$this->db->where('PDUsuario',nvl($data['ANombre']));
			
			$this->db->where("PDDelete IS NULL");
			$data['percepciones'] = $this->perded_model->get_all();
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'percepciones/Mostrar_view';			
			$this->load->view('plantilla_general', $data);
		}
		
		public function import(){
			if(isset($_POST["import"]))
			{
				$filename=$_FILES["file"]["tmp_name"];
				if($_FILES["file"]["size"] > 0)
				{
					$i=0;
					$n=0;
					$file = fopen($filename, "r");
					while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE)
					{
						$data = array(
						'PDUsuario' => folio($importdata[0]),
						'PDNombre' => utf8_encode($importdata[1]),
						'PDPuesto' => $importdata[2],
						'PDTipo_plantel' => $importdata[3],
						'PDISSEMYM' => $importdata[4],
						'PDRFC' => $importdata[5],
						'PDDepartamento' => $importdata[6],
						'PDFecha_i' => $importdata[7],
						'PDFecha_f' => $importdata[8],
						'PDQuincena' => $importdata[9],
						'PDTotal_percepciones' => str_replace(array('$',','),'',$importdata[10]),
						'PDTotal_deducciones' => str_replace(array('$',','),'',$importdata[11]),
						'PDNeto_pagar' => str_replace(array('$',','),'',$importdata[12]),
						'P562' => str_replace(array('$',','),'',$importdata[13]),
						'P567' => str_replace(array('$',','),'',$importdata[14]),
						'P563' => str_replace(array('$',','),'',$importdata[15]),
						'P571' => str_replace(array('$',','),'',$importdata[16]),
						'P581' => str_replace(array('$',','),'',$importdata[17]),
						'P308' => str_replace(array('$',','),'',$importdata[18]),
						'P309' => str_replace(array('$',','),'',$importdata[19]),
						'P310' => str_replace(array('$',','),'',$importdata[20]),
						'P323' => str_replace(array('$',','),'',$importdata[21]),
						'P324' => str_replace(array('$',','),'',$importdata[22]),
						'P325' => str_replace(array('$',','),'',$importdata[23]),
						'P326' => str_replace(array('$',','),'',$importdata[24]),
						'P501' => str_replace(array('$',','),'',$importdata[25]),
						'P509' => str_replace(array('$',','),'',$importdata[26]),
						'P520' => str_replace(array('$',','),'',$importdata[27]),
						'P521' => str_replace(array('$',','),'',$importdata[28]),
						'P522' => str_replace(array('$',','),'',$importdata[29]),
						'P531' => str_replace(array('$',','),'',$importdata[30]),
						'P533' => str_replace(array('$',','),'',$importdata[31]),
						'P570' => str_replace(array('$',','),'',$importdata[32]),
						'P589' => str_replace(array('$',','),'',$importdata[33]),
						'PDUsusario_registro' => get_session('UNCI_usuario')
						);
						
						if($i>0 and str_replace(array('$',','),'',$importdata[12])!='0.00'){
							$insert = $this->perded_model->insert($data);
							$n++;
						}
						$i++;
					}                 
					fclose($file);
					set_mensaje("Se han importado $n datos satisfactoriamente...","success::");
				}else{
					set_mensaje("Error al procesar los datos...","danger::");
				}
			}
			redirect('percepciones');
		}
		
		public function download($PDClave_skip){
			$PDClave = $this->encrypt->decode( $PDClave_skip );
			$data['perded'] = $this->perded_model->find("PDClave = $PDClave");		
			$update = array('PDNotificacion'=>'1','PDDownload' => $data['perded']['PDDownload']+1 );
			$this->db->where('PDUsuario',get_session('UClave_servidor'));
			$this->perded_model->update($PDClave,$update);
			
			//$data['titulo']= "<h2>COMPROBANTE DE PERCEPCIONES Y DEDUCCIONES</h2>";
			$data['firma_pie']= "<b>COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO</b><br />DEPARTAMENTO DE RECURSOS MATERIALES Y SERVICIOS GENERALES<br />DIRECCIÓN DE ADMINISTRACIÓN DE FINANZAS";
			//$data['pie_pagina']= "2da Privada de la Libertad #102. La Merced y Alameda, Toluca, Estado de México, Teléfonos: (01722) 2.26.04.50 al 5";
			$this->load->library('dpdf');
			$data['subvista'] = 'percepciones/Percepcion_pdf_view';
			$this->dpdf->load_view('plantilla_general_pdf',$data);
			$this->dpdf->setPaper('letter', 'portrait');			
			$this->dpdf->render();
			$this->dpdf->stream("solicitud.pdf",array("Attachment"=>0));
		}
		
		public function delete($PEClave_skip=''){
			$PEClave = $this->encrypt->decode( $PEClave_skip );
				//$this->percepcion_model->delete($PEClave);
				$data['PDDelete'] = '1';
				$this->perded_model->update($PEClave,$data);
				set_mensaje("El registro con clave [".folio($PEClave)."] se borro con éxito",'success::');
				redirect("percepciones/index/anio");
		}
		
	}