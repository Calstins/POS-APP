<?php


// call the fpdf library
require('fpdf/fpdf.php');
// A4 width:219mm
// default margin: 10mm each side
// writabble horizontal: 219(10)

include_once'connect_db.php';

$id=$_GET['id'];
$select=$pdo->prepare("select * from onek_invoice where invoice_id=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

// create pdf object
$pdf= new FPDF('P','mm', array(80,200));

// add new page
$pdf->Addpage();

// font properties
$pdf->SetFont('Arial','B',16);

// cell(width, height, text, border, endline, [align])
// $pdf-> Image('image/1kshoplogo.png',0,0);
$pdf-> Cell(60,10,'1KSHOP plc',1,1,'');


$pdf->SetFont('Arial','B',8);
$pdf-> Cell(60,5,'INVOICE',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf-> Cell(60,5,'Address: 3 Kafi Street, Alausa, Ikeja, Lagos',0,1,'C');

$pdf->SetFont('Arial','I',8);
$pdf-> Cell(60,5,'Phone Number: +234-815911-9625',0,1,'C');
$pdf-> Cell(60,5,'Email Address: webmaster@yehgs.co.uk',0,1,'mailto:webmaster@yehgs.co.uk');
$pdf-> Cell(60,5,'Website: www.yehgs.co.uk',0,1,'C');

$pdf->Line(7,45,72,45);

$pdf->Ln(3);

$pdf->SetFont('Arial','BI',8);
$pdf->cell(30,4,'Bill To:',0,0,'');

$pdf->SetFont('courier','BI',8);
$pdf->cell(30,4,$row->customer_name,0,1,'');

$pdf->SetFont('Arial','BI',8);
$pdf->cell(30,4,'Invoice No:',0,0,'');

$pdf->SetFont('courier','BI',8);
$pdf->cell(30,4,'#'.$row->invoice_id,0,1,'');

$pdf->SetFont('Arial','BI',8);
$pdf->cell(30,4,'Date:',0,0,'');

$pdf->SetFont('courier','BI',8);
$pdf->cell(30,4,$row->order_date,0,1,'');


$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(34,5,'PRODUCT',1,0,'C');
$pdf->cell(7,5,'QTY',1,0,'C');
$pdf->cell(12,5,'PRICE',1,0,'C');
$pdf->cell(12,5,'TOTAL',1,1,'C');

$select=$pdo->prepare("select * from onek_invoice_details where invoice_id=$id");
$select->execute();

while($item=$select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetX(7);
    $pdf->SetFont('Helvetica','',8);
    $pdf->cell(34,5,$item->product_name,1,0,'L');
    $pdf->cell(7,5,$item->qty,1,0,'C');
    $pdf->cell(12,5,$item->price,1,0,'C');
    $pdf->cell(12,5,$item->price*$item->qty,1,1,'R');

}


$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(20,5,'',0,0,'L');
// $pdf->cell(20,5,'',0,0,'C');
$pdf->cell(25,5,'SUBTOTAL',0,0,'C',);
$pdf->cell(20,5,$row->subtotal,0,1,'R');


$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(20,5,'',0,0,'L');
// $pdf->cell(20,5,'',0,0,'C');
$pdf->cell(25,5,'VAT(7.5%)',0,0,'C',);
$pdf->cell(20,5,$row->tax,0,1,'R');

$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(20,5,'',0,0,'L');
// $pdf->cell(20,5,'',0,0,'C');
$pdf->cell(25,5,'DISCOUNT',0,0,'C',);
$pdf->cell(20,5,$row->discount,0,1,'R');

$pdf->SetX(7);
$pdf->SetFont('courier','B',10);
$pdf->cell(20,5,'',0,0,'L');
// $pdf->cell(20,5,'',0,0,'C');
$pdf->cell(25,5,'GD-TOTAL',0,0,'C',);
$pdf->cell(20,5,$row->total,0,1,'R');

$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(20,5,'',0,0,'L');
// $pdf->cell(20,5,'',0,0,'C');
$pdf->cell(25,5,'DUE',0,0,'C',);
$pdf->cell(20,5,$row->due,0,1,'R');


$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(20,5,'',0,0,'L');
// $pdf->cell(20,5,'',0,0,'C');
$pdf->cell(25,5,'PAYMENT TYPE',0,0,'C',);
$pdf->cell(20,5,$row->payment_type,0,1,'R');

$pdf->Cell(20,5,'',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','B',8);
$pdf->cell(25,5,'Important Notice:',0,1,'',);

$pdf->SetX(7);
$pdf->SetFont('Arial','I',6);
$pdf->cell(75,5,'No item will be refunded if you dont have the invoice with you. You',0,2,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','I',6);
$pdf->cell(75,5,'can refund within 2 days of purchase',0,1,'');



// output the result
$pdf->Output();

?>