<?php
session_start();
include 'koneksi.php';
?>
<?php
$idproduk = $_GET["id"];
$ambil = $koneksi->query("SELECT*FROM produk WHERE idproduk='$idproduk'");
$detail = $ambil->fetch_assoc();
?>
<?php include 'header.php'; ?>
<section style="margin-top: 70px;">
	<div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
		<div class="container">
			<div>
				<div class="wrap-about ftco-animate">
					<div class="heading-section text-center">
						<h1 style="font-size: 40px; font-weight:500;">Riwayat Kesehatan</h1>
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
					<table class="table table-bordered">
						<thead style="background-color: #A73E80; color: white;">
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Tindakan</th>
								<th>Deskripsi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$nomor = 1;
							$ambil = $koneksi->query("SELECT * FROM riwayat_kesehatan WHERE idproduk='$idproduk' ORDER BY tanggal DESC");
							while ($pecah = $ambil->fetch_assoc()) { ?>
								<tr style="color: black;">
									<td><?php echo $nomor; ?></td>
									<td><?php echo date('d-m-Y', strtotime($pecah['tanggal'])); ?></td>
									<td><?php echo $pecah['tindakan']; ?></td>
									<td><?php echo $pecah['deskripsi']; ?></td>
								</tr>
								<?php $nomor++; ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<div style="padding-top:250px">
	<?php
	include 'footer.php';
	?>
</div>
