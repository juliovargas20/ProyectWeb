<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
                        <button type="button" class="dropdown-item" onclick="MostrarIngresosRecibo(' . $data[$i]['IN_ID'] . ')">
                            <i class="mdi mdi-pencil-outline me-1"></i> 
                            Editar
                        </button>
                        <button type="button" class="dropdown-item" onclick="EliminarIngres(' . $data[$i]['IN_ID'] . ')">
                            <i class="mdi mdi-trash-can-outline me-1"></i> 
                            Eliminar
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
                        <button type="button" class="dropdown-item" onclick="EliminarIngres(' . $data[$i]['IN_ID'] . ')">
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
            $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="MostrarEgresos(' . $data[$i]['SAL_ID'] . ')">
                            <i class="mdi mdi-pencil-outline me-1"></i> 
                            Editar
                        </button>
                        <button type="button" class="dropdown-item" onclick="EliminarEgres(' . $data[$i]['SAL_ID'] . ')">
                            <i class="mdi mdi-trash-can-outline me-1"></i> 
                            Eliminar
                        </button>
                    </div>
                </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarRecibos()
    {
        $data = $this->model->ListarRecibos();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['IN_MONTO'] = '<span class="badge rounded-pill bg-label-info">S/. ' . $data[$i]['IN_MONTO'] . '</span>';
            $data[$i]['ACCIONES'] = '
            <button type="button" class="btn btn-icon btn-label-danger waves-effect" onclick="ReciboPdf(' . $data[$i]['IN_ID'] . ')">
                <i class="mdi mdi-file-document-outline">
                </i>
            </button>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarIngreso()
    {
        $id = $_POST['ID_IN'];
        $tranx = $_POST['Tranx'];
        $com = $_POST['Comprobante'];
        $n = $_POST['NCom'];
        $respo = $_POST['Responsable'];
        $tip = $_POST['TipPago'];
        $des = $_POST['Dsc'];
        $area = $_POST['Area'];
        $monto = $_POST['Monto'];

        if ($id == '') {
            $data = $this->model->RegistrarIngreso($tranx, $com, $n, $respo, $tip, $des, $area, $monto);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'msg' => 'Ingreso Registrado', 'id' => $data, 'condicion' => 'registrado');
            } else {
                $res = array('tipo' => 'error', 'msg' => 'error Ingreso Registrado');
            }
        } else {
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

    public function EliminarIngreso($id)
    {
        $data = $this->model->EliminarIngreso($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Ingreso Eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Ingreso Eliminado');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarEgreso()
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
            $data = $this->model->RegistrarEgreso($tranx, $com, $n, $respo, $tip, $des, $area, $monto);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'msg' => 'Egreso Registrado');
            } else {
                $res = array('tipo' => 'error', 'msg' => 'error Egreso Registrado');
            }
        } else {
            $data = $this->model->ModificarEgreso($id, $tranx, $com, $n, $respo, $tip, $des, $area, $monto);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'msg' => 'Egreso Modificado');
            } else {
                $res = array('tipo' => 'error', 'msg' => 'error Egreso Modificado');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function MostrarEgresos($id)
    {
        $data = $this->model->MostraEgresos($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function EliminarEgreso($id)
    {
        $data = $this->model->EliminarEgreso($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'msg' => 'Egreso Eliminado');
        } else {
            $res = array('tipo' => 'error', 'msg' => 'error Egreso Eliminado');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function IDMaxRecibo()
    {
        $data = $this->model->IdRecibo();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarRecibo($id)
    {
        $data = $this->model->RegistrarRecibo($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'msg' => 'Recibo Registrado', 'id' => $data);
        } else {
            $res = array('tipo' => 'error', 'msg' => 'error Recibo Registrado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ReciboPDF($id)
    {
        require('Assets/vendor/libs/fpdf/fpdf.php');

        $datos = $this->model->MostraIngresos($id);
        $id_recibo = $this->model->DatosReciboID($datos['IN_ID']);

        $pdf = new FPDF();
        $pdf->AddPage('PORTRAIT', 'A4');

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 18);
        $pdf->Cell(0, 10, utf8_decode('RECIBO'), 0, 0, 'C');
        $pdf->Ln(15);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(95, 10, utf8_decode('Fecha: ' . $id_recibo['FECHA']), 0, 0, 'L');
        $pdf->Cell(0, 10, utf8_decode('N° Recibo: 00' . $id_recibo['ID']), 0, 0, 'R');
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 6, utf8_decode('Responsable: ' . $datos['IN_RESPONSABLE']), 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(95, 6, utf8_decode('Transacción: ' . $datos['IN_TRANSACCION']), 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(95, 6, utf8_decode('Tipo de Pago: ' . $datos['IN_TIP_PAGO']), 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(95, 6, utf8_decode('Área: ' . $datos['IN_AREA']), 0, 0, 'L');
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(192, 192, 192);
        $pdf->Cell(0, 8, utf8_decode('  Descripción'), 0, 0, 'L', true);
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5, utf8_decode($datos['IN_DESCRIPCION']), 0, 'L');
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 8, utf8_decode('  TOTAL: S/. ' . $datos['IN_MONTO']), 0, 0, 'R');
        $pdf->Ln(15);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 8, '__________________', 0, 0, 'C', false);
        $pdf->Cell(95, 8, '__________________', 0, 0, 'C', false);
        $pdf->Ln(4);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 8, utf8_decode('Administración'), 0, 0, 'C');
        $pdf->Cell(95, 8, 'Responsable', 0, 0, 'C');
        $pdf->Ln(30);




        $pdf->SetFont('RubikMedium', '', 18);
        $pdf->Cell(0, 10, utf8_decode('RECIBO'), 0, 0, 'C');
        $pdf->Ln(15);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(95, 10, utf8_decode('Fecha: ' . $id_recibo['FECHA']), 0, 0, 'L');
        $pdf->Cell(0, 10, utf8_decode('N° Recibo: 00' . $id_recibo['ID']), 0, 0, 'R');
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 6, utf8_decode('Responsable: ' . $datos['IN_RESPONSABLE']), 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(95, 6, utf8_decode('Transacción: ' . $datos['IN_TRANSACCION']), 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(95, 6, utf8_decode('Tipo de Pago: ' . $datos['IN_TIP_PAGO']), 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(95, 6, utf8_decode('Área: ' . $datos['IN_AREA']), 0, 0, 'L');
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(192, 192, 192);
        $pdf->Cell(0, 8, utf8_decode('  Descripción'), 0, 0, 'L', true);
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5, utf8_decode($datos['IN_DESCRIPCION']), 0, 'L');
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 8, utf8_decode('  TOTAL: S/. ' . $datos['IN_MONTO']), 0, 0, 'R');
        $pdf->Ln(15);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 8, '__________________', 0, 0, 'C', false);
        $pdf->Cell(95, 8, '__________________', 0, 0, 'C', false);
        $pdf->Ln(4);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 8, utf8_decode('Administración'), 0, 0, 'C');
        $pdf->Cell(95, 8, 'Responsable', 0, 0, 'C');
        $pdf->Ln(6);

        $pdf->Output("I", "Recibo.pdf");

        die();
    }

    public function CerrarCaja()
    {
        require('./include/fpdf_box.php');

        $datos = $this->model->ListarIngresosCaja();
        $salida = $this->model->ListarEgresosCaja();
        $totalIngreso = $this->model->TotalIngresosCaja();
        $totalEgreso = $this->model->TotalEgresosCaja();

        $total = $totalIngreso['IN_MONTO'] - $totalEgreso['SAL_MONTO'];

        $pdf = new PDF('L', 'pt');
        $pdf->AddPage();


        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->SetTextColor(220, 50, 50);
        $pdf->Cell(0, 20, utf8_decode('Reporte Caja Chica'), 0, 1, 'L', false);
        $pdf->Ln(25);

        $pdf->SetFont('RubikMedium', '', 18);
        $pdf->SetTextColor(33, 163, 102);
        $pdf->Cell(0, 20, utf8_decode('KYP BIOINGEN S.A.C'), 0, 1, 'L', false);
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 16);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 20, utf8_decode('Resumen TOTAL S/. ' . $total), 0, 1, 'L', false);
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 20, utf8_decode('Reporte Ingresos del ' . $totalIngreso['IN_FECHA']), 0, 1, 'L', false);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 9);
        $pdf->Cell(0, 20, utf8_decode('Total Ingresos      S/. ' . $totalIngreso['IN_MONTO']), 0, 1, 'L', false);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 10);
        $pdf->SetDrawColor(155, 155, 155);
        $pdf->tablewidths = array(70, 80, 90, 85, 90, 90, 100, 90, 90);
        for ($i = 0; $i < 1; $i++) {
            $data[] = array('FECHA', 'TRANSACCION', 'COMPROBANTE', utf8_decode('N° COMPROB.'), 'RESPONSABLE', 'TIPO DE PAGO', 'DESCRIPCION', 'AREA', 'MONTO');
        }

        $pdf->Ln(10);

        $pdf->tablewidths = array(70, 80, 90, 85, 90, 90, 100, 90, 90);

        $pdf->SetFont('RubikRegular', '', 10);
        foreach ($datos as $row) {
            $data[] = array($row['IN_FECHA'], $row['IN_TRANSACCION'], $row['IN_COMPROBANTE'], $row['IN_NCOMPRO'], utf8_decode($row['IN_RESPONSABLE']), $row['IN_TIP_PAGO'], utf8_decode($row['IN_DESCRIPCION']), utf8_decode($row['IN_AREA']), 'S/. ' . $row['IN_MONTO']);
        }

        $pdf->morepagestable($data, 20);
        $pdf->Ln(50);


        $pdf->SetFont('RubikMedium', '', 12);
        //$pdf->SetTextColor(220,50,50);
        $pdf->Cell(0, 20, utf8_decode('Reporte Egresos del ' . $totalEgreso['SAL_FECHA']), 0, 1, 'L', false);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 9);
        $pdf->Cell(0, 20, utf8_decode('Total Egresos    S/. ' . $totalEgreso['SAL_MONTO']), 0, 1, 'L', false);
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 10);

        $pdf->tablewidths = array(70, 80, 90, 85, 90, 90, 100, 90, 90);
        for ($i = 0; $i < 1; $i++) {
            $data2[] = array('FECHA', 'TRANSACCION', 'COMPROBANTE', utf8_decode('N° COMPROB.'), 'RESPONSABLE', 'TIPO DE PAGO', 'DESCRIPCION', 'AREA', 'MONTO');
        }

        $pdf->Ln(10);

        $pdf->tablewidths = array(70, 80, 90, 85, 90, 90, 100, 90, 90);

        foreach ($salida as $row) {
            $data2[] = array($row['SAL_FECHA'], $row['SAL_TRANSACCION'], $row['SAL_COMPROBANTE'], $row['SAL_NCOMPRO'], utf8_decode($row['SAL_RESPONSABLE']), $row['SAL_TIP_PAGO'], utf8_decode($row['SAL_DESCRIPCION']), utf8_decode($row['SAL_AREA']), 'S/. ' . $row['SAL_MONTO']);
        }

        $pdf->morepagestable($data2, 20);

        $Servi = $pdf->Output('S', 'Reporte ' . $totalIngreso['IN_FECHA'], true);
        $this->model->CerrarCaja($total, $Servi);
        $pdf->Output('I', 'Reporte ' . $totalIngreso['IN_FECHA']);
        die();
    }

    public function ListaResumenCaja()
    {
        $data = $this->model->ListaResumenCaja();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['MONTO'] = '<span class="badge rounded-pill bg-label-info">S/. ' . $data[$i]['MONTO'] . '</span>';
            $data[$i]['ACCIONES'] = '<button type="button" class="btn btn-icon btn-label-secondary waves-effect" onclick="VerPDFcaja(' . $data[$i]['ID'] . ')">
            <i class="mdi mdi-file-document-outline">
            </i>
        </button>
        <button type="button" class="btn btn-icon btn-label-danger waves-effect" onclick="EliminarCerrarCaja(' . $data[$i]['ID'] . ')">
            <i class="mdi mdi-trash-can-outline">
            </i>
        </button>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function EliminarResumenCaja($id)
    {
        $data = $this->model->EliminarResumenCaja($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'msg' => 'Caja Eliminada');
        } else {
            $res = array('tipo' => 'error', 'msg' => 'error Caja Eliminado');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();

    }

    public function VerPDFCaja($id)
    {
        $data = $this->model->VerPDFCaja($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ReportExcel()
    {
        $spreadsheet = new Spreadsheet();

        $listIngresos = $this->model->ListarIngresosExcel();
        $listEgresos = $this->model->ListarEgresosExcel();

        // Crear la hoja de "Ingresos"
        $sheetIngresos = $spreadsheet->getActiveSheet();
        $sheetIngresos->setTitle("Ingresos");

        // Agregar datos a la hoja de "Ingresos" (tabla de ejemplo)
        $sheetIngresos->setCellValue('A1', 'Fecha');
        $sheetIngresos->setCellValue('B1', 'Transacción');
        $sheetIngresos->setCellValue('C1', 'Comprobante');
        $sheetIngresos->setCellValue('D1', 'N° Comprobante');
        $sheetIngresos->setCellValue('E1', 'Responsable');
        $sheetIngresos->setCellValue('F1', 'Tipo de Pago');
        $sheetIngresos->setCellValue('G1', 'Descripción');
        $sheetIngresos->setCellValue('H1', 'Area');
        $sheetIngresos->setCellValue('I1', 'Monto');


        $row = 2;
        foreach ($listIngresos as $rowData) {
            $sheetIngresos->setCellValue('A' . $row, $rowData['IN_FECHA']);
            $sheetIngresos->getStyle('A' . $row)->getNumberFormat()->setFormatCode('yyyy-mm-dd');
            $sheetIngresos->setCellValue('B' . $row, $rowData['IN_TRANSACCION']);
            $sheetIngresos->setCellValue('C' . $row, $rowData['IN_COMPROBANTE']);
            $sheetIngresos->setCellValue('D' . $row, $rowData['IN_NCOMPRO']);
            $sheetIngresos->setCellValue('E' . $row, $rowData['IN_RESPONSABLE']);
            $sheetIngresos->setCellValue('F' . $row, $rowData['IN_TIP_PAGO']);
            $sheetIngresos->setCellValue('G' . $row, $rowData['IN_DESCRIPCION']);
            $sheetIngresos->setCellValue('H' . $row, $rowData['IN_AREA']);
            $sheetIngresos->setCellValue('I' . $row, $rowData['IN_MONTO']);

            $sheetIngresos->getColumnDimension('A')->setAutoSize(true);
            $sheetIngresos->getColumnDimension('B')->setAutoSize(true);
            $sheetIngresos->getColumnDimension('C')->setAutoSize(true);
            $sheetIngresos->getColumnDimension('D')->setAutoSize(true);
            $sheetIngresos->getColumnDimension('E')->setAutoSize(true);
            $sheetIngresos->getColumnDimension('F')->setAutoSize(true);
            $sheetIngresos->getColumnDimension('G')->setAutoSize(true);
            $sheetIngresos->getColumnDimension('H')->setAutoSize(true);
            $sheetIngresos->getColumnDimension('I')->setAutoSize(true);
            $row++;
        }

        // Crear la hoja de "Egresos"
        $sheetEgresos = $spreadsheet->createSheet();
        $sheetEgresos->setTitle("Egresos");

        $sheetEgresos->setCellValue('A1', 'Fecha');
        $sheetEgresos->setCellValue('B1', 'Transacción');
        $sheetEgresos->setCellValue('C1', 'Comprobante');
        $sheetEgresos->setCellValue('D1', 'N° Comprobante');
        $sheetEgresos->setCellValue('E1', 'Responsable');
        $sheetEgresos->setCellValue('F1', 'Tipo de Pago');
        $sheetEgresos->setCellValue('G1', 'Descripción');
        $sheetEgresos->setCellValue('H1', 'Area');
        $sheetEgresos->setCellValue('I1', 'Monto');


        $rowE = 2;
        foreach ($listEgresos as $rowData) {
            $sheetEgresos->setCellValue('A' . $rowE, $rowData['SAL_FECHA']);
            $sheetEgresos->getStyle('A' . $rowE)->getNumberFormat()->setFormatCode('yyyy-mm-dd');
            $sheetEgresos->setCellValue('B' . $rowE, $rowData['SAL_TRANSACCION']);
            $sheetEgresos->setCellValue('C' . $rowE, $rowData['SAL_COMPROBANTE']);
            $sheetEgresos->setCellValue('D' . $rowE, $rowData['SAL_NCOMPRO']);
            $sheetEgresos->setCellValue('E' . $rowE, $rowData['SAL_RESPONSABLE']);
            $sheetEgresos->setCellValue('F' . $rowE, $rowData['SAL_TIP_PAGO']);
            $sheetEgresos->setCellValue('G' . $rowE, $rowData['SAL_DESCRIPCION']);
            $sheetEgresos->setCellValue('H' . $rowE, $rowData['SAL_AREA']);
            $sheetEgresos->setCellValue('I' . $rowE, $rowData['SAL_MONTO']);

            $sheetEgresos->getColumnDimension('A')->setAutoSize(true);
            $sheetEgresos->getColumnDimension('B')->setAutoSize(true);
            $sheetEgresos->getColumnDimension('C')->setAutoSize(true);
            $sheetEgresos->getColumnDimension('D')->setAutoSize(true);
            $sheetEgresos->getColumnDimension('E')->setAutoSize(true);
            $sheetEgresos->getColumnDimension('F')->setAutoSize(true);
            $sheetEgresos->getColumnDimension('G')->setAutoSize(true);
            $sheetEgresos->getColumnDimension('H')->setAutoSize(true);
            $sheetEgresos->getColumnDimension('I')->setAutoSize(true);
            $rowE++;
        }

        // Crear un archivo Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'reporte_ingresos_egresos.xlsx';

        // Descargar el archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save('php://output');
    }
}
