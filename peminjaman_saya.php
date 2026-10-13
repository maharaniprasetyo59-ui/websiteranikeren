<?php

session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['id'];

$query = mysqli_query(
    $koneksi,
    "SELECT 
        peminjaman.*,
        barang.nama_barang,
        barang.kategori
     FROM peminjaman
     JOIN barang ON peminjaman.barang_id = barang.id
     WHERE peminjaman.user_id = '$user_id'
     ORDER BY peminjaman.id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Peminjaman Saya - PinjamSekolah</title>

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

        /* CONTAINER */

        .container {
            max-width: 1200px;

            margin: 35px auto;

            padding: 0 25px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 27px;
            margin-bottom: 8px;
        }

        .header p {
            color: #777;
            font-size: 14px;
        }

        /* NAVIGASI */

        .menu {
            display: flex;
            gap: 10px;

            margin-bottom: 25px;
        }

        .menu a {
            text-decoration: none;

            background: white;
            color: #555;

            padding: 11px 17px;

            border-radius: 8px;

            font-size: 14px;

            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .menu a.active {
            background: #6c63ff;
            color: white;
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

        .kategori {
            color: #777;
            font-size: 12px;
        }

        /* STATUS */

        .status {
            display: inline-block;

            padding: 6px 10px;

            border-radius: 20px;

            font-size: 11px;

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

        /* EMPTY */

        .empty {
            text-align: center;

            padding: 50px 20px;

            color: #777;
        }

        .empty-icon {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .btn-kembali {
            display: inline-block;

            margin-top: 18px;

            background: #6c63ff;

            color: white;

            text-decoration: none;

            padding: 10px 18px;

            border-radius: 7px;

            font-size: 13px;
        }

        /* RESPONSIVE */

        @media (max-width: 600px) {

            .navbar {
                padding: 0 18px;
            }

            .nama {
                display: none;
            }

            .container {
                padding: 0 18px;
                margin-top: 25px;
            }

            .header h1 {
                font-size: 23px;
            }

            .menu {
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

            <span class="nama">
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
                Peminjaman Saya
            </h1>

            <p>
                Lihat status dan riwayat barang yang pernah kamu pinjam.
            </p>

        </div>


        <!-- MENU -->

        <div class="menu">

            <a href="dashboard.php">
                🏠 Daftar Barang
            </a>

            <a href="peminjaman_saya.php" class="active">
                📋 Peminjaman Saya
            </a>

        </div>


        <!-- DATA -->

        <div class="table-box">

            <?php if (mysqli_num_rows($query) > 0) { ?>

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Barang</th>

                            <th>Jumlah</th>

                            <th>Tanggal Pinjam</th>

                            <th>Tanggal Kembali</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody id="dataPeminjaman">

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

                <div class="kategori">
                    <?php echo htmlspecialchars($data['kategori']); ?>
                </div>

            </td>

            <td>
                <?php echo $data['jumlah']; ?> barang
            </td>

            <td>
                <?php echo date('d-m-Y', strtotime($data['tanggal_pinjam'])); ?>
            </td>

            <td>
                <?php echo date('d-m-Y', strtotime($data['tanggal_kembali'])); ?>
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
                        📋
                    </div>

                    <h3>
                        Belum Ada Peminjaman
                    </h3>

                    <p>
                        Kamu belum pernah melakukan peminjaman barang.
                    </p>

                    <a href="dashboard.php" class="btn-kembali">
                        Lihat Barang
                    </a>

                </div>

            <?php } ?>

        </div>


    </div>
<script>

let dataSebelumnya = JSON.stringify(
    <?php

    mysqli_data_seek($query, 0);

    $dataAwal = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $dataAwal[] = $row;
    }

    echo json_encode($dataAwal);

    ?>
);


function buatStatus(status) {

    if (status === "Menunggu") {
        return `<span class="status menunggu">Menunggu</span>`;
    }

    if (status === "Disetujui") {
        return `<span class="status disetujui">Disetujui</span>`;
    }

    if (status === "Ditolak") {
        return `<span class="status ditolak">Ditolak</span>`;
    }

    if (status === "Selesai") {
        return `<span class="status selesai">Selesai</span>`;
    }

    return status;
}


function escapeHTML(text) {

    const div = document.createElement("div");

    div.textContent = text;

    return div.innerHTML;
}


function formatTanggal(tanggal) {

    const date = new Date(tanggal + "T00:00:00");

    const hari = String(date.getDate()).padStart(2, "0");

    const bulan = String(date.getMonth() + 1).padStart(2, "0");

    const tahun = date.getFullYear();

    return `${hari}-${bulan}-${tahun}`;
}


function tampilkanPeminjaman(data) {

    const tbody = document.getElementById("dataPeminjaman");

    if (!tbody) {
        return;
    }

    let html = "";


    data.forEach((item, index) => {

        html += `

            <tr>

                <td>
                    ${index + 1}
                </td>

                <td>

                    <div class="nama-barang">
                        ${escapeHTML(item.nama_barang)}
                    </div>

                    <div class="kategori">
                        ${escapeHTML(item.kategori)}
                    </div>

                </td>

                <td>
                    ${item.jumlah} barang
                </td>

                <td>
                    ${formatTanggal(item.tanggal_pinjam)}
                </td>

                <td>
                    ${formatTanggal(item.tanggal_kembali)}
                </td>

                <td>
                    ${buatStatus(item.status)}
                </td>

            </tr>

        `;

    });


    tbody.innerHTML = html;
}


function updatePeminjaman() {

    fetch("cek_peminjaman.php?time=" + Date.now())

        .then(response => {

            if (!response.ok) {
                throw new Error("Gagal mengambil data");
            }

            return response.json();

        })

        .then(data => {

            const dataBaru = JSON.stringify(data);


            if (dataBaru !== dataSebelumnya) {

                tampilkanPeminjaman(data);

                dataSebelumnya = dataBaru;

                console.log("✅ Data peminjaman diperbarui");

            }

        })

        .catch(error => {

            console.error(
                "❌ Gagal memperbarui data:",
                error
            );

        });

}


// Mengecek perubahan setiap 3 detik
setInterval(updatePeminjaman, 3000);

</script>
</body>

</html>