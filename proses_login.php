<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = '';
$no_telp = '';
$username = '';
$nama_lengkap = '';
$foto_profil = '';

// Ambil data user dari database
$query = "SELECT * FROM user WHERE id_user = ?";
$stmt = $koneksi->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Inisialisasi variabel dengan data dari database
        $email = $user['email'];
        $no_telp = isset($user['no_telp']) ? $user['no_telp'] : '';
        $username = $user['username'];
        $nama_lengkap = isset($user['nama_lengkap']) ? $user['nama_lengkap'] : '';
        $foto_profil = isset($user['foto_profil']) ? $user['foto_profil'] : 'default-avatar.jpg';
    } else {
        // Jika user tidak ditemukan
        session_destroy();
        header("Location: login.php");
        exit();
    }
    $stmt->close();
} else {
    echo "Error: " . $koneksi->error;
}

// Proses update profile
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_email = isset($_POST['email']) ? $_POST['email'] : '';
    $new_no_telp = isset($_POST['no_telp']) ? $_POST['no_telp'] : '';
    $new_username = isset($_POST['username']) ? $_POST['username'] : '';
    $new_nama_lengkap = isset($_POST['nama_lengkap']) ? $_POST['nama_lengkap'] : '';
    
    // Validasi input
    if (empty($new_email) || empty($new_username)) {
        $error = "Email dan username harus diisi";
    } else {
        // Update data user
        $update_query = "UPDATE user SET email = ?, no_telp = ?, username = ?, nama_lengkap = ? WHERE id_user = ?";
        $update_stmt = $koneksi->prepare($update_query);
        
        if ($update_stmt) {
            $update_stmt->bind_param("ssssi", $new_email, $new_no_telp, $new_username, $new_nama_lengkap, $user_id);
            
            if ($update_stmt->execute()) {
                $success = "Profile berhasil diupdate!";
                // Update session dan variabel
                $_SESSION['username'] = $new_username;
                $_SESSION['email'] = $new_email;
                $email = $new_email;
                $no_telp = $new_no_telp;
                $username = $new_username;
                $nama_lengkap = $new_nama_lengkap;
            } else {
                $error = "Gagal mengupdate profile: " . $update_stmt->error;
            }
            $update_stmt->close();
        } else {
            $error = "Terjadi kesalahan sistem";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Setting - GoLombok</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 40px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-brand {
            font-size: 24px;
            font-weight: 700;
            color: #084c61;
            text-decoration: none;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }

        .nav-menu a {
            color: #555;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .nav-menu a:hover {
            background-color: #e0f7fa;
            color: #084c61;
        }

        .nav-menu a.active {
            background-color: #00bfa6;
            color: white;
        }

        .logout-btn {
            background-color: #ff4757;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #ff3742;
        }

        /* Main Content Styles */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-header h1 {
            color: #084c61;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #666;
            font-size: 18px;
        }

        .profile-container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Profile Card Styles */
        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            height: fit-content;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #00bfa6;
            margin-bottom: 20px;
        }

        .profile-name {
            color: #084c61;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-email {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .profile-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 18px;
            font-weight: 700;
            color: #084c61;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
        }

        /* Profile Form Styles */
        .profile-form {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h3 {
            color: #084c61;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0f7fa;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #084c61;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            color: #333;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #00bfa6;
        }

        .submit-btn {
            background-color: #00bfa6;
            color: white;
            border: none;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background-color: #009f8a;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #ffcdd2;
        }

        .success-message {
            background: #e8f5e8;
            color: #2e7d32;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #c8e6c9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }

            .nav-container {
                flex-direction: column;
                gap: 15px;
            }

            .nav-menu {
                gap: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .profile-container {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="home.php" class="nav-brand">GoLombok</a>
            <ul class="nav-menu">
                <li><a href="home.php">Home</a></li>
                <li><a href="destination.php">Destination</a></li>
                <li><a href="favorites.php">Favorites</a></li>
                <li><a href="#" class="active">Profile</a></li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1>Account Setting</h1>
            <p>Manage your account information and preferences</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <div class="profile-container">
            <!-- Profile Card -->
            <div class="profile-card">
                <img src="<?php echo htmlspecialchars($foto_profil); ?>" alt="Profile Picture" class="profile-image" 
                     onerror="this.src='default-avatar.jpg'">
                <h2 class="profile-name"><?php echo htmlspecialchars($nama_lengkap ?: $username); ?></h2>
                <p class="profile-email"><?php echo htmlspecialchars($email); ?></p>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <span class="stat-number">12</span>
                        <span class="stat-label">Trips</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">8</span>
                        <span class="stat-label">Reviews</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24</span>
                        <span class="stat-label">Photos</span>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <form action="" method="POST" class="profile-form">
                <div class="form-section">
                    <h3>Personal Information</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" required 
                                   value="<?php echo htmlspecialchars($username); ?>">
                        </div>

                        <div class="form-group">
                            <label for="nama_lengkap">Full Name</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap"
                                   value="<?php echo htmlspecialchars($nama_lengkap); ?>">
                        </div>

                        <div class="form-group full-width">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo htmlspecialchars($email); ?>">
                        </div>

                        <div class="form-group">
                            <label for="no_telp">Phone Number</label>
                            <input type="text" id="no_telp" name="no_telp" placeholder="+62 8180-7654-5432"
                                   value="<?php echo htmlspecialchars($no_telp); ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Validasi form client-side
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const username = document.getElementById('username').value.trim();
            
            if (!email || !username) {
                e.preventDefault();
                alert('Email dan username harus diisi');
                return false;
            }
            
            // Validasi format email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Format email tidak valid');
                return false;
            }
        });

        // Format phone number
        document.getElementById('no_telp').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+62' + value.substring(1);
            }
            
            // Format: +62 8180-7654-5432
            if (value.length > 3) {
                value = value.replace(/(\+\d{2})(\d{4})(\d{4})(\d{4})/, '$1 $2-$3-$4');
            }
            e.target.value = value;
        });
    </script>
</body>
</html>