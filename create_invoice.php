<?php
require('fpdf.php');

header("Content-Encoding: None", true);

class PDF extends FPDF
{

    var $widths;
    var $aligns;

    var $invoiceNo;

    var $pdfObject;

    function SetInvoiceNo($no){
        $this->invoiceNo = $no;
    }
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

    function setPdfObject($pdf){
        $this->$pdfObject = $pdf;
    }

    function GetVAT(){
        /*$host_name = "localhost";
        $db_username = "dannexte_root";
        $db_password = "BitifyPro@2020";
        $db_name = "dannexte_invoices";*/

        $host_name = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "invoice_generator";

        $connect = mysqli_connect($host_name, $db_username, $db_password, $db_name);


        if (!$connect) {
            echo "<script>alert('Could not connect to the database');</script>";
            exit;
        }

        $sql = "SELECT value FROM vat WHERE id = 1";

        $result = mysqli_query($connect, $sql);

        $vat = mysqli_fetch_assoc($result);

        mysqli_close($connect);

        return $vat['value']/100;

    }
// Page header
    function Header()
    {
        // Logo
        $this->Image('logo2.jpg',80,10, 60);

        $this->Ln(25);
        $this->setFont("Arial",'',10);
        $this->cell(0, 60,"Gateway House Kenyatta Avenue Third Floor | P.O.Box 4089 Thika",0,0,'C');
        $this->Ln(1);
        $this->cell(0, 67,'TEL: +254726224968, +254726736198 | EMAIL: info@marc.co.ke',0,0,'C');
        $this->Ln(10);
        $this->SetTextColor(0,0,0);
        $this->Cell(0,70,"Date: ". date("Y-m-d"),0,0,'R');
        $this->Ln(1);
        $this->SetTextColor(30,144,255);
        $this->SetFont("Arial", 'B', 20);
        $this->Cell(0,80,"INVOICE",0,0,'C');
        $this->SetFont("Arial", "B", 12);
        $this->Ln(1);
        $this->Cell(0,90,"Invoice No: ".$this->invoiceNo,0,0,'L');
        
        $this->SetTextColor(30,144,255);
        $this->Cell(0,90,"PIN No: P051414752C",0,0,'R');
        
        $this->Ln(4);

        // Line break
        //$this->Ln();
    }

// Page footer
    function Footer()
    {
        $this->SetY(-60);
        $this->SetFont('Arial','',10);
        $this->Cell(0,30,"Prepared by: ________________________________________",0,0,"C");

        // Position at 1.5 cm from bottom
        $this->SetY(-40);
        $this->Image('footer.png',20,null, 0,0);
        $this->Ln(1);
        // Arial italic 8
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(128,128,128);
        // Page number

        $this->MultiCell(0,4,'Accounts to be settled by CROSSED CHEQUE / BANK RTGS only in favor of Marc Construction Works Limited Account NO: 1168971586. Kenya Commercial Bank, Thika Branch');
        $this->Ln();
        $this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');

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
                
                if($i==2){
                    //Print the text
                $this->MultiCell($w,8,$data[$i],0,"L");

                }else{
                    //Print the text
                $this->MultiCell($w,8,$data[$i],0,"R");

                }

                
                
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
    function BasicTableNew($header, $data)
    {
        $sss = array(1=>$data['bill_to'],2=>$data['desc_inv_no']);
        $this->Row($sss);

        $wid = array(13,90,20,35,35);
        $counter = 0;
        // Header
        foreach($header as $col){
            $this->Cell($wid[$counter],7,$col,1);
            $counter++;
        }
        $this->Ln();


        $columns = 5;
        $row = (sizeof($data) - 2)/$columns;

            /*$host_name = "localhost";
            $db_username = "dannexte_root";
            $db_password = "BitifyPro@2020";
            $db_name = "dannexte_invoices";*/
            
            $host_name = "localhost";
            $db_username = "root";
            $db_password = "";
            $db_name = "invoice_generator";

            $connect = mysqli_connect($host_name, $db_username, $db_password, $db_name);


            if (!$connect) {
                echo "<script>alert('Could not connect to the database');</script>";
                exit;
            }

            $table = null;

        for($r = 1; $r <= $row; $r++){
            $sql = "INSERT INTO items (itemNo, itemDescription, itemQuantity, itemRate, itemInvoiceNo) VALUES ('".$data['item'.$r]."', '".$data['description'.$r]."', '".$data['quantity'.$r]."', '".$data['rate'.$r]."','".$data['invoiceNo']."')";

            if ($connect->query($sql) === TRUE) {
                for($c = 1; $c <= $columns; $c++){
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
                            $table[$r][$c] = number_format($data['rate'.$r]);
                            break;
                        case 5:
                            $table[$r][$c] = number_format($data['amount'.$r]);
                            break;
                    }
                }
            } else {
                echo "Error: " . $sql . "<br>" . $connect->error;
            }
            
        }

        $connect->close();

        $items = sizeof($table);
        $subTotal = 0;
        foreach($table as $amount){
            //remove commas from value
            $output = str_replace(',', '', $amount[5]);
            $subTotal += (int)$output;
        }

        //getting the current VAT
        $vat = $subTotal * $this->GetVAT();
        $total = $subTotal + $vat;

        for($r = $items+1; $r <= $items+4; $r++) {
            switch ($r) {
                case $items + 1:
                    $table[$r][1] = "";
                    $table[$r][2] = "";
                    $table[$r][3] = "";
                    $table[$r][4] = "";
                    $table[$r][5] = "";
                    break;
                case $items + 2:
                    $table[$r][1] = "";
                    $table[$r][2] = "Sub-Total";
                    $table[$r][3] = "";
                    $table[$r][4] = "";
                    $table[$r][5] = number_format($subTotal);
                    break;
                case $items + 3:
                    $table[$r][1] = "";
                    $table[$r][2] = "ADD VAT";
                    $table[$r][3] = "";
                    $table[$r][4] = "";
                    $table[$r][5] = number_format($vat);
                    break;
                case $items + 4:
                    $table[$r][1] = "";
                    $table[$r][2] = "Total";
                    $table[$r][3] = "";
                    $table[$r][4] = "";
                    $table[$r][5] = number_format($total);
                    break;
            }
        }


        foreach($table as $amount){
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

    // Simple table
    function BasicTableOld($header, $data)
    {
        $sss = array(1=>$data['bill_to'],2=>$data['desc_inv_no']);
        $this->Row($sss);

        $wid = array(13,90,20,35,35);
        $counter = 0;
        // Header
        foreach($header as $col){
            $this->Cell($wid[$counter],7,$col,1);
            $counter++;
        }
        $this->Ln();


        $columns = 5;
        $row = (sizeof($data) - 2)/$columns;

            /*$host_name = "localhost";
            $db_username = "dannexte_root";
            $db_password = "BitifyPro@2020";
            $db_name = "dannexte_invoices";*/
            
            $host_name = "localhost";
            $db_username = "root";
            $db_password = "";
            $db_name = "invoice_generator";

            $connect = mysqli_connect($host_name, $db_username, $db_password, $db_name);


            if (!$connect) {
                echo "<script>alert('Could not connect to the database');</script>";
                exit;
            }

            $table = null;

        /*for($r = 1; $r <= $row; $r++){
            $sql = "UPDATE items SET itemNo = '".$data['item'.$r]."', itemDescription = '".$data['description'.$r]."', itemQuantity = '".$data['quantity'.$r]."', itemRate = '".$data['rate'.$r]."' WHERE itemInvoiceNo = '".$data['invoiceNo']."' AND itemNo = '".$data['item'.$r]."'";

            if ($connect->query($sql) === TRUE) {
                for($c = 1; $c <= $columns; $c++){
                    switch ($c) {
                        case 1:
                            $table[$r][$c] = $data['item'.$r];
                            break;
                        case 2:
                            $table[$r][$c] = $data['description'.$r];
                            /*if ($height < $this->GetMultiCellHeight(95, 8, $data['description'.$r], 1)) {
                                $height = $this->GetMultiCellHeight(95, 8, $data['description'.$r], 1);
                            }*//*
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
            } else {
                echo "Error: " . $sql . "<br>" . $connect->error;
            }
            
        }*/

        $sql1 = "DELETE FROM items WHERE itemInvoiceNo = '".$data['invoiceNo']."'";

        if(mysqli_query($connect,$sql1)):
            for($r = 1; $r <= $row; $r++){
                $sql = "INSERT INTO items (itemNo, itemDescription, itemQuantity, itemRate, itemInvoiceNo) VALUES ('".$data['item'.$r]."', '".$data['description'.$r]."', '".$data['quantity'.$r]."', '".$data['rate'.$r]."','".$data['invoiceNo']."')";
    
                if ($connect->query($sql) === TRUE) {
                    for($c = 1; $c <= $columns; $c++){
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
                                $table[$r][$c] = number_format($data['rate'.$r]);
                                break;
                            case 5:
                                $table[$r][$c] = number_format($data['amount'.$r]);
                                break;
                        }
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $connect->error;
                }
                
            }
        endif;
        

        $connect->close();

        $items = sizeof($table);
        $subTotal = 0;
        foreach($table as $amount){
            //remove commas from value
            $output = str_replace(',', '', $amount[5]);
            $subTotal += (int)$output;
        }

        //getting the current VAT
        $vat = $subTotal * $this->GetVAT();
        $total = $subTotal + $vat;

        for($r = $items+1; $r <= $items+4; $r++) {
            switch ($r) {
                case $items + 1:
                    $table[$r][1] = "";
                    $table[$r][2] = "";
                    $table[$r][3] = "";
                    $table[$r][4] = "";
                    $table[$r][5] = "";
                    break;
                case $items + 2:
                    $table[$r][1] = "";
                    $table[$r][2] = "Sub-Total";
                    $table[$r][3] = "";
                    $table[$r][4] = "";
                    $table[$r][5] = number_format($subTotal);
                    break;
                case $items + 3:
                    $table[$r][1] = "";
                    $table[$r][2] = "VAT";
                    $table[$r][3] = "";
                    $table[$r][4] = "";
                    $table[$r][5] = number_format($vat);
                    break;
                case $items + 4:
                    $table[$r][1] = "";
                    $table[$r][2] = "Total";
                    $table[$r][3] = "";
                    $table[$r][4] = "";
                    $table[$r][5] = number_format($total);
                    break;
            }
        }


        foreach($table as $amount){
        }
        $ccc = 1;
        foreach($table as $rows){
            $this->Row($rows);
            if($ccc == 10 || $ccc%10 == 0) {
                $this->addPage();
                $this->Ln(50);
            }
            $ccc++;
        }
        // Data
        /*foreach($data as $row)
         {
             foreach($row as $col)
                 $this->Cell(40,6,$col,1);
             $this->Ln();
         }*/
    }

    

    function saveInvoice($invoice){
        $sql = "INSERT INTO invoice (invoiceNo, billTo, description, invoicePath) VALUES ('".$invoice['invoiceNo']."', '".$invoice['bill_to']."', '".$invoice['desc_inv_no']."', '../invoices/".$invoice['invoiceNo'].".pdf')";

        /*$host_name = "localhost";
        $db_username = "dannexte_root";
        $db_password = "BitifyPro@2020";
        $db_name = "dannexte_invoices";*/

        $host_name = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "invoice_generator";

        $connect = mysqli_connect($host_name, $db_username, $db_password, $db_name);


        if (!$connect) {
            echo "<script>alert('Could not connect to the database');</script>";
            exit;
        }

        if(mysqli_query($connect,$sql)):
           // echo "<script>alert('Invoice Saved Successfully')</script>";
        endif;
    }

    function updateInvoice($invoice){
        $sql1 = "DELETE FROM invoice WHERE invoiceNo = '".$invoice['invoiceNo']."'";
        //$sql = "UPDATE invoice SET billTo = '".$invoice['bill_to']."', description = '".$invoice['desc_inv_no']."' WHERE invoiceNo = '".$invoice['invoiceNo']."'";
        $sql2 = "INSERT INTO invoice (invoiceNo, billTo, description, invoicePath) VALUES ('".$invoice['invoiceNo']."', '".$invoice['bill_to']."', '".$invoice['desc_inv_no']."', '../invoices/".$invoice['invoiceNo'].".pdf')";

        /* $host_name = "localhost";
        $db_username = "dannexte_root";
        $db_password = "BitifyPro@2020";
        $db_name = "dannexte_invoices";*/

        $host_name = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "invoice_generator";

        $connect = mysqli_connect($host_name, $db_username, $db_password, $db_name);


        if (!$connect) {
            echo "<script>alert('Could not connect to the database');</script>";
            exit;
        }

        if(mysqli_query($connect,$sql1)):
            mysqli_query($connect, $sql2);
           // echo "<script>alert('Invoice Saved Successfully')</script>";
        endif;
    }
}

// Instanciation of inherited class
$pdf = new PDF();



$inNo = 0;

// //set page number
// $pdf->AliasNbPages();
// $pdf->AddPage();
// $pdf->SetFont('Times','B',12);

//$pdf->SetAutoPageBreak(true, 10);


// Column headings
$header = array('Item', 'Description', 'Quantity', '@', 'Amount');
//set column width
$pdf->SetWidths(array(13,90,20,35,35));
// Data to load in the table
$data = $_POST;

if($data['invoice_no'] != ""){
    $inNo = $data['invoice_no'];
    
    $pdf->SetInvoiceNo($data['invoice_no']);

    $data['invoiceNo'] = $data['invoice_no'];

    $pdf->updateInvoice($data);

    //set page number
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','B',12);

    $pdf->Ln(50);
    //loading the table
    $pdf->BasicTableOld($header, $data);

    //$filename="/home/dannexte/public_html/InvoiceGenerator/invoices/".$inNo.".pdf";
    $filename = "C:\\xampp\\htdocs\\invoicegen\\invoices\\".$inNo.".pdf";
    
    //delete file
    unlink($filename);

    //Display output
    $pdf->Output($filename,'F');
    $pdf->Output();

}else{
    //generate a random number
    //$inNo = rand(1000,10000);


        /*$host_name = "localhost";
        $db_username = "dannexte_root";
        $db_password = "BitifyPro@2020";
        $db_name = "dannexte_invoices";*/

        $host_name = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "invoice_generator";

        $connect = mysqli_connect($host_name, $db_username, $db_password, $db_name);


        if (!$connect) {
            echo "<script>alert('Could not connect to the database');</script>";
            exit;
        }

    $result = mysqli_query($connect,"SELECT * FROM invoice");
    $inNo = mysqli_num_rows($result)+1;

    $inNo += 1630; 

    $pdf->SetInvoiceNo($inNo);

    $data['invoiceNo'] = $inNo;

    $pdf->saveInvoice($data);

    //set page number
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','B',12);

    $pdf->Ln(50);
    //loading the table
    $pdf->BasicTableNew($header, $data);

    //Display output
    //$filename="/home/dannexte/public_html/InvoiceGenerator/invoices/".$inNo.".pdf";
    $filename = "C:\\xampp\\htdocs\\invoicegen\\invoices\\".$inNo.".pdf";
    $pdf->Output($filename,'F');
    $pdf->Output();
}
?>
