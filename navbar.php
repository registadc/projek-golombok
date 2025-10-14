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
    
    /* Styling khusus untuk icon user */
    .user-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background-color: #f0f0f0;
      transition: background-color 0.3s;
      margin-left: 10px;
    }
    
    .user-icon:hover {
      background-color: #00C9A7;
      color: white;
    }
    
    .user-icon i {
      font-size: 18px;
      color: #555;
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
      <a href="user_profile.php" class="user-icon">
        <i class="fas fa-user"></i>
      </a>
    </nav>
  </header>
</body>
</html>