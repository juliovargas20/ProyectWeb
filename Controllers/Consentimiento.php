<?php
class Consentimiento extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function consen()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 12);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Carta Consentimiento | KYPBioingeniería';
            $data['activeConsen'] = 'active';
            $data['scripts'] = 'Consentimiento/Listado.js';
            $this->views->getView('Consentimiento', 'listado', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function Listar()
    {
        $data = $this->model->Listar();
        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i]['CONSEN'] == 0) {
                $data[$i]['ACCIONES'] = '
                    <button type="button" class="btn btn-icon btn-label-danger waves-effect" onclick="redirect(\'' . $data[$i]['ID_PACIENTE'] . '\')">
                        <i class="mdi mdi-eye-outline">
                        </i>
                    </button>
                ';
            } else {
                $data[$i]['ACCIONES'] = '
                <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                        <a href="javascript:;" class="dropdown-item" onclick="CartaSP('.$data[$i]['ID'].')">
                            <i class="mdi mdi-file-document me-1"></i> 
                            Provicional
                        </a>
                        <a href="javascript:;" class="dropdown-item" onclick="CartaSF('.$data[$i]['ID'].')">
                            <i class="mdi mdi-file-document me-1"></i> 
                            Final
                        </a>
                        <a href="javascript:;" class="dropdown-item" onclick="CartaImagen('.$data[$i]['ID'].')">
                            <i class="mdi mdi-image me-1"></i> 
                            Imagen
                        </a>
                    </div>
                </div>
                ';
            }
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
        $verificar = $this->model->Verificar($id_caja, 12);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Carta Consentimiento | KYPBioingeniería';
            $data['activeConsen'] = 'active';
            $data['scripts'] = 'Consentimiento/agregar.js';
            $data['get'] = $this->model->getDatos($id);
            $this->views->getView('Consentimiento', 'agregar', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function RegistrarDatos()
    {
        $id_paciente = $_POST['id_paciente'];
        $id_contrato = $_POST['id_contrato'];
        $tip = $_POST['tip_trab'];
        $sub = $_POST['sub_trab'];

        $data = $this->model->RegistrarDatos($id_contrato, $id_paciente, $tip, $sub);
        if ($data > 0) {
            $this->model->UpdateConsen($id_contrato);
            $res = array('tipo' => 'success', 'mensaje' => 'Datos Registrado', 'id' => $data);
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Datos Contrato');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarLista($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $item = $data['selecciones'];

        for ($i = 0; $i < count($item); $i++) {
            $lista = $item[$i];
            $data = $this->model->RegistrarLista($id, $lista);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Lista Registrada');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'error Lista Registrada');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function CartaSP($id)
    {
        require('Assets/vendor/libs/fpdf/fpdf.php');

        $pdf = new FPDF();

        $get_id = $this->model->getIDPA($id);

        $get = $this->model->getDatosCarta($get_id['ID']);
        $lista = $this->model->getLista($get_id['ID']);

        $pdf->AddPage();
        $pdf->SetLeftMargin(22.4);
        $pdf->SetRightMargin(22.4);

        $pdf->Image(BASE_URL . 'Assets/img/encabezado.png', 85, 8, 38, 15, 'png');
        $pdf->Ln(20);

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $dia = date('d');
        $mes = date('m');
        $año = date('Y');

        $nombre_mes = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');

        $fecha_hoy = $dia . ' de ' . $nombre_mes[$mes] . ' del ' . $año;

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode($get['SEDE'] . ', ' . $fecha_hoy), 0, 1, 'R');
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Señores:'), 0, 1);
        $pdf->Ln(0);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(0, 7, utf8_decode($get['NOMBRES']), 0, 1);
        $pdf->Ln(0);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode($get['SEDE']), 0, 1);
        $pdf->Ln(0);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Presente.-'), 0, 1);
        $pdf->Ln(5);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Ref.: CARTA DE CONFORMIDAD'), 0, 1, 'C');
        $pdf->Ln(1);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Estimado Sr. ' . $get['NOMBRES']), 0, 1);
        $pdf->Ln(3);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5, utf8_decode('En KYP Bio Ingen, estamos emocionados de ser parte de este paso importante en su vida y agradecemos sinceramente su confianza en nuestros servicios.'), 0);
        $pdf->Ln(3);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Detalles de la Prótesis Entregada:'), 0, 1);
        $pdf->Ln(3);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Tipo de Prótesis: ' . $get['SUB_TRAB']), 0, 1);
        $pdf->Ln(-1);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Fabricante: KYP Bio Ingen SAC'), 0, 1);
        $pdf->Ln(-1);

        foreach ($lista as $row) {
            $pdf->SetFont('RubikRegular', '', 11);
            $pdf->Cell(0, 7, utf8_decode($row['ITEM']), 0, 1);
            $pdf->Ln(-1);
        }

        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5, utf8_decode('Nos esforzamos por proporcionar productos que no solo sean funcionales y duraderos, sino también cómodos y adaptados a sus necesidades individuales. Esperamos que esta prótesis contribuya significativamente a mejorar su calidad de vida.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5, utf8_decode('Al finalizar tu periodo de prueba, pasaremos al cambio de tu encaje PROVICIONAL a un encaje en FIBRA DE CARBONO, contribuyendo a que tu nuevo encaje se adapte mejor con tus nuevas medidas y las correcciones necesarias.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Atentamente,'), 0, 1);
        $pdf->Ln(20);

        $pdf->SetFont('arial', '', 11);
        $pdf->Cell(85, 7, utf8_decode('..............................................................'), 0, 0);
        $pdf->Cell(80, 7, utf8_decode('.......................................'), 0, 1, 'C');
        $pdf->Ln(-1);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(85, 5, utf8_decode($get['NOMBRES']), 0, 0);
        $pdf->Cell(80, 5, utf8_decode('ADMINISTRACIÓN'), 0, 1, 'C');
        $pdf->Cell(85, 5, utf8_decode('DNI ' . $get['DNI']), 0, 1);
        $pdf->Cell(85, 5, utf8_decode('Cliente'), 0, 1);
        $pdf->Ln(20);

        $pdf->Output('I', 'SocketProvisional.pdf');
    }

    public function CartaSF($id)
    {
        require('Assets/vendor/libs/fpdf/fpdf.php');

        $pdf = new FPDF();

        $get_id = $this->model->getIDPA($id);

        $get = $this->model->getDatosCarta($get_id['ID']);
        $lista = $this->model->getLista($get_id['ID']);

        $pdf->AddPage();
        $pdf->SetLeftMargin(22.4);
        $pdf->SetRightMargin(22.4);

        $pdf->Image(BASE_URL . 'Assets/img/encabezado.png', 85, 8, 38, 15, 'png');
        $pdf->Ln(20);

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $dia = date('d');
        $mes = date('m');
        $año = date('Y');

        $nombre_mes = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');

        $fecha_hoy = $dia . ' de ' . $nombre_mes[$mes] . ' del ' . $año;

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode($get['SEDE'] . ', ' . $fecha_hoy), 0, 1, 'R');
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Señores:'), 0, 1);
        $pdf->Ln(-1);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(0, 7, utf8_decode($get['NOMBRES']), 0, 1);
        $pdf->Ln(-1);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode($get['SEDE']), 0, 1);
        $pdf->Ln(-1);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Presente.-'), 0, 1);
        $pdf->Ln(1);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Ref.: CARTA DE ENTREGA'), 0, 1, 'C');
        $pdf->Ln(1);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Estimado Sr. ' . $get['NOMBRES']), 0, 1);
        $pdf->Ln(3);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5, utf8_decode('En KYP Bio Ingen, estamos emocionados de ser parte de este paso importante en su vida y agradecemos sinceramente su confianza en nuestros servicios.'), 0);
        $pdf->Ln(3);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Detalles de la Prótesis Entregada:'), 0, 1);
        $pdf->Ln(3);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Tipo de Prótesis: ' . $get['SUB_TRAB']), 0, 1);
        $pdf->Ln(-1);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Fabricante: KYP Bio Ingen SAC'), 0, 1);
        $pdf->Ln(-1);

        foreach ($lista as $row) {
            $pdf->SetFont('RubikRegular', '', 11);
            $pdf->Cell(0, 7, utf8_decode($row['ITEM']), 0, 1);
            $pdf->Ln(-1);
        }

        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5, utf8_decode('Nos esforzamos por proporcionar productos que no solo sean funcionales y duraderos, sino también cómodos y adaptados a sus necesidades individuales. Esperamos que esta prótesis contribuya significativamente a mejorar su calidad de vida. Tenga presente que a partir de esta entrega tendrá controles cada mes hasta la fecha de finalización de su contrato, que incluye el mantenimiento de las piezas.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5, utf8_decode('Recuerde que el socket y el LINNER no tiene garantía por fluctuación de volumen del muñón, los daños al socket, conectores, rodilla, tubo o pie serán evaluados por el Técnico para efectuar su garantía si esta aplica, tampoco deberá manipular los tornillos. De necesitar algún ajuste debe comunicarse para solicitar una cita en evaluación con el técnico disponible.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5, utf8_decode('Al firmar este documento acepta el estar conforme con su prótesis y las piezas que este tiene en su totalidad; asimismo la claridad con el proceso de adaptación, el uso correcto, aseo diario de su LINNER con los productos entregados, manuales de uso y tiempos de garantía.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(0, 7, utf8_decode('Atentamente,'), 0, 1);
        $pdf->Ln(7);

        $pdf->SetFont('arial', '', 11);
        $pdf->Cell(85, 7, utf8_decode('..............................................................'), 0, 0);
        $pdf->Cell(80, 7, utf8_decode('.......................................'), 0, 1, 'C');
        $pdf->Ln(-1);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(85, 5, utf8_decode($get['NOMBRES']), 0, 0);
        $pdf->Cell(80, 5, utf8_decode('ADMINISTRACIÓN'), 0, 1, 'C');
        $pdf->Cell(85, 5, utf8_decode('DNI ' . $get['DNI']), 0, 1);
        $pdf->Cell(85, 5, utf8_decode('Cliente'), 0, 1);
        $pdf->Ln(20);

        $pdf->Output('I', 'SocketFinal.pdf');
    }

    public function Imagen($id)
    {
        require('Assets/vendor/libs/fpdf/fpdf.php');

        $pdf = new FPDF();

        $get_id = $this->model->getIDPA($id);
        $get = $this->model->getDatosCarta($get_id['ID']);

        $pdf->AddPage();
        $pdf->SetLeftMargin(22.4);
        $pdf->SetRightMargin(22.4);

        $pdf->Image(BASE_URL . 'Assets/img/encabezado.png', 85, 8, 38, 15, 'png');
        $pdf->Ln(30);

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('PERMISO DE USO DE IMAGEN'), 0, 0);
        $pdf->Ln(15);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5.5, utf8_decode('Yo, ' . $get['NOMBRES'] . ', identificado  con  DNI  Nº ' . $get['DNI'] . '. con  domicilio  en ' . $get['DIRECCION'] . ', otorgo mi consentimiento expreso a la empresa KYP - BIO INGEN S.A.C., con RUC Nº 20600880081 y domicilio legal en Cal. Max Palma Arrue Nro.1117 Urb. Venus. para utilizar mi imagen en fotografías y/o videos tomados por un equipo profesional.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5.5, utf8_decode('Este permiso abarca el uso de mi imagen en redes sociales, plataformas en Línea, material impreso, publicidades, material promocional y cualquier otro medio de difusión que KYP - BIO INGEN S.A.C. considere necesario parala promoci6n de sus servicios.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5.5, utf8_decode('Entiendo que las imágenes serán utilizadas exclusivamente con el propósito de promocionar los servicios ofrecidos por KYP - BIO INGEN S.AC. y no serán utilizadas para ningún otro propósito sin mi consentimiento expreso.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5.5, utf8_decode('Además, renunció a cualquier derecho de compensación o regalía por el uso de estas imágenes.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5.5, utf8_decode('Este permiso es válido desde La fecha de la firma y permanecerá en vigor durante un período de 1 año a partir de dicha fecha.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5.5, utf8_decode('En caso de revocación.cualquier material en el que mi imagen haya sido utilizada deberá ser retirado de a circulación en un plazo razonable de 15 días hábiles.'), 0);
        $pdf->Ln(25);

        $pdf->SetFont('arial', '', 12);
        $pdf->Cell(0, 7, '................................................', 0, 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(0, 7, 'Firma', 0, 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(0, 7, utf8_decode('DNI N°: ' . $get['DNI']), 0, 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Fecha'), 0, 0);
        $pdf->Ln(5);

        $pdf->Output('I', 'Imagen.pdf');
    }
}
