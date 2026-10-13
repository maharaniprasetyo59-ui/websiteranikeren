<?php

session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../login.php");
    exit;
}

/* Mengambil barang yang tersedia */

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM barang
     WHERE status = 'Tersedia'
     AND jumlah > 0
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Siswa - PinjamSekolah</title>

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

        .nama {
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

        /* =========================
           CONTAINER
        ========================= */

        .container {
            max-width: 1200px;

            margin: 35px auto;

            padding: 0 25px;
        }

        .welcome {
            background: #6c63ff;

            color: white;

            padding: 30px;

            border-radius: 14px;

            margin-bottom: 30px;

            box-shadow: 0 7px 20px rgba(108,99,255,0.2);
        }

        .welcome h1 {
            font-size: 27px;
            margin-bottom: 8px;
        }

        .welcome p {
            font-size: 14px;
            opacity: 0.9;
        }

        /* =========================
           MENU
        ========================= */

        .quick-menu {
            display: flex;

            gap: 12px;

            margin-bottom: 30px;
        }

        .quick-menu a {
            background: white;

            color: #555;

            text-decoration: none;

            padding: 12px 18px;

            border-radius: 8px;

            font-size: 14px;

            box-shadow: 0 4px 12px rgba(0,0,0,0.05);

            transition: 0.2s;
        }

        .quick-menu a:hover {
            color: #6c63ff;
            transform: translateY(-2px);
        }

        /* =========================
           JUDUL
        ========================= */

        .title {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 18px;
        }

        .title h2 {
            font-size: 21px;
        }

        .title span {
            color: #777;
            font-size: 13px;
        }

        /* =========================
           BARANG
        ========================= */

        .barang-grid {
            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 20px;
        }

        .barang-card {
            background: white;

            padding: 22px;

            border-radius: 12px;

            box-shadow: 0 5px 18px rgba(0,0,0,0.06);

            transition: 0.2s;
        }

        .barang-card:hover {
            transform: translateY(-4px);

            box-shadow: 0 9px 22px rgba(0,0,0,0.1);
        }

        .barang-icon {
            width: 50px;
            height: 50px;

            background: #f0efff;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 25px;

            margin-bottom: 17px;
        }

        .barang-card h3 {
            font-size: 17px;

            margin-bottom: 8px;
        }

        .kategori {
            display: inline-block;

            background: #f0efff;

            color: #6c63ff;

            padding: 5px 9px;

            border-radius: 5px;

            font-size: 11px;

            margin-bottom: 12px;
        }

        .detail {
            color: #777;

            font-size: 13px;

            line-height: 1.7;

            margin-bottom: 17px;
        }

        .btn-pinjam {
            display: block;

            text-align: center;

            background: #6c63ff;

            color: white;

            text-decoration: none;

            padding: 10px;

            border-radius: 7px;

            font-size: 13px;

            font-weight: bold;
        }

        .btn-pinjam:hover {
            background: #574fd6;
        }

        /* =========================
           KOSONG
        ========================= */

        .empty {
            background: white;

            padding: 40px;

            border-radius: 12px;

            text-align: center;

            color: #777;

            box-shadow: 0 5px 18px rgba(0,0,0,0.05);
        }

        .empty-icon {
            font-size: 45px;
            margin-bottom: 15px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1000px) {

            .barang-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media (max-width: 600px) {

            .navbar {
                padding: 0 18px;
            }

            .nama {
                display: none;
            }

            .container {
                margin-top: 25px;
                padding: 0 18px;
            }

            .welcome {
                padding: 24px;
            }

            .welcome h1 {
                font-size: 23px;
            }

            .quick-menu {
                flex-direction: column;
            }

            .barang-grid {
                grid-template-columns: 1fr;
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

            <span class="nama">
                👤 <?php echo $_SESSION['nama']; ?>
            </span>

            <a href="../logout.php" class="logout">
                Logout
            </a>

        </div>

    </div>


    <!-- CONTENT -->

    <div class="container">


        <!-- WELCOME -->

        <div class="welcome">

            <h1>
                Halo, <?php echo $_SESSION['nama']; ?>! 👋
            </h1>

            <p>
                Selamat datang di PinjamSekolah.
                Silakan pilih barang yang ingin kamu pinjam.
            </p>

        </div>


        <!-- MENU -->

        <div class="quick-menu">

            <a href="dashboard.php">
                🏠 Daftar Barang
            </a>

            <a href="peminjaman_saya.php">
                📋 Peminjaman Saya
            </a>

        </div>


        <!-- JUDUL -->

        <div class="title">

            <h2>
                Barang Tersedia
            </h2>

            <span>
                Pilih barang untuk dipinjam
            </span>

        </div>


        <!-- BARANG -->
         <div id="barangContainer">

        <?php if (mysqli_num_rows($query) > 0) { ?>

            <div class="barang-grid">

                <?php while ($data = mysqli_fetch_assoc($query)) { ?>

                    <div class="barang-card">

                        <div class="barang-icon">
                            📦
                        </div>

                        <span class="kategori">
                            <?php echo htmlspecialchars($data['kategori']); ?>
                        </span>

                        <h3>
                            <?php echo htmlspecialchars($data['nama_barang']); ?>
                        </h3>

                        <div class="detail">

                            Jumlah tersedia:
                            <strong>
                                <?php echo $data['jumlah']; ?>
                            </strong>
                            barang

                            <br>

                            Kondisi:
                            <strong>
                                <?php echo htmlspecialchars($data['kondisi']); ?>
                            </strong>

                        </div>

                        <a
                            href="pinjam.php?id=<?php echo $data['id']; ?>"
                            class="btn-pinjam"
                        >
                            Pinjam Barang
                        </a>

                    </div>

                <?php } ?>

            </div>

        <?php } else { ?>

            <div class="empty">

                <div class="empty-icon">
                    📦
                </div>

                <h3>
                    Belum Ada Barang Tersedia
                </h3>

                <p>
                    Saat ini belum ada barang yang dapat dipinjam.
                </p>

            </div>

        <?php } ?>


    </div>

    <script>

    let dataBarangSebelumnya = <?php

    mysqli_data_seek($query, 0);

    $dataAwal = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $dataAwal[] = $row;
    }

    echo json_encode($dataAwal);

    ?>;


    function escapeHTML(text) {

        const div = document.createElement("div");

        div.textContent = text;

        return div.innerHTML;

    }


    function tampilkanBarang(data) {

        const container = document.getElementById("barangContainer");

        if (!container) {
            return;
        }


        if (data.length === 0) {

            container.innerHTML = `
                <div class="empty">

                    <div class="empty-icon">
                        📦
                    </div>

                    <h3>
                        Belum Ada Barang Tersedia
                    </h3>

                    <p>
                        Saat ini belum ada barang yang dapat dipinjam.
                    </p>

                </div>
            `;

            return;
        }


        let html = `
            <div class="barang-grid">
        `;


        data.forEach(item => {

            html += `

                <div class="barang-card">

                    <div class="barang-icon">
                        📦
                    </div>

                    <span class="kategori">
                        ${escapeHTML(item.kategori)}
                    </span>

                    <h3>
                        ${escapeHTML(item.nama_barang)}
                    </h3>

                    <div class="detail">

                        Jumlah tersedia:
                        <strong>
                            ${item.jumlah}
                        </strong>
                        barang

                        <br>

                        Kondisi:
                        <strong>
                            ${escapeHTML(item.kondisi)}
                        </strong>

                    </div>

                    <a
                        href="pinjam.php?id=${item.id}"
                        class="btn-pinjam"
                    >
                        Pinjam Barang
                    </a>

                </div>

            `;

        });


        html += `
            </div>
        `;


        container.innerHTML = html;

    }


    function updateBarang() {

        fetch("cek_barang.php?time=" + Date.now())

            .then(response => {

                if (!response.ok) {
                    throw new Error("Gagal mengambil data barang");
                }

                return response.json();

            })

            .then(data => {

                const dataBaru = JSON.stringify(data);

                const dataLama = JSON.stringify(dataBarangSebelumnya);


                if (dataBaru !== dataLama) {

                    tampilkanBarang(data);

                    dataBarangSebelumnya = data;

                    console.log("Data barang diperbarui");

                }

            })

            .catch(error => {

                console.error(
                    "Gagal memperbarui data barang:",
                    error
                );

            });

    }


    // Cek perubahan setiap 3 detik
    setInterval(updateBarang, 3000);

    </script>

</body>

</html>
</body>

</html>