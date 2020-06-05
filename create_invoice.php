<?php
require('fpdf.php');

header("Content-Encoding: None", true);

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('logo.jpg',80,30, 60);

        // Line break
        $this->Ln(20);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Data
       /*foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(40,6,$col,1);
            $this->Ln();
        }*/
    }

}

// Instanciation of inherited class
$pdf = new PDF();
//set page number
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',12);

// Column headings
$header = array('Item', 'Description', 'Quantity', '@', 'Amount');
// Data to load in the table
$data = "";

$pdf->Ln(60);
//loading the table
$pdf->BasicTable($header);

//Display output
$pdf->Output();
?>
