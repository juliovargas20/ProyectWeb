<?php
class Logistica extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /************** <LISTADO DE PACIENTES> **************/

    public function importaciones()
    {
        $data['title'] = 'Logística - Orden de Importaciones | KYPBioingeniería';
        $data['activeImport'] = 'active';
        $data['scripts'] = 'Logistica/importaciones.js';
        $this->views->getView('Logistica', 'importacion', $data);
    }

    public function RegistroDetallePro()
    {
        $id = $_POST['ID_Provee'];
        $id_user = $_SESSION['id_usuario'];
        $nombre = $_POST['NombreProve'];
        $pais = $_POST['PaisProve'];
        $tel_pro = $_POST['TelProve'];
        $pagina = $_POST['PaginaPro'];
        $ven = $_POST['Vendedor'];
        $tel_ven = $_POST['VenTel'];
        $cantidad = $_POST['Cantidad'];
        $producto = $_POST['Producto'];
        $des = $_POST['Descripcion'];
        $link = $_POST['Link'];
        $obs = $_POST['Obs'];
        $moneda = $_POST['Moneda'];
        $precio = $_POST['Precio'];

        if (empty($id)) {
            $data = $this->model->RegistarDetallePro($nombre, $pais, $tel_pro, $pagina, $ven, $tel_ven, $cantidad, $producto, $des, $link, $obs, $id_user, $moneda, $precio);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Detalle Registrado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al Registrar Detalle');
            }
        } else {
            $data = $this->model->Modificar($id, $nombre, $pais, $tel_pro, $pagina, $ven, $tel_ven, $cantidad, $producto, $des, $link, $obs, $moneda, $precio);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Detalle Modificado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al Modificado Detalle');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Listar()
    {
        $id_user = $_SESSION['id_usuario'];
        $data = $this->model->Listar($id_user);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Mostrar($id)
    {
        $data = $this->model->Mostrar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Eliminar($id)
    {
        $data = $this->model->Eliminar($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Detalle Eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Detalle Eliminado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Pdf()
    {
        require('include/fpdf_temp.php');

        $id_user = 1;
        $datos = $this->model->getDatos($id_user);

        $pdf = new PDF_MC_Table('L');
        $pdf->AddPage();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikRegular', '', 14);
        $pdf->SetX(235);
        $pdf->Cell(50, 5, 'Fecha: ' . date("Y-m-d"), 0, 0,  'R');
        $pdf->Ln(5);

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->SetX(235);
        $pdf->Cell(50, 5, utf8_decode('N°: OI000001'), 0, 0, 'R');

        $pdf->Image(BASE_URL . 'Assets/img/encabezado.png', 10, 8, 38, 15, 'png');
        $pdf->Ln(25);

        foreach ($datos as $row) {
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->Cell(120, 7, utf8_decode('Proveedor: '.$row['PRO_NOMBRE']), 0, 0);
            $pdf->Cell(0, 7, utf8_decode('Página Web: enlace de la página'), 0, 1, 'R', false, $row['PAGINA']);
            $pdf->Cell(120, 7, utf8_decode('Pais Proveedor: '.$row['PAIS']), 0, 0);
            $pdf->Cell(0, 7, utf8_decode('Vendedor: '.$row['VENDEDOR']), 0, 1, 'R');
            $pdf->Cell(120, 7, utf8_decode('Telefono Proveedor: '.$row['TEL_PRO']), 0, 0);
            $pdf->Cell(0, 7, utf8_decode('Telefono Vendedor: '.$row['TEL_VENDEDOR']), 0, 1, 'R');
            $pdf->Ln(10);

            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->Cell(25, 7, utf8_decode('Cantidad'), 1, 0, 'C');
            $pdf->Cell(90, 7, utf8_decode('Producto'), 1, 0, 'C');
            $pdf->Cell(90, 7, utf8_decode('Descripción'), 1, 0);
            $pdf->Cell(40, 7, utf8_decode('Link Producto'), 1, 0, 'C');
            $pdf->Cell(0, 7, utf8_decode('Precio'), 1, 0, 'C');
            $pdf->Ln(7);

            $pdf->Cell(25, 7, utf8_decode($row['CANTIDAD']), 1, 0, 'C');
            $pdf->Cell(90, 7, utf8_decode($row['PRODUCTO']), 1, 0, 'C');
            $pdf->Cell(90, 7, utf8_decode($row['DESCRIPCION']), 1, 0);
            $pdf->Cell(40, 7, utf8_decode('enlace'), 1, 0, 'C', false, $row['LINK']);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 7, utf8_decode($row['MONEDA']. ' '. $row['PRECIO']), 1, 0, 'C');
            $pdf->Ln(15);
        }

        $pdf->SetFont('RubikRegular', '', 16);

    
        $pdf->Output();
    }
}
