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
                        <h1 style="font-size: 40px; font-weight:500;">Daftar</h1>
                        <p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Daftar</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4 mb-4">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-6">
                <h1>Daftar Akun</h1>
                <p>Sudah punya akun? <a href="login.php" style="color: black;">Masuk disini!</a></p>
                <form method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label">Nama Anda</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input type="text" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">No HP</label>
                        <input type="text" name="telepon" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Alamat</label>
                        <textarea class="form-control" name="alamat" required></textarea>
                    </div>
                    <div class="form-group ">
                        <br>
                        <button class="btn btn-primary btn-block" name="daftar" style="height: 60px; border-radius:10px;">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
if (isset($_POST["daftar"])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $ambil = $koneksi->query("SELECT * FROM pengguna WHERE email='$email'");
    $yangcocok = $ambil->num_rows;
    if ($yangcocok == 1) {
        echo "<script>alert('Pendaftaran Gagal, email sudah ada')</script>";
        echo "<script>location='daftar.php';</script>";
    } else {
        $koneksi->query("INSERT INTO pengguna(nama, email, password, telepon, alamat, level)
                                VALUES('$nama','$email','$password','$telepon','$alamat','Pelanggan')");

        echo "<script>alert('Pendaftaran Berhasil')</script>";
        echo "<script>location='login.php';</script>";
    }
}
?>
<?php
include 'footer.php';
?>