<div class="row mb-2">
	<div class="col-md-12">
		<div class="card shadow h-80">
			<div class="card-body">
				<h5 style="color: black;">Daftar Kategori</h5>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<a href="index.php?halaman=tambahkategori" class="btn btn-sm btn-primary shadow-sm float-right pull-right"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Kategori</a>
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="table">
					<thead class="text-white" style="background-color: #B92854;">
						<tr>
							<th>No</th>
							<th>Kategori</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $nomor = 1; ?>

						<?php $ambil = $koneksi->query("SELECT * FROM kategori"); ?>
						<?php while ($data = $ambil->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $nomor ?></td>
								<td><?php echo $data["nama_kategori"] ?></td>
								<td>
									<a href="index.php?halaman=ubahkategori&id=<?php echo $data['id_kategori']; ?>" class="btn btn-success btn-sm">Ubah</a>
									<a href="index.php?halaman=hapuskategori&id=<?php echo $data['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data ?')">Hapus</a>
								</td>

							</tr>
							<?php $nomor++; ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>