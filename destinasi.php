<?php
include 'koneksi.php';


$result = $koneksi->query("SELECT * FROM kategori");


$kategori_id = "";
if (isset($_GET['kategori']) && !empty($_GET['kategori'])) {
    $kategori_id = $_GET['kategori'];
    $sql = "SELECT * FROM wisata WHERE id_kategori = '$kategori_id'";
} elseif (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $sql = "SELECT * FROM wisata WHERE nama_wisata LIKE '%$keyword%' OR lokasi LIKE '%$keyword%'";
} else {
    $sql = "SELECT * FROM wisata";
}

$destinasi = $koneksi->query($sql);

if (isset($_GET['add_favorite']) && isset($_GET['id_wisata'])) {
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['id_user'];
        $wisata_id = $_GET['id_wisata'];
        
        // Cek apakah sudah ada di favorit
        $check = $koneksi->query("SELECT * FROM favorit WHERE id_user = '$id_user' AND id_wisata = '$id_wisata'");
        
        if ($check->num_rows > 0) {
            // Jika sudah ada, hapus dari favorit
            $koneksi->query("DELETE FROM favorit WHERE id_user = '$id_user' AND id_wisata = '$id_wisata'");
            $favorite_message = "Destinasi dihapus dari favorit";
        } else {
            // Jika belum ada, tambahkan ke favorit
            $koneksi->query("INSERT INTO favorit (id_user, id_wisata) VALUES ('$id_user', '$id_wisata')");
            $favorite_message = "Destinasi ditambahkan ke favorit";
        }
        
        // Redirect kembali ke halaman destinasi dengan pesan
        header("Location: destinasi.php?kategori=" . (isset($_GET['kategori']) ? $_GET['kategori'] : '') . "&keyword=" . (isset($_GET['keyword']) ? $_GET['keyword'] : '') . "&message=" . urlencode($favorite_message));
        exit();
    } else {
        $favorite_message = "Anda harus login terlebih dahulu";
        header("Location: destinasi.php?kategori=" . (isset($_GET['kategori']) ? $_GET['kategori'] : '') . "&keyword=" . (isset($_GET['keyword']) ? $_GET['keyword'] : '') . "&message=" . urlencode($favorite_message));
        exit();
    }
}

// Cek status favorit untuk setiap destinasi
session_start();
$favorites = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $favorite_result = $koneksi->query("SELECT wisata_id FROM favorites WHERE user_id = '$user_id'");
    while ($row = $favorite_result->fetch_assoc()) {
        $favorites[] = $row['wisata_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {box-sizing:border-box; margin:0; padding:0;}

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color:#333;
        }

        .cover {
            position: relative;
            min-height: 70vh;
            background: url('img/bilebante.jpeg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-start;
            background-size: cover;
            background-position: center;
            padding: 3rem 4rem;
            text-align: left;
            color: white;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            overflow: hidden;
        }

        .cover::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            z-index: 0;
        }

        .cover > * {
            position: relative;
            z-index: 1;
        }

        .cover h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .content {
            padding: 3rem 4rem;
        }

        .destinasi h2 {
            font-size: 30px;
            font-weight: 700;
            color: #073B4C;
            margin-bottom: 8px;
            text-align: center; 
        }

        .destinasi p {
            color: #555;
            margin-bottom: 30px;
            text-align: center;
            font-size: 20px;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .search-form {
            display: flex;
            flex: 1;
            min-width: 300px;
        }

        .search-form input[type="text"] {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-form button {
            padding: 10px 15px;
            background-color: #00bfa6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 5px;
        }

        .filter-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-container label {
            font-weight: 500;
        }

        .filter-container select {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: white;
        }

        .daftar-destinasi {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .destinasi-item {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden; /* Penting supaya rounded bawah tombol ikut rapi */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .destinasi-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .destinasi-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .destinasi-item h3 {
            font-size: 18px;
            color: #024950;
            margin-bottom: 8px;
            text-align: left;
            padding-left: 15px;
        }

        .destinasi-item p {
            color: #555;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: left;
            padding-left: 15px;
        }

        .btn-read {
            display: block;                 
            width: 100%;
            background-color: #004d4d;      
            color: #ffffff;                 
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            padding: 15px 0;
            border: none;
            border-radius: 0 0 10px 10px;   
            transition: all 0.3s ease;
            text-align: center;
            cursor: pointer;
            box-shadow: inset 0 0 0 0 #00796b;
        }

        .btn-read:hover {
            background-color: #009e89;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #777;
            font-style: italic;
        }

        /* Style untuk ikon love */
        .love-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.8);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
            text-decoration: none;
        }

        .love-icon:hover {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.1);
        }

        .love-icon i {
            color: #ff4757;
            font-size: 18px;
        }

        .love-icon.active i {
            color: #ff4757;
        }

        /* Style untuk kategori */
        .kategori-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .kategori-item {
            padding: 8px 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .kategori-item:hover, .kategori-item.active {
            background-color: #00bfa6;
            color: white;
            border-color: #00bfa6;
        }

        /* Style untuk pesan */
        .message {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .cover {
                padding: 2rem;
                min-height: 50vh;
            }
            
            .content {
                padding: 2rem;
            }
            
            .search-container {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-form {
                min-width: 100%;
            }
            
            .filter-container {
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="cover">
        <h1>Destinasi</h1>
        <p>Destinasi wisata di Lombok</p>
    </div>

    <div class="content">
        <div class="destinasi">
            <h2>Destinasi Terbaik di Lombok Menantimu</h2>
            <p>Nikmati serunya petualangan alam, jelajahi pantai eksotis,
                mendaki gunung megah, dan menyelami budaya lokal yang memikat</p>
            
            <!-- Tampilkan pesan -->
            <?php if (isset($_GET['message'])): ?>
                <div class="message <?php echo strpos($_GET['message'], 'login') !== false ? 'error' : 'success'; ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php endif; ?>
            
            <!-- Kategori -->
            <div class="kategori-container">
                <div class="kategori-item <?php echo empty($kategori_id) ? 'active' : ''; ?>" onclick="clearCategoryFilter()">Semua</div>
                <?php
                // Reset pointer result untuk iterasi ulang
                $result->data_seek(0);
                while ($row = $result->fetch_assoc()) {
                    $active = (isset($_GET['kategori']) && $_GET['kategori'] == $row['id_kategori']) ? 'active' : '';
                    echo "<div class='kategori-item {$active}' onclick=\"filterByCategory('{$row['id_kategori']}')\">{$row['nama_kategori']}</div>";
                }
                ?>
            </div>
            
            <div class="search-container">
                <form method="GET" action="destinasi.php" class="search-form">
                    <input type="text" name="keyword" placeholder="Search destination..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                    <button type="submit"><i class="fas fa-search"></i> Search</button>
                </form>

                
            </div>  

            <div class="daftar-destinasi">
                <?php
                if ($destinasi->num_rows > 0) {
                    while ($row = $destinasi->fetch_assoc()) {
                        $is_favorite = in_array($row['id_wisata'], $favorites);
                        $heart_icon = $is_favorite ? 'fas' : 'far';
                        
                        echo "
                        <div class='destinasi-item'>
                            <a href='destinasi.php?add_favorite=1&wisata_id={$row['id_wisata']}&kategori=" . (isset($_GET['kategori']) ? $_GET['kategori'] : '') . "&keyword=" . (isset($_GET['keyword']) ? $_GET['keyword'] : '') . "' class='love-icon " . ($is_favorite ? 'active' : '') . "'>
                                <i class='{$heart_icon} fa-heart'></i>
                            </a>
                            <img src='admin_dashboard/uploads/{$row['gambar_utama']}' alt='{$row['nama_wisata']}'>
                            <h3>{$row['nama_wisata']}</h3>
                            <p>{$row['lokasi']}</p>
                            <a href='detail_wisata.php?id_wisata={$row['id_wisata']}' class='btn-read'>Read More</a>
                        </div>";
                    }
                } else {
                    echo "<div class='no-results'>Tidak ada destinasi yang ditemukan.</div>";
                }
                ?>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function filterByCategory(categoryId) {
            const url = new URL(window.location.href);
            
            if (categoryId) {
                url.searchParams.set('kategori', categoryId);
                // Hapus parameter pencarian jika ada
                url.searchParams.delete('keyword');
            } else {
                url.searchParams.delete('kategori');
            }
            
            window.location.href = url.toString();
        }

        function filterByCategorySelect() {
            const kategori = document.getElementById('kategori').value;
            filterByCategory(kategori);
        }

        function clearCategoryFilter() {
            filterByCategory('');
        }
    </script>
</body>
</html>