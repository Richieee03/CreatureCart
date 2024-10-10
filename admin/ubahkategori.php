<?php
$ambil = $koneksi->query("SELECT * FROM kategori WHERE id_kategori='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
?>
<div class="row mb-2">
	<div class="col-md-12">
		<div class="card shadow h-80">
			<div class="card-body">
				<h5 style="color: black;">Ubah Kategori</h5>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card shadow mb-4">
			<div class="card-body">
				<form method="post">
					<div class="form-group">
						<label>Nama Kategori</label>
						<input type="text" class="form-control" name="kategori" value="<?php echo $pecah['nama_kategori']; ?>">
					</div>
					<button class="btn btn-primary" name="ubah">Simpan</button>
				</form>

			</div>
		</div>
	</div>
</div>
<?php
if (isset($_POST['ubah'])) {
	$koneksi->query("UPDATE kategori SET nama_kategori='$_POST[kategori]' WHERE id_kategori='$_GET[id]'");
	echo "<script>alert('Kategori Berhasil Di Ubah');</script>";
	echo "<script> location ='index.php?halaman=kategori';</script>";
}
?>