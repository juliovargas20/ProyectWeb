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

        $this->SetFont('arial', 'IB', 12);
        $this->SetX(135);
        $this->Cell(50, 5, 'Front Desk', 0, 0,  'R');
        $this->Ln(5);

        $this->SetFont('arial', 'B', 12);
        $this->SetX(135);
        $this->Cell(50, 5, 'Fecha: ' . date("Y-m-d"), 0, 0,  'R');
        $this->Ln(5);

        $this->SetFont('arial', 'B', 12);
        $this->SetX(135);
        $this->Cell(50, 5, utf8_decode('N°: ' . $this->id), 0, 0, 'R');

        $this->Image(BASE_URL . 'Assets/img/encabezado.png', 25, 8, 38, 15, 'png');
        $this->Ln(15);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('arial', '', 8);
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

class MYPDF extends FPDF
{
    private $id;
    private $fecha;

    public function __construct($id, $fecha)
    {
        parent::__construct();
        $this->id = $id;
        $this->fecha = $fecha;
    }

    public function Header()
    {

        $this->AddFont('RubikMedium', '', 'Rubik-Medium.php');
        $this->AddFont('RubikRegular', '', 'Rubik-Regular.php');


        $this->SetFont('arial', 'IB', 12);
        $this->SetX(150);
        $this->Cell(50, 5, 'Front Desk', 0, 0,  'R');
        $this->Ln(5);

        $this->SetFont('RubikRegular', '', 12);
        $this->SetX(150);
        $this->Cell(50, 5, 'Fecha: ' . $this->fecha, 0, 0,  'R');
        $this->Ln(5);

        $this->SetFont('RubikMedium', '', 12);
        $this->SetX(150);
        $this->Cell(50, 5, utf8_decode('N°: #' . $this->id), 0, 0, 'R');

        $this->Image(BASE_URL . 'Assets/img/encabezado.png', 10, 8, 38, 15, 'png');
        $this->Ln(15);
    }
}

class PDF_MC_Table extends FPDF
{
    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x, $y, $w, $h);
            // Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            // Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if (!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string)$txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}
