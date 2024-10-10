<?php
// Ambil data produk berdasarkan idproduk
$id_produk = $_GET["id"];
$query_produk = "SELECT * FROM produk WHERE idproduk = $id_produk";
$result_produk = $koneksi->query($query_produk);
$produk = $result_produk->fetch_assoc();

// Ambil daftar diskusi untuk produk ini beserta informasi pengguna
$query_diskusi = "SELECT diskusi.*, pengguna.nama, pengguna.email, pengguna.fotoprofil 
                     FROM diskusi 
                     INNER JOIN pengguna ON diskusi.id_pengguna = pengguna.id 
                     WHERE id_produk = $id_produk 
                     ORDER BY waktu ASC";
$result_diskusi = $koneksi->query($query_diskusi);

if (isset($_POST["submit_diskusi"])) {
    $id_produk = $_GET["id"]; // Sesuaikan dengan cara mendapatkan ID produk dari URL atau sesuai kebutuhan
    $id_pengguna = $_SESSION["admin"]['id']; // Ambil ID pengguna dari session, asumsikan pengguna sudah login
    $diskusi = mysqli_real_escape_string($koneksi, $_POST['diskusi']); // Melakukan sanitasi input

    // Query untuk menyimpan diskusi ke dalam database
    $query_insert = "INSERT INTO diskusi (id_produk, id_pengguna, diskusi, waktu) 
                     VALUES ('$id_produk', '$id_pengguna', '$diskusi', NOW())";
    $result_insert = $koneksi->query($query_insert);

    if ($result_insert) {
        echo "<script>alert('diskusi berhasil disimpan');</script>";
        echo "<script>window.location.href = 'index.php?halaman=diskusi&id=$id_produk';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan diskusi');</script>";
    }
}
?>

<div class="row mb-2">
	<div class="col-md-12">
				<h1 class="bold" style="color: black;">Diskusi</h1>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
    <ul class="list-group ">
        <?php if ($result_diskusi->num_rows > 0): ?>
            <?php while ($row = $result_diskusi->fetch_assoc()): ?>
                <?php
                $id_diskusi = $row['id_diskusi'];
                $diskusi = $row['diskusi'];
                $waktu = $row['waktu'];
                $nama_pengguna = $row['nama'];
                $email_pengguna = $row['email'];
                $foto_profil = $row['fotoprofil'];
                ?>
                <li class='list-group-item mb-3 shadow'>
                    <div class='d-flex w-100 justify-content-between'>
                        <div class='mr-3'>
                            <img src='../foto/<?php echo $foto_profil; ?>' alt='Foto Profil' style='width: 100px; height: 100px; object-fit: cover;'>
                        </div>
                        <div>
                            <h5 class='mb-1' style="color: black;"><?php echo $nama_pengguna; ?></h5>
                            <p class='mb-1 text-primary'><strong><?php echo $email_pengguna; ?></strong></p>
                            <p class='mb-1'><?php echo $diskusi; ?></p>
                        </div>
                        <div class='ml-auto text-right'>
                            <small><?php echo $waktu; ?></small>
                        </div>
                    </div>
                

            <?php endwhile; ?>
        <?php else: ?>
            <li class='list-group-item'>Belum ada diskusi untuk produk ini.</li>
        <?php endif; ?>
    </ul>
    </div>
</div>

	
<div class="row mb-3 mt-2">
    <div class="col-lg-12">
        <form method="post">
            <div class="form-group">
                <label for="diskusi" style="color: black;">Masukkan Komentar Anda</label>
                <textarea class="form-control" id="diskusi" name="diskusi" rows="1" required></textarea>
            </div>
            <button type="submit" name="submit_diskusi" class="btn btn-primary float-right">Simpan</button>
        </form>
    </div>
</div>