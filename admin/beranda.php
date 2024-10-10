<?php
$kategori = $koneksi->query("SELECT * FROM kategori");
$jumlahkategori = $kategori->num_rows;

$produk = $koneksi->query("SELECT * FROM produk");
$jumlahproduk = $produk->num_rows;

$member = $koneksi->query("SELECT * FROM pengguna where level = 'Pelanggan'");
$jumlahmember = $member->num_rows;

$pembelian = $koneksi->query("SELECT * FROM pembelian");
$jumlahpembelian = $pembelian->num_rows;

$tahunini = date('Y');
$bulanini = date('m');

$bulan = 1;
$penjualangrafik = array();
$pembeliangrafik = array();
while ($bulan <= 13) {
    // penjualan
    $penjualan = $koneksi->query("SELECT * FROM pembelian where month(tanggalbeli) = '$bulan' and year(tanggalbeli) = '$tahunini' and statusbeli != 'Menunggu Konfirmasi Admin' and statusbeli != 'Belum Bayar' and statusbeli != 'Pesanan Di Tolak'");
    $totalpenjualan = 0;
    while ($jumlahpenjualan = $penjualan->fetch_assoc()) {
        $totalpenjualan += $jumlahpenjualan['totalbeli'];
    }
    $penjualangrafik[] = $totalpenjualan;
    $bulan++;
}
?>
<br>
<div class="row mb-2">
    <div class="col-md-12">
        <div class="card shadow h-80">
            <div class="card-body">
                <h5 style="color: black;">Dashboard</h5>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 text-center">
            <a href="index.php?halaman=kategori" class="btn">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="mb-2"><img src="../foto/a.png" alt=""></div>
                        </div>
                        <div class="col mr-2">
                            <div class="h5 mb-2 font-weight-bold text-gray-800"><?php echo $jumlahproduk ?></div>
                            <div class="h6 mb-0 font-weight-bold text-gray text-uppercase">
                                Jumlah Produk</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 text-center">
            <a href="index.php?halaman=produk" class="btn">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="mb-2"><img src="../foto/b.png" alt=""></div>
                        </div>
                        <div class="col mr-2">
                            <div class="h5 mb-2 font-weight-bold text-gray-800"><?php echo $jumlahmember ?></div>
                            <div class="h6 mb-0 font-weight-bold text-gray text-uppercase">
                                Jumlah Akun</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 text-center">
            <a href="index.php?halaman=produk" class="btn">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="mb-2"><img src="../foto/c.png" alt=""></div>
                        </div>
                        <div class="col mr-2">
                            <div class="h5 mb-2 font-weight-bold text-gray-800"><?php echo $jumlahkategori ?></div>
                            <div class="h6 mb-0 font-weight-bold text-gray text-uppercase">
                                Jumlah Kategori</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 text-center">
            <a href="index.php?halaman=produk" class="btn">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="mb-2"><img src="../foto/d.png" alt=""></div>
                        </div>
                        <div class="col mr-2">
                            <div class="h5 mb-2 font-weight-bold text-gray-800"><?php echo $jumlahpembelian ?></div>
                            <div class="h6 mb-0 font-weight-bold text-gray text-uppercase">
                                Jumlah Transaksi</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <img src="../foto/dashboard.png" alt="">
</div>