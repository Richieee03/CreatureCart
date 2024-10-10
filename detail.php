<?php
session_start();
include 'koneksi.php';
?>
<?php
$idproduk = $_GET["id"];
$ambil = $koneksi->query("SELECT*FROM produk WHERE idproduk='$idproduk'");
$detail = $ambil->fetch_assoc();
$kategori = $detail["id_kategori"];
$idkategori = $kategori;

if (isset($_POST["submit_diskusi"])) {
    $id_produk = $_GET["id"]; // Sesuaikan dengan cara mendapatkan ID produk dari URL atau sesuai kebutuhan
    $id_pengguna = $_SESSION["pengguna"]['id']; // Ambil ID pengguna dari session, asumsikan pengguna sudah login
    $diskusi = mysqli_real_escape_string($koneksi, $_POST['diskusi']); // Melakukan sanitasi input

    // Query untuk menyimpan diskusi ke dalam database
    $query_insert = "INSERT INTO diskusi (id_produk, id_pengguna, diskusi, waktu) 
                     VALUES ('$id_produk', '$id_pengguna', '$diskusi', NOW())";
    $result_insert = $koneksi->query($query_insert);

    if ($result_insert) {
        echo "<script>alert('diskusi berhasil disimpan');</script>";
        echo "<script>window.location.href = 'detail.php?id=$id_produk';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan diskusi');</script>";
    }
}
?>
<?php include 'header.php'; ?>
<section style="margin-top: 70px;">
	<div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
		<div class="container">
			<div>
				<div class="wrap-about ftco-animate">
					<div class="heading-section text-center">
						<h1 style="font-size: 40px; font-weight:500;">Detail Produk</h1>
						<p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Detail Produk</p>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div class="container mt-5 mb-5">
		<div class="row">
			<div class="col-md-12 col-12">
				<div class="row">
					<div class="col-lg-6 mb-5 ftco-animate">
						<a href="foto/<?php echo $detail["fotoproduk"]; ?>" class="image-popup prod-img-bg"><img src="foto/<?php echo $detail["fotoproduk"]; ?>" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" alt="Colorlib Template"></a>
					</div>
					<div class="col-lg-6 pl-md-5 ftco-animate">
						<h3><?php echo $detail["namaproduk"] ?></h3>
						<!-- <h5><span><?php echo rupiah($detail["hargaproduk"]); ?></span></h5> -->
						<p><br><?php echo $detail["deskripsiproduk"]; ?></p>
						<?php
						if (isset($_SESSION["pengguna"])) { ?>
							<?php
							$id = $_SESSION["pengguna"]['id'];
							$ambil = $koneksi->query("SELECT *FROM pengguna WHERE id='$id'");
							$pecah = $ambil->fetch_assoc(); ?>
							<div class="row mt-4">
								<div class="w-100"></div>
								<div class="col-md-12">
									<!-- <p style="color: #000;">Sisa Produk : <?php echo number_format($detail["stokproduk"]); ?></p> -->
								</div>
							</div>
							<form method="post">
								<div class="form-group">
									<label>Jumlah</label>
									<div class="row">
										<div class="col-md-12 col-6 my-auto">
											<input type="number" placeholder="QTY" min="1" value="1" class="form-control" name="jumlah" max="<?php echo number_format($detail["stokproduk"]); ?>" required></input>
										</div>
										<div class="col-md-12 col-6 my-auto">
											<button class="btn btn-danger btn-lg text-white float-right mt-4" name="beli"><i class="fa fa-shopping-cart"></i> Beli Sekarang</button>
											<a href="riwayatkesehatan.php?id=<?php echo $detail['idproduk']; ?>" class="btn btn-success btn-lg text-white float-right mt-4 mr-2">Lihat Riwayat Kesehatan</a>
										</div>
									</div>
								</div>
							</form>
						<?php } ?>
						<?php
						if (isset($_POST["beli"])) {
							$jumlah = $_POST["jumlah"];

							// Periksa stok produk sebelum menambahkannya ke keranjang
							if ($jumlah <= $detail["stokproduk"]) {
								$idproduk = $_GET["id"];
								$_SESSION["keranjang"][$idproduk] = $jumlah;
								echo "<script> alert('Produk Masuk Ke Keranjang');</script>";
								echo "<script> location ='keranjang.php';</script>";
							} else {
								echo "<script> alert('Maaf, stok produk tidak mencukupi');</script>";
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-12">
                <h4>Forum Tanya Jawab</h4>
                <form method="post">
                    <div class="form-group">
                        <label for="diskusi">Tulis diskusi Anda Disini</label>
                        <textarea class="form-control" id="diskusi" name="diskusi" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="submit_diskusi" class="btn btn-primary float-right">Simpan</button>
                </form>
            </div>
        </div>
    </div>

	<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-12">
            <?php
            // Ambil diskusi dan jawaban dari database
            $id_produk = $_GET["id"];
            $query_diskusi = "SELECT diskusi.*, pengguna.nama, pengguna.email 
                                FROM diskusi 
                                INNER JOIN pengguna ON diskusi.id_pengguna = pengguna.id 
                                WHERE diskusi.id_produk = $id_produk 
                                ORDER BY diskusi.waktu ASC";
            $result_diskusi = $koneksi->query($query_diskusi);

            if ($result_diskusi->num_rows > 0) {
                while ($row = $result_diskusi->fetch_assoc()) {
                    $id_diskusi = $row["id_diskusi"];
                    $nama_pengguna = $row["nama"];
                    $email_pengguna = $row["email"];
                    $diskusi = $row["diskusi"];
                    $waktu = $row["waktu"];

                    echo "<div class='card mt-3'>";
                    echo "<div class='card-body d-flex'>";
                    
                    // Foto Profil
                    echo "<div class='mr-3'>";
                    echo "<img src='foto/{$pecah['fotoprofil']}' alt='Foto Profil' style='width: 100px; height: 100px; object-fit: cover;'>";
                    echo "</div>";

                    // Informasi Nama, Email, dan diskusi
                    echo "<div>";
                    echo "<h5 class='card-title'>$nama_pengguna</h5>";
                    echo "<p class='card-text text-primary'>$email_pengguna</p>";
                    echo "<p class='card-text'>$diskusi</p>";
                    echo "</div>";

                    // Tanggal dan Status
                    echo "<div class='ml-auto text-right'>";
                    echo "<p class='small text-muted mb-1'>$waktu</p>";
                    echo "</div>";

                    echo "</div>"; // card-body
                    echo "</div>"; // card
                }
            } else {
                echo "<p>Belum ada diskusi untuk produk ini.</p>";
            }
            ?>
        </div>
    </div>
</div>


</section>


<?php
include 'footer.php';
?>