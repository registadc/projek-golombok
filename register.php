<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        }

        .register {
            display: flex;
            background-color: #fff;
            width: 800px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .register img {
            width: 50%;
            object-fit: cover;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .form-container {
            padding: 40px;
            width: 50%;
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

        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group input[type="email"],
        .form-group input[type="tel"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 15px;
            border: none;
            background-color: #e0f7fa;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            color: #084c61;
        }

        .file-input-container {
            position: relative;
            margin-bottom: 15px;
        }

        .file-input-container input[type="file"] {
            width: 100%;
            padding: 12px 14px;
            border: none;
            background-color: #e0f7fa;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            color: #084c61;
            cursor: pointer;
        }

        .file-input-container::before {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #084c61;
            pointer-events: none;
            z-index: 1;
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
    </style>
</head>
<body>
    <div class="register">
        <div class="form-container">
            <form action="proses_register.php" method="POST" enctype="multipart/form-data">
                <h2>Register</h2>
                <p>Already a member? <a href="login.php">Log in</a></p>

                <div class="form-group">
                    <input type="text" id="username" name="username" required placeholder="Username">
                    <input type="email" id="email" name="email" required placeholder="Email">
                    <input type="password" id="password" name="password" required placeholder="Password">
                    <input type="tel" id="no" name="no" required placeholder="Phone Number">
                    
                    <div class="file-input-container">
                        <input type="file" id="foto" name="foto" accept="image/*" required>
                    </div>

                    <input type="submit" value="Create Account">
                </div>
            </form>
        </div>
        
        <img src="img/register2.jpeg" alt="air laut">
    </div>
</body>
</html>