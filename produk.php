<?php
session_start();
include 'koneksi.php';

// Retrieve search term if it exists
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if (empty($_GET['id'])) {
    $idkategori = 0;
} else {
    $idkategori = $_GET['id'];
    $ambilkategori = $koneksi->query("SELECT * FROM kategori WHERE id_kategori='$idkategori'");
    $kategori = $ambilkategori->fetch_assoc();
}
?>
<?php include 'header.php'; ?>
<section style="margin-top: 70px;">
    <div class="d-flex justify-content-center align-items-center" style="height: 300px; background-image:url('foto/bg2.png');">
        <div class="container">
            <div>
                <div class="wrap-about ftco-animate">
                    <div class="heading-section text-center">
                        <h1 style="font-size: 40px; font-weight:500;">Daftar Produk</h1>
                        <p style="text-decoration: none; color:black;"><a href="index.php" style="color: black;">Home</a> <img src="foto/arrow.png" alt=""> Daftar Produk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 col-12">
                <!-- Search Form -->
                <form method="GET" action="">
                    <div class="input-group mb-5">
                        <input type="text" class="form-control" placeholder="Masukkan Keyword Pencarian" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                        <div class="input-group-append ml-2">
                            <button class="btn rounded text-white" style="width: 100px; background-color:#009BF3;" type="submit">Cari</button>
                        </div>
                    </div>
                </form>
                <div class="row justify-content-center">
                    <?php
                    $limit = 9;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    $whereClause = '';
                    if ($idkategori != 0) {
                        $whereClause = "WHERE produk.id_kategori = '$idkategori'";
                    }

                    if (!empty($searchTerm)) {
                        $searchClause = $whereClause ? " AND " : " WHERE ";
                        $whereClause .= $searchClause . "(produk.namaproduk LIKE '%$searchTerm%')";
                    }

                    $query = "SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori $whereClause ORDER BY idproduk ASC LIMIT $offset, $limit";

                    $totalResultsQuery = "SELECT COUNT(*) as count FROM produk LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori $whereClause";
                    $totalResults = $koneksi->query($totalResultsQuery)->fetch_assoc()['count'];

                    $result = $koneksi->query($query);

                    while ($perproduk = $result->fetch_assoc()) {
                    ?>
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
                    <?php } ?>
                </div>

                <div class="row mb-5">
                    <div class="col-md-12 d-flex align-items-center justify-content-center">
                        <?php
                        $totalPages = ceil($totalResults / $limit);

                        echo '<nav aria-label="Page navigation"><ul class="pagination">';
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?id=' . $idkategori . '&page=' . ($page - 1) . '&search=' . $searchTerm . '">Previous</a></li>';
                        }

                        $startPage = max($page - 1, 1);
                        $endPage = min($page + 1, $totalPages);

                        if ($startPage > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?id=' . $idkategori . '&page=1&search=' . $searchTerm . '">1</a></li>';
                            if ($startPage > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }

                        for ($i = $startPage; $i <= $endPage; $i++) {
                            echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="?id=' . $idkategori . '&page=' . $i . '&search=' . $searchTerm . '">' . $i . '</a></li>';
                        }

                        if ($endPage < $totalPages) {
                            if ($endPage < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?id=' . $idkategori . '&page=' . $totalPages . '&search=' . $searchTerm . '">' . $totalPages . '</a></li>';
                        }

                        if ($page < $totalPages) {
                            echo '<li class="page-item"><a class="page-link" href="?id=' . $idkategori . '&page=' . ($page + 1) . '&search=' . $searchTerm . '">Next</a></li>';
                        }
                        echo '</ul></nav>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include 'footer.php';
?>
