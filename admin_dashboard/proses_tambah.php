<?php
include "koneksi.php";

// --- Ambil data dari form ---
$nama_wisata = $_POST['nama_wisata'];
$deskripsi   = $_POST['deskripsi'];
$id_kategori = $_POST['kategori']; 
$lokasi      = $_POST['lokasi'];
$latitude    = $_POST['latitude'];
$longitude   = $_POST['longitude'];

// --- Folder upload ---
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// --- Fungsi upload ---
function uploadFoto($field, $target_dir) {
    if (!empty($_FILES[$field]['name'])) {
        $filename = time() . "_" . basename($_FILES[$field]['name']);
        $target_file = $target_dir . $filename;
        $ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];

        if (!in_array($ext, $allowed)) {
            die("Format file tidak valid ($field).");
        }

        if (move_uploaded_file($_FILES[$field]['tmp_name'], $target_file)) {
            return $filename;
        } else {
            die("Gagal upload $field.");
        }
    }
    return null;
}

// --- Upload gambar utama ---
$gambar_utama = uploadFoto('foto1', $target_dir);

// --- Insert ke tabel wisata ---
$stmt = $koneksi->prepare("INSERT INTO wisata (id_kategori, nama_wisata, lokasi, deskripsi, latitude, longitude, gambar_utama) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssdds", $id_kategori, $nama_wisata, $lokasi, $deskripsi, $latitude, $longitude, $gambar_utama);

if ($stmt->execute()) {
    $id_wisata = $stmt->insert_id;

    // --- Upload foto tambahan ke gambar_wisata ---
    $foto2 = uploadFoto('foto2', $target_dir);
    $foto3 = uploadFoto('foto3', $target_dir);
    $foto4 = uploadFoto('foto4', $target_dir);

    $foto_lain = array_filter([$foto2, $foto3, $foto4]);
    if (!empty($foto_lain)) {
        $stmt2 = $koneksi->prepare("INSERT INTO gambar_wisata (id_wisata, image_url) VALUES (?, ?)");
        foreach ($foto_lain as $foto) {
            $stmt2->bind_param("is", $id_wisata, $foto);
            $stmt2->execute();
        }
        $stmt2->close();
    }

    echo "<script>alert('Data wisata berhasil disimpan!'); window.location.href='daftar_wisata.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
