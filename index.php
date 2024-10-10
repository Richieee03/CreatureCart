<?php
session_start();
include 'koneksi.php';
if (empty($_GET['id'])) {
    $idkategori = 0;
} else {
    $idkategori = $_GET['id'];
    $ambilkategori = $koneksi->query("SELECT * FROM kategori WHERE id_kategori='$idkategori'");
    $kategori = $ambilkategori->fetch_assoc();
}
?>

<?php include 'header.php'; ?>
<div class="hero-wrap d-flex justify-content-center align-items-center" style="background-image: url('foto/bg1.png');" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-12 wrap-about ftco-animate py-5  text-center justify-content-center">
                <div class="heading-section mt-5">
                    <h1 style="color: white;">SELAMAT DATANG DI WEBSITE CREATURE CART
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-6 col-12">
                <img src="foto/home1.png" width="100%">
            </div>
            <div class="col-md-6 col-12 wrap-about pl-md-5 ftco-animate py-5">
                <div class="heading-section">
                    <h3>Tentang Kami</h3>
                    <h1>Creature Cart</h1>
                    <p class="text-justify" style="color:black">
                        Selamat datang di Creature Cart, toko yang menawarkan berbagai macam hewan peliharaan untuk melengkapi hidup Anda dengan keceriaan dan kehangatan. Kami berkomitmen untuk menyediakan beranekaragam hewan mulai dari yang eksotis hingga yang paling familiar, semuanya dipilih dengan cermat untuk memastikan kualitas dan kesejahteraan mereka. Di Creature Cart, kami memahami bahwa setiap hewan memiliki karakteristik unik yang dapat membawa kebahagiaan dan keindahan tersendiri bagi pemiliknya. Dengan pelayanan yang profesional dan ramah, kami siap membantu Anda menemukan hewan peliharaan yang sesuai dengan kebutuhan dan gaya hidup Anda. Terima kasih telah memilih Creature Cart sebagai tempat untuk menemukan sahabat baru. Bersama kami, setiap hari adalah petualangan yang penuh dengan cinta dan kebahagiaan. <br>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include 'footer.php';
?>