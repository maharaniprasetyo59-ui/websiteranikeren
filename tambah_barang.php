<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $kondisi = $_POST['kondisi'];
    $status = $_POST['status'];

    $query = mysqli_query($koneksi, "INSERT INTO barang 
        (nama_barang, kategori, jumlah, kondisi, status)
        VALUES 
        ('$nama_barang', '$kategori', '$jumlah', '$kondisi', '$status')");

    if ($query) {
        header("Location: barang.php");
        exit;
    } else {
        echo "Data gagal disimpan: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Barang</title>

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

        .btn-simpan {
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

            <h1>Tambah Barang</h1>

            <form method="POST">

                <div class="form-group">

                    <label>Nama Barang</label>

                    <input
                        type="text"
                        name="nama_barang"
                        placeholder="Contoh: Laptop Lenovo"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Kategori</label>

                    <select name="kategori" required>

                        <option value="">-- Pilih Kategori --</option>

                        <option value="Elektronik">Elektronik</option>

                        <option value="Jaringan">Jaringan</option>

                        <option value="Kabel">Kabel</option>

                        <option value="Peralatan">Peralatan</option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Jumlah</label>

                    <input
                        type="number"
                        name="jumlah"
                        min="1"
                        placeholder="Masukkan jumlah"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Kondisi</label>

                    <select name="kondisi" required>

                        <option value="">-- Pilih Kondisi --</option>

                        <option value="Baik">Baik</option>

                        <option value="Rusak Ringan">Rusak Ringan</option>

                        <option value="Rusak Berat">Rusak Berat</option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Status</label>

                    <select name="status" required>

                        <option value="Tersedia">Tersedia</option>

                        <option value="Tidak Tersedia">Tidak Tersedia</option>

                    </select>

                </div>

                <div class="buttons">

                    <button
                        type="submit"
                        name="simpan"
                        class="btn-simpan"
                    >
                        Simpan Barang
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