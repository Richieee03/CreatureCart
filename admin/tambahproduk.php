<?php
$datakategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
	$datakategori[] = $tiap;
}
?>
<div class="row mb-2">
	<div class="col-md-12">
		<div class="card shadow h-80">
			<div class="card-body">
				<h5 style="color: black;">Tambah Produk</h5>
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
						<label>Nama</label>
						<input type="text" class="form-control" name="nama">
					</div>

					<div class="form-group">
						<label>Nama Kategori</label>
						<select class="form-control" name="id_kategori">
							<option value="">Pilih Kategori</option>
							<?php foreach ($datakategori as $key => $value) : ?>

								<option value="<?php echo $value["id_kategori"] ?>"><?php echo $value["nama_kategori"] ?></option>

							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group">
						<label>Harga (Rp)</label>
						<input type="text" class="form-control" name="harga" id="harga">
					</div>
					<div class="form-group">
						<label>Keterangan</label>
						<select name="deskripsi" class="form-control" id="">
							<option value="Tersedia">Tersedia</option>
							<option value="Tidak Tersedia">Tidak Tersedia</option>
						</select>
					</div>
					<div class="form-group">
						<label>Stok </label>
						<input type="number" class="form-control" name="stok">
					</div>
					<div class="form-group">
						<label>Foto</label>
						<div class="letak-input" style="margin-bottom: 10px;">
							<input type="file" class="form-control" name="foto">
						</div>
					</div>

					<button class="btn btn-primary" name="save"><i class="glyphicon glyphicon-saved"></i>Simpan</a></button>

				</form>
			</div>
		</div>
	</div>
</div>

<?php
if (isset($_POST['save'])) {



	$harga_with_rp = $_POST['harga'];
	$harga = str_replace(["Rp. ", "."], "", $harga_with_rp);
	// echo $harga;
	$namafoto = $_FILES['foto']['name'];
	$lokasifoto = $_FILES['foto']['tmp_name'];
	move_uploaded_file($lokasifoto, "../foto/" . $namafoto);
	$koneksi->query("INSERT INTO produk
		(namaproduk,id_kategori, hargaproduk,fotoproduk,deskripsiproduk, stokproduk)
		VALUES('$_POST[nama]','$_POST[id_kategori]','$harga','$namafoto','$_POST[deskripsi]','$_POST[stok]')");
	$idproduk_barusan = $koneksi->insert_id;
	echo "<script>alert('Produk Berhasil Di Simpan');</script>";
	echo "<script> location ='index.php?halaman=produk';</script>";
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
</script>