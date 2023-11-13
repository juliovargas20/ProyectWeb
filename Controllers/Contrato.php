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
        date_default_timezone_set('America/Lima');

        require('include/fpdf_temp.php');

        $datos = $this->model->getDatosCotizacion($id);
        $lista = $this->model->getListaComponentes($id);

        $dia = date('d');
        $mes = date('m');
        $año = date('Y');

        $nombre_mes = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');

        $fecha_hoy = $dia . ' de ' . $nombre_mes[$mes] . ' del ' . $año;

        $mes_actual = (int)$mes;
        $meses_a_sumar = 13;

        // Sumar meses
        $nuevo_mes = $mes_actual + $meses_a_sumar;

        // Ajustar el año si es necesario
        if ($nuevo_mes > 12) {
            $año += floor(($nuevo_mes - 1) / 12);
            $nuevo_mes = ($nuevo_mes - 1) % 12 + 1;
        }

        // Formatear la nueva fecha
        $fecha_resultado = $dia . ' de ' . $nombre_mes[str_pad($nuevo_mes, 2, '0', STR_PAD_LEFT)] . ' del ' . $año;


        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 9, utf8_decode("CONTRATO DE " . mb_strtoupper($datos['SUB_TRAB'], 'UTF-8')), 0, 1, 'C', true);
        $pdf->Ln(8);

        $html = $datos['SEDE'] . ', ' . $fecha_hoy . ', que celebran, de una parte, KYP BIO INGENIERIA con RUC 20600880081 a quien en adelante se le denominará "EL CONTRATISTA" y de otra parte ' . mb_strtoupper($datos['NOMBRES']) . ' con DNI ' . $datos['DNI'] . ', a quien en adelante se le denominará "EL CONTRATANTE". Para referirnos a ambos contratantes denominaremos como "LAS PARTES". Para referirnos al SERVICIO materia de DESARROLLO Y/ O REALIZACION se le denominará como SERVICIO DE PROTESIS DE ' . mb_strtoupper($datos['SUB_TRAB'], 'UTF-8') . '. Acordamos sin ningún vicio que altere nuestra real voluntad expresando las siguientes cláusulas contractuales: ';

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode($html), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 1°.- LEGITIMIDAD QUE ACREDITA EL DERECHO PARA LA REALIZACION DEL SERVICIO DE PROTESIS :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('1.1. "EL CONTRATISTA" tiene derecho y legitimidad para realizar el servicio de prótesis de acuerdo a la necesidad del locador (cliente) en mérito a la calidad de servicio y profesionalismo de DISEÑO DE PROTESIS BIOMECANICAS FUNCIONALES Y ESTETICAS.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 2°.- IDENTIFICACIÓN, INDIVIDUALIZACIÓN Y REFERENCIA PRECISA DE UBICACIÓN DEL SERVICIO COMERCIAL :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('2.1. El CONTRATISTA se encuentra, prestando servicio con las formalidades de ley, permisos y autorizaciones que requiere para la realización de la actividad y/o servicio que presta.  ubicado en CALLE MAX PALMA ARRUE MZ A LT 35, distrito de LOS OLIVOS provincia de LIMA , departamento de LOS OLIVOS.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('2.2. El presente servicio DE PROTESIS se identifica por las siguientes características: '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(0, 7, utf8_decode('    ' . $datos['CANTIDAD'] . ' ' . $datos['SUB_TRAB']));
        $pdf->Ln(8);

        foreach ($lista as $row) {
            $pdf->SetFont('RubikRegular', '', 11);
            $pdf->Cell(0, 7, utf8_decode('    -   ' . $row['LISTA']));
            $pdf->Ln(6);
        }
        $pdf->Ln(5);

        if (!empty($datos['OBSERVACION'])) {
            $pdf->SetFont('RubikMedium', '', 11);
            $pdf->Cell(0, 7, utf8_decode('    Observaciones:'));
            $pdf->Ln(8);
            $pdf->SetFont('RubikRegular', '', 11);
            $pdf->MultiCell(0, 7, utf8_decode('    ' . $datos['OBSERVACION']), 0);
            $pdf->Ln(5);
        }

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('2.3. El servicio  DE PROTESIS   cuenta con las siguientes garantías: '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('1 año de Garantía que brinda KYP BIO INGENIERIA a toda la prótesis (INCLUIDA PIEZAS).'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('LAS PROPIAS PIEZAS PODRIAN TENER UNA GARANTIA MAS LARGA, consultar en Front desk.'), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('2.4. "EL CONTRATANTE" declara bajo juramento que conoce perfectamente la individualización e identificación del SERVICIO REQUERIDO por lo que renuncia expresamente a cualquier argumento sobre la falta de especificación. '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 3°.- OBJETO, DESTINO Y PROTECCIÓN DEL LOCAL COMERCIAL :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('3.1. Por el presente contrato "EL CONTRATISTA" realizara el servicio de acuerdo a las características de acuerdo a lo mencionado en la cláusula precedente, haciendo entrega del SERVICIO PRESTADO en la fecha de estipulado en el presente contrato. "EL CONTRATANTE" a su vez podrá hacer las observaciones en el plazo que el servicio tenga vigente la garantía en lo que respecta su situación como usuario. '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('3.2 La CONFORMIDAD por el diseño del encaje es de manera automática al adquirir el SERVICIO DE DISEÑO DE PROTESIS, a cargo por un equipo PROFESIONAL parte del equipo de el CONTRATISTA, habiéndole informado de manera clara todo el proceso al CONTRATANTE. '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 4°.- PLAZO DEL CONTRATO :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('4.1. El plazo de contrato será de UN AÑO, el mismo que comenzará a regir desde el ' . $fecha_hoy . ' hasta el ' . $fecha_resultado . ' (13 MESES).'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 5°.- MERCED CONDUCTIVA, FORMA DE PAGO Y PETICIÓN DE ESTADO DE CUENTA :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('5.1. A la suscripción del presente contrato se hará entrega a “EL CONTRATISTA” la cantidad del 50% del servicio, el mismo que servirá para la compra de los productos de importación y garantizar el absoluto cumplimiento de todas y cada una de las obligaciones asumidas en virtud del presente contrato.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('El otro 50% del servicio se realizará con:'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('* ENTREGA DE LA PROTESIS CON EL PRE ENCAJE.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Ya que con el PRE ENCAJE, inicia su adaptabilidad y la reducción del muñón, esto puede tomar como mínimo de 7 a 15 días y puede variar como indique el especialista, dando paso a la realización del socket de fibra de carbono para dar terminado el servicio de diseño.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('De mutuo acuerdo El pago se realizará, sin necesidad de requerimiento alguno, por transferencia bancaria o en efectivo como indique el administrador a cargo, el cual adjuntará con el pago, un recibo detallado con los pagos realizados y por realizar.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 6°.- OBLIGACIONES DEL PAGO DE IMPUESTOS POR IMPORTACION :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('6.1. Será de cuenta del  "EL CONTRATISTA" el pago de cualquier otro impuesto creado o por crearse que afecte  el SERVICIO  en forma exclusiva.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 7°.- DE LOS HECHOS FORTUITOS  :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('7.1. "EL CONTRATANTE" no podrá  manipular la prótesis  sin autorización expresa y por escrito de "EL CONTRATISTA", sea cual fuera su necesidad o naturaleza, quedarán bajo responsabilidad del CONTRATANTE y no tendrá derecho a percibir suma ni indemnización de "EL CONTRATISTA" , y además si esto afectará de manera  funcional a la prótesis, EL CONTRATANTE INDEMNIZARA SU ARREGLO Y REPOSICION SI LO REQUIERA;  ya que este deberá  conservar la integridad del servicio prestado.'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 8°.- OBLIGACIÓN DE CONSERVACIÓN DEL BIEN  :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('8.1. "EL LOCADOR" se compromete a tomar en cuenta los usos y cuidados de PROTESIS DE ' . mb_strtoupper($datos['SUB_TRAB']) . ' materia del presente contrato y mantener en perfectas condiciones, de acuerdo a las recomendaciones dadas por el contratista.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 9°.- LIBERACIÓN DE RESPONSABILIDAD  :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('9.1. Se deja expresamente establecido que el pago por cualquier situación externa que se genere por el mal uso de PROTESIS ' . mb_strtoupper($datos['SUB_TRAB']) . ' por parte de "EL CONTRATANTE", o cualquier otra que se genere por causal distinta, serán asumidos por EL CONTRATANTE”, debiendo éste asumir las previsiones necesarias.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('9.2. Asimismo, "EL CONTRATISTA" queda liberado de toda responsabilidad por deficiencia, o patología propia del de EL CONTRATANTE que afecte el funcionamiento de la PROTESIS, y cualquier otro INCIDENTE que suceda durante el servicio de su elaboración, corre por cuenta u obligación de “EL CONTRATANTE”.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 10°.- PENALIDAD  :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('10.1. Habiendo realizado el pago del primer 50% inicial y realizado el avance del Prencaje y lista para su entrega, y vencido el plazo del pago del 50% restante, no realizado dentro de los 3 meses de generado el contrato, EL CONTRATISTA da por ANULADO el contrato.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('10.2. Además el contrato también quedará resuelto si se encuentra dentro de una de las causales establecidas en el Artículo 1697° del Código Civil o de alguna de las cláusulas del presente contrato.'), 0);
        $pdf->Ln(25);



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

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {
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
        }


        $pdfFileName = 'Contrato.pdf'; // Nombre del archivo PDF
        $pdf->Output('F', $pdfFileName); // Guardar el PDF en el servidor
        $pdf->Output('I', $pdfFileName);

        die();
    }

    public function PdfContratoServi($id)
    {
        date_default_timezone_set('America/Lima');

        require('include/fpdf_temp.php');

        $datos = $this->model->getDatosCotizacion($id);
        $lista = $this->model->getListaComponentes($id);

        $dia = date('d');
        $mes = date('m');
        $año = date('Y');

        $nombre_mes = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');

        $fecha_hoy = $dia . ' de ' . $nombre_mes[$mes] . ' del ' . $año;

        $mes_actual = (int)$mes;
        $meses_a_sumar = 13;

        // Sumar meses
        $nuevo_mes = $mes_actual + $meses_a_sumar;

        // Ajustar el año si es necesario
        if ($nuevo_mes > 12) {
            $año += floor(($nuevo_mes - 1) / 12);
            $nuevo_mes = ($nuevo_mes - 1) % 12 + 1;
        }

        // Formatear la nueva fecha
        $fecha_resultado = $dia . ' de ' . $nombre_mes[str_pad($nuevo_mes, 2, '0', STR_PAD_LEFT)] . ' del ' . $año;


        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $pdf->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $pdf->SetFont('RubikMedium', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 9, utf8_decode("CONTRATO DE " . mb_strtoupper($datos['SUB_TRAB'], 'UTF-8')), 0, 1, 'C', true);
        $pdf->Ln(8);

        $html = $datos['SEDE'] . ', ' . $fecha_hoy . ', que celebran, de una parte, KYP BIO INGENIERIA con RUC 20600880081 a quien en adelante se le denominará "EL CONTRATISTA" y de otra parte ' . mb_strtoupper($datos['NOMBRES']) . ' con DNI ' . $datos['DNI'] . ', a quien en adelante se le denominará "EL CONTRATANTE". Para referirnos a ambos contratantes denominaremos como "LAS PARTES". Para referirnos al SERVICIO materia de DESARROLLO Y/ O REALIZACION se le denominará como SERVICIO DE PROTESIS DE ' . mb_strtoupper($datos['SUB_TRAB'], 'UTF-8') . '. Acordamos sin ningún vicio que altere nuestra real voluntad expresando las siguientes cláusulas contractuales: ';

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode($html), 0);
        $pdf->Ln(5);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 1°.- LEGITIMIDAD QUE ACREDITA EL DERECHO PARA LA REALIZACION DEL SERVICIO DE PROTESIS :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('1.1. "EL CONTRATISTA" tiene derecho y legitimidad para realizar el servicio de prótesis de acuerdo a la necesidad del locador (cliente) en mérito a la calidad de servicio y profesionalismo de DISEÑO DE PROTESIS BIOMECANICAS FUNCIONALES Y ESTETICAS.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 2°.- IDENTIFICACIÓN, INDIVIDUALIZACIÓN Y REFERENCIA PRECISA DE UBICACIÓN DEL SERVICIO COMERCIAL :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('2.1. El CONTRATISTA se encuentra, prestando servicio con las formalidades de ley, permisos y autorizaciones que requiere para la realización de la actividad y/o servicio que presta.  ubicado en CALLE MAX PALMA ARRUE MZ A LT 35, distrito de LOS OLIVOS provincia de LIMA , departamento de LOS OLIVOS.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('2.2. El presente servicio DE PROTESIS se identifica por las siguientes características: '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->Cell(0, 7, utf8_decode('    ' . $datos['CANTIDAD'] . ' ' . $datos['SUB_TRAB']));
        $pdf->Ln(8);

        foreach ($lista as $row) {
            $pdf->SetFont('RubikRegular', '', 11);
            $pdf->Cell(0, 7, utf8_decode('    -   ' . $row['LISTA']));
            $pdf->Ln(6);
        }
        $pdf->Ln(5);

        if (!empty($datos['OBSERVACION'])) {
            $pdf->SetFont('RubikMedium', '', 11);
            $pdf->Cell(0, 7, utf8_decode('    Observaciones:'));
            $pdf->Ln(8);
            $pdf->SetFont('RubikRegular', '', 11);
            $pdf->MultiCell(0, 7, utf8_decode('    ' . $datos['OBSERVACION']), 0);
            $pdf->Ln(5);
        }

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('2.3. El servicio  DE PROTESIS   cuenta con las siguientes garantías: '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('1 año de Garantía que brinda KYP BIO INGENIERIA a toda la prótesis (INCLUIDA PIEZAS).'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('LAS PROPIAS PIEZAS PODRIAN TENER UNA GARANTIA MAS LARGA, consultar en Front desk.'), 0);
        $pdf->Ln(8);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('2.4. "EL CONTRATANTE" declara bajo juramento que conoce perfectamente la individualización e identificación del SERVICIO REQUERIDO por lo que renuncia expresamente a cualquier argumento sobre la falta de especificación. '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 3°.- OBJETO, DESTINO Y PROTECCIÓN DEL LOCAL COMERCIAL :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('3.1. Por el presente contrato "EL CONTRATISTA" realizara el servicio de acuerdo a las características de acuerdo a lo mencionado en la cláusula precedente, haciendo entrega del SERVICIO PRESTADO en la fecha de estipulado en el presente contrato. "EL CONTRATANTE" a su vez podrá hacer las observaciones en el plazo que el servicio tenga vigente la garantía en lo que respecta su situación como usuario. '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('3.2 La CONFORMIDAD por el diseño del encaje es de manera automática al adquirir el SERVICIO DE DISEÑO DE PROTESIS, a cargo por un equipo PROFESIONAL parte del equipo de el CONTRATISTA, habiéndole informado de manera clara todo el proceso al CONTRATANTE. '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 4°.- PLAZO DEL CONTRATO :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('4.1. El plazo de contrato será de UN AÑO, el mismo que comenzará a regir desde el ' . $fecha_hoy . ' hasta el ' . $fecha_resultado . ' (13 MESES).'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 5°.- MERCED CONDUCTIVA, FORMA DE PAGO Y PETICIÓN DE ESTADO DE CUENTA :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('5.1. A la suscripción del presente contrato se hará entrega a “EL CONTRATISTA” la cantidad del 50% del servicio, el mismo que servirá para la compra de los productos de importación y garantizar el absoluto cumplimiento de todas y cada una de las obligaciones asumidas en virtud del presente contrato.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('El otro 50% del servicio se realizará con:'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('* ENTREGA DE LA PROTESIS CON EL PRE ENCAJE.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Ya que con el PRE ENCAJE, inicia su adaptabilidad y la reducción del muñón, esto puede tomar como mínimo de 7 a 15 días y puede variar como indique el especialista, dando paso a la realización del socket de fibra de carbono para dar terminado el servicio de diseño.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('De mutuo acuerdo El pago se realizará, sin necesidad de requerimiento alguno, por transferencia bancaria o en efectivo como indique el administrador a cargo, el cual adjuntará con el pago, un recibo detallado con los pagos realizados y por realizar.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 6°.- OBLIGACIONES DEL PAGO DE IMPUESTOS POR IMPORTACION :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('6.1. Será de cuenta del  "EL CONTRATISTA" el pago de cualquier otro impuesto creado o por crearse que afecte  el SERVICIO  en forma exclusiva.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 7°.- DE LOS HECHOS FORTUITOS  :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('7.1. "EL CONTRATANTE" no podrá  manipular la prótesis  sin autorización expresa y por escrito de "EL CONTRATISTA", sea cual fuera su necesidad o naturaleza, quedarán bajo responsabilidad del CONTRATANTE y no tendrá derecho a percibir suma ni indemnización de "EL CONTRATISTA" , y además si esto afectará de manera  funcional a la prótesis, EL CONTRATANTE INDEMNIZARA SU ARREGLO Y REPOSICION SI LO REQUIERA;  ya que este deberá  conservar la integridad del servicio prestado.'), 0);
        $pdf->Ln(10);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 8°.- OBLIGACIÓN DE CONSERVACIÓN DEL BIEN  :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('8.1. "EL LOCADOR" se compromete a tomar en cuenta los usos y cuidados de PROTESIS DE ' . mb_strtoupper($datos['SUB_TRAB']) . ' materia del presente contrato y mantener en perfectas condiciones, de acuerdo a las recomendaciones dadas por el contratista.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 9°.- LIBERACIÓN DE RESPONSABILIDAD  :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('9.1. Se deja expresamente establecido que el pago por cualquier situación externa que se genere por el mal uso de PROTESIS ' . mb_strtoupper($datos['SUB_TRAB']) . ' por parte de "EL CONTRATANTE", o cualquier otra que se genere por causal distinta, serán asumidos por EL CONTRATANTE”, debiendo éste asumir las previsiones necesarias.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('9.2. Asimismo, "EL CONTRATISTA" queda liberado de toda responsabilidad por deficiencia, o patología propia del de EL CONTRATANTE que afecte el funcionamiento de la PROTESIS, y cualquier otro INCIDENTE que suceda durante el servicio de su elaboración, corre por cuenta u obligación de “EL CONTRATANTE”.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikMedium', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CLÁUSULA 10°.- PENALIDAD  :'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('10.1. Habiendo realizado el pago del primer 50% inicial y realizado el avance del Prencaje y lista para su entrega, y vencido el plazo del pago del 50% restante, no realizado dentro de los 3 meses de generado el contrato, EL CONTRATISTA da por ANULADO el contrato.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('RubikRegular', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('10.2. Además el contrato también quedará resuelto si se encuentra dentro de una de las causales establecidas en el Artículo 1697° del Código Civil o de alguna de las cláusulas del presente contrato.'), 0);
        $pdf->Ln(25);



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

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {
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
        }


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
            if ($data[$i]['ESTADO'] == 1) {
                $data[$i]['ESTADO'] = '
                    <span class="badge badge-center rounded-pill bg-label-success">
                        <i class="mdi mdi-check"></i>
                    </span>
                ';
            } else {
                $data[$i]['ESTADO'] = '
                    <span class="badge rounded-pill bg-label-danger">
                        Deuda
                    </span>
                ';
            }
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
                        <button type="button" class="dropdown-item" onclick="VisualizarContrato(' . $data[$i]['ID'] . ')">
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

    public function EliminarPago($id)
    {
        $data = $this->model->EliminarPago($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Pago Eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Pago Eliminada');
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
            if ($datos['TIP_TRAB'] == 'Miembro Inferior' || $datos['TIP_TRAB'] == 'Miembros Inferiores de Encaje' || $datos['TIP_TRAB'] == 'Órtosis') {
                $mail->addAddress('produccion@kypbioingenieria.com');
            } else if ($datos['TIP_TRAB'] == 'Estética') {
                $mail->addAddress('martin.es@kypbioingenieria.com');
            } else if ($datos['TIP_TRAB' == 'Miembro Superior']) {
                $mail->addAddress('subgerencia@kypbioingenieria.com');
            }


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
