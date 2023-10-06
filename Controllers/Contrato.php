<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class Contrato extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function generar($id)
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 5);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Contratos | KYPBioingeniería';
            $data['activePaciente'] = 'active';
            $data['scripts'] = 'Contrato/contrato.js';
            $data['get'] = $this->model->getPaciente($id);
            $this->views->getView('Contrato', 'contrato', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function getLista($id)
    {
        $data = $this->model->getLista($id);
        for ($i = 0; $i < COUNT($data); $i++) {
            $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="AbrirContrato(\'' . $data[$i]['ID'] . '\', \'' . addslashes($data[$i]['OBSERVACION']) . '\', ' . $data[$i]['MONTO'] . ')">
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


    public function ListaComponente($id)
    {
        $data = $this->model->ListaComponente($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    /********** REGISTRAR CONTRATO **********/

    public function Registrar($id)
    {
        $lista = $this->model->getContrato($id);

        $id_paciente = $lista['ID_PACIENTE'];
        $monto = $lista['MONTO'];
        $ser = $lista['TIP_TRAB'];
        $tra = $lista['SUB_TRAB'];
        $blob = $this->PdfContratoServi($id);

        $data = $this->model->RegistrarContrato($id_paciente, $ser, $tra, $monto, $blob);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Contrato Registrado', 'id' => $data);
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Registrar Contrato');
        }


        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function PdfContrato($id)
    {
        require('include/fpdf_temp.php');

        $datos = $this->model->getDatosCotizacion($id);
        $lista = $this->model->getListaComponentes($id);

        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 9, "CONTRATO", 0, 1, 'L', true);
        $pdf->Ln(8);

        $html = 'Conste por el presente contrato que celebran de una parte, KYP BIO IN GEN S.A.C. a quien en adelante se le denominará LA EMPRESA identificado con el RUC 20600880081, y con domicilio en Calle Max Palma Arrué 1117 Los Olivos, y por otra parte del Sr(a). ' . $datos['NOMBRES'] . ', identificado(a) con DNI ' . $datos['DNI'] . ', en adelante EL CLIENTE, intervienen ambos en su propio nombre y derecho, reconociéndose la mutua capacidad legal necesaria para celebrar el presente contrato para una prótesis transfemoral, de acuerdo con las siguientes:';

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'ESTIPULACIONES:', 0, 1, 'L', false);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'Primera:', 0, 1, 'L', false);
        $pdf->Ln(2);

        $html2 = 'Que EL CLIENTE contrata los servicios profesionales de LA EMPRESA en su calidad de profesionales de la actividad de desarrollo de prótesis:';
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html2), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('    '. $datos['CANTIDAD'] .' ' . $datos['SUB_TRAB']));
        $pdf->Ln(8);

        foreach ($lista as $row) {
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->Cell(0, 7, utf8_decode('    -   ' . $row['LISTA']));
            $pdf->Ln(6);
        }
        $pdf->Ln(8);

        if (!empty($datos['OBSERVACION'])) {
            $pdf->SetFont('RubikMedium', '', 12);
            $pdf->Cell(0, 7, utf8_decode('    Observaciones:'));
            $pdf->Ln(8);
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->MultiCell(0, 7, utf8_decode('    ' . $datos['OBSERVACION']), 0);
            $pdf->Ln(8);
        }

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'Segunda: El Plazo', 0, 1, 'L', false);
        $pdf->Ln(2);

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {
            $html3 = 'El plazo de entrega es de 35 a 45 días hábiles a partir de la fecha de la firma del acuerdo.';
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode($html3), 0);
            $pdf->Ln(8);
        } else if ($datos['TIP_TRAB'] == 'Miembro Superior') {
            $html4 = 'El plazo de entrega es de 35 a 45 días hábiles a partir de la fecha de la firma del acuerdo.';
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode($html4), 0);
            $pdf->Ln(8);
        } else if ($datos['TIP_TRAB'] == 'Estética') {
            $html5 = 'El plazo de entrega es de 90 días hábiles a partir de la fecha de la firma del acuerdo.';
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode($html5), 0);
            $pdf->Ln(8);
        }

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'Tercero: Citas', 0, 1, 'L', false);
        $pdf->Ln(2);

        $html6 = 'El paciente debe acercarse a las instalaciones de KYP cada vez que el especialista lo solicite, el cual se notificará a la empresa con un mínimo de tres días de anticipación para cada cita. En caso el paciente no pueda acudir en la fecha solicitada. Esto podría implicar una extensión de la fecha de la entrega final de la prótesis. La cantidad de citas se le indica al momento de la evaluación el cual varía según la complejidad y particularidad de cada paciente.';
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html6), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'Cuarto: Costo', 0, 1, 'L', false);
        $pdf->Ln(2);

        $html7 = 'El precio estipulado para el desarrollo de la prótesis es de S/. ' . $datos['MONTO'] . '.';
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html7), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Quinto: Protección de datos personales'), 0, 1, 'L', false);
        $pdf->Ln(2);

        $html8 = 'LA EMPRESA, reconoce que en el marco del presente contrato podrán disponer y tener acceso a datos personales y sensibles, sobre personas con discapacidad. En tal sentido, y en observancia de la Ley 29733, Ley de Protección de Datos Personales y su Reglamento aprobado mediante el Decreto Supremo 003-2013-JUS, LA EMPRESA, se obliga a recolectar el consentimiento previo, expreso e informado de los titulares de datos personales para el tratamiento de su información personal. Asimismo, LA EMPRESA se compromete a no divulgar, transferir o utilizar dicha información para alguna finalidad distinta a las establecidas en este contrato, sin que no medie una autorización previa y expresa para ello por parte del titular de la información personal.';

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html8), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Sexto: Garantía'), 0, 1, 'L', false);
        $pdf->Ln(2);

        $html9 = 'Con el presente contrato para la prótesis y teniendo en cuenta nuestro compromiso con el paciente, LA EMPRESA se hace totalmente responsable del mantenimiento de la prótesis durante un plazo de un (1) año consecutivo, en caso de que la misma o alguna de sus partes presente falla o daño de fabricación entendiendo que cualquier daño o rotura causado por el uso incorrecto según las indicaciones de la ficha técnica invalidará la presente garantía. ';
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html9), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Séptima: Solución de controversias'), 0, 1, 'L', false);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('Toda discrepancia en la aplicación o interpretación del presente convenio buscará ser solucionado mediante el entendimiento directo, sobre la base de las reglas de la buena fe y común intención de las partes, procurando para tal efecto, la máxima colaboración para la solución de las diferencias. En caso de ser resueltas las discrepancias o controversias que puedan surgir en el cumplimiento y/o ejecución del presente contrato, las mismas se someterán a arbitraje, en el marco de lo establecido en el Derecho Legislativo N° 1071, Decreto Legislativo que norma el arbitraje.'));
        $pdf->Ln(8);


        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Octava: Disposiciones finales'), 0, 1, 'L', false);
        $pdf->Ln(2);

        setlocale(LC_TIME, 'es_ES', 'es_ES.UTF-8', 'es_ES.utf8');

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('Estando conformes en los términos y condiciones del presente convenio, las partes lo suscriben en 2 ejemplares, en la ciudad de ' . $datos['SEDE'] . ', ' . strftime("%d de %B de %Y", strtotime(date('Y-M-d'))) . '.'));
        $pdf->Ln(20);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, '---------------------------------', 0, 0, 'L');
        $pdf->Cell(100, 7, '---------------------------------', 0, 0, 'R');
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, utf8_decode('Área Administrativa'), 0, 0, 'L');
        $pdf->Cell(100, 7, utf8_decode($datos['NOMBRES']), 0, 0, 'R');
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, '', 0, 0, 'L');
        $pdf->Cell(100, 7, utf8_decode('DNI: ' . $datos['DNI']), 0, 0, 'R');
        $pdf->Ln(7);

        $pdf->AddPage();

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 7, "ORDEN DE PEDIDO", 0, 1, 'L', true);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(0, 7, utf8_decode("N° Paciente: " . $datos['ID_PACIENTE']), 0, 1, 'L', false);
        $pdf->Cell(0, 7, utf8_decode("Nombre del Paciente: " . $datos['NOMBRES']), 0, 1, 'L', false);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode("Lista de Componentes"), 0, 1, 'L', false);
        $pdf->Ln(5);

        foreach ($lista as $row) {
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->Cell(0, 7, utf8_decode('    -   ' . $row['LISTA']));
            $pdf->Ln(6);
        }
        $pdf->Ln(8);


        $pdfFileName = 'Contrato.pdf'; // Nombre del archivo PDF
        $pdf->Output('F', $pdfFileName); // Guardar el PDF en el servidor
        $pdf->Output('I', $pdfFileName);

        die();
    }

    public function PdfContratoServi($id)
    {
        require('include/fpdf_temp.php');

        $datos = $this->model->getDatosCotizacion($id);
        $lista = $this->model->getListaComponentes($id);

        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 9, "CONTRATO", 0, 1, 'L', true);
        $pdf->Ln(8);

        $html = 'Conste por el presente contrato que celebran de una parte, KYP BIO IN GEN S.A.C. a quien en adelante se le denominará LA EMPRESA identificado con el RUC 20600880081, y con domicilio en Calle Max Palma Arrué 1117 Los Olivos, y por otra parte del Sr(a). ' . $datos['NOMBRES'] . ', identificado(a) con DNI ' . $datos['DNI'] . ', en adelante EL CLIENTE, intervienen ambos en su propio nombre y derecho, reconociéndose la mutua capacidad legal necesaria para celebrar el presente contrato para una prótesis transfemoral, de acuerdo con las siguientes:';

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'ESTIPULACIONES:', 0, 1, 'L', false);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'Primera:', 0, 1, 'L', false);
        $pdf->Ln(2);

        $html2 = 'Que EL CLIENTE contrata los servicios profesionales de LA EMPRESA en su calidad de profesionales de la actividad de desarrollo de prótesis:';
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html2), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('    '. $datos['CANTIDAD'] .' ' . $datos['SUB_TRAB']));
        $pdf->Ln(8);

        foreach ($lista as $row) {
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->Cell(0, 7, utf8_decode('    -   ' . $row['LISTA']));
            $pdf->Ln(6);
        }
        $pdf->Ln(8);

        if (!empty($datos['OBSERVACION'])) {
            $pdf->SetFont('RubikMedium', '', 12);
            $pdf->Cell(0, 7, utf8_decode('    Observaciones:'));
            $pdf->Ln(8);
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->MultiCell(0, 7, utf8_decode('    ' . $datos['OBSERVACION']), 0);
            $pdf->Ln(8);
        }

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'Segunda: El Plazo', 0, 1, 'L', false);
        $pdf->Ln(2);

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {
            $html3 = 'El plazo de entrega es de 35 a 45 días hábiles a partir de la fecha de la firma del acuerdo.';
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode($html3), 0);
            $pdf->Ln(8);
        } else if ($datos['TIP_TRAB'] == 'Miembro Superior') {
            $html4 = 'El plazo de entrega es de 35 a 45 días hábiles a partir de la fecha de la firma del acuerdo.';
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode($html4), 0);
            $pdf->Ln(8);
        } else if ($datos['TIP_TRAB'] == 'Estética') {
            $html5 = 'El plazo de entrega es de 90 días hábiles a partir de la fecha de la firma del acuerdo.';
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode($html5), 0);
            $pdf->Ln(8);
        }

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'Tercero: Citas', 0, 1, 'L', false);
        $pdf->Ln(2);

        $html6 = 'El paciente debe acercarse a las instalaciones de KYP cada vez que el especialista lo solicite, el cual se notificará a la empresa con un mínimo de tres días de anticipación para cada cita. En caso el paciente no pueda acudir en la fecha solicitada. Esto podría implicar una extensión de la fecha de la entrega final de la prótesis. La cantidad de citas se le indica al momento de la evaluación el cual varía según la complejidad y particularidad de cada paciente.';
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html6), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, 'Cuarto: Costo', 0, 1, 'L', false);
        $pdf->Ln(2);

        $html7 = 'El precio estipulado para el desarrollo de la prótesis es de S/. ' . $datos['MONTO'] . '.';
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html7), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Quinto: Protección de datos personales'), 0, 1, 'L', false);
        $pdf->Ln(2);

        $html8 = 'LA EMPRESA, reconoce que en el marco del presente contrato podrán disponer y tener acceso a datos personales y sensibles, sobre personas con discapacidad. En tal sentido, y en observancia de la Ley 29733, Ley de Protección de Datos Personales y su Reglamento aprobado mediante el Decreto Supremo 003-2013-JUS, LA EMPRESA, se obliga a recolectar el consentimiento previo, expreso e informado de los titulares de datos personales para el tratamiento de su información personal. Asimismo, LA EMPRESA se compromete a no divulgar, transferir o utilizar dicha información para alguna finalidad distinta a las establecidas en este contrato, sin que no medie una autorización previa y expresa para ello por parte del titular de la información personal.';

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html8), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Sexto: Garantía'), 0, 1, 'L', false);
        $pdf->Ln(2);

        $html9 = 'Con el presente contrato para la prótesis y teniendo en cuenta nuestro compromiso con el paciente, LA EMPRESA se hace totalmente responsable del mantenimiento de la prótesis durante un plazo de un (1) año consecutivo, en caso de que la misma o alguna de sus partes presente falla o daño de fabricación entendiendo que cualquier daño o rotura causado por el uso incorrecto según las indicaciones de la ficha técnica invalidará la presente garantía. ';
        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode($html9), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Séptima: Solución de controversias'), 0, 1, 'L', false);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('Toda discrepancia en la aplicación o interpretación del presente convenio buscará ser solucionado mediante el entendimiento directo, sobre la base de las reglas de la buena fe y común intención de las partes, procurando para tal efecto, la máxima colaboración para la solución de las diferencias. En caso de ser resueltas las discrepancias o controversias que puedan surgir en el cumplimiento y/o ejecución del presente contrato, las mismas se someterán a arbitraje, en el marco de lo establecido en el Derecho Legislativo N° 1071, Decreto Legislativo que norma el arbitraje.'));
        $pdf->Ln(8);


        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode('Octava: Disposiciones finales'), 0, 1, 'L', false);
        $pdf->Ln(2);

        setlocale(LC_TIME, 'es_ES', 'es_ES.UTF-8', 'es_ES.utf8');

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->MultiCell(0, 5, utf8_decode('Estando conformes en los términos y condiciones del presente convenio, las partes lo suscriben en 2 ejemplares, en la ciudad de ' . $datos['SEDE'] . ', ' . strftime("%d de %B de %Y", strtotime(date('Y-M-d'))) . '.'));
        $pdf->Ln(20);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, '---------------------------------', 0, 0, 'L');
        $pdf->Cell(100, 7, '---------------------------------', 0, 0, 'R');
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, utf8_decode('Área Administrativa'), 0, 0, 'L');
        $pdf->Cell(100, 7, utf8_decode($datos['NOMBRES']), 0, 0, 'R');
        $pdf->Ln(5);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(90, 7, '', 0, 0, 'L');
        $pdf->Cell(100, 7, utf8_decode('DNI: ' . $datos['DNI']), 0, 0, 'R');
        $pdf->Ln(7);

        $pdf->AddPage();

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 7, "ORDEN DE PEDIDO", 0, 1, 'L', true);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 12);
        $pdf->Cell(0, 7, utf8_decode("N° Paciente: " . $datos['ID_PACIENTE']), 0, 1, 'L', false);
        $pdf->Cell(0, 7, utf8_decode("Nombre del Paciente: " . $datos['NOMBRES']), 0, 1, 'L', false);
        $pdf->Ln(8);

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->Cell(0, 7, utf8_decode("Lista de Componentes"), 0, 1, 'L', false);
        $pdf->Ln(5);

        foreach ($lista as $row) {
            $pdf->SetFont('RubikRegular', '', 12);
            $pdf->Cell(0, 7, utf8_decode('    -   ' . $row['LISTA']));
            $pdf->Ln(6);
        }
        $pdf->Ln(8);


        $servi = $pdf->Output('S', 'Contrato.pdf');

        return $servi;
    }

    /********** PAGOS DE CONTRATO **********/

    public function pagos()
    {

        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 5);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Pacientes - Pagos de Contrato | KYPBioingeniería';
            $data['activePagos'] = 'active';
            $data['scripts'] = 'Contrato/pagos.js';
            $this->views->getView('Contrato', 'pagos', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }
    }

    public function ListaPagos()
    {
        $data = $this->model->ListaContrato();

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['ACCIONES'] = '
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="Visualizar(' . $data[$i]['ID'] . ')">
                            <i class="mdi mdi-eye-outline mdi-20px mx-1"></i> 
                            Visualizar
                        </button>
                        <button type="button" class="dropdown-item" onclick="VisualizarContrato('.$data[$i]['ID'].')">
                            <i class="mdi mdi-file-pdf-box mdi-20px mx-1"></i> 
                            Ver Contrato
                        </button>
                    </div>
                </div>
            ';

        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function historialPagos($id)
    {
        $data['title'] = 'Gestión de Pacientes - Historial de Contrato | KYPBioingeniería';
        $data['activePagos'] = 'active';
        $data['scripts'] = 'Contrato/registroPago.js';
        $data['datos'] = $this->model->getDatos($id);
        $data['saldo'] = $this->model->SaldoPagos($id);
        $this->views->getView('Contrato', 'historialPagos', $data);
    }


    public function RegistroPago()
    {
        $id_contrato = $_POST['id_contrato'];
        $id_paciente = $_POST['id_paciente'];
        $nPago = $_POST['NPago'];
        $monto = $_POST['MontoA'];
        $tipPago = $_POST['TipPago'];
        $metodo = $_POST['Metodo'];
        $compro = $_FILES['file'];

        $saldo = $this->model->SaldoPagos($id_contrato);
        $total = $this->model->MontoAbonado($id_contrato);


        if (!$compro['error'] == UPLOAD_ERR_NO_FILE) {
            $tmp_name = file_get_contents($compro['tmp_name']);
        } else {
            $tmp_name = NULL;
        }

        if ($nPago == 'Pago 1') {
            if ($monto > $total['MONTO']) {
                $res = array('tipo' => 'warning', 'mensaje' => 'El monto abonado es mayor al saldo restante');
            } else {
                $data = $this->model->RegistroPago($id_contrato, $id_paciente, $nPago, $monto, $tipPago, $metodo, $tmp_name);
                if ($data > 0) {
                    $res = array('tipo' => 'success', 'mensaje' => 'Pago Registrado', 'id' => $data);
                } else if ($data == "existe") {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El N° Pago ya fue Registrado');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'Error al Pago Contrato');
                }
            }
        } else {
            if ($monto > $saldo['TOTAL']) {
                $res = array('tipo' => 'warning', 'mensaje' => 'El monto abonado es mayor al saldo restante');
            } else {
                $data = $this->model->RegistroPago($id_contrato, $id_paciente, $nPago, $monto, $tipPago, $metodo, $tmp_name);
                if ($data > 0) {
                    $res = array('tipo' => 'success', 'mensaje' => 'Pago Registrado', 'id' => $data);
                } else if ($data == "existe") {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El N° Pago ya fue Registrado');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'Error al Pago Contrato');
                }
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ListarPagos($id)
    {
        $data = $this->model->ListarPagos($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Comprobante($id)
    {
        $data = $this->model->MostrarComprobante($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Recibo($id)
    {
        require('Assets/vendor/libs/fpdf/fpdf.php');

        $datos = $this->model->getDatosRecibo($id);
        $contrato = $this->model->getDatosContrato($id);
        $npagos = $this->model->getRowPagos($datos['ID_PACIENTE'], $datos['ID_CONTRATO']);
        $saldos = $this->model->getSaldos($datos['ID_PACIENTE'], $datos['ID_CONTRATO']);

        $pdf = new FPDF();
        $pdf->AddPage('PORTRAIT', 'A4');

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 14);
        $pdf->Cell(0, 10, utf8_decode('RECIBO DE PAGO DE ' . mb_strtoupper($contrato['SUB_TRAB'])), 0, 0, 'C', false);
        $pdf->Ln(15);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 7, utf8_decode('FECHA:'), 1, 0, 'L', false);
        $pdf->Cell(95, 7, date('Y - m - d'), 1, 0, 'L', false);
        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 7, utf8_decode('EMPRESA:'), 1, 0, 'L', false);
        $pdf->Cell(95, 7, utf8_decode('KYP BIOINGEN S.A.C'), 1, 0, 'L', false);
        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 7, utf8_decode('PACIENTE:'), 1, 0, 'L', false);
        $pdf->Cell(95, 7, utf8_decode(mb_strtoupper($datos['NOMBRES'])), 1, 0, 'L', false);
        $pdf->Ln(7);

        $pdf->SetFont('RubikRegular', '', 10);
        $pdf->Cell(95, 7, utf8_decode('FECHA CONTRATO:'), 1, 0, 'L', false);
        $pdf->Cell(95, 7, $contrato['FECHA'], 1, 0, 'L', false);
        $pdf->Ln(10);


        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 6, utf8_decode('Conste por el presente que la empresa KYP BIO INGENIERIA , identificado con RUC 20600880081, UBICADA EN Calle Max Palma Arrúe 119, Los Olivos, recibí del Paciente ' . mb_strtoupper($datos['NOMBRES']) . ', identificado con DNI ' . $datos['DNI'] . ' LOS SIGUIENTES MONTOS:'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(0, 8, utf8_decode('HISTORIAL DE PAGOS:'), 1, 0, 'L', false);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(95, 8, utf8_decode('Valor de la Prótesis: '), 1, 0, 'L', false);
        $pdf->Cell(95, 8, utf8_decode('S/. ' . $contrato['MONTO']), 1, 0, 'L', false);
        $pdf->Ln(8);

        foreach ($npagos as $row) {
            $pdf->SetFont('RubikRegular', '', 11);
            $pdf->Cell(95, 8, utf8_decode($row['NPAGO']), 1, 0, 'L', false);
            $pdf->Cell(95, 8, utf8_decode('S/. ' . $row['ABONO'] . '     Fecha: ' . $row['FECHA']), 1, 0, 'L', false);
            $pdf->Ln(8);
        }

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(95, 8, utf8_decode('Valor Faltante: '), 1, 0, 'L', false);
        $pdf->Cell(95, 8, utf8_decode('S/. ' . $saldos['TOTAL']), 1, 0, 'L', false);
        $pdf->Ln(12);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 6, utf8_decode('Por el pago DE UNA ' . mb_strtoupper($contrato['SUB_TRAB']) . '. El nuevo SALDO es:'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(95, 8, utf8_decode('Nuevo Saldo: '), 1, 0, 'L', false);
        $pdf->Cell(95, 8, utf8_decode('S/. ' . $saldos['TOTAL']), 1, 0, 'L', false);
        $pdf->Ln(13);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(95, 8, utf8_decode('Para constancia SE FIRMA LA PRESENTE'), 0, 0, 'L', false);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(95, 8, utf8_decode('FECHA: ' . date('Y - m - d')), 0, 0, 'L', false);
        $pdf->Ln(15);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(95, 8, utf8_decode('RECIBÍ CONFORME:'), 0, 0, 'L', false);
        $pdf->Ln(15);

        // Establecer las dimensiones de la celda
        $anchoCelda = 50;
        $altoCelda = 10;

        // Obtener las coordenadas de la celda
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Calcular las coordenadas de la línea
        $xInicioLinea = $x;
        $xFinLinea = $x + $anchoCelda;
        $yLinea = $y + $altoCelda;

        // Dibujar la línea debajo de la celda utilizando el método Line()
        $pdf->Line($xInicioLinea, $yLinea, $xFinLinea, $yLinea);
        $pdf->Ln(10);

        $pdf->Image('./Assets/img/firma_digital.png', $x + 122, $y + 15, 50, 0, 'PNG');

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->Cell(100, 6, utf8_decode('Paciente: ' . mb_strtoupper($datos['NOMBRES'])), 0, 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(100, 6, utf8_decode('DNI: ' . $datos['DNI']), 0, 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(95, 8, utf8_decode('CLIENTE'), 0, 0, 'L', false);
        $pdf->Ln(15);

        // Establecer las dimensiones de la celda
        $anchoCeldaCO = 50;
        $altoCeldaCO = 10;

        // Obtener las coordenadas de la celda
        $xCO = $pdf->GetX();
        $yCO = $pdf->GetY();

        // Calcular las coordenadas de la línea
        $xInicioLineaCO = $xCO;
        $xFinLineaCO = $xCO + $anchoCeldaCO;
        $yLineaCO = $yCO + $altoCeldaCO;

        // Dibujar la línea debajo de la celda utilizando el método Line()
        $pdf->Line($xInicioLineaCO + 25, $yLineaCO, $xFinLineaCO + 25, $yLineaCO);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(100, 6, utf8_decode('KYP BIO INGENIERIA'), 0, 0, 'C', false);
        $pdf->Cell(90, 6, utf8_decode('KYP BIO INGENIERIA'), 0, 0, 'C', false);
        $pdf->Ln(6);
        $pdf->Cell(100, 6, utf8_decode('ADMINISTRACIÓN'), 0, 0, 'C', false);
        $pdf->Cell(90, 6, utf8_decode('GERENCIA'), 0, 0, 'C', false);
        $pdf->Ln(15);

        $servi = $pdf->Output('S', $datos['ID_PACIENTE'] . '.pdf', true);
        $pdf->Output('I', 'Recibo_Pago.pdf');
        $this->model->RegistrarPdfPago($datos['ID'], $servi);
        die();
    }

    public function MostrarRecibo($id)
    {
        $data = $this->model->MostrarRecibo($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function MostrarContrato($id)
    {
        $data = $this->model->MostrarContrato($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function EnviarCorreo()
    {

        $id_contrato = $_POST['id_contrato'];
        $id_coti = $_POST['id_coti'];

        $mail = new PHPMailer(true);
        $datos = $this->model->getDatosMailer($id_contrato);
        $lista = $this->model->getListaComponentes($id_coti);
        $obs = $this->model->getDatosCotizacion($id_coti);

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
            */


            $mail->CharSet = 'UTF-8';

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Paciente ' . $datos['NOMBRES'] . ' hizo Contrato';
            $mail->Body    = '
                <h5>PACIENTE: ' . $datos['NOMBRES'] . '</h5>
                <ul>
                    <li>Codigo: ' . $datos['ID_PACIENTE'] . '</li>
                    <li>Servicio: ' . $datos['SUB_TRAB'] . '</li>
                    <li>Fecha de Contrato ' . $datos['FECHA'] . '</li>
                    <li>Peso del Paciente (Kg.): ' . $obs['PESO'] . '</li>
                </ul>   
                <p><strong>Componentes:</strong></p>
                <ul>
            ';

            foreach ($lista as $row) {
                $mail->Body .= '<li>' . $row['LISTA'] . '</li>';
            }
            $mail->Body .= '</ul>';

            if (!empty($obs['OBSERVACION'])) {
                $mail->Body .= '
                <p><strong>Observaciones</strong></p>
                <p>' . $obs['OBSERVACION'] . '</p>
                ';
            }


            $mail->send();
            echo "Enviado";
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }
    }

    public function EnviarCorreoImpor()
    {

        $id_contrato = $_POST['id_contrato'];
        $id_coti = $_POST['id_coti'];

        $mail = new PHPMailer(true);
        $datos = $this->model->getDatosMailer($id_contrato);
        $lista = $this->model->getListaComponentes($id_coti);
        $obs = $this->model->getDatosCotizacion($id_coti);

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
            */


            $mail->CharSet = 'UTF-8';

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Paciente ' . $datos['NOMBRES'] . ' hizo Contrato';
            $mail->Body    = '
                <h5>PACIENTE: ' . $datos['NOMBRES'] . '</h5>
                <ul>
                    <li>Codigo: ' . $datos['ID_PACIENTE'] . '</li>
                    <li>Servicio: ' . $datos['SUB_TRAB'] . '</li>
                    <li>Fecha de Contrato ' . $datos['FECHA'] . '</li>
                    <li>Peso del Paciente (Kg.): ' . $datos['PESO'] . '</li>
                </ul>   
                <p><strong>Componentes:</strong></p>
                <ul>
            ';

            foreach ($lista as $row) {
                $mail->Body .= '<li>' . $row['LISTA'] . '</li>';
            }
            $mail->Body .= '</ul>';

            if (!empty($obs['OBSERVACION'])) {
                $mail->Body .= '
                <p><strong>Observaciones</strong></p>
                <p>' . $obs['OBSERVACION'] . '</p>
                ';
            }

            $mail->addAttachment('Contrato.pdf');

            $mail->send();
            echo "Enviado";
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }
    }
}