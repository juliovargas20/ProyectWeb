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
}
