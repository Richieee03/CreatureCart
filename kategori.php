<?php
session_start();
include 'koneksi.php';

?>

<?php include 'header.php';
$kategori = $_GET["id"];


$semuadata = array();
$ambil = $koneksi->query("SELECT*FROM produk WHERE id_kategori LIKE '%$kategori%'");
while ($pecah = $ambil->fetch_assoc()) {
	$semuadata[] = $pecah;
}
?>
<?php
$datakategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
	$datakategori[] = $tiap;
}
?>
<?php $am = $koneksi->query("SELECT * FROM kategori where id_kategori='$kategori'");
$pe = $am->fetch_assoc()
?>
<section style="margin-top: 70px;">
	<div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
		<div class="container">
			<div>
				<div class="wrap-about ftco-animate">
					<div class="heading-section text-center">
						<h1 style="font-size: 40px; font-weight:500;">Kategori</h1>
						<p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Daftar Produk <img src="foto/arrow.png" alt=""> Kategori <?php echo $pe["nama_kategori"] ?></p>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="container mt-5">
		<div class="row mb-3 pb-3 justify-content-center">
			<div class="col-md-12 heading-section ftco-animate">
				<?php if (empty($semuadata)) : ?>
					<div class="alert alert-danger">Produk <strong><?php echo  $pe["nama_kategori"] ?></strong> Kosong</div>
				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row justify-content-center">
			<?php foreach ($semuadata as $key => $perproduk) : ?>
				<div class="col-md-4 d-flex">
					<div class="product ftco-animate bg-white">
						<div class="img d-flex align-items-center justify-content-center" style="background-image: url('foto/<?php echo $perproduk['fotoproduk'] ?>');height:250px">
							<div class="desc">
								<p class="meta-prod d-flex">
									<a href="detail.php?id=<?php echo $perproduk['idproduk']; ?>" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
								</p>
							</div>
						</div>
						<div class="text">
							<h2><?php echo $perproduk['namaproduk'] ?></h2>
							<h5 class="text-right"><?= rupiah($perproduk['hargaproduk']) ?></h5>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</section>

<?php
include 'footer.php';
?>