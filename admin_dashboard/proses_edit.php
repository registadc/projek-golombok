<?php
include "koneksi.php";

// Ambil data dari form
$id_wisata   = $_POST['id_wisata'];
$nama        = $_POST['nama_wisata'];
$deskripsi   = $_POST['deskripsi'];

// Update data wisata
$koneksi->query("UPDATE wisata 
                 SET nama_wisata='$nama', deskripsi='$deskripsi' 
                 WHERE id_wisata=$id_wisata");

// Folder upload
$targetDir = "uploads/";

// Jika ada foto baru diupload
if (!empty($_FILES['foto']['name'][0])) {
    $koneksi->query("DELETE FROM gambar_wisata WHERE id_wisata=$id_wisata");
    foreach ($_FILES['foto']['tmp_name'] as $key => $tmp_name) {
        $fileName = time() . "_" . basename($_FILES['foto']['name'][$key]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($tmp_name, $targetFilePath)) {
            // Simpan ke tabel gambar_wisata
            $koneksi->query("INSERT INTO gambar_wisata (id_wisata, image_url) 
                             VALUES ($id_wisata, '$fileName')");
        }
    }
}

header("Location: daftar_wisata.php?pesan=update_success");
exit();
?>
