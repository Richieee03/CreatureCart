<div class="row mb-2">
    <div class="col-md-12">
    <div class="card shadow h-80">
                <div class="card-body">
                <h5 style="color: black;">Tambah Kategori</h5>
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
						<input type="text" class="form-control" name="kategori">
					</div>
					<button class="btn btn-primary" name="tambah">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
if (isset($_POST['tambah'])) {
	$kategori = $_POST["kategori"];

	$koneksi->query("INSERT INTO kategori(nama_kategori)
		VALUES ('$kategori')");
	echo "<script> alert('Kategori Berhasil Di Tambah');</script>";
	echo "<script> location ='index.php?halaman=kategori';</script>";
}
?>