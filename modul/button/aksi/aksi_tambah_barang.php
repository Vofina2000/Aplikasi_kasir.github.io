<?php 
include "../../../koneksi/koneksi.php";
if(isset($_POST['tambah_barang'])){
	$insertSql=mysqli_query($conf, "INSERT into tbl_barang (kode_barang , nama_barang, stok , harga_barang) VALUES ('$_POST[kode_barang]','$_POST[nama_barang]','$_POST[stok]','$_POST[harga_barang]')");
	if($insertSql){
		echo "<script type='text/javascript'>alert('Data Berhasil Disimpan..!!'); location.href=\"../../barang.php\"</script>";
	}
}
if (isset($_GET['id'])){
	$deleteSql = mysqli_query($conf , " DELETE FROM tbl_barang Where kode_barang='$_GET[id]'");
	if($deleteSql){
		echo "<script type='text/javascript'>alert('Data Berhasil Dihapus..!!'); location.href=\"../../barang.php\"</script>";
	}else{
		echo "<script type='text/javascript'>alert('Data Gagal Dihapus..!!'); location.href=\"../../barang.php\"</script>";	}
}

if(isset($_POST['pemasukan'])){
	$insertSql=mysqli_query($conf, "INSERT into tbl_pemasukan (kode_pemasukan , kode_barang, tanggal_masuk , jumlah_masuk) VALUES ('$_POST[kode_pemasukan]','$_POST[kode_barang]','$_POST[tanggal_masuk]','$_POST[jumlah_masuk]')");
	$jl = $_POST['jumlah_masuk'];
	if($insertSql){
		echo "<script type='text/javascript'>alert('Data Berhasil Disimpan..!!'); location.href=\"../../masuk.php\"</script>";
		mysqli_query($conf,"update tbl_barang set stok = stok + $jl where kode_barang = '$_POST[kode_barang]'");
	}else{
		echo "<script type='text/javascript'>alert('Data Gagal Disimpan..!!'); location.href=\"../../masuk.php\"</script>";

	}
}
 if(isset($_POST['edit'])){
 	$updatekea = mysqli_query($conf , "update tbl_barang set
nama_barang = '$_POST[nama_barang]',
stok = '$_POST[stok]',
harga_barang = '$_POST[harga_barang]'
where kode_barang = '$_POST[kode_barang]'");
 	if($updatekea){
 				echo "<script type='text/javascript'>alert('Data Berhasil Disimpan..!!'); location.href=\"../../barang.php\"</script>";

 	}
 }


if(isset($_POST['pengeluaran'])){
	$insertSql=mysqli_query($conf, "INSERT INTO tbl_pengeluaran values ('$_POST[kode_pengeluaran]',
 '$_POST[kode_barang]',
 '$_POST[tanggal_keluar]',
 '$_POST[jumlah_keluar]',
 '$_POST[harga_barang]',
 '$_POST[uang_dibayar]')");

	$jl = $_POST['jumlah_keluar'];
	if($insertSql){
		echo "<script type='text/javascript'>alert('Data Berhasil Disimpan..!!'); location.href=\"../../keluar.php\"</script>";
		mysqli_query($conf,"update tbl_barang set stok = stok - $jl where kode_barang = '$_POST[kode_barang]'");
	}else{
		echo "<script type='text/javascript'>alert('Data Gagal Disimpan..!!'); location.href=\"../../keluar.php\"</script>";

	}
}




 ?>