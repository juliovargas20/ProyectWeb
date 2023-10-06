<?php
class Historial extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /*************** LISTADO DE PROCESOS ***************/

    public function index()
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 4);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Historial | KYPBioingeniería';
            $data['activeHistorial'] = 'active';
            $data['scripts'] = 'Historial/historial.js';
            $this->views->getView('Historial', 'index', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }



    /*************** LISTADO DE PACIENTES ***************/
    public function listado($cod)
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 4);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Historial - Listado | KYPBioingeniería';
            $data['activeHistorial'] = 'active';
            $data['scripts'] = 'Historial/listado.js';
            $data['cod'] = $cod;
            $this->views->getView('Historial', 'listado', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    //======================MIEMBRO SUPERIORES==================//

    public function ListarMS1()
    {
        $data = $this->model->ListarMS1();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarMS2()
    {
        $data = $this->model->ListarMS2();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarMS3()
    {
        $data = $this->model->ListarMS3();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarMS4()
    {
        $data = $this->model->ListarMS4();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    //======================MIEMBRO INFERIORES==================//

    public function ListarMI1()
    {
        $data = $this->model->ListarMI1();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarMI2()
    {
        $data = $this->model->ListarMI2();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarMI3()
    {
        $data = $this->model->ListarMI3();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarMI4()
    {
        $data = $this->model->ListarMI4();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    //======================ESTETICA==================//


    public function ListarE1()
    {
        $data = $this->model->ListarE1();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function ListarE2()
    {
        $data = $this->model->ListarE2();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarE3()
    {
        $data = $this->model->ListarE3();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarE4()
    {
        $data = $this->model->ListarE4();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    /*************** REGISTRO DE HISTORIAL ***************/
    public function historial($id)
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 4);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Historial - Registro | KYPBioingeniería';
            $data['activeHistorial'] = 'active';
            $data['scripts'] = 'Historial/registro.js';
            $data['datos'] = $this->model->getDatos($id);
            $this->views->getView('Historial', 'historial', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }

        
    }

    public function Registrar()
    {
        $idbase = $_POST['idbase'];
        $idpa = $_POST['idpacientehisto'];
        $des = $_POST['Descripcion'];
        $tec = $_SESSION['nombres'];
        $proceso = $_POST['proceso'];

        $data = $this->model->RegistrarHistorial($idbase, $idpa, $des, $tec, $proceso);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Historial Registradas');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Historial Registrada');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarHis()
    {
        $cod = $this->model->getIDHisto();
        if ($cod['ID'] == NULL) {
            $max = 1;
        } else {
            $max = $cod['ID'];
        }
        $id = $_POST['ID_PACIENTE'];
        $proceso = $_POST['proceso'];
        $img = $_FILES['file'];

        for ($i = 0; $i < count($img['name']); $i++) {
            $tmp_name = file_get_contents($img['tmp_name'][$i]);
            $type = $img['type'][$i];
            $name = $img['name'][$i];
            $data = $this->model->RegistrarImg($max, $id, $tmp_name, $type, $name, $proceso);
            if ($data > 0) {
                $respuesta = $data;
            } else {
                $respuesta = "error";
            }
        }

        if ($respuesta > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Imagenes Registradas');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Imagenes Registrada');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarHistorial()
    {
        $id = $_POST['id_base'];
        $pro = $_POST['PrFG'];

        $data = $this->model->ListarHistorual($id, $pro);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function Proceso()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data['id'];
        $proceso = $data['proceso'];

        if ($proceso == 1) {
            $data = $this->model->Proceso2($id, 1);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Proceso Finalizado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'error. Proceso Finalizado');
            }
        }

        if ($proceso == 2) {
            $data = $this->model->Proceso3($id, 2);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Proceso Finalizado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'error. Proceso Finalizado');
            }
        }

        if ($proceso == 3) {
            $data = $this->model->Proceso4($id, 3);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Proceso Finalizado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'error. Proceso Finalizado');
            }
        }

        if ($proceso == 4) {
            $data = $this->model->ProcesoFinal($id, 4);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Proceso Finalizado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'error. Proceso Finalizado');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function Res1()
    {
        $id = $_POST['id_base'];
        $pro = 1;

        $data = $this->model->Resumen($id, $pro);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Res2()
    {
        $id = $_POST['id_base'];
        $pro = 2;

        $data = $this->model->Resumen($id, $pro);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Res3()
    {
        $id = $_POST['id_base'];
        $pro = 3;

        $data = $this->model->Resumen($id, $pro);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Res4()
    {
        $id = $_POST['id_base'];
        $pro = 4;

        $data = $this->model->Resumen($id, $pro);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListFinal()
    {
        $data = $this->model->Listfinal();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Descargar($id)
    {
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kypbioingenieria";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Obtener las imágenes y tipos desde la base de datos
        $sql = "SELECT IMG, TIPO FROM historial_img WHERE ID_HISTORIAL = $id";
        $result = $conn->query($sql);

        // Crear un archivo ZIP
        $zip_file = 'historial_' . $id . '.zip';
        $zip = new ZipArchive();
        if ($zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            while ($row = $result->fetch_assoc()) {
                $tipo = $row['Tipo'];
                $imagen_nombre = 'imagen_' . $id . '_' . uniqid() . '.jpg';
                $zip->addFromString($tipo . '/' . $imagen_nombre, $row['IMG']);
            }
            $zip->close();

            // Descargar el archivo ZIP
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zip_file . '"');
            readfile($zip_file);

            // Eliminar el archivo ZIP después de la descarga (opcional)
            unlink($zip_file);
        } else {
            echo 'Error al crear el archivo ZIP.';
        }

        $conn->close();
    }
}
