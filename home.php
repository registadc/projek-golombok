<?php
include "koneksi.php";

$query = mysqli_query($koneksi, "SELECT * FROM wisata LIMIT 4");
$destinasi = [];
while ($row = mysqli_fetch_assoc($query)) {
    $destinasi[] = $row;
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
      background:#f5f5f5;
      color:#fff;
    }
    header {
      width:100%;
      padding:15px 40px;
      position:absolute;
      top:0; left:0;
      display:flex;
      justify-content:space-between;
      align-items:center;
      z-index:1000;
    }

    header a{
      text-decoration: none;
    }
    header .judul {
      font-family:'Pacifico', cursive;
      font-size:24px;
      color:#fff;
    }
    nav {
      display:flex;
      gap:24px;
    }
    nav a {
      text-decoration:none;
      color:#fff;
      font-weight:500;
      transition:.3s;
    }
    nav a:hover { color:#00C9A7; }

    /* Hero Section */
    .home {
      height:70vh; 
      background:url('background/rinjani.jpeg') center/cover no-repeat;
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      text-align:center;
      padding:0 20px;
      position:relative;
      overflow:hidden;
    }

    .home::before {
      content:'';
      position:absolute;
      inset:0;
      background:rgba(0,0,0,0.4);
    }

    /* Konten di tengah */
    .home-container {
      position:relative;
      max-width:800px;
      z-index:2;
      color:#fff;
    }

    .home-container p{
      margin-top: 20px;
    }

    /* Search bar absolute di bawah hero */
    .search-box {
      position:relative;
      margin-top: -70px;
      left:50%;
      transform:translateX(-50%);
      display:flex;
      align-items:center;
      gap:10px;
      background:#fff;
      padding:20px;
      border-radius:16px;
      box-shadow:0 4px 12px rgba(0,0,0,0.2);
      max-width:700px;
      width:90%;
      flex-wrap:wrap;
      z-index:1000;
    }
    .categories {
      display:flex;
      gap:8px;
      flex-wrap:wrap;
    }
    .categories a {
      display: inline-flex;
      align-items: center;
      gap: 6px; /* jarak antara icon dan teks */
      padding: 8px 14px;
      border: 1px solid #00C9A7;
      border-radius: 20px;
      text-decoration: none;
      color: #00C9A7;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .categories a i {
      font-size: 16px;
    }

    .categories a:hover {
      background: #00C9A7;
      color: white;
    }

    .search-box input {
      flex:1;
      border:1px solid rgba(0,0,0,0.1);
      outline: none;
      padding:8px 10px;
      font-size:0.9rem;
    }
    .search-box button {
      background:#00C9A7;
      border:none;
      color:#fff;
      padding:8px 14px;
      border-radius:8px;
      cursor:pointer;
      transition:.3s;
    }
    .search-box button:hover { background:#009688; }

    /* Wave style */
    .wave {
      position:absolute;
      bottom:0;
      left:0;
      width:100%;
      height:100px;
      z-index:1;
    }

    .destinations {
      text-align:center;
      padding:60px 20px;
      background-color: #f5f5f5;
    }
    .destinations h2 {
      font-size:24px;
      font-weight:700;
      color:#003333;
      margin-bottom:8px;
    }
    .destinations p {
      color:#555;
      margin-bottom:40px;
    }
    
    /* Grid layout yang diperbaiki sesuai gambar referensi */
    .dest-grid {
      display:grid;
      grid-template-columns: repeat(4, 1fr);
      grid-template-rows: repeat(2, 1fr);
      gap:20px;
      max-width:1000px;
      margin:0 auto;
      grid-template-areas: 
        "card1 card1 card2 card3"
        "card4 card4 card4 card3";
    }
    
    .dest-card {
      position:relative;
      overflow:hidden;
      border-radius:12px;
      box-shadow:0 4px 10px rgba(0,0,0,0.15);
      cursor:pointer;
      height: 200px;
    }
    .dest-card img {
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
      transition:transform .3s ease;
    }
    .dest-card:hover img {
      transform:scale(1.05);
    }
    .dest-card .title {
      position:absolute;
      bottom:10px;
      left:10px;
      color:white;
      font-weight:600;
      text-shadow:0 2px 5px rgba(0,0,0,0.5);
    }

    /* Penempatan card sesuai grid areas */
    .dest-card:nth-child(1) {
      grid-area: card1;
    }
    .dest-card:nth-child(2) {
      grid-area: card2;
    }
    .dest-card:nth-child(3) {
      grid-area: card3;
      height: 420px; /* Card ini memanjang ke bawah */
    }
    .dest-card:nth-child(4) {
      grid-area: card4;
    }

    .explore-btn {
      margin-top:40px;
    }
    .explore-btn a {
      display:inline-block;
      padding:12px 26px;
      border-radius:30px;
      background:#00C9A7;
      color:white;
      text-decoration:none;
      font-weight:600;
      transition:.3s;
    }
    .explore-btn a:hover {
      background:#009688;
    }
  </style>
</head>
<body>
  <header>
    <a href="home.php" class="judul">GoLombok</a>
    <nav>
      <a href="home.php">Home</a>
      <a href="destinasi.php">Destination</a>
      <a href="favorit.php">Favorites</a>
      <a href="user_profile.php"><i class="fas fa-user"></i></a>
    </nav>
  </header>

  <section class="home">
    <div class="home-container">
      <h1>Discover the Beauty of Lombok</h1>
      <p>Eksplorasi keindahan alam, budaya, dan petualangan terbaik di Lombok.  
      Temukan destinasi populer, tips perjalanan, dan pengalaman yang membuat  
      liburanmu tak terlupakan, semua dalam satu tempat.</p>
    </div>

    <!-- SVG Wave -->
    <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
      <path d="M0,100 C150,200 350,0 500,100 L500,150 L0,150 Z" style="fill:#f5f5f5;"></path>
    </svg>
  </section>

  <form action="destinasi.php" method="get" class="search-box">
    <div class="categories">
      <a href="destinasi.php?kategori=Pantai">
        <i class="fas fa-umbrella-beach"></i> Pantai
      </a>
      <a href="destinasi.php?kategori=Alam">
        <i class="fas fa-mountain"></i> Alam
      </a>
      <a href="destinasi.php?kategori=Budaya">
        <i class="fas fa-landmark"></i> Budaya
      </a>
    </div>

    <input type="text" name="q" placeholder="Gunung Rinjani...">
    <button type="submit"><i class="fas fa-search"></i></button>
  </form>

  <section class="destinations">
    <h2>Top Destinations</h2>
    <p>Destinasi terbaik Lombok untuk liburan tak terlupakan.</p>

    <div class="dest-grid">
      <?php if(count($destinasi) >= 4): ?>
        <!-- Card 1: Bilebanjia (kiri atas, lebar 2 kolom) -->
        <a href="detail_wisata.php?id=<?php echo $destinasi[0]['id_wisata']; ?>" class="dest-card">
          <img src="uploads/<?php echo $destinasi[0]['gambar_utama']; ?>" alt="<?php echo $destinasi[0]['nama_wisata']; ?>">
          <div class="title"><?php echo $destinasi[0]['nama_wisata']; ?></div>
        </a>
        
        <!-- Card 2: Air terjun (kanan atas) -->
        <a href="detail_wisata.php?id=<?php echo $destinasi[1]['id_wisata']; ?>" class="dest-card">
          <img src="uploads/<?php echo $destinasi[1]['gambar_utama']; ?>" alt="<?php echo $destinasi[1]['nama_wisata']; ?>">
          <div class="title"><?php echo $destinasi[1]['nama_wisata']; ?></div>
        </a>
        
        <!-- Card 3: Gili island (kanan, memanjang ke bawah) -->
        <a href="detail_wisata.php?id=<?php echo $destinasi[2]['id_wisata']; ?>" class="dest-card">
          <img src="uploads/<?php echo $destinasi[2]['gambar_utama']; ?>" alt="<?php echo $destinasi[2]['nama_wisata']; ?>">
          <div class="title"><?php echo $destinasi[2]['nama_wisata']; ?></div>
        </a>
        
        <!-- Card 4: Card besar bawah (lebar 3 kolom) -->
        <a href="detail_wisata.php?id=<?php echo $destinasi[3]['id_wisata']; ?>" class="dest-card">
          <img src="uploads/<?php echo $destinasi[3]['gambar_utama']; ?>" alt="<?php echo $destinasi[3]['nama_wisata']; ?>">
          <div class="title"><?php echo $destinasi[3]['nama_wisata']; ?></div>
        </a>
      <?php endif; ?>
    </div>

    <div class="explore-btn">
      <a href="destinasi.php">explore more destinations</a>
    </div>
  </section>
</body>
</html>