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
        if(get_session('URol') == '16') {
            redirect('Docente/ver_docentes');
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
        $data['subvista'] = 'docentes/Mostrar_view';

        $this->load->view('plantilla_general', $data);
    }

    public function ver_docentes($idPlantel = null) {
        $data = array();

        $idPlantel = $this->encrypt->decode($idPlantel);
        if ($idPlantel == '') {
            $idPlantel = get_session('UPlantel');
        }
                
        $selectP = 'CPLClave, CPLNombre, CPLTipo';
        $this->db->where('CPLClave',$idPlantel);
        $data['plantel'] = $this->plantel_model->find_all(null, $selectP);

        //$this->db->where('UDTipo_Nombramiento',$data['tipoDoc']);
        $this->db->where('UDPlantel',$idPlantel);
        $data['datosUser'] = $this->usuariodatos_model->find_all();
        
        $selectU = "UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, UFecha_nacimiento, UCorreo_electronico, URFC, UCURP, UClave_elector, UDomicilio, UColonia, UMunicipio, UCP, UTelefono_movil, UTelefono_casa, ULugar_nacimiento, UEstado_civil, USexo, UEscolaridad, UPlantel, UEstado, UFecha_registro";
        $this->db->join('nocrol','URol = CROClave');
        
        $this->db->where("UEstado",'Activo');
        $this->db->where("CROClave NOT IN ('3','10','12')");
        $this->db->where('FIND_IN_SET ("'.$idPlantel.'",UPlantel)');
        $this->db->group_by('UNCI_usuario');
        $this->db->order_by('UApellido_pat', 'ASC');
        
        $data['docentes'] = $this->usuario_model->find_all(null, $selectU);

        foreach ($data['docentes'] as $d => $doc) {

            $selectNomb = 'UDTipo_Nombramiento, UDTipo_materia, TPNombre';
            $this->db->join('noctipopersonal','TPClave = UDTipo_Nombramiento','left');
            $this->db->where('UDUsuario', $doc['UNCI_usuario']);
            $this->db->where('UDPlantel', $idPlantel);
            $this->db->where('UDActivo', '1');
            $this->db->order_by('UDTipo_Nombramiento', 'ASC');
            $data['docentes'][$d]['nombramientos'] = $this->usuariodatos_model->find_all(null, $selectNomb);
        }
    
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
        
        $selectEst = 'IdLicenciatura, LGradoEstudio, LIdentificador';
        $this->db->group_by('LGradoEstudio');   
        $this->db->order_by('LIdentificador', 'ASC');
        $data['estudios'] = $this->licenciaturas_model->find_all(null, $selectEst);

        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'docentes/Mostrar_docentes';

        $this->load->view('plantilla_general', $data);
    }

    public function Update($idPlantel = null, $idUser = null) {
        $idPlantel = $this->encrypt->decode($idPlantel);
        $idUser = $this->encrypt->decode($idUser);  
        
        if($idUser != '0') {
            $selectU = "*";
            $this->db->join('nocrol','URol = CROClave');
            $this->db->join('nousuariodatos','UDUsuario = UNCI_usuario','left');
            $this->db->where('UNCI_usuario', $idUser);
            $this->db->where('FIND_IN_SET ("'.$idPlantel.'",UPlantel)');
            $data['usuario'] = $this->usuario_model->find_all(null, $selectU);
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

        $this->db->order_by('id_gradoestudios', 'ASC');
        $data['estudios'] = $this->gradoestudios_model->find_all();

        $this->db->where('LIdentificador !=','0');
        $this->db->group_by('Licenciatura');
        $this->db->order_by('Licenciatura', 'ASC');
        $data['carreras'] = $this->licenciaturas_model->find_all();
        
        $this->db->order_by('nomplaza','ASC');
        $data['plazas'] = $this->plazadocente_model->find_all();

        $data["config"] = $this->config_model->find();
                
        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'docentes/Mostrar_Update';

        $this->load->view('plantilla_general', $data);
    }

    public function savePlazas() {
        $data = post_to_array('_skip');
        
        if(nvl($data['UDClave']) != '') {
            $totales = 0;    
        } else {
            $select = 'SUM(UDHoras_grupo + UDHoras_apoyo + UDHoras_CB) AS Total';
            $this->db->where('UDUsuario',$data['UDUsuario']);
            $this->db->where('UDPlantel',$data['UDPlantel']);
            $this->db->where('UDActivo','1');
            $totales = $this->usuariodatos_model->find_all(null, $select);
        }
        
        if ($data['UDTipo_Nombramiento'] == '' || $data['UDPlaza'] == '' || $data['UDHoras_CB'] == '' ) {
            set_mensaje("Favor de ingresar todos los datos requeridos.");
            muestra_mensaje();
        } else {
            if (($data['UDTipo_Nombramiento'] == '1' || $data['UDTipo_Nombramiento'] == '2' || $data['UDTipo_Nombramiento'] == '3') &&  $data['UDFecha_ingreso'] == '') {
                set_mensaje("Favor de ingresar todos los datos requeridos.");
                muestra_mensaje();
            } elseif (($data['UDTipo_Nombramiento'] == '4'  || $data['UDTipo_Nombramiento'] == '5' || $data['UDTipo_Nombramiento'] == '6')  &&  ($data['UDFecha_inicio'] == '' ||  $data['UDFecha_final'] == '')) {
                set_mensaje("Favor de ingresar todos los datos requeridos.");
                muestra_mensaje();
            } elseif ($data['UDTipo_Nombramiento'] == '8'  &&  $data['UDFecha_inicio'] == '') {
                set_mensaje("Favor de ingresar todos los datos requeridos.");
                muestra_mensaje();
            } else {
                    $totalhoras = 0;
                    $totalhoras = $data['UDHoras_grupo'] + $data['UDHoras_apoyo'] + $data['UDHoras_CB'];
                if($totalhoras > 40) {
                    set_mensaje("El Número de horas no debe de exceder las <b>40 horas</b>.");
                    muestra_mensaje();
                } else {
                    $total = 0;
                    $total = $totalhoras + $totales[0]['Total'];
                    if ($total > '40'){
                        set_mensaje("Número Total de horas exceden las<b> 40</b>.");
                        muestra_mensaje();
                    } else {
                        if (($data['UDTipo_Nombramiento'] == '5' || $data['UDTipo_Nombramiento'] == '6') && $data['UDHoras_CB'] > '5') {
                            set_mensaje("Número de horas no pueden exceder las<b> 5 horas por Nombramiento.</b>");
                            muestra_mensaje();
                        } else {
                            if(isset($_FILES["UDNombramiento_file"]) && nvl($data['UDNombramiento_file']) != 'undefined' ) {
                                $nom = $_POST['UDUsuario'].date("dmY").'.pdf';
                                $directorio = "./Documentos/Docentes/Nombramientos/".$_POST['UDUsuario']."/";
                                
                                //Subir Nombramiento
                                $nomNombramiento = 'Nombramiento';
                                $fileNombramiento = $nomNombramiento.$nom;
                                $targetFileNombramiento = $directorio . $fileNombramiento;
                
                                if (!file_exists($directorio)) {
                                    mkdir($directorio, 0777, true);
                                }
                                //Con datos
                                move_uploaded_file($_FILES["UDNombramiento_file"]["tmp_name"], $targetFileNombramiento);
                                $data['UDNombramiento_file'] = $targetFileNombramiento;
                            } else {
                                $data['UDNombramiento_file'] = '';
                            }
                            $idPlantilla = $this->plantilla_model->plantilla_actual($data['UDPlantel']);

                            if($data['UDTipo_Nombramiento'] == '1' || $data['UDTipo_Nombramiento'] == '2' || $data['UDTipo_Nombramiento'] == '3' || $data['UDTipo_Nombramiento'] == '8') {
                                $permanente = 'Y';
                                $plantilla = NULL;
                            } else {
                                $permanente = 'N';
                                $plantilla = $idPlantilla;
                            }
                            
                            if (nvl($data['UDClave']) == '') {
                                $datos['UDUsuario'] = $data['UDUsuario'];
                                $datos['UDPlantel'] = $data['UDPlantel'];
                                $datos['UDFecha_ingreso'] = $data['UDFecha_ingreso'];
                                $datos['UDTipo_Nombramiento'] = $data['UDTipo_Nombramiento'];
                                $datos['UDPlaza'] = $data['UDPlaza'];
                                $datos['UDTipo_materia'] = $data['UDTipo_materia'];
                                $datos['UDNumOficio'] = $data['UDNumOficio'];
                                $datos['UDHoras_grupo'] = $data['UDHoras_grupo'];
                                $datos['UDHoras_apoyo'] = $data['UDHoras_apoyo'];
                                $datos['UDHoras_CB'] = $data['UDHoras_CB'];
                                $datos['UDFecha_inicio'] = $data['UDFecha_inicio'];
                                $datos['UDFecha_final'] = $data['UDFecha_final'];
                                $datos['UDLicencia'] = $data['UDLicencia'];
                                $datos['UDObservaciones'] = $data['UDObservaciones'];
                                $datos['UDNombramiento_file'] = $data['UDNombramiento_file'];
                                $datos['UDPlantilla'] = $plantilla;
                                $datos['UDActivo'] = '1';
                                $datos['UDValidado'] = '1';
                                $datos['UDPermanente'] = $permanente;
                                $datos['UDUsuario_registro'] = get_session('UNCI_usuario');
                                $datos['UDFecha_registro'] = date('Y-m-d H:i:s');
                                $this->usuariodatos_model->insert($datos);

                                set_mensaje("La plaza del Docente se guardo correctamente.",'success::');
                                muestra_mensaje();
                                echo "::OK";
                                echo "::".$data['UDUsuario'];
                            } else {
                                $data['UDPlantilla'] = $plantilla;
                                $data['UDPermanente'] = $permanente;
                                $data['UDUsuarioModificacion'] = get_session('UNCI_usuario');
                                $data['UDFechaModificacion'] = date('Y-m-d H:i:s');
                                $this->usuariodatos_model->update($data['UDClave'], $data);

                                set_mensaje("La plaza del Docente se modifico correctamente.",'success::');
                                muestra_mensaje();
                                echo "::OK";
                                echo "::".$data['UDUsuario'];
                            }
                            
                            //echo "::".$data['UDTipo_Nombramiento'];
                        }
                        
                    }

                }
                
            }
        }
        
    }    

    public function mostrarPlazas_skip () {
        $idUsuario = $this->input->post('idUsuario');
        $idPlantel = $this->input->post('idPlantel');
                
        $this->db->join('noplazadocente','idPlaza = UDPlaza','left');
        $this->db->join('noctipopersonal',' UDTipo_Nombramiento = TPClave','left');

        $this->db->where('UDUsuario',$idUsuario);
        $this->db->where_in('UDPlantel',$idPlantel);
        $this->db->where('UDActivo','1');
        $this->db->order_by('UDTipo_Nombramiento','ASC');

        $data['data'] = $this->usuariodatos_model->find_all();
        
        $data['contar'] = count($data['data']);

        echo $data['data'][0]['UDTipo_Nombramiento']."::";

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
        $this->db->join('noctipopersonal',' UDTipo_Nombramiento = TPClave');

        $this->db->where('UDUsuario',$idUsuario);
        $this->db->where('UDPlantel',$idPlantel);
        $this->db->where('UDActivo','1');
        $data['data'] = $this->usuariodatos_model->find_all();

        $data['contar'] = count($data['data']);

        $this->load->view('docentes/Mostrar_plazas', $data);
    }

    public function saveEstudios() {
        $data= post_to_array('_skip');
       
        //Subir Titulo Profesional
        if ($data['ULTitulado'] == 'Titulado') {    
            if ($data['ULNivel_estudio'] == '' || $data['ULLicenciatura'] == '') {
                set_mensaje("Favor de ingresar todos los datos requeridos.");
                muestra_mensaje();
            } else {
                if(isset($_FILES["ULTitulo_file"]) && nvl($data['ULTitulo_file']) != 'undefined') {
                    $nom = date("dmY").'.pdf';
                    $directorio = "./Documentos/Docentes/Licenciaturas/".$data['ULUsuario']."/";
    
                    $nomTitulo = 'Titulo'.$_POST['ULUsuario'];
                    $fileTitulo = $nomTitulo.$nom;
                    $targetFileTitulo = $directorio . $fileTitulo;   
                    
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true);
                    }
                    //Con datos
                    move_uploaded_file($_FILES["ULTitulo_file"]["tmp_name"], $targetFileTitulo);
                    $data['ULTitulo_file'] = $targetFileTitulo;
                } else {
                    $data['ULTitulo_file'] = '';
                }
                
                if(!$data['ULClave']) {
                    $data['ULActivo'] = '1';
                    $data['ULUsuarioRegistro'] = get_session('UNCI_usuario');
                    $data['ULFechaRegistro'] = date('Y-m-d H:i:s');

                    $this->usuariolic_model->insert($data);

                    set_mensaje("Los datos se agregarón correctamente",'success::');
                    muestra_mensaje();
                    echo "::OK";
                    echo "::".$data['ULUsuario'];
                } else {
                    $data['ULActivo'] = '1';
                    $data['ULUsuarioModificacion'] = get_session('UNCI_usuario');
                    $data['ULFechaModificacion'] = date('Y-m-d H:i:s');
                    
                    $this->usuariolic_model->update($data['ULClave'],$data);

                    set_mensaje("Los datos se Modificarón correctamente",'success::');
                    muestra_mensaje();
                    echo "::OK";
                    echo "::".$data['ULUsuario'];
                }
            }

        } else {
            if ($data['ULNivel_estudio'] == '' || $data['ULLicenciatura'] == '') {
                set_mensaje("Favor de ingresar todos los datos requeridos.");
                muestra_mensaje();
            } else {
                $datos['ULUsuario'] = $data['ULUsuario'];
                $datos['ULPlantel'] = $data['ULPlantel'];
                $datos['ULNivel_estudio'] = $data['ULNivel_estudio'];
                $datos['ULLicenciatura'] = $data['ULLicenciatura'];
                $datos['ULTitulado'] = $data['ULTitulado'];
                $datos['ULActivo'] = '1';

               

                if(!$data['ULClave']) {
                    $datos['ULUsuarioRegistro'] = get_session('UNCI_usuario');
                    $datos['ULFechaRegistro'] = date('Y-m-d H:i:s');
                    $this->usuariolic_model->insert($datos);

                    set_mensaje("Los datos se agregarón correctamente",'success::');
                    muestra_mensaje();
                    echo "::OK";
                    echo "::".$data['ULUsuario'];

                } else {
                    $datos['ULUsuarioModificacion'] = get_session('UNCI_usuario');
                    $datos['ULFechaModificacion'] = date('Y-m-d H:i:s');
                    $this->usuariolic_model->update($data['ULClave'], $datos);

                    set_mensaje("Los datos se Modificarón correctamente",'success::');
                    muestra_mensaje();
                    echo "::OK";
                    echo "::".$data['ULUsuario'];
                }
                
                
            }
        }
        
    }

    public function mostrarEstudios () {
        $idUsuario = $this->input->post('idUsuario');
        $idPlantel = $this->input->post('idPlantel');
        $data['contar'] = 0;

        $selectDatos = "ULClave, ULUsuario, ULPLantel, id_gradoestudios, grado_estudios, ULLicenciatura, Licenciatura, ULTitulo_file, ULCedula_file, ULTitulado, ULCedulaProf, ULActivo";
        $this->db->join('nolicenciaturas','ULLicenciatura = IdLicenciatura','left');
        $this->db->join('nogradoestudios','LIdentificador = id_gradoestudios','left');
        $this->db->where('ULUsuario',$idUsuario);
        $this->db->where('ULPlantel',$idPlantel);
        $this->db->where('ULActivo','1');
        $data['data'] = $this->usuariolic_model->find_all(null, $selectDatos);
        
        $data['contar'] = count($data['data']);
        
        echo $data['contar'].'::';

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

        $data['contar'] = 0;

        $selectDatos = "ULClave, ULUsuario, ULPLantel, id_gradoestudios, grado_estudios, ULLicenciatura, Licenciatura, ULTitulo_file, ULCedula_file, ULTitulado, ULCedulaProf, ULActivo";
        $this->db->join('nolicenciaturas','ULLicenciatura = IdLicenciatura','left');
        $this->db->join('nogradoestudios','LIdentificador = id_gradoestudios','left');
        $this->db->where('ULUsuario',$idUsuario);
        $this->db->where('ULPlantel',$idPlantel);
        $this->db->where('ULActivo','1');
        $data['data'] = $this->usuariolic_model->find_all(null, $selectDatos);
        
        $data['contar'] = count($data['data']);
        
        $data['contar'];

        $this->load->view('docentes/Mostrar_estudios', $data);
    }
    
    public function Save() {
        $data = post_to_array('_skip');
       
        if (isset($data)){
            if ($data['UNCI_usuario'] == ''){    
                $user = array(
                    'UClave_servidor' => $data['UClave_servidor'],
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
                    'URed_social' => $data['URed_social'],                
                    'ULugar_nacimiento' => $data['ULugar_nacimiento'],
                    'UISSEMYM' => $data['UISSEMYM'],
                    'UClave_elector' => $data['UClave_elector'],
                    'UEstado_civil' => $data['UEstado_civil'],
                    'USexo' => $data['USexo'],
                    'UHijos' => $data['UHijos'],                
                    'UPlantel' => $data['UPlantel'],
                    'UTipoDocente' => $data['UTipoDocente'],
                    'URol' => 7,
                    'UEstado' => 'Activo',
                    'UFecha_registro' => date('Y-m-d H:i:s'),
                    'UUsuario_registro' => get_session('UNCI_usuario')
                );                
                
                $id = $this->usuario_model->insert($user);
                set_mensaje("El Docente se guardo con éxito",'success::');
                echo"::$id";
                echo"::OK";
            } else {

                $user = array(
                    'UClave_servidor' => $data['UClave_servidor'],
                    'UClave_servidor_centro' => $data['UClave_servidor_centro'],
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
                    'URed_social' => $data['URed_social'],                
                    'ULugar_nacimiento' => $data['ULugar_nacimiento'],
                    'UISSEMYM' => $data['UISSEMYM'],
                    'UClave_elector' => $data['UClave_elector'],
                    'UEstado_civil' => $data['UEstado_civil'],
                    'USexo' => $data['USexo'],
                    'UHijos' => $data['UHijos'],                
                    'UTipoDocente' => $data['UTipoDocente'],
                    'UFecha_modificacion' => date('Y-m-d H:i:s'),
                    'UUsuario_modificacion' => get_session('UNCI_usuario')
                ); 

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
        
        $this->db->where('LIdentificador',$nivel);
        $this->db->group_by('Licenciatura');
        $this->db->order_by('Licenciatura', 'ASC');
        $data['carreras'] = $this->licenciaturas_model->find_all();
        
        ?>
        <select name="ULLicenciatura" id="ULLicenciatura" class="form-control chosen-select" data-placeholder="Seleccionar">
            <option value=""></option>
            <?php foreach ($data['carreras']  as $k => $listCar) { ?>
                <option value="<?= $listCar['IdLicenciatura']; ?>"><?= $listCar['Licenciatura']; ?></option>    
            <?php } ?>
        </select>    
        <script type="text/javascript">
            $(document).ready(function() {
                $('.chosen-select').chosen();            
            });
        </script>    
        <?php
    }

    public function datosPlaza_skip() {
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