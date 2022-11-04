<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Generarplantilla extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if (!is_login() )
				redirect('login');
			
			if (!is_permitido())
				redirect('usuario/negar_acceso');
		}

        public function index() {
			//PlanVerPlan -> Plantilla ver planteles
			if(!is_permitido(null,'generarplantilla','PlanVerPlan')) {
				redirect('generarplantilla/crear/'.$this->encrypt->encode(get_session('UPlantel')));
			}
			
			//$planteles =  get_session('UPlanteles');
			$select = 'CPLClave, CPLNombre, CPLCCT, CPLCorreo_electronico, CPLDirector';
			if (get_session('URol') == '15') {
				$this->db->where_in('CPLClave',get_session('UPlanteles'),false);
				//$this->db->where( "FIND_IN_SET( '".get_session('UPlanteles')."',CPLClave)" );
				$this->db->where('(CPLTipo = 35 OR CPLTipo = 36)');
			} else {
				$this->db->where('(CPLTipo = 35 OR CPLTipo = 36)');
			}
			
			$this->db->where('CPLActivo',1);
			$this->db->order_by('CPLClave','ASC');
			$data['planteles'] = $this->plantel_model->find_all(null, $select);
	
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'plantilla/Mostrar_view2';			
			$this->load->view('plantilla_general', $data);
		}

		public function crear ($plantel = null){
			$plantel = $this->encrypt->decode($plantel);
			if(!$plantel) redirect('generarplantilla');
			
			//Consultar plantillas generadas del periodo
			$where = array('PPeriodo' => '22-2', 'PPlantel' => $plantel, 'PActivo' => '1');
			$data['plantillas'] = $this->plantilla_model->find_all($where);

			$this->db->where('CPEStatus','1');
			$this->db->order_by('CPEPeriodo','DESC');
			$this->db->limit('10');
			$data['periodos'] = $this->periodos_model->find_all();	
			
			$data['plantel'] = $plantel;
			$data['titulo'] = 'CREAR PLANTILLA';
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'plantilla/Crear_plantilla';
			$this->load->view('plantilla_general', $data);
		}

		public function mostrarTablas_skip() {
			$plantel = $this->input->post('plantel');
			$data['Tipo_Nombramiento'] =  $this->input->post('UDTipo_Docente');
			
			$data['docentes'] = $this->usuariodatos_model->nombramientos($plantel, $data['Tipo_Nombramiento']);
			
			$this->load->view('plantilla/Mostrar_tablas_view', $data);

		}

		public function asignarMaterias_skip() {

			$idUsuario = $this->input->post('idUser');
			$plantel = $this->input->post('plantel');
			$UDTipo_Nombramiento =  $this->input->post('UDTipo_Docente');
			$idPlanDetalle = $this->input->post('idPlanDetalle');
			$data['UDTipo_Nombramiento'] = $UDTipo_Nombramiento;

			$data['datosPlantilla'] = $this->generarplantilla_model->get($idPlanDetalle);
			
			$data['idUser'] = $idUsuario;
			$select = "UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, UFecha_nacimiento, UCorreo_electronico, URFC, UCURP, UClave_elector, UDomicilio, UColonia, UMunicipio, UCP, UTelefono_movil, UTelefono_casa, ULugar_nacimiento, UEstado_civil, USexo, UEscolaridad, UPlantel, UEstado";
			$this->db->join('nocrol','URol = CROClave', 'left');
			$this->db->where("CROClave NOT IN ('3','10','12')");
			$this->db->where('FIND_IN_SET ("'.$plantel.'",UPlantel)');
			$this->db->where('UNCI_usuario',$idUsuario);
			$this->db->where('UEstado','Activo');
			$this->db->order_by('UNombre', 'ASC');
			$data['docentes'] = $this->usuario_model->find_all(null, $select);

			$selectNom = '
				SUM(UDHoras_grupo)+SUM(UDHoras_CB)+SUM(UDHoras_provicionales) AS HorasTot,
				UDClave, UDUsuario, UDParaescolares, UDPlantel, UDTipo_Nombramiento, UDTipo_materia, 
				UDHoras_grupo, UDHoras_apoyo, UDHoras_CB, UDHoras_provicionales, 
				UDPlaza, UDActivo, UDPermanente, nomplaza, TPClave, TPNombre
			';
			$this->db->join('noctipopersonal','TPClave = UDTipo_Nombramiento','left');
			$this->db->join('noplazadocente','idPlaza = UDPlaza','left');
			$this->db->where('UDUsuario',$idUsuario);
			$this->db->where("UDTipo_Nombramiento IN($UDTipo_Nombramiento,5,6,7,8)"); 
			$this->db->where('UDPlantel',$plantel);
			$this->db->where('UDActivo','1');
			$this->db->group_by('UDTipo_Nombramiento');
			$data['nombramientos'] = $this->usuariodatos_model->find_all(null, $selectNom);
			
			$this->db->join('nolicenciaturas', 'IdLicenciatura = ULLicenciatura','left');
			$this->db->where('ULUsuario',$idUsuario);
			$this->db->where('ULPlantel',$plantel);
			$this->db->where('ULActivo','1');
			//$this->db->limit('1');
			$data['estudios'] = $this->usuariolic_model->find_all(null);

			$this->load->view('plantilla/Mostrar_AsignarMaterias', $data);			

		}

		public function mostrarMaterias_skip() {
			$UDClave  = $this->input->post('UDClave');
			$plantel  = $this->input->post('plantel');
			$periodo  = $this->input->post('periodo');
			$idLic    = $this->input->post('licenciatura');
			$semestre = $this->input->post('semestre');
			$idPlanDetalle = $this->input->post('idPlanDetalle');
			
			if (!$semestre) exit();

			$data['opcion'] = 'materias';
			
			$data['datosPlantilla'] = $this->generarplantilla_model->get($idPlanDetalle);
			
			$tipoMat = $this->usuariodatos_model->get($UDClave);
			
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
					if ($data['datosPlantilla'] ) {
						$this->db->where('id_materia',$data['datosPlantilla']['pidMateria']);
					}

					$this->db->where('id_materia',$mats);
					$this->db->where('semmat',$semestre);
					$this->db->where('plan_estudio',$plan_estudio);
					if($tipoMat['UDParaescolares'] == 'N') {
						$this->db->where('campo_cono', $tipoMat['UDTipo_materia']);				
					}
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

				if (!$arrayAux) exit('Sin datos que Mostrar');

				$data['arrayMaterias'] = $arrayAux;

				$this->load->view('plantilla/Mostrar_materias', $data);		

			}
		}

		public function save() {
			$data = post_to_array('_skip');
			
			if($data['idPlanDetalle']) {
				$data['datosPlantilla'] = $this->generarplantilla_model->get($data['idPlanDetalle']);
			}
			
			$idPlantilla = $this->plantilla_model->plantilla_actual($data['idPPlantel']);

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

			$selsum = 'SUM(ptotalHoras) as horasTotales';
			$this->db->where('idPPlantel',$data['idPPlantel']);
			$this->db->where('idPUsuario',$data['idPUsuario']);
			//$this->db->where('idPUDatos',$data['idPUDatos']);
			$this->db->where('idPlantilla',$idPlantilla);
			$this->db->where('pactivo','1');
			if($data['idPlanDetalle']) {
				$this->db->where("idPlanDetalle != ".$data['idPlanDetalle']);
			}
			$sumNombramiento = $this->generarplantilla_model->find_all(null, $selsum);

			if(nvl($data['spTotal'])) {
				$sumahoras = array_sum(nvl($data['spTotal'])) + $sumNombramiento[0]['horasTotales'];
			}
			if(nvl($data['psemestre']) == '' || nvl($data['pidMateria']) == '') {
				set_mensaje("Favor de ingresar todos los datos.");
				muestra_mensaje();
			} else {
				if ($sumahoras > $totalHoras) {
					set_mensaje("El número de horas exceden al número de horas del Nombramiento.");
					muestra_mensaje();
					
				} else {
						
					foreach ($data['pidMateria'] as $mat => $listS) {
						$this->db->where('idPlantilla', $idPlantilla);
						$this->db->where('idPUDatos', $data['idPUDatos']);
						$this->db->where('idPUsuario', $data['idPUsuario']);
						$this->db->where('pidMateria', $data['pidMateria'][$mat]);
						$this->db->where('pactivo','1');
						$validado = $this->generarplantilla_model->find();
						
						if (empty($validado)) {
							$sel = 'semmat';
							$this->db->where('id_materia', $listS);
							$semmat = $this->materias_model->find_all(null, $sel);
							
							$datos = array(
								'idPPlantel' => $data['idPPlantel'],
								//'idPlantilla' => $idPlantilla,
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
								'pestatus' => 'Activa',
								'pusuario_creacion' => get_session('UNCI_usuario'),
								'pfecha_creacion' => date('Y-m-d H:i:s')
							);
							
							$this->generarplantilla_model->insert($datos);
														
							set_mensaje("Los datos se agregarón correctamente",'success::');
							muestra_mensaje();
							echo "::OK";
							echo "::".$data['idPUsuario'];
							echo "::".$data['datosnom'][0]['UDTipo_Nombramiento'];
						} else {
							if($validado['idPlanDetalle'] == $data['idPlanDetalle']){
								if (!$spTotal[$mat]) {
									$activo = '0';
								} else {
									$activo = '1';
								}
								$datos = array (
									'pnogrupoMatutino' => nvl($matutino[$mat]),
									'pnogrupoVespertino' => nvl($vespertino[$mat]),
									'ptotalHoras' => nvl($spTotal[$mat]),
									'pactivo' => $activo,
								);
								
								$this->generarplantilla_model->update($data['idPlanDetalle'], $datos);
								set_mensaje("Los datos se agregarón correctamente",'success::');
								muestra_mensaje();
								echo "::OK";
								echo "::".$data['idPUsuario'];
								echo "::".$data['datosnom'][0]['UDTipo_Nombramiento'];

							} else {
								
								$sumGrupoMat = 0;
								$sumGrupoMat = $validado['pnogrupoMatutino'] + nvl($matutino[$mat]);
								$sumGrupoVes = 0;
								$sumGrupoVes = $validado['pnogrupoVespertino'] + nvl($vespertino[$mat]);
								$sumTotalHoras = 0;
								$sumTotalHoras = $validado['ptotalHoras'] + nvl($spTotal[$mat]);
								
								$datos = array (
									'pnogrupoMatutino' => $sumGrupoMat,
									'pnogrupoVespertino' => $sumGrupoVes,
									'ptotalHoras' => $sumTotalHoras,
								);
								
								$this->generarplantilla_model->update($validado['idPlanDetalle'], $datos);
								set_mensaje("Los datos se agregarón correctamente",'success::');
								muestra_mensaje();
								echo "::OK";
								echo "::".$data['idPUsuario'];
								echo "::".$data['datosnom'][0]['UDTipo_Nombramiento'];
							}
						}
					}
				}
			}			
		}
		
		public function datosPlantilla_skip() {
			$idPUsuario = $this->input->post('idPUsuario');
			$idPlantel = $this->input->post('idPlantel');
			$data['periodos'] = $this->input->post('periodo');

			$data['UDTipo_Nombramiento'] = $this->input->post('UDTipo_Docente');

			$data['opcion'] = 'plantilla';

			$idPlantilla = $this->plantilla_model->plantilla_actual($idPlantel);
			$data['datosPlantilla'] = $this->plantilla_model->get($idPlantilla);
			
			$select = 'UDClave, UDUsuario, UDPlantel, UDTipo_Nombramiento, UDFecha_ingreso, UDHoras_grupo, UDHoras_apoyo, UDHoras_CB, UDHoras_provicionales, UDPlaza, UDFecha_inicio, UDFecha_final, UDObservaciones, UDValidado';
			$this->db->where('UDUsuario', $idPUsuario );
			$this->db->where('UDPlantel', $idPlantel);

			$data['datos'] = $this->usuariodatos_model->find_all(null, $select);

			foreach ($data['datos'] as $d => $listDat) {
				$selectPlant = 'idPlanDetalle, idPlantilla, idPUsuario, idPPlantel, idPUDatos, pidLicenciatura, pperiodo, psemestre, pnogrupoMatutino, pnogrupoVespertino, ptotalHoras, pestatus, pidMateria, materia, hsm, plan_estudio, semmat, idPBitacora, pbObservaciones';
				$this->db->join('nomaterias', 'id_materia = pidMateria', 'left');
				$this->db->join('noplantillabitacora', 'idPlanDetalle = idBPlanDetalle', 'left');
				$this->db->where('idPUDatos', $listDat['UDClave']);
				$this->db->where('idPlantilla', $idPlantilla);
				$this->db->where('pactivo', '1');
				$this->db->order_by('idPUDatos','ASC');
				$this->db->order_by('psemestre','ASC');
				
				$data['datos'][$d]['plantilla'] = $this->generarplantilla_model->find_all(null, $selectPlant);
			}
			
			$this->load->view('plantilla/Mostrar_materias', $data);	
		}

		public function verplantilla() {
			
			$this->db->where('PClave', $this->input->post('idPlantilla'));
			$data['plantilla'] = $this->plantilla_model->find();
						
			$select = 'PClave, idPlanDetalle, PPlantel, noplantilla.PPeriodo, pd.idPUsuario, noplantilla.PEstatus,
			UDClave, UDUsuario, UDPlantel, UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, URFC, UDTipo_Nombramiento';
			$this->db->where("PClave",$data['plantilla']['PClave']);
			$this->db->join("noplantilladetalle AS pd","PClave = idPlantilla","LEFT");
			$this->db->join('nousuario','UNCI_usuario = idPUsuario','LEFT');
			$this->db->join('nousuariodatos','idPUsuario = UDUsuario','LEFT');
			$this->db->group_by('UNCI_usuario');
			$data['docentes'] = $this->plantilla_model->find_all(null, $select);
			$data['contarDoc'] = count($data['docentes']);

			$idPlantel 	= $data['docentes'][0]['PPlantel'];
			$periodo	= $data['docentes'][0]['PPeriodo'];
			$data['doc'] = $this->usuariodatos_model->nombramientos($idPlantel, $data['docentes'][0]['UDTipo_Nombramiento']);
			$data['DocPlan'] = count($data['doc']);

			$this->db->select('CPLClave, CPLNombre, CPLCCT, CPLCorreo_electronico, CPLDirector');
        	$data['plantel'] = $this->plantel_model->get($idPlantel);
			
			$data['periodo'] = periodo($periodo);
			
			
			foreach ($data['docentes'] as $u => $listUser) {
				$select = "UDClave, UDFecha_ingreso, UDTipo_Nombramiento, TPNombre, UDTipo_materia, UDHoras_grupo, UDHoras_apoyo, UDHoras_CB, UDHoras_provicionales, (`UDHoras_grupo`+`UDHoras_apoyo`) AS TotalHoras, UDPlaza, nomplaza, UDFecha_inicio, UDFecha_final, UDObservaciones,UDNumOficio";
				$this->db->join('noctipopersonal', 'UDTipo_Nombramiento = TPClave', 'left');
				$this->db->join('noplazadocente', 'UDPlaza = idPlaza', 'left');
				$this->db->where('UDUsuario',$listUser['UNCI_usuario']);
				$this->db->where('UDPlantel',$listUser['UDPlantel']);
				$this->db->order_by('UDTipo_Nombramiento','ASC');
				$this->db->where('UDActivo','1');
				
				$data['docentes'][$u]['plazas'] = $this->usuariodatos_model->find_all(null, $select);

				$selects = "ULClave, ULNivel_estudio, ULLicenciatura, LGradoEstudio, Licenciatura, ULCedulaProf, ULTitulado";
				$this->db->join('nolicenciaturas','IdLicenciatura = ULLicenciatura','left');
				$this->db->where('ULUsuario',$listUser['UNCI_usuario']);
				$this->db->where('ULPlantel',$listUser['UDPlantel']);

				$data['docentes'][$u]['estudios'] = $this->usuariolic_model->find_all(null, $selects);

				$selectMat = "idPlanDetalle, idPlantilla, idPUDatos, pidLicenciatura, pperiodo, psemestre, pidMateria, materia, hsm, pnogrupoMatutino, pnogrupoVespertino, ptotalHoras";
				$this->db->join('nomaterias','id_materia = pidMateria','left');
				$this->db->where('idPUsuario',$listUser['UNCI_usuario']);
				$this->db->where('idPPlantel',$listUser['UDPlantel']);
				$this->db->where('idPlantilla',$data['plantilla']['PClave']);
				$this->db->where('pactivo','1');
				$this->db->order_by('idPUDatos','ASC');
				$this->db->order_by('psemestre','ASC');

				$data['docentes'][$u]['materias'] = $this->generarplantilla_model->find_all(null, $selectMat);

				$selectHoras = 
				"SUM(UDHoras_grupo) UDHoras_grupo, SUM(UDHoras_apoyo) UDHoras_apoyo, SUM(UDHoras_CB) UDHoras_CB, SUM(UDHoras_provicionales) UDHoras_provicionales, 
				(`UDHoras_grupo`+`UDHoras_apoyo`) AS TotalHoras, 
				(SELECT SUM(ptotalHoras) FROM noplantilladetalle WHERE idPUsuario = ".$listUser['UNCI_usuario']." AND idPPlantel = ".$listUser['UDPlantel']." AND idPlantilla = ".$data['plantilla']['PClave']." AND pactivo = 1) AS totalHoras";
				$this->db->where('UDUsuario',$listUser['UNCI_usuario']);
				$this->db->where('UDPlantel',$listUser['UDPlantel']);
				$this->db->where('UDActivo','1');

				$data['docentes'][$u]['horas'] = $this->usuariodatos_model->find_all(null, $selectHoras);

			}
			
			$data['FLogo_cobaemex'] = "logo_cobaemex_2018.png";
			$this->load->view('plantilla/Ver_plantilla_view', $data);
		}

		public function revisarPlantilla () {
			$data = post_to_array('_skip');
			
			$datos = array(
				'PEstatus' => 'Revision'
			);
			//$this->plantilla_model->update($data['idPlantilla'], $datos);

			foreach ($data['UDClave'] as $x => $listIds) {

				$pldatos = array (
					'pestatus' => 'Revision',
					'pusuario_envio' => get_session('UNCI_usuario'),
					'pfecha_envio' => date('Y-m-d H:i:s')
				);
				
				$this->db->set($pldatos);
				$this->db->where('idPUDatos', $listIds);
				$this->db->where('idPlantilla', $data['idPlantilla']);
				//$this->db->update('noplantilladetalle');
			}

			set_mensaje("Los Plantilla se envio correctamente a Revisión.",'success::');
			muestra_mensaje();
			echo "::OK";
			echo "::".$data['idPlantilla'];			
			
		}

		function enviarCorrecciones_skip() {
			$data = post_to_array('_skip');
			
			foreach ($data['idPlanDetalle'] as $x => $ids) {
				if (nvl($data[$ids]) != '' ) {
					$pldatos = array (
						'idBPlantilla' => $data['idPlantilla'], //Validado
						'idBPlanDetalle' =>  $ids,
						'pbObservaciones' =>$data[$ids],
						'pbusuario' => get_session('UNCI_usuario'),
						'pbfecha' => date('Y-m-d H:i:s')

					);

					$this->plantillabitacora_model->insert($pldatos);
					
					$this->db->where('idPlanDetalle',$ids);
					$idUDatos = $this->generarplantilla_model->find();
					/*$updatos = array (
						'UDValidado' => '4'
					);
					//Cambiar estatus en Datos del Usuario a 4 Correccion
					$this->usuariodatos_model->update($idUDatos['idPUDatos'], $updatos);*/
				}

				$datos = array (
					'pestatus' => 'Corregir',
					'pusuario_revision' => get_session('UNCI_usuario'),
					'pfecha_revision' => date('Y-m-d H:i:s')
				);

				//Cambiar estatus en plantilla Detalle a Revisado, habilitar correciones
				$this->db->set($datos);
				$this->db->where('idPlantilla', $ids);
				$this->db->update('noplantilladetalle');
				

			}
			
			set_mensaje("Las Observaciones se enviaron correctamente al Plantel.",'success::');
			muestra_mensaje();
			echo "::OK";
			echo "::".$data['idPlantilla'];
					
			
		}

		public function exportarExcel_skip() {
			$this->load->view('plantilla/ExportarExcel');
		}
    }
?>