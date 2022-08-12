<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docente extends CI_Controller {
    public function __contruct () {
        $this->load->helper('file');
        $this->load->helper('url');

        parent::__construct();
        if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');

        if (!is_permitido()) //  Verificamos que el usuario tenga permisos
            redirect('usuario/negar_acceso');
    }

    public function index() {
        $data = array();
        /*if(is_permitido(null,'Docente','ver_planteles') && get_session('URol') == '6') {
            redirect('Docente/mostrarDocentes');
        }*/

        $select = 'CPLClave, CPLNombre, CPLCCT, CPLCorreo_electronico, CPLDirector';
        $this->db->where('CPLTipo',35);
        $this->db->or_where('CPLTipo',36);
        $this->db->where('CPLActivo',1);
        $this->db->order_by('CPLClave','ASC');
        
        $data['planteles'] = $this->plantel_model->find_all(null, $select);

        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'docentes/Mostrar_view';

        $this->load->view('plantilla_general', $data);
    }

    public function ver_planteles($idPlantel = null, $tipoDocente = null) {
        $data = array();
        $idPlantel = $this->encrypt->decode($idPlantel);
        if (!$idPlantel) {
            $idPlantel = get_session('UPlantel');
        }        
        $data['tipoDoc'] = $this->encrypt->decode($tipoDocente);
                
        $selectP = 'CPLClave, CPLNombre, CPLTipo';
        $this->db->where('CPLClave',$idPlantel);
        $data['plantel'] = $this->plantel_model->find_all(null, $selectP);

        $this->db->where('UDTipo_docente',$data['tipoDoc']);
        $this->db->where('UDPlantel',$idPlantel);
        $data['datosUser'] = $this->usuariodatos_model->find_all();

        //echo json_encode($data['datosUser']);
        //exit;
        
        $selectU = "UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, UFecha_nacimiento, UCorreo_electronico, URFC, UCURP, UClave_elector, UDomicilio, UColonia, UMunicipio, UCP, UTelefono_movil, UTelefono_casa, ULugar_nacimiento, UEstado_civil, USexo, UEscolaridad, UPlantel, UEstado, UFecha_registro";
        $this->db->join('nocrol','URol = CROClave');
        $this->db->where("UEstado",'Activo');
        $this->db->where("CROClave NOT IN ('3','10','12')");
        $this->db->where('FIND_IN_SET ("'.$idPlantel.'",UPlantel)');
        $this->db->order_by('UNombre', 'ASC');
        $data['docentes'] = $this->usuario_model->find_all(null, $selectU);
        
        /*foreach ($data['docentes'] as $k => $doc) {
            $selectD = '`UDClave`, `UDTipo_Docente`, `UDActivo`, TPClave, `TPNombre`, `UDPlaza`, PLPuesto, `UDPlaza_file`, `UDOficio_file`, `UDCurriculum_file`, `UDCURP_file`';

            $this->db->join('noctipopersonal','UDTipo_Docente = TPClave', 'LEFT');
            $this->db->join('noplaza','PLClave = UDPlaza', 'LEFT');
            $this->db->where('UDUsuario',$doc['UNCI_usuario']);
            $this->db->where('UDPlantel', $idPlantel);

            $data['docentes'][$k]['datosDocentes'] = $this->usuariodatos_model->find_all(null, $selectD);
        }*/
        
        //echo json_encode($data['docentes']);
        //exit;

        $data['estado_civil'] = $this->estciv_model->find_all();
        $data['tipoDocente'] = $this->tipopersonal_model->find_all();

        $selectNom = 'PLClave, PLTipo, PLTipo_plantel, PLTipo_clase, PLPuesto';
        if ($data['plantel'][0]['CPLTipo'] == 35) {
            $this->db->where('PLTipo_plantel', 'Plantel');
            $this->db->where('PLTipo_clase', 'Profesor');
            $this->db->or_where('PLTipo_clase', 'Tecnico');
        } elseif ($data['plantel'][0]['CPLTipo'] == 36) {
            $this->db->where('PLTipo_plantel', 'Centro');
            $this->db->where('PLTipo_clase', 'Profesor');
        }
        
        $data['nombramiento'] = $this->plaza_model->find_all(null, $selectNom);
        
        $selectEst = 'IdLicenciatura, LGradoEstudio';
        $this->db->group_by('LGradoEstudio');   
        $this->db->order_by('LGradoEstudio', 'ASC');
        $data['estudios'] = $this->licenciaturas_model->find_all(null, $selectEst);

        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'docentes/Mostrar_docentes';

        $this->load->view('plantilla_general', $data);
    }

    public function Update($idPlantel = null, $idUser = null, $tipoDoce = null) {
        $idPlantel = $this->encrypt->decode($idPlantel);
        $idUser = $this->encrypt->decode($idUser);
        $tipoDoce = $this->encrypt->decode($tipoDoce);
  
        $data['tipoDoce'] = $tipoDoce;
        if($idUser != '0') {
            //$this->db->join('nousuariodatos','UNCI_usuario = UDUsuario', 'LEFT');
            $this->db->where('UNCI_usuario', $idUser);
            $this->db->where('FIND_IN_SET ("'.$idPlantel.'",UPlantel)');
            $data['usuario'] = $this->usuario_model->find_all();
        }
        
        $data['estado_civil'] = $this->estciv_model->find_all();

        $data['tipoDocente'] = $this->tipopersonal_model->find_all();
        
        $selectP = 'CPLClave, CPLNombre, CPLTipo';
        $this->db->where('CPLClave',$idPlantel);
        
        $data['plantel'] = $this->plantel_model->find_all(null, $selectP);
        
        $selectNom = 'PLClave, PLTipo, PLTipo_plantel, PLTipo_clase, PLPuesto';
			if ($data['plantel'][0]['CPLTipo'] == 35) {
				$this->db->where('PLTipo_plantel', 'Plantel');
				$this->db->where('PLTipo', 'Docente');
			} elseif ($data['plantel'][0]['CPLTipo'] == 36) {
				$this->db->where('PLTipo_plantel', 'Centro');
				$this->db->where('PLTipo', 'Docente');
			}
			
		$data['nombramiento'] = $this->plaza_model->find_all(null, $selectNom);

        $selectEst = 'IdLicenciatura, LGradoEstudio';
        $this->db->group_by('LGradoEstudio');   
        $this->db->order_by('LGradoEstudio', 'ASC');
        $data['estudios'] = $this->licenciaturas_model->find_all(null, $selectEst);

        $this->db->where('LIdentificador !=','0');
        $this->db->group_by('Licenciatura');
        $this->db->order_by('Licenciatura', 'ASC');
        $data['carreras'] = $this->licenciaturas_model->find_all();

        $this->db->order_by('nomplaza','ASC');
        $data['plazas'] = $this->plazadocente_model->find_all();
        
        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'docentes/Mostrar_Update';

        $this->load->view('plantilla_general', $data);
    }

    public function savePlazas() {
        $data = post_to_array('_skip');
        echo json_encode($data);
        exit;
        if ($data['UDFecha_ingreso'] == '' || $data['UDTipo_Docente'] == '' || $data['UDPlaza'] == '' || $data['UDNumOficio'] == '') {
            set_mensaje("Favor de ingresar todos los datos requeridos.");
            muestra_mensaje();
        } else {
            $nom = $_POST['UDUsuario'].date("dmY").'.pdf';
            $directorio = "./Documentos/Docentes/Nombramientos/".$_POST['UDUsuario']."/";
        
            //Subir Nombramiento
            $nomNombramiento = 'Nombramiento';
            $fileNombramiento = $nomNombramiento.$nom;
            $targetFileNombramiento = $directorio . $fileNombramiento;
            
            //Subir Oficio de Petición
            $nomOficio = 'Oficio';
            $fileOficio = $nomOficio.$nom;
            $targetFileOficio = $directorio . $fileOficio;

            //Subir Curriculum
            $nomCurriculum = 'Curriculum';
            $fileCurriculum = $nomCurriculum.$nom;
            $targetFileCurriculum = $directorio . $fileCurriculum;

            //Subir CURP
            $nomCURP = 'CURP';
            $fileCURP = $nomCURP.$nom;
            $targetFileCURP = $directorio . $fileCURP;

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $datos['UDUsuario'] = $data['UDUsuario'];
            $datos['UDPlantel'] = $data['UDPlantel'];
            $datos['UDFecha_ingreso'] = $data['UDFecha_ingreso'];
            $datos['UDTipo_Docente'] = $data['UDTipo_Docente'];
            $datos['UDTipo_materia'] = $data['UDTipo_materia'];
            $datos['UDHoras_grupo'] = $data['UDHoras_grupo'];
            $datos['UDHoras_apoyo'] = $data['UDHoras_apoyo'];
            $datos['UDHorasAdicionales'] = $data['UDHorasAdicionales'];
            $datos['UDPlaza'] = $data['UDPlaza'];
            $datos['UDNumOficio'] = $data['UDNumOficio'];

            if(isset($_FILES["UDPlaza_file"])){
                //Con datos
                move_uploaded_file($_FILES["UDPlaza_file"]["tmp_name"], $targetFileNombramiento);
                $datos['UDPlaza_file'] = $targetFileNombramiento;
            }
            if(isset($_FILES["UDOficio_file"])){
                //Con datos
                move_uploaded_file($_FILES["UDOficio_file"]["tmp_name"], $targetFileOficio);
                $datos['UDOficio_file'] = $targetFileOficio;
            }
            if(isset($_FILES["UDCurriculum_file"])){
                //Con datos
                move_uploaded_file($_FILES["UDCurriculum_file"]["tmp_name"], $targetFileCurriculum);
                $datos['UDCurriculum_file'] = $targetFileCurriculum;
            }
            if(isset($_FILES["UDCURP_file"])){
                //Con datos
                move_uploaded_file($_FILES["UDCURP_file"]["tmp_name"], $targetFileCURP);
                $datos['UDCURP_file'] = $targetFileCURP;
            }
            
            $datos['UDActivo'] = '1';
            $datos['UDUsuario_registro'] = get_session('UNCI_usuario');
            $datos['UDFecha_registro'] = date('Y-m-d H:i:s');
            $this->usuariodatos_model->insert($datos);
            set_mensaje("La plaza del Docente se guardo correctamente.",'success::');
            muestra_mensaje();
            echo "::OK";
            echo "::".$data['UDUsuario'];
        }
        
        

        /*$this->db->where('UDPlantel', $data['UDPlantel']);
        $this->db->where('UDUsuario', $data['UDUsuario']);
        $contar = $this->usuariodatos_model->find_all();
        
        if (count($contar) == 0){
            $this->usuariodatos_model->insert($datos);
            echo ";".$data['UDUsuario'];
        } else {
            $datos['UDUsuarioModificacion'] = get_session('UNCI_usuario');
            $datos['UDFechaModificacion'] = date('Y-m-d H:i:s');
            $this->usuariodatos_model->update($contar[0]['UDClave'],$datos);
            echo ";".$data['UDUsuario'];
        }*/
    }    

    public function mostrarPlazas () {
        $idUsuario = $this->input->post('idUsuario');
        $idPlantel = $this->input->post('idPlantel');
        
        $this->db->join('noplazadocente','idPlaza = UDPlaza','left');
        $this->db->join('noctipopersonal',' UDTipo_Docente = TPClave','left');

        $this->db->where('UDUsuario',$idUsuario);
        $this->db->where('UDPlantel',$idPlantel);
        $this->db->where('UDActivo','1');
        $data['data'] = $this->usuariodatos_model->find_all();
        
        $this->load->view('docentes/Mostrar_plazas', $data);
    }

    public function deletePlazas(){
        $idUsuario = $this->input->post('idUsuario');
        $idPlantel = $this->input->post('idPlantel');

        $UDClave = $this->encrypt->decode($this->input->post('UDClave'));
        $data = array(
            'UDActivo' => '0',
            'UDUsuario_baja' => get_session('UNCI_usuario'),
            'UDFecha_baja' => date('Y-m-d H:i:s')
        );
        
        $this->usuariodatos_model->update($UDClave,$data);
        set_mensaje("La plaza del Docente se elimino correctamente.",'success::');
        muestra_mensaje();
        
        $this->db->join('noplazadocente','idPlaza = UDPlaza');
        $this->db->join('noctipopersonal',' UDTipo_Docente = TPClave');

        $this->db->where('UDUsuario',$idUsuario);
        $this->db->where('UDPlantel',$idPlantel);
        $this->db->where('UDActivo','1');
        $data['data'] = $this->usuariodatos_model->find_all();

        $this->load->view('docentes/Mostrar_plazas', $data);
    }

    public function saveEstudios() {
        $data= post_to_array('_skip');

        //Subir Titulo Profesional
        $nom = date("dmY").'.pdf';
        $directorio = "./Documentos/Docentes/Licenciaturas/".$data['ULUsuario']."/";

        $nomTitulo = 'Titulo'.$_POST['ULUsuario'];
        $fileTitulo = $nomTitulo.$nom;
        $targetFileTitulo = $directorio . $fileTitulo;
        
        //Subir Cedula Profesional
        $nomCedula = 'Cedula'.$_POST['ULUsuario'];
        $fileCedula = $nomCedula.$nom;
        $targetFileCedula = $directorio . $fileCedula;
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }
        
        if ($data['ULTitulado'] == 'Titulado') {
            $datos['ULUsuario'] = $data['ULUsuario'];
            $datos['ULPlantel'] = $data['ULPlantel'];
            $datos['ULNivel_estudio'] = $data['ULNivel_estudio'];
            $datos['ULLicenciatura'] = $data['ULLicenciatura'];
            if(isset($_FILES["ULTitulo_file"])){
                //Con datos
                move_uploaded_file($_FILES["ULTitulo_file"]["tmp_name"], $targetFileTitulo);
                $datos['ULTitulo_file'] = $targetFileTitulo;
            }
            if(isset($_FILES["ULCedula_file"])){
                //Con datos
                move_uploaded_file($_FILES["ULCedula_file"]["tmp_name"], $targetFileCedula);
                $datos['ULCedula_file'] = $targetFileCedula;
            }
                    
            $datos['ULCedulaProf'] = $data['ULCedulaProf'];
            $datos['ULTitulado'] = $data['ULTitulado'];
            $datos['ULActivo'] = '1';
            $datos['ULUsuarioRegistro'] = get_session('UNCI_usuario');
            $datos['UlFechaRegistro'] = date('Y-m-d H:i:s');
                
            $this->usuariolic_model->insert($datos);
            echo ";".$data['ULUsuario'];

        } else {
            $datos['ULUsuario'] = $data['ULUsuario'];
            $datos['ULPlantel'] = $data['ULPlantel'];
            $datos['ULNivel_estudio'] = $data['ULNivel_estudio'];
            $datos['ULLicenciatura'] = $data['ULLicenciatura'];
            $datos['ULTitulado'] = $data['ULTitulado'];
            $datos['ULActivo'] = '1';
            $datos['ULUsuarioRegistro'] = get_session('UNCI_usuario');
            $datos['UlFechaRegistro'] = date('Y-m-d H:i:s');
            $this->usuariolic_model->insert($datos);
            echo ";".$data['ULUsuario'];
        }
        
    }

    public function mostrarEstudios () {
        $idUsuario = $this->input->post('idUsuario');
        $idPlantel = $this->input->post('idPlantel');
        
        $selectDatos = "ULClave, ULUsuario, ULPLantel, ULNivel_estudio, ULLicenciatura, Licenciatura, ULTitulo_file, ULCedula_file, ULTitulado, ULCedulaProf, ULActivo";
        $this->db->join('nolicenciaturas','ULLicenciatura = IdLicenciatura');

        $this->db->where('ULUsuario',$idUsuario);
        $this->db->where('ULPlantel',$idPlantel);
        $this->db->where('ULActivo','1');
        $data['data'] = $this->usuariolic_model->find_all(null, $selectDatos);
        
        $this->load->view('docentes/Mostrar_estudios', $data);
    }   

    public function deleteEstudios() {
        $idUsuario = $this->input->post('idUsuario');
        $idPlantel = $this->input->post('idPlantel');

        $ULClave = $this->encrypt->decode($this->input->post('ULClave'));
        $data = array(
            'ULActivo' => '0',
            'ULUsuarioModificacion' => get_session('UNCI_usuario'),
            'ULFechaModificacion' => date('Y-m-d H:i:s')
        );
        
        $this->usuariolic_model->update($ULClave,$data);
        set_mensaje("Los datos del usuario se eliminaron correctamente.",'success::');
        muestra_mensaje();

        $idUsuario = $this->input->post('idUsuario');
        $idPlantel = $this->input->post('idPlantel');
        
        $selectDatos = "ULClave, ULUsuario, ULPLantel, ULNivel_estudio, ULLicenciatura, Licenciatura, ULTitulo_file, ULCedula_file, ULTitulado, ULCedulaProf, ULActivo";
        $this->db->join('nolicenciaturas','ULLicenciatura = IdLicenciatura');

        $this->db->where('ULUsuario',$idUsuario);
        $this->db->where('ULPlantel',$idPlantel);
        $this->db->where('ULActivo','1');
        $data['data'] = $this->usuariolic_model->find_all(null, $selectDatos);

        $this->load->view('docentes/Mostrar_estudios', $data);
    }
    
    public function Save() {
        $data = post_to_array('_skip');

        if (isset($data)){
            $user = array(
                'UNombre' => $data['UNombre'],
                'UApellido_pat' => $data['UApellido_pat'],
                'UApellido_mat' => $data['UApellido_mat'],
                'UCURP' => $data['UCURP'],
                'UFecha_nacimiento' => $data['UFecha_nacimiento'],
                'URFC' => $data['URFC'],
                'UDomicilio' => $data['UDomicilio'],
                'UColonia' => $data['UColonia'],
                'UMunicipio' => $data['UMunicipio'],
                'UCP' => $data['UCP'],
                'UTelefono_movil' => $data['UTelefono_movil'],
                'UTelefono_casa' => $data['UTelefono_casa'],
                'UCorreo_electronico' => $data['UCorreo_electronico'],
                'ULugar_nacimiento' => $data['ULugar_nacimiento'],
                'UEstado_civil' => $data['UEstado_civil'],
                'USexo' => $data['USexo'],
                'UPlantel' => $data['UPlantel'],
                'URol' => 7,
                'UEstado' => 'Activo',
                'UFecha_registro' => date('Y-m-d H:i:s'),
                'UUsuario_registro' => get_session('UNCI_usuario')
            );

            if ($data['UNCI_usuario'] == ''){                
                $id = $this->usuario_model->insert($user);
                set_mensaje("El Docente se guardo con éxito",'success::');
                echo"::$id";
                echo"::OK";
            } else {
                $this->usuario_model->update($data['UNCI_usuario'],$user);
                //set_mensaje("Se modificaron con éxito",'success::');
                echo '::'.$data['UNCI_usuario']; 
                echo"::OK";
            }
        } 
    }

    public function delete() {
        $data = array();
        $UNCI_usuario = $this->encrypt->decode($this->input->post('UNCI_usuario_skip'));
        $UNCI_plantel = $this->input->post('PlantelId');
        
        $select = 'UNCI_usuario, UPlantel';
        $this->db->where('UNCI_usuario', $UNCI_usuario);
        $datos = $this->usuario_model->find_all(null, $select);
        
        foreach ($datos as $k => $listP) {
        $ids = explode(',', $listP['UPlantel']);
            if (count($ids) == 1 ) {
                //$data['UPlantel'] = '';
                $data['UEstado'] = "Inactivo";
                } else {
                foreach ($ids as $y => $ids) {
                    if ($ids != $UNCI_plantel) {
                        $result[$y] = $ids;
                        $results = implode(',', $result);
                        $data['UPlantel'] = $results;
                    }
                }
            }
        }
        $this->usuario_model->update($UNCI_usuario, $data);
        set_mensaje("El docente se quito correctamente de su Plantel",'success::');
        echo "OK";
    }

    public function ver_curp(){
        $curp =  new Curp;
            
        $micurp = $this->input->post('UCURP');
        $curp->setMicurp($micurp);
        
        $result = $curp->getCurp(0);
        if(nvl($result['error'])==0){
            echo "OK|";
            echo $result['apellido1']."|";
            echo $result['apellido2']."|";
            echo $result['nombres']."|";
            echo $result['fechanac']."|";
            echo $result['sexo']."|";
        } else {
            echo nvl($result['tipo']);
        }
    }

    public function mostrarCarreras() {
        $nivel =  $this->input->post('tipo');
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

    public function datosnombramiento_skip() {
        $datos = array();
        $idPlaza =  $this->input->post('idPlaza');
        
        $this->db->where('idPlaza',$idPlaza);
        $datos = $this->plazadocente_model->find_all();

        echo '::'.$datos[0]['horas_grupo'];
        echo '::'.$datos[0]['horas_apoyo'];
        echo '::'.$datos[0]['tipo_materia'];
    }

}
?>