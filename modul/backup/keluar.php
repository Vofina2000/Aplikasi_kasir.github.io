<?php
switch($_GET['aksi']){
case "tampil": //untuk mengakses aksi=tampil
echo "<h3>Data Barang Keluar</h3>";
echo "<a href='?modul=keluar&aksi=tambah'><div class='tomboltambah'>Tambah Barang Keluar</div></a><br>";
$query=mysqli_query($conn,"SELECT * FROM tbl_pengeluaran
left join tbl_barang on tbl_pengeluaran.kode_barang = tbl_barang.kode_barang
 order by kode_pengeluaran"); 
echo "<table border='1' width='600px'>
<tr>
<th>No</th>
<th>Kode Pengeluaran</th>
<th>Kode Barang</th>
<th>Nama Barang</th>
<th>Tanggal Keluar</th>
<th>Jumlah Keluar</th>
<th>Stok</th>
<th>Harga</th>
<th>Total Harga</th>
<th>Uang Dibayar</th>
<th>Uang Kembalian</th>

<th>Edit</th>
<th>Hapus</th>
</tr>"; 
$nomor=1; 

while($tampil=mysqli_fetch_array($query))
{
    $total = $tampil['harga_barang'] * $tampil['jumlah_keluar'];
    $kembalian = $tampil['uang_dibayar'] - $total;


echo "<td>$nomor</td>";
echo "<td>$tampil[kode_pengeluaran]</td>";
echo "<td>$tampil[kode_barang]</td>";
echo "<td>$tampil[nama_barang]</td>";
echo "<td>$tampil[tanggal_keluar]</td>";
echo "<td>$tampil[jumlah_keluar]</td>";
echo "<td>$tampil[stok]</td>";
echo "<td>$tampil[harga_barang]</td>";
echo "<td>$total</td>";
echo "<td>$tampil[uang_dibayar]</td>";
echo "<td>$kembalian</td>";


echo "<td><a href='?modul=keluar&aksi=edit&kode_pengeluaran=$tampil[kode_pengeluaran]'>edit</a></td>"; 
echo "<td><a href='?modul=keluar&aksi=aksihapus&kode_pengeluaran=$tampil[kode_pengeluaran]' onclick='return confirm(\"Anda Yakin Menghapus Data Ini?\")'>hapus</a></td>";
echo "</tr>";
$nomor++; 
}
echo "</table>";
break;
case "tambah": //untuk interface tambah barang
echo "<span style='font-size:18pt; font-weight:bold;'>Tambah Data Barang Keluar </span></br></br>
<form method='POST' action='?modul=keluar&aksi=aksitambah'>
<table class='forminput'>
<tr><td>Kode Pemasukan</td><td>: <input type='text' name='kode_pengeluaran' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Kode Pemasukan..!\")'/></td></tr>
<tr><td>Kode Barang</td><td>: <select name='kode_barang' required oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Pilih Barang..!\")'>
<option value=''>--Pilih Barang--</option>";
$tampilbarang = mysqli_query($conn,"select * from tbl_barang order by kode_barang asc");
while ($tbarang = mysqli_fetch_array($tampilbarang)){
echo "<option value='$tbarang[kode_barang]'>$tbarang[kode_barang] | $tbarang[nama_barang]</option>";
}
echo "</select></td></tr>
<tr><td>Tanggal Keluar</td><td>: <input type='date' name='tanggal_keluar' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Tanggal Keluar..!\")'/></td></tr>
<tr><td>Jumlah Keluar</td><td>: <input type='text' name='jumlah_keluar' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Jumlah Keluar..!\")'/></td></tr>
<tr><td>Harga</td><td>: <select name='harga_barang' required oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Pilih harga..!\")'>
<option value=''>--Pilih Harga--</option>";
$tampilbarang = mysqli_query($conn,"select * from tbl_barang order by harga_barang asc");
while ($tbarang = mysqli_fetch_array($tampilbarang)){
echo "<option value='$tbarang[harga_barang]'>$tbarang[nama_barang] | $tbarang[harga_barang]</option>";
}
echo "</select></td></tr>
<tr><td>Uang Dibayar</td><td>: <input type='int' name='uang_dibayar' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Uang Dibayar..!\")'/></td></tr>




<tr><td colspan='2'><input type='submit' value='Simpan'/><input type='submit' value='Batal' onclick='self.history.back()'/></tr>
<tr></tr>
</table>
";
break;
case "aksitambah": //untuk aksi tambah barang
 $sql = mysqli_query($conn, "INSERT INTO tbl_pengeluaran values ('$_POST[kode_pengeluaran]',
 '$_POST[kode_barang]',
 '$_POST[tanggal_keluar]',
 '$_POST[jumlah_keluar]',
 '$_POST[harga_barang]',
 '$_POST[uang_dibayar]')");

$jl = $_POST['jumlah_keluar'];

if (!$sql)
        {
         
        echo '<script>alert(\'Data Gagal Dimasukkan\')
            setTimeout(\'location.href="?modul=keluara&aksi=tampil"\' ,0);</script>';
        }else
        {
        echo '<script>alert(\'Data Berhasil Dimasukkan\')
            setTimeout(\'location.href="?modul=keluar&aksi=tampil"\' ,0);</script>';
            //start kode mengurangi jumlah barang
            mysqli_query($conn,"update tbl_barang set stok = stok - $jl where kode_barang = '$_POST[kode_barang]'");
            //end kode mengurangi jumlah barang
        }   
break;
case "edit": //untuk interface edit barang barang masuk
$tampil = mysqli_fetch_array(mysqli_query($conn,"select * from tbl_pengeluaran
left join tbl_barang on tbl_pengeluaran.kode_barang = tbl_barang.kode_barang 
where tbl_pengeluaran.kode_pengeluaran = '$_GET[kode_pengeluaran]'"));
echo "<span style='font-size:18pt; font-weight:bold;'>Edit Data Barang masuk</span></br></br>
<form method='POST' action='?modul=keluar&aksi=aksiedit'>
<table class='forminput'>
<tr><td>Kode Pemasukan</td><td>: <input type='text' name='kode_pengeluaran' readonly value='$tampil[kode_pengeluaran]' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Kode Pemasukan..!\")'/></td></tr>
<tr><td>Kode Barang</td><td>: <select name='kode_barang' required oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Pilih Barang..!\")'>
<option value='$tampil[kode_barang]'>$tampil[kode_barang] | $tampil[nama_barang]</option>
<option value=''>--Pilih Barang--</option>";
$tampilbarang = mysqli_query($conn,"select * from tbl_barang order by kode_barang asc");
while ($tbarang = mysqli_fetch_array($tampilbarang)){
echo "<option value='$tbarang[kode_barang]'>$tbarang[kode_barang] | $tbarang[nama_barang]</option>";
}
echo "</select></td></tr>
<tr><td>Tanggal Keluar</td><td>: <input type='date' name='tanggal_keluar' value='$tampil[tanggal_keluar]' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Tanggal Keluar..!\")'/></td></tr>
<tr><td>Jumlah Keluar</td><td>: <input type='text' name='jumlah_keluar' maxlength='10' value='$tampil[jumlah_keluar]' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi jumlah Keluar..!\")'/></td></tr>
<tr><td colspan='2'><input type='submit' value='Simpan'/><input type='submit' value='Batal' onclick='self.history.back()'/></tr>
<tr></tr>
</table>
";
break;
case "aksiedit": //untuk aksi mengedit barang masuk
$sql = mysqli_query($conn,"update tbl_pengeluaran set 
kode_barang = '$_POST[kode_barang]',
tanggal_keluar = '$_POST[tanggal_keluar]',
jumlah_keluar = '$_POST[jumlah_keluar]',
stok = '$_POST[stok]'

where kode_pengeluaran = '$_POST[kode_pengeluaran]'");  
if (!$sql)
        {
        echo '<script>alert(\'Data Gagal Diubah\')
            setTimeout(\'location.href="?modul=keluar&aksi=tampil"\' ,0);</script>';
        }else
        {
        echo '<script>alert(\'Data Berhasil Diubah\')
            setTimeout(\'location.href="?modul=keluar&aksi=tampil"\' ,0);</script>';
        }
break;
case "aksihapus": //untuk aksi menghapus data barang masuk
$sql = mysqli_query($conn,"delete from tbl_pengeluaran where kode_pengeluaran = '$_GET[kode_pengeluaran]'");  
if (!$sql)
        {
        echo '<script>alert(\'Data Gagal Dihapus\')
            setTimeout(\'location.href="?modul=keluar&aksi=tampil"\' ,0);</script>';
        }else
        {
        echo '<script>setTimeout(\'location.href="?modul=keluar&aksi=tampil"\' ,0);</script>';
        }
break;
}
?>