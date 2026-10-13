<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: barang.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id='$id'");
$barang = mysqli_fetch_assoc($query);

if (!$barang) {
    echo "Data barang tidak ditemukan.";
    exit;
}

if (isset($_POST['update'])) {

    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $kondisi = $_POST['kondisi'];
    $status = $_POST['status'];

    $update = mysqli_query($koneksi, "UPDATE barang SET
        nama_barang='$nama_barang',
        kategori='$kategori',
        jumlah='$jumlah',
        kondisi='$kondisi',
        status='$status'
        WHERE id='$id'
    ");

    if ($update) {
        header("Location: barang.php");
        exit;
    } else {
        echo "Data gagal diperbarui: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Barang</title>

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
            margin-bottom: 25px;
            color: #333;
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

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #6c63ff;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-update {
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
        <h2>Sistem Peminjaman Barang</h2>
    </div>

    <div class="container">

        <div class="form-box">

            <h1>Edit Barang</h1>

            <form method="POST">

                <div class="form-group">

                    <label>Nama Barang</label>

                    <input
                        type="text"
                        name="nama_barang"
                        value="<?php echo $barang['nama_barang']; ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Kategori</label>

                    <select name="kategori" required>

                        <option value="Elektronik"
                            <?php if ($barang['kategori'] == 'Elektronik') echo 'selected'; ?>>
                            Elektronik
                        </option>

                        <option value="Jaringan"
                            <?php if ($barang['kategori'] == 'Jaringan') echo 'selected'; ?>>
                            Jaringan
                        </option>

                        <option value="Kabel"
                            <?php if ($barang['kategori'] == 'Kabel') echo 'selected'; ?>>
                            Kabel
                        </option>

                        <option value="Peralatan"
                            <?php if ($barang['kategori'] == 'Peralatan') echo 'selected'; ?>>
                            Peralatan
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Jumlah</label>

                    <input
                        type="number"
                        name="jumlah"
                        min="1"
                        value="<?php echo $barang['jumlah']; ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Kondisi</label>

                    <select name="kondisi" required>

                        <option value="Baik"
                            <?php if ($barang['kondisi'] == 'Baik') echo 'selected'; ?>>
                            Baik
                        </option>

                        <option value="Rusak Ringan"
                            <?php if ($barang['kondisi'] == 'Rusak Ringan') echo 'selected'; ?>>
                            Rusak Ringan
                        </option>

                        <option value="Rusak Berat"
                            <?php if ($barang['kondisi'] == 'Rusak Berat') echo 'selected'; ?>>
                            Rusak Berat
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Status</label>

                    <select name="status" required>

                        <option value="Tersedia"
                            <?php if ($barang['status'] == 'Tersedia') echo 'selected'; ?>>
                            Tersedia
                        </option>

                        <option value="Tidak Tersedia"
                            <?php if ($barang['status'] == 'Tidak Tersedia') echo 'selected'; ?>>
                            Tidak Tersedia
                        </option>

                    </select>

                </div>

                <div class="buttons">

                    <button
                        type="submit"
                        name="update"
                        class="btn-update"
                    >
                        Update Barang
                    </button>

                    <a
                        href="barang.php"
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