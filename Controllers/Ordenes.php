<?php
class Ordenes extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /***** ORDEN DE COMPRA *****/
    public function compra()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 10);

        if (!empty($verificar)) {
            $data['title'] = 'Ordenes Internas - Orden de Compra | KYPBioingeniería';
            $data['activeOrdenCompra'] = 'active';
            $data['scripts'] = 'Ordenes/ordenCompra.js';
            $this->views->getView('Ordenes', 'compra', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function InsertarDetallesCompra()
    {
        $id_user = $_SESSION['id_usuario'];
        $des = $_POST['DesOC'];
        $uni = $_POST['UniOC'];
        $can = $_POST['CantidadOC'];
        $pre = $_POST['PrecioOC'];
        $sub = $can * $pre;

        $data = $this->model->InsertarDetalle($id_user, $des, $uni, $can, $pre, $sub);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Ingresado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Ingresado');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarDetalle()
    {
        $id_user = $_SESSION['id_usuario'];
        $data['Lista'] = $this->model->ListarDetalles($id_user);
        $data['Total'] = $this->model->CalcularTotal($id_user);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function EliminarDetalle($id)
    {
        $data = $this->model->EliminarDetalle($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Eliminado');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarOrdenCompra()
    {
        $id = $_SESSION['id_usuario'];
        $area = $_POST['Area'];
        $nece = $_POST['Necesidad'];
        $concep = $_POST['Concepto'];
        $total = $_POST['OCTotal'];
        $moneda = $_POST['Moneda'];
        $blob = $this->Recibo($area, $nece, $concep, $total, $moneda);

        $data = $this->model->RegistrarOrdenCompra($area, $nece, $concep, $moneda, $total, $blob);
        if ($data != NULL) {
            $this->model->EliminarTodosDetalles($id);
            $res = array('tipo' => 'success', 'mensaje' => 'Orden Compra Realizada', 'id' => $data);
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Orden Compra Realizada');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Recibo($area, $nece, $concep, $total, $moneda)
    {
        require('./include/fpdf_box.php');

        $id = $_SESSION['id_usuario'];
        $cod = $this->model->MaxAu1();
        $datos = $this->model->ListarDatos($id);
        $data = array();

        $pdf = new PDF('P');
        $pdf->AddPage();


        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 24);
        $pdf->Cell(30, 7, 'Orden de Compra', 0);
        $pdf->Ln(16);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(95, 7, utf8_decode('Necesidad: ' . $nece), 0, 0);
        $pdf->Cell(0, 7, utf8_decode('N° Orden: #' . $cod['nuevo_numero']), 0, 0, 'R');
        $pdf->Ln(7);
        $pdf->Cell(95, 7, utf8_decode('Área: ' . $area), 0, 0);
        $pdf->Cell(0, 7, utf8_decode('Fecha: ' . date('Y-m-d')), 0, 0, 'R');
        $pdf->Ln(7);
        $pdf->Cell(0, 7, utf8_decode('Concepto: ' . $concep), 0, 0);
        $pdf->Ln(15);

        $pdf->Image(BASE_URL . 'Assets/img/encabezado.png', 163, 6, 35, 13, 'png');

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetDrawColor(117, 185, 202);
        $pdf->Cell(22, 7, utf8_decode('Cantidad'), 1, 0, 'C');
        $pdf->Cell(90, 7, utf8_decode(' Descripción'), 1, 0,);
        $pdf->Cell(18, 7, utf8_decode('Uni.'), 1, 0, 'C');
        $pdf->Cell(30, 7, utf8_decode('SubTotal'), 1, 0, 'C');
        $pdf->Cell(30, 7, utf8_decode('Total'), 1, 0, 'C');
        $pdf->Ln(7);



        $pdf->SetFont('RubikMedium', '', 10);
        $pdf->tablewidths = array(22, 90, 18, 30, 30);

        $pdf->SetFont('RubikRegular', '', 10);
        foreach ($datos as $row) {
            $data[] = array($row['CANTIDAD'], utf8_decode($row['DESCRIPCION']), utf8_decode($row['UNIDADES']), $moneda.' '.$row['PRECIO_U'],  $moneda.' '.$row['SUB_TOTAL']);
        }


        $pdf->morepagestable($data, 9);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(22, 7, '', 0, 0);
        $pdf->Cell(90, 7, '', 0, 0);
        $pdf->Cell(18, 7, '', 0, 0);
        $pdf->Cell(30, 7, 'TOTAL: ', 0, 0, 'C');
        $pdf->Cell(30, 7, $moneda. ' ' . $total, 0, 0, 'C');
        $pdf->Ln(25);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(95, 7, '-----------------------------------', 0, 0, 'C');
        $pdf->Cell(95, 7, '-----------------------------------', 0, 0, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(95, 7, utf8_decode($area), 0, 0, 'C');
        $pdf->Cell(95, 7, utf8_decode('Administración'), 0, 0, 'C');

        $servi = $pdf->Output('S', 'OrdenCompra.pdf');
        return $servi;
    }

    public function MostrarRecibo($id)
    {
        $data = $this->model->MostrarPDF($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarOC()
    {
        $data = $this->model->ListarOrdenCompra();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['TOTAL'] = '<span class="badge bg-label-info">S/. ' . $data[$i]['TOTAL'] . '</span>';
            $data[$i]['ACCIONES'] = '
                <button type="button" class="btn btn-icon btn-label-danger waves-effect" onclick="MostrarRecibo(\'' . $data[$i]['ID'] . '\')">
                    <i class="mdi mdi-file-document-outline">
                    </i>
                </button>
            ';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    /***** /ORDEN DE COMPRA *****/



    /***** ORDEN DE TRABAJO *****/

    public function trabajo()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 11);

        if (!empty($verificar)) {
            $data['title'] = 'Ordenes Internas - Orden de Trabajo | KYPBioingeniería';
            $data['activeOrdenTrabajo'] = 'active';
            $data['scripts'] = 'Ordenes/ordenTrabajo.js';
            $this->views->getView('Ordenes', 'trabajo', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    /***** /ORDEN DE TRABAJO *****/
}
