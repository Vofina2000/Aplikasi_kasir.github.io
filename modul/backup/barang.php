<?php

switch($_GET['aksi']){
case "tampil": //untuk mengakses aksi=tampil
echo "<h3>Data Barang</h3>";
echo "<a href='?modul=barang&aksi=tambah'><div class='tomboltambah'>Tambah Data Barang</div></a><br>";
$query=mysqli_query($conn,"SELECT * FROM tbl_barang order by kode_barang"); 
echo "<table border='1' width='600px'>
<tr>
<th>No</th>
<th>Kode Barang</th>
<th>Nama Barang</th>
<th>Stok</th>
<th>Harga</th>
<th>Edit</th>
<th>Hapus</th>
</tr>"; 
$nomor=1; 
while($tampil=mysqli_fetch_array($query))
{
echo "<td>$nomor</td>";
echo "<td>$tampil[kode_barang]</td>";
echo "<td>$tampil[nama_barang]</td>";
echo "<td>$tampil[stok]</td>";
echo "<td>$tampil[harga_barang]</td>";
echo "<td><a href='?modul=barang&aksi=edit&kode_barang=$tampil[kode_barang]'>edit</a></td>"; 
echo "<td><a href='?modul=barang&aksi=aksihapus&kode_barang=$tampil[kode_barang]' onclick='return confirm(\"Anda Yakin Menghapus Data Ini?\")'>hapus</a></td>";
 

echo "</tr>";
$nomor++; 
}
echo "</table>";
break;
case "tambah": //untuk interface tambah barang
echo "<span style='font-size:18pt; font-weight:bold;'>Tambah Data Barang</span></br></br>
<form method='POST' action='?modul=barang&aksi=aksitambah'>
<table class='forminput'>
<tr>
<td>Kode Barang</td><td>: <input type='text' name='kode_barang' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Kode Barang..!\")'/></td>
</tr>
<tr>
<td>Nama Barang</td><td>: <input type='text' name='nama_barang' maxlength='20' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Nama Barang..!\")'/></td>
</tr>
<tr>
<td>Stok Barang</td><td>: <input type='text' name='stok' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Stok Barang..!\")'/></td>
</tr>
<tr>
<td>Harga Barang</td><td>: <input type='text' name='harga_barang' maxlength='20' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Harga Barang..!\")'/></td>
</tr>
<tr><td colspan='2'><input type='submit' value='Simpan'/><input type='submit' value='Batal' onclick='self.history.back()'/></tr>
<tr></tr>
</table>
";
break;
case "aksitambah": //untuk aksi tambah barang
$sql = mysqli_query($conn,"INSERT INTO tbl_barang 
(kode_barang,nama_barang,stok,harga_barang) 
values (
'$_POST[kode_barang]',
'$_POST[nama_barang]',
'$_POST[stok]',
'$_POST[harga_barang]')
");  
if (!$sql)
        {
        echo '<script>alert(\'Data Gagal Dimasukkan\')
            setTimeout(\'location.href="?modul=barang&aksi=tampil"\' ,0);</script>';
        }else
        {
        echo '<script>alert(\'Data Berhasil Dimasukkan\')
            setTimeout(\'location.href="?modul=barang&aksi=tampil"\' ,0);</script>';
}
break;
case "edit": //untuk interface edit barang
$tampil = mysqli_fetch_array(mysqli_query($conn,"select * from tbl_barang where kode_barang = '$_GET[kode_barang]'"));
echo "<span style='font-size:18pt; font-weight:bold;'>Edit Data Barang</span></br></br>
<form method='POST' action='?modul=barang&aksi=aksiedit'>
<table class='forminput'>
<tr>
<td>Kode Barang</td><td>: <input type='text' value='$tampil[kode_barang]' readonly name='kode_barang' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Kode Barang..!\")'/></td>
</tr>
<tr>
<td>Nama Barang</td><td>: <input type='text' value='$tampil[nama_barang]' name='nama_barang' maxlength='20' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Nama Barang..!\")'/></td>
</tr>
<td>Stok Barang</td><td>: <input type='text' value='$tampil[stok]' name='stok' maxlength='10' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Stok Barang..!\")'/></td>
</tr>
<tr>
<td>Harga Barang</td><td>: <input type='text' value='$tampil[harga_barang]' name='harga_barang' maxlength='20' required='required' oninput='setCustomValidity(\"\")' oninvalid='this.setCustomValidity(\"Isi Harga Barang..!\")'/></td>
</tr>
<tr><td colspan='2'><input type='submit' value='Simpan'/><input type='button' value='Batal' onclick='self.history.back()'/></tr>
<tr></tr>
</table>
";
break;
case "aksiedit": //untuk aksi mengedit barang
$sql = mysqli_query($conn,"update tbl_barang set
nama_barang = '$_POST[nama_barang]',
stok = '$_POST[stok]',
harga_barang = '$_POST[harga_barang]'
where kode_barang = '$_POST[kode_barang]'");  
if (!$sql)
        {
        echo '<script>alert(\'Data Gagal Diubah\')
            setTimeout(\'location.href="?modul=barang&aksi=tampil"\' ,0);</script>';
        }else
        {
        echo '<script>alert(\'Data Berhasil Diubah\')
            setTimeout(\'location.href="?modul=barang&aksi=tampil"\' ,0);</script>';
        }
break;
case "aksihapus": //untuk aksi menghapus data barang
$sql = mysqli_query($conn,"delete from tbl_barang where kode_barang = '$_GET[kode_barang]'");  
if (!$sql)
        {
        echo '<script>alert(\'Data Gagal Dihapus\')
            setTimeout(\'location.href="?modul=barang&aksi=tampil"\' ,0);</script>';
        }else
        {
        echo '<script>setTimeout(\'location.href="?modul=barang&aksi=tampil"\' ,0);</script>';
        }
break;
}
?>