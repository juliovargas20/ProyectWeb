<?php
class Consentimiento extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function consen()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 12);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Carta Consentimiento | KYPBioingeniería';
            $data['activeConsen'] = 'active';
            $data['scripts'] = 'Consentimiento/Listado.js';
            $this->views->getView('Consentimiento', 'listado', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function Listar()
    {
        $data = $this->model->Listar();
        for ($i=0; $i < count($data); $i++) { 

            if ($data[$i]['CONSEN'] == 0) {
                $data[$i]['ACCIONES'] = '
                    <button type="button" class="btn btn-icon btn-label-danger waves-effect" onclick="redirect(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                        <i class="mdi mdi-eye-outline">
                        </i>
                    </button>
                ';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function agregar($id)
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 12);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Carta Consentimiento | KYPBioingeniería';
            $data['activeConsen'] = 'active';
            $data['scripts'] = 'Consentimiento/agregar.js';
            $data['get'] = $this->model->getDatos($id);
            $this->views->getView('Consentimiento', 'agregar', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function RegistrarDatos()
    {
        $id_paciente = $_POST['id_paciente'];
        $tip = $_POST['tip_trab'];
        $sub = $_POST['sub_trab'];

        $data = $this->model->RegistrarDatos($id_paciente, $tip, $sub);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Datos Registrado', 'id' => $data);
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Datos Contrato');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarLista($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $item = $data['selecciones'];

        for ($i = 0; $i < count($item); $i++) {
            $lista = $item[$i];
            $data = $this->model->RegistrarLista($id, $lista);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Lista Registrada');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'error Lista Registrada');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();

    }

    public function CartaSP()
    {
        require('Assets/vendor/libs/fpdf/fpdf.php');

        $pdf = new FPDF();

        $pdf->AddPage();
        $pdf->SetLeftMargin(22.4);
        $pdf->SetRightMargin(22.4);

        $pdf->Image(BASE_URL . 'Assets/img/encabezado.png', 85, 8, 38, 15, 'png');
        $pdf->Ln(20);
        
        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $dia = date('d');
        $mes = date('m');
        $año = date('Y');

        $nombre_mes = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');

        $fecha_hoy = $dia . ' de ' . $nombre_mes[$mes] . ' del ' . $año;

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Lima, '.$fecha_hoy), 1, 1, 'R');
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Señores:'), 1, 1);
        $pdf->Ln(0);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Luis Calderón Castro'), 1, 1);
        $pdf->Ln(0);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Lima'), 1, 1);
        $pdf->Ln(0);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Presente.-'), 1, 1);
        $pdf->Ln(5);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Ref.: CARTA DE CONFORMIDAD'), 1, 1, 'C');
        $pdf->Ln(0);

        $pdf->Output();
    }
}
