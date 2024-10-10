<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["pengguna"])) {
	echo "<script> alert('Anda belum login');</script>";
	echo "<script> location ='login.php';</script>";
}
?>
<?php include 'header.php'; ?>
<section style="margin-top: 70px;">
	<div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
		<div class="container">
			<div>
				<div class="wrap-about ftco-animate">
					<div class="heading-section text-center">
						<h1 style="font-size: 40px; font-weight:500;">Riwayat</h1>
						<p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Riwayat</p>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="container mt-5">
		<div class="row">
			<div class="col-md-12 ftco-animate">
				<div class="cart-list">
					<table class="table">
						<thead style="background-color: #A73E80;">
							<tr class="text-center">
								<th>No</th>
								<th>Daftar</th>
								<th>Tanggal</th>
								<th>Total</th>
								<th>Opsi</th>
								<th>Bukti Pembayaran</th>
							</tr>
						</thead>
						<tbody>
							<?php $nomor = 1;
							$id = $_SESSION["pengguna"]['id'];
							$ambil = $koneksi->query("SELECT *, pembayaran.bukti as bukti, pembelian.idbeli as idbelireal FROM pembelian left join pembayaran on pembelian.idbeli = pembayaran.idbeli WHERE pembelian.id='$id' order by pembelian.tanggalbeli desc, pembelian.idbeli desc");
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
									<td><?php echo tanggal($pecah['tanggalbeli']) . '<br>Jam ' . date('H:i', strtotime($pecah['waktu'])) ?></td>
									<td><?php echo rupiah($pecah["totalbeli"] + $pecah["ongkir"]); ?></td>
									<td>
										<?php if ($pecah['statusbeli'] == "Belum Bayar") {
											$deadline = date('Y-m-d H:i', strtotime($pecah['waktu'] . ' +1 day'));
											$harideadline = date('Y-m-d', strtotime($pecah['waktu'] . ' +1 day'));
											$jamdeadline = date('H:i', strtotime($pecah['waktu'] . ' +1 day'));
											if (date('Y-m-d H:i') >= $deadline) {
												echo 'Waktu pembayaran<br>telah habis';
											} else { ?>
												<a href="pembayaran.php?id=<?php echo $pecah["idbelireal"] ?>" class="btn text-white" style="background-color: red;">Upload Bukti Pembayaran</a>
											<?php }
										} elseif ($pecah['statusbeli'] == "Sudah Upload Bukti Pembayaran") { ?>
											<a class="btn btn-warning text-white">Menunggu Konfirmasi Admin</a>
										<?php
										} elseif ($pecah['statusbeli'] == "Pesanan Sedang Di Proses") { ?>
											<a class="btn btn-info text-white">Pesanan Sedang Di Proses</a>
										<?php } elseif ($pecah['statusbeli'] == "Pesanan Di Kirim") { ?>
											<a class="btn btn-success text-white">Barang Dikirim</a>
											<?php
											if ($pecah['resipengiriman'] != "") { ?>
												<br><br>
												<p><a target="_blank" href="https://cekresi.com">No Resi : <?= $pecah['resipengiriman'] ?></a></p>
											<?php } ?>
										<?php } elseif ($pecah['statusbeli'] == "Pesanan Telah Sampai ke Pemesan") { ?>
											<a data-toggle="modal" data-target="#selesai<?= $nomor ?>" class="btn btn-success text-white">Konfirmasi Selesai</a>
										<?php } elseif ($pecah['statusbeli'] == "Selesai") { ?>
											<a class="btn btn-success text-white">Selesai</a>
										<?php } elseif ($pecah['statusbeli'] == "Pesanan Di Tolak") { ?>
											<a class="btn btn-danger text-white">Pesanan Anda Di Tolak</a>
											<br>
											<br>
											Alasan Di Tolak : <?= $pecah['catatanditolak'] ?>
										<?php } ?>
									</td>
									<td class="text-center"><img src="foto/<?php echo $pecah['bukti'] ?>" alt="" style="width: 50%;"></td>
									<?php $nomor++; ?>
								<?php  } ?>
								</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
$no = 1;
$id = $_SESSION["pengguna"]['id'];
$ambil = $koneksi->query("SELECT *, pembelian.idbeli as idbelireal FROM pembelian left join pembayaran on pembelian.idbeli = pembayaran.idbeli WHERE pembelian.id='$id' order by pembelian.tanggalbeli desc, pembelian.idbeli desc");
while ($pecah = $ambil->fetch_assoc()) { ?>
	<div class="modal fade" id="selesai<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pesanan Selesai</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<h5>Apakah anda yakin ingin mengkonfirmasi pesanan telah selesai ?</h5>
					</div>
					<div class="modal-footer">
						<input type="hidden" class="form-contol" value="<?= $pecah['idbeli'] ?>" name="idbeli">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" name="selesai" value="selesai" class="btn btn-danger">Konfirmasi</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	$no++;
} ?>
<?php
if (isset($_POST["selesai"])) {
	$koneksi->query("UPDATE pembelian SET statusbeli='Selesai'
		WHERE idbeli='$_POST[idbeli]'");
	echo "<script>alert('Pesanan berhasil di konfirmasi selesai')</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>
<div style="padding-top:250px">
	<?php
	include 'footer.php';
	?>