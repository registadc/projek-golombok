<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

// PERBAIKAN: Gunakan session variable yang konsisten
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// PERBAIKAN: Gunakan $_SESSION['user_id'] bukan $_SESSION['id_user']
$user_id = $_SESSION['user_id'];

// Handle remove favorite
if (isset($_GET['remove_favorite']) && !empty($_GET['remove_favorite'])) {
    $wisata_id = $_GET['remove_favorite'];
    
    $delete_query = "DELETE FROM favorit WHERE id_user = '$user_id' AND id_wisata = '$wisata_id'";
    if ($koneksi->query($delete_query)) {
        $message = "Destinasi berhasil dihapus dari favorit!";
        $message_type = "success";
    } else {
        $message = "Error: " . $koneksi->error;
        $message_type = "error";
    }
}

// Query untuk mendapatkan destinasi favorit user
$favorites_query = "
    SELECT w.*, k.nama_kategori 
    FROM wisata w 
    INNER JOIN favorit f ON w.id_wisata = f.id_wisata 
    LEFT JOIN kategori k ON w.id_kategori = k.id_kategori 
    WHERE f.id_user = '$user_id' 
    ORDER BY f.created_at DESC
";

$favorites_result = $koneksi->query($favorites_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites - Goldenbuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            background: url('img/favorit.jpeg') no-repeat center center/cover;
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
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .cover p {
            font-size: 1.2rem;
            font-weight: 400;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 50vh;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #ff6b6b;
        }

        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .favorite-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .favorite-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card-image {
            height: 200px;
            width: 100%;
            background-size: cover;
            background-position: center;
            background-color: #eee; /* Fallback jika gambar tidak ada */
        }

        .card-content {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .card-location {
            display: flex;
            align-items: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .card-location i {
            margin-right: 0.5rem;
            color: #ff6b6b;
        }

        .card-category {
            display: inline-block;
            background: #f0f0f0;
            color: #666;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .card-description {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .btn-read {
            background-color: #004d4d;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .btn-read:hover {
            background-color: #009e89;
        }

        .remove-btn {
            background: #ff6b6b;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remove-btn:hover {
            background: #ff3b3b;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #ddd;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .message {
            padding: 1rem;
            margin: 1rem 0;
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

        /* Style untuk ikon love di card */
        .love-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .love-icon:hover {
            background: white;
            transform: scale(1.1);
        }

        .love-icon i {
            color: #ff4757;
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .cover {
                padding: 2rem;
                min-height: 60vh;
            }
            
            .cover h1 {
                font-size: 2.5rem;
            }
            
            .container {
                padding: 1rem;
            }
            
            .favorites-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="cover">
        <h1>Favorites</h1>
        <p>Destinasi wisata favoritmu</p>
    </div>

    <div class="container">
        <h2 class="section-title">Best of Lombok</h2>
        <p>Pilihan wisata menarik yang wajib masuk dalam daftar perjalananmu di Lombok.</p>
        
        <?php
        // Tampilkan pesan
        if (isset($message)) {
            echo "<div class='message {$message_type}'>{$message}</div>";
        }
        ?>
        
        <div class="favorites-grid">
            <?php if ($favorites_result->num_rows === 0): ?>
                <div class="empty-state">
                    <i class="far fa-heart"></i>
                    <h3>Belum ada destinasi favorit</h3>
                    <p>Tambahkan destinasi favoritmu dengan menekan ikon hati di halaman destinasi.</p>
                    <a href="destinasi.php" class="btn-read" style="display: inline-block; margin-top: 1rem; text-decoration: none;">
                        Jelajahi Destinasi
                    </a>
                </div>
            <?php else: ?>
                <?php while ($destination = $favorites_result->fetch_assoc()): ?>
                    <div class="favorite-card">
                        <!-- Ikon love untuk menghapus favorit -->
                        <a href="favorit.php?remove_favorite=<?php echo $destination['id_wisata']; ?>" 
                           class="love-icon" 
                           onclick="return confirm('Hapus destinasi ini dari favorit?')"
                           title="Hapus dari Favorit">
                            <i class="fas fa-heart"></i>
                        </a>
                        
                        <!-- Gambar destinasi -->
                        <div class="card-image" 
                             style="background-image: url('admin_dashboard/uploads/<?php echo htmlspecialchars($destination['gambar_utama']); ?>')">
                        </div>
                        
                        <div class="card-content">
                            <!-- Nama destinasi -->
                            <h3 class="card-title"><?php echo htmlspecialchars($destination['nama_wisata']); ?></h3>
                            
                            <!-- Lokasi -->
                            <div class="card-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($destination['lokasi']); ?></span>
                            </div>
                            
                            <!-- Kategori -->
                            <?php if (!empty($destination['nama_kategori'])): ?>
                                <div class="card-category"><?php echo htmlspecialchars($destination['nama_kategori']); ?></div>
                            <?php endif; ?>
                            
                            <!-- Deskripsi singkat -->
                            <?php if (!empty($destination['deskripsi'])): ?>
                                <p class="card-description"><?php echo htmlspecialchars(substr($destination['deskripsi'], 0, 150)); ?>...</p>
                            <?php endif; ?>
                            
                            <!-- Actions -->
                            <div class="card-actions">
                                <a href="detail_wisata.php?id_wisata=<?php echo $destination['id_wisata']; ?>" class="btn-read">
                                    Lihat Detail
                                </a>
                                <a href="favorit.php?remove_favorite=<?php echo $destination['id_wisata']; ?>" 
                                   class="remove-btn" 
                                   onclick="return confirm('Hapus dari favorit?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Konfirmasi sebelum menghapus favorit
        function confirmRemove(event) {
            if (!confirm('Hapus destinasi ini dari favorit?')) {
                event.preventDefault();
                return false;
            }
            return true;
        }

        // Tambahkan event listener untuk semua link hapus
        document.addEventListener('DOMContentLoaded', function() {
            const removeLinks = document.querySelectorAll('a[href*="remove_favorite"]');
            removeLinks.forEach(link => {
                link.addEventListener('click', confirmRemove);
            });
        });
    </script>
</body>
</html>