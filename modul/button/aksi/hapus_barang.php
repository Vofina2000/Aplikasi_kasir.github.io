<?php 
include "../../../koneksi/koneksi.php";
if (isset($_GET['id'])){
	$deleteSql = mysqli_query($conf , " DELETE FROM tbl_barang Where kode_barang='$_GET[id]'");
	if($deleteSql){
		echo "<script type='text/javascript'>alert('Data Berhasil Dihapus..!!'); location.href=\"../../barang.php\"</script>";
	}
}
?>