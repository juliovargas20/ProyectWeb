<?php
class Pacientes extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /************** <LISTADO DE PACIENTES> **************/

    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 2);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - ListadoPaciente | KYPBioingeniería';
            $data['activePaciente'] = 'active';
            $data['scripts'] = 'Pacientes/Listado.js';
            $this->views->getView('Pacientes', 'ListadoPaciente', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function Listar()
    {
        $data = $this->model->Listado();
        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i]['ESTADO'] == 'Contrato' || $data[$i]['ESTADO'] == 'Donación') {
                $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="editar(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-pencil-outline me-1"></i> 
                            Editar
                        </button>
                        <button type="button" class="dropdown-item" onclick="eliminar(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-trash-can-outline me-1"></i> 
                            Eliminar
                        </button>
                        <button type="button" class="dropdown-item" onclick="getFicha(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-file-pdf-box me-1"></i> 
                            Ver Ficha
                        </button>
                        <button type="button" class="dropdown-item" onclick="Contrato(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-file-document-edit me-1"></i> 
                            Contrato
                        </button>
                        <button type="button" class="dropdown-item" onclick="FichaEvaluacion(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-file-document-refresh-outline me-1"></i> 
                            Ficha Evaluación
                        </button>
                        <button type="button" class="dropdown-item" onclick="Accesorios(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-cart-variant me-1"></i> 
                            Accesorios
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
                        <button type="button" class="dropdown-item" onclick="editar(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-pencil-outline me-1"></i> 
                            Editar
                        </button>
                        <button type="button" class="dropdown-item" onclick="eliminar(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-trash-can-outline me-1"></i> 
                            Eliminar
                        </button>
                        <button type="button" class="dropdown-item" onclick="getFicha(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-file-pdf-box me-1"></i> 
                            Ver Ficha
                        </button>
                        <button type="button" class="dropdown-item" onclick="FichaEvaluacion(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-file-document-refresh-outline me-1"></i> 
                            Ficha Evaluación
                        </button>
                        <button type="button" class="dropdown-item" onclick="Accesorios(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                            <i class="mdi mdi-cart-variant me-1"></i> 
                            Accesorios
                        </button>
                    </div>
                </div>
            ';
            }
        }
        // \''.$data[$i]['ID_PACIENTE'].'\'; Tipo String
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Eliminar($id)
    {
        $data = $this->model->EliminarPaciente($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Paciente Eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Paciente Eliminado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    /************** </LISTADO DE PACIENTES> **************/


    /************** <REGISTRO DE PACIENTES> **************/

    public function registro()
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 2);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Registro Paciente | KYPBioingeniería';
            $data['activePaciente'] = 'active';
            $data['scripts'] = 'Pacientes/registro.js';
            $this->views->getView('Pacientes', 'registro', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }


    public function registroPaciente()
    {
        $nombre = $_POST['Nombres'];
        $dni = $_POST['DNI'];
        $genero = $_POST['Genero'];
        $edad = $_POST['Edad'];
        $celular = $_POST['Celular'];
        $naci = $_POST['naci'];
        $dire = $_POST['Direccion'];
        $sede = $_POST['Sede'];
        $local = $_POST['Locacion'];
        $correo = $_POST['email'];
        $estado = $_POST['Estado'];
        $canal = $_POST['Canal'];
        $time = $_POST['TiemA'];
        $motivo = $_POST['Motivo'];
        $afec = $_POST['Afecc'];
        $aler = $_POST['Alergia'];
        $obs = $_POST['Obs'];

        $data = $this->model->Registrar($nombre, $dni, $genero, $edad, $celular, $naci, $dire, $sede, $local, $correo, $estado, $canal, $time, $motivo, $afec, $aler, $obs);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Paciente Registrado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Paciente Registrado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    /************** </REGISTRO DE PACIENTES> **************/




    /************** <MODIFICAR DE PACIENTES> **************/

    public function modificar($id)
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 2);

        if (!empty($verificar)) {
            $data['id'] = $id;
            $data['title'] = 'Gestión de Pacientes - Modificar Paciente | KYPBioingeniería';
            $data['activePaciente'] = 'active';
            $data['scripts'] = 'Pacientes/modificar.js';
            $this->views->getView('Pacientes', 'modificar', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function Mostrar($id)
    {
        $data = $this->model->Mostrar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function modificarPaciente()
    {
        $id = $_POST['IDPaciente'];
        $nombre = $_POST['Nombres'];
        $dni = $_POST['DNI'];
        $genero = $_POST['Genero'];
        $edad = $_POST['Edad'];
        $celular = $_POST['Celular'];
        $naci = $_POST['naci'];
        $dire = $_POST['Direccion'];
        $sede = $_POST['Sede'];
        $local = $_POST['Locacion'];
        $correo = $_POST['email'];
        $estado = $_POST['Estado'];
        $canal = $_POST['Canal'];
        $time = $_POST['TiemA'];
        $motivo = $_POST['Motivo'];
        $afec = $_POST['Afecc'];
        $aler = $_POST['Alergia'];
        $obs = $_POST['Obs'];

        $data = $this->model->Modificar($id, $nombre, $dni, $genero, $edad, $celular, $naci, $dire, $sede, $local, $correo, $estado, $canal, $time, $motivo, $afec, $aler, $obs);

        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Paciente Modificado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Paciente Modificado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }



    /************** </MODIFICAR DE PACIENTES> **************/



    /************** <FICHA DE PACIENTES> **************/

    public function Ficha($id)
    {
        require('include/fpdf_temp.php');

        $datos = $this->model->Mostrar($id);

        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 16);
        $pdf->Cell(0, 7, "FICHA DE REGISTRO PARA LOS PACIENTES", 0, 1, 'C');
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 9, 'Datos del Paciente', 0, 0, 'L', true);
        $pdf->Ln(14);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(40, 7, 'NOMBRES', 1, 0, 'L');
        $pdf->Cell(0, 7, utf8_decode($datos['NOMBRES']), 1, 0, 'C');
        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(25, 7, 'DNI - C.E.', 1, 0, 'L');
        $pdf->Cell(30, 7, $datos['DNI'], 1, 0, 'C');
        $pdf->Cell(30, 7, 'CELULAR', 1, 0, 'L');
        $pdf->Cell(60, 7, $datos['CELULAR'], 1, 0, 'C');
        $pdf->Cell(20, 7, 'EDAD', 1, 0, 'L');
        $pdf->Cell(25, 7, utf8_decode($datos['EDAD']), 1, 0, 'C');
        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(30, 7, utf8_decode('DIRECCIÓN'), 1, 0, 'L');
        $pdf->Cell(0, 7, utf8_decode($datos['DIRECCION']), 1, 0, 'C');
        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(30, 7, utf8_decode('GÉNERO'), 1, 0, 'L');
        $pdf->Cell(40, 7, utf8_decode($datos['GENERO']), 1, 0, 'C');
        $pdf->Cell(60, 7, utf8_decode('FECHA DE NACIMIENTO'), 1, 0, 'L');
        $pdf->Cell(0, 7, utf8_decode($datos['FECHANAC']), 1, 0, 'C');
        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(30, 7, 'CORREO', 1, 0, 'L');
        $pdf->Cell(0, 7, utf8_decode($datos['CORREO']), 1, 0, 'C');
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 9, utf8_decode('Datos Médicos'), 0, 0, 'L', true);
        $pdf->Ln(14);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(70, 7, utf8_decode('AFECCIONES MÉDICAS'), 1, 0, 'L');
        $pdf->Cell(0, 7, utf8_decode($datos['AFECCIONES']), 1, 0, 'C');
        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(70, 7, utf8_decode('ALERGIAS'), 1, 0, 'L');
        $pdf->Cell(0, 7, utf8_decode($datos['ALERGIAS']), 1, 0, 'C');
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 9, utf8_decode('Datos para el Técnico'), 0, 0, 'L', true);
        $pdf->Ln(14);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TIEMPO DE AMPUTACIÓN'), 1, 0, 'L');
        $pdf->Cell(0, 7, utf8_decode($datos['TIME_AMP']), 1, 0, 'C');
        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(70, 7, utf8_decode('MOTIVO DE AMPUTACIÓN'), 1, 0, 'L');
        $pdf->Cell(0, 7, utf8_decode($datos['MOTIVO']), 1, 0, 'C');
        $pdf->Ln(15);

        if (!empty($datos['OBSERVACION'])) {
            $pdf->SetFont('RubikMedium', '', 12);
            $pdf->SetFillColor(200, 220, 255);
            $pdf->Cell(0, 9, utf8_decode('Observaciones'), 0, 0, 'L', true);
            $pdf->Ln(14);

            $pdf->MultiCell(0, 7, utf8_decode($datos['OBSERVACION']), 0);
        }

        $pdf->AddPage();


        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(0, 7, utf8_decode("Consentimiento Informado para el Contacto Físico con Pacientes Amputados"), 0, 1, 'C', false);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('Yo, ' . $datos['NOMBRES'] . ', en pleno uso de mis facultades mentales y entendiendo plenamente la naturaleza de este consentimiento, otorgo mi consentimiento informado para que el personal médico y los profesionales capacitados de la empresa KYP BIO INGEN S.A.C realicen el contacto físico necesario durante el tratamiento y cuidado de mi condición de amputación.'), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('Entiendo y acepto que el contacto físico puede ser necesario para realizar una evaluación adecuada, proporcionar tratamiento médico, llevar a cabo procedimientos terapéuticos y mejorar mi bienestar general como paciente amputado. Comprendo que el contacto físico puede incluir, pero no se limita a, la inspección visual, la palpación, la movilización de extremidades y la aplicación de dispositivos médicos y ortopédicos.'), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('Además, se me ha proporcionado información detallada sobre los procedimientos específico que implicarán contacto físico, así como los riesgos y beneficios asociados. He tenido la oportunidad de hacer preguntas y todas ellas han sido respondidas satisfactoriamente.'), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('También entiendo que tengo el derecho de retirar mi consentimiento en cualquier aspecto de mi tratamiento o cuidado.'), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('Declaro que este consentimiento ha sido otorgado de manera voluntaria y sin ninguna forma de coerción o presión. Soy plenamente consciente de las implicaciones y consecuencias del contacto físico y autorizo a los profesionales capacitados de la empresa KYP BIO INGEN S.A.C a llevar a cabo dichos procedimientos en mi persona.'), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('Además, doy mi consentimiento para que se documente y almacene de manera segura cualquier información relacionada con el contacto físico en mi historial médico.'), 0);
        $pdf->Ln(25);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(0, 5, 'Firma del Paciente/Representante Legal');
        $pdf->Ln(5);
        $pdf->Cell(0, 5, 'Fecha:');


        $pdf->Output('I', 'Ficha.pdf');
        die();
    }

    /************** </FICHA DE PACIENTES> **************/


    /************** <ACCESORIOS> **************/

    public function Accesorios($id)
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 7);

        if (!empty($verificar)) {
            $data['id'] = $id;
            $data['title'] = 'Gestión de Pacientes - Accesorios | KYPBioingeniería';
            $data['activePaciente'] = 'active';
            $data['scripts'] = 'Pacientes/accesorios.js';
            $data['get'] = $this->model->Mostrar($id);
            $this->views->getView('Pacientes', 'accesorios', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function InsertDetallePago()
    {
        $id_user = $_SESSION['id_usuario'];
        $id_pa = $_POST['id_pa'];
        $des = $_POST['des'];
        $can = $_POST['can'];
        $pre = $_POST['pre'];
        $sub = $can * $pre;

        $data = $this->model->InsertDetallePago($id_user, $id_pa, $des, $can, $pre, $sub);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Ingresado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Ingresado');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListaDetallePago($id_pa)
    {
        $id_user = $_SESSION['id_usuario'];
        $data['detalle'] = $this->model->ListaDetallePago($id_user, $id_pa);
        $data['total'] = $this->model->CalcularTotalAcc($id_user, $id_pa);
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

    public function RealizarPago()
    {
        $id_user = $_SESSION['id_usuario'];
        $id_pa = $_POST['id_pa'];
        $tip = $_POST['TipPago'];
        $pago = $_POST['Pago'];
        $total = $_POST['Total'];
        $obs = $_POST['Obs'];
        $blob = $this->PDFPago($id_pa);

        $data = $this->model->RealizarPago($id_pa, $tip, $pago, $total, $obs, $blob);
        if ($data > 0) {
            $this->model->EliminarTodosDetalles($id_user, $id_pa);
            $res = array('tipo' => 'success', 'mensaje' => 'Pago Realizado', 'id' => $data);
        } else{
            $res = array('tipo' => 'error', 'mensaje' => 'error Pago Realizado');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function PDFPago($id_paciente)
    {
        require('./Assets/vendor/libs/fpdf/fpdf.php');
        $id_user = $_SESSION['id_usuario'];
        $datos = $this->model->ListaDetallePago($id_user, $id_paciente);
        $count = $this->model->Maxpagos();
        $total = $this->model->CalcularTotalAcc($id_user, $id_paciente);
        $get = $this->model->Mostrar($id_paciente);

        if ($count['ID'] == NULL) {
            $max = 1;
        } else{
            $max = $count['ID'] + 1;
        }

        $pdf = new FPDF();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->AddPage();
        $pdf->SetFont('RubikMedium', '', 28);
        $pdf->Cell(30, 7, 'Recibo', 0);
        $pdf->Ln(13);

        $pdf->Image(BASE_URL . 'Assets/img/encabezado.png', 163, 6, 35, 13, 'png');

        $pdf->SetFont('RubikMedium', '', 10);
        $pdf->Cell(40, 7, 'KYP BIOINGEN S.A.C', 0);
        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(0, 7, utf8_decode('N° Recibo: #00'.$max), 0, 0, 'R');
        $pdf->Ln(4);

        $pdf->SetFont('RubikRegular', '', 8);
        $pdf->Cell(43, 7, utf8_decode('Cal. Max Palma Arrúe Nro. 1117'), 0);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(0, 7, utf8_decode('Fecha: '.date('Y-m-d')), 0, 0, 'R');
        $pdf->Ln(7);

        $pdf->Cell(0, 7, utf8_decode('Nombre: '. $get['NOMBRES']), 0, 0);
        $pdf->Ln(4);

        $pdf->Cell(0, 7, utf8_decode('DNI: '. $get['DNI']), 0, 0);
        $pdf->Ln(10);


        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(117, 185, 202);
        $pdf->Cell(30, 8, utf8_decode('Cantidad'), 0, 0, 'C', true);
        $pdf->Cell(73, 8, utf8_decode('  Descripción'), 0, 0, 'L', true);
        $pdf->Cell(40, 8, utf8_decode('Precio U.'), 0, 0, 'C', true);
        $pdf->Cell(0, 8, utf8_decode('Sub-Total'), 0, 0, 'C', true);
        $pdf->Ln(10);

        foreach ($datos as $row) {
            $pdf->SetFont('RubikRegular', '', 10);
            $pdf->Cell(30, 7, utf8_decode($row['CANTIDAD']), 0, 0, 'C');
            $pdf->Cell(73, 7, utf8_decode('  '. $row['DESCRIPCION']), 0, 0, 'L');
            $pdf->Cell(40, 7, utf8_decode('S/. '. $row['PRECIO_U']), 0, 0, 'C');
            $pdf->Cell(0, 7, utf8_decode('S/. '. $row['SUB_TOTAL']), 0, 0, 'C');
            $pdf->Ln(7);
        }
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(30, 7, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(73, 7, utf8_decode(''), 0, 0, 'L');
        $pdf->Cell(40, 7, utf8_decode('TOTAL'), 0, 0, 'C');
        $pdf->Cell(0, 7, utf8_decode('S/. '. $total['TOTAL']), 0, 0, 'C');
        $pdf->Ln(18);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(95, 7, '-----------------------------------', 0, 0, 'C');
        $pdf->Cell(95, 7, '-----------------------------------', 0, 0, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(95, 7, utf8_decode('Administración'), 0, 0, 'C');
        $pdf->Cell(95, 7, utf8_decode($get['NOMBRES']), 0, 0, 'C');
        $pdf->Ln(20);

        /*==================== DUPLICADO ====================*/
        /*===================================================*/
        $pdf->Image(BASE_URL . 'Assets/img/encabezado.png', 163, $pdf->GetY(), 35, 13, 'png');

        $pdf->SetFont('RubikMedium', '', 28);
        $pdf->Cell(30, 7, 'Recibo', 0);
        $pdf->Ln(13);

        
        $pdf->SetFont('RubikMedium', '', 10);
        $pdf->Cell(40, 7, 'KYP BIOINGEN S.A.C', 0);
        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(0, 7, utf8_decode('N° Recibo: #00'.$max), 0, 0, 'R');
        $pdf->Ln(4);

        $pdf->SetFont('RubikRegular', '', 8);
        $pdf->Cell(43, 7, utf8_decode('Cal. Max Palma Arrúe Nro. 1117'), 0);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(0, 7, utf8_decode('Fecha: '.date('Y-m-d')), 0, 0, 'R');
        $pdf->Ln(7);

        $pdf->Cell(0, 7, utf8_decode('Nombre: '.$get['NOMBRES']), 0, 0);
        $pdf->Ln(4);

        $pdf->Cell(0, 7, utf8_decode('DNI: '.$get['DNI']), 0, 0);
        $pdf->Ln(10);


        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(117, 185, 202);
        $pdf->Cell(30, 8, utf8_decode('Cantidad'), 0, 0, 'C', true);
        $pdf->Cell(73, 8, utf8_decode('  Descripción'), 0, 0, 'L', true);
        $pdf->Cell(40, 8, utf8_decode('Precio U.'), 0, 0, 'C', true);
        $pdf->Cell(0, 8, utf8_decode('Sub-Total'), 0, 0, 'C', true);
        $pdf->Ln(10);

        foreach ($datos as $row) {
            $pdf->SetFont('RubikRegular', '', 10);
            $pdf->Cell(30, 7, utf8_decode($row['CANTIDAD']), 0, 0, 'C');
            $pdf->Cell(73, 7, utf8_decode('  '. $row['DESCRIPCION']), 0, 0, 'L');
            $pdf->Cell(40, 7, utf8_decode('S/. '. $row['PRECIO_U']), 0, 0, 'C');
            $pdf->Cell(0, 7, utf8_decode('S/. '. $row['SUB_TOTAL']), 0, 0, 'C');
            $pdf->Ln(7);
        }
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(30, 7, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(73, 7, utf8_decode(''), 0, 0, 'L');
        $pdf->Cell(40, 7, utf8_decode('TOTAL'), 0, 0, 'C');
        $pdf->Cell(0, 7, utf8_decode('S/. '. $total['TOTAL']), 0, 0, 'C');
        $pdf->Ln(18);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(95, 7, '-----------------------------------', 0, 0, 'C');
        $pdf->Cell(95, 7, '-----------------------------------', 0, 0, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(95, 7, utf8_decode('Administración'), 0, 0, 'C');
        $pdf->Cell(95, 7, utf8_decode($get['NOMBRES']), 0, 0, 'C');

        $servi = $pdf->Output('S', 'ReciboPago.pdf');

        return $servi;

    }

    public function ListarRecibos()
    {
        $data = $this->model->ListarRecibos();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['TOTAL'] = '<span class="badge bg-label-info">S/. '.$data[$i]['TOTAL'].'</span>';
            $data[$i]['ACCIONES'] = '
            <button type="button" class="btn btn-icon btn-label-danger waves-effect" onclick="PDfPago('.$data[$i]['ID'].')">
                <i class="mdi mdi-file-document-outline">
                </i>
            </button>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function MostrarReciboPagos($id)
    {
        $data = $this->model->MostrarReciboPagos($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    /************** </ACCESORIOS> **************/


    /************** <EVALUACIÓN TRANSFEMORAL> **************/

    public function FichaEvaluacionTransfemoral($id)
    {
        require('include/fpdf_temp.php');

        $datos = $this->model->Mostrar($id);

        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(0, 7, utf8_decode("FICHA DE EVALUACIÓN TRANSFEMORAL O DESARTICULADO DE RODILLA"), 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(40, 7, utf8_decode(' PACIENTE: '), 1);
        $pdf->Cell(0, 7, utf8_decode($datos['NOMBRES']), 1, 0, 'C');
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(50, 7, utf8_decode('PESO (Kg.): _____'), 0);
        $pdf->Cell(60, 7, utf8_decode('Selección de Prótesis: '), 0, 0, 'R');
        $pdf->Cell(40, 7, utf8_decode('( ) Transfemoral'), 0, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode('( ) Rodilla'), 0, 0, 'C');
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TIPO DE ENCAJE'), 0);
        $pdf->Ln(9);
        
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( )  Fibra de Vidrio'), 0);
        $pdf->Cell(50, 7, utf8_decode('( )  Fibra de Carbono'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TIPO DE SUJECIÓN'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( )  Sujeción Lanyard'), 0);
        $pdf->Cell(40, 7, utf8_decode('( )  Locker Pin'), 0);
        $pdf->Cell(0, 7, utf8_decode('( )  Valvula de Vacío y Oring.   TALLA: ____'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TALLA LINER'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(45, 7, utf8_decode('TALLA: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Lineal'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Cónica'), 0);
        $pdf->Cell(0, 14, utf8_decode('( ) K1 - 0.0    ( ) k2 - 0.5    ( ) k3 - 10'), 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->Cell(45, 7, utf8_decode('LONGITUD: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) C/Adaptador'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) S/Adaptador'), 0);
        $pdf->Ln(13);


        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TIPO DE RODILLA'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( ) Mecánica'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Hidráulica'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Neumática'), 0);
        $pdf->Ln(8);
        $pdf->Cell(50, 7, utf8_decode('( ) Win Walker'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Össur'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Ottobock'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) LIMP'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TIPO DE PIE'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(100, 7, utf8_decode('( ) Clásica'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Fibra de Carbono'), 0);
        $pdf->Ln(8);
        $pdf->Cell(40, 7, utf8_decode('( ) Multiaxial'), 0);
        $pdf->Cell(60, 7, utf8_decode('( ) Sach'), 0);
        $pdf->Cell(40, 7, utf8_decode('( ) Tobillo Alto'), 0);
        $pdf->Cell(40, 7, utf8_decode('( ) Tobillo Bajo'), 0);
        $pdf->Ln(13);
        $pdf->Cell(50, 7, utf8_decode('( ) LIMP'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Win Walker'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Össur'), 0);
        $pdf->Ln(13);
        $pdf->Cell(50, 7, utf8_decode('TALLA: ____      LADO: ( ) L     ( ) R'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(100, 7, utf8_decode('ACABADO ESTÉTICO'), 0);
        $pdf->Cell(70, 7, utf8_decode('CONECTORES ESPECIALES'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( ) Neopreno'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Telireno'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Si'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) No'), 0);
        $pdf->Ln(8);
        $pdf->Cell(50, 7, utf8_decode('( ) Cover 3D'), 0);
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(100, 7, utf8_decode('MONTO COTIZADO: S/. _______________'), 0);
        $pdf->Ln(9);

        $pdf->AddPage();

        $M1 = BASE_URL . 'Assets/img/M1.jpg';
        $pdf->Image($M1, 0, 0, 210, 297);

        $pdf->Output('I', 'EvaluacionTransfemoral.pdf');
        die();        
    }

    public function FichaEvaluacionTranstibial($id)
    {
        require('include/fpdf_temp.php');

        $datos = $this->model->Mostrar($id);

        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(0, 7, utf8_decode("FICHA DE EVALUACIÓN TRANSTIBIAL O SYME"), 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(40, 7, utf8_decode(' PACIENTE: '), 1);
        $pdf->Cell(0, 7, utf8_decode($datos['NOMBRES']), 1, 0, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(50, 7, utf8_decode('PESO (Kg.): _____'), 0);
        $pdf->Cell(60, 7, utf8_decode('Selección de Prótesis: '), 0, 0, 'R');
        $pdf->Cell(40, 7, utf8_decode('( ) Transtibial'), 0, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode('( ) Syme'), 0, 0, 'C');
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TIPO DE ENCAJE'), 0);
        $pdf->Ln(9);
        
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( )  Fibra de Vidrio'), 0);
        $pdf->Cell(50, 7, utf8_decode('( )  Fibra de Carbono'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TIPO DE SUJECIÓN'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(40, 7, utf8_decode('( )  Locker Pin'), 0);
        $pdf->Cell(0, 7, utf8_decode('( )  Rodillera.   TALLA: ____'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TALLA LINER'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(45, 7, utf8_decode('TALLA: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Lineal'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Cónica'), 0);
        $pdf->Cell(0, 14, utf8_decode('( ) K1 - 0.0    ( ) k2 - 0.5    ( ) k3 - 10'), 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->Cell(45, 7, utf8_decode('LONGITUD: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) C/Adaptador'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) S/Adaptador'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('TIPO DE PIE'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(100, 7, utf8_decode('( ) Clásica'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Fibra de Carbono'), 0);
        $pdf->Ln(8);
        $pdf->Cell(40, 7, utf8_decode('( ) Multiaxial'), 0);
        $pdf->Cell(60, 7, utf8_decode('( ) Sach'), 0);
        $pdf->Cell(40, 7, utf8_decode('( ) Tobillo Alto'), 0);
        $pdf->Cell(40, 7, utf8_decode('( ) Tobillo Bajo'), 0);
        $pdf->Ln(13);
        $pdf->Cell(50, 7, utf8_decode('( ) LIMP'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Win Walker'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Össur'), 0);
        $pdf->Ln(13);
        $pdf->Cell(50, 7, utf8_decode('TALLA: ____      LADO: ( ) L     ( ) R'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(100, 7, utf8_decode('ACABADO ESTÉTICO'), 0);
        $pdf->Cell(70, 7, utf8_decode('CONECTORES ESPECIALES'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( ) Neopreno'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Telireno'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Si'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) No'), 0);
        $pdf->Ln(8);
        $pdf->Cell(50, 7, utf8_decode('( ) Cover 3D'), 0);
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(100, 7, utf8_decode('MONTO COTIZADO: S/. _______________'), 0);
        $pdf->Ln(9);

        $pdf->AddPage();

        $M1 = BASE_URL . 'Assets/img/M1.jpg';
        $pdf->Image($M1, 0, 0, 210, 297);

        $pdf->Output('I', 'EvaluacionTransfemoral.pdf');
        die();        
    }

    public function FichaEvaluacionBiTransfemoral($id)
    {
        require('include/fpdf_temp.php');

        $datos = $this->model->Mostrar($id);

        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(0, 7, utf8_decode("FICHA DE EVALUACIÓN BILATERAL TRANSFEMORAL"), 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(40, 7, utf8_decode(' PACIENTE: '), 1);
        $pdf->Cell(0, 7, utf8_decode($datos['NOMBRES']), 1, 0, 'C');
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(50, 7, utf8_decode('PESO (Kg.): _____'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('2 TIPO DE ENCAJE'), 0);
        $pdf->Ln(9);
        
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( )  Fibra de Vidrio'), 0);
        $pdf->Cell(50, 7, utf8_decode('( )  Fibra de Carbono'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('PRIMERA TALLA LINER'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(45, 7, utf8_decode('TALLA: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Lineal'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Cónica'), 0);
        $pdf->Cell(0, 14, utf8_decode('( ) K1 - 0.0    ( ) k2 - 0.5    ( ) k3 - 10'), 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->Cell(45, 7, utf8_decode('LONGITUD: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) C/Adaptador'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) S/Adaptador'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('SEGUNDA TALLA LINER'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(45, 7, utf8_decode('TALLA: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Lineal'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Cónica'), 0);
        $pdf->Cell(0, 14, utf8_decode('( ) K1 - 0.0    ( ) k2 - 0.5    ( ) k3 - 10'), 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->Cell(45, 7, utf8_decode('LONGITUD: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) C/Adaptador'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) S/Adaptador'), 0);
        $pdf->Ln(10);


        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('2 TIPOS DE RODILLA'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( ) Mecánica'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Hidráulica'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Neumática'), 0);
        $pdf->Ln(8);
        $pdf->Cell(50, 7, utf8_decode('( ) Win Walker'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Össur'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Ottobock'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) LIMP'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(50, 7, utf8_decode('STUBBIES'), 0);
        $pdf->Cell(20, 7, utf8_decode('( ) Si'), 0);
        $pdf->Cell(20, 7, utf8_decode('( ) No'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('2 TIPOS DE PIE'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(100, 7, utf8_decode('( ) Clásica'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Fibra de Carbono'), 0);
        $pdf->Ln(8);
        $pdf->Cell(40, 7, utf8_decode('( ) Multiaxial'), 0);
        $pdf->Cell(60, 7, utf8_decode('( ) Sach'), 0);
        $pdf->Cell(40, 7, utf8_decode('( ) Tobillo Alto'), 0);
        $pdf->Cell(40, 7, utf8_decode('( ) Tobillo Bajo'), 0);
        $pdf->Ln(13);
        $pdf->Cell(50, 7, utf8_decode('( ) LIMP'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Win Walker'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Össur'), 0);
        $pdf->Ln(13);
        $pdf->Cell(50, 7, utf8_decode('TALLA: ____      LADO: ( ) L     ( ) R'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(100, 7, utf8_decode('ACABADO ESTÉTICO'), 0);
        $pdf->Cell(70, 7, utf8_decode('CONECTORES ESPECIALES'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( ) Neopreno'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Telireno'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Si'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) No'), 0);
        $pdf->Ln(8);
        $pdf->Cell(50, 7, utf8_decode('( ) Cover 3D'), 0);
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(100, 7, utf8_decode('MONTO COTIZADO: S/. _______________'), 0);
        $pdf->Ln(9);

        $pdf->AddPage();

        $M1 = BASE_URL . 'Assets/img/M1.jpg';
        $pdf->Image($M1, 0, 0, 210, 297);

        $pdf->Output('I', 'EvaluacionBilateralTransfemoral.pdf');
        die();        
    }

    public function FichaEvaluacionBiTranstibial($id)
    {
        require('include/fpdf_temp.php');

        $datos = $this->model->Mostrar($id);

        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(0, 7, utf8_decode("FICHA DE EVALUACIÓN BILATERAL TRANSTIBIAL"), 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(40, 7, utf8_decode(' PACIENTE: '), 1);
        $pdf->Cell(0, 7, utf8_decode($datos['NOMBRES']), 1, 0, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(50, 7, utf8_decode('PESO (Kg.): _____'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('2 TIPO DE ENCAJE'), 0);
        $pdf->Ln(9);
        
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( )  Fibra de Vidrio'), 0);
        $pdf->Cell(50, 7, utf8_decode('( )  Fibra de Carbono'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('PRIMER TALLA LINER'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(45, 7, utf8_decode('TALLA: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Lineal'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Cónica'), 0);
        $pdf->Cell(0, 14, utf8_decode('( ) K1 - 0.0    ( ) k2 - 0.5    ( ) k3 - 10'), 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->Cell(45, 7, utf8_decode('LONGITUD: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) C/Adaptador'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) S/Adaptador'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('SEGUNDA TALLA LINER'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(45, 7, utf8_decode('TALLA: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Lineal'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) Cónica'), 0);
        $pdf->Cell(0, 14, utf8_decode('( ) K1 - 0.0    ( ) k2 - 0.5    ( ) k3 - 10'), 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->Cell(45, 7, utf8_decode('LONGITUD: _____'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) C/Adaptador'), 0);
        $pdf->Cell(35, 7, utf8_decode('( ) S/Adaptador'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(70, 7, utf8_decode('2 TIPO DE PIE'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(100, 7, utf8_decode('( ) Clásica'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Fibra de Carbono'), 0);
        $pdf->Ln(8);
        $pdf->Cell(40, 7, utf8_decode('( ) Multiaxial'), 0);
        $pdf->Cell(60, 7, utf8_decode('( ) Sach'), 0);
        $pdf->Cell(40, 7, utf8_decode('( ) Tobillo Alto'), 0);
        $pdf->Cell(40, 7, utf8_decode('( ) Tobillo Bajo'), 0);
        $pdf->Ln(13);
        $pdf->Cell(50, 7, utf8_decode('( ) LIMP'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Win Walker'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Össur'), 0);
        $pdf->Ln(13);
        $pdf->Cell(50, 7, utf8_decode('TALLA: ____      LADO: ( ) L     ( ) R'), 0);
        $pdf->Ln(13);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(100, 7, utf8_decode('ACABADO ESTÉTICO'), 0);
        $pdf->Cell(70, 7, utf8_decode('CONECTORES ESPECIALES'), 0);
        $pdf->Ln(9);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(50, 7, utf8_decode('( ) Neopreno'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Telireno'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) Si'), 0);
        $pdf->Cell(50, 7, utf8_decode('( ) No'), 0);
        $pdf->Ln(8);
        $pdf->Cell(50, 7, utf8_decode('( ) Cover 3D'), 0);
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(100, 7, utf8_decode('MONTO COTIZADO: S/. _______________'), 0);
        $pdf->Ln(9);

        $pdf->AddPage();

        $M1 = BASE_URL . 'Assets/img/M1.jpg';
        $pdf->Image($M1, 0, 0, 210, 297);

        $pdf->Output('I', 'EvaluacionBilateralTranstibial.pdf');
        die();        
    }

    public function FichaEvaluacionManoParcial($id)
    {
        require('include/fpdf_temp.php');

        $datos = $this->model->Mostrar($id);

        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(0, 7, utf8_decode("FICHA DE EVALUACIÓN MANO PARCIAL"), 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(40, 7, utf8_decode(' PACIENTE: '), 1);
        $pdf->Cell(0, 7, utf8_decode($datos['NOMBRES']), 1, 0, 'C');
        $pdf->Ln(10);

        $M1 = BASE_URL . 'Assets/img/LadoMP.PNG';
        $pdf->Image($M1, 20, 58, 170, 120);

        $pdf->SetY(180);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('SELECCIÓN DE PRÓTESIS: '), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(55, 7, utf8_decode(' ( ) Mano Parcial Mecánica'), 0);
        $pdf->Cell(55, 7, utf8_decode(' ( ) Mano Parcial Biónica'), 0);
        $pdf->Cell(80, 7, utf8_decode(' ( ) Mano Parcial de Articulación Manual'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('PRUEBAS BIOMECÁNICAS: '), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, utf8_decode(' - Extensión / Flexión de Muñeca : '), 0);
        $pdf->Cell(0, 7, utf8_decode(' ________ / ________    (1 -> 10)'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, utf8_decode(' - Fuerza : '), 0);
        $pdf->Cell(0, 7, utf8_decode(' _________________     (1 -> 10)'), 0);
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('OBSERVACIONES: '), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->MultiCell(0, 10, '_________________________________________________________________________________________________________________________________________________________________________________', 0);

        $pdf->Output('I', 'EvaluacionManoParcial.pdf');
        die();
    }

    public function FichaEvaluacionTransradial($id)
    {
        require('include/fpdf_temp.php');

        $datos = $this->model->Mostrar($id);

        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(0, 7, utf8_decode("FICHA DE EVALUACIÓN TRANSRADIAL"), 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(40, 7, utf8_decode(' PACIENTE: '), 1);
        $pdf->Cell(0, 7, utf8_decode($datos['NOMBRES']), 1, 0, 'C');
        $pdf->Ln(10);

        $M1 = BASE_URL . 'Assets/img/LadoTransradial.PNG';
        $pdf->Image($M1, 20, 58, 170, 120);

        $pdf->SetY(180);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('SELECCIÓN DE PRÓTESIS: '), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(70, 7, utf8_decode(' ( ) Transradial Mecánica de TPU'), 0);
        $pdf->Cell(70, 7, utf8_decode(' ( ) Transradial tipo gancho con guante Cosmético'), 0);
        $pdf->Ln(7);
        $pdf->Cell(70, 7, utf8_decode(' ( ) Mano Completa Biónica'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('PRUEBAS BIOMECÁNICAS: '), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, utf8_decode(' - Extensión / Flexión de Codo : '), 0);
        $pdf->Cell(0, 7, utf8_decode(' ________ / ________    (1 -> 10)'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, utf8_decode(' - Fuerza : '), 0);
        $pdf->Cell(0, 7, utf8_decode(' _________________     (1 -> 10)'), 0);
        $pdf->Ln(15);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('OBSERVACIONES: '), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->MultiCell(0, 10, '______________________________________________________________________________________________________________________', 0);

        $pdf->Output('I', 'EvaluacionTransradial.pdf');
        die();
    }

    /************** </EVALUACIÓN TRANSFEMORAL> **************/
}
