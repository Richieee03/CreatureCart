<?php
session_start();
include 'koneksi.php';

// Check if the user is logged in
if (!isset($_SESSION["pengguna"])) {
	echo "<script>alert('Anda belum login');</script>";
	echo "<script>location='login.php';</script>";
	exit;
}

// Get user data
$id = $_SESSION["pengguna"]['id'];
$query = "
    SELECT pengguna.*
    FROM pengguna 
    WHERE pengguna.id='$id'
";
$pengguna = $koneksi->query($query);
$data = $pengguna->fetch_assoc();

$totalbelanja = 0;

// Loop through the cart items
foreach ($_SESSION["keranjang"] as $idproduk => $jumlah) :
	$query = "SELECT * FROM produk WHERE idproduk='$idproduk'";
	$ambil = $koneksi->query($query);
	$pecah = $ambil->fetch_assoc();
	$totalharga = $pecah["hargaproduk"] * $jumlah;
	// Add the price of the current product to the total shopping cost
	$totalbelanja += $totalharga;
// You can display the products and their details here
endforeach;
?>

<?php include 'header.php'; ?>
<section style="margin-top: 70px; background-color: #F6F7F9;">
	<div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
		<div class="container">
			<div>
				<div class="wrap-about ftco-animate">
					<div class="heading-section text-center">
						<h1 style="font-size: 40px; font-weight:500;">Checkout</h1>
						<p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Checkout</p>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row justify-content-center mt-5">
			<div class="col-xl-10 ftco-animate mb-5">
				<form method="post" style="background-color: #fff;">
					<div class="d-flex align-items-center text-white" style="background-color: #A73E80; padding: 10px 10px;">
						<p class="mb-0"><img src="foto/co.png" alt=""> Info Pembayaran</p>
					</div>
					<div class="row" style="padding: 20px;">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama Pelanggan</label>
								<input type="text" readonly value="<?php echo $data['nama'] ?>" class="form-control">
							</div>
							<div class="form-group">
								<label>No. Handphone Pelanggan</label>
								<input type="text" readonly value="<?php echo $data['telepon'] ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<input type="hidden" id="dua" name="dua" value="<?php echo $totalbelanja ?>">
							<div class="form-group">
								<label>Ongkir Pengiriman</label>
								<input class="form-control" name="ongkir1" type="text" readonly required id="res1" value="<?= rupiah(15000) ?>">
								<input class="form-control" name="ongkir" type="hidden" readonly required id="res" value="15000">
							</div>
							<div class="form-group">
								<label>Total Belanja + Ongkir</label>
								<input class="form-control" id="result1" required readonly type="text" value="<?= rupiah($totalbelanja + 15000) ?>">
								<input class="form-control" id="result" required readonly type="hidden" value="<?= $totalbelanja + 15000 ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Alamat Lengkap Pengiriman</label>
								<textarea class="form-control" name="alamatpengiriman"><?= $data['alamat'] ?></textarea>
							</div>
							<button class="btn btn-danger pull-right btn-lg float-right" name="checkout">Checkout</button>
						</div>
					</div>
				</form>
			</div> <!-- .col-md-8 -->
		</div>
	</div>
</section>
<?php
if (isset($_POST["checkout"])) {
	$notransaksi = '#TP' . date("Ymdhis");
	$id = $_SESSION["pengguna"]["id"];
	$tanggalbeli = date("Y-m-d");
	$waktu = date("Y-m-d H:i:s");
	$alamatpengiriman = $_POST["alamatpengiriman"];
	$totalbeli = $totalbelanja;
	$ongkir = $_POST["ongkir"];
	$koneksi->query(
		"INSERT INTO pembelian(notransaksi,
				id, tanggalbeli, totalbeli, alamatpengiriman, ongkir, statusbeli, waktu)
				VALUES('$notransaksi','$id', '$tanggalbeli', '$totalbeli', '$alamatpengiriman','$ongkir', 'Belum Bayar', '$waktu')"
	) or die(mysqli_error($koneksi));
	$idbeli_barusan = $koneksi->insert_id;
	foreach ($_SESSION['keranjang'] as $idproduk => $jumlah) {
		$ambil = $koneksi->query("SELECT*FROM produk WHERE idproduk='$idproduk'");
		$perproduk = $ambil->fetch_assoc();
		$nama = $perproduk['namaproduk'];
		$harga = $perproduk['hargaproduk'];

		$stok_sekarang = $perproduk['stokproduk'] - $jumlah;
		$koneksi->query("UPDATE produk SET stokproduk='$stok_sekarang' WHERE idproduk='$idproduk'");

		$subharga = $perproduk['hargaproduk'] * $jumlah;
		$koneksi->query("INSERT INTO pembelianproduk (idbeli, idproduk, nama, harga, subharga, jumlah)
					VALUES ('$idbeli_barusan','$idproduk', '$nama','$harga','$subharga','$jumlah')") or die(mysqli_error($koneksi));
	}
	unset($_SESSION["keranjang"]);
	echo "<script> alert('Pembelian Sukses');</script>";
	echo "<script> location ='riwayat.php';</script>";
}
?>
<?php
include 'footer.php';
?>

<script>
	function formatRupiah(angka) {
		var number_string = angka.toString().replace(/[^,\d]/g, ''),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);

		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return 'Rp. ' + rupiah;
	}

	function check() {
		var val = document.getElementById('Sone').value;
		if (val == 'Medan') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Semarang') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Aceh') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Palembang') {
			document.getElementById('res').value = "5000";
		} else if (val == 'Jakarta') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Bandung') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Surabaya') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Yogyakarta') {
			document.getElementById('res').value = "25000";
		} else if (val == 'Bali') {
			document.getElementById('res').value = "15000";
		} else if (val == 'Cirebon') {
			document.getElementById('res').value = "10000";
		} else if (val == 'Tanjung Enim') {
			document.getElementById('Tanjung Enim').value = "25000";
		}
		var num1 = document.getElementById("res").value;
		var num2 = document.getElementById("dua").value;
		result = parseInt(num1) + parseInt(num2);
		document.getElementById("res1").value = formatRupiah(num1);
		document.getElementById("result").value = result;
		document.getElementById("result1").value = formatRupiah(result);
	}
</script>