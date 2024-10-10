<div class="row mb-2">
    <div class="col-md-12">
    <div class="card shadow h-80">
                <div class="card-body">
                <h5 style="color: black;">Daftar Pengguna</h5>
                </div>
            </div>
    </div>
</div>
<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card shadow mb-4">
			<div class="card-body">
				<table class="table table-bordered" id="table">
					<thead class="text-white" style="background-color: #B92854;">
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Email</th>
							<th>Telepon</th>
							<th>Alamat</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $nomor = 1; ?>
						<?php $ambil = $koneksi->query("SELECT * FROM pengguna where level = 'Pelanggan'"); ?>
						<?php while ($pecah = $ambil->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $nomor; ?></td>
								<td><?php echo $pecah['nama'] ?></td>
								<td><?php echo $pecah['email'] ?></td>
								<td><?php echo $pecah['telepon'] ?></td>
								<td><?php echo $pecah['alamat'] ?></td>
								<td>
									<a href="index.php?halaman=hapuspengguna&id=<?php echo $pecah['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data ?')">Hapus</a>

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