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
$this->Cell(120);
$this->Cell(30,0,'Laporan Barang Keluar',0,0,'C');
$this->Ln(10);
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
$pdf=new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',10);
$dari = @$_POST['dari'];
$sampai = @$_POST['sampai'];
$sql=mysqli_query($conf,"SELECT * FROM tbl_pengeluaran 
INNER JOIN tbl_barang ON tbl_pengeluaran .kode_barang = tbl_barang.kode_barang
where tanggal_keluar between '$dari' and '$sampai'
ORDER BY kode_pengeluaran"); 
$no = 1;
$pdf->SetX(15);
$pdf->CELL(40,6,'Dari Tanggal',0,0,'L',0);
$pdf->CELL(40,6,": $dari",0,1,'L',0);
$pdf->SetX(15);
$pdf->CELL(40,6,'Sampai Tanggal',0,0,'L',0);
$pdf->CELL(40,6,": $sampai",0,1,'L',0);
$pdf->Ln(5);
$pdf->setFillColor(142,160,243);
$pdf->SetX(15);
$pdf->CELL(8,6,'NO',1,0,'C',1);
$pdf->CELL(35,6,'Kode Keluar',1,0,'C',1);
$pdf->CELL(25,6,'Kode Barang',1,0,'C',1);
$pdf->CELL(80,6,'Nama Barang',1,0,'C',1);
$pdf->CELL(70,6,'Tgl Keluar',1,0,'C',1);
$pdf->CELL(40,6,'Jumlah',1,1,'C',1);
while($tampil = mysqli_fetch_array($sql)){
$pdf->SetX(15);
$pdf->setFillColor(255,255,255);
$pdf->CELL(8,6,$no,1,0,'C',1);
$pdf->CELL(35,6,$tampil['kode_pengeluaran'],1,0,'L',1);
$pdf->CELL(25,6,$tampil['kode_barang'],1,0,'L',1);
$pdf->CELL(80,6,$tampil['nama_barang'],1,0,'L',1);
$pdf->CELL(70,6,$tampil['tanggal_keluar'],1,0,'L',1);
$pdf->CELL(40,6,$tampil['jumlah_keluar'],1,1,'L',1);
 
$no++;
}
$pdf->Output();
?>