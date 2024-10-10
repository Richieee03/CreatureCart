<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');</script>";
    echo "<script>location='../login.php';</script>";
    exit();
}
function rupiah($angka)
{
    if ($angka != "") {
        $angkafix = $angka;
    } else {
        $angkafix = 0;
    }
    $hasilrupiah = "Rp " . number_format($angkafix, 2, ',', '.');
    return $hasilrupiah;
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
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Creature Cart - Admin</title>
    <link href="css/css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/css//sb-admin-2.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link href="css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="assets/ckeditor/ckeditor.js"></script>
    <link rel="icon" type="image/x-icon" href="../foto/logo2.png">
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: 	#961200;">
            <a class="sidebar-brand d-flex align-items-center justify-content-center text-white" href="index.php?halaman=beranda">
                <div class="sidebar-brand-text mx-3">Halaman</sup></div>
            </a>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?halaman=beranda">
                    <i class="fas fa-fw fa-book text-white"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?halaman=kategori">
                    <i class="fas fa-fw fa-list text-white"></i>
                    <span>Kategori</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?halaman=produk">
                    <i class="fas fa-fw fa-pen text-white"></i>
                    <span>Daftar Produk</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?halaman=pembelian">
                    <i class="fas fa-fw fa-home text-white"></i>
                    <span>Daftar Transaksi</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?halaman=pengguna">
                    <i class="fas fa-fw fa-users text-white"></i>
                    <span>Data Akun User</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?halaman=diskusi">
                    <i class="fas fa-fw fa-question text-white"></i>
                    <span>Diskusi</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link text-white" href="logout.php" onclick="return confirm('Apakah Anda Yakin Ingin Keluar ?');">
                    <i class="fas fa-fw fa-power-off text-white"></i>
                    <span>Logout</span></a>
            </li>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
                    <a href="#" class="sidebar-toggler flex-shrink-0">
                        <i class="fa fa-bars" style="color: white;"></i>
                    </a>
                    <h5 class="navbar-nav ml-2 text-dark">Dashboard</h5>
                </nav>
                <div class="container-fluid">
                    <div id="page-inner">
                        <?php
                        if (isset($_GET['halaman'])) {
                            if ($_GET['halaman'] == "produk") {
                                include 'produk.php';
                            } elseif ($_GET['halaman'] == "pembelian") {
                                include 'pembelian.php';
                            } elseif ($_GET['halaman'] == "pengguna") {
                                include 'pengguna.php';
                            } elseif ($_GET['halaman'] == "detail") {
                                include 'detail.php';
                            } elseif ($_GET['halaman'] == "tambahproduk") {
                                include 'tambahproduk.php';
                            } elseif ($_GET['halaman'] == "hapusproduk") {
                                include 'hapusproduk.php';
                            } elseif ($_GET['halaman'] == "ubahproduk") {
                                include 'ubahproduk.php';
                            } elseif ($_GET['halaman'] == "logout") {
                                include 'logout.php';
                            } elseif ($_GET['halaman'] == "pembayaran") {
                                include 'pembayaran.php';
                            } elseif ($_GET['halaman'] == "pembayaranhapus") {
                                include 'pembayaranhapus.php';
                            } elseif ($_GET['halaman'] == "kategori") {
                                include 'kategori.php';
                            } elseif ($_GET['halaman'] == "ubahkategori") {
                                include 'ubahkategori.php';
                            } elseif ($_GET['halaman'] == "detailproduk") {
                                include 'detailproduk.php';
                            } elseif ($_GET['halaman'] == "hapusfotoproduk") {
                                include 'hapusfotoproduk.php';
                            } elseif ($_GET['halaman'] == "tambahkategori") {
                                include 'tambahkategori.php';
                            } elseif ($_GET['halaman'] == "hapuskategori") {
                                include 'hapuskategori.php';
                            } elseif ($_GET['halaman'] == "hapuspengguna") {
                                include 'hapuspengguna.php';
                            } elseif ($_GET['halaman'] == "beranda") {
                                include 'beranda.php';
                            } elseif ($_GET['halaman'] == "diskusi") {
                                include 'diskusi.php';
                            }
                        } else {
                            include 'beranda.php';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <script src="assets/js/jquery-1.10.2.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/jquery.metisMenu.js"></script>
            <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
            <script src="assets/js/morris/morris.js"></script>
            <script src="css/js/sb-admin-2.min.js"></script>
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/bootstrap.bundle.min.js"></script>
            <script src="assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
            <script src="assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
            <script>
                $(document).ready(function() {
                    $(document).ready(function() {
                        $('#table').DataTable();
                    });
                });


                $(document).ready(function() {
                    $('#laporan').DataTable({
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'pdfHtml5',
                                title: 'LAPORAN PENJUALAN',
                                text: 'Download Laporan Penjualan',
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                },
                                customize: function(doc) {
                                    doc.content[1].table.widths =
                                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                    doc.defaultStyle.alignment = 'center';
                                    doc.styles.tableHeader.alignment = 'center';
                                }

                            },
                            'colvis'
                        ],
                        "language": {
                            "search": "Cari",
                            "sLengthMenu": "Tampil _MENU_ Data",
                            "info": "Menampikan _START_ sampai _END_ dari _TOTAL_ data",
                            "infoEmpty": "Menampikan 0 sampai 0 dari 0 data",
                            "zeroRecords": "Data tidak ditemukan",
                            "paginate": {
                                "first": "Pertama",
                                "last": "Terakhir",
                                "next": "Selanjutnya",
                                "previous": "Sebelumnya"
                            },
                        },
                    });
                    $('#laporanpemasukan').DataTable({
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'pdfHtml5',
                                title: 'LAPORAN PEMASUKAN',
                                text: 'Download Laporan Pemasukan',
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4]
                                },
                                customize: function(doc) {
                                    doc.content[1].table.widths =
                                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                    doc.defaultStyle.alignment = 'center';
                                    doc.styles.tableHeader.alignment = 'center';
                                }

                            },
                            'colvis'
                        ],
                        "language": {
                            "search": "Cari",
                            "sLengthMenu": "Tampil _MENU_ Data",
                            "info": "Menampikan _START_ sampai _END_ dari _TOTAL_ data",
                            "infoEmpty": "Menampikan 0 sampai 0 dari 0 data",
                            "zeroRecords": "Data tidak ditemukan",
                            "paginate": {
                                "first": "Pertama",
                                "last": "Terakhir",
                                "next": "Selanjutnya",
                                "previous": "Sebelumnya"
                            },
                        },
                    });
                });
            </script>
            <script>
                // JavaScript code to toggle the sidebar
                document.addEventListener('DOMContentLoaded', function() {
                    const sidebarToggler = document.querySelector('.sidebar-toggler');
                    const sidebar = document.querySelector('#accordionSidebar'); // Target sidebar instead of '.sidebar'

                    sidebarToggler.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent default behavior of the link
                        sidebar.classList.toggle('toggled'); // Toggle the 'toggled' class on the sidebar
                    });
                });
            </script>
</body>

</html>