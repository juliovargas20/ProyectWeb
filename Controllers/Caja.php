<?php
class Caja extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Caja Empresarial - Caja | KYPBioingeniería';
        $data['activeCaja'] = 'active';
        $data['scripts'] = 'Caja/caja.js';
        $this->views->getView('Caja', 'CajaChica', $data);
    }

    public function TotalIngresos()
    {
        $data = $this->model->CalcularIngresos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function TotalEgresos()
    {
        $data = $this->model->CalcularEgresos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RestaTotal()
    {
        $data = $this->model->TotalIngresoEgresos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarIngresos()
    {
        $data = $this->model->ListarIngresos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['IN_COMPROBANTE'] == "Recibo") {
                $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="">
                            <i class="mdi mdi-pencil-outline me-1"></i> 
                            Editar
                        </button>
                        <button type="button" class="dropdown-item" onclick="">
                            <i class="mdi mdi-trash-can-outline me-1"></i> 
                            Eliminar
                        </button>
                        <button type="button" class="dropdown-item" onclick="">
                            <i class="mdi mdi-file-pdf-box me-1"></i> 
                            Ver Ficha
                        </button>
                    </div>
                </div>';
            } else {
                $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="MostrarIngresos(' . $data[$i]['IN_ID'] . ')">
                            <i class="mdi mdi-pencil-outline me-1"></i> 
                            Editar
                        </button>
                        <button type="button" class="dropdown-item" onclick="">
                            <i class="mdi mdi-trash-can-outline me-1"></i> 
                            Eliminar
                        </button>
                    </div>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarEgresos()
    {
        $data = $this->model->ListarEgresos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['SAL_COMPROBANTE'] == "Recibo") {
                $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="">
                            <i class="mdi mdi-pencil-outline me-1"></i> 
                            Editar
                        </button>
                        <button type="button" class="dropdown-item" onclick="">
                            <i class="mdi mdi-trash-can-outline me-1"></i> 
                            Eliminar
                        </button>
                        <button type="button" class="dropdown-item" onclick="">
                            <i class="mdi mdi-file-pdf-box me-1"></i> 
                            Ver Ficha
                        </button>
                    </div>
                </div>';
            } else {
                $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="">
                            <i class="mdi mdi-pencil-outline me-1"></i> 
                            Editar
                        </button>
                        <button type="button" class="dropdown-item" onclick="">
                            <i class="mdi mdi-trash-can-outline me-1"></i> 
                            Eliminar
                        </button>
                    </div>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarIngreso()
    {
        $id = $_POST['ID'];
        $tranx = $_POST['Tranx'];
        $com = $_POST['Comprobante'];
        $n = $_POST['NCom'];
        $respo = $_POST['Responsable'];
        $tip = $_POST['TipPago'];
        $des = $_POST['Dsc'];
        $area = $_POST['Area'];
        $monto = $_POST['Monto'];

        if (empty($id)) {
            $data = $this->model->RegistrarIngreso($tranx, $com, $n, $respo, $tip, $des, $area, $monto);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'msg' => 'Ingreso Registrado', 'condicion' => 'registro');
            } else {
                $res = array('tipo' => 'error', 'msg' => 'error Ingreso Registrado');
            }
        } else{
            $data = $this->model->ModificarIngreso($id, $tranx, $com, $n, $respo, $tip, $des, $area, $monto);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'msg' => 'Ingreso Modificado', 'condicion' => 'modificado');
            } else {
                $res = array('tipo' => 'error', 'msg' => 'error Ingreso Modificado');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function MostrarIngresos($id)
    {
        $data = $this->model->MostraIngresos($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarEgreso()
    {
        $tranx = $_POST['Tranx'];
        $com = $_POST['Comprobante'];
        $n = $_POST['NCom'];
        $respo = $_POST['Responsable'];
        $tip = $_POST['TipPago'];
        $des = $_POST['Dsc'];
        $area = $_POST['Area'];
        $monto = $_POST['Monto'];

        $data = $this->model->RegistrarEgreso($tranx, $com, $n, $respo, $tip, $des, $area, $monto);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'msg' => 'Egreso Registrado');
        } else {
            $res = array('tipo' => 'error', 'msg' => 'error Egreso Registrado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Reporte()
    {
        require('./include/fpdf_box.php');

        $pdf = new PDF('P', 'pt');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(0, 20, 'Example to build a table over more than one page');
        $pdf->SetFont('Arial', '', 10);

        $pdf->tablewidths = array(100, 90, 90, 90, 90, 90);
        for ($i = 0; $i < 1; $i++) {
            $data[] = array('TITULO 1', 'TITULO 1', 'TITULO 1', 'TITULO 1', 'TITULO 1', 'TITULO 1');
        }

        $pdf->Ln(10);

        $pdf->tablewidths = array(100, 90, 90, 90, 90, 90);
        for ($i = 0; $i < 4; $i++) {
            $data[] = array('JULIO EDGAR VARGAS TELLO "="#($($(xddddddddddfdfddfdfdfd', 'JULIO EDGAR VARGAS TELLO "="#($($(', 'JULIO EDGAR VARGAS TELLO "="#($($(', 'JULIO EDGAR VARGAS TELLO "="#($($(', 'JULIO EDGAR VARGAS TELLO "="#($($(', 'JULIO EDGAR VARGAS TELLO "="#($($(');
        }
        $pdf->morepagestable($data, 20);
        $pdf->Output();
    }
}
