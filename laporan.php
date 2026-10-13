<?php

session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}


/* Mengambil semua data peminjaman */

$query = mysqli_query(
    $koneksi,
    "SELECT
        peminjaman.*,
        users.nama,
        barang.nama_barang,
        barang.kategori
     FROM peminjaman
     JOIN users ON peminjaman.user_id = users.id
     JOIN barang ON peminjaman.barang_id = barang.id
     ORDER BY peminjaman.id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Peminjaman - PinjamSekolah</title>

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

        /* =========================
           NAVBAR
        ========================= */

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

        /* =========================
           CONTAINER
        ========================= */

        .container {
            max-width: 1250px;

            margin: 35px auto;

            padding: 0 25px;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            display: flex;

            justify-content: space-between;

            align-items: center;

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

        /* =========================
           PRINT BUTTON
        ========================= */

        .btn-print {
            border: none;

            background: #6c63ff;

            color: white;

            padding: 11px 17px;

            border-radius: 8px;

            cursor: pointer;

            font-size: 13px;

            font-weight: bold;
        }

        .btn-print:hover {
            background: #574fd6;
        }

        /* =========================
           TABLE
        ========================= */

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

            min-width: 1050px;
        }

        th {
            background: #f5f4ff;

            color: #555;

            text-align: left;

            padding: 14px;

            font-size: 12px;
        }

        td {
            padding: 14px;

            border-bottom: 1px solid #eee;

            font-size: 12px;

            color: #555;

            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .nama {
            font-weight: bold;

            color: #333;
        }

        .barang {
            font-weight: bold;

            color: #333;
        }

        .kategori {
            display: block;

            color: #888;

            font-size: 10px;

            margin-top: 3px;
        }

        /* =========================
           STATUS
        ========================= */

        .status {
            display: inline-block;

            padding: 6px 10px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: bold;
        }

        .menunggu {
            background: #fff4cc;

            color: #a67c00;
        }

        .disetujui {
            background: #e2f7e8;

            color: #218838;
        }

        .ditolak {
            background: #ffe5e5;

            color: #c62828;
        }

        .selesai {
            background: #e5e9ff;

            color: #4d55a5;
        }

        /* =========================
           EMPTY
        ========================= */

        .empty {
            text-align: center;

            padding: 50px 20px;

            color: #777;
        }

        .empty-icon {
            font-size: 45px;

            margin-bottom: 15px;
        }

        /* =========================
           BACK
        ========================= */

        .back {
            display: inline-block;

            margin-top: 20px;

            color: #6c63ff;

            text-decoration: none;

            font-size: 13px;

            font-weight: bold;
        }

        /* =========================
           PRINT
        ========================= */

        @media print {

            body {
                background: white;
            }

            .navbar,
            .btn-print,
            .back {
                display: none;
            }

            .container {
                max-width: 100%;

                margin: 0;

                padding: 0;
            }

            .header {
                display: block;

                margin-bottom: 20px;
            }

            .header h1 {
                font-size: 22px;
            }

            .table-box {
                box-shadow: none;

                padding: 0;
            }

            table {
                min-width: 0;

                font-size: 10px;
            }

            th,
            td {
                border: 1px solid #ddd;

                padding: 8px;
            }

        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 700px) {

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

                flex-direction: column;

                gap: 15px;
            }

            .header h1 {
                font-size: 23px;
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
                    Laporan Peminjaman
                </h1>

                <p>
                    Riwayat seluruh transaksi peminjaman barang sekolah.
                </p>

            </div>


            <button
                class="btn-print"
                onclick="window.print()"
            >
                🖨 Cetak Laporan
            </button>

        </div>


        <!-- TABLE -->

        <div class="table-box">


            <?php if (mysqli_num_rows($query) > 0) { ?>


                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nama Siswa</th>

                            <th>Barang</th>

                            <th>Jumlah</th>

                            <th>Tanggal Pinjam</th>

                            <th>Tanggal Kembali</th>

                            <th>Status</th>

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

                                    <div class="nama">

                                        <?php
                                        echo htmlspecialchars($data['nama']);
                                        ?>

                                    </div>

                                </td>


                                <td>

                                    <div class="barang">

                                        <?php
                                        echo htmlspecialchars($data['nama_barang']);
                                        ?>

                                    </div>


                                    <span class="kategori">

                                        <?php
                                        echo htmlspecialchars($data['kategori']);
                                        ?>

                                    </span>

                                </td>


                                <td>

                                    <?php echo $data['jumlah']; ?>

                                    barang

                                </td>


                                <td>

                                    <?php
                                    echo date(
                                        'd-m-Y',
                                        strtotime($data['tanggal_pinjam'])
                                    );
                                    ?>

                                </td>


                                <td>

                                    <?php
                                    echo date(
                                        'd-m-Y',
                                        strtotime($data['tanggal_kembali'])
                                    );
                                    ?>

                                </td>


                                <td>


                                    <?php if ($data['status'] == 'Menunggu') { ?>

                                        <span class="status menunggu">
                                            Menunggu
                                        </span>

                                    <?php } elseif ($data['status'] == 'Disetujui') { ?>

                                        <span class="status disetujui">
                                            Disetujui
                                        </span>

                                    <?php } elseif ($data['status'] == 'Ditolak') { ?>

                                        <span class="status ditolak">
                                            Ditolak
                                        </span>

                                    <?php } elseif ($data['status'] == 'Selesai') { ?>

                                        <span class="status selesai">
                                            Selesai
                                        </span>

                                    <?php } ?>


                                </td>

                            </tr>


                        <?php } ?>


                    </tbody>

                </table>


            <?php } else { ?>


                <div class="empty">

                    <div class="empty-icon">
                        📊
                    </div>

                    <h3>
                        Belum Ada Data
                    </h3>

                    <p>
                        Belum ada riwayat peminjaman yang dapat ditampilkan.
                    </p>

                </div>


            <?php } ?>


        </div>


        <a href="dashboard.php" class="back">
            ← Kembali ke Dashboard
        </a>


    </div>

</body>

</html>