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
      background-color: #f5f5f5;
      color:#333;
    }

    header {
      width: 100%;
      padding: 15px 40px;
      position: fixed;
      top: 0; left: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 9999;
      transition: all 0.3s ease;
      background: transparent;
    }
    header a {
      text-decoration: none;
      color: #fff; 
      transition: color 0.3s ease;
    }
    header.scrolled {
      background: #fff;  
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    header.scrolled a { color: #333; }
    header.scrolled .judul { color: #2EC4B6; }

    header .judul {
      font-family: 'Pacifico', cursive;
      font-size: 24px;
      color: #2EC4B6; 
    }

    nav {
      display:flex;
      gap:24px;
      align-items:center;
    }
    nav a {
      text-decoration:none;
      font-weight:500;
      transition:.3s;
    }
    nav a:hover { color:#00C9A7; }

    /* Login button */
    .login-btn {
      background: #00C9A7;
      color: #fff;
      padding: 6px 16px;
      border-radius: 6px;
      font-weight: 500;
      transition: 0.3s;
    }
    .login-btn:hover { background: #009E85; }

    /* User icon */
    .user-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background-color: rgba(255,255,255,0.15);
      transition: background-color 0.3s;
    }
    .user-icon:hover {
      background-color: #00C9A7;
      color: white;
    }

    /* Hero Section */
    .home {
      height:70vh; 
      background:url('img/rinjani.jpeg') center/cover no-repeat;
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      text-align:center;
      padding:0 20px;
      position:relative;
      overflow:hidden;
      background-color: #ffffff;
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

    .home-container h1 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .home-container p{
      margin-top: 20px;
      font-size: 1.1rem;
      line-height: 1.6;
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
      gap: 6px;
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
      border-radius: 8px;
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

    /* ====== DESTINATIONS SECTION ====== */
    .destinations {
      text-align: center;
      padding: 80px 20px 40px;
      background-color: #f5f5f5;
    }
    .destinations h2 {
      font-size: 24px;
      font-weight: 700;
      color: #073B4C;
      margin-bottom: 8px;
    }
    .destinations p {
      color: #555;
      margin-bottom: 30px;
    }

    .dest-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(2, 200px);
      gap: 15px;
      max-width: 1000px;
      margin: 0 auto;
      grid-template-areas: 
        "card1 card2 card3"
        "card1 card4 card4";
    }

    .dest-card {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.15);
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .dest-card:hover {
      transform: translateY(-3px);
    }

    .dest-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform 0.3s ease;
      background: #e0e0e0;
    }

    .dest-card:hover img {
      transform: scale(1.03);
    }

    .dest-card .title {
      position: absolute;
      bottom: 12px;
      left: 12px;
      color: white;
      font-weight: 600;
      font-size: 16px;
      text-shadow: 0 2px 4px rgba(0,0,0,0.7);
      z-index: 2;
    }

    .dest-card::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 60%;
      background: linear-gradient(transparent, rgba(0,0,0,0.6));
      border-radius: 10px;
    }

    .dest-card:nth-child(1) {
      grid-area: card1;
    }
    .dest-card:nth-child(2) {
      grid-area: card2;
    }
    .dest-card:nth-child(3) {
      grid-area: card3;
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
      text-transform: lowercase;
    }
    .explore-btn a:hover {
      background:#009688;
    }

    /* ====== TRAVEL SMART SECTION ====== */
    .travel {
      position: relative;
      text-align: center;
      color: white;
      font-family: 'Poppins', sans-serif;
      overflow: hidden;
      padding: 60px 20px;
      margin: 40px 0;
      height: 500px; /* Tinggi yang lebih sesuai */
    }

    /* Background image yang lebih sesuai */
    .travel-bg {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(50%);
      position: absolute;
      top: 0;
      left: 0;
      z-index: 0;
    }

    /* Judul & deskripsi di tengah */
    .travel h2 {
      position: relative;
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 10px;
      z-index: 1;
    }

    .travel p {
      position: relative;
      font-size: 16px;
      color: #f0f0f0;
      margin-bottom: 40px;
      z-index: 1;
    }

    /* Container tips */
    .travel-container {
      position: relative;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
      z-index: 1;
    }

    .travel-tips {
      background: rgba(255, 255, 255, 0.1);
      width: 300px;
      padding: 25px 20px;
      border-radius: 12px;
      backdrop-filter: blur(6px);
      transition: all 0.3s ease;
    }

    .travel-tips:hover {
      background: rgba(255, 255, 255, 0.2);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      transform: translateY(-5px);
    }

    /* Icon lingkaran */
    .travel-tips i {
      display: inline-block;
      background: #ffffff;
      color: #39b9a3;
      font-size: 20px;
      padding: 15px;
      border-radius: 50%;
      margin-bottom: 15px;
    }

    /* Subjudul tiap tips */
    .travel-tips h3 {
      color: white;
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 8px;
    }

    /* Deskripsi */
    .travel-tips p {
      color: #e0e0e0;
      font-size: 14px;
      line-height: 1.5;
      margin: 0;
    }

    /* ====== HIGHLIGHTS SECTION ====== */
    /* .highlights {
      text-align: center;
      padding: 60px 20px;
      background-color: #f5f5f5;
    }

    .highlights h2 {
      font-size: 24px;
      font-weight: 700;
      color: #073B4C;
      margin-bottom: 8px;
    }

    .highlights p {
      color: #555;
      margin-bottom: 40px;
    }

    .highlights-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .highlights-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      width: 270px;
      transition: transform 0.3s ease;
    }

    .highlights-card:hover {
      transform: translateY(-5px);
    }

    .highlights-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .highlights-card h3 {
      color: #073B4C;
      font-size: 18px;
      font-weight: 600;
      margin: 15px 0 10px;
    }

    .highlights-card p {
      color: #555;
      font-size: 14px;
      line-height: 1.5;
      padding: 0 15px 20px;
      margin: 0;
    } */
/* ===== SECTION HIGHLIGHTS ===== */
.highlights {
  text-align: center;
  max-width: 1000px;
  margin: 0 auto;
  padding: 40px 20px;
  margin-bottom: 60px;
}

.highlights h2 {
  font-size: 24px;
  font-weight: 700;
  color: #003b3f;
  margin-bottom: 10px;
}

.highlights p {
  color: #333;
  font-size: 16px;
  margin-bottom: 40px;
}

/* GRID UTAMA: 2x2 */
.highlights-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 2 kolom */
  gap: 25px; /* jarak antar card */
  justify-items: center;
}

/* KARTU */
.highlights-card {
  display: flex;
  align-items: center;
  gap: 15px;
  background-color: #e6f9ff;
  border-radius: 20px;
  padding: 20px;
  width: 100%;
  max-width: 450px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.highlights-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.highlights-card img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
   object-fit: cover;
  flex-shrink: 0;
}

/* TEKS DALAM CARD */
.text-content {
  display: flex;
  flex-direction: column; /* agar h3 di atas p */
  text-align: left;
}

.text-content h3 {
  margin: 0;
  font-size: 18px;
  font-weight: 700;
  color: #004b5f;
}

.text-content p {
  margin-top: 5px;
  font-size: 15px;
  color: #333;
  line-height: 1.4;
}


    /* ====== ANIMASI MUNCUL SAAT SCROLL ====== */

    /* Awal elemen tersembunyi */
    .reveal {
      opacity: 0;
      transform: translateY(40px);
      transition: all 0.8s ease-out;
    }

    /* Saat elemen terlihat di layar */
    .reveal.show {
      opacity: 1;
      transform: translateY(0);
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .dest-grid {
        grid-template-columns: 1fr;
        grid-template-rows: repeat(4, 200px);
        grid-template-areas: 
          "card1"
          "card2"
          "card3"
          "card4";
      }
      
      .travel-container,
      .highlights-container {
        flex-direction: column;
        align-items: center;
      }
      
      .travel-tips,
      .highlights-card {
        width: 90%;
      }
      
      .home-container h1 {
        font-size: 2rem;
      }
      
      .home-container p {
        font-size: 1rem;
      }
      
      .travel {
        height: auto; /* Tinggi otomatis di mobile */
        padding: 40px 20px;
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
    if(isset($_SESSION['user_id'])): ?>
      <!-- PERBAIKAN: Hanya tampilkan icon user saja -->
      <a href="user_profile.php" class="user-icon" title="Profile">
        <i class="fas fa-user"></i>
      </a>
    <?php else: ?>
      <!-- Tampilkan tombol login jika belum login -->
      <a href="login.php" class="login-btn">Login</a>
    <?php endif; ?>
  </nav>
</header>

<!------------------COVER------------->
  <section class="home">
    <div class="home-container">
      <h1>Discover the Beauty of Lombok</h1>
      <p>Eksplorasi keindahan alam, budaya, dan petualangan terbaik di Lombok.  
      Temukan destinasi populer, tips perjalanan, dan pengalaman yang membuat  
      liburanmu tak terlupakan, semua dalam satu tempat.</p>
    </div>

    <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
      <path d="M0,100 C150,200 350,0 500,100 L500,150 L0,150 Z" style="fill:#f5f5f5;"></path>
    </svg>
  </section>

  <form action="destinasi.php" method="get" class="search-box">
    <div class="categories">
            <a href="destinasi.php?kategori=1">
   <i class="fas fa-mountain-sun"></i> Alam
</a>
<a href="destinasi.php?kategori=2">
  <i class="fas fa-umbrella-beach"></i> Pantai
</a>
<a href="destinasi.php?kategori=3">
  <i class="fas fa-landmark"></i> Budaya
</a>
 

    </div>

    <input type="text" name="q" placeholder="Gunung Rinjani...">
    <button type="submit"><i class="fas fa-search"></i></button>
  </form>

<!----------------TOP DESTINASI------------->
<section class="destinations">
    <h2>Top Destinations</h2>
    <p>Destinasi terbaik Lombok untuk liburan tak terlupakan.</p>

    <div class="dest-grid">
        <?php
        include "koneksi.php";
        
        $query = mysqli_query($koneksi, "SELECT * FROM wisata LIMIT 4");
        $destinasi = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $destinasi[] = $row;
        }
        
        // Jika data dari database tersedia
        if(count($destinasi) >= 4): 
            for($i = 0; $i < 4; $i++):
            $d = $destinasi[$i];
        ?>
            <!-- PERBAIKAN: ganti id menjadi id_wisata -->
            <a href="detail_wisata.php?id_wisata=<?= $d['id_wisata']; ?>" class="dest-card reveal">
                <img src="<?= !empty($d['gambar_utama']) ? 'admin_dashboard/uploads/'.$d['gambar_utama'] : 'images/default.jpg'; ?>" 
                    alt="<?= $d['nama_wisata']; ?>"
                    onerror="this.src='images/default.jpg'">
                <div class="title"><?= $d['nama_wisata']; ?></div>
            </a>
        <?php 
            endfor; 
        else: 
            // Fallback jika data tidak tersedia
        ?>
            <a href="#" class="dest-card reveal">
                <img src="img/rinjani.jpeg" alt="Gunung Rinjani">
                <div class="title">Gunung Rinjani</div>
            </a>
            <a href="#" class="dest-card reveal">
                <img src="img/pink-beach.jpeg" alt="Pink Beach">
                <div class="title">Pink Beach</div>
            </a>
            <a href="#" class="dest-card reveal">
                <img src="img/gili-trawangan.jpeg" alt="Gili Trawangan">
                <div class="title">Gili Trawangan</div>
            </a>
            <a href="#" class="dest-card reveal">
                <img src="img/sendang-gile.jpeg" alt="Air Terjun Sendang Gile">
                <div class="title">Air Terjun Sendang Gile</div>
            </a>
        <?php endif; ?>
    </div>

    <div class="explore-btn reveal">
        <a href="destinasi.php">explore more destinations</a>
    </div>
</section>

  <!----------------TRAVEL SMART------------->
  <div class="travel reveal">
    <img src="img/bg travel.jpeg" alt="Travel background" class="travel-bg">
    <h2>Travel Smart di Lombok</h2>
    <p>Tips & trik perjalanan ke surga tropis</p>
    
    <div class="travel-container">
      <div class="travel-tips reveal">
        <i class="fa-solid fa-calendar-days"></i>
        <h3>Waktu terbaik</h3>
        <p>Datanglah antara bulan April sampai September (musim kemarau) untuk cuaca cerah dan laut tenang.</p>
      </div>

      <div class="travel-tips reveal">
        <i class="fa-solid fa-plane"></i>
        <h3>Transportasi</h3>
        <p>Bandara Internasional Lombok (ZAMIA), rute kapal dari Bali, sewa motor, mobil, atau taksi online.</p>
      </div>

      <div class="travel-tips reveal">
        <i class="fa-solid fa-house"></i>
        <h3>Area menginap</h3>
        <p>Mataram (akses kota), Senggigi (pantai & sunset), Kuta (surfer & Mandalika), Gili Islands (pulau santai).</p>
      </div>
    </div>
  </div>

  <!----------------HIGHLIGHTS------------->
 <section class="highlights reveal">
  <h2>Local Food & Culture Highlights</h2>
  <p>Rasakan cita rasa khas Lombok dan kekayaan budayanya dalam satu perjalanan.</p>

  <div class="highlights-grid reveal">
  <div class="highlights-card" onclick="openVideo('https://www.youtube.com/watch?v=g_rJkNbxVq8')">
    <img src="img/ayam.jpeg" alt="Ayam Taliwang">
    <div class="text-content">
      <h3>Ayam Taliwang</h3>
      <p>Ayam panggang pedas khas Lombok, gurih dan penuh rempah.</p>
    </div>
  </div>

  <div class="highlights-card" onclick="openVideo('https://www.youtube.com/watch?v=CvShDN4CdsU')">
    <img src="img/kangkung.jpeg" alt="Plecing Kangkung">
    <div class="text-content">
      <h3>Plecing Kangkung</h3>
      <p>Kangkung segar dengan sambal pedas tomat, pelengkap sempurna Ayam Taliwang.</p>
    </div>
  </div>

  <div class="highlights-card" onclick="openVideo('https://www.youtube.com/watch?v=xjvIlSmVjCg')">
    <img src="img/nyale.jpg" alt="Festival Bau Nyale">
    <div class="text-content">
      <h3>Festival Bau Nyale</h3>
      <p>Tradisi tahunan menangkap cacing laut, terkait legenda Putri Mandalika.</p>
    </div>
  </div>

  <div class="highlights-card" onclick="openVideo('https://www.youtube.com/watch?v=WP-wQAxF5uA')">
    <img src="img/budaya.jpg" alt="Tari Peresean">
    <div class="text-content">
      <h3>Tari Peresean</h3>
      <p>Pertunjukan seni bela diri tradisional Sasak menggunakan tongkat rotan.</p>
    </div>
  </div>
</div>

</section>

<?php include "footer.php"; ?>

  <!----------------SCRIPT EFEK SCROLL------------->
  <script>
     function openVideo(url) {
      window.open(url, '_blank'); // buka YouTube di tab baru
    }

  document.addEventListener("DOMContentLoaded", function() {
    const reveals = document.querySelectorAll('.reveal');

    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('show');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });

    reveals.forEach(r => observer.observe(r));
  });

  window.addEventListener("scroll", function() {
  const header = document.querySelector("header");
  if (window.scrollY > 50) { 
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }

});
  </script>
</body>
</html>