<?php
session_start();
include 'koneksi.php';
if (isset($_GET["id"])) {
	$id = $_GET["id"];
	$koneksi->query("UPDATE pengguna SET statusaktif='Aktif' WHERE id='$id'") or die(mysqli_error($conn));
	echo "<script>alert('Email anda berhasil diverifikasi, silahkan login');</script>";
	echo "<script>location='login.php';</script>";
}
?>
<?php include 'header.php'; ?>
<section style="margin-top: 70px;">
	<div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
		<div class="container">
			<div>
				<div class="wrap-about ftco-animate">
					<div class="heading-section text-center">
						<h1 style="font-size: 40px; font-weight:500;">Masuk</h1>
						<p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Masuk</p>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="container mt-4">
		<div class="row justify-content-center">
			<div class="col-md-8 mb-5">
				<h1 class="mt-5">Masuk</h1>
				<p>Belum punya akun? <a href="login.php" style="color: black;">Daftar disini!</a></p>
				<form method="post">
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="password">
					</div>
					<br>
					<button class="btn btn-block" style="background-color: #3563E9; color:#fff;height: 60px; border-radius:10px;" name="simpan">Login</button>
				</form>
				<div style=" display: flex; align-items: center;">
					<hr style="flex: 1;border: none;border-top: 1px solid #CBD5E0;margin: 0 10px;">
					<span class="py-3">OR</span>
					<hr style="flex: 1;border: none;border-top: 1px solid #CBD5E0;margin: 0 10px;">
				</div>
				<a href="loginadmin.php"><button class="btn btn-block" style="border: 2px solid #CBD5E0; color:#67728A;height: 60px; border-radius:10px;">Login Sebagai Admin</button></a>
			</div>
		</div>
	</div>
</section>
<?php
if (isset($_POST["simpan"])) {
	$email = $_POST["email"];
	$password = $_POST["password"];
	$ambil = $koneksi->query("SELECT * FROM pengguna
		WHERE email='$email' AND password='$password' limit 1");
	$akunyangcocok = $ambil->num_rows;
	if ($akunyangcocok == 1) {
		$akun = $ambil->fetch_assoc(); {
			if ($akun['level'] == "Pelanggan") {
				$_SESSION["pengguna"] = $akun;
				echo "<script> alert('Anda sukses login');</script>";
				echo "<script> location ='index.php';</script>";
			} elseif ($akun['level'] == "Admin") {
				$_SESSION['admin'] = $akun;
				echo "<script> alert('Anda sukses login');</script>";
				echo "<script> location ='admin/index.php';</script>";
			}
		}
	} else {
		echo "<script> alert('Anda gagal login, Cek akun anda');</script>";
		echo "<script> location ='login.php';</script>";
	}
}
?>
<?php
include 'footer.php';
?>