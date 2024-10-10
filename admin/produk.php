<div class="row mb-2">
	<div class="col-md-12">
		<div class="card shadow h-80">
			<div class="card-body">
				<h5 style="color: black;">Daftar Produk</h5>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<a href="index.php?halaman=tambahproduk" class="btn btn-sm btn-primary shadow-sm float-right pull-right"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk</a>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped" id="table">
					<thead class="text-white" style="background-color: #B92854;">
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Harga</th>
							<th>Stok</th>
							<th>Foto</th>
							<th>Kategori</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $nomor = 1; ?>
						<?php $ambil = $koneksi->query("SELECT*FROM produk LEFT JOIN kategori ON produk.id_kategori=kategori.id_kategori"); ?>
						<?php while ($pecah = $ambil->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $nomor; ?></td>
								<td><?php echo $pecah['namaproduk'] ?></td>
								<td><?php echo rupiah($pecah['hargaproduk']) ?></td>
								<td><?php echo $pecah['stokproduk'] ?></td>
								<td>
									<img src="../foto/<?php echo $pecah['fotoproduk'] ?>" width="100px">
								</td>
								<td><?php echo $pecah['nama_kategori'] ?></td>
								<td>
									<a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['idproduk']; ?>" class="btn btn-success">Ubah</a>
									<a href="index.php?halaman=hapusproduk&id=<?php echo $pecah['idproduk']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data ?')">Hapus</a>
									<a href="index.php?halaman=diskusi&id=<?php echo $pecah['idproduk']; ?>" class="btn btn-primary">Diskusi</a>
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