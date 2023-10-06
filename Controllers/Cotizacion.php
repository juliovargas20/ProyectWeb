<?php

//Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Cotizacion extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /************** <COTIZACION DE PACIENTES> **************/

    public function index()
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 3);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Cotización | KYPBioingeniería';
            $data['activeCotizacion'] = 'active';
            $data['scripts'] = 'Cotizacion/listado.js';
            $this->views->getView('Cotizacion', 'Cotizacion', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function Listar()
    {
        $data = $this->model->ListarCotizacion();
        for ($i = 0; $i < COUNT($data); $i++) {
            $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="Prevista(' . $data[$i]['ID'] . ')">
                            <i class="mdi mdi-eye-outline mdi-20px mx-1"></i> 
                            Visualizar
                        </button>
                    </div>
                </div>
            ';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    /************** </COTIZACION DE PACIENTES> **************/



    /************** <REGISTRAR COTIZACION DE PACIENTES> **************/

    public function agregar()
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 3);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Cotización | KYPBioingeniería';
            $data['activeCotizacion'] = 'active';
            $data['scripts'] = 'Cotizacion/registro.js';
            $data['get'] = $this->model->getPacientes();
            $data['tipSer'] = $this->model->getTipService();
            $this->views->getView('Cotizacion', 'agregar', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function Existe($id)
    {
        $data = $this->model->Existe($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getSubtrabajo($id)
    {
        $data = $this->model->getSubTrab($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarServicio()
    {
        $id = $_POST['IdPaciente'];
        $ser = $_POST['Tip_trab'];
        $tra = $_POST['Sub_trab'];

        $data = $this->model->RegistrarSer($id, $ser, $tra);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Trabajo Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Trabajo Registrado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarServicioManual()
    {
        $id = $_POST['IdPacienteManual'];
        $ser = $_POST['Tip_trabManual'];
        $tra = $_POST['Sub_trabManual'];

        $data = $this->model->RegistrarSer($id, $ser, $tra);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Trabajo Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Trabajo Registrado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarCoti()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data['id'];
        $obs = $data['obs'];
        $ser = $data['tip'];
        $tra = $data['sub'];
        $peso = $data['peso'];
        $igv = $data['igv'];
        $cant = $data['cant'];

        if ($igv == 1) {
            $monto = $data['monto'] + 0.18 * $data['monto'];
        } else {
            $monto = $data['monto'];
        }

        $total = $cant * $monto;

        $data = $this->model->RegistrarCoti($id, $total, $obs, $ser, $tra, $peso, $igv, $cant);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Cotizacion Registrada', 'id' => $data);
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Cotizacion Registrada');
        }


        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarLista()
    {
        $cod = $this->model->IdCoti();
        $data = json_decode(file_get_contents("php://input"), true);

        if ($cod['ID'] == NULL) {
            $max = 1;
        } else {
            $max = $cod['ID'];
        }

        $lista_data = $data['selecciones'];

        for ($i = 0; $i < count($lista_data); $i++) {
            $lista = $lista_data[$i];
            $data = $this->model->RegistrarLista($max, $lista);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Lista Registrada');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'error Lista Registrada');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    /************** </ REGISTRAR COTIZACION DE PACIENTES> **************/



    /************** < IMPRIMIR COTIZACION > **************/

    public function imprimir($id)
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 3);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Imprimir | KYPBioingeniería';
            $data['scripts'] = 'Cotizacion/imprimir.js';
            $data['lista'] = $this->model->MostraListaCoti($id);
            $data['get'] = $this->model->getImprimir($id);
            $this->views->getView('Cotizacion', 'imprimir', $data);
       } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }


    /************** </ IMPRIMIR COTIZACION > **************/


    /************** < CORREO COTIZACION > **************/


    public function EnviarCorreo($id)
    {   
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host       = SMP;
            $mail->SMTPAuth   = true;
            $mail->Username   = USER_EMAIL;
            $mail->Password   = PASS_EMAIL;
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = PORT_SSL;


            $mail->setFrom(USER_EMAIL, 'Administración');
            $mail->addAddress('sistemas@kypbioingenieria.com');

                /*Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            */;

            $mail->CharSet = 'UTF-8';

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Prueba Envia de Cotizacion';
            $mail->Body    = 'Mira el PDF';

            $mail->addAttachment('archivo.pdf');


            $mail->send();
            echo 'El correo se envió correctamente.';
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }
    }


    /************** </ CORREO COTIZACION > **************/
}
