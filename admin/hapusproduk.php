<?php

$ambil = $koneksi->query("SELECT*FROM produk WHERE idproduk='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
$fotoproduk = $pecah['fotoproduk'];
if (file_exists("../foto$fotoproduk")) {
	unlink("../foto$fotoproduk");
}


$koneksi->query("DELETE FROM produk WHERE idproduk='$_GET[id]'");

echo "<script>alert('Produk Berhasil Di Hapus');</script>";
echo "<script>location='index.php?halaman=produk';</script>";
