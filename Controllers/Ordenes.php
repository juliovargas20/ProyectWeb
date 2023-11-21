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
        $data['title'] = 'Ordenes Internas - Orden de Compra | KYPBioingeniería';
        $data['activeOrdenCompra'] = 'active';
        $data['scripts'] = 'Ordenes/ordenCompra.js';
        $this->views->getView('Ordenes', 'compra', $data);
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

}
