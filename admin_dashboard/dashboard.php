<?php
include "koneksi.php";

// Hitung ringkasan data
$total_wisata = $koneksi->query("SELECT COUNT(*) AS total FROM wisata")->fetch_assoc()['total'];
$total_kategori = $koneksi->query("SELECT COUNT(*) AS total FROM kategori")->fetch_assoc()['total'];
$total_user = $koneksi->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc()['total'];

// Ambil 5 data wisata terbaru
$sql = "SELECT w.id_wisata, w.nama_wisata, k.nama_kategori, w.lokasi, w.gambar_utama 
        FROM wisata w 
        JOIN kategori k ON w.id_kategori = k.id_kategori
        ORDER BY w.id_wisata DESC 
        LIMIT 5";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin</title>
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

    /* Content */
    .content {
      flex: 1;
      padding: 30px;
      margin-left: 230px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    .header h1 {
      color: #014D4D;
      font-size: 26px;
      font-weight: 600;
    }
    .logout-btn {
      background: #d9534f;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      transition: 0.3s;
    }
    .logout-btn:hover {
      background: #c9302c;
    }

    /* Dashboard Cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 40px;
    }
    .card {
      background: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.2s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card h3 {
      font-size: 20px;
      color: #014D4D;
      margin-bottom: 10px;
    }
    .card p {
      font-size: 28px;
      color: #2EC4B6;
      font-weight: 700;
    }
    .card small {
      color: #777;
      font-size: 13px;
    }

    /* Tabel Ringkas */
    .table-section {
      background: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .table-section h3 {
      color: #014D4D;
      margin-bottom: 15px;
      font-weight: 600;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
      font-size: 14px;
    }
    th {
      background-color: #2EC4B6;
      color: #fff;
    }
    tr:hover {
      background-color: #f5f5f5;
    }
    img {
      width: 70px;
      border-radius: 8px;
    }
    .see-all {
      display: inline-block;
      margin-top: 15px;
      background: #014D4D;
      color: #fff;
      padding: 8px 16px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 13px;
      transition: 0.3s;
    }
    .see-all:hover {
      background: #2EC4B6;
    }

    footer {
      margin-top: 40px;
      text-align: center;
      color: #555;
      font-size: 13px;
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
    <div class="header">
      <h1>Selamat Datang, Admin!</h1>
      <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <div class="cards">
      <div class="card">
        <h3>Total Wisata</h3>
        <p><?= $total_wisata; ?></p>
        <small>Data wisata yang terdaftar</small>
      </div>
      <div class="card">
        <h3>Total Kategori</h3>
        <p><?= $total_kategori; ?></p>
        <small>Jenis kategori wisata</small>
      </div>
      <div class="card">
        <h3>Total Pengguna</h3>
        <p><?= $total_user; ?></p>
        <small>Jumlah akun terdaftar</small>
      </div>
    </div>

    <div class="table-section">
      <h3>Daftar Wisata Terbaru</h3>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Wisata</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Gambar</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if ($result->num_rows > 0) {
            $no = 1;
            while ($row = $result->fetch_assoc()) { ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama_wisata']); ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                <td><?= htmlspecialchars($row['lokasi']); ?></td>
                <td><img src="uploads/<?= $row['gambar_utama']; ?>" alt="<?= $row['nama_wisata']; ?>"></td>
              </tr>
            <?php }
          } else {
            echo "<tr><td colspan='5'>Belum ada data wisata.</td></tr>";
          }
          ?>
        </tbody>
      </table>
      <a href="daftar_wisata.php" class="see-all">Lihat Semua</a>
    </div>

    <footer>
      &copy; <?= date('Y'); ?> GoLombok | Admin Panel
    </footer>
  </div>

</body>
</html>
