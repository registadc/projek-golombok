<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer GoLombok</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .main-content h1 {
            color: #014D4D;
            margin-bottom: 1rem;
        }

        .main-content p {
            line-height: 1.6;
            color: #555;
        }

        footer {
            background-color: #014D4D;
            color: white;
            padding: 3rem 1.5rem 1.5rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr;
            gap: 2rem;
        }

        .footer-brand h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
            font-family: pacifico;
            color: #2EC4B6;
        }

        .footer-brand p {
            color: #e0e0e0;
            margin-bottom: 1.5rem;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
        }

        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background-color: #8db596;
            transform: translateY(-3px);
        }

        .footer-section h4 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.8rem;
        }

        .footer-section ul li a {
            color: #e0e0e0;
            text-decoration: none;
            transition: color 0.3s;
            font-size: 0.95rem;
        }

        .footer-section ul li a:hover {
            color: #8db596;
        }

        .footer-section p {
            line-height: 1.6;
            color: #e0e0e0;
            font-size: 0.95rem;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #e0e0e0;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .footer-section h4 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <h3>GoLombok</h3>
                <p>Discover the Beauty of Lombok</p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="destinations.php">Destination</a></li>
                    <li><a href="favorites.php">Favorites</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Quick Link</h4>
                <ul>
                    <li><a href="#top-destinations">Top Destinations</a></li>
                    <li><a href="#travel-smart">Travel Smart</a></li>
                    <li><a href="#local-food">Local Food</a></li>
                    <li><a href="#culture">Culture Highlights</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>GoLombok Office</h4>
                <p>Jl. Raya Senggigi No. 88, Senggigi, Batu Layar, Lombok Barat, Nusa Tenggara Barat 83355, Indonesia</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 GoLombok. All rights reserved</p>
        </div>
    </footer>
</body>
</html>