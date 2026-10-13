<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Peminjaman Barang Sekolah</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f7f7ff;
            color: #333;
        }

        /* NAVBAR */

        .navbar {
            background: white;
            padding: 18px 60px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .logo {
            color: #6c63ff;
            font-size: 22px;
            font-weight: bold;
        }

        .nav-button {
            display: flex;
            gap: 10px;
        }

        .nav-button a {
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
        }

        .login {
            color: #6c63ff;
            border: 1px solid #6c63ff;
        }

        .register {
            background: #6c63ff;
            color: white;
        }

        /* HERO */

        .hero {
            min-height: 520px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 70px 10%;
            gap: 50px;
        }

        .hero-text {
            max-width: 600px;
        }

        .hero-text h1 {
            font-size: 48px;
            line-height: 1.2;
            margin-bottom: 20px;
            color: #333;
        }

        .hero-text h1 span {
            color: #6c63ff;
        }

        .hero-text p {
            color: #777;
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .hero-button {
            display: inline-block;
            background: #6c63ff;
            color: white;
            text-decoration: none;
            padding: 14px 25px;
            border-radius: 9px;
            font-weight: bold;
        }

        .hero-button:hover {
            background: #574fd6;
        }

        /* ILUSTRASI */

        .hero-card {
            width: 380px;
            height: 300px;

            background: white;
            border-radius: 25px;

            display: flex;
            justify-content: center;
            align-items: center;

            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }

        .icon {
            font-size: 100px;
        }

        /* FITUR */

        .features {
            padding: 60px 10%;
            background: white;
            text-align: center;
        }

        .features h2 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .features > p {
            color: #777;
            margin-bottom: 40px;
        }

        .feature-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .feature {
            padding: 30px;
            background: #f7f7ff;
            border-radius: 15px;
        }

        .feature-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .feature h3 {
            margin-bottom: 10px;
            color: #6c63ff;
        }

        .feature p {
            color: #777;
            line-height: 1.6;
        }

        /* FOOTER */

        footer {
            background: #6c63ff;
            color: white;
            text-align: center;
            padding: 25px;
        }

        /* RESPONSIVE */

        @media (max-width: 800px) {

            .navbar {
                padding: 18px 25px;
            }

            .hero {
                flex-direction: column;
                text-align: center;
                padding: 60px 25px;
            }

            .hero-text h1 {
                font-size: 36px;
            }

            .hero-card {
                width: 100%;
                max-width: 380px;
            }

            .feature-container {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- NAVBAR -->

<nav class="navbar">

    <div class="logo">
        PinjamSekolah
    </div>

    <div class="nav-button">

        <a href="login.php" class="login">
            Login
        </a>

        <a href="register.php" class="register">
            Daftar
        </a>

    </div>

</nav>


<!-- HERO -->

<section class="hero">

    <div class="hero-text">

        <h1>
            Sistem Peminjaman
            <span>Barang Sekolah</span>
        </h1>

        <p>
            Platform sederhana untuk memudahkan siswa
            dalam mengajukan peminjaman barang sekolah
            dan membantu admin mengelola data peminjaman
            secara lebih teratur.
        </p>

        <a href="login.php" class="hero-button">
            Mulai Peminjaman →
        </a>

    </div>


    <div class="hero-card">

        <div class="icon">
            📦
        </div>

    </div>

</section>


<!-- FITUR -->

<section class="features">

    <h2>
        Fitur Sistem
    </h2>

    <p>
        Beberapa fitur utama yang tersedia dalam sistem.
    </p>


    <div class="feature-container">


        <div class="feature">

            <div class="feature-icon">
                📦
            </div>

            <h3>
                Data Barang
            </h3>

            <p>
                Admin dapat mengelola data barang,
                jumlah, kategori, kondisi, dan status barang.
            </p>

        </div>


        <div class="feature">

            <div class="feature-icon">
                📝
            </div>

            <h3>
                Peminjaman
            </h3>

            <p>
                Siswa dapat mengajukan peminjaman
                barang secara mudah melalui sistem.
            </p>

        </div>


        <div class="feature">

            <div class="feature-icon">
                📊
            </div>

            <h3>
                Laporan
            </h3>

            <p>
                Admin dapat melihat riwayat peminjaman
                dan mencetak laporan.
            </p>

        </div>


    </div>

</section>


<!-- FOOTER -->

<footer>

    <p>
        © 2026 Sistem Peminjaman Barang Sekolah
    </p>

</footer>


</body>

</html>