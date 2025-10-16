<?php
include "koneksi.php";

// ambil id wisata dari URL
$id_wisata = $_GET['id_wisata'];

// ambil data wisata berdasarkan id
$sql = "SELECT * FROM wisata WHERE id_wisata = $id_wisata";
$resultWisata = $koneksi->query($sql);
$wisata = $resultWisata->fetch_assoc();

// ambil data kategori
$resultKategori = $koneksi->query("SELECT * FROM kategori");

// ambil gambar terkait
$gambar = $koneksi->query("SELECT * FROM gambar_wisata WHERE id_wisata=$id_wisata");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Wisata</title>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
}

body {
  background: #E0F7FA;
  display: flex;
}

/* ===== SIDEBAR ===== */
.sidebar {
  width: 230px;
  background: #014D4D;
  color: #fff;
  min-height: 100vh;
  padding: 20px 0;
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0;
  left: 0;
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
}

.sidebar h2 {
  font-size: 20px;
  margin: 0 20px 30px;
  color: #2EC4B6;
  padding-top: 10px;
}

.sidebar a {
  color: #fff;
  text-decoration: none;
  padding: 12px 20px;
  display: block;
  transition: all 0.3s ease;
}

.sidebar a:hover {
  background: #E0F7FA;
  color: #014D4D;
  transform: translateX(5px);
}

/* ===== CONTENT ===== */
.content {
  margin-left: 260px; /* beri jarak agar tidak tertutup sidebar */
  padding: 40px;
  flex: 1;
}

.content h2 {
  text-align: center;
  margin-bottom: 25px;
  color: #014D4D;
}

/* ===== FORM CONTAINER ===== */
form {
  max-width: 800px;
  margin: 0 auto;
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 20px;
}

label {
  font-weight: 600;
  display: block;
  margin-bottom: 8px;
  color: #014D4D;
}

input, textarea, select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  outline: none;
  transition: 0.3s;
}

input:focus, textarea:focus, select:focus {
  border-color: #2EC4B6;
  box-shadow: 0 0 5px rgba(46, 196, 182, 0.4);
}

button {
  background: #1E6F5C;
  color: #fff;
  padding: 12px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.3s;
  width: 100%;
}

button:hover {
  background: #145346;
}

  </style>
</head>
<body>

 <div class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="daftar_wisata.php">Daftar Wisata</a>
    <a href="add_wisata.php">Tambah Wisata</a>
    <a href="users.php">Users</a>
  </div>


  <div class="content">
      <h2>Edit Wisata</h2>
      <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_wisata" value="<?php echo $wisata['id_wisata']; ?>">

        <div class="form-group">
          <label>Nama Wisata</label>
          <input type="text" name="nama_wisata" value="<?php echo $wisata['nama_wisata']; ?>" required>
        </div>

        <div class="form-group">
          <label>Kategori</label>
          <select name="id_kategori" required>
            <option value="">--Pilih Kategori--</option>
            <?php while($kategori = $resultKategori->fetch_assoc()): ?>
              <option value="<?php echo $kategori['id_kategori']; ?>" <?php if($kategori['id_kategori'] == $wisata['id_kategori']) echo 'selected'; ?>>
                <?php echo $kategori['nama_kategori']; ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Lokasi</label>
          <input type="text" name="lokasi" value="<?php echo $wisata['lokasi']; ?>" required>
        </div>

        <div class="form-group">
          <label>Latitude</label>
          <input type="text" name="latitude" value="<?php echo $wisata['latitude']; ?>" required>
        </div>

        <div class="form-group">
          <label>Longitude</label>
          <input type="text" name="longitude" value="<?php echo $wisata['longitude']; ?>" required>
        </div>

        <div class="form-group">
          <label>Deskripsi</label>
          <textarea name="deskripsi" rows="4" required><?php echo $wisata['deskripsi']; ?></textarea>
        </div>
      
        <button type="submit">Simpan Perubahan</button>
    </form>
  </div>
</body>
</html>
