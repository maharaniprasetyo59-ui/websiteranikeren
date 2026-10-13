<?php

include "config/koneksi.php";

$error = "";
$success = "";

if (isset($_POST['daftar'])) {

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek username
    $cek = mysqli_prepare($koneksi, "SELECT id FROM users WHERE username = ?");
    mysqli_stmt_bind_param($cek, "s", $username);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {

        $error = "Username sudah digunakan! Silakan pilih username lain.";

    } else {

        // Simpan data siswa
        $query = mysqli_prepare(
            $koneksi,
            "INSERT INTO users (nama, username, password, role)
             VALUES (?, ?, ?, 'siswa')"
        );

        mysqli_stmt_bind_param(
            $query,
            "sss",
            $nama,
            $username,
            $password
        );

        if (mysqli_stmt_execute($query)) {
            $success = "Pendaftaran berhasil! Silakan login.";
        } else {
            $error = "Pendaftaran gagal. Silakan coba lagi.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar - PinjamSekolah</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f6ff;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;
        }

        .container {
            width: 900px;
            max-width: 100%;

            background: white;
            border-radius: 18px;

            overflow: hidden;

            display: flex;

            box-shadow: 0 10px 35px rgba(0,0,0,0.08);
        }

        /* BAGIAN KIRI */

        .left {
            width: 45%;

            background: #6c63ff;
            color: white;

            padding: 50px 40px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .left h1 {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .left p {
            line-height: 1.7;
            font-size: 15px;
            opacity: 0.95;
        }

        .info {
            margin-top: 30px;
        }

        .info p {
            margin-bottom: 12px;
        }

        /* BAGIAN KANAN */

        .right {
            width: 55%;
            padding: 45px;
        }

        .right h2 {
            color: #333;
            margin-bottom: 8px;
            font-size: 28px;
        }

        .subtitle {
            color: #777;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #444;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;

            padding: 13px 14px;

            border: 1px solid #ddd;
            border-radius: 8px;

            outline: none;
            font-size: 14px;

            transition: 0.2s;
        }

        input:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 0 3px rgba(108,99,255,0.1);
        }

        button {
            width: 100%;

            padding: 13px;

            border: none;
            border-radius: 8px;

            background: #6c63ff;
            color: white;

            font-size: 15px;
            font-weight: bold;

            cursor: pointer;

            margin-top: 5px;

            transition: 0.2s;
        }

        button:hover {
            background: #574fd6;
        }

        .error {
            background: #ffe5e5;
            color: #c62828;

            padding: 12px;

            border-radius: 7px;

            margin-bottom: 18px;

            font-size: 14px;
        }

        .success {
            background: #e4f8e8;
            color: #218838;

            padding: 12px;

            border-radius: 7px;

            margin-bottom: 18px;

            font-size: 14px;
        }

        .login-link {
            text-align: center;
            margin-top: 22px;

            font-size: 14px;
            color: #777;
        }

        .login-link a {
            color: #6c63ff;
            text-decoration: none;
            font-weight: bold;
        }

        .back {
            display: inline-block;

            margin-top: 25px;

            color: white;
            text-decoration: none;

            font-size: 14px;
        }

        .back:hover {
            text-decoration: underline;
        }

        /* RESPONSIVE */

        @media (max-width: 700px) {

            .container {
                flex-direction: column;
            }

            .left,
            .right {
                width: 100%;
            }

            .left {
                padding: 35px;
            }

            .right {
                padding: 35px;
            }

        }

    </style>

</head>

<body>

    <div class="container">

        <!-- BAGIAN KIRI -->

        <div class="left">

            <div class="logo">📦</div>

            <h1>PinjamSekolah</h1>

            <p>
                Buat akun siswa untuk melakukan peminjaman
                barang sekolah dengan lebih mudah dan terorganisir.
            </p>

            <div class="info">

                <p>✓ Lihat daftar barang</p>

                <p>✓ Ajukan peminjaman</p>

                <p>✓ Pantau status peminjaman</p>

                <p>✓ Lihat riwayat peminjaman</p>

            </div>

            <a href="index.php" class="back">
                ← Kembali ke Beranda
            </a>

        </div>


        <!-- BAGIAN KANAN -->

        <div class="right">

            <h2>Buat Akun</h2>

            <p class="subtitle">
                Daftarkan akun siswa kamu untuk mulai meminjam barang.
            </p>


            <?php if ($error != "") { ?>

                <div class="error">
                    <?php echo $error; ?>
                </div>

            <?php } ?>


            <?php if ($success != "") { ?>

                <div class="success">
                    <?php echo $success; ?>
                </div>

            <?php } ?>


            <form method="POST">

                <div class="form-group">

                    <label>Nama Lengkap</label>

                    <input
                        type="text"
                        name="nama"
                        placeholder="Masukkan nama lengkap"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Username</label>

                    <input
                        type="text"
                        name="username"
                        placeholder="Buat username"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Buat password"
                        required
                    >

                </div>


                <button type="submit" name="daftar">
                    Daftar
                </button>

            </form>


            <div class="login-link">

                Sudah punya akun?

                <a href="login.php">
                    Login di sini
                </a>

            </div>

        </div>

    </div>

</body>

</html>