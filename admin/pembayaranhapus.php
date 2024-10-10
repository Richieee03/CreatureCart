<?php
$koneksi->query("DELETE FROM pembelian WHERE idbeli='$_GET[id]'");
$koneksi->query("DELETE FROM pembelianproduk WHERE idbeli='$_GET[id]'");
$koneksi->query("DELETE FROM pembayaran WHERE idbeli='$_GET[id]'");
echo "<script>alert('Data Berhasil Di Hapus');</script>";
echo "<script>location='index.php?halaman=pembelian';</script>";
