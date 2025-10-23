<?php
// Hanya start session jika belum ada session yang aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoLombok</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {box-sizing:border-box; margin:0; padding:0;}
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding-top: 80px; 
    }

    header {
      width: 100%;
      padding: 15px 40px;
      position: fixed;        
      top: 0;
      left: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
      background: white;      
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
    }
    
    header a {
      text-decoration: none;
    }
    
    header .judul {
      font-family:'Pacifico', cursive;
      font-size:24px;
      color:#2EC4B6;
    }
    
    nav {
      display:flex;
      gap:24px;
      align-items: center;
    }
    
    nav a {
      text-decoration: none;
      color: black;
      font-weight: 500;
      transition: .3s;
      display: flex;
      align-items: center;
    }
    
    nav a:hover { 
      color: #00C9A7; 
    }
    
    /* Styling untuk button login */
    .login-btn {
      background-color: #00C9A7;
      color: white;
      padding: 8px 20px;
      border-radius: 25px;
      font-weight: 500;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }
    
    .login-btn:hover {
      background-color: #00b894;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 201, 167, 0.3);
      color: white;
    }
    
    /* PERBAIKAN: Styling untuk icon user (sederhana) */
    .user-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #f0f0f0;
      transition: all 0.3s ease;
      text-decoration: none;
    }
    
    .user-icon:hover {
      background-color: #00C9A7;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .user-icon i {
      font-size: 18px;
      color: #555;
      transition: color 0.3s ease;
    }
    
    .user-icon:hover i {
      color: white;
    }
    
    /* PERBAIKAN: Hapus styling untuk dropdown yang tidak digunakan */
    .user-menu,
    .username,
    .dropdown-content {
      display: none !important;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
      header {
        padding: 15px 20px;
      }
      
      nav {
        gap: 15px;
      }
    }
  </style>
</head>
<body>
  <!------------------NAVBAR------------->
  <header>
    <a href="home.php" class="judul">GoLombok</a>
    <nav>
      <a href="home.php">Home</a>
      <a href="destinasi.php">Destination</a>
      <a href="favorit.php">Favorites</a>
      
      <?php
      if (isset($_SESSION['user_id'])) {
          // User sudah login - tampilkan icon user saja
          ?>
          <a href="user_profile.php" class="user-icon" title="Profile">
            <i class="fas fa-user"></i>
          </a>
          <?php
      } else {
          // User belum login - tampilkan button login
          ?>
          <a href="login.php" class="login-btn">
            <i class="fas fa-sign-in-alt"></i> Login
          </a>
          <?php
      }
      ?>
    </nav>
  </header>
</body>
</html>