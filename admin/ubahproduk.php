<?php
// Mengambil data produk berdasarkan idproduk
$ambil = $koneksi->query("SELECT * FROM produk WHERE idproduk='$_GET[id]'");
$pecah = $ambil->fetch_assoc();

// Mengambil data kategori
$datakategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
	$datakategori[] = $tiap;
}

// Mengambil riwayat kesehatan produk berdasarkan idproduk
$riwayatKesehatan = array();
$ambilRiwayat = $koneksi->query("SELECT * FROM riwayat_kesehatan WHERE idproduk='$_GET[id]'");
while ($riwayat = $ambilRiwayat->fetch_assoc()) {
	$riwayatKesehatan[] = $riwayat;
}

function formatRupiah($angka)
{
	$rupiah = "Rp. " . number_format($angka, 0, ',', '.');
	return $rupiah;
}
?>
<div class="row mb-2">
	<div class="col-md-12">
		<div class="card shadow h-80">
			<div class="card-body">
				<h5 style="color: black;">Ubah Produk</h5>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card shadow mb-4">
			<div class="card-body">
				<form method="post" enctype="multipart/form-data">

					<div class="form-group">
						<label>Nama Produk</label>
						<input type="text" name="nama" class="form-control" value="<?php echo $pecah['namaproduk']; ?>">
					</div>

					<div class="form-group">
						<label>Nama Kategori</label>
						<select class="form-control" name="id_kategori">
							<option value="">Pilih Kategori</option>
							<?php foreach ($datakategori as $key => $value) : ?>

								<option value="<?php echo $value["id_kategori"] ?>" <?php if ($pecah["id_kategori"] == $value["id_kategori"]) {
																						echo "selected";
																					} ?>><?php echo $value["nama_kategori"] ?></option>

							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group">
						<label>Harga Rp</label>
						<input type="text" name="harga" id="harga" class="form-control" value="<?php echo formatRupiah($pecah['hargaproduk']); ?>">
					</div>
					<div class="form-group">

						<img src="../foto/<?php echo $pecah['fotoproduk']; ?>" width="200">

					</div>

					<div class="form-group">
						<label> Ganti Foto</label>
						<input type="file" class="form-control" name="foto">
					</div>

					<div class="form-group">
						<label>Keterangan</label>
						<select name="deskripsi" class="form-control" id="">
							<option value="Tersedia" <?= $pecah['deskripsiproduk'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
							<option value="Tidak Tersedia" <?= $pecah['deskripsiproduk'] == 'Tidak Tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
						</select>
					</div>
					<div class="form-group">
						<label>Stok Produk</label>
						<input type="number" name="stok" class="form-control" value="<?php echo $pecah['stokproduk']; ?>">
					</div>

					<button class="btn btn-primary" name="ubah">Ubah</button>
					
					<!-- Bagian Riwayat Kesehatan -->
					<div class="form-group mt-5">
						<label>Riwayat Kesehatan</label>
						<table class="table table-bordered" id="tabelRiwayatKesehatan">
							<thead style="background-color: #A73E80;">
								<tr class="text-white">
									<th>Tanggal</th>
									<th>Status Kesehatan</th>
									<th>Deskripsi</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($riwayatKesehatan as $riwayat) : ?>
								<tr>
									<td><input type="date" name="tanggal[]" class="form-control" value="<?php echo $riwayat['tanggal']; ?>"></td>
									<td><input type="text" name="tindakan[]" class="form-control" value="<?php echo $riwayat['tindakan']; ?>"></td>
									<td><textarea name="deskripsi_kesehatan[]" class="form-control"><?php echo $riwayat['deskripsi']; ?></textarea></td>
									<td><button type="button" class="btn btn-danger removeRow">Hapus</button></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<button type="button" class="btn btn-primary" id="tambahRiwayatKesehatan">Tambah Riwayat Kesehatan</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>

<?php
if (isset($_POST['ubah'])) {

	$harga_with_rp = $_POST['harga'];
	$harga = str_replace(["Rp. ", "."], "", $harga_with_rp);
	$namafoto = $_FILES['foto']['name'];
	$lokasifoto = $_FILES['foto']['tmp_name'];

	if (!empty($lokasifoto)) {
		move_uploaded_file($lokasifoto, "../foto/$namafoto");

		$koneksi->query("UPDATE produk SET namaproduk='$_POST[nama]',id_kategori='$_POST[id_kategori]',hargaproduk='$harga',fotoproduk='$namafoto', deskripsiproduk='$_POST[deskripsi]', stokproduk='$_POST[stok]' WHERE idproduk='$_GET[id]'");
	} else {
		$koneksi->query("UPDATE produk SET namaproduk='$_POST[nama]', id_kategori='$_POST[id_kategori]',hargaproduk='$harga',deskripsiproduk='$_POST[deskripsi]', stokproduk='$_POST[stok]' WHERE idproduk='$_GET[id]'");
	}

	// Menyimpan Riwayat Kesehatan
	$idproduk = $_GET['id'];
	$koneksi->query("DELETE FROM riwayat_kesehatan WHERE idproduk='$idproduk'");
	foreach ($_POST['tanggal'] as $index => $tanggal) {
		$tindakan = $_POST['tindakan'][$index];
		$deskripsi_kesehatan = $_POST['deskripsi_kesehatan'][$index];

		$koneksi->query("INSERT INTO riwayat_kesehatan (idproduk, tanggal, tindakan, deskripsi) VALUES ('$idproduk', '$tanggal', '$tindakan', '$deskripsi_kesehatan')");
	}

	echo "<script>alert('Data Produk Berhasil Diubah');</script>";
	echo "<script>location='index.php?halaman=produk';</script>";
}
?>

<script>
	/* Dengan Rupiah */
	var harga = document.getElementById('harga');
	harga.addEventListener('keyup', function(e) {
		harga.value = formatRupiah(this.value, 'Rp. ');
	});

	/* Fungsi */
	function formatRupiah(angka, prefix) {
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);

		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}

	// Script untuk menambah riwayat kesehatan baru
	document.getElementById('tambahRiwayatKesehatan').addEventListener('click', function() {
		var table = document.getElementById('tabelRiwayatKesehatan').getElementsByTagName('tbody')[0];
		var newRow = table.insertRow();
		var cell1 = newRow.insertCell(0);
		var cell2 = newRow.insertCell(1);
		var cell3 = newRow.insertCell(2);
		var cell4 = newRow.insertCell(3);

		cell1.innerHTML = '<input type="date" name="tanggal[]" class="form-control">';
		cell2.innerHTML = '<input type="text" name="tindakan[]" class="form-control">';
		cell3.innerHTML = '<textarea name="deskripsi_kesehatan[]" class="form-control"></textarea>';
		cell4.innerHTML = '<button type="button" class="btn btn-danger removeRow">Hapus</button>';

		// Event listener untuk tombol hapus
		newRow.querySelector('.removeRow').addEventListener('click', function() {
			this.closest('tr').remove();
		});
	});

	// Event listener untuk tombol hapus pada baris awal
	document.querySelectorAll('.removeRow').forEach(function(button) {
		button.addEventListener('click', function() {
			this.closest('tr').remove();
		});
	});
</script>
