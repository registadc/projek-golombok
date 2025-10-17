<?php
include 'koneksi.php';
$result = $koneksi->query("SELECT * FROM kategori");
$destinasi = $koneksi->query("SELECT * FROM wisata");


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinasi</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="content">
        <h1>Destinasi</h1>
        <p>Destinasi wisata di Lombok</p>
        <img src="img/bilebante.jpeg" alt="destinasi wisata">
        
        <div class="destinasi">
            <h2>Destinasi Terbaik di Lombok Menantimu</h2>
            <p>Nikmati serunya petualangan alam, jelajahi pantai eksotis,
                mendaki gunung megah, dan menyelami budaya lokal yang memikat</p>
            
            <div class="search">
                <input type="text" name="q" placeholder="Gunung Rinjani...">
                <button type="submit"><i class="fas fa-search"></i></button>

                <label>Kategori</label>
                <select name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id_kategori']}'>{$row['nama_kategori']}</option>";
                    }
                    ?>
                </select>
            </div>  

            <div class="daftar-destinasi">
                <?php
                while ($row = $destinasi->fetch_assoc()) {
                    echo "<div class='destinasi-item'>
                            <img src='img/{$row['gambar_utama']}' alt='{$row['nama_wisata']}'>
                            <h3>{$row['nama_wisata']}</h3>
                            <p>{$row['lokasi']}</p>
                            <button>Read More</button>
                          </div>";
                }
                ?>
            </div>
        </div>
    </div>

   <?php include 'footer.php'; ?>
</body>
</html>