<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class GenerarPlantilla extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			//if ( ! is_permitido())
				//redirect('usuario/negar_acceso');
		}

        public function index() {
			if(is_permitido(null,'GenerarPlantilla','crear') && get_session('URol') == '6') {
				redirect('GenerarPlantilla/crear/'.$this->encrypt->encode(get_session('UPlantel')));
			}
			
			$data = array();
			
			/*filtrar por planteles
			if( is_permitido(null,'personal','ver_todos') ){
			}elseif( is_permitido(null,'personal','ver_plantel') ){
				$this->db->where("PPlantel IN(".get_session('UPlanteles').")");
			}
			
			//contar todos los registros sin limit
			if( is_permitido(null,'personal','ver_todos') ){
                $this->db->where('CPLTipo != 37');
				$this->db->order_by('CPLNombre','ASC');
				$data['planteles'] = $this->plantel_model->find_all("CPLActivo = '1'");
			}elseif( is_permitido(null,'personal','ver_plantel') ){
                $this->db->where('CPLTipo != 37');
				$this->db->order_by('CPLNombre','ASC');
				$data['planteles'] = $this->plantel_model->find_all("CPLClave IN(".get_session('UPlanteles').") and CPLActivo = '1'");
			}*/

			$select = 'CPLClave, CPLNombre, CPLCCT, CPLCorreo_electronico, CPLDirector';
			$this->db->where('CPLTipo',35);
			$this->db->or_where('CPLTipo',36);
			$this->db->where('CPLActivo',1);
			$this->db->order_by('CPLClave','ASC');
			
        	$data['planteles'] = $this->plantel_model->find_all(null, $select);
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'plantilla/Mostrar_view2';			
			$this->load->view('plantilla_general', $data);
		}

		public function crear ($plantel = null) {
			
			$plantel = $this->encrypt->decode($plantel);
			$data['plantel'] = $plantel;
			$data['titulo'] = 'CREAR PLANTILLA';

			$this->db->where('CPEStatus','1');
			$this->db->order_by('CPEPeriodo','DESC');
			$this->db->limit('10');
			$data['periodos'] = $this->periodos_model->find_all();	
			
			$data['modulo'] = $this->router->fetch_class();
			//$data['subvista'] = 'plantilla/Crear_view';
			$data['subvista'] = 'plantilla/Crear_plantilla';
			$this->load->view('plantilla_general', $data);
		}

		public function mostrarTablas() {
			$plantel = $this->input->post('plantel');
			$UDTipo_Nombramiento =  $this->input->post('UDTipo_Docente');
			
			$select = "UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, UFecha_nacimiento, UCorreo_electronico, URFC, UCURP, UClave_elector, UDomicilio, UColonia, UMunicipio, UCP, UTelefono_movil, UTelefono_casa, ULugar_nacimiento, UEstado_civil, USexo, UEscolaridad, UPlantel, UEstado, UDClave, UDUsuario, UDPlantel, UDTipo_Nombramiento";
			$this->db->join('nousuario','UNCI_usuario = UDUsuario', 'left');
			$this->db->join('nocrol','URol = CROClave', 'left');
			$this->db->where("CROClave NOT IN ('3','10','12')");
			$this->db->where('FIND_IN_SET ("'.$plantel.'",UPlantel)');
			//$this->db->where('UNCI_usuario',$datos['UDUsuario']);
			$this->db->where('UEstado','Activo');
			$this->db->where('UDTipo_Nombramiento', $UDTipo_Nombramiento ); 
			$this->db->where('FIND_IN_SET ("'.$plantel.'",UDPlantel)');
			$this->db->group_by('UDUsuario');
			$this->db->order_by('UNombre', 'ASC');
			$data['docentes'] = $this->usuariodatos_model->find_all(null, $select);

			$this->load->view('plantilla/Mostrar_tablas', $data);

		}

		public function asignarMaterias() {
			$idUsuario = $this->input->post('idUser');
			$plantel = $this->input->post('plantel');
			$UDTipo_Nombramiento =  $this->input->post('UDTipo_Docente');

			$data['idUser'] = $idUsuario;
			$select = "UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, UFecha_nacimiento, UCorreo_electronico, URFC, UCURP, UClave_elector, UDomicilio, UColonia, UMunicipio, UCP, UTelefono_movil, UTelefono_casa, ULugar_nacimiento, UEstado_civil, USexo, UEscolaridad, UPlantel, UEstado";
			$this->db->join('nocrol','URol = CROClave', 'left');
			$this->db->where("CROClave NOT IN ('3','10','12')");
			$this->db->where('FIND_IN_SET ("'.$plantel.'",UPlantel)');
			$this->db->where('UNCI_usuario',$idUsuario);
			$this->db->where('UEstado','Activo');
			$this->db->order_by('UNombre', 'ASC');
			$data['docentes'] = $this->usuario_model->find_all(null, $select);

			$selectNom = 'UDClave, UDUsuario, UDPlantel, UDTipo_Nombramiento, UDTipo_materia, UDHoras_grupo, UDHoras_apoyo, UDHoras_adicionales, UDPlaza, UDActivo, nomplaza, TPClave, TPNombre';
			$this->db->join('noctipopersonal','TPClave = UDTipo_Nombramiento','left');
			$this->db->join('noplazadocente','idPlaza = UDPlaza','left');
			$this->db->where('UDUsuario',$idUsuario);
			$this->db->where('(UDTipo_Nombramiento = '.$UDTipo_Nombramiento.' OR UDTipo_Nombramiento = 5 OR UDTipo_Nombramiento = 6 OR UDTipo_Nombramiento = 7)'); 
			$this->db->where('UDPlantel',$plantel);
			$this->db->where('UDActivo','1');
			$data['nombramientos'] = $this->usuariodatos_model->find_all(null, $selectNom); 
			
			$selectEst = '*';
			$this->db->join('nolicenciaturas', 'IdLicenciatura = ULLicenciatura','left');
			$this->db->where('ULUsuario',$idUsuario);
			$this->db->where('ULPlantel',$plantel);
			$this->db->where('ULActivo','1');
			//$this->db->limit('1');
			$data['estudios'] = $this->usuariolic_model->find_all(null, $selectEst);		

			$this->load->view('plantilla/Mostrar_AsignarMaterias', $data);			

		}

		public function mostrarMaterias() {
			$plantel = $this->input->post('plantel');
			$periodo = $this->input->post('periodo');
			$idLic = $this->input->post('licenciatura');
			$semestre = $this->input->post('semestre');
			if($idLic == ''){
				set_mensaje("Favor de seleccionar Estudios del Docente.");
				muestra_mensaje();
			} else {
				$selectP = 'CPLClave, CPLNombre, CPLTipo';
				$this->db->where('CPLClave',$plantel);
				$data['plantel'] = $this->plantel_model->find_all(null, $selectP);

				if ($data['plantel'][0]['CPLTipo'] == 35) {
					$plan_estudio = '1';
				} elseif ($data['plantel'][0]['CPLTipo'] == 36) {
					$plan_estudio = '2';
				}

				$this->db->where('IdLicenciatura',$idLic);
				$data['ids'] = $this->licenciaturas_model->find_all();
				$idMat = array();

				$idMat = explode(',',$data['ids'][0]['LIdmateria']);
				
				foreach ($idMat as $k => $mats) {
					$this->db->where('id_materia',$mats);
					$this->db->where('semmat',$semestre);
					$this->db->where('plan_estudio',$plan_estudio);
					$this->db->where('activo','1');
					$this->db->order_by('semmat','ASC');
					$arreglo[$k] = $this->materias_model->find_all();
				}
				$arrayAux = array();
				foreach ($arreglo as $valor) {
					if ($valor != null && !empty($valor)) {
						array_push($arrayAux, $valor);
					}
				}

				$data['arrayMaterias'] = $arrayAux;

				$this->load->view('plantilla/Mostrar_materias', $data);		

			}
		}

		public function save() {
			$data = post_to_array('_skip');
			echo json_encode($data);
				
				$datosNom = 'UDClave, UDUsuario, UDPlantel, UDTipo_Nombramiento, TPNombre, UDTipo_materia, UDHoras_grupo, UDHoras_apoyo, UDHoras_adicionales, UDPlaza, nomplaza, UDActivo, UDValidado';
				$this->db->join('noctipopersonal','TPClave = UDTipo_Nombramiento','left');
				$this->db->join('noplazadocente','idPlaza = UDPlaza','left');
				$this->db->where('UDClave',$data['idPUDatos']);
				$data['datosnom'] = $this->usuariodatos_model->find_all(null, $datosNom);
				$sumahoras = '0';
				$totalHoras = '0';
				$totalHoras = $data['datosnom'][0]['UDHoras_grupo'] + $data['datosnom'][0]['UDHoras_apoyo'] + $data['datosnom'][0]['UDHoras_adicionales'];
				echo $totalHoras;
				if(nvl($data['spTotal'])) {
					$sumahoras = array_sum(nvl($data['spTotal']));
				}
				if ($sumahoras > $totalHoras) {
					set_mensaje("Las número de horas exceden al número de horas del Nombramiento.");
					muestra_mensaje();
				} else {
					set_mensaje("Los datos se agregarón correctamente",'success::');
					muestra_mensaje();
					//echo "::OK";
				}
			
			exit;
			

			if($data['pidnombramiento'] == '' || $data['pidLicenciatura'] == '' || $data['psemestre'] == '' || $data['pidMateria'] == '' || $data['nogrupoMatutino'] == '' || $data['nogrupoVespertino'] == '' ) {
				set_mensaje("Favor de ingresar todos los datos requeridos.");
				muestra_mensaje();
			} else {
				$data['pactivo'] = '1';
				$data['pusuario_creacion'] = get_session('UNCI_usuario');
				$data['pfecha_creacion'] = date('Y-m-d H:i:s');
				
				$id = $this->generarplantilla_model->insert($data);
				set_mensaje("Los Grupos se Agregarón Correctamente",'success::');
				muestra_mensaje();
				echo "::OK";
            	echo "::".$id;
			}
		}
		
		public function datosPlantilla() {
			$idPlantilla = $this->input->post('idPlantilla');
			$idPlantel = $this->input->post('idPlantel');

			echo $idPlantilla;
			echo $idPlantel;
		}
		/*public function MostrarCarreras() {
			$nivel =  $this->input->post('tipo');
			if (is_numeric($nivel)) {
				$this->db->where('UNCI_usuario', $nivel);
				$data['usuarios'] = $this->usuario_model->find_all();
				$UCURP = $data['usuarios'][0]['UCURP'];
				$UNombre = $data['usuarios'][0]['UNombre'];
				$UApellido_pat = $data['usuarios'][0]['UApellido_pat'];
				$UApellido_mat = $data['usuarios'][0]['UApellido_mat'];
				$URFC = $data['usuarios'][0]['URFC'];
				$timestamp = strtotime($data['usuarios'][0]['UFecha_registro']);
				$UFecha_ingreso = date("d-m-Y", $timestamp );
				echo"::$UCURP";
				echo"::$UNombre";
				echo"::$UApellido_pat";
				echo"::$UApellido_mat";
				echo"::$URFC";
				echo"::$UFecha_ingreso";

			} elseif (is_string($nivel)) {
				$this->db->where('LIdentificador !=','0');
				$this->db->like('LGradoEstudio', $nivel);
				$this->db->group_by('Licenciatura');
				$this->db->order_by('Licenciatura', 'ASC');
				$data['carreras'] = $this->licenciaturas_model->find_all();
				
				?>
				<option value=""></option>
				<?php foreach ($data['carreras']  as $k => $listCar) { ?>
					<option value="<?= $listCar['IdLicenciatura']; ?>"><?= $listCar['Licenciatura']; ?></option>    
				<?php } 
				
			}
		}
		
		public function uploads() {
			//$filename = $_FILES['file']['name'];

			$time = $_POST['idUsuario'].date("dmY");
			$targetDir = "uploads/";
			$doc = $_POST['tipoDoc'].'.pdf';
			$file_name = $time."-".$doc;
			$targetFilePath = $targetDir . $file_name;
			if ( move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
				//insertar los documentos en la tabla
			echo '::'.'El archivo se subio Correctamente'; 
			} else { 
			echo '::'.'Fallo al subir Archivo'; 			}
			
		}

		public function save() {
			$data= post_to_array('_skip');
			$idUser = $this->input->post('idUsuario');
			$plantel = $this->input->post('plantel');

			if($this->input->post('usernew') == 'Si') {
				$datosUser = array(
					'UCURP' => $data['UCURP'], 
					'UNombre' => $data['UNombre'], 
					'UApellido_pat' => $data['UApellido_pat'], 
					'UApellido_mat' => $data['UApellido_mat'], 
					'URFC' => $data['URFC'], 
					'UFecha_ingreso' => $data['UFecha_ingreso']
				);
				//$idU = $this->usuario_model->insert($datosUser);
				
				if ($this->input->post('FClave_skip') != '') {
					$datosEstudios = array(
						'ULUsuario' => $this->input->post('FClave_skip'), 
						'ULPlantel' => $plantel, 
						'ULNivel_estudio' => $data['ULNivel_estudio'], 
						'ULLicenciatura' => $data['ULLicenciatura'], 
						'ULCedulaProf' => $data['ULCedulaProf'], 
						'ULNombramiento' => $data['ULNombramiento'], 
						'ULTitutado' => $data['Titulado'], 
						'ULActivo' => '1',
						'ULUsuarioRegistro' => get_session('UNCI_usuario'),
						'ULFechaRegistro' => date('Y-m-d H:i:s')
					);
					//$idEst = $this->usuario_model->insert($datosEstudios);
				}

//				echo "::".$idU;
				//echo"::OK";
			} else {
				$idUser = $this->input->post('idUsuario');
				echo $idUser;
			}
			
			exit;
			
			echo "::".$idUser;
			echo "::"."Se guardarpn los datos correctos";
		}*/
    }
?>