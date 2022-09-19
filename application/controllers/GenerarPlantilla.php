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
			
			$select = "UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, UFecha_nacimiento, UCorreo_electronico, URFC, UCURP, UClave_elector, UDomicilio, UColonia, UMunicipio, UCP, UTelefono_movil, UTelefono_casa, ULugar_nacimiento, UEstado_civil, USexo, UEscolaridad, UPlantel, UEstado, UDClave, UDUsuario, UDPlantel, UDTipo_Nombramiento, UDValidado";
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

			$selectNom = 'UDClave, UDUsuario, UDPlantel, UDTipo_Nombramiento, UDTipo_materia, UDHoras_grupo, UDHoras_apoyo, UDHoras_CB, UDHoras_provicionales, UDPlaza, UDActivo, nomplaza, TPClave, TPNombre';
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
			$data['opcion'] = 'materias';
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
			
			if(nvl($data['nogrupoMatutino'])) {
				$matutino = array();
				foreach ($data['nogrupoMatutino'] as $valorMat){
					if($valorMat != null && !empty($valorMat)){
						array_push($matutino, $valorMat);
					}
				}
			}

			if(nvl($data['nogrupoVespertino'])) {
			$vespertino = array();
				foreach ($data['nogrupoVespertino'] as $valorVes){
					if($valorVes != null && !empty($valorVes)){
						array_push($vespertino, $valorVes);
					}
				}
			}

			if(nvl($data['spTotal'])) {
				$spTotal = array();
					foreach ($data['spTotal'] as $valorTotal){
						if($valorTotal != null && !empty($valorTotal)){
							array_push($spTotal, $valorTotal);
						}
					}
				}
			
			$datosNom = 'UDClave, UDUsuario, UDPlantel, UDTipo_Nombramiento, TPNombre, UDTipo_materia, UDHoras_grupo, UDHoras_apoyo, UDHoras_CB, UDHoras_provicionales, UDPlaza, nomplaza, UDActivo, UDValidado';
			$this->db->join('noctipopersonal','TPClave = UDTipo_Nombramiento','left');
			$this->db->join('noplazadocente','idPlaza = UDPlaza','left');
			$this->db->where('UDClave',$data['idPUDatos']);
			$data['datosnom'] = $this->usuariodatos_model->find_all(null, $datosNom);
			$sumahoras = '0';
			$totalHoras = '0';
			$totalHoras = $data['datosnom'][0]['UDHoras_grupo'] + $data['datosnom'][0]['UDHoras_apoyo'] + $data['datosnom'][0]['UDHoras_CB'] + $data['datosnom'][0]['UDHoras_provicionales'];
			//$totalHoras = $data['datosnom'][0]['UDHoras_grupo'] + $data['datosnom'][0]['UDHoras_apoyo'];
			
			if(nvl($data['spTotal'])) {
				$sumahoras = array_sum(nvl($data['spTotal']));
			}
			if(nvl($data['psemestre']) == '' || nvl($data['pidMateria']) == '') {
				set_mensaje("Favor de ingresar todos los datos.");
				muestra_mensaje();
			} else {
				
				if ($sumahoras > $totalHoras) {
					set_mensaje("Las número de horas exceden al número de horas del Nombramiento.");
					muestra_mensaje();
				} else {
					$this->db->where('UDClave', $data['idPUDatos']);
					$validado = $this->usuariodatos_model->find();
					if ($validado['UDValidado'] == '1') {
						set_mensaje("Ya se guardaron los datos del Docente.");
						muestra_mensaje();
					} else {
						
						foreach ($data['pidMateria'] as $mat => $listS) {
							$sel = 'semmat';
							$this->db->where('id_materia', $listS);
							$semmat = $this->materias_model->find_all(null, $sel);
							
							$datos = array(
								'idPPlantel' => $data['idPPlantel'],
								'idPUsuario' => $data['idPUsuario'],
								'idPUDatos' => $data['idPUDatos'],
								'pidLicenciatura' => $data['pidLicenciatura'],
								'pperiodo' => $data['pperiodo'],
								'psemestre' => $semmat[0]['semmat'],
								'pidMateria' => $data['pidMateria'][$mat],
								'pnogrupoMatutino' => nvl($matutino[$mat]),
								'pnogrupoVespertino' => nvl($vespertino[$mat]),
								'ptotalHoras' => nvl($spTotal[$mat]),
								'pactivo' => 1,
								'pusuario_creacion' => get_session('UNCI_usuario'),
								'pfecha_creacion' => date('Y-m-d H:i:s')
							);
							
							$this->generarplantilla_model->insert($datos);	
						}
						$updatos = array(
							'UDValidado' => '1'
						);
						
						$idPlantilla = $this->usuariodatos_model->update($data['idPUDatos'], $updatos);
						set_mensaje("Los datos se agregarón correctamente",'success::');
						muestra_mensaje();
						echo "::OK";
						echo "::".$data['idPUsuario'];
					}
				}
			}
			
		}
		
		public function datosPlantilla() {
			$idPUsuario = $this->input->post('idPUsuario');
			$idPlantel = $this->input->post('idPlantel');
			$data['periodos'] = $this->input->post('periodo');

			$data['opcion'] = 'plantilla';

			$select = 'UDClave, UDUsuario, UDPlantel, UDTipo_Nombramiento, UDFecha_ingreso, UDHoras_grupo, UDHoras_apoyo, UDHoras_CB, UDHoras_provicionales, UDPlaza, UDFecha_inicio, UDFecha_final, UDObservaciones, UDValidado';
			$this->db->where('UDUsuario', $idPUsuario );
			$this->db->where('UDPlantel', $idPlantel);
			$this->db->where('UDValidado','1');

			$data['datos'] = $this->usuariodatos_model->find_all(null, $select);

			foreach ($data['datos'] as $d => $listDat) {
				$selectPlant = 'idPlantilla, idPUsuario, idPPlantel, idPUDatos, pidLicenciatura, pperiodo, psemestre, pnogrupoMatutino, pnogrupoVespertino, ptotalHoras, pidMateria, materia, hsm, plan_estudio, semmat';
				$this->db->join('nomaterias', 'id_materia = pidMateria', 'left');
				$this->db->where('idPUDatos', $listDat['UDClave']);
				$this->db->order_by('idPUDatos','ASC');
				$this->db->order_by('psemestre','ASC');
				
				$data['datos'][$d]['plantilla'] = $this->generarplantilla_model->find_all(null, $selectPlant);
			}
			
			$this->load->view('plantilla/Mostrar_materias', $data);	
		}

		public function ver_plantilla() {
			$idPlantel = $this->input->post('idPlantel');
			$data['FLogo_cobaemex'] = "logo_cobaemex_2018.png";
			$select = 'CPLClave, CPLNombre, CPLCCT, CPLCorreo_electronico, CPLDirector';
			$this->db->where('CPLClave',$idPlantel);
			
        	$data['plantel'] = $this->plantel_model->find_all(null, $select);

			$this->db->where('CPEStatus','1');
			$this->db->order_by('CPEPeriodo','DESC');
			$this->db->limit('1');
			$data['periodos'] = $this->periodos_model->find_all();	

			$selectUser = 'UDClave, UDUsuario, UDPlantel, UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, URFC, UDTipo_Nombramiento'; //ULCedulaProf;
			//$this->db->join('nousuariolic','ULClave = UDClave','left');
			$this->db->join('nousuario','UNCI_usuario = UDUsuario','left');
			$this->db->where('UDPlantel',$idPlantel);
			$this->db->order_by('UDTipo_Nombramiento','ASC');
			$this->db->order_by('UApellido_pat','ASC');
			$this->db->group_by('UDUsuario');

			$data['docentes'] = $this->usuariodatos_model->find_all(null, $selectUser);
			
			foreach ($data['docentes'] as $u => $listUser) {
				$select = "UDClave, UDFecha_ingreso, UDTipo_Nombramiento, TPNombre, UDTipo_materia, UDHoras_grupo, UDHoras_apoyo, UDHoras_CB, UDHoras_provicionales, (`UDHoras_grupo`+`UDHoras_apoyo`) AS TotalHoras, UDPlaza, nomplaza, UDFecha_inicio, UDFecha_final, UDObservaciones,UDNumOficio";
				$this->db->join('noctipopersonal', 'UDTipo_Nombramiento = TPClave', 'left');
				$this->db->join('noplazadocente', 'UDPlaza = idPlaza', 'left');
				$this->db->where('UDUsuario',$listUser['UNCI_usuario']);
				$this->db->where('UDPlantel',$listUser['UDPlantel']);
				$this->db->where('UDActivo','1');
				
				$data['docentes'][$u]['plazas'] = $this->usuariodatos_model->find_all(null, $select);

				$selects = "ULClave, ULNivel_estudio, ULLicenciatura, Licenciatura, ULCedulaProf, ULTitulado";
				$this->db->join('nolicenciaturas','IdLicenciatura = ULLicenciatura','left');
				$this->db->where('ULUsuario',$listUser['UNCI_usuario']);
				$this->db->where('ULPlantel',$listUser['UDPlantel']);

				$data['docentes'][$u]['estudios'] = $this->usuariolic_model->find_all(null, $selects);

				$selectMat = "idPlantilla, idPUDatos, pidLicenciatura, pperiodo, psemestre, pidMateria, materia, hsm, pnogrupoMatutino, pnogrupoVespertino, ptotalHoras";
				$this->db->join('nomaterias','id_materia = pidMateria','left');
				$this->db->where('idPUsuario',$listUser['UNCI_usuario']);
				$this->db->where('idPPlantel',$listUser['UDPlantel']);
				$this->db->order_by('idPUDatos','ASC');
				$this->db->order_by('psemestre','ASC');

				$data['docentes'][$u]['materias'] = $this->generarplantilla_model->find_all(null, $selectMat);

				$selectHoras = "SUM(UDHoras_grupo) UDHoras_grupo, SUM(UDHoras_apoyo) UDHoras_apoyo, SUM(UDHoras_CB) UDHoras_CB, SUM(UDHoras_provicionales) UDHoras_provicionales, (`UDHoras_grupo`+`UDHoras_apoyo`) AS TotalHoras";
				$this->db->where('UDUsuario',$listUser['UNCI_usuario']);
				$this->db->where('UDPlantel',$listUser['UDPlantel']);
				$this->db->where('UDActivo','1');

				$data['docentes'][$u]['horas'] = $this->usuariodatos_model->find_all(null, $selectHoras);

			}
			
			//echo json_encode($data['docentes']);

			$this->load->view('plantilla/Ver_plantilla', $data);
		}
		
    }
?>