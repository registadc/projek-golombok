<?php
include "koneksi.php";

// Ambil semua data wisata beserta nama kategori
$sql = "SELECT w.id_wisata, w.nama_wisata, w.lokasi, w.latitude, w.longitude, 
               w.gambar_utama, w.deskripsi, k.nama_kategori 
        FROM wisata w 
        JOIN kategori k ON w.id_kategori = k.id_kategori
        ORDER BY w.id_wisata DESC";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Wisata</title>
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
    .content {
      flex: 1;
      padding: 30px;
      margin-left: 230px;
    }
    .card {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h3 {
      margin-bottom: 20px;
      color: #014D4D;
      font-weight: 600;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
      font-size: 14px;
    }
    th {
      background-color: #2EC4B6;
      color: #fff;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    img {
      width: 100px;
      border-radius: 8px;
    }
    .action-btn {
      padding: 5px 10px;
      border-radius: 6px;
      text-decoration: none;
      margin: 0 3px;
      font-size: 12px;
      color: #fff;
    }
    .action-btn {
      display: block;       /* Setiap tombol di baris baru */
      margin: 5px 0;        /* Jarak vertikal antar tombol */
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 12px;
      color: #fff;
    }
    .edit {background:#1E6F5C;}
    .delete {background:#d9534f;}
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
      <h3>Daftar Wisata</h3>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Wisata</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Lokasi Peta</th>
            <th>Deskripsi</th>
            <th>Gambar Utama</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        if($result->num_rows > 0){
          $no = 1;
          while($row = $result->fetch_assoc()){ ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['nama_wisata']); ?></td>
              <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
              <td><?= htmlspecialchars($row['lokasi']); ?></td>
              <td><?= $row['latitude'];?><br><?= $row['longitude'];?></td>
              <td><?= $row['deskripsi']; ?></td>
              <td><img src="uploads/<?= $row['gambar_utama']; ?>" alt="<?= $row['nama_wisata']; ?>"></td>
              <td>
                <a class="action-btn edit" href="edit_wisata.php?id_wisata=<?= $row['id_wisata']; ?>">Edit</a>
                <a class="action-btn delete" href="hapus_wisata.php?id_wisata=<?= $row['id_wisata']; ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
              </td>
            </tr>
        <?php 
          }
        } else {
          echo "<tr><td colspan='8'>Belum ada data wisata.</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
