<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["pengguna"])) {
    echo "<script> alert('Harap login terlebih dahulu');</script>";
    echo "<script> location ='login.php';</script>";
}
$id = $_SESSION["pengguna"]["id"];
?>
<?php
$id = $_SESSION["pengguna"]['id'];
$ambil = $koneksi->query("SELECT *FROM pengguna WHERE id='$id'");
$pecah = $ambil->fetch_assoc();
$idpengguna = $pecah['id'];
?>
<?php include 'header.php'; ?>
<section style="margin-top: 70px;">
    <div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
        <div class="container">
            <div>
                <div class="wrap-about ftco-animate">
                    <div class="heading-section text-center">
                        <h1 style="font-size: 40px; font-weight:500;">Profil Akun</h1>
                        <p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Profil Akun</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <form method="post" enctype="multipart/form-data">
            <div class="container mt-4">
                <div class="d-flex align-items-center text-white" style="background-color: #A73E80; padding: 10px 10px;">
                    <p class="mb-0"><img src="foto/co.png" alt=""> Edit Profil</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                if ($pecah['fotoprofil'] != "") { ?>
                                    <center>
                                        <img src="foto/<?= $pecah['fotoprofil'] ?>" width="150px" alt="">
                                    </center>
                                <?php } ?>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input value="<?php echo $pecah['nama']; ?>" type="text" value="" class="form-control" name="nama">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input value="<?php echo $pecah['email']; ?>" type="email" class="form-control" name="email" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input value="<?php echo $pecah['telepon']; ?>" type="number" class="form-control" name="telepon">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alamat</label>
                                    <input type="hidden" value="<?= $pecah['idalamat'] ?>" name="idalamat">
                                    <textarea class="form-control" id="alamat" name="alamat" rows="5" required><?= $pecah['alamat'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="text" class="form-control" name="password">
                                    <input type="hidden" class="form-control" name="passwordlama" value="<?php echo $pecah['password']; ?>">
                                    <span class="text-primary">Kosongkan Password jika tidak ingin mengganti</span>
                                </div>
                                <button class="btn btn-success float-right pull-right" name="ubah"><i class="glyphicon glyphicon-saved"></i>Simpan</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
</section>
<br><br>
<?php
if (isset($_POST['ubah'])) {
    if ($_POST['password'] == "") {
        $password = $_POST['passwordlama'];
    } else {
        $password = $_POST['password'];
    }
    $namafoto = $_FILES['fotoprofil']['name'];
    $lokasifoto = $_FILES['fotoprofil']['tmp_name'];
    if (!empty($lokasifoto)) {
        move_uploaded_file($lokasifoto, "foto/$namafoto");
        $fotoprofil = $namafoto;
    } else {
        $fotoprofil = $pecah['fotoprofil'];
    }
    $koneksi->query("UPDATE pengguna SET password='$password',nama='$_POST[nama]', email='$_POST[email]',telepon='$_POST[telepon]', alamat='$_POST[alamat]', fotoprofil='$fotoprofil' WHERE id='$id'") or die(mysqli_error($koneksi));
    echo "<script>alert('Profil Berhasil Di Ubah');</script>";
    echo "<script>location='akun.php';</script>";
}
include 'footer.php';
?>