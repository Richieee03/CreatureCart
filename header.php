 <?php
  include 'koneksi.php';
  $datakategori = array();
  $ambil = $koneksi->query("SELECT * FROM kategori");
  while ($tiap = $ambil->fetch_assoc()) {
    $datakategori[] = $tiap;
  }
  function rupiah($rp)
  {
    $jumlah = number_format($rp, 0, ",", ".");
    $rupiah = "Rp. " . $jumlah;

    return $rupiah;
  }
  function tanggal($tgl)
  {
    $tanggal = substr($tgl, 8, 2);
    $bulan = getBulan(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
  }
  function getBulan($bln)
  {
    switch ($bln) {
      case 1:
        return "Januari";
        break;
      case 2:
        return "Februari";
        break;
      case 3:
        return "Maret";
        break;
      case 4:
        return "April";
        break;
      case 5:
        return "Mei";
        break;
      case 6:
        return "Juni";
        break;
      case 7:
        return "Juli";
        break;
      case 8:
        return "Agustus";
        break;
      case 9:
        return "September";
        break;
      case 10:
        return "Oktober";
        break;
      case 11:
        return "November";
        break;
      case 12:
        return "Desember";
        break;
    }
  }
  ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
   <title>Creature Cart</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="home/css/animate.css">
   <link rel="stylesheet" href="home/css/owl.carousel.min.css">
   <link rel="stylesheet" href="home/css/owl.theme.default.min.css">
   <link rel="stylesheet" href="home/css/magnific-popup.css">
   <link rel="stylesheet" href="home/css/flaticon.css">
   <link rel="stylesheet" href="home/css/style.css">
   <link rel="icon" type="image/x-icon" href="foto/logo1.png">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
   <style>
     .dropdown-item:hover {
       color: black !important;
     }
   </style>
 </head>

 <body>
   <nav class="navbar navbar-expand-lg navbar-danger ftco_navbar ftco-navbar-light" id="ftco-navbar" style="background-color: #961200 !important;">
     <div class="container">
       <a href="index.php" style="color: black;"> <img src="foto/logo1.png" width="60px">&nbsp;<span class="text-black">&nbsp;</span></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
         <i class="fa fa-list" style="color: black;"></i>
       </button>

       <div class="collapse navbar-collapse" id="ftco-nav">
         <ul class="navbar-nav">
           <li class="nav-item active"><a href="index.php" class="nav-link" style="color: white;">Home</a></li>
           <li class="nav-item active"><a href="produk.php" class="nav-link" style="color: white;">Daftar Produk</a></li>
           <li class="nav-item active dropdown">
             <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">Kategori</a>
             <div class="dropdown-menu" aria-labelledby="dropdown03">
               <?php foreach ($datakategori as $key => $value) : ?>
                 <a href="kategori.php?id=<?php echo $value["id_kategori"] ?>" class="dropdown-item"><?php echo $value["nama_kategori"] ?></a>
               <?php endforeach; ?>
             </div>
           </li>
           <?php if (isset($_SESSION["pengguna"])) { ?>
             <li class="nav-item active"><a href="riwayat.php" class="nav-link" style="color: white;">Riwayat Transaksi</a></li>
           <?php } ?>
         </ul>

         <ul class="navbar-nav ml-auto">
           <?php if (isset($_SESSION["pengguna"])) { ?>
             <?php
              $id = $_SESSION["pengguna"]['id'];
              $ambil = $koneksi->query("SELECT * FROM pengguna WHERE id='$id'");
              $pecah = $ambil->fetch_assoc(); ?>
             <li class="nav-item active"><a href="keranjang.php" class="nav-link"><i class="fa fa-shopping-cart" style="color: white;"></i></a></li>
             <li class="nav-item active dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;"><img src="foto/profil.png" alt="" style="width: 30px;"></a>
               <div class="dropdown-menu" aria-labelledby="dropdown03">
                 <a href="akun.php" class="dropdown-item">Profil Akun</a>
                 <a href="logout.php" class="dropdown-item">Logout</a>
               </div>
             </li>
           <?php } else { ?>
             <li class="nav-item active"><a href="daftar.php" class="nav-link" style="color: white;">Daftar</a></li>
             <li class="nav-item active"><a href="login.php" class="nav-link" style="color: white;">Login</a></li>
           <?php } ?>
         </ul>

       </div>
     </div>
   </nav>