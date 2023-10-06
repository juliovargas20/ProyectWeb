<?php
class Citas extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /************** <LISTADO DE PACIENTES> **************/

    public function index()
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 6);

        if (!empty($verificar)) {
            $data['title'] = 'Visitas Médicas - Citas | KYPBioingeniería';
            $data['activeCitas'] = 'active';
            $data['scripts'] = 'Citas/citas.js';
            $this->views->getView('Citas', 'citas', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function Listar()
    {
        $data = $this->model->ListarVisme();
        for ($i = 0; $i < COUNT($data); $i++) {
            $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="visualizarCentro(' . $data[$i]['ID'] . ');">
                            <i class="mdi mdi-eye-outline mdi-20px mx-1"></i> 
                            Visualizar
                        </button>
                    </div>
                </div>
            ';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarOr()
    {
        $data = $this->model->ListarOrtoP();
        for ($i = 0; $i < COUNT($data); $i++) {
            $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="visualizarOR(' . $data[$i]['ID'] . ')">
                            <i class="mdi mdi-eye-outline mdi-20px mx-1"></i> 
                            Visualizar
                        </button>
                    </div>
                </div>
            ';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }



    public function RegistrarVisme()
    {
        $inicio = $_POST['Etime'];
        $salida = $_POST['Stime'];
        $censa = $_POST['CenSalud'];
        $nomdoc = $_POST['NomDoc'];
        $time = $_POST['TimeVis'];
        $desarrollo = $_POST['Desarrollo'];
        $conclusion = $_POST['Conclusion'];
        $correo = $_POST['Correo'];
        $celular = $_POST['Celular'];
        $fechanac = $_POST['FechaNac'];
        $visitador = $_SESSION['nombres'];

        $data = $this->model->RegistrarCensa($inicio, $salida, $censa, $nomdoc, $time, $desarrollo, $conclusion, $correo, $celular, $fechanac, $visitador);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Visita Registrada');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Visita Registrado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function MostrarCenSa($id)
    {
        $data = $this->model->MostrarCenSalud($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function RegistrarOR()
    {
        $inicio = $_POST['EtimeOr'];
        $salida = $_POST['StimeOr'];
        $tienda = $_POST['Tienda'];
        $nomenc = $_POST['NomEnc'];
        $time = $_POST['TimeOr'];
        $desarrollo = $_POST['DesarrolloOr'];
        $conclusion = $_POST['ConclusionOr'];
        $correo = $_POST['CorreoOr'];
        $celular = $_POST['CelularOr'];
        $ruc = $_POST['Ruc'];
        $visitador = $_SESSION['nombres'];

        $data = $this->model->RegistrarOr($inicio, $salida, $tienda, $nomenc, $time, $desarrollo, $conclusion, $correo, $celular, $ruc, $visitador);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Ortopedia Registrada');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Ortopedia Registrado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function MostrarOr($id)
    {
        $data = $this->model->MostrarOr($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
