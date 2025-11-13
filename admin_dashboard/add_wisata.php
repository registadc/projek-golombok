<?php
include "koneksi.php";
$result = $koneksi->query("SELECT * FROM kategori");

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Tambah Wisata</title>
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
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 230px;
      background: #014D4D;
      color: #fff;
      min-height: 100vh;
      padding: 20px 0;
      display: flex;
      flex-direction: column;
      position: fixed;
      height: 100%;
      border-top-right-radius: 30px;
      border-bottom-right-radius: 30px;
    }
    
    .sidebar h2 {
      font-size: 20px;
      margin: 0 20px 30px;
      color: #2EC4B6;
      /* font-family: 'Pacifico', cursive; */
      padding-top: 10px;
    }
    
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: center;
      padding: 12px 20px;
      margin-bottom: 8px;
      border-left: 4px solid transparent;
      transition: all 0.3s ease;
      position: relative;
    }
    
    .sidebar a:hover {
      background: #E0F7FA;
      border-left: 4px solid #E0F7FA;
      transform: translateX(5px);
      color: black;
    }

    /* Content */
    .content {
      flex: 1;
      padding: 30px;
      margin-left: 230px;
    }
    
    .card {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 900px;
      margin: auto;
    }
    
    .card h3 {
      margin-bottom: 25px;
      font-weight: 600;
      color: #014D4D;
      font-size: 24px;
      padding-bottom: 10px;
      border-bottom: 2px solid #E0F7FA;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: #333;
    }
    
    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
      transition: border 0.3s ease;
    }
    
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      border-color: #2EC4B6;
      outline: none;
      box-shadow: 0 0 0 2px rgba(46, 196, 182, 0.2);
    }
    
    .form-row {
      display: flex;
      gap: 20px;
    }
    
    .form-row .form-group {
      flex: 1;
    }
    
    button {
      background: #1E6F5C;
      color: #fff;
      padding: 14px 25px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      transition: 0.3s;
      font-size: 16px;
      width: 100%;
      margin-top: 10px;
    }
    
    button:hover {
      background: #145346;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* File input styling */
    input[type="file"] {
      padding: 8px;
      background: #f9f9f9;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        min-height: auto;
        position: relative;
        height: auto;
      }
      
      .content {
        margin-left: 0;
      }
      
      .form-row {
        flex-direction: column;
        gap: 0;
      }
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
    <div class="card">
      <h3>Tambah Wisata Baru</h3>
      <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label>Nama Wisata</label>
          <input type="text" name="nama_wisata" placeholder="Contoh: Gili Trawangan" required>
        </div>
        <div class="form-group">
          <label>Deskripsi</label>
          <textarea name="deskripsi" rows="4" placeholder="Tulis deskripsi wisata..." required></textarea>
        </div>
        <div class="form-row">
          <div class="form-group">
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
          <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="lokasi" placeholder="Kabupaten Lombok Utara, NTB" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Latitude</label>
            <input type="text" name="latitude" placeholder="-8.3511" required>
          </div>
          <div class="form-group">
            <label>Longitude</label>
            <input type="text" name="longitude" placeholder="116.0453" required>
          </div>
        </div>
        <div class="form-group">
          <label>Foto Utama</label>
          <input type="file" name="foto1" accept="image/*" required>
        </div>
        <button type="submit">Simpan</button>
      </form>
    </div>
  </div>
</body>
</html>