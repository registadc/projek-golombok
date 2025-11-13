<?php
include "koneksi.php";



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Users</title>
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
        <h3>Daftar Users</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Foto Profil</th>
                    <th>Nomer Telepon</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "koneksi.php";

                $query = "SELECT * FROM user";
                $result = mysqli_query($koneksi, $query);

            while($row = $result->fetch_assoc()){ ?>
            <tr>
              <td><?= $row['id_user']?></td>
              <td><?= htmlspecialchars($row['username']); ?></td>
              <td><?= htmlspecialchars($row['email']); ?></td>
              <td><img src="../uploads/<?= $row['foto_profil']; ?>" alt="foto profil"></td>
              <td><?= htmlspecialchars($row['no_telp']); ?></td>
              <td><?= htmlspecialchars($row['user_type']); ?></td>
                <td>
                  <a href="hapus_user.php?id=<?= $row['id_user']; ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
  </div>

</body>
</html>