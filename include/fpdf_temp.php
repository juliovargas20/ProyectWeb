<?php

require('Assets/vendor/libs/fpdf/fpdf.php');

class PDF extends FPDF
{

    // Propiedad para almacenar el valor de $id
    private $id;
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    // Constructor que recibe el valor de $id
    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

    public function Header()
    {

        setlocale(LC_TIME, 'es_ES');

        $this->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $this->AddFont('RubikRegular', '', 'Rubik-Regular.php');


        $this->SetFont('arial', 'IB', 12);
        $this->SetX(150);
        $this->Cell(50, 5, 'Front Desk', 0, 0,  'R');
        $this->Ln(5);

        $this->SetFont('RubikRegular', '', 12);
        $this->SetX(150);
        $this->Cell(50, 5, 'Fecha: ' . date("Y-M-d"), 0, 0,  'R');
        $this->Ln(5);

        $this->SetFont('RubikMedium', '', 12);
        $this->SetX(150);
        $this->Cell(50, 5, utf8_decode('N°: ' . $this->id), 0, 0, 'R');

        $this->Image(BASE_URL . 'Assets/img/encabezado.png', 10, 8, 38, 15, 'png');
        $this->Ln(15);
    }

    function Footer()
    {
        $this->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $this->AddFont('RubikRegular', '', 'Rubik-Regular.php');

        $this->SetY(-15);
        $this->SetFont('RubikRegular', '', 8);
        $this->Cell(0, 10, 'Pag. ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function WriteHTML($html)
    {
        // Intérprete de HTML
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                // Text
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                else
                    $this->Write(5, $e);
            } else {
                // Etiqueta
                if ($e[0] == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else {
                    // Extraer atributos
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag, $attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Etiqueta de apertura
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $attr['HREF'];
        if ($tag == 'BR')
            $this->Ln(5);
    }

    function CloseTag($tag)
    {
        // Etiqueta de cierre
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modificar estilo y escoger la fuente correspondiente
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s) {
            if ($this->$s > 0)
                $style .= $s;
        }
        $this->SetFont('', $style);
    }

    function PutLink($URL, $txt)
    {
        // Escribir un hiper-enlace
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }
}
