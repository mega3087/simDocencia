<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class NuevaPlantilla extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			//if ( ! is_permitido())
				//redirect('usuario/negar_acceso');
		}

        public function index(){
			
			$data = array();
			
			/*filtrar por planteles
			if( is_permitido(null,'personal','ver_todos') ){
			}elseif( is_permitido(null,'personal','ver_plantel') ){
				$this->db->where("PPlantel IN(".get_session('UPlanteles').")");
			}*/
			
			//contar todos los registros sin limit
			if( is_permitido(null,'personal','ver_todos') ){
                $this->db->where('CPLTipo != 37');
				$this->db->order_by('CPLNombre','ASC');
				$data['planteles'] = $this->plantel_model->find_all("CPLActivo = '1'");
			}elseif( is_permitido(null,'personal','ver_plantel') ){
                $this->db->where('CPLTipo != 37');
				$this->db->order_by('CPLNombre','ASC');
				$data['planteles'] = $this->plantel_model->find_all("CPLClave IN(".get_session('UPlanteles').") and CPLActivo = '1'");
			}
			
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'plantilla/Mostrar_view2';			
			$this->load->view('plantilla_general', $data);
		}

		public function crear ($plantel = null) {
			
			$plantel = $this->encrypt->decode($plantel);
			$data['plantel'] = $plantel;
			$data['titulo'] = 'CREAR PLANTILLA';
			$data['planteles'] = $this->plantel_model->find_all("CPLClave IN(".$plantel.")");
			
			$selectU = "UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, UFecha_nacimiento, UCorreo_electronico, URFC, UCURP, UClave_elector, UDomicilio, UColonia, UMunicipio, UCP, UTelefono_movil, UTelefono_casa, ULugar_nacimiento, UEstado_civil, USexo, UEscolaridad, UPlantel, UEstado, UFecha_registro";
			$this->db->join('nocrol','URol = CROClave');
			$this->db->where("CROClave NOT IN ('3','10','12')");
			$this->db->where('FIND_IN_SET ("'.$plantel.'",UPlantel)');
			//$this->db->where('UTipoDocente','D');
			$this->db->order_by('UNombre', 'ASC');
			$data['docentes'] = $this->usuario_model->find_all(null, $selectU);

			$data['estado_civil'] = $this->estciv_model->find_all();

			$selectEst = 'IdLicenciatura, LGradoEstudio';
			$this->db->group_by('LGradoEstudio');   
			$this->db->order_by('LGradoEstudio', 'ASC');
			$data['estudios'] = $this->licenciaturas_model->find_all(null, $selectEst);
			
			$this->db->where('LIdentificador !=','0');
			$this->db->group_by('Licenciatura');
			$this->db->order_by('Licenciatura', 'ASC');
			$data['carreras'] = $this->licenciaturas_model->find_all();

			$selectNom = 'PLClave, PLTipo, PLTipo_plantel, PLTipo_clase, PLPuesto';
			if ($data['planteles'][0]['CPLTipo'] == 35) {
				$this->db->where('PLTipo_plantel', 'Plantel');
				$this->db->where('PLTipo_clase', 'Profesor');
				$this->db->or_where('PLTipo_clase', 'Tecnico');
			} elseif ($data['planteles'][0]['CPLTipo'] == 36) {
				$this->db->where('PLTipo_plantel', 'Centro');
				$this->db->where('PLTipo_clase', 'Profesor');
			}
			
			$data['nombramiento'] = $this->plaza_model->find_all(null, $selectNom);
			$data['modulo'] = $this->router->fetch_class();
			$data['subvista'] = 'plantilla/Crear_view';
			$this->load->view('plantilla_general', $data);
		}

		public function MostrarCarreras() {
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
				<select name="UPLicenciatura" id="UPLicenciatura" class="form-control">
					<option value="">- Especialidad -</option>
					<?php foreach ($data['carreras']  as $k => $listCar) { ?>
						<option value="<?= $listCar['IdLicenciatura'] ?>"><?= $listCar['Licenciatura'] ?></option>    
					<?php } ?>
				</select>
			
				<?php
			}
		}
		
		public function uploads() {
			$filename = $_FILES['file']['name'];
			echo $_POST['idUsuario'];
			echo $_POST['idPlantel'];
			
			/* Choose where to save the uploaded file */
			$location = "uploads/".$filename;
			/* Save the uploaded file to the local filesystem */
			if ( move_uploaded_file($_FILES['file']['tmp_name'], $location) ) {
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
				echo "vacio";
				echo $this->input->post('UCURP').'<br>';
				echo json_encode($data);
			} else {
				$idUser = $this->input->post('idUsuario');
				echo $idUser;
			}
			
			exit;
			if($this->input->post('idUsuario')) {
				echo "hola";
				$idUser = $this->input->post('FClave_skip');
				$datosUser = array(
					'UCURP' => $data['UCURP'], 
					'UNombre' => $data['UNombre'], 
					'UApellido_pat' => $data['UApellido_pat'], 
					'UApellido_mat' => $data['UApellido_mat'], 
					'URFC' => $data['URFC'], 
					'UFecha_ingreso' => $data['UFecha_ingreso']
				);
				//$this->usuario_model->update($idUser,$datosUser);
				if ($this->input->post('Titulado')== 'Titulado') {
					echo "aqui";
					$this->db->where('ULUsuario',$idUser);
					$nolic = $this->usuariolic_model->find_all();
					if (count($nolic) == '0'){
						$dataTitulado = array(
							'ULUsuario' => $idUser,
							'ULPlantel' => $plantel,
							'ULNivel_estudio' => $data['UPNivel_estudio'], 
							'ULLicenciatura' => $data['UPLicenciatura'], 
							'ULCedulaProf' => $data['UPCedulaProf'], 
							'ULNombramiento' => $data['UPNombramiento'],
							'ULActivo' => 1,
							'ULUsuarioRegistro' => get_session('UNCI_usuario'),
							'ULFechaRegistro' => date('Y-m-d H:i:s')
						);
					//	echo json_encode($dataTitulado);
					} else {
						//echo "modificar";
					}
				}
				
				//$this->docper_model->insert($data_dp);
				echo json_encode($data);
				
			}

			echo "::".$idUser;
			echo "::"."Se guardarpn los datos correctos";
		}
    }
?>