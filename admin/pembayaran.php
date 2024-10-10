<?php
$ambil = $koneksi->query("SELECT*FROM pembelian JOIN pengguna
	ON pembelian.id=pengguna.id
	WHERE pembelian.idbeli='$_GET[id]'");
$detail = $ambil->fetch_assoc();
?>


<div class="row mb-2">
    <div class="col-md-12">
    <div class="card shadow h-80">
                <div class="card-body">
                <h5 style="color: black;">Detail Transaksi</h5>
                </div>
            </div>
    </div>
</div>
<div class="row">
	<div class="col-md-6 mb-4">
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #B92854;">
				<h6 class="m-0 font-weight-bold text-white">Detail Transaksi</h6>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<strong>NO PEMBELIAN: <?php echo $detail['idbeli']; ?></strong><br>
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
						<strong>NAMA : <?php echo $detail['nama']; ?></strong><br>
						Telepon : <?php echo $detail['telepon']; ?><br>
						Email : <?php echo $detail['email']; ?><br>
						Alamat Pengiriman : <?php echo $detail['alamatpengiriman']; ?><br>
					</div>
				</div>
				<br>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Produk</th>
							<th>Harga</th>
							<th>Jumlah</th>
							<th>Total Harga</th>
						</tr>
					</thead>
					<tbody>
						<?php $nomor = 1; ?>
						<?php $ambil = $koneksi->query("SELECT * FROM pembelianproduk WHERE idbeli='$_GET[id]'"); ?>
						<?php while ($pecah = $ambil->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $nomor; ?></td>
								<td><?php echo $pecah['nama']; ?></td>
								<td>Rp. <?php echo number_format($pecah['harga']); ?></td>
								<td><?php echo $pecah['jumlah']; ?></td>
								<td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
							</tr>
							<?php $nomor++; ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="col-md-6 mb-4">
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #B92854;">
				<h6 class="m-0 font-weight-bold text-white">Bukti Pembayaran</h6>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12 text-center">
						<?php $ambil2 = $koneksi->query("SELECT * FROM pembayaran WHERE idbeli='$_GET[id]'"); ?>
						<?php while ($detail2 = $ambil2->fetch_assoc()) { ?>
						<img src="../foto/<?php echo $detail2['bukti'] ?>" alt="" class="img-responsive" width="50%">
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$idbeli = $_GET['id'];


?>
<?php $am = $koneksi->query("SELECT*FROM pembelian WHERE idbeli='$idbeli'");
$det = $am->fetch_assoc(); ?>
<div class="row">
	<?php if ($det['statusbeli'] != "Selesai") { ?>
		<div class="col-md-12 mb-4">
			<div class="card shadow mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #B92854;">
					<h6 class="m-0 font-weight-bold text-white">Konfirmasi</h6>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<form method="post">
								<div class="form-group">
									<label>Status</label>
									<select class="form-control" name="statusbeli" id="statusbeli">
										<option value="">Pilih Status</option>
										<option <?php if ($det['statusbeli'] == 'Pesanan Di Tolak') echo 'selected'; ?> value="Pesanan Di Tolak">Pesanan Di Tolak</option>
										<option <?php if ($det['statusbeli'] == 'Pesanan Di Setujui') echo 'selected'; ?> value="Pesanan Di Setujui">Pesanan Di Setujui</option>
										<option <?php if ($det['statusbeli'] == 'Pesanan Sedang Di Proses') echo 'selected'; ?> value="Pesanan Sedang Di Proses">Pesanan Sedang Di Proses</option>
										<option <?php if ($det['statusbeli'] == 'Pesanan Di Kirim') echo 'selected'; ?> value="Pesanan Di Kirim">Pesanan Di Kirim</option>
										<option <?php if ($det['statusbeli'] == 'Pesanan Telah Sampai ke Pemesan') echo 'selected'; ?> value="Pesanan Telah Sampai ke Pemesan">Pesanan Telah Sampai ke Pemesan</option>
									</select>
								</div>
								<div class="form-group">
									<label>Masukkan No Resi Pengiriman</label>
									<input type="text" class="form-control" name="resi" value="<?php echo $det['resipengiriman'] ?>">
								</div>
								<div class="form-group" id="tampil" <?php if ($det['statusbeli'] != 'Pesanan Di Tolak') echo 'style="display: none;"'; ?>>
									<label>Catatan</label>
									<textarea type="text" class="form-control" name="catatanditolak" rows="5"><?= $det['catatanditolak'] ?></textarea>
								</div>
								<button class=" btn btn-primary" name="proses">Simpan</button>
								<br>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
<?php
if (isset($_POST["proses"])) {
	$resi = $_POST["resi"];
	$statusbeli = $_POST["statusbeli"];
	$catatanditolak = $_POST["catatanditolak"];

	// Ambil status beli sebelumnya
	$statusSebelumnya = $koneksi->query("SELECT statusbeli FROM pembelian WHERE idbeli='$idbeli'");
	$dataStatusSebelumnya = $statusSebelumnya->fetch_assoc();
	$statusSebelumnya = $dataStatusSebelumnya['statusbeli'];

	// Update status beli
	$koneksi->query("UPDATE pembelian SET resipengiriman='$resi', statusbeli='$statusbeli', catatanditolak='$catatanditolak' WHERE idbeli='$idbeli'");

	if ($statusbeli == "Pesanan Di Tolak" && $statusSebelumnya != "Pesanan Di Tolak") {
		$produk = $koneksi->query("SELECT * FROM pembelianproduk WHERE idbeli='$idbeli'");
		while ($data = $produk->fetch_assoc()) {
			$jumlah = $data['jumlah'];
			$idproduk = $data['idproduk'];

			// Ambil stok produk saat ini
			$stokProduk = $koneksi->query("SELECT stokproduk FROM produk WHERE idproduk='$idproduk'");
			$dataStok = $stokProduk->fetch_assoc();
			$stokSaatIni = $dataStok['stokproduk'];

			// Kurangkan stok dengan jumlah yang telah dibeli
			$stokBaru = $stokSaatIni + $jumlah;

			// Perbarui stokproduk
			$koneksi->query("UPDATE produk SET stokproduk = '$stokBaru' WHERE idproduk='$idproduk'");
		}
	}

	echo "<script>alert('Status Transaksi Berhasil Diupdate')</script>";
	echo "<script>location='index.php?halaman=pembelian';</script>";
}
?>
<script>
	document.getElementById('statusbeli').addEventListener('change', function() {
		var tampilDiv = document.getElementById('tampil');
		if (this.value === 'Pesanan Di Tolak') {
			tampilDiv.style.display = 'block';
		} else {
			tampilDiv.style.display = 'none';
		}
	});
</script>