<?php
switch($_GET['aksi']){
case "tampil": //untuk mengakses aksi=tampil
echo "<h3>Data Barang Masuk</h3>";
echo "<a href='?modul=masuk&aksi=tambah'><div class='tomboltambah'>Tambah Barang Masuk</div></a><br>";
$query=mysqli_query($conn,"SELECT * FROM tbl_pemasukan
left join tbl_barang on tbl_pemasukan.kode_barang = tbl_barang.kode_barang
 order by kode_pemasukan"); 
echo "<table border='1' width='600px'>
<tr>
<th>No</th>
<th>Kode Pemasukan</th>
<th>Kode Barang</th>
<th>Nama Barang</th>
<th>Tanggal Masuk</th>
<th>Jumlah Masuk</th>
<th>Edit</th>
<th>Hapus</th>
</tr>"; 
$nomor=1; 
while($tampil=mysqli_fetch_array($query))
{
echo "<td>$nomor</td>";
echo "<td>$tampil[kode_pemasukan]</td>";
echo "<td>$tampil[kode_barang]</td>";
echo "<td>$tampil[nama_barang]</td>";
echo "<td>$tampil[tanggal_masuk]</td>";
echo "<td>$tampil[jumlah_masuk]</td>";
echo "<td><a href='?modul=masuk&aksi=edit&kode_pemasukan=$tampil[kode_pemasukan]'>edit</a></td>"; 
echo "<td><a href='?modul=masuk&aksi=aksihapus&kode_pemasukan=$tampil[kode_pemasukan]' onclick='return confirm(\"Anda Yakin Menghapus Data Ini?\")'>hapus</a></td>";
echo "</tr>";
$nomor++; 
}
echo "</table>";
break;
case "tambah": //untuk interface tambah barang
echo "<span style='font-size:18pt; font-weight:bold;'>Tambah Data Barang Masuk</span></br></br>
<form method='POST' action='?modul=masuk&aksi=aksitambah'>
<table class='forminput'>
<tr><td>Kode Pemasukan</td><td>: <input type='text' name='kode_pemasukan' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Kode Pemasukan..!\")'/></td></tr>
<tr><td>Kode Barang</td><td>: <select name='kode_barang' required oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Pilih Barang..!\")'>
<option value=''>--Pilih Barang--</option>";
$tampilbarang = mysqli_query($conn,"select * from tbl_barang order by kode_barang asc");
while ($tbarang = mysqli_fetch_array($tampilbarang)){
echo "<option value='$tbarang[kode_barang]'>$tbarang[kode_barang] | $tbarang[nama_barang]</option>";
}
echo "</select></td></tr>
<tr><td>Tanggal Masuk</td><td>: <input type='date' name='tanggal_masuk' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Tanggal Masuk..!\")'/></td></tr>
<tr><td>Jumlah Masuk</td><td>: <input type='text' name='jumlah_masuk' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi jumlah Masuk..!\")'/></td></tr>
<tr><td colspan='2'><input type='submit' value='Simpan'/><input type='submit' value='Batal' onclick='self.history.back()'/></tr>
<tr></tr>
</table>
";
break;
case "aksitambah": //untuk aksi tambah barang
 $sql = mysqli_query($conn, "INSERT INTO tbl_pemasukan values ('$_POST[kode_pemasukan]',
 '$_POST[kode_barang]',
 '$_POST[tanggal_masuk]',
 '$_POST[jumlah_masuk]')");
$jl = $_POST['jumlah_masuk']; 
if (!$sql)
        {
         
        echo '<script>alert(\'Data Gagal Dimasukkan\')
            setTimeout(\'location.href="?modul=masuka&aksi=tampil"\' ,0);</script>';
        }else
        {
        echo '<script>alert(\'Data Berhasil Dimasukkan\')
            setTimeout(\'location.href="?modul=masuk&aksi=tampil"\' ,0);</script>';
            //start kode menambahkan jumlah barang
            mysqli_query($conn,"update tbl_barang set stok = stok + $jl where kode_barang = '$_POST[kode_barang]'");
            //end kode menambahkan jumlah barang
        }   
break;
case "edit": //untuk interface edit barang barang masuk
$tampil = mysqli_fetch_array(mysqli_query($conn,"select * from tbl_pemasukan
left join tbl_barang on tbl_pemasukan.kode_barang = tbl_barang.kode_barang 
where tbl_pemasukan.kode_pemasukan = '$_GET[kode_pemasukan]'"));
echo "<span style='font-size:18pt; font-weight:bold;'>Edit Data Barang masuk</span></br></br>
<form method='POST' action='?modul=masuk&aksi=aksiedit'>
<table class='forminput'>
<tr><td>Kode Pemasukan</td><td>: <input type='text' name='kode_pemasukan' readonly value='$tampil[kode_pemasukan]' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Kode Pemasukan..!\")'/></td></tr>
<tr><td>Kode Barang</td><td>: <select name='kode_barang' required oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Pilih Barang..!\")'>
<option value='$tampil[kode_barang]'>$tampil[kode_barang] | $tampil[nama_barang]</option>
<option value=''>--Pilih Barang--</option>";
$tampilbarang = mysqli_query($conn,"select * from tbl_barang order by kode_barang asc");
while ($tbarang = mysqli_fetch_array($tampilbarang)){
echo "<option value='$tbarang[kode_barang]'>$tbarang[kode_barang] | $tbarang[nama_barang]</option>";
}
echo "</select></td></tr>
<tr><td>Tanggal Masuk</td><td>: <input type='date' name='tanggal_masuk' value='$tampil[tanggal_masuk]' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Tanggal Masuk..!\")'/></td></tr>
<tr><td>Jumlah Masuk</td><td>: <input type='text' name='jumlah_masuk' maxlength='10' value='$tampil[jumlah_masuk]' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi jumlah Masuk..!\")'/></td></tr>
<tr><td colspan='2'><input type='submit' value='Simpan'/><input type='submit' value='Batal' onclick='self.history.back()'/></tr>
<tr></tr>
</table>
";
break;
case "aksiedit": //untuk aksi mengedit barang masuk
$sql = mysqli_query($conn,"update tbl_pemasukan set 
kode_barang = '$_POST[kode_barang]',
tanggal_masuk = '$_POST[tanggal_masuk]',
jumlah_masuk = '$_POST[jumlah_masuk]'
where kode_pemasukan = '$_POST[kode_pemasukan]'");  
if (!$sql)
        {
        echo '<script>alert(\'Data Gagal Diubah\')
            setTimeout(\'location.href="?modul=masuk&aksi=tampil"\' ,0);</script>';
        }else
        {
        echo '<script>alert(\'Data Berhasil Diubah\')
            setTimeout(\'location.href="?modul=masuk&aksi=tampil"\' ,0);</script>';
        }
break;
case "aksihapus": //untuk aksi menghapus data barang masuk
$sql = mysqli_query($conn,"delete from tbl_pemasukan where kode_pemasukan = '$_GET[kode_pemasukan]'");  
if (!$sql)
        {
        echo '<script>alert(\'Data Gagal Dihapus\')
            setTimeout(\'location.href="?modul=masuk&aksi=tampil"\' ,0);</script>';
        }else
        {
        echo '<script>setTimeout(\'location.href="?modul=masuk&aksi=tampil"\' ,0);</script>';
        }
break;
}
?>