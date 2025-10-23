<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$query = "SELECT * FROM user WHERE id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Update profil
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];

    $update = "UPDATE user SET username=?, email=?, no_telp=? WHERE id_user=?";
    $stmt = $koneksi->prepare($update);
    $stmt->bind_param("sssi", $username, $email, $no_telp, $user_id);

    if ($stmt->execute()) {
        $message = "<div class='message success'>Profil berhasil diperbarui!</div>";
        $user['username'] = $username;
        $user['email'] = $email;
        $user['no_telp'] = $no_telp;
    } else {
        $message = "<div class='message error'>Gagal memperbarui profil.</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Account Setting</title>
<style>
    * {
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: #f4f6f8;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }

    .card {
        background: #fff;
        width: 800px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 40px 50px;
    }

    h2 {
        font-size: 22px;
        color: #444;
        margin-bottom: 25px;
    }

    /* Tabs */
    .tabs {
        display: flex;
        border-bottom: 1px solid #ddd;
        margin-bottom: 25px;
    }

    .tab {
        padding: 8px 20px;
        background: #f7f7f7;
        border: 1px solid #ddd;
        border-bottom: none;
        border-radius: 5px 5px 0 0;
        margin-right: 8px;
        text-decoration: none;
        color: #555;
        font-weight: 500;
        transition: 0.3s;
    }

    .tab.active {
        background: #fff;
        color: #00bfa6;
        border-color: #00bfa6;
        font-weight: 600;
    }

    .tab:hover {
        color: #00bfa6;
    }

    /* Profile layout */
    .profile-container {
        display: flex;
        align-items: flex-start;
        gap: 40px;
    }

    .profile-left {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile-left img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 3px solid #00bfa6;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .logout-btn {
        background: #c52d2dff;
        color: white;
        border: none;
        padding: 8px 25px;
        border-radius: 5px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: #810d0dff;
    }

    form {
        flex: 1;
    }

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 8px;
    }

    .form-group label {
        width: 130px;
        color: #333;
        font-size: 14px;
        font-weight: 500;
    }

    .form-group input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        font-size: 14px;
        color: #555;
    }

    .form-group .edit-icon {
        color: #777;
        font-size: 14px;
        cursor: pointer;
    }

    .save-btn {
        display: block;
        background: #00bfa6;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 40px;
        margin: 25px auto 0;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .save-btn:hover {
        background: #009c89;
    }

    .message {
        text-align: center;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 6px;
        font-weight: 500;
    }

    .success {
        background: #e3f9f4;
        color: #009e7a;
    }

    .error {
        background: #fde8e8;
        color: #c0392b;
    }
</style>

<!-- Font Awesome untuk ikon pensil -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>
<body>

<div class="card">
    <h2>Account Setting</h2>

    <div class="tabs">
        <a href="user_profile.php" class="tab active">Profile</a>
        <a href="home.php" class="tab">Home</a>
        <a href="destinasi.php" class="tab">Destination</a>
        <a href="favorit.php" class="tab">Favorites</a>
    </div>

    <?= $message ?>

    <div class="profile-container">
        <div class="profile-left">
            <img src="uploads/<?= htmlspecialchars($user['foto_profil'] ?: 'default-avatar.jpg') ?>" alt="Profile Picture">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>">
                <i class="fas fa-pen edit-icon"></i>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                <i class="fas fa-pen edit-icon"></i>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" value="<?= htmlspecialchars($user['password']) ?>" readonly>
                <i class="fas fa-pen edit-icon"></i>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="no_telp" value="<?= htmlspecialchars($user['no_telp']) ?>">
                <i class="fas fa-pen edit-icon"></i>
            </div>

            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>
</div>

</body>
</html>
