<?php
// 5 saniye sonra anasayfaya yönlendir
header("refresh:5;url=index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Results</title>
    <link rel="stylesheet" href="about_css.css">
    <script src="script_main.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        /* Sayfa Gövdesi */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding-top: 100px;
            height: 100vh; /* Sayfa yüksekliği */
            overflow: hidden; /* Sayfa taşmasını engelle */
            background-color: #111; /* Koyu bir arka plan */
        }

        /* Başlık (h2) */
        h2 {
            color: rgba(255, 100, 0, 1); /* Turuncu renk */
            font-size: 36px; /* Makul boyutta başlık */
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px; /* Harfler arası boşluk */
            text-shadow: 0 0 15px rgba(255, 100, 0, 0.8), 0 0 25px rgba(255, 100, 0, 0.6); /* Işıltılı efekt */
            animation: glowing 1.5s ease-in-out infinite; /* Işıltı efekti */
            z-index: 10; /* Yazı üstte olacak */
            margin-bottom: 20px;
        }

        /* Paragraf (p) */
        p {
            color: rgba(255, 100, 0, 0.9);
            font-size: 18px; /* Başlık kadar büyük olmayan bir boyut */
            font-weight: 400;
            margin-top: 10px;
            text-shadow: 0 0 10px rgba(255, 100, 0, 0.5); /* Daha yumuşak gölge */
            z-index: 10; /* Yazı üstte olacak */
        }

        /* Particles.js Arka Planı */
        #particles-js {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* Arka planda olacak */
        }

        /* Işıltılı Animasyon */
        @keyframes glowing {
            0% { text-shadow: 0 0 10px rgba(255, 100, 0, 0.8), 0 0 20px rgba(255, 100, 0, 0.6), 0 0 30px rgba(255, 100, 0, 0.4); }
            50% { text-shadow: 0 0 20px rgba(255, 100, 0, 1), 0 0 40px rgba(255, 100, 0, 0.8), 0 0 60px rgba(255, 100, 0, 0.6); }
            100% { text-shadow: 0 0 10px rgba(255, 100, 0, 0.8), 0 0 20px rgba(255, 100, 0, 0.6), 0 0 30px rgba(255, 100, 0, 0.4); }
        }

        /* Geriye doğru kayma animasyonu */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Sayfa yüklenince başlığın kayarak görünmesi */
        h2, p {
            animation: slideIn 1s ease-out forwards;
        }
    </style>
</head>
<body>

<!-- Particles.js Arka Planı -->
<div id="particles-js"></div>

<!-- İçerik -->
<h2>No match found. Please try a different keyword.</h2>
<p>You will be redirected to the homepage in 5 seconds...</p>

</body>
</html>
