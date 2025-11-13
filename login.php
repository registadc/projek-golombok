<?php
session_start();
include 'koneksi.php';


$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM user WHERE email = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Cek password bcrypt ATAU md5
        if (password_verify($password, $user['password']) || $user['password'] === md5($password)) {

            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];

            // Jika admin → ke dashboard
            if ($user['user_type'] === 'admin') {
                header("Location: admin_dashboard/dashboard.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            $error = "⚠️ Password salah!";
        }
    } else {
        $error = "⚠️ Email tidak ditemukan!";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoLombok</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login {
            display: flex;
            background-color: #fff;
            width: 800px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .login img {
            width: 50%;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .form-container {
            padding: 40px;
            width: 50%;
            margin-top: 80px;
        }

        .form-container h2 {
            margin-bottom: 5px;
            color: #084c61;
            font-size: 22px;
            font-weight: 700;
        }

        .form-container p {
            margin-bottom: 25px;
            font-size: 14px;
            color: #555;
        }

        .form-container p a {
            color: #00bfa6;
            text-decoration: none;
            font-weight: 600;
        }

        .form-container p a:hover {
            text-decoration: underline;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 15px;
            border: none;
            background-color: #e0f7fa;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            color: #084c61;
            transition: background-color 0.3s ease;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            background-color: #b2ebf2;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #00bfa6;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #009f8a;
        }

        .back-home {
            text-align: center;
            margin-top: 15px;
        }

        .back-home a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-home a:hover {
            color: #00bfa6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login {
                flex-direction: column;
                width: 90%;
                max-width: 400px;
            }

            .login img {
                width: 100%;
                height: 200px;
                border-radius: 12px 12px 0 0;
            }

            .form-container {
                width: 100%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login">
        <img src="img/login2.jpeg" alt="Lombok Landscape">
        
        <div class="form-container">
            <form action="" method="POST">
                <h2>Login</h2>
                <p>Don't have an account? <a href="register.php">Register</a></p>

                <div class="form-group">
                    <input type="email" id="email" name="email" required placeholder="Email">
                    <input type="password" id="password" name="password" required placeholder="Password">
                    <input type="submit" value="Login">
                </div>
            </form>

        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (!email || !password) {
                e.preventDefault();
                alert('Email dan password harus diisi');
                return false;
            }
            
            // Validasi format email sederhana
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Format email tidak valid');
                return false;
            }
        });
    </script>
</body>
</html>