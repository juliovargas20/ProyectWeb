<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Luecano\NumeroALetras\NumeroALetras;

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


        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->SetLeftMargin(25.4);
        $pdf->SetRightMargin(25.4);
        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(0, 9, utf8_decode("CONTRATO DE SERVICIOS"), 0, 1, 'C');
        $pdf->Ln(4);

        $html = 'Conste por el presente documento, el Contrato de Locación de Servicios que celebran de una parte parte KYP BIO INGEN SAC con RUC. N° 206000880081 domiciliado en la Calle Max palma Arrué N° 1117 distrito de Los Olivos - Lima - Lima, representado por su Gerente General Sr. PERCY GIOVANY MAGUIÑA VARGAS, identificado con DNI N° 45077305 según poder inscrito en el Asiento N° A0001 de la Partida Electrónica N° 13526119 del Registro de Personas Jurídicas de la Oficina Registral de Lima, a quien en adelante se denominará "KYP BIO INGEN SAC", y de la otra parte ' . mb_strtoupper($datos['NOMBRES']) . ' identificado con DNI N° ' . $datos['DNI'] . ' con domicilio en ' . mb_strtoupper($datos['DIRECCION']) . ', a quien en adelante se le denominará "EL CLIENTE" y en conjunto con KYP BIO se les denominará "Las Partes", en los términos y condiciones siguientes: ';

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode($html), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('PRIMERA: DE LAS PARTES'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC es una persona jurídica de derecho privado constituida como Sociedad de Anónima Cerrada y bajo el régimen MYPE (MICROEMPRESA), cuyo objeto social es la elaboración y comercialización de prótesis para personas con discapacidad, el cual cumple con las formalidades de Ley, permisos y autorizaciones que se requiere para la realización de la actividad y/o servicio que presta.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE es una persona natural que requiere se le brinde el servicio de elaboración de una prótesis por discapacidad.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('SEGUNDA: OBJETO'), 0);
        $pdf->Ln(2);

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Por el presente documento, KYP BIO INGEN SAC se obliga frente a EL CLIENTE a la elaboración de una prótesis biomecánica funcional de acuerdo a las especificaciones y plazos anotadas en la hoja de requerimiento. el cual constituye parte integrante del presente contrato.'), 0);
            $pdf->Ln(5);
        } else if ($datos['TIP_TRAB'] == 'Estética') {

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Por el presente documento, KYP BIO INGEN SAC se obliga frente a EL CLIENTE a la elaboración de una prótesis estética semi realista al 85% de acuerdo a las especificaciones y plazos anotadas en la hoja de requerimiento. el cual constituye parte integrante del presente contrato.'), 0);
            $pdf->Ln(5);
        } else if ($datos['TIP_TRAB'] == 'Miembro Superior') {

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Por el presente documento, KYP BIO INGEN SAC se obliga frente a EL CLIENTE a la elaboración de una prótesis biomecánica funcional de acuerdo a las especificaciones y plazos anotadas en la hoja de requerimiento. el cual constituye parte integrante del presente contrato.'), 0);
            $pdf->Ln(5);
        }

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('TERCERA: DE LA NATURALEZA DEL CONTRATO '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Se deja expresa constancia que todo lo no previsto en el presente Contrato se aplicarán las disposiciones contenidas en el Código Civil, pues, conforme se aprecia de las condiciones del servicio, el presente contrato tiene naturaleza civil, según lo dispuesto en los artículos 1764° y 1769° del Código Civil peruano, por lo que éste no implica ningún tipo de subordinación ni dependencia laboral alguna de KYP BIO INGEN SAC con EL CLIENTE.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CUARTA: PRESTACIÓN INDEPENDIENTE Y AUTONOMA DE LOS SERVICIOS '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Para los efectos de la ejecución del presente contrato, KYP BIO INGEN SAC prestará sus servicios profesionales en la forma, fecha, tiempo y demás condiciones acordadas previamente con EL CLIENTE, con sus propios recursos. En tal sentido, KYP BIO INGEN SAC tiene plena libertad en el ejercicio de sus servicios.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Se deja establecido que, por la naturaleza del servicio que se contrata, no estará sujeto a jornada u horario alguno ni a supervisión o fiscalización de ninguna índole.'), 0);
        $pdf->Ln(5);

        $formatter = new NumeroALetras();
        $texto = $formatter->toMoney($datos['MONTO'], 2, 'SOLES', 'CENTIMOS');

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('QUINTA: RETRIBUCION ECONOMICA'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Las Partes acuerdan que la retribución que pagará EL CLIENTE a KYP BIO INGEN SAC como contraprestación por los servicios prestados asciende a S/.' . $datos['MONTO'] . ' (' . mb_strtoupper($texto) . ') mas IGV, el cual será cancelado de la siguiente manera:'), 0);
        $pdf->Ln(2);

        $pdf->Cell(0, 7, utf8_decode('     -    El 50% del monto (más IGV) a la firma del presente contrato.'), 0, 1);

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {

            $pdf->Cell(0, 7, utf8_decode('     -    El 50% del monto (más IGV) a la entrega de la prótesis con el pre encaje.'), 0);
            $pdf->Ln(8);
        } else if ($datos['TIP_TRAB'] == 'Estética') {

            $pdf->MultiCell(0, 5.5, utf8_decode('    -     El 50% del monto (más IGV) a la entrega de la prótesis pigmentada con el                            recubrimiento de protección de silicona.'), 0);
            $pdf->Ln(8);
        } else if ($datos['TIP_TRAB'] == 'Miembro Superior') {

            $pdf->Cell(0, 7, utf8_decode('     -	    El 50% del monto (más IGV) a la entrega de la prótesis final.'), 0);
            $pdf->Ln(8);
        }


        $pdf->MultiCell(0, 5.5, utf8_decode('Para el pago de la retribución económica, KYP BIO INGEN SAC entregará a EL CLIENTE el respectivo comprobante de pago. En caso se produzca retraso injustificado en el recojo y/o pago de la prótesis por más de 15 días por parte de EL CLIENTE, KYP BIO INGEN SAC tendrá derecho a la no devolución del monto adelantado como penalidad y a exigir el pago de los intereses moratorios, que se devengarán desde la fecha en que se produzca el incumplimiento injustificado del pago.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('SEXTA: DE LAS OBLIGACIONES DE LAS PARTES '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC, en virtud al presente Contrato, se obliga a: '), 0);
        $pdf->Ln(2);

        $pdf->Cell(0, 7, utf8_decode('     -    Realizar las asesorías requeridas por EL CLIENTE.'), 0, 1);
        $pdf->MultiCell(0, 5.5, utf8_decode('     -    Proporcionar los informes que sean requeridos por EL CLIENTE respecto al servicio            materia del presente Contrato. '), 0);
        $pdf->Cell(0, 7, utf8_decode('     -    Cumplir con los plazos estipulados en la hoja de requerimiento.'), 0, 1);
        $pdf->MultiCell(0, 5.5, utf8_decode('     -    Otras que le sean solicitadas por EL CLIENTE en el marco del objeto del presente               contrato. '), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE, en virtud al presente Contrato, se obliga a: '), 0);
        $pdf->Ln(2);

        $pdf->Cell(0, 7, utf8_decode('     -    Asumir el pago de la retribución económica según lo estipulado en el presente contrato.'), 0, 1);
        $pdf->MultiCell(0, 5.5, utf8_decode('     -    Apersonarse a las instalaciones de KYP BIO INGEN SAC cada vez que esta lo                    requiera para la elaboración de la prótesis.'), 0);
        $pdf->Cell(0, 7, utf8_decode('     -    Otras obligaciones que pudiesen emanar de las estipulaciones del presente contrato.'), 0, 1);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('SETIMA: PLAZO '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('El presente Contrato tendrá un plazo de duración de acuerdo a lo pactado en la hoja de requerimiento suscrito por las partes, salvo KYP BIO INGEN SAC comunique a EL CLIENTE, de manera justificada, la necesidad de un mayor plazo.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('OCTAVA: RESERVA, CONFIDENCIALIDAD Y PROPIEDAD INTELECTUAL '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE se compromete y obliga a no usar en su propio provecho ni divulgar directa o indirectamente a ninguna persona, empresa o entidad de cualquier índole, la información proporcionada por KYP BIO INGEN SAC para la prestación del servicio a su cargo.'), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE se compromete y obliga a no reproducir, entregar o permitir que se entregue o que se acceda y/o use información a que se refiere el numeral precedente, salvo que exista autorización previa y por escrito del KYP BIO INGEN SAC. '), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('La obligación de confidencialidad a que se refiere la presente cláusula tendrá una vigencia de  (1) año calendario contados a partir de la suscripción del presente documento.'), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('La información y/o documentación que se produzca en la ejecución del presente Contrato será de propiedad exclusiva del KYP BIO INGEN SAC, encontrándose incluida dentro de los alcances de reserva y confidencialidad estipulados en la presente cláusula. '), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE declara que la violación de esta obligación facultará a KYP BIO INGEN SAC a resolver el presente contrato y a exigir judicial o extrajudicialmente una indemnización por los daños y perjuicios. '), 0);
        $pdf->Ln(5);


        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {
            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('NOVENA: GARANTIA'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se compromete a otorgar una garantía por el PRE ENCAJE de hasta 30 días calendarios desde su entrega sólo en caso de adaptabilidad y reducción del muñón; siendo que posterior a dicho plazo se dará paso a la elaboración del socket de fibra de carbono para dar por finalizado el servicio contratado.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('La no comunicación expresa de EL CLIENTE a KYP BIO respecto al pre encaje conforme a la causal y plazo estipulado en el párrafo anterior implicará la renuncia a cualquier reclamo por parte de EL CLIENTE y su conformidad respecto al mismo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Asimismo, al momento de tener el socket en fibra de carbono final si necesita cambios o uno nuevo deberé asumir el costo de este tanto como de un nuevo linner si fuera necesario.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC otorgará el servicio de mantenimiento de hasta un (01) año respecto a la prótesis materia de contrato siempre y cuando la misma no haya sufrido ningún daño estructural que permita su normal funcionamiento por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA: RESOLUCIÓN DEL CONTRATO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se encuentra facultado a resolver el presente Contrato, durante la vigencia del mismo, bastando para ello que curse una comunicación simple con cinco (05) días de anticipación a la fecha en que solicita opere la resolución, en caso se dé el incumplimiento a las obligaciones estipuladas en el presente Contrato y/o en la hoja de requerimiento del servicio por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA PRIMERA: NOTIFICACION EN DOMICILIO Y/O CORREO ELECTRÓNICO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Para la validez de todas las comunicaciones y notificaciones entre las partes, con motivo de la ejecución de este contrato, estas se realizarán a través de sus domicilios y/o correos electrónicos, señalados en la introducción de este documento. La variación de domicilio de cualquiera de las partes surtirá efecto desde la fecha de comunicación de dicho cambio a la otra parte, por cualquier medio escrito.'), 0);
            $pdf->Ln(10);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA SEGUNDA: COMPETENCIA Y LEGISLACIÓN'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('LAS PARTES acuerdan que para efectos de cualquier controversia que se genere con motivo de la celebración y/o ejecución de este contrato, serán resueltas de manera definitiva mediante ARBITRAJE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA TERCERA: DISPOSICIONES FINALES'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las partes declaran que el Contrato constituye el acuerdo y entendimiento íntegros a los que han llegado con relación al objeto materia del presente documento y que el Contrato sustituye todas las negociaciones y todos los acuerdos que hubieran sido celebrados previamente. '), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier modificación o ampliación de los términos del presente Contrato deberá realizarse por escrito y con participación de las partes. '), 0);
            $pdf->Ln(5);

            $pdf->MultiCell(0, 5.5, utf8_decode('En señal de conformidad, las partes suscriben el presente documento en dos (2) ejemplares originales en los mismos términos y con la misma validez, en la ciudad de ' . $datos['SEDE'] . ' el ' . $fecha_hoy . '.'), 0);
        } else if ($datos['TIP_TRAB'] == 'Estética') {
            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('NOVENA: PROCESO DE ELABORACIÓN, CARACTERISTICAS, APROBACION, MULTAS, INTERVENCIONES QUIRUJICAS, PUNTUALIDAD Y MANTENIMIENTO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Proceso de Elaboración:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La elaboración de la prótesis ' . $datos['SUB_TRAB'] . ' abarca un periodo de 45 a 55 días hábiles, distribuidos en 4 fases:'), 0);
            $pdf->Ln(2);

            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('i.     Fase I: Toma del molde y medidas.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('ii.    Fase II: Escultura y posible modificación según el gusto del paciente.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iii.   Fase III: Vaciado en silicona con color base.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iv.   Fase IV: Pintado y entrega de la prótesis con el paciente en vivo.'), 0, 1);
            $pdf->Ln(5);

            $pdf->MultiCell(0, 5.5, utf8_decode('Se recuerda al paciente que las prótesis tienen un propósito netamente estético y de exhibición, sugiriendo evitar cargar objetos o someterlas a pruebas extremas.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Características de las Prótesis:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las prótesis presentan un 80% de realismo en cuanto al color y un 95% en el modelado escultórico.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se recomienda que el paciente mantenga una tonalidad pareja para lograr un resultado más realista y armonioso con otras partes del cuerpo.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Aprobación en Fase II y Multas: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Una vez aprobada la FASE II (escultura), no se admiten modificaciones en la FASE IV, y realizar cambios conlleva una multa.'), 0);
            $pdf->Ln(2);

            if ($datos['SUB_TRAB'] == "Microtia Tipo 1 y 2" || $datos['SUB_TRAB'] == "Microtia Tipo 3 y 4") {
                $pdf->MultiCell(0, 5.5, utf8_decode('En caso de microtias, se deja una membrana para mayor adhesión, pero su reducción corre por cuenta del paciente, eximiendo a la empresa de responsabilidad por pérdida de firmeza.'), 0);
                $pdf->Ln(5);
            }

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Intervenciones Quirúrgicas y Puntualidad: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El paciente debe informar cualquier intervención quirúrgica durante la elaboración, evitando multas y retrasos.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('A partir de la FASE IV, la empresa no asume responsabilidad por variaciones en medidas no informadas previamente.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se insta a la puntualidad, y en caso de retraso, se avanzará en la elaboración para evitar perjuicios a otros pacientes. Se recomienda a los pacientes de provincia llegar con anticipación.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Cuidados y Mantenimiento: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se aconseja aplicar talco en el muñón según sea necesario para facilitar el deslizamiento de la prótesis.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('La extracción debe hacerse con cuidado, evitando fuerza excesiva para prevenir roturas irreparables.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se detallan condiciones de resistencia y debilidades del material de la prótesis, indicando precauciones para su uso adecuado.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Reparaciones y Consideraciones Finales: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier corte en la prótesis debe ser atendido en las instalaciones de la empresa para evitar riesgos. Se desaconseja la reparación por cuenta propia.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se proporcionan recomendaciones específicas, como evitar la inmersión en sales marinas, cargar objetos pesados o realizar flexiones bruscas.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se alerta sobre la posibilidad de alteraciones estéticas en caso de reparaciones.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA: GARANTIA'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La no comunicación expresa de EL CLIENTE a KYP BIO INGEN SAC respecto a la escultura y modificación conforme a la causal y plazo estipulado en el párrafo anterior implicará la renuncia a cualquier reclamo por parte de EL CLIENTE y su conformidad respecto al mismo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC otorgará el servicio de mantenimiento de hasta un (01) año respecto a la protesis materia de contrato siempre y cuando la misma no haya sufrido ningún daño estructural que permita su normal pigmentación por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('ONCEAVA: RESOLUCIÓN DEL CONTRATO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se encuentra facultado a resolver el presente Contrato, durante la vigencia del mismo, bastando para ello que curse una comunicación simple con cinco (05) días de anticipación a la fecha en que solicita opere la resolución, en caso se dé el incumplimiento a las obligaciones estipuladas en el presente Contrato y/o en la hoja de requerimiento del servicio por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('ONCEAVA PRIMERA: NOTIFICACION EN DOMICILIO Y/O CORREO ELECTRONICO  '), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Para la validez de todas las comunicaciones y notificaciones entre las partes, con motivo de la ejecución de este contrato, estas se realizarán a través de sus domicilios y/o correos electrónicos, señalados en la introducción de este documento. La variación de domicilio de cualquiera de las partes surtirá efecto desde la fecha de comunicación de dicho cambio a la otra parte, por cualquier medio escrito.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('ONCEAVA SEGUNDA: COMPETENCIA Y LEGISLACIÓN'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('LAS PARTES acuerdan que para efectos de cualquier controversia que se genere con motivo de la celebración y/o ejecución de este contrato, serán resueltas de manera definitiva mediante ARBITRAJE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('ONCEAVA TERCERA: DISPOSICIONES FINALES'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las partes declaran que el Contrato constituye el acuerdo y entendimiento íntegros a los que han llegado con relación al objeto materia del presente documento y que el Contrato sustituye todas las negociaciones y todos los acuerdos que hubieran sido celebrados previamente. '), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier modificación o ampliación de los términos del presente Contrato deberá realizarse por escrito y con participación de las partes.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('En señal de conformidad, las partes suscriben el presente documento en dos (2) ejemplares originales en los mismos términos y con la misma validez, en la ciudad de ' . $datos['SEDE'] . ' el ' . $fecha_hoy . '.'), 0);
            $pdf->Ln(2);
        } else if ($datos['SUB_TRAB'] == 'Mano Parcial Biónica' || $datos['SUB_TRAB'] == 'Mano Completa Biónica') {

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('NOVENA: PROCESO DE ELABORACIÓN, CARACTERISTICAS, INTERVENCIONES QUIRUJICAS, PROGRAMACIÓN DE CITAS, USOS Y CUIDADOS'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Proceso de Elaboración:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La elaboración de la prótesis abarca un periodo de 30 a 40 días hábiles, distribuidos en 5 fases:'), 0);
            $pdf->Ln(2);

            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('i.     Fase I: Toma de medidas y escaneo 3D.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('ii.    Fase II: Pruebas de encaje del socket.'), 0, 1);
            $pdf->SetX(40);
            $pdf->MultiCell(0, 5.5, utf8_decode('iii.   Fase III: Pruebas con el prototipo de la prótesis y adecuación de las señales            mioeléctricas.'), 0);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iv.   Fase IV: Modificaciones y ensamble de la prótesis final.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('v.    Fase V: Entrega de la prótesis final con sus accesorios.'), 0, 1);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Características de las Prótesis:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La prótesis electrónica ofrece la capacidad de realizar diversas actividades cotidianas con facilidad, desde sujetar objetos como vasos, tazas, hasta manipular bolígrafos y teléfonos celulares. La efectividad en estas tareas puede variar en función del nivel de destreza y habilidad individual del paciente.'), 0);
            $pdf->Ln(5);


            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Intervenciones Quirúrgicas y Puntualidad: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El paciente no debe realizarse ninguna intervención quirúrgica durante la elaboración de la prótesis para evitar retrasos y variaciones en el diseño del encaje.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('A partir de la FASE III, la empresa no asume responsabilidad por variaciones en medidas del muñón no informadas previamente.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Programación de Citas: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La asistencia puntual a todas las citas programadas con el especialista es de vital importancia durante las diversas fases del desarrollo hasta la entrega final de la prótesis. La falta de asistencia a estas citas puede ocasionar retrasos considerables en la entrega del producto final. Se informa al paciente que la ausencia continua y no justificada a dichas citas podría resultar en la terminación unilateral del contrato por parte del proveedor, sin derecho a reclamos o reembolsos de los pagos efectuados hasta la fecha de rescisión.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Usos y cuidados: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El uso de la prótesis se limita a actividades cotidianas que incluyen sujetar vasos, tazas, bolígrafos, teléfonos celulares y objetos similares. Queda expresamente prohibido exponer la prótesis a temperaturas superiores a 50 °C, así como participar en actividades extremas con su uso. Se advierte al usuario que la capacidad de carga de la prótesis está limitada a objetos de hasta 1.5 kg, evitando cargas superiores para preservar su integridad y funcionamiento óptimo. Se hace constar que cualquier caída o impacto puede ocasionar daños irreparables, por lo que se recomienda precaución para evitar estos incidentes. Adicionalmente, se insta al usuario a evitar el contacto con agua, polvo excesivo y sustancias químicas, ya que podrían comprometer la integridad y durabilidad de la prótesis.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA: GARANTIA'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El CLIENTE debe llevar la prótesis para su mantenimiento cada 4 meses a partir de la entrega de la prótesis final, según las fechas indicadas en la ficha de garantía. Si no se cumplen estos plazos de mantenimiento, la garantía quedará anulada y no se podrá realizar ningún reclamo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('En caso de que se presente alguna falla en algún componente de la prótesis KYP BIO INGEN SAC, nos comprometemos a evaluar dicho componente defectuoso para determinar el origen del problema. Si la falla se debe a defectos de fabricación, procederemos a reemplazarlo por uno nuevo. Sin embargo, no nos haremos responsables por fallas debido a un uso inadecuado o falta de cuidado de la prótesis. En esos casos, se requerirá el pago del componente dañado para realizar el reemplazo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC otorgará el servicio de mantenimiento de hasta un (01) año respecto a la prótesis materia de contrato siempre y cuando la misma no haya sufrido ningún daño estructural que permita su normal funcionamiento por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA PRIMERA: RESOLUCIÓN DEL CONTRATO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se encuentra facultado a resolver el presente Contrato, durante la vigencia del mismo, bastando para ello que curse una comunicación simple con cinco (05) días de anticipación a la fecha en que solicita opere la resolución, en caso se dé el incumplimiento a las obligaciones estipuladas en el presente Contrato y/o en la hoja de requerimiento del servicio por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA SEGUNDA: NOTIFICACION EN DOMICILIO Y/O CORREO ELECTRONICO '), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Para la validez de todas las comunicaciones y notificaciones entre las partes, con motivo de la ejecución de este contrato, estas se realizarán a través de sus domicilios y/o correos electrónicos, señalados en la introducción de este documento. La variación de domicilio de cualquiera de las partes surtirá efecto desde la fecha de comunicación de dicho cambio a la otra parte, por cualquier medio escrito.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA TERCERA: COMPETENCIA Y LEGISLACIÓN'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('LAS PARTES acuerdan que para efectos de cualquier controversia que se genere con motivo de la celebración y/o ejecución de este contrato, serán resueltas de manera definitiva mediante ARBITRAJE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA CUARTA: DISPOSICIONES FINALES'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las partes declaran que el Contrato constituye el acuerdo y entendimiento íntegros a los que han llegado con relación al objeto materia del presente documento y que el Contrato sustituye todas las negociaciones y todos los acuerdos que hubieran sido celebrados previamente. '), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier modificación o ampliación de los términos del presente Contrato deberá realizarse por escrito y con participación de las partes.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('En señal de conformidad, las partes suscriben el presente documento en dos (2) ejemplares originales en los mismos términos y con la misma validez, en la ciudad de ' . $datos['SEDE'] . ' el ' . $fecha_hoy . '.'), 0);
            $pdf->Ln(2);
        } else if ($datos['SUB_TRAB'] == 'Mano Parcial Mecánica' || $datos['SUB_TRAB'] == 'Mano Parcial de articulación manual' || $datos['SUB_TRAB'] == 'Falange Mecánica' || $datos['SUB_TRAB'] == 'Protesis Transhumeral tipo gancho cosmético (Fillauer)' || $datos['SUB_TRAB'] == 'Protesis transradial tipo gancho cosmético (Fillauer)' || $datos['SUB_TRAB'] == 'Protesis Transhumeral tipo gancho cosmético (Aosuo)' || $datos['SUB_TRAB'] == 'Protesis transradial mecánica de TPU' || $datos['SUB_TRAB'] == '') {

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('NOVENA: PROCESO DE ELABORACIÓN, CARACTERISTICAS, INTERVENCIONES QUIRUJICAS, PROGRAMACIÓN DE CITAS, USOS Y CUIDADOS'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Proceso de Elaboración:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La elaboración de la prótesis abarca un periodo de 30 a 40 días hábiles, distribuidos en 5 fases:'), 0);
            $pdf->Ln(2);

            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('i.     Fase I: Toma de medidas y escaneo 3D.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('ii.    Fase II: Pruebas de encaje del socket.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iii.   Fase III: Pruebas con el prototipo de la prótesis.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iv.   Fase IV: Modificaciones y ensamble de la prótesis final.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('v.    Fase V: Entrega de la prótesis final con sus accesorios.'), 0, 1);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Características de las Prótesis:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las prótesis accionadas por el cuerpo ofrecen la capacidad de realizar diversas actividades cotidianas con facilidad, desde sujetar objetos como vasos, tazas, hasta manipular bolígrafos y teléfonos celulares. La efectividad en estas tareas puede variar en función del nivel de destreza y habilidad individual del paciente.'), 0);
            $pdf->Ln(5);


            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Intervenciones Quirúrgicas y Puntualidad: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El paciente no debe realizarse ninguna intervención quirúrgica durante la elaboración de la prótesis para evitar retrasos y variaciones en el diseño del encaje.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('A partir de la FASE III, la empresa no asume responsabilidad por variaciones en medidas del muñón no informadas previamente.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Programación de Citas: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La asistencia puntual a todas las citas programadas con el especialista es de vital importancia durante las diversas fases del desarrollo hasta la entrega final de la prótesis. La falta de asistencia a estas citas puede ocasionar retrasos considerables en la entrega del producto final. Se informa al paciente que la ausencia continua y no justificada a dichas citas podría resultar en la terminación unilateral del contrato por parte del proveedor, sin derecho a reclamos o reembolsos de los pagos efectuados hasta la fecha de rescisión.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Usos y cuidados: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El uso de la prótesis se limita a actividades cotidianas que incluyen sujetar vasos, tazas, bolígrafos, teléfonos celulares y objetos similares. Queda expresamente prohibido exponer la prótesis a temperaturas superiores a 50 °C. Se advierte al usuario que la capacidad de carga de la prótesis está limitada a objetos de hasta 1.5 kg, evitando cargas superiores para preservar su integridad y funcionamiento óptimo. Soporta caídas de hasta de 1.5 metros. Adicionalmente, se insta al usuario a evitar el contacto con sustancias químicas, ya que podrían comprometer la integridad y durabilidad de la prótesis.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA: GARANTIA'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('En caso de que se presente alguna falla en algún componente de la prótesis KYP BIO INGEN SAC, nos comprometemos a evaluar dicho componente defectuoso para determinar el origen del problema. Si la falla se debe a defectos de fabricación, procederemos a reemplazarlo por uno nuevo. Sin embargo, no nos haremos responsables por fallas debido a un uso inadecuado o falta de cuidado de la prótesis. En esos casos, se requerirá el pago del componente dañado para realizar el reemplazo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC otorgará el servicio de mantenimiento de hasta un (01) año respecto a la prótesis materia de contrato siempre y cuando la misma no haya sufrido ningún daño estructural que permita su normal funcionamiento por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA PRIMERA: RESOLUCIÓN DEL CONTRATO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se encuentra facultado a resolver el presente Contrato, durante la vigencia del mismo, bastando para ello que curse una comunicación simple con cinco (05) días de anticipación a la fecha en que solicita opere la resolución, en caso se dé el incumplimiento a las obligaciones estipuladas en el presente Contrato y/o en la hoja de requerimiento del servicio por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA SEGUNDA: NOTIFICACION EN DOMICILIO Y/O CORREO ELECTRONICO '), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Para la validez de todas las comunicaciones y notificaciones entre las partes, con motivo de la ejecución de este contrato, estas se realizarán a través de sus domicilios y/o correos electrónicos, señalados en la introducción de este documento. La variación de domicilio de cualquiera de las partes surtirá efecto desde la fecha de comunicación de dicho cambio a la otra parte, por cualquier medio escrito.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA TERCERA: COMPETENCIA Y LEGISLACIÓN'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('LAS PARTES acuerdan que para efectos de cualquier controversia que se genere con motivo de la celebración y/o ejecución de este contrato, serán resueltas de manera definitiva mediante ARBITRAJE.'), 0);
            $pdf->Ln(10);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA CUARTA: DISPOSICIONES FINALES'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las partes declaran que el Contrato constituye el acuerdo y entendimiento íntegros a los que han llegado con relación al objeto materia del presente documento y que el Contrato sustituye todas las negociaciones y todos los acuerdos que hubieran sido celebrados previamente. '), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier modificación o ampliación de los términos del presente Contrato deberá realizarse por escrito y con participación de las partes.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('En señal de conformidad, las partes suscriben el presente documento en dos (2) ejemplares originales en los mismos términos y con la misma validez, en la ciudad de ' . $datos['SEDE'] . ' el ' . $fecha_hoy . '.'), 0);
            $pdf->Ln(2);
        }

        $pdf->Ln(30);
        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(90, 7, '..............................................', 0, 0, 'C');
        $pdf->Cell(0, 7, '..............................................', 0, 0, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('arial', '', 12);
        $pdf->Cell(90, 7, utf8_decode('KYP BIO INGEN SAC'), 0, 0, 'C');
        $pdf->Cell(0, 7, utf8_decode('EL CLIENTE'), 0, 0, 'C');


        $pdf->AddPage();

        $pdf->SetFont('arial', 'B', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 7, "HOJA DE REQUERIMIENTO", 0, 1, 'L', true);
        $pdf->Ln(8);

        $pdf->SetFont('arial', '', 12);
        $pdf->Cell(0, 7, utf8_decode("N° Paciente: " . $datos['ID_PACIENTE']), 0, 1, 'L', false);
        $pdf->Cell(0, 7, utf8_decode("Nombre del Paciente: " . $datos['NOMBRES']), 0, 1, 'L', false);
        $pdf->Ln(8);

        $pdf->SetFont('arial', 'BI', 12);
        $pdf->Cell(0, 7, utf8_decode("Lista de Componentes Cotizados:"), 0, 1, 'L', false);
        $pdf->Ln(5);

        foreach ($lista as $row) {
            $pdf->SetFont('arial', '', 12);
            $pdf->Cell(0, 7, utf8_decode('    -   ' . $row['LISTA']));
            $pdf->Ln(6);
        }
        $pdf->Ln(8);

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {
            $pdf->AddPage();

            $pdf->SetFont('arial', 'B', 14);
            $pdf->Cell(0, 7, utf8_decode("Consentimiento Informado para Inicio de Protetización"), 0, 1, 'C', false);
            $pdf->Ln(8);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Yo, ' . $datos['NOMBRES'] . ', identificado con DNI ' . $datos['DNI'] . ' en pleno uso de mis facultades mentales y entendiendo plenamente la naturaleza de este consentimiento, otorgo mi consentimiento informado para que el personal profesional capacitado de la empresa KYP BIO INGEN S.A.C realicen el contacto físico necesario durante el tratamiento y cuidado de mi condición de amputación.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Entiendo y acepto que el contacto físico puede ser necesario para realizar una evaluación adecuada, proporcionar tratamiento PROTÉSICO, llevar a cabo procedimientos terapéuticos y mejorar mi bienestar general como persona amputada. Comprendo que el contacto físico puede incluir, pero no se limita a, la inspección visual, la palpación, la movilización de extremidades y la aplicación de dispositivos médicos y ortopédicos.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Además, se me ha proporcionado información detallada sobre los procedimientos específicos que implicarán contacto físico, así como los riesgos y beneficios asociados. Así mismo me explicaron el uso de la media compresiva (LINNER), su limpieza, manera de colocarla y que el material del cual está fabricado es silicona americana hipoalergénica y si podría producir algún tipo de enrojecimiento es por el tipo de piel que el usuario presenta (sensibilidad, alergia u otro factor) y es de mi completa responsabilidad.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Entiendo el hecho de que mi muñón varíe de volumen teniendo en cuenta, el peso, la alimentación, enfermedades de base, etc. que requerirán cambios de socket. Asimismo, al momento de tener el SOCKET EN FIBRA DE CARBONO FINAL si necesita cambios o uno nuevo DEBERÉ ASUMIR EL COSTO DE ESTE TANTO COMO DE UN NUEVO LINNER SI FUERA NECESARIO. He tenido la oportunidad de hacer preguntas y todas ellas han sido respondidas satisfactoriamente.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('También entiendo que tengo el derecho de retirar mi consentimiento en cualquier aspecto de mi tratamiento o cuidado y mi compromiso al asistir puntualmente y con disponibilidad de tiempo a las citas acordadas; de no ser así comunicarme con antelación de mínimo 1 hora para reprogramar dicha cita.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Declaro que este consentimiento ha sido otorgado de manera voluntaria y sin ninguna forma de coerción o presión. Soy plenamente consciente de las implicaciones y consecuencias del contacto físico y autorizo a los profesionales capacitados de la empresa KYP BIO INGEN S.A.C a llevar a cabo dichos procedimientos en mi persona. Además, doy mi consentimiento para que se documente y almacene de manera segura cualquier información relacionada con el contacto físico en mi historial médico.'), 0);
            $pdf->Ln(15);

            $pdf->SetFont('arial', '', 12);
            $pdf->Cell(0, 5, 'Firma del Paciente/Representante Legal');
            $pdf->Ln(4);
            $pdf->Cell(0, 5, 'Fecha:');
        }


        $pdfFileName = 'Contrato.pdf'; // Nombre del archivo PDF
        //$pdf->Output('F', $pdfFileName); // Guardar el PDF en el servidor
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


        $pdf = new PDF($datos['ID_PACIENTE']);

        $pdf->SetLeftMargin(25.4);
        $pdf->SetRightMargin(25.4);
        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(0, 9, utf8_decode("CONTRATO DE SERVICIOS"), 0, 1, 'C');
        $pdf->Ln(4);

        $html = 'Conste por el presente documento, el Contrato de Locación de Servicios que celebran de una parte parte KYP BIO INGEN SAC con RUC. N° 206000880081 domiciliado en la Calle Max palma Arrué N° 1117 distrito de Los Olivos - Lima - Lima, representado por su Gerente General Sr. PERCY GIOVANY MAGUIÑA VARGAS, identificado con DNI N° 45077305 según poder inscrito en el Asiento N° A0001 de la Partida Electrónica N° 13526119 del Registro de Personas Jurídicas de la Oficina Registral de Lima, a quien en adelante se denominará "KYP BIO INGEN SAC", y de la otra parte ' . mb_strtoupper($datos['NOMBRES']) . ' identificado con DNI N° ' . $datos['DNI'] . ' con domicilio en ' . mb_strtoupper($datos['DIRECCION']) . ', a quien en adelante se le denominará "EL CLIENTE" y en conjunto con KYP BIO se les denominará "Las Partes", en los términos y condiciones siguientes: ';

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode($html), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('PRIMERA: DE LAS PARTES'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC es una persona jurídica de derecho privado constituida como Sociedad de Anónima Cerrada y bajo el régimen MYPE (MICROEMPRESA), cuyo objeto social es la elaboración y comercialización de prótesis para personas con discapacidad, el cual cumple con las formalidades de Ley, permisos y autorizaciones que se requiere para la realización de la actividad y/o servicio que presta.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE es una persona natural que requiere se le brinde el servicio de elaboración de una prótesis por discapacidad.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('SEGUNDA: OBJETO'), 0);
        $pdf->Ln(2);

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Por el presente documento, KYP BIO INGEN SAC se obliga frente a EL CLIENTE a la elaboración de una prótesis biomecánica funcional de acuerdo a las especificaciones y plazos anotadas en la hoja de requerimiento. el cual constituye parte integrante del presente contrato.'), 0);
            $pdf->Ln(5);
        } else if ($datos['TIP_TRAB'] == 'Estética') {

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Por el presente documento, KYP BIO INGEN SAC se obliga frente a EL CLIENTE a la elaboración de una prótesis estética semi realista al 85% de acuerdo a las especificaciones y plazos anotadas en la hoja de requerimiento. el cual constituye parte integrante del presente contrato.'), 0);
            $pdf->Ln(5);
        } else if ($datos['TIP_TRAB'] == 'Miembro Superior') {

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Por el presente documento, KYP BIO INGEN SAC se obliga frente a EL CLIENTE a la elaboración de una prótesis biomecánica funcional de acuerdo a las especificaciones y plazos anotadas en la hoja de requerimiento. el cual constituye parte integrante del presente contrato.'), 0);
            $pdf->Ln(5);
        }

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('TERCERA: DE LA NATURALEZA DEL CONTRATO '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Se deja expresa constancia que todo lo no previsto en el presente Contrato se aplicarán las disposiciones contenidas en el Código Civil, pues, conforme se aprecia de las condiciones del servicio, el presente contrato tiene naturaleza civil, según lo dispuesto en los artículos 1764° y 1769° del Código Civil peruano, por lo que éste no implica ningún tipo de subordinación ni dependencia laboral alguna de KYP BIO INGEN SAC con EL CLIENTE.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('CUARTA: PRESTACIÓN INDEPENDIENTE Y AUTONOMA DE LOS SERVICIOS '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Para los efectos de la ejecución del presente contrato, KYP BIO INGEN SAC prestará sus servicios profesionales en la forma, fecha, tiempo y demás condiciones acordadas previamente con EL CLIENTE, con sus propios recursos. En tal sentido, KYP BIO INGEN SAC tiene plena libertad en el ejercicio de sus servicios.'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Se deja establecido que, por la naturaleza del servicio que se contrata, no estará sujeto a jornada u horario alguno ni a supervisión o fiscalización de ninguna índole.'), 0);
        $pdf->Ln(5);

        $formatter = new NumeroALetras();
        $texto = $formatter->toMoney($datos['MONTO'], 2, 'SOLES', 'CENTIMOS');

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('QUINTA: RETRIBUCION ECONOMICA'), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('Las Partes acuerdan que la retribución que pagará EL CLIENTE a KYP BIO INGEN SAC como contraprestación por los servicios prestados asciende a S/.' . $datos['MONTO'] . ' (' . mb_strtoupper($texto) . ') mas IGV, el cual será cancelado de la siguiente manera:'), 0);
        $pdf->Ln(2);

        $pdf->Cell(0, 7, utf8_decode('     -    El 50% del monto (más IGV) a la firma del presente contrato.'), 0, 1);

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {

            $pdf->Cell(0, 7, utf8_decode('     -    El 50% del monto (más IGV) a la entrega de la prótesis con el pre encaje.'), 0);
            $pdf->Ln(8);
        } else if ($datos['TIP_TRAB'] == 'Estética') {

            $pdf->MultiCell(0, 5.5, utf8_decode('    -     El 50% del monto (más IGV) a la entrega de la prótesis pigmentada con el                            recubrimiento de protección de silicona.'), 0);
            $pdf->Ln(8);
        } else if ($datos['TIP_TRAB'] == 'Miembro Superior') {

            $pdf->Cell(0, 7, utf8_decode('     -	    El 50% del monto (más IGV) a la entrega de la prótesis final.'), 0);
            $pdf->Ln(8);
        }


        $pdf->MultiCell(0, 5.5, utf8_decode('Para el pago de la retribución económica, KYP BIO INGEN SAC entregará a EL CLIENTE el respectivo comprobante de pago. En caso se produzca retraso injustificado en el recojo y/o pago de la prótesis por más de 15 días por parte de EL CLIENTE, KYP BIO INGEN SAC tendrá derecho a la no devolución del monto adelantado como penalidad y a exigir el pago de los intereses moratorios, que se devengarán desde la fecha en que se produzca el incumplimiento injustificado del pago.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('SEXTA: DE LAS OBLIGACIONES DE LAS PARTES '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC, en virtud al presente Contrato, se obliga a: '), 0);
        $pdf->Ln(2);

        $pdf->Cell(0, 7, utf8_decode('     -    Realizar las asesorías requeridas por EL CLIENTE.'), 0, 1);
        $pdf->MultiCell(0, 5.5, utf8_decode('     -    Proporcionar los informes que sean requeridos por EL CLIENTE respecto al servicio            materia del presente Contrato. '), 0);
        $pdf->Cell(0, 7, utf8_decode('     -    Cumplir con los plazos estipulados en la hoja de requerimiento.'), 0, 1);
        $pdf->MultiCell(0, 5.5, utf8_decode('     -    Otras que le sean solicitadas por EL CLIENTE en el marco del objeto del presente               contrato. '), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE, en virtud al presente Contrato, se obliga a: '), 0);
        $pdf->Ln(2);

        $pdf->Cell(0, 7, utf8_decode('     -    Asumir el pago de la retribución económica según lo estipulado en el presente contrato.'), 0, 1);
        $pdf->MultiCell(0, 5.5, utf8_decode('     -    Apersonarse a las instalaciones de KYP BIO INGEN SAC cada vez que esta lo                    requiera para la elaboración de la prótesis.'), 0);
        $pdf->Cell(0, 7, utf8_decode('     -    Otras obligaciones que pudiesen emanar de las estipulaciones del presente contrato.'), 0, 1);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('SETIMA: PLAZO '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('El presente Contrato tendrá un plazo de duración de acuerdo a lo pactado en la hoja de requerimiento suscrito por las partes, salvo KYP BIO INGEN SAC comunique a EL CLIENTE, de manera justificada, la necesidad de un mayor plazo.'), 0);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('OCTAVA: RESERVA, CONFIDENCIALIDAD Y PROPIEDAD INTELECTUAL '), 0);
        $pdf->Ln(2);

        $pdf->SetFont('arial', '', 11);
        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE se compromete y obliga a no usar en su propio provecho ni divulgar directa o indirectamente a ninguna persona, empresa o entidad de cualquier índole, la información proporcionada por KYP BIO INGEN SAC para la prestación del servicio a su cargo.'), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE se compromete y obliga a no reproducir, entregar o permitir que se entregue o que se acceda y/o use información a que se refiere el numeral precedente, salvo que exista autorización previa y por escrito del KYP BIO INGEN SAC. '), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('La obligación de confidencialidad a que se refiere la presente cláusula tendrá una vigencia de  (1) año calendario contados a partir de la suscripción del presente documento.'), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('La información y/o documentación que se produzca en la ejecución del presente Contrato será de propiedad exclusiva del KYP BIO INGEN SAC, encontrándose incluida dentro de los alcances de reserva y confidencialidad estipulados en la presente cláusula. '), 0);
        $pdf->Ln(2);

        $pdf->MultiCell(0, 5.5, utf8_decode('EL CLIENTE declara que la violación de esta obligación facultará a KYP BIO INGEN SAC a resolver el presente contrato y a exigir judicial o extrajudicialmente una indemnización por los daños y perjuicios. '), 0);
        $pdf->Ln(5);


        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {
            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('NOVENA: GARANTIA'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se compromete a otorgar una garantía por el PRE ENCAJE de hasta 30 días calendarios desde su entrega sólo en caso de adaptabilidad y reducción del muñón; siendo que posterior a dicho plazo se dará paso a la elaboración del socket de fibra de carbono para dar por finalizado el servicio contratado.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('La no comunicación expresa de EL CLIENTE a KYP BIO respecto al pre encaje conforme a la causal y plazo estipulado en el párrafo anterior implicará la renuncia a cualquier reclamo por parte de EL CLIENTE y su conformidad respecto al mismo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Asimismo, al momento de tener el socket en fibra de carbono final si necesita cambios o uno nuevo deberé asumir el costo de este tanto como de un nuevo linner si fuera necesario.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC otorgará el servicio de mantenimiento de hasta un (01) año respecto a la prótesis materia de contrato siempre y cuando la misma no haya sufrido ningún daño estructural que permita su normal funcionamiento por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA: RESOLUCIÓN DEL CONTRATO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se encuentra facultado a resolver el presente Contrato, durante la vigencia del mismo, bastando para ello que curse una comunicación simple con cinco (05) días de anticipación a la fecha en que solicita opere la resolución, en caso se dé el incumplimiento a las obligaciones estipuladas en el presente Contrato y/o en la hoja de requerimiento del servicio por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA PRIMERA: NOTIFICACION EN DOMICILIO Y/O CORREO ELECTRÓNICO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Para la validez de todas las comunicaciones y notificaciones entre las partes, con motivo de la ejecución de este contrato, estas se realizarán a través de sus domicilios y/o correos electrónicos, señalados en la introducción de este documento. La variación de domicilio de cualquiera de las partes surtirá efecto desde la fecha de comunicación de dicho cambio a la otra parte, por cualquier medio escrito.'), 0);
            $pdf->Ln(10);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA SEGUNDA: COMPETENCIA Y LEGISLACIÓN'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('LAS PARTES acuerdan que para efectos de cualquier controversia que se genere con motivo de la celebración y/o ejecución de este contrato, serán resueltas de manera definitiva mediante ARBITRAJE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA TERCERA: DISPOSICIONES FINALES'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las partes declaran que el Contrato constituye el acuerdo y entendimiento íntegros a los que han llegado con relación al objeto materia del presente documento y que el Contrato sustituye todas las negociaciones y todos los acuerdos que hubieran sido celebrados previamente. '), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier modificación o ampliación de los términos del presente Contrato deberá realizarse por escrito y con participación de las partes. '), 0);
            $pdf->Ln(5);

            $pdf->MultiCell(0, 5.5, utf8_decode('En señal de conformidad, las partes suscriben el presente documento en dos (2) ejemplares originales en los mismos términos y con la misma validez, en la ciudad de ' . $datos['SEDE'] . ' el ' . $fecha_hoy . '.'), 0);
        } else if ($datos['TIP_TRAB'] == 'Estética') {
            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('NOVENA: PROCESO DE ELABORACIÓN, CARACTERISTICAS, APROBACION, MULTAS, INTERVENCIONES QUIRUJICAS, PUNTUALIDAD Y MANTENIMIENTO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Proceso de Elaboración:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La elaboración de la prótesis ' . $datos['SUB_TRAB'] . ' abarca un periodo de 45 a 55 días hábiles, distribuidos en 4 fases:'), 0);
            $pdf->Ln(2);

            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('i.     Fase I: Toma del molde y medidas.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('ii.    Fase II: Escultura y posible modificación según el gusto del paciente.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iii.   Fase III: Vaciado en silicona con color base.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iv.   Fase IV: Pintado y entrega de la prótesis con el paciente en vivo.'), 0, 1);
            $pdf->Ln(5);

            $pdf->MultiCell(0, 5.5, utf8_decode('Se recuerda al paciente que las prótesis tienen un propósito netamente estético y de exhibición, sugiriendo evitar cargar objetos o someterlas a pruebas extremas.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Características de las Prótesis:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las prótesis presentan un 80% de realismo en cuanto al color y un 95% en el modelado escultórico.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se recomienda que el paciente mantenga una tonalidad pareja para lograr un resultado más realista y armonioso con otras partes del cuerpo.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Aprobación en Fase II y Multas: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Una vez aprobada la FASE II (escultura), no se admiten modificaciones en la FASE IV, y realizar cambios conlleva una multa.'), 0);
            $pdf->Ln(2);

            if ($datos['SUB_TRAB'] == "Microtia Tipo 1 y 2" || $datos['SUB_TRAB'] == "Microtia Tipo 3 y 4") {
                $pdf->MultiCell(0, 5.5, utf8_decode('En caso de microtias, se deja una membrana para mayor adhesión, pero su reducción corre por cuenta del paciente, eximiendo a la empresa de responsabilidad por pérdida de firmeza.'), 0);
                $pdf->Ln(5);
            }

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Intervenciones Quirúrgicas y Puntualidad: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El paciente debe informar cualquier intervención quirúrgica durante la elaboración, evitando multas y retrasos.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('A partir de la FASE IV, la empresa no asume responsabilidad por variaciones en medidas no informadas previamente.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se insta a la puntualidad, y en caso de retraso, se avanzará en la elaboración para evitar perjuicios a otros pacientes. Se recomienda a los pacientes de provincia llegar con anticipación.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Cuidados y Mantenimiento: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se aconseja aplicar talco en el muñón según sea necesario para facilitar el deslizamiento de la prótesis.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('La extracción debe hacerse con cuidado, evitando fuerza excesiva para prevenir roturas irreparables.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se detallan condiciones de resistencia y debilidades del material de la prótesis, indicando precauciones para su uso adecuado.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Reparaciones y Consideraciones Finales: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier corte en la prótesis debe ser atendido en las instalaciones de la empresa para evitar riesgos. Se desaconseja la reparación por cuenta propia.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se proporcionan recomendaciones específicas, como evitar la inmersión en sales marinas, cargar objetos pesados o realizar flexiones bruscas.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('Se alerta sobre la posibilidad de alteraciones estéticas en caso de reparaciones.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA: GARANTIA'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La no comunicación expresa de EL CLIENTE a KYP BIO INGEN SAC respecto a la escultura y modificación conforme a la causal y plazo estipulado en el párrafo anterior implicará la renuncia a cualquier reclamo por parte de EL CLIENTE y su conformidad respecto al mismo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC otorgará el servicio de mantenimiento de hasta un (01) año respecto a la protesis materia de contrato siempre y cuando la misma no haya sufrido ningún daño estructural que permita su normal pigmentación por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('ONCEAVA: RESOLUCIÓN DEL CONTRATO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se encuentra facultado a resolver el presente Contrato, durante la vigencia del mismo, bastando para ello que curse una comunicación simple con cinco (05) días de anticipación a la fecha en que solicita opere la resolución, en caso se dé el incumplimiento a las obligaciones estipuladas en el presente Contrato y/o en la hoja de requerimiento del servicio por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('ONCEAVA PRIMERA: NOTIFICACION EN DOMICILIO Y/O CORREO ELECTRONICO  '), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Para la validez de todas las comunicaciones y notificaciones entre las partes, con motivo de la ejecución de este contrato, estas se realizarán a través de sus domicilios y/o correos electrónicos, señalados en la introducción de este documento. La variación de domicilio de cualquiera de las partes surtirá efecto desde la fecha de comunicación de dicho cambio a la otra parte, por cualquier medio escrito.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('ONCEAVA SEGUNDA: COMPETENCIA Y LEGISLACIÓN'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('LAS PARTES acuerdan que para efectos de cualquier controversia que se genere con motivo de la celebración y/o ejecución de este contrato, serán resueltas de manera definitiva mediante ARBITRAJE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('ONCEAVA TERCERA: DISPOSICIONES FINALES'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las partes declaran que el Contrato constituye el acuerdo y entendimiento íntegros a los que han llegado con relación al objeto materia del presente documento y que el Contrato sustituye todas las negociaciones y todos los acuerdos que hubieran sido celebrados previamente. '), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier modificación o ampliación de los términos del presente Contrato deberá realizarse por escrito y con participación de las partes.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('En señal de conformidad, las partes suscriben el presente documento en dos (2) ejemplares originales en los mismos términos y con la misma validez, en la ciudad de ' . $datos['SEDE'] . ' el ' . $fecha_hoy . '.'), 0);
            $pdf->Ln(2);
        } else if ($datos['SUB_TRAB'] == 'Mano Parcial Biónica' || $datos['SUB_TRAB'] == 'Mano Completa Biónica') {

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('NOVENA: PROCESO DE ELABORACIÓN, CARACTERISTICAS, INTERVENCIONES QUIRUJICAS, PROGRAMACIÓN DE CITAS, USOS Y CUIDADOS'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Proceso de Elaboración:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La elaboración de la prótesis abarca un periodo de 30 a 40 días hábiles, distribuidos en 5 fases:'), 0);
            $pdf->Ln(2);

            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('i.     Fase I: Toma de medidas y escaneo 3D.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('ii.    Fase II: Pruebas de encaje del socket.'), 0, 1);
            $pdf->SetX(40);
            $pdf->MultiCell(0, 5.5, utf8_decode('iii.   Fase III: Pruebas con el prototipo de la prótesis y adecuación de las señales            mioeléctricas.'), 0);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iv.   Fase IV: Modificaciones y ensamble de la prótesis final.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('v.    Fase V: Entrega de la prótesis final con sus accesorios.'), 0, 1);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Características de las Prótesis:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La prótesis electrónica ofrece la capacidad de realizar diversas actividades cotidianas con facilidad, desde sujetar objetos como vasos, tazas, hasta manipular bolígrafos y teléfonos celulares. La efectividad en estas tareas puede variar en función del nivel de destreza y habilidad individual del paciente.'), 0);
            $pdf->Ln(5);


            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Intervenciones Quirúrgicas y Puntualidad: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El paciente no debe realizarse ninguna intervención quirúrgica durante la elaboración de la prótesis para evitar retrasos y variaciones en el diseño del encaje.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('A partir de la FASE III, la empresa no asume responsabilidad por variaciones en medidas del muñón no informadas previamente.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Programación de Citas: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La asistencia puntual a todas las citas programadas con el especialista es de vital importancia durante las diversas fases del desarrollo hasta la entrega final de la prótesis. La falta de asistencia a estas citas puede ocasionar retrasos considerables en la entrega del producto final. Se informa al paciente que la ausencia continua y no justificada a dichas citas podría resultar en la terminación unilateral del contrato por parte del proveedor, sin derecho a reclamos o reembolsos de los pagos efectuados hasta la fecha de rescisión.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Usos y cuidados: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El uso de la prótesis se limita a actividades cotidianas que incluyen sujetar vasos, tazas, bolígrafos, teléfonos celulares y objetos similares. Queda expresamente prohibido exponer la prótesis a temperaturas superiores a 50 °C, así como participar en actividades extremas con su uso. Se advierte al usuario que la capacidad de carga de la prótesis está limitada a objetos de hasta 1.5 kg, evitando cargas superiores para preservar su integridad y funcionamiento óptimo. Se hace constar que cualquier caída o impacto puede ocasionar daños irreparables, por lo que se recomienda precaución para evitar estos incidentes. Adicionalmente, se insta al usuario a evitar el contacto con agua, polvo excesivo y sustancias químicas, ya que podrían comprometer la integridad y durabilidad de la prótesis.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA: GARANTIA'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El CLIENTE debe llevar la prótesis para su mantenimiento cada 4 meses a partir de la entrega de la prótesis final, según las fechas indicadas en la ficha de garantía. Si no se cumplen estos plazos de mantenimiento, la garantía quedará anulada y no se podrá realizar ningún reclamo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('En caso de que se presente alguna falla en algún componente de la prótesis KYP BIO INGEN SAC, nos comprometemos a evaluar dicho componente defectuoso para determinar el origen del problema. Si la falla se debe a defectos de fabricación, procederemos a reemplazarlo por uno nuevo. Sin embargo, no nos haremos responsables por fallas debido a un uso inadecuado o falta de cuidado de la prótesis. En esos casos, se requerirá el pago del componente dañado para realizar el reemplazo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC otorgará el servicio de mantenimiento de hasta un (01) año respecto a la prótesis materia de contrato siempre y cuando la misma no haya sufrido ningún daño estructural que permita su normal funcionamiento por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA PRIMERA: RESOLUCIÓN DEL CONTRATO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se encuentra facultado a resolver el presente Contrato, durante la vigencia del mismo, bastando para ello que curse una comunicación simple con cinco (05) días de anticipación a la fecha en que solicita opere la resolución, en caso se dé el incumplimiento a las obligaciones estipuladas en el presente Contrato y/o en la hoja de requerimiento del servicio por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA SEGUNDA: NOTIFICACION EN DOMICILIO Y/O CORREO ELECTRONICO '), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Para la validez de todas las comunicaciones y notificaciones entre las partes, con motivo de la ejecución de este contrato, estas se realizarán a través de sus domicilios y/o correos electrónicos, señalados en la introducción de este documento. La variación de domicilio de cualquiera de las partes surtirá efecto desde la fecha de comunicación de dicho cambio a la otra parte, por cualquier medio escrito.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA TERCERA: COMPETENCIA Y LEGISLACIÓN'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('LAS PARTES acuerdan que para efectos de cualquier controversia que se genere con motivo de la celebración y/o ejecución de este contrato, serán resueltas de manera definitiva mediante ARBITRAJE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA CUARTA: DISPOSICIONES FINALES'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las partes declaran que el Contrato constituye el acuerdo y entendimiento íntegros a los que han llegado con relación al objeto materia del presente documento y que el Contrato sustituye todas las negociaciones y todos los acuerdos que hubieran sido celebrados previamente. '), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier modificación o ampliación de los términos del presente Contrato deberá realizarse por escrito y con participación de las partes.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('En señal de conformidad, las partes suscriben el presente documento en dos (2) ejemplares originales en los mismos términos y con la misma validez, en la ciudad de ' . $datos['SEDE'] . ' el ' . $fecha_hoy . '.'), 0);
            $pdf->Ln(2);
        } else if ($datos['SUB_TRAB'] == 'Mano Parcial Mecánica' || $datos['SUB_TRAB'] == 'Mano Parcial de articulación manual' || $datos['SUB_TRAB'] == 'Falange Mecánica' || $datos['SUB_TRAB'] == 'Protesis Transhumeral tipo gancho cosmético (Fillauer)' || $datos['SUB_TRAB'] == 'Protesis transradial tipo gancho cosmético (Fillauer)' || $datos['SUB_TRAB'] == 'Protesis Transhumeral tipo gancho cosmético (Aosuo)' || $datos['SUB_TRAB'] == 'Protesis transradial mecánica de TPU' || $datos['SUB_TRAB'] == '') {

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('NOVENA: PROCESO DE ELABORACIÓN, CARACTERISTICAS, INTERVENCIONES QUIRUJICAS, PROGRAMACIÓN DE CITAS, USOS Y CUIDADOS'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Proceso de Elaboración:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La elaboración de la prótesis abarca un periodo de 30 a 40 días hábiles, distribuidos en 5 fases:'), 0);
            $pdf->Ln(2);

            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('i.     Fase I: Toma de medidas y escaneo 3D.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('ii.    Fase II: Pruebas de encaje del socket.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iii.   Fase III: Pruebas con el prototipo de la prótesis.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('iv.   Fase IV: Modificaciones y ensamble de la prótesis final.'), 0, 1);
            $pdf->SetX(40);
            $pdf->Cell(0, 5, utf8_decode('v.    Fase V: Entrega de la prótesis final con sus accesorios.'), 0, 1);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Características de las Prótesis:'), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las prótesis accionadas por el cuerpo ofrecen la capacidad de realizar diversas actividades cotidianas con facilidad, desde sujetar objetos como vasos, tazas, hasta manipular bolígrafos y teléfonos celulares. La efectividad en estas tareas puede variar en función del nivel de destreza y habilidad individual del paciente.'), 0);
            $pdf->Ln(5);


            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Intervenciones Quirúrgicas y Puntualidad: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El paciente no debe realizarse ninguna intervención quirúrgica durante la elaboración de la prótesis para evitar retrasos y variaciones en el diseño del encaje.'), 0);
            $pdf->Ln(2);
            $pdf->MultiCell(0, 5.5, utf8_decode('A partir de la FASE III, la empresa no asume responsabilidad por variaciones en medidas del muñón no informadas previamente.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Programación de Citas: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('La asistencia puntual a todas las citas programadas con el especialista es de vital importancia durante las diversas fases del desarrollo hasta la entrega final de la prótesis. La falta de asistencia a estas citas puede ocasionar retrasos considerables en la entrega del producto final. Se informa al paciente que la ausencia continua y no justificada a dichas citas podría resultar en la terminación unilateral del contrato por parte del proveedor, sin derecho a reclamos o reembolsos de los pagos efectuados hasta la fecha de rescisión.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('Usos y cuidados: '), 0, 1);
            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('El uso de la prótesis se limita a actividades cotidianas que incluyen sujetar vasos, tazas, bolígrafos, teléfonos celulares y objetos similares. Queda expresamente prohibido exponer la prótesis a temperaturas superiores a 50 °C. Se advierte al usuario que la capacidad de carga de la prótesis está limitada a objetos de hasta 1.5 kg, evitando cargas superiores para preservar su integridad y funcionamiento óptimo. Soporta caídas de hasta de 1.5 metros. Adicionalmente, se insta al usuario a evitar el contacto con sustancias químicas, ya que podrían comprometer la integridad y durabilidad de la prótesis.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA: GARANTIA'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('En caso de que se presente alguna falla en algún componente de la prótesis KYP BIO INGEN SAC, nos comprometemos a evaluar dicho componente defectuoso para determinar el origen del problema. Si la falla se debe a defectos de fabricación, procederemos a reemplazarlo por uno nuevo. Sin embargo, no nos haremos responsables por fallas debido a un uso inadecuado o falta de cuidado de la prótesis. En esos casos, se requerirá el pago del componente dañado para realizar el reemplazo.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC otorgará el servicio de mantenimiento de hasta un (01) año respecto a la prótesis materia de contrato siempre y cuando la misma no haya sufrido ningún daño estructural que permita su normal funcionamiento por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA PRIMERA: RESOLUCIÓN DEL CONTRATO'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('KYP BIO INGEN SAC se encuentra facultado a resolver el presente Contrato, durante la vigencia del mismo, bastando para ello que curse una comunicación simple con cinco (05) días de anticipación a la fecha en que solicita opere la resolución, en caso se dé el incumplimiento a las obligaciones estipuladas en el presente Contrato y/o en la hoja de requerimiento del servicio por parte de EL CLIENTE.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA SEGUNDA: NOTIFICACION EN DOMICILIO Y/O CORREO ELECTRONICO '), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Para la validez de todas las comunicaciones y notificaciones entre las partes, con motivo de la ejecución de este contrato, estas se realizarán a través de sus domicilios y/o correos electrónicos, señalados en la introducción de este documento. La variación de domicilio de cualquiera de las partes surtirá efecto desde la fecha de comunicación de dicho cambio a la otra parte, por cualquier medio escrito.'), 0);
            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DÉCIMA TERCERA: COMPETENCIA Y LEGISLACIÓN'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('LAS PARTES acuerdan que para efectos de cualquier controversia que se genere con motivo de la celebración y/o ejecución de este contrato, serán resueltas de manera definitiva mediante ARBITRAJE.'), 0);
            $pdf->Ln(10);

            $pdf->SetFont('arial', 'B', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('DECIMA CUARTA: DISPOSICIONES FINALES'), 0);
            $pdf->Ln(2);

            $pdf->SetFont('arial', '', 11);
            $pdf->MultiCell(0, 5.5, utf8_decode('Las partes declaran que el Contrato constituye el acuerdo y entendimiento íntegros a los que han llegado con relación al objeto materia del presente documento y que el Contrato sustituye todas las negociaciones y todos los acuerdos que hubieran sido celebrados previamente. '), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('Cualquier modificación o ampliación de los términos del presente Contrato deberá realizarse por escrito y con participación de las partes.'), 0);
            $pdf->Ln(2);

            $pdf->MultiCell(0, 5.5, utf8_decode('En señal de conformidad, las partes suscriben el presente documento en dos (2) ejemplares originales en los mismos términos y con la misma validez, en la ciudad de ' . $datos['SEDE'] . ' el ' . $fecha_hoy . '.'), 0);
            $pdf->Ln(2);
        }

        $pdf->Ln(30);
        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(90, 7, '..............................................', 0, 0, 'C');
        $pdf->Cell(0, 7, '..............................................', 0, 0, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('arial', '', 12);
        $pdf->Cell(90, 7, utf8_decode('KYP BIO INGEN SAC'), 0, 0, 'C');
        $pdf->Cell(0, 7, utf8_decode('EL CLIENTE'), 0, 0, 'C');


        $pdf->AddPage();

        $pdf->SetFont('arial', 'B', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(0, 7, "HOJA DE REQUERIMIENTO", 0, 1, 'L', true);
        $pdf->Ln(8);

        $pdf->SetFont('arial', '', 12);
        $pdf->Cell(0, 7, utf8_decode("N° Paciente: " . $datos['ID_PACIENTE']), 0, 1, 'L', false);
        $pdf->Cell(0, 7, utf8_decode("Nombre del Paciente: " . $datos['NOMBRES']), 0, 1, 'L', false);
        $pdf->Ln(8);

        $pdf->SetFont('arial', 'BI', 12);
        $pdf->Cell(0, 7, utf8_decode("Lista de Componentes Cotizados:"), 0, 1, 'L', false);
        $pdf->Ln(5);

        foreach ($lista as $row) {
            $pdf->SetFont('arial', '', 12);
            $pdf->Cell(0, 7, utf8_decode('    -   ' . $row['LISTA']));
            $pdf->Ln(6);
        }
        $pdf->Ln(8);

        if ($datos['TIP_TRAB'] == 'Miembro Inferior') {
            $pdf->AddPage();

            $pdf->SetFont('arial', 'B', 14);
            $pdf->Cell(0, 7, utf8_decode("Consentimiento Informado para Inicio de Protetización"), 0, 1, 'C', false);
            $pdf->Ln(8);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Yo, ' . $datos['NOMBRES'] . ', identificado con DNI ' . $datos['DNI'] . ' en pleno uso de mis facultades mentales y entendiendo plenamente la naturaleza de este consentimiento, otorgo mi consentimiento informado para que el personal profesional capacitado de la empresa KYP BIO INGEN S.A.C realicen el contacto físico necesario durante el tratamiento y cuidado de mi condición de amputación.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Entiendo y acepto que el contacto físico puede ser necesario para realizar una evaluación adecuada, proporcionar tratamiento PROTÉSICO, llevar a cabo procedimientos terapéuticos y mejorar mi bienestar general como persona amputada. Comprendo que el contacto físico puede incluir, pero no se limita a, la inspección visual, la palpación, la movilización de extremidades y la aplicación de dispositivos médicos y ortopédicos.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Además, se me ha proporcionado información detallada sobre los procedimientos específicos que implicarán contacto físico, así como los riesgos y beneficios asociados. Así mismo me explicaron el uso de la media compresiva (LINNER), su limpieza, manera de colocarla y que el material del cual está fabricado es silicona americana hipoalergénica y si podría producir algún tipo de enrojecimiento es por el tipo de piel que el usuario presenta (sensibilidad, alergia u otro factor) y es de mi completa responsabilidad.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Entiendo el hecho de que mi muñón varíe de volumen teniendo en cuenta, el peso, la alimentación, enfermedades de base, etc. que requerirán cambios de socket. Asimismo, al momento de tener el SOCKET EN FIBRA DE CARBONO FINAL si necesita cambios o uno nuevo DEBERÉ ASUMIR EL COSTO DE ESTE TANTO COMO DE UN NUEVO LINNER SI FUERA NECESARIO. He tenido la oportunidad de hacer preguntas y todas ellas han sido respondidas satisfactoriamente.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('También entiendo que tengo el derecho de retirar mi consentimiento en cualquier aspecto de mi tratamiento o cuidado y mi compromiso al asistir puntualmente y con disponibilidad de tiempo a las citas acordadas; de no ser así comunicarme con antelación de mínimo 1 hora para reprogramar dicha cita.'), 0);
            $pdf->Ln(4);

            $pdf->SetFont('arial', '', 12);
            $pdf->MultiCell(0, 5, utf8_decode('Declaro que este consentimiento ha sido otorgado de manera voluntaria y sin ninguna forma de coerción o presión. Soy plenamente consciente de las implicaciones y consecuencias del contacto físico y autorizo a los profesionales capacitados de la empresa KYP BIO INGEN S.A.C a llevar a cabo dichos procedimientos en mi persona. Además, doy mi consentimiento para que se documente y almacene de manera segura cualquier información relacionada con el contacto físico en mi historial médico.'), 0);
            $pdf->Ln(15);

            $pdf->SetFont('arial', '', 12);
            $pdf->Cell(0, 5, 'Firma del Paciente/Representante Legal');
            $pdf->Ln(4);
            $pdf->Cell(0, 5, 'Fecha:');
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
                    <span class="badge rounded-pill bg-label-success">
                        Pagado
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
}
