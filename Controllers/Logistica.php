<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class Logistica extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /************** <IMPORTACIONES> **************/

    public function importaciones()
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 13);

        if (!empty($verificar)) {
            $data['title'] = 'Logística - Orden de Importaciones | KYPBioingeniería';
            $data['activeImport'] = 'active';
            $data['scripts'] = 'Logistica/importaciones.js';
            $this->views->getView('Logistica', 'importacion', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
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

    public function Pdf($area)
    {
        require('include/fpdf_temp.php');

        $id_user = $_SESSION['id_usuario'];
        $datos = $this->model->getDatos($id_user);
        $cod = $this->model->MaxAu3();

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
        $pdf->Cell(50, 5, utf8_decode('N°: ' . $cod['nuevo_numero']), 0, 0, 'R');
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 14);
        $pdf->SetX(235);
        $pdf->Cell(50, 5, utf8_decode('Area: ' . $area), 0, 0,  'R');

        $pdf->Image(BASE_URL . 'Assets/img/encabezado.png', 10, 8, 38, 15, 'png');
        $pdf->Ln(15);

        foreach ($datos as $row) {
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->Cell(120, 7, utf8_decode('Proveedor: ' . $row['PRO_NOMBRE']), 0, 0);
            $pdf->Cell(0, 7, utf8_decode('Página Web: enlace de la página'), 0, 1, 'R', false, $row['PAGINA']);
            $pdf->Cell(120, 7, utf8_decode('Pais Proveedor: ' . $row['PAIS']), 0, 0);
            $pdf->Cell(0, 7, utf8_decode('Vendedor: ' . $row['VENDEDOR']), 0, 1, 'R');
            $pdf->Cell(120, 7, utf8_decode('Telefono Proveedor: ' . $row['TEL_PRO']), 0, 0);
            $pdf->Cell(0, 7, utf8_decode('Telefono Vendedor: ' . $row['TEL_VENDEDOR']), 0, 1, 'R');
            $pdf->Ln(7);

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
            $pdf->Cell(0, 7, utf8_decode($row['MONEDA'] . ' ' . $row['PRECIO']), 1, 0, 'C');

            $pdf->Ln(15);

            $pdf->Line($pdf->GetX() - 20, $pdf->GetY(), $pdf->GetX() + 287, $pdf->GetY());

            $pdf->Ln(2);
        }


        $servi = $pdf->Output('S', 'Importacion.pdf');
        return $servi;
    }

    public function RegistrarImportacion()
    {
        $area = $_POST['AreaImport'];
        $blob = $this->Pdf($area);

        $id = $_SESSION['id_usuario'];

        $data = $this->model->RegistrarImportacion($area, $blob);
        if ($data != NULL) {
            $this->model->EliminarDetalles($id);
            $res = array('tipo' => 'success', 'mensaje' => 'Orden Importacion Realizada', 'id' => $data);
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Orden Importacion Realizada');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function MostrarPdf($id)
    {
        $data = $this->model->MostrarPdf($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarImportacion()
    {
        $data = $this->model->ListarImportaciones();
        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i]['STATUS'] == 0) {
                $data[$i]['STATUS'] = '
                    <span class="badge rounded-pill bg-label-warning">
                        <span class="d-none">Espera</span>
                        <i class="mdi mdi-alert-circle-outline"></i>
                    </span>
                ';
            } else if ($data[$i]['STATUS'] == 1) {
                $data[$i]['STATUS'] = '
                    <span class="badge badge-center rounded-pill bg-label-success">
                        <span class="d-none">Aprobado</span>
                        <i class="mdi mdi-check"></i>
                    </span>
                ';
            } else {
                $data[$i]['STATUS'] = '
                    <span class="badge badge-center rounded-pill bg-label-danger">
                        <span class="d-none">Denegado</span>
                        <i class="mdi mdi-window-close"></i>
                    </span>
                ';
            }

            $data[$i]['ACCIONES'] = '
                <button type="button" class="btn btn-icon btn-label-info waves-effect" onclick="MostrarPDf(\'' . $data[$i]['ID'] . '\')">
                    <i class="mdi mdi-file-document-outline">
                    </i>
                </button>
            ';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function MostrarPdfEmail($id)
    {
        $pdfContent = $this->model->ObtenerContenidoPdf($id);
        return $pdfContent;
    }

    public function EnviarCorreo()
    {
        $id_importacion = $_POST['id_importacion'];
        $area = $_POST['area'];
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host       = SMP;
            $mail->SMTPAuth   = true;
            $mail->Username   = $_SESSION['email'];
            $mail->Password   = $_SESSION['pass'];
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = PORT_SSL;

            // Configuración del remitente y destinatario
            $mail->setFrom($_SESSION['email'], $_SESSION['nombres']);
            $mail->addAddress('jvdark2020@gmail.com');

            // Adjunta el archivo PDF al correo
            $pdfContent = $this->MostrarPdfEmail($id_importacion);
            $mail->addStringAttachment($pdfContent, 'Importacion_' . $id_importacion . '.pdf');

            $mail->CharSet = 'UTF-8';

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Importacion ' . $area . ' - ' . $id_importacion;
            $mail->Body = 'Importacion ' . $area . ' - ' . $id_importacion;

            // Envía el correo
            $mail->send();
            echo "Enviado";
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }
    }

    public function Aprobacion()
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 14);

        if (!empty($verificar)) {
            $data['title'] = 'Logística - Aprobación de Importaciones | KYPBioingeniería';
            $data['activeCheckImport'] = 'active';
            $data['scripts'] = 'Logistica/aprobacion.js';
            $this->views->getView('Logistica', 'aprobacion', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function ListarImportacionAprobacion()
    {
        $data = $this->model->ListarImportaciones();
        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i]['STATUS'] == 0) {
                $data[$i]['STATUS'] = '
                    <span class="badge rounded-pill bg-label-warning">
                        <span class="d-none">En Espera</span>
                        <i class="mdi mdi-alert-circle-outline"></i>
                    </span>
                ';
            } else if ($data[$i]['STATUS'] == 1) {
                $data[$i]['STATUS'] = '
                    <span class="badge badge-center rounded-pill bg-label-success">
                        <span class="d-none">Aprobado</span>
                        <i class="mdi mdi-check"></i>
                    </span>
                ';
            } else {
                $data[$i]['STATUS'] = '
                    <span class="badge badge-center rounded-pill bg-label-danger">
                        <span class="d-none">Denegado</span>
                        <i class="mdi mdi-window-close"></i>
                    </span>
                ';
            }

            $data[$i]['ACCIONES'] = '
                <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                        <a href="javascript:;" class="dropdown-item" onclick="MostrarPDf(\'' . $data[$i]['ID'] . '\')">
                            <i class="mdi mdi-file-document-outline me-1"></i> 
                            Ver Documento
                        </a>
                        <a href="javascript:;" class="dropdown-item" onclick="Aprobacion(\'' . $data[$i]['ID'] . '\')">
                            <i class="mdi mdi-check me-1"></i> 
                            Aprobar
                        </a>
                        <a href="javascript:;" class="dropdown-item" onclick="Espera(\'' . $data[$i]['ID'] . '\')">
                            <i class="mdi mdi-alert-circle-outline me-1"></i> 
                            En Espera
                        </a>
                        <a href="javascript:;" class="dropdown-item" onclick="Denegado(\'' . $data[$i]['ID'] . '\')">
                            <i class="mdi mdi-window-close me-1"></i> 
                            Denegado
                        </a>
                        
                    </div>
                </div>
            ';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function AprobacionStatus($id)
    {
        $data = $this->model->updateStatus($id, 1);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Aprobado Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Aprobado Detalle');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function EsperaStatus($id)
    {
        $data = $this->model->updateStatus($id, 0);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Espera Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Espera Detalle');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function DenegadoStatus($id)
    {
        $data = $this->model->updateStatus($id, 2);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Denegado Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Denegado Detalle');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function AprobacionStatusCompra($id)
    {
        $data = $this->model->updateStatusCompra($id, 1);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Aprobado Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Aprobado Detalle');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function EsperaStatusCompra($id)
    {
        $data = $this->model->updateStatusCompra($id, 0);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Espera Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Espera Detalle');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function DenegadoStatusCompra($id)
    {
        $data = $this->model->updateStatusCompra($id, 2);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Denegado Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Denegado Detalle');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarOC()
    {
        $data = $this->model->ListarOrdenCompra();
        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i]['STATUS'] == 0) {
                $data[$i]['STATUS'] = '
                    <span class="badge rounded-pill bg-label-warning">
                        <span class="d-none">Espera</span>
                        <i class="mdi mdi-alert-circle-outline"></i>
                    </span>
                ';
            } else if ($data[$i]['STATUS'] == 1) {
                $data[$i]['STATUS'] = '
                    <span class="badge badge-center rounded-pill bg-label-success">
                        <span class="d-none">Aprobado</span>
                        <i class="mdi mdi-check"></i>
                    </span>
                ';
            } else {
                $data[$i]['STATUS'] = '
                    <span class="badge badge-center rounded-pill bg-label-danger">
                        <span class="d-none">Denegado</span>
                        <i class="mdi mdi-window-close"></i>
                    </span>
                ';
            }

            $data[$i]['TOTAL'] = '<span class="badge bg-label-info">S/. ' . $data[$i]['TOTAL'] . '</span>';
            $data[$i]['ACCIONES'] = '
            <div class="d-inline-block">
            <a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="mdi mdi-dots-vertical"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end m-0">
                <a href="javascript:;" class="dropdown-item" onclick="MostrarPDfCompra(\'' . $data[$i]['ID'] . '\')">
                    <i class="mdi mdi-file-document-outline me-1"></i> 
                    Ver Recibo
                </a>
                <a href="javascript:;" class="dropdown-item" onclick="AprobacionCompra(\'' . $data[$i]['ID'] . '\')">
                    <i class="mdi mdi-check me-1"></i> 
                    Aprobar
                </a>
                <a href="javascript:;" class="dropdown-item" onclick="EsperaCompra(\'' . $data[$i]['ID'] . '\')">
                    <i class="mdi mdi-alert-circle-outline me-1"></i> 
                    En Espera
                </a>
                <a href="javascript:;" class="dropdown-item" onclick="DenegadoCompra(\'' . $data[$i]['ID'] . '\')">
                    <i class="mdi mdi-window-close me-1"></i> 
                    Denegado
                </a>
                
            </div>
        </div>
            ';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    /************** </IMPORTACIONES> **************/


    /************** <ALMACENES> **************/

    public function almacen()
    {
        $data['title'] = 'Logística - Almacenes | KYPBioingeniería';
        $data['activeAlmacen'] = 'active';
        $data['activeOpen'] = 'active open';
        $data['scripts'] = 'Logistica/importaciones.js';
        $this->views->getView('Logistica', 'almacen', $data);
    }

    /************** </ALMACENES> **************/


    /************** <PRODUCTOS LIMA> **************/

    public function productos_lima()
    {
        $data['title'] = 'Logística - Listado de Productos LIMA | KYPBioingeniería';
        $data['activeAlmacen'] = 'active';
        $data['activeOpen'] = 'active open';
        $data['scripts'] = 'Logistica/Productos/lima.js';
        $this->views->getView('Logistica', 'Productos-Lima/productos-lima', $data);
    }

    public function AllProducts()
    {

        $data = $this->model->AllProducts('Lima');
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['ACCIONES'] = '
                <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                        <a href="javascript:;" class="dropdown-item" onclick="SimpleProducts(' . $data[$i]['PRO_ID'] . ')">
                            <i class="mdi mdi-pencil-outline me-1"></i> 
                            Editar
                        </a>
                        <a href="javascript:;" class="dropdown-item" onclick="DeleteProduct(' . $data[$i]['PRO_ID'] . ')">
                            <i class="mdi mdi-trash-can-outline me-1"></i> 
                            Eliminar
                        </a>
                    </div>
                </div>
            ';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function InsertProductLima()
    {
        $id = $_POST['ProID'];
        $cod = $_POST['CodProduct'];
        $name = $_POST['NameProduct'];
        $des = $_POST['DesProduct'];
        $uni = $_POST['UnidProduct'];
        $area = $_POST['AreaProduct'];
        $stock = $_POST['StockProduct'];
        $sede = 'Lima';

        if ($id == "") {
            $data = $this->model->InsertProduct($cod, $name, $des, $uni, $sede, $area, $stock);
            if ($data == 'ok') {
                $res = array('tipo' => 'success', 'mensaje' => 'Producto Registrado');
            } else if ($data == "existe") {
                $res = array('tipo' => 'warning', 'mensaje' => 'El Código Producto ya Existe');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al Producto Registrado');
            }
        } else {
            $data = $this->model->UpdateProducts($id, $cod, $name, $des, $uni, $area, $stock);
            if ($data == 'ok') {
                $res = array('tipo' => 'success', 'mensaje' => 'Producto Modificado');
            } else if ($data == "existe") {
                $res = array('tipo' => 'warning', 'mensaje' => 'El Código Producto ya Existe');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al Producto Modificado');
            }
        }


        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function SImpleProduct($id)
    {
        $data = $this->model->SimpleProducts($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function DeleteProduct($id)
    {
        $data = $this->model->DeleteProduct($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Producto Eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Producto Eliminado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function entradas_lima()
    {
        $data['title'] = 'Logística - Entradas de Productos LIMA | KYPBioingeniería';
        $data['activeAlmacen'] = 'active';
        $data['activeOpen'] = 'active open';
        $data['scripts'] = 'Logistica/Productos/entradas.js';
        $data['get'] = $this->model->AllProducts('Lima');
        $this->views->getView('Logistica', 'Productos-Lima/entradas-lima', $data);
    }

    public function AllEntriesProducts()
    {
        $data = $this->model->AllEntriesProducts();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function UnidProductsSearch($cod)
    {
        $data = $this->model->UnidProductsSearch($cod);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function InsertEntriesProducts()
    {
        $cod = $_POST['SearchProduct'];
        $boleta = $_POST['NSerieProducts'];
        $qual = $_POST['QuantProduct'];

        $data = $this->model->RegisterEntriesProducts($cod, $boleta, $qual);
        if ($data > 0) {
            if ($data == 'ok') {
                $res = array('tipo' => 'success', 'mensaje' => 'Entradas Registradas', 'id' => $data);
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al Entradas Registradas');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();

    }


    /************** </PRODUCTOS LIMA> **************/
}
