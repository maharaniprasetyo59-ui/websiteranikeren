<?php

session_start();

include "../config/koneksi.php";

// Cek apakah yang login adalah siswa
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../login.php");
    exit;
}

// Cek apakah ID barang ada
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$barang_id = $_GET['id'];

// Ambil data barang
$query = mysqli_prepare(
    $koneksi,
    "SELECT * FROM barang WHERE id = ?"
);

mysqli_stmt_bind_param($query, "i", $barang_id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$barang = mysqli_fetch_assoc($result);

// Jika barang tidak ditemukan
if (!$barang) {
    echo "Barang tidak ditemukan.";
    exit;
}

$error = "";

// Jika tombol pinjam ditekan
if (isset($_POST['pinjam'])) {

    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $jumlah = $_POST['jumlah'];

    // Cek jumlah
    if ($jumlah <= 0) {

        $error = "Jumlah barang harus lebih dari 0.";

    } elseif ($jumlah > $barang['jumlah']) {

        $error = "Jumlah yang dipinjam melebihi stok yang tersedia.";

    } elseif ($tanggal_kembali < $tanggal_pinjam) {

        $error = "Tanggal kembali tidak boleh sebelum tanggal pinjam.";

    } else {

        // Simpan peminjaman
        $insert = mysqli_prepare(
            $koneksi,
            "INSERT INTO peminjaman
            (user_id, barang_id, tanggal_pinjam, tanggal_kembali, jumlah, status)
            VALUES (?, ?, ?, ?, ?, 'Menunggu')"
        );

        mysqli_stmt_bind_param(
            $insert,
            "iissi",
            $_SESSION['id'],
            $barang_id,
            $tanggal_pinjam,
            $tanggal_kembali,
            $jumlah
        );

        if (mysqli_stmt_execute($insert)) {

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Peminjaman gagal. Silakan coba lagi.";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pinjam Barang</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f9;
        }

        .navbar {
            background: #6c63ff;
            color: white;
            padding: 20px 30px;
        }

        .navbar h2 {
            font-size: 22px;
        }

        .container {
            padding: 30px;
        }

        .form-box {
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        h1 {
            color: #333;
            margin-bottom: 8px;
        }

        .info {
            color: #777;
            margin-bottom: 25px;
        }

        .barang-info {
            background: #f5f4ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .barang-info p {
            margin-bottom: 7px;
            color: #555;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #6c63ff;
        }

        .error {
            background: #ffe5e5;
            color: #d00000;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: center;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-pinjam {
            border: none;
            background: #6c63ff;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-kembali {
            text-decoration: none;
            background: #777;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
        }

    </style>

</head>

<body>

<div class="navbar">

    <h2>
        Sistem Peminjaman Barang
    </h2>

</div>


<div class="container">

    <div class="form-box">

        <h1>
            Form Peminjaman
        </h1>

        <p class="info">
            Silakan isi data peminjaman barang.
        </p>


        <!-- Informasi barang -->

        <div class="barang-info">

            <p>
                <strong>Nama Barang:</strong>
                <?php echo $barang['nama_barang']; ?>
            </p>

            <p>
                <strong>Kategori:</strong>
                <?php echo $barang['kategori']; ?>
            </p>

            <p>
                <strong>Stok Tersedia:</strong>
                <?php echo $barang['jumlah']; ?>
            </p>

            <p>
                <strong>Kondisi:</strong>
                <?php echo $barang['kondisi']; ?>
            </p>

        </div>


        <?php if ($error != "") { ?>

            <div class="error">
                <?php echo $error; ?>
            </div>

        <?php } ?>


        <form method="POST">

            <div class="form-group">

                <label>
                    Jumlah yang Dipinjam
                </label>

                <input
                    type="number"
                    name="jumlah"
                    min="1"
                    max="<?php echo $barang['jumlah']; ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Tanggal Pinjam
                </label>

                <input
                    type="date"
                    name="tanggal_pinjam"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Tanggal Kembali
                </label>

                <input
                    type="date"
                    name="tanggal_kembali"
                    required
                >

            </div>


            <div class="buttons">

                <button
                    type="submit"
                    name="pinjam"
                    class="btn-pinjam"
                >
                    Ajukan Peminjaman
                </button>

                <a
                    href="dashboard.php"
                    class="btn-kembali"
                >
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

</body>

</html>