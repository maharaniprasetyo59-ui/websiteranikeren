<?php

session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM barang ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Barang - PinjamSekolah</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f6ff;
            color: #333;
        }

        /* NAVBAR */

        .navbar {
            height: 70px;

            background: white;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 35px;

            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

        .logo {
            color: #6c63ff;
            font-size: 22px;
            font-weight: bold;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-name {
            color: #555;
            font-size: 14px;
        }

        .logout {
            text-decoration: none;
            background: #ffe8e8;
            color: #d32f2f;
            padding: 9px 15px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
        }

        /* CONTAINER */

        .container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 25px;
        }

        /* HEADER */

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 27px;
            margin-bottom: 7px;
        }

        .header p {
            color: #777;
            font-size: 14px;
        }

        .btn-tambah {
            background: #6c63ff;
            color: white;

            text-decoration: none;

            padding: 11px 17px;

            border-radius: 8px;

            font-size: 13px;
            font-weight: bold;
        }

        .btn-tambah:hover {
            background: #574fd6;
        }

        /* TABLE */

        .table-box {
            background: white;

            border-radius: 12px;

            padding: 20px;

            box-shadow: 0 5px 18px rgba(0,0,0,0.06);

            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;

            min-width: 750px;
        }

        th {
            background: #f5f4ff;
            color: #555;

            text-align: left;

            padding: 14px;

            font-size: 13px;
        }

        td {
            padding: 14px;

            border-bottom: 1px solid #eee;

            font-size: 13px;

            color: #555;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .nama-barang {
            font-weight: bold;
            color: #333;
        }

        /* BADGE */

        .badge {
            display: inline-block;

            padding: 6px 10px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;
        }

        .tersedia {
            background: #e2f7e8;
            color: #218838;
        }

        .tidak {
            background: #ffe5e5;
            color: #c62828;
        }

        .baik {
            background: #e2f7e8;
            color: #218838;
        }

        .rusak {
            background: #fff4cc;
            color: #a67c00;
        }

        /* BUTTON AKSI */

        .aksi {
            display: flex;
            gap: 7px;
        }

        .btn-edit,
        .btn-hapus {
            text-decoration: none;

            padding: 7px 10px;

            border-radius: 6px;

            font-size: 11px;

            font-weight: bold;
        }

        .btn-edit {
            background: #e8e7ff;
            color: #574fd6;
        }

        .btn-hapus {
            background: #ffe5e5;
            color: #c62828;
        }

        .btn-edit:hover {
            background: #dcd9ff;
        }

        .btn-hapus:hover {
            background: #ffd5d5;
        }

        /* BACK */

        .back {
            display: inline-block;

            margin-top: 20px;

            color: #6c63ff;

            text-decoration: none;

            font-size: 13px;

            font-weight: bold;
        }

        /* RESPONSIVE */

        @media (max-width: 600px) {

            .navbar {
                padding: 0 18px;
            }

            .admin-name {
                display: none;
            }

            .container {
                padding: 0 18px;
                margin-top: 25px;
            }

            .header {
                align-items: flex-start;
                gap: 15px;
                flex-direction: column;
            }

        }

    </style>

</head>

<body>


    <!-- NAVBAR -->

    <div class="navbar">

        <div class="logo">
            📦 PinjamSekolah
        </div>

        <div class="nav-right">

            <span class="admin-name">
                👤 <?php echo htmlspecialchars($_SESSION['nama']); ?>
            </span>

            <a href="../logout.php" class="logout">
                Logout
            </a>

        </div>

    </div>


    <!-- CONTENT -->

    <div class="container">


        <!-- HEADER -->

        <div class="header">

            <div>

                <h1>
                    Data Barang
                </h1>

                <p>
                    Kelola daftar dan stok barang sekolah.
                </p>

            </div>

            <a href="tambah_barang.php" class="btn-tambah">
                + Tambah Barang
            </a>

        </div>


        <!-- TABLE -->

        <div class="table-box">

            <table>

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    $no = 1;

                    while ($data = mysqli_fetch_assoc($query)) {

                    ?>

                        <tr>

                            <td>
                                <?php echo $no++; ?>
                            </td>

                            <td>
                                <div class="nama-barang">
                                    <?php echo htmlspecialchars($data['nama_barang']); ?>
                                </div>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($data['kategori']); ?>
                            </td>

                            <td>
                                <?php echo $data['jumlah']; ?> barang
                            </td>

                            <td>

                                <?php if ($data['kondisi'] == 'Baik') { ?>

                                    <span class="badge baik">
                                        Baik
                                    </span>

                                <?php } else { ?>

                                    <span class="badge rusak">
                                        <?php echo htmlspecialchars($data['kondisi']); ?>
                                    </span>

                                <?php } ?>

                            </td>

                            <td>

                                <?php if ($data['status'] == 'Tersedia') { ?>

                                    <span class="badge tersedia">
                                        Tersedia
                                    </span>

                                <?php } else { ?>

                                    <span class="badge tidak">
                                        Tidak Tersedia
                                    </span>

                                <?php } ?>

                            </td>

                            <td>

                                <div class="aksi">

                                    <a
                                        href="edit_barang.php?id=<?php echo $data['id']; ?>"
                                        class="btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="hapus_barang.php?id=<?php echo $data['id']; ?>"
                                        class="btn-hapus"
                                        onclick="return confirm('Yakin ingin menghapus barang ini?')"
                                    >
                                        Hapus
                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>


        <a href="dashboard.php" class="back">
            ← Kembali ke Dashboard
        </a>


    </div>

</body>

</html>