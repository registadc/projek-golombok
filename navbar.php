<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffff;
            font-family: 'Poppins', sans-serif;
        }

        .header-2 {
            width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 12px 24px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
        }

        .header-2 .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1000px;
            margin: auto;
        }

        .navbar {
            display: flex;
            gap: 18px;
        }

        .navbar a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
           background-color: #E0F7FA;
        color: #014D4D;
        }

        .judul {
            font-size: 18px;
            font-weight: 600;
            color: #2EC4B6;
            pointer-events: none;
            cursor: default;
            text-decoration: none;
            font-family: 'Pacifico', cursive;
        }
        /* Dropdown container */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Tombol utama */
.dropbtn {
  background: none;
  border: none;
  font-family: inherit;
  font-size: 16px;
  color: #555;
  cursor: pointer;
  padding: 6px 12px;
  transition: all 0.3s ease;
}

.dropbtn:hover {
 background-color: #E0F7FA;
    color: #014D4D;
}

/* Isi dropdown */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #fff;
  min-width: 160px;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
  border-radius: 6px;
  z-index: 1000;
}

.dropdown-content a {
  color: #555;
  padding: 10px 14px;
  text-decoration: none;
  display: block;
  font-weight: 500;
  transition: background-color 0.3s;
}

.dropdown-content a:hover {
  background-color: #2EC4B6;
  color: #fff;
}

/* Tampilkan dropdown saat hover */
.dropdown:hover .dropdown-content {
  display: block;
}

    </style>
</head>
<body>
    <div class="header-2">
      <div class="flex">
        <a href="home.php" class="judul">GoLombok</a>
          <nav class="navbar">
                <a href="home.php">Home</a>
                <a href="destinasi.php">Destinations</a>
                <div class="dropdown">
                    <button class="dropbtn">Categories ▾</button>
                        <div class="dropdown-content">
                            <a href="destinations.php?category=alam">Alam</a>
                            <a href="destinations.php?category=pantai">Pantai</a>
                            <a href="destinations.php?category=budaya">Budaya</a>
                        </div>
                </div>
              <a href="favorit.php">Favorites</a>
              <a href="user_profile.php" class="fas fa-user"></a>
          </nav>
      </div>
  </div>
</body>
</html>