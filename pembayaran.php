<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["pengguna"])) {
	echo "<script> alert('Anda belum login');</script>";
	echo "<script> location ='login.php';</script>";
	exit();
}
$idpem = $_GET["id"];
$ambil = $koneksi->query("SELECT*FROM pembelian WHERE idbeli='$idpem'");
$detpem = $ambil->fetch_assoc();

$id_beli = $detpem["id"];
$id_login = $_SESSION["pengguna"]["id"];
if ($id_login !== $id_beli) {
	echo "<script> alert('Gagal');</script>";
	echo "<script> location ='riwayat.php';</script>";
}
$deadline = date('Y-m-d H:i', strtotime($detpem['waktu'] . ' +1 day'));
$harideadline = date('Y-m-d', strtotime($detpem['waktu'] . ' +1 day'));
$jamdeadline = date('H:i', strtotime($detpem['waktu'] . ' +1 day'));
if (date('Y-m-d H:i') >= $deadline) {
	echo "<script> alert('Waktu pembayaran telah habis');</script>";
	echo "<script> location ='riwayat.php';</script>";
}
$ambil2 = $koneksi->query("SELECT*FROM pembelian JOIN pengguna
	ON pembelian.id=pengguna.id
	WHERE pembelian.idbeli='$_GET[id]'");
$detail = $ambil2->fetch_assoc();
?>
<?php include 'header.php'; ?>
<section style="margin-top: 70px;">
	<div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
		<div class="container">
			<div>
				<div class="wrap-about ftco-animate">
					<div class="heading-section text-center">
						<h1 style="font-size: 40px; font-weight:500;">Kategori</h1>
						<p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Kategori</p>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div class="container mt-5">
		<div class="row">
			<div class="col-md-12 mb-4">
				<div class="card shadow mb-4">
					<div class="d-flex align-items-center text-white" style="background-color: #A73E80; padding: 10px 10px;">
						<p class="mb-0"><img src="foto/co.png" alt=""> Upload Bukti Pembayaran Sebelum <?= tanggal($harideadline) . ' - Jam ' . $jamdeadline ?></p>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								Tanggal : <?= tanggal(date('Y-m-d', strtotime($detail['tanggalbeli']))) ?><br>
								Status Pesanan: <?php echo $detail['statusbeli']; ?><br>
								Total Pembelian : Rp. <?php echo number_format($detail['totalbeli']); ?><br>
								Ongkir : Rp. <?php echo number_format($detail['ongkir']); ?><br>
								Total Bayar : Rp. <?php echo number_format($detail['ongkir'] + $detail['totalbeli']); ?><br>
								Status : <?php echo $detail['statusbeli'] ?>
								<?php if ($detail['statusbeli'] == "Pesanan Di Tolak") { ?>
									<br>
									Alasan Di Tolak : <?= $detail['catatanditolak'] ?>
								<?php } ?>
							</div>
							<div class="col-md-6">
								<strong>Nama : <?php echo $detail['nama']; ?></strong><br>
								Telepon : <?php echo $detail['telepon']; ?><br>
								Email : <?php echo $detail['email']; ?><br>
								Alamat Pengiriman : <?php echo $detail['alamatpengiriman']; ?><br>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead style="background-color: #A73E80;">
							<tr>
								<th>No</th>
								<th>Nama Produk</th>
								<th>Harga</th>
								<th>Ongkir</th>
								<th>Total Harga</th>
							</tr>
						</thead>
						<tbody>
							<?php $nomor = 1;
							$id = $_SESSION["pengguna"]['id'];
							$ambil = $koneksi->query("SELECT *, pembayaran.bukti, pembelian.idbeli as idbelireal FROM pembelian left join pembayaran on pembelian.idbeli = pembayaran.idbeli WHERE pembelian.id='$id' order by pembelian.tanggalbeli desc, pembelian.idbeli desc");
							while ($pecah = $ambil->fetch_assoc()) { ?>
								<tr style="color: black;">
									<td><?php echo $nomor; ?></td>
									<td>
										<ul>
											<?php $ambilproduk = $koneksi->query("SELECT * FROM pembelianproduk join produk on pembelianproduk.idproduk = produk.idproduk where idbeli='$pecah[idbelireal]'");
											while ($produk = $ambilproduk->fetch_assoc()) { ?>
												<li>
													<?= $produk['namaproduk'] ?> x <?= $produk['jumlah'] ?>
												</li>
											<?php } ?>
										</ul>
									</td>
									<td><?php echo rupiah($pecah["totalbeli"]); ?></td>
									<td><?php echo rupiah($pecah["ongkir"]); ?></td>
									<td><?php echo rupiah($pecah["totalbeli"] + $pecah["ongkir"]); ?></td>
									<?php $nomor++; ?>
								<?php  } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php
		$ambil = $koneksi->query("SELECT*FROM pembelian JOIN pengguna
		ON pembelian.id=pengguna.id
		WHERE pembelian.idbeli='$_GET[id]'");
		$detail = $ambil->fetch_assoc();
		?>
		<div class="row justify-content-center mb-5 mt-5">
			<div class="col-md-5">
				<img height="100%" src="foto/pay.png">
			</div>
			<div class="col-md-7">
				<br>
				<p>Upload Bukti Pembayaran</p>
				<b>Dana : 0821 3828 1398 (Creature Cart)</b>
				<br>
				<br>
				<div class="alert" style="background-color: #A73E80; color:white;">Total Tagihan Anda : <strong><?php echo rupiah($detpem["totalbeli"] + $detpem["ongkir"]) ?> <br>(Sudah
						Termasuk biaya pengiriman)</strong></div>

				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label>Nama Rekening</label>
						<input type="text" name="nama" class="form-control" value="<?= $_SESSION['pengguna']['nama'] ?>" required>

					</div>
					<div class="form-group">
						<label for="tanggaltransfer">Tanggal Transfer:</label>
						<input type="date" name="tanggaltransfer" id="tanggaltransfer" class="form-control" value="<?= date('Y-m-d') ?>" required>
					</div>
					<div class="form-group">
						<label>Foto Bukti</label>
						<input type="file" name="bukti" class="form-control" required>
					</div>
					<button class="btn btn-danger float-right" name="kirim">Simpan</button>
					<br>
					<br>
				</form>
			</div>
		</div>
	</div>
</section>
<?php
if (isset($_POST["kirim"])) {
	$namabukti = $_FILES["bukti"]["name"];
	$lokasibukti = $_FILES["bukti"]["tmp_name"];
	$namafix = date("YmdHis") . $namabukti;
	move_uploaded_file($lokasibukti, "foto/$namafix");

	$nama = $_POST["nama"];
	$tanggaltransfer = $_POST["tanggaltransfer"];
	$tanggal = date("Y-m-d");


	$koneksi->query("INSERT INTO pembayaran(idbeli, nama, tanggaltransfer,tanggal, bukti)
		VALUES ('$idpem','$nama','$tanggaltransfer','$tanggal','$namafix')");

	$koneksi->query("UPDATE pembelian SET statusbeli='Sudah Upload Bukti Pembayaran'
		WHERE idbeli='$idpem'");
	echo "<script> alert('Terima kasih, Pembayaran anda berhasil di uplaod, mohon menunggu konfirmasi admin');</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>
<?php
include 'footer.php';
?>

<script>
	// Mendapatkan elemen input tanggal transfer
	var inputTanggalTransfer = document.getElementById('tanggaltransfer');

	// Mendapatkan tanggal saat ini dalam format YYYY-MM-DD
	var currentDate = new Date().toISOString().split('T')[0];

	// Menetapkan nilai maksimum tanggal pada elemen input
	inputTanggalTransfer.setAttribute('max', currentDate);
</script>