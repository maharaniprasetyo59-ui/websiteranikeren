<?php

session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM users ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data User - PinjamSekolah</title>

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

        .logout:hover {
            background: #ffd5d5;
        }

        /* CONTAINER */

        .container {
            max-width: 1100px;

            margin: 35px auto;

            padding: 0 25px;
        }

        /* HEADER */

        .header {
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

            min-width: 600px;
        }

        th {
            background: #f5f4ff;

            color: #555;

            text-align: left;

            padding: 14px;

            font-size: 13px;
        }

        td {
            padding: 15px 14px;

            border-bottom: 1px solid #eee;

            font-size: 13px;

            color: #555;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .nama {
            font-weight: bold;
            color: #333;
        }

        .username {
            color: #777;
        }

        /* ROLE */

        .role {
            display: inline-block;

            padding: 6px 11px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;
        }

        .admin {
            background: #e5e9ff;
            color: #4d55a5;
        }

        .siswa {
            background: #e2f7e8;
            color: #218838;
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

        .back:hover {
            text-decoration: underline;
        }

        /* EMPTY */

        .empty {
            text-align: center;

            padding: 45px 20px;

            color: #777;
        }

        .empty-icon {
            font-size: 45px;

            margin-bottom: 15px;
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


        <div class="header">

            <h1>
                Data User
            </h1>

            <p>
                Lihat daftar pengguna yang terdaftar pada sistem.
            </p>

        </div>


        <div class="table-box">


            <?php if (mysqli_num_rows($query) > 0) { ?>


                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nama</th>

                            <th>Username</th>

                            <th>Role</th>

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

                                    <div class="username">

                                        @<?php
                                        echo htmlspecialchars($data['username']);
                                        ?>

                                    </div>

                                </td>


                                <td>


                                    <?php if ($data['role'] == 'admin') { ?>

                                        <span class="role admin">
                                            Admin
                                        </span>

                                    <?php } else { ?>

                                        <span class="role siswa">
                                            Siswa
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
                        👥
                    </div>

                    <h3>
                        Belum Ada User
                    </h3>

                    <p>
                        Belum ada pengguna yang terdaftar.
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