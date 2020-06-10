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

    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        
        //Calculate the height of the row
        $nb=0;
        for($i=1; $i <= sizeof($data); ++$i){
            $nb=max($nb,$this->NbLines($this->widths[$i-1],$data[$i]));

        }

        $h=8*$nb;
        //Issue a page break first if needed
        //$this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=1;$i<=sizeof($data);$i++)
        {
            $w=$this->widths[$i-1];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            if (sizeof($data) == 5) {
                //Draw the border
                $this->Rect($x,$y,$w,$h);
                //Print the text
                $this->MultiCell($w,8,$data[$i],0,$a);
                //Put the position to the right of the cell
                $this->SetXY($x+$w,$y);
            }else{
                //Draw the border
            $this->Rect($x,$y,95,40);
            //Print the text
            $this->MultiCell(95,8,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+95,$y);
            }
        }
        //Go to the next line
        if (sizeof($data)==5) {
            $this->Ln($h);
        }else{
            $this->Ln(50);
        }
        
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    // Simple table
    function BasicTable($header, $data)
    {
        $sss = array(1=>$data['bill_to'],2=>$data['desc_inv_no']);
        //print_r($sss);
        $this->Row($sss);

        $wid = array(13,90,20,35,35);
        $counter = 0;
        // Header
        foreach($header as $col){
            $this->Cell($wid[$counter],7,$col,1);
            $counter++;
        }
        $this->Ln();

        //print_r($data);

        $columns = 5;
        $row = (sizeof($data) - 2)/$columns;
        for($r = 1; $r <= $row; $r++){
            for($c = 1; $c <= $columns; $c++){
                if($r == 1){
                   switch ($c) {
                        case 1:
                            $table[$r][$c] = $data['item'];
                            break;
                        case 2:
                            $table[$r][$c] = $data['description'];
                            //$height = $this->GetMultiCellHeight(95, 8, $data['description'], 1);
                            break;
                        case 3:
                            $table[$r][$c] = $data['quantity'];
                            break;
                        case 4:
                            $table[$r][$c] = $data['rate'];
                            break;
                        case 5:
                            $table[$r][$c] = $data['amount'];
                            break;

                    }
                }else{
                    switch ($c) {
                        case 1:
                            $table[$r][$c] = $data['item'.$r];
                            break;
                        case 2:
                            $table[$r][$c] = $data['description'.$r];
                            /*if ($height < $this->GetMultiCellHeight(95, 8, $data['description'.$r], 1)) {
                                $height = $this->GetMultiCellHeight(95, 8, $data['description'.$r], 1);
                            }*/
                            break;
                        case 3:
                            $table[$r][$c] = $data['quantity'.$r];
                            break;
                        case 4:
                            $table[$r][$c] = $data['rate'.$r];
                            break;
                        case 5:
                            $table[$r][$c] = $data['amount'.$r];
                            break;

                    }
                }
            }
        }

        foreach($table as $rows){
            $this->Row($rows);
        }
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
//set column width
$pdf->SetWidths(array(13,90,20,35,35));
// Data to load in the table
$data = $_POST;

$pdf->Ln(60);
//loading the table
$pdf->BasicTable($header, $data);

//Display output
$pdf->Output();
?>
