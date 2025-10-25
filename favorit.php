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

        .container p{
            text-align: center;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
            position: relative;
            padding-bottom: 0.5rem;
            text-align: center;
            
        }

        /* .section-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #ff6b6b;
        } */

       .favorites-grid {
        margin-top: 2rem;
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* dua kolom */
        gap: 1.5rem;
    }

    .favorite-card {
        display: flex;
        background: #E0F7FA;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        cursor: pointer;
    }

    .favorite-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .card-image {
        flex: 0 0 150px;
        height: 150px;
        background-size: cover;
        background-position: center;
    }

    .card-content {
        flex: 1;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #000;
        margin-bottom: 0.2rem;
    }

    .card-category {
        color: #00a896;
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
        font-weight: 500;
    }

    .card-location {
        font-size: 0.85rem;
        color: #444;
        line-height: 1.4;
    }

    /* Ikon love dan hapus */
    .love-icon, .remove-icon {
        position: absolute;
        top: 10px;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff4d4d;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        z-index: 3;
        transition: 0.3s;
        text-decoration: none;
    }

    .love-icon:hover, .remove-icon:hover {
        transform: scale(1.1);
        background: #fff;
    }

    .love-icon { right: 50px; }
    .remove-icon { right: 10px; color: #555; }

    .love-icon i { color: #ff4d4d; }
    .remove-icon i { color: #555; }

    @media (max-width: 600px) {
        .favorites-grid {
            grid-template-columns: 1fr;
        }
        .favorite-card {
            flex-direction: column;
        }
        .card-image {
            width: 100%;
            height: 200px;
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
        <a href="destinasi.php" class="btn-read">Jelajahi Destinasi</a>
    </div>
<?php else: ?>
    <?php while ($destination = $favorites_result->fetch_assoc()): ?>
        <div class="favorite-card" onclick="window.location.href='detail_wisata.php?id_wisata=<?php echo $destination['id_wisata']; ?>'">
            <a href="favorit.php?remove_favorite=<?php echo $destination['id_wisata']; ?>"
               class="love-icon"
               onclick="event.stopPropagation(); return confirm('Hapus dari favorit?');">
               <i class="fas fa-heart"></i>
            </a>

            <a href="favorit.php?remove_favorite=<?php echo $destination['id_wisata']; ?>"
               class="remove-icon"
               onclick="event.stopPropagation(); return confirm('Hapus dari favorit?');">
               <i class="fas fa-trash"></i>
            </a>

            <div class="card-image" style="background-image: url('admin_dashboard/uploads/<?php echo htmlspecialchars($destination['gambar_utama']); ?>')"></div>

            <div class="card-content">
                <div class="card-title"><?php echo htmlspecialchars($destination['nama_wisata']); ?></div>
                <div class="card-category"><?php echo htmlspecialchars($destination['nama_kategori']); ?></div>
                <div class="card-location"><?php echo htmlspecialchars($destination['lokasi']); ?></div>
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