<?php
define('FPDF_FONTPATH','font/');
require('../fpdf/fpdf.php');
include "../koneksi/koneksi.php";
class PDF extends FPDF
{
//Page header
function Header()
{
$this->Ln(10);
$this->SetFont('Arial','B',13);
$this->Cell(80);
$this->Cell(30,0,'Data Barang',0,0,'C');
$this->Ln(20);
$this->PageFormats=array('a3'=>array(841.89,1190.55),
'a4'=>array(595.28,841.89), 'a5'=>array(549.94,595.28),
'letter'=>array(612,792), 'legal'=>array(612,1008));
}
function Footer()
{
    $this->SetY(-10);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Halaman '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',10);
$sql = mysqli_query($conf,'select * from tbl_barang');
$no = 1;
$pdf->setFillColor(142,160,243);
$pdf->SetX(25);
$pdf->CELL(8,6,'NO',1,0,'C',1);
$pdf->CELL(25,6,'Kode Barang',1,0,'C',1);
$pdf->CELL(80,6,'Nama Barang',1,0,'C',1);
$pdf->CELL(13,6,'Stok',1,0,'C',1);
$pdf->CELL(35,6,'Harga Barang',1,1,'C',1);
while($tampil = mysqli_fetch_array($sql)){
$pdf->SetX(25);
$pdf->setFillColor(255,255,255);
$pdf->CELL(8,6,$no,1,0,'C',1);
$pdf->CELL(25,6,$tampil['kode_barang'],1,0,'L',1);
$pdf->CELL(80,6,$tampil['nama_barang'],1,0,'L',1);
$pdf->CELL(13,6,$tampil['stok'],1,0,'L',1);
$pdf->CELL(35,6,$tampil['harga_barang'],1,1,'L',1);
$no++;
}
$pdf->Output();
?>