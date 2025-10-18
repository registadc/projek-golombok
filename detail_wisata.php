<?php
include 'koneksi.php';

$id_wisata = $_GET['id_wisata'];

// Ambil data wisata
$query = mysqli_query($koneksi, "SELECT * FROM wisata WHERE id_wisata = '$id_wisata'");
$wisata = mysqli_fetch_assoc($query);

// Ambil 3 gambar kecil
$query_gambar = mysqli_query($koneksi, "SELECT * FROM gambar_wisata WHERE id_wisata = '$id_wisata' LIMIT 3");
$gambar_kecil = [];
while ($row = mysqli_fetch_assoc($query_gambar)) {
    $gambar_kecil[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $wisata['nama_wisata']; ?> | Detail Wisata</title>
    <style>
        body {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  background-color: #f8f9fa;
  color: #222;
}


.detail-wisata {
  width: 90%;
  max-width: 1100px;
  margin: 40px auto;
}

.gambar-utama img {
  width: 100%;
  height: 350px;
  border-radius: 10px;
  object-fit: cover;
}

.teks-wisata {
  margin-top: 20px;
}

.teks-wisata h2 {
  color: #024950;
  font-size: 24px;
  font-weight: 600;
}

.teks-wisata .alamat {
  color: #555;
  font-size: 15px;
  margin-bottom: 10px;
}

.teks-wisata .deskripsi {
  text-align: justify;
  line-height: 1.7;
  color: #333;
}

.gambar-kecil {
  display: flex;
  justify-content: flex-start;
  gap: 15px;
  margin-top: 25px;
}

.gambar-kecil img {
  width: 32%;
  height: 130px;
  border-radius: 8px;
  object-fit: cover;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.gambar-kecil img:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}


.peta {
  margin-top: 40px;
}

.peta h3 {
  color: #024950;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 10px;
}

    </style>
</head>
<body>

<?php include "navbar.php"; ?>

    <section class="detail-wisata">
        <div class="gambar-utama">
            <img src="admin_dashboard/uploads/<?= $wisata['gambar_utama']; ?>" alt="<?= $wisata['nama_wisata']; ?>">
        </div>

        <div class="teks-wisata">
            <h2><?= $wisata['nama_wisata']; ?></h2>
            <p class="alamat"><?= $wisata['lokasi']; ?></p>
            <hr><br>
            <p class="deskripsi"><?= nl2br($wisata['deskripsi']); ?></p>
        </div>

        <div class="gambar-kecil">
            <?php foreach ($gambar_kecil as $g) : ?>
                <img src="admin_dashboard/uploads/<?= $g['image_url']; ?>" alt="Gambar tambahan">
            <?php endforeach; ?>
        </div><br><br>
        <hr>

        <div class="peta">
            <h3>Peta Lokasi</h3>
            <iframe
                src="https://www.google.com/maps?q=<?= $wisata['latitude']; ?>,<?= $wisata['longitude']; ?>&hl=id&z=14&output=embed"
                width="100%"
                height="350"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </section>
    <?php include "footer.php"; ?>

</body>
</html>
