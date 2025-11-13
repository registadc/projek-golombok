<?php 
include "koneksi.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM user WHERE id_user='$id'";
    $query = mysqli_query($koneksi, $sql);

    if($query){
        header("Location: users.php?hapus=sukses");
        exit;
    } else {
        die("Gagal menghapus user: " . mysqli_error($koneksi));
    }
} else {
    die("ID user tidak ditemukan.");
}
?>