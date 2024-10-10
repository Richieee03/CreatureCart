<?php
session_start();
include 'koneksi.php';
?>
<?php include 'header.php'; ?>
<section style="margin-top: 70px;">
	<div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
		<div class="container">
			<div>
				<div class="wrap-about ftco-animate">
					<div class="heading-section text-center">
						<h1 style="font-size: 40px; font-weight:500;">Keranjang</h1>
						<p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Keranjang</p>
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
								<th>Produk</th>
								<th>Foto Produk</th>
								<th>Harga</th>
								<th>Jumlah Beli</th>
								<th>Total Harga</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $nomor = 1; ?>
							<?php if (!empty($_SESSION["keranjang"])) { ?>
								<?php foreach ($_SESSION["keranjang"] as $idproduk => $jumlah) : ?>
									<?php
									$ambil = $koneksi->query("SELECT * FROM produk 
								WHERE idproduk='$idproduk'");
									$pecah = $ambil->fetch_assoc();
									$totalharga = $pecah["hargaproduk"] * $jumlah;
									?>
									<tr class="text-center" style="color: black;">
										<td><?php echo $nomor; ?></td>
										<td><?php echo $pecah['namaproduk']; ?></td>
										<td class="image-prod">
											<img src="foto/<?php echo $pecah["fotoproduk"]; ?>" width="100px" style="border-radius: 10px;">
										</td>
										<td><?php echo rupiah($pecah['hargaproduk']); ?></td>
										<td><?php echo $jumlah; ?></td>
										<td><?php echo rupiah($totalharga); ?></td>
										<td>
											<a href="hapuskeranjang.php?id=<?php echo $idproduk ?>" class="btn btn-danger btn-xs">Hapus</a>
										</td>
									</tr>
									<?php $nomor++; ?>
							<?php endforeach;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br><br>
		<div class="row justify-content-center">
			<a href="produk.php" class="btn btn-primary">Lanjutkan Belanja</a>
			&nbsp;<a href="checkout.php" class="btn btn-danger">Checkout</a>
		</div>
		<br><br>
	</div>
</section>

<?php
include 'footer.php';
?>