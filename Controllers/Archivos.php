<?php
class Archivos extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function Listado()
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 9);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Archivos | KYPBioingeniería';
            $data['activeArchivo'] = 'active';
            $data['scripts'] = 'Archivos/Listado.js';
            $this->views->getView('Archivos', 'Listado', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function Listar()
    {
        $data = $this->model->Listado();
        for ($i = 0; $i < COUNT($data); $i++) {
            $data[$i]['ACCIONES'] = '
                <button type="button" class="btn btn-icon btn-label-secondary waves-effect" onclick="archivos('.$data[$i]['ID'].')">
                    <i class="mdi mdi-eye-outline">
                    </i>
                </button>
            ';
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
        $verificar = $this->model->Verificar($id_caja, 9);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Archivos | KYPBioingeniería';
            $data['activeArchivo'] = 'active';
            $data['scripts'] = 'Archivos/agregar.js';
            $data['get'] = $this->model->getDatos($id);
            $this->views->getView('Archivos', 'archivos', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function ListarDocumentos($id)
    {
        $data = $this->model->ListarDocumentos($id);
        for ($i = 0; $i < COUNT($data); $i++) {
            $data[$i]['ACCIONES'] = '
                <button type="button" class="btn btn-icon btn-label-secondary waves-effect" onclick="Documento('.$data[$i]['ID'].')">
                    <i class="mdi mdi-text-box-multiple-outline">
                    </i>
                </button>
                <button type="button" class="btn btn-icon btn-label-danger waves-effect" onclick="EliminarDocumento('.$data[$i]['ID'].')">
                    <i class="mdi mdi-trash-can">
                    </i>
                </button>
            ';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarDocumento()
    {
        $id = $_POST['Id_BaseDoc'];
        $nombre = $_POST['NombreDoc'];
        $doc = $_FILES['file'];
        $tipo = $doc['type'];

        if (!$doc['error'] == UPLOAD_ERR_NO_FILE) {
            $tmp_name = file_get_contents($doc['tmp_name']);
        } else {
            $tmp_name = NULL;
        }

        $data = $this->model->RegistrarDocumento($id, $nombre, $tmp_name, $tipo);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Documento Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Documento Contrato');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Documento($id)
    {
        $data = $this->model->MostrarDocumento($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function EliminarDocumento($id)
    {
        $data = $this->model->EliminarDocumento($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Documento Eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Documento Eliminada');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
