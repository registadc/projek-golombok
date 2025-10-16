<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <div class="register">
        <img src="img/regsiter.jpeg" alt="air laut">
        <div class="form-container">
            <form action="proses_register.php" method="POST">
                <h2>Register</h2>
                <p>Already a member?<a href="login.php">Log in</a></p>
                <div class="form-group">
                    <input type="text" id="username" name="username" required placeholder="Username">

                    <input type="text" id="email" name="email" required  placeholder="Email">

                    <input type="text" id="password" name="password" required placeholder="Password">

                    <input type="text" id="no" name="no" required placeholder="Phone Number">

                    <input type="file" id="foto" name="foto" accept="img/*" required placeholder="Profile Picture">

                    <input type="button" value="Create Account" onclick="this.form.submit()">
                </div>
            </form>

    </div>
</body>
</html>