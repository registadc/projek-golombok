<?php
include "koneksi.php";

$id_wisata = $_GET['id_wisata'] ?? '';

if ($id_wisata !== '') {
    // Hapus gambar terkait
    mysqli_query($koneksi, "DELETE FROM gambar_wisata WHERE id_wisata = '$id_wisata'");

    // Hapus data wisata
    $sql = "DELETE FROM wisata WHERE id_wisata = '$id_wisata'";
    $query = mysqli_query($koneksi, $sql);

    if ($query && mysqli_affected_rows($koneksi) > 0) {
        header("Location: daftar_wisata.php?hapus=sukses");
        exit;
    } else {
        die("Gagal menghapus wisata: " . mysqli_error($koneksi));
    }
} else {
    die("ID wisata tidak ditemukan.");
}
?>
