<?php

session_start();
include "config/koneksi.php";

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM users WHERE username='$username'"
    );

    if (mysqli_num_rows($query) > 0) {

        $user = mysqli_fetch_assoc($query);

        if ($password == $user['password']) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {

                header("Location: admin/dashboard.php");
                exit;

            } else {

                header("Location: siswa/dashboard.php");
                exit;

            }

        } else {

            $error = "Password salah!";

        }

    } else {

        $error = "Username tidak ditemukan!";

    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - PinjamSekolah</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f7f7ff;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;
        }

        .login-container {
            width: 900px;
            min-height: 520px;

            background: white;
            border-radius: 20px;

            display: grid;
            grid-template-columns: 1fr 1fr;

            overflow: hidden;

            box-shadow: 0 15px 40px rgba(0,0,0,0.10);
        }

        /* BAGIAN KIRI */

        .login-info {
            background: #6c63ff;
            color: white;

            padding: 50px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-info h1 {
            font-size: 38px;
            margin-bottom: 20px;
        }

        .login-info h1 span {
            color: #e8e6ff;
        }

        .login-info p {
            line-height: 1.7;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .icon {
            font-size: 80px;
            margin-bottom: 25px;
        }

        .back-home {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        /* BAGIAN KANAN */

        .login-form {
            padding: 50px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            font-size: 30px;
            color: #333;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #777;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;

            padding: 13px;

            border: 1px solid #ddd;
            border-radius: 8px;

            outline: none;
            font-size: 15px;
        }

        input:focus {
            border-color: #6c63ff;
        }

        .btn-login {
            width: 100%;

            border: none;
            border-radius: 8px;

            padding: 13px;

            background: #6c63ff;
            color: white;

            font-size: 16px;
            font-weight: bold;

            cursor: pointer;
        }

        .btn-login:hover {
            background: #574fd6;
        }

        .error {
            background: #ffe5e5;
            color: #d00000;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 20px;

            text-align: center;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #777;
        }

        .register-link a {
            color: #6c63ff;
            text-decoration: none;
            font-weight: bold;
        }

        /* RESPONSIVE */

        @media (max-width: 700px) {

            .login-container {
                grid-template-columns: 1fr;
            }

            .login-info {
                padding: 35px;
                text-align: center;
            }

            .login-info h1 {
                font-size: 30px;
            }

            .icon {
                font-size: 60px;
            }

            .login-form {
                padding: 35px;
            }

        }

    </style>

</head>

<body>

<div class="login-container">


    <!-- BAGIAN INFORMASI -->

    <div class="login-info">

        <div class="icon">
            📦
        </div>

        <h1>
            Pinjam<span>Sekolah</span>
        </h1>

        <p>
            Sistem digital untuk memudahkan
            proses peminjaman dan pengelolaan
            barang sekolah.
        </p>

        <a href="index.php" class="back-home">
            ← Kembali ke Beranda
        </a>

    </div>


    <!-- FORM LOGIN -->

    <div class="login-form">

        <h2>
            Selamat Datang!
        </h2>

        <p class="subtitle">
            Silakan login untuk melanjutkan.
        </p>


        <?php if ($error != "") { ?>

            <div class="error">
                <?php echo $error; ?>
            </div>

        <?php } ?>


        <form method="POST">

            <div class="form-group">

                <label>
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    placeholder="Masukkan username"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <button
                type="submit"
                name="login"
                class="btn-login"
            >
                Login
            </button>

        </form>


        <div class="register-link">

            Belum punya akun?

            <a href="register.php">
                Daftar sebagai siswa
            </a>

        </div>

    </div>

</div>

</body>

</html>