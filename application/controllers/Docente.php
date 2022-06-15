<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docente extends CI_Controller {
    public function __contruct () {
        $this->load->helper('file');
        $this->load->helper('url');

        parent::__construct();
        if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');

        /*if (!is_permitido()) //  Verificamos que el usuario tenga permisos
            redirect('usuario/negar_acceso');*/
    }

    public function index() {
        if(!is_permitido(null,'docente','ver_planteles')){
            redirect('docente/mostrarDocentes');
        }
        $data = array();
        if (is_permitido(null,'docente', 'index')) {
        }

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

    public function mostrarDocentes($idPlantel = null) {
        $data = array();
        $idPlantel = $this->encrypt->decode($idPlantel);
        if (!$idPlantel) {
            $idPlantel = get_session('UPlantel');
        }        
        
        $selectP = 'CPLClave, CPLNombre, CPLTipo';
        $this->db->where('CPLClave',$idPlantel);
        
        $data['plantel'] = $this->plantel_model->find_all(null, $selectP);
        
        $selectU = "UNCI_usuario, UClave_servidor, UNombre, UApellido_pat, UApellido_mat, UFecha_nacimiento, UCorreo_electronico, URFC, UCURP, UClave_elector, UDomicilio, UColonia, UMunicipio, UCP, UTelefono_movil, UTelefono_casa, ULugar_nacimiento, UEstado_civil, USexo, UEscolaridad, UPlantel, UEstado, UFecha_registro";
        $this->db->join('nocrol','URol = CROClave');
        $this->db->where("CROClave NOT IN ('3','10','12')");
        $this->db->where('FIND_IN_SET ("'.$idPlantel.'",UPlantel)');
        //$this->db->where('UTipoDocente','D');
        $this->db->order_by('UNombre', 'ASC');
        $data['docentes'] = $this->usuario_model->find_all(null, $selectU);
        
        foreach ($data['docentes'] as $k => $doc) {
            $selectD = '`UDClave`, `UDTipo_Docente`, `UDActivo`, TPClave, `TPNombre`, `UDFecha_ingreso`, `UDPlaza`, PLPuesto,
            `UDNombramiento_file`, `UDOficio_file`, `UDCurriculum_file`, `UDCURP_file`';

            $this->db->join('noctipopersonal','UDTipo_Docente = TPClave', 'LEFT');
            $this->db->join('noplaza','PLClave = UDPlaza', 'LEFT');
            $this->db->where('UDCUsuario',$doc['UNCI_usuario']);
            $this->db->where('UDCPlantel', $idPlantel);

            $data['docentes'][$k]['datosDocentes'] = $this->usuariodatos_model->find_all(null, $selectD);
        }
        
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

    public function Update($idPlantel = null, $idUser = null) {
        $idPlantel = $this->encrypt->decode($idPlantel);
        $idUser = $this->encrypt->decode($idUser);

        if($idUser)
        $data['usuario'] = $this->usuario_model->get($idUser);
        
        $data['estado_civil'] = $this->estciv_model->find_all();

        $data['tipoDocente'] = $this->tipopersonal_model->find_all();
        
        $selectP = 'CPLClave, CPLNombre, CPLTipo';
        $this->db->where('CPLClave',$idPlantel);
        
        $data['plantel'] = $this->plantel_model->find_all(null, $selectP);
        
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

        $this->db->where('LIdentificador !=','0');
        $this->db->group_by('Licenciatura');
        $this->db->order_by('Licenciatura', 'ASC');
        $data['carreras'] = $this->licenciaturas_model->find_all();

        
        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'docentes/Mostrar_Update';

        $this->load->view('plantilla_general', $data);
    }
    
    public function Registrar() {
        $data = post_to_array('_skip');
        
        if (!$data['UNCI_usuario']) {
            $this->_set_rules($data); //validamos los datos
            if($this->form_validation->run() === FALSE) {
                set_mensaje(validation_errors());
                muestra_mensaje();
            } else {
                //Subir archivos al servidor
                $lista_archivos = array(
                    'UDNombramiento_file',
                    'UDOficio_file',
                    'UDCurriculum_file',
                    'UDCURP_file'
                    );

                $user['UNombre'] = $data['UNombre'];
                $user['UApellido_pat'] = $data['UApellido_pat'];
                $user['UApellido_mat'] = $data['UApellido_mat'];
                $user['UCURP'] = $data['UCURP'];
                $user['UFecha_nacimiento'] = fecha_format($data['UFecha_nacimiento']);
                $user['URFC'] = $data['URFC'];
                $user['UDomicilio'] = $data['UDomicilio'];
                $user['UColonia'] = $data['UColonia'];
                $user['UMunicipio'] = $data['UMunicipio'];
                $user['UCP'] = $data['UCP'];
                $user['UTelefono_movil'] = $data['UTelefono_movil'];
                $user['UTelefono_casa'] = $data['UTelefono_casa'];
                $user['UCorreo_electronico'] = $data['UCorreo_electronico'];
                $user['ULugar_nacimiento'] = $data['ULugar_nacimiento'];
                $user['UEstado_civil'] = $data['UEstado_civil'];
                $user['USexo'] = $data['USexo'];
                $user['UPlantel'] = $data['UDCPLantel'];
                $user['URol'] = 7;
                $user['UEstado'] = 'Activo';
                $user['UFecha_registro'] = date('Y-m-d H:i:s');
                $user['UUsuario_registro'] = get_session('UNCI_usuario');
                
                //Insertar el nuevo docente en la tabla usuario
                $id = $this->usuario_model->insert($user);

                $old_data = $this->usuario_model->find("UNCI_usuario = ".$id); 
                mover_archivos($data,$lista_archivos,$old_data,"./Documentos/Docentes/".$id."/");

                $datos['UDCUsuario'] = $id;
                $datos['UDCPlantel'] = $data['UDCPLantel'];
                $datos['UDTipo_Docente'] = $data['UDTipo_Docente'];
                $datos['UDFecha_ingreso'] = fecha_format($data['UDFecha_ingreso']);
                $datos['UDPlaza'] = $data['UDNombramiento'];
                $datos['UDNombramiento_file'] = $data['UDNombramiento_file'];
                $datos['UDOficio_file'] = $data['UDOficio_file'];
                $datos['UDCurriculum_file'] = $data['UDCurriculum_file'];
                $datos['UDCURP_file'] = $data['UDCURP_file'];
                $datos['UDActivo'] = 1;
                $datos['UDUsuario_registro'] = get_session('UNCI_usuario');
                $datos['UDFecha_registro'] = date('Y-m-d H:i:s');
               
                //Insertar los datos del nuevo usuario
                $this->usuariodatos_model->insert($datos);
                set_mensaje("El docente se guardo con éxito",'success::');
                echo "OK";
            }
        } else {

            $this->_set_rules($data); //validamos los datos
            if($this->form_validation->run() === FALSE) {
                set_mensaje(validation_errors());
                muestra_mensaje();
            } else {
                $this->db->where('UDCPlantel', $data['UDCPLantel']);
                $this->db->where('UDCUsuario', $data['UNCI_usuario']);
                $data['datos'] = $this->usuariodatos_model->find_all();
                
                if (count($data['datos']) == 0) { //Validar que el docente no se encuentre dado de alta en el plantel o centro
                    if ($data['UDOficio_file'] == '' || $data['UDCurriculum_file'] == '' || $data['UDCURP_file'] == '' || $data['UDNombramiento_file'] == '') {
                        set_mensaje("Favor de ingresar todos los documentos requeridos.");
                        muestra_mensaje();
                    } else {
                        //Subir archivos al servidor
                        $lista_archivos = array(
                            'UDNombramiento_file',
                            'UDOficio_file',
                            'UDCurriculum_file',
                            'UDCURP_file'
                            );
                        $old_data = $this->usuariodatos_model->find("UDCUsuario = ".$data['UNCI_usuario']); 
                        mover_archivos($data,$lista_archivos,$old_data,"./Documentos/Docentes/".$data['UNCI_usuario']."/"); 
                        //Subir archivos al servidor
                        
                        $datos['UDCUsuario'] = $data['UNCI_usuario'];
                        $datos['UDCPlantel'] = $data['UDCPLantel'];
                        $datos['UDTipo_Docente'] = $data['UDTipo_Docente'];
                        $datos['UDFecha_ingreso'] = fecha_format($data['UDFecha_ingreso']);
                        $datos['UDPlaza'] = $data['UDNombramiento'];
                        $datos['UDNombramiento_file'] = $data['UDNombramiento_file'];
                        $datos['UDOficio_file'] = $data['UDOficio_file'];
                        $datos['UDCurriculum_file'] = $data['UDCurriculum_file'];
                        $datos['UDCURP_file'] = $data['UDCURP_file'];
                        $datos['UDActivo'] = 1;
                        $datos['UDUsuario_registro'] = get_session('UNCI_usuario');
                        $datos['UDFecha_registro'] = date('Y-m-d H:i:s');

                        $this->usuariodatos_model->insert($datos);

                        $user['UNombre'] = $data['UNombre'];
                        $user['UApellido_pat'] = $data['UApellido_pat'];
                        $user['UApellido_mat'] = $data['UApellido_mat'];
                        $user['UCURP'] = $data['UCURP'];
                        $user['UFecha_nacimiento'] = fecha_format($data['UFecha_nacimiento']);
                        $user['URFC'] = $data['URFC'];
                        $user['UDomicilio'] = $data['UDomicilio'];
                        $user['UColonia'] = $data['UColonia'];
                        $user['UMunicipio'] = $data['UMunicipio'];
                        $user['UCP'] = $data['UCP'];
                        $user['UTelefono_movil'] = $data['UTelefono_movil'];
                        $user['UTelefono_casa'] = $data['UTelefono_casa'];
                        $user['UCorreo_electronico'] = $data['UCorreo_electronico'];
                        $user['ULugar_nacimiento'] = $data['ULugar_nacimiento'];
                        $user['UEstado_civil'] = $data['UEstado_civil'];
                        $user['USexo'] = $data['USexo'];
                        
                        $this->usuario_model->update($data['UNCI_usuario'], $user);
                        set_mensaje("Los datos del Usuario se actualizaron con éxito",'success::');
                        echo "OK";
                    }
                } else {
                    //Subir archivos al servidor
                    $lista_archivos = array(
                        'UDOficio_file',
                        'UDCurriculum_file',
                        'UDCURP_file'
                        );
                    $old_data = $this->usuariodatos_model->find("UDCUsuario = ".$data['UNCI_usuario']); 
                    mover_archivos($data,$lista_archivos,$old_data,"./Documentos/Docentes/".$data['UNCI_usuario']."/"); 
                    //Subir archivos al servidor
                    
                    $datos['UDTipo_Docente'] = $data['UDTipo_Docente'];
                    $datos['UDFecha_ingreso'] = fecha_format($data['UDFecha_ingreso']);
                    $datos['UDPlaza'] = $data['UDNombramiento'];
                    $datos['UDNombramiento_file'] = $data['UDNombramiento_file'];
                        if (isset($data['UDOficio_file'])) {
                            $datos['UDOficio_file'] =$data['UDOficio_file'];
                        }
                        if (isset($data['UDCurriculum_file'])) {
                            $datos['UDCurriculum_file'] = $data['UDCurriculum_file'];
                        }
                        if (isset($data['UDCURP_file'])) {
                            $datos['UDCURP_file'] = $data['UDCURP_file'];
                        }
                    $datos['UDUsuarioModificacion'] = get_session('UNCI_usuario');
                    $datos['UDFechaModificacion'] = date('Y-m-d H:i:s');

                    $this->usuariodatos_model->update($data['datos'][0]['UDClave'],$datos);

                    $user['UNombre'] = $data['UNombre'];
                    $user['UApellido_pat'] = $data['UApellido_pat'];
                    $user['UApellido_mat'] = $data['UApellido_mat'];
                    $user['UCURP'] = $data['UCURP'];
                    $user['UFecha_nacimiento'] = fecha_format($data['UFecha_nacimiento']);
                    $user['URFC'] = $data['URFC'];
                    $user['UDomicilio'] = $data['UDomicilio'];
                    $user['UColonia'] = $data['UColonia'];
                    $user['UMunicipio'] = $data['UMunicipio'];
                    $user['UCP'] = $data['UCP'];
                    $user['UTelefono_movil'] = $data['UTelefono_movil'];
                    $user['UTelefono_casa'] = $data['UTelefono_casa'];
                    $user['UCorreo_electronico'] = $data['UCorreo_electronico'];
                    $user['ULugar_nacimiento'] = $data['ULugar_nacimiento'];
                    $user['UEstado_civil'] = $data['UEstado_civil'];
                    $user['USexo'] = $data['USexo'];                        
                    
                    $this->usuario_model->update($data['UNCI_usuario'], $user);
                    set_mensaje("Los datos del Usuario se actualizaron con éxito",'success::');
                    echo "OK";
                }
            }   
        }    
    }

    public function saveArchivo() {
        
        $data= post_to_array('_skip');
        $data['UPActivo'] = 1;
        $data['UPUsuarioRegistro'] = get_session('UNCI_usuario');
        $data['UPFechaRegistro'] = date('Y-m-d H:i:s');
        
        if ($data['UPNivel_estudio'] == '' || $data['UPLicenciatura'] == '' || $data['UPTitulo_file'] == '' || $data['UPCedula_file'] == '' ) {
            set_mensaje("Favor de ingresar todos los datos requeridos.");
            muestra_mensaje();
        } else {
            $lista_archivos = array(
                'UPTitulo_file',
                'UPCedula_file',
                );

            $old_data = $this->usuariodatos_model->find("UDCUsuario = ".$data['UPUClave']); 
            mover_archivos($data,$lista_archivos,$old_data,"./documentos/Docentes/".$data['UPUClave']."/"); 
            //Subir archivos al servidor

            $this->usuarioprofesion_model->insert($data);
            set_mensaje("Los datos y archivos se guardaron correctamente",'success::');
            echo "OK;";
            muestra_mensaje();
        }
        echo ";".$data['UPUClave'];
    }

    public function mostrarArchivos () {
        $idUsuario = $this->input->post('idUsuario');
        $idPlantel = $this->input->post('idPlantel');

        $selectDatos = "UPClave, UPUClave, UPPClave, UPNivel_estudio, UPLicenciatura, Licenciatura, UPTitulo_file, UPCedula_file, UPActivo";
        $this->db->join('nolicenciaturas','UPLicenciatura = IdLicenciatura');

        $this->db->where('UPUClave',$idUsuario);
        $this->db->where('UPPClave',$idPlantel);
        $this->db->where('UPActivo','1');
        $data['data'] = $this->usuarioprofesion_model->find_all(null, $selectDatos);
        
        $this->load->view('docentes/Mostrar_archivos', $data);
    }   

    public function deleteEstudios() {
        $UPClave = $this->encrypt->decode($this->input->post('UPClave'));
        $data = array(
            'UPActivo' => '0',
            'UPUsuarioModificacion' => get_session('UNCI_usuario'),
            'UPFechaModificacion' => date('Y-m-d H:i:s')
        );
        
        $this->usuarioprofesion_model->update($UPClave,$data);
        set_mensaje("Los datos del usuario se eliminaron correctamente.",'success::');
        muestra_mensaje();

        $idUsuario = $this->input->post('idUsuario');
        $idPlantel = $this->input->post('idPlantel');
        
         $selectDatos = "UPClave, UPUClave, UPPClave, UPNivel_estudio, UPLicenciatura, Licenciatura, UPTitulo_file, UPCedula_file, UPActivo";
        $this->db->join('nolicenciaturas','UPLicenciatura = IdLicenciatura');

        $this->db->where('UPUClave',$idUsuario);
        $this->db->where('UPPClave',$idPlantel);
        $this->db->where('UPActivo','1');
        $data['data'] = $this->usuarioprofesion_model->find_all(null, $selectDatos);

        $this->load->view('docentes/Mostrar_archivos', $data);
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
        /*$this->db->like('LGradoEstudio', $nivel);
        $this->db->group_by('LNombreLic');
        $this->db->order_by('LNombreLic', 'ASC');
        $data['carreras'] = $this->licenciaturas_model->find_all();*/

        $this->db->where('LIdentificador !=','0');
        $this->db->like('LGradoEstudio', $nivel);
        $this->db->group_by('Licenciatura');
        $this->db->order_by('Licenciatura', 'ASC');
        $data['carreras'] = $this->licenciaturas_model->find_all();
        ?>
        <div class="form-group">
            <label class="col-lg-3 control-label" for="">Especialidad: <em>*</em></label>
            <div class="col-lg-9">
                <select name="UPLicenciatura" id="UPLicenciatura" class="form-control chosen-select">
                    <option value="">- Especialidad -</option>
                    <?php foreach ($data['carreras']  as $k => $listCar) { ?>
                        <option value="<?= $listCar['IdLicenciatura'] ?>"><?= $listCar['Licenciatura'] ?></option>    
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php
    }

    public function quitarDocente() {
        $data = array();
        $UNCI_usuario = $this->encrypt->decode($this->input->post('UNCI_usuario_skip'));
        $UNCI_plantel = $this->input->post('PlantelId');
        
        /*$select = 'UNCI_usuario, UPlantel';
        $this->db->where('UNCI_usuario', $UNCI_usuario);
        $datos = $this->usuario_model->find_all(null, $select);
        
        foreach ($datos as $k => $listP) {
        $ids = explode(',', $listP['UPlantel']);
            if (count($ids) == 1 ) {
                $data['UPlantel'] = '';
                } else {
                foreach ($ids as $y => $ids) {
                    if ($ids != $UNCI_plantel) {
                        $result[$y] = $ids;
                        $results = implode(',', $result);
                        $data['UPlantel'] = $results;
                    }
                }
            }
        }*/
        //$data['UTipoDocente'] = "A";
        $this->usuario_model->update($UNCI_usuario, $data);
        set_mensaje("El docente se quito correctamente",'success::');
        echo "OK";
    }

    public function _set_rules() {
        $rango_fechas = date('d/m/Y',strtotime('-100 year') ) . "," . date('d/m/Y', strtotime('+0 year'));

        $this->form_validation->set_rules('UCURP', 'CURP', "trim|required|min_length[18]|max_length[20]");
        $this->form_validation->set_rules('UNombre', 'Nombre(s)', "trim|required|min_length[1]|max_length[150]");
        $this->form_validation->set_rules('UApellido_pat', 'Apellido Paterno', "trim|required|min_length[1]|max_length[150]");
        $this->form_validation->set_rules('UApellido_mat', 'Apellido Materno', "trim|required|min_length[1]|max_length[150]");
        $this->form_validation->set_rules('UFecha_nacimiento', 'Fecha de Nacimiento', "trim|required|max_length[10]|valida_fecha[$rango_fechas]");
        $this->form_validation->set_rules('ULugar_nacimiento', 'Lugar de Nacimiento', "trim|required|min_length[1]|max_length[150]");
        $this->form_validation->set_rules('URFC', 'RFC', "trim|required|min_length[10]|max_length[14]");
        $this->form_validation->set_rules('UDomicilio', 'Domicilio', "trim|required|min_length[1]|max_length[250]");
        $this->form_validation->set_rules('UColonia', 'Colonia', "trim|required|min_length[1]|max_length[150]");
        $this->form_validation->set_rules('UMunicipio', 'Municipio', "trim|required|min_length[1]|max_length[150]");
        $this->form_validation->set_rules('UCP', 'Código Postal', "trim|required|min_length[4]|max_length[5]");
        $this->form_validation->set_rules('UTelefono_movil', 'Teléfono Móvil', "trim|required|min_length[10]|max_length[10]");
        $this->form_validation->set_rules('UTelefono_casa', 'Teléfono Casa', "trim|required|min_length[10]|max_length[10]");
        $this->form_validation->set_rules('UCorreo_electronico', 'Correo electr&oacute;nico', "trim|required|max_length[60]|valid_email");
        $this->form_validation->set_rules('UEstado_civil', 'Estado civil', "trim|required|min_length[5]|max_length[13]");
        $this->form_validation->set_rules('USexo', 'Sexo', "trim|required|min_length[5]|max_length[6]");
        $this->form_validation->set_rules('UDTipo_Docente', 'Tipo Docente', "trim|required|min_length[1]|max_length[1]");
        $this->form_validation->set_rules('UDFecha_ingreso', 'Fecha de Ingreso', "trim|required|max_length[10]");
        $this->form_validation->set_rules('UDNombramiento', 'Nombramiento', "trim|required|min_length[1]|max_length[2]");
        $this->form_validation->set_rules('UDNombramiento_file', 'Archivo Nombramiento', "trim|required|min_length[1]|max_length[250]");

        $this->form_validation->set_rules('UDOficio_file', 'Oficio de Petición', "trim|required|min_length[1]|max_length[250]");
        $this->form_validation->set_rules('UDCurriculum_file', 'Curriculum', "trim|required|min_length[1]|max_length[250]");
        $this->form_validation->set_rules('UDCURP_file', 'CURP', "trim|required|min_length[1]|max_length[250]");

    }

}
?>