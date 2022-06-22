<?php
class Periodos extends CI_Controller {
    public function __construct (){
       parent::__construct();
       if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');

        if (!is_permitido()) //  Verificamos que el usuario tenga permisos
            redirect('usuario/negar_acceso');
    }

    public function index() {
        $data = array();

        $this->db->where('CPEStatus','1');
        $this->db->order_by('CPEPeriodo','DESC');
        $this->db->limit('10');
        $data["periodos"] = $this->periodos_model->find_all();

        foreach ($data["periodos"] as $k => $per) {
            $periodos = explode('-', $per['CPEPeriodo']);
            $fechaInicio = $per['CPEDiaInicio'].'/'.$per['CPEMesInicio'].'/'.$per['CPEAnioInicio'];
            $fechaFin = $per['CPEDiaFin'].'/'.$per['CPEMesFin'].'/'.$per['CPEAnioFin'];

            $data['editar'][$k] = array(
                'CPEClave' => $per['CPEClave'],
                'CPEPeriodo' => $periodos[0],
                'CPEPeriodoSem' => $periodos[1],
                'InicioPeriodo' => $fechaInicio,
                'FinPeriodo' => $fechaFin,
            );
        }

        $data['modulo'] = $this->router->fetch_class();

        $data['subvista'] = 'periodos/Mostrar_view';
        $this->load->view('plantilla_general', $data);
    }

    public function save() {
        if(! $_POST)
            redirect( $this->router->fetch_class() );

        $data= post_to_array('_skip');
        
        $this->_set_rules(); //validamos los datos
        if($this->form_validation->run() === FALSE) {
            set_mensaje(validation_errors());
            muestra_mensaje();
            
        } else {

            $fechaInicio = explode("/", $data['InicioPeriodo']);
            $fechaFin = explode("/", $data['FinPeriodo']);
            $periodo = $data['CPEPeriodo'].'-'.$data['CPEPeriodoSem'];
            $insertar['CPEPeriodo'] = $periodo;

            $insertar['CPEDiaInicio'] = $fechaInicio[0];
            $insertar['CPEMesInicio'] = $fechaInicio[1];
            $insertar['CPEAnioInicio'] = $fechaInicio[2];
            $insertar['CPEDiaFin'] = $fechaFin[0];
            $insertar['CPEMesFin'] = $fechaFin[1];
            $insertar['CPEAnioFin'] = $fechaFin[2];
            $insertar['CPEStatus'] = '1';

            if (!$data['CPEClave']) { //Insertar nuevo periodo escolar
                if ($data['CPEPeriodoSem'] == '1') { // Validar el Periodo del ciclo para ver fechas correctas
                    if (($fechaInicio[1] == '1' || $fechaInicio[1] == '2') && ($fechaFin[1] == '7' || $fechaFin[1] == '8') &&  $data['CPEPeriodo'] == substr($fechaInicio[2], -2) && $data['CPEPeriodo'] == substr($fechaFin[2], -2)) { //Validando fechas que sean de Febrero a Julio 
                        $this->periodos_model->insert($insertar);
                        echo "OK";
                    } else { // mostrar el error si los meses y año no son los correctos
                        set_mensaje("Las fechas son Incorrectas, por favor verificar.");
                        muestra_mensaje();
                    }
                } elseif ($data['CPEPeriodoSem'] == '2') { // Validar el Periodo del ciclo para ver fechas correctas
                    if (($fechaInicio[1] == '7' || $fechaInicio[1] == '8') && ($fechaFin[1] == '1' || $fechaFin[1] == '2') &&  $data['CPEPeriodo'] == substr($fechaInicio[2], -2) && $data['CPEPeriodo'] + 1 == substr($fechaFin[2], -2)) { //Validando fechas que sean de Febrero a Julio 
                        $this->periodos_model->insert($insertar);
                        echo "OK";
                    } else { // mostrar el error si los meses y año no son los correctos
                        set_mensaje("Las fechas son Incorrectas, por favor verificar.");
                        muestra_mensaje();
                    }
                } else {
                    set_mensaje("Las fechas no corresponden al periodo indicado.");
                    muestra_mensaje();
                }

            } else { // Editar un periodo existente
                if ($data['CPEPeriodoSem'] == '1') { // Validar el Periodo del ciclo para ver fechas correctas
                    if (($fechaInicio[1] == '1' || $fechaInicio[1] == '2') && ($fechaFin[1] == '7' || $fechaFin[1] == '8') &&  $data['CPEPeriodo'] == substr($fechaInicio[2], -2) && $data['CPEPeriodo'] == substr($fechaFin[2], -2)) { //Validando fechas que sean de Febrero a Julio 
                        $this->periodos_model->update($data['CPEClave'], $insertar);
                        echo "OK";
                    } else { // mostrar el error si los meses y año no son los correctos
                        set_mensaje("Las fechas son Incorrectas, por favor verificar.");
                        muestra_mensaje();
                    }
                } elseif ($data['CPEPeriodoSem'] == '2') { // Validar el Periodo del ciclo para ver fechas correctas
                    if (($fechaInicio[1] == '7' || $fechaInicio[1] == '8') && ($fechaFin[1] == '1' || $fechaFin[1] == '2') &&  $data['CPEPeriodo'] == substr($fechaInicio[2], -2) && $data['CPEPeriodo'] + 1 == substr($fechaFin[2], -2)) { //Validando fechas que sean de Febrero a Julio 
                        $this->periodos_model->update($data['CPEClave'], $insertar);
                        echo "OK";
                    } else { // mostrar el error si los meses y año no son los correctos
                        set_mensaje("Las fechas son Incorrectas, por favor verificar.");
                        muestra_mensaje();
                    }
                } else {
                    set_mensaje("Las fechas no corresponden al periodo indicado.");
                    muestra_mensaje();
                }
            }
        }
    }

    public function delete($CPECLave = null, $CPEStatus = null) { //Modificar los peridos a Incativos
        $data= array();
        $Status = $this->encrypt->decode( $CPEStatus );   
        $data = array("CPEStatus" => $Status );
        $CPECLave = $this->encrypt->decode($CPECLave);  
        $this->periodos_model->update($CPECLave,$data);

        redirect( $this->router->fetch_class() );

    }

    function _set_rules(){
        $this->form_validation->set_rules('CPEPeriodo', 'Periodo', "trim|required|min_length[2]|max_length[2]");
        $this->form_validation->set_rules('CPEPeriodoSem', 'Semestre', "trim|required|min_length[1]|max_length[1]");
        $this->form_validation->set_rules('InicioPeriodo', 'Inicio de Periodo', "trim|required|min_length[10]|max_length[10]");
        $this->form_validation->set_rules('FinPeriodo', 'Fin de Periodo', "trim|required|min_length[10]|max_length[10]");
    }
}
?>