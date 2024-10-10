<div class="row mb-2">
	<div class="col-md-12">
		<div class="card shadow h-80">
			<div class="card-body">
				<h5 style="color: black;">Daftar Pembelian</h5>
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
							<th>Tanggal</th>
							<th>Nama Transaksi</th>
							<th>Pelanggan</th>
							<th>Total Pembelian</th>
							<th>Status Belanja</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $nomor = 1; ?>
						<?php $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pengguna ON pembelian.id=pengguna.id where statusbeli != 'Belum Bayar'  order by pembelian.tanggalbeli desc, pembelian.idbeli desc"); ?>
						<?php while ($pecah = $ambil->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $nomor; ?></td>
								<td><?= tanggal(date('Y-m-d', strtotime($pecah['tanggalbeli']))) ?></td>
								<td>
									<ul>
										<?php $ambilproduk = $koneksi->query("SELECT * FROM pembelianproduk join produk on pembelianproduk.idproduk = produk.idproduk where idbeli='$pecah[idbeli]'");
										while ($produk = $ambilproduk->fetch_assoc()) { ?>
											<li>
												<?= $produk['namaproduk'] ?> x <?= $produk['jumlah'] ?>
											</li>
										<?php } ?>
									</ul>
								</td>
								<td><?php echo $pecah['nama'] ?></td>
								<td>Rp. <?php echo number_format($pecah['totalbeli'] + $pecah['ongkir']) ?></td>
								<td>
									<?php echo $pecah['statusbeli'] ?>
									<?php if ($pecah['statusbeli'] == "Pesanan Di Tolak") { ?>
										<br>
										<br>
										Alasan Di Tolak : <?= $pecah['catatanditolak'] ?>
									<?php } ?>
								</td>
								<td>
									<a href="index.php?halaman=pembayaran&id=<?php echo $pecah['idbeli'] ?>" class="btn btn-info m-1">Detail</a>
									<a href="index.php?halaman=pembayaranhapus&id=<?php echo $pecah['idbeli'] ?>" class="btn btn-danger m-1" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?')">Hapus</a>
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