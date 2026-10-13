<?php

session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}


/* =========================
   SEARCH & FILTER
========================= */

$search = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';


$query_sql = "
    SELECT 
        peminjaman.*,
        users.nama,
        barang.nama_barang
    FROM peminjaman
    JOIN users ON peminjaman.user_id = users.id
    JOIN barang ON peminjaman.barang_id = barang.id
    WHERE 1=1
";


if ($search != '') {

    $search = mysqli_real_escape_string($koneksi, $search);

    $query_sql .= "
        AND (
            users.nama LIKE '%$search%'
            OR barang.nama_barang LIKE '%$search%'
        )
    ";
}


if ($status_filter != '') {

    $status_filter = mysqli_real_escape_string($koneksi, $status_filter);

    $query_sql .= "
        AND peminjaman.status = '$status_filter'
    ";
}


$query_sql .= " ORDER BY peminjaman.id DESC";


$query = mysqli_query($koneksi, $query_sql);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Peminjaman - PinjamSekolah</title>


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
           FILTER
        ========================= */

        .filter-box {

            background: white;

            padding: 18px;

            border-radius: 12px;

            margin-bottom: 20px;

            display: flex;

            gap: 10px;

            align-items: center;

            box-shadow: 0 5px 18px rgba(0,0,0,0.06);

        }


        .filter-box input,
        .filter-box select {

            padding: 11px 12px;

            border: 1px solid #ddd;

            border-radius: 7px;

            font-size: 13px;

            outline: none;

        }


        .filter-box input {

            flex: 1;

        }


        .filter-box input:focus,
        .filter-box select:focus {

            border-color: #6c63ff;

        }


        .btn-cari {

            border: none;

            background: #6c63ff;

            color: white;

            padding: 11px 18px;

            border-radius: 7px;

            cursor: pointer;

            font-size: 13px;

            font-weight: bold;

        }


        .btn-reset {

            text-decoration: none;

            background: #777;

            color: white;

            padding: 11px 18px;

            border-radius: 7px;

            font-size: 13px;

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


        .nama-siswa {

            font-weight: bold;

            color: #333;

        }


        .nama-barang {

            font-weight: bold;

            color: #333;

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
           AKSI
        ========================= */

        .aksi {

            display: flex;

            gap: 6px;

        }


        .aksi a {

            text-decoration: none;

            padding: 7px 9px;

            border-radius: 6px;

            font-size: 10px;

            font-weight: bold;

            white-space: nowrap;

        }


        .btn-setujui {

            background: #e2f7e8;

            color: #218838;

        }


        .btn-tolak {

            background: #ffe5e5;

            color: #c62828;

        }


        .btn-kembali {

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


            .filter-box {

                flex-direction: column;

                align-items: stretch;

            }


            .filter-box input {

                width: 100%;

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

            <h1>
                Data Peminjaman
            </h1>

            <p>
                Kelola pengajuan peminjaman barang dari siswa.
            </p>

        </div>



        <!-- FILTER -->

        <form method="GET" class="filter-box">


            <input
                type="text"
                name="search"
                placeholder="Cari nama siswa atau barang..."
                value="<?php echo htmlspecialchars($search); ?>"
            >


            <select name="status">

                <option value="">
                    Semua Status
                </option>


                <option
                    value="Menunggu"
                    <?php if ($status_filter == 'Menunggu') echo 'selected'; ?>
                >
                    Menunggu
                </option>


                <option
                    value="Disetujui"
                    <?php if ($status_filter == 'Disetujui') echo 'selected'; ?>
                >
                    Disetujui
                </option>


                <option
                    value="Ditolak"
                    <?php if ($status_filter == 'Ditolak') echo 'selected'; ?>
                >
                    Ditolak
                </option>


                <option
                    value="Selesai"
                    <?php if ($status_filter == 'Selesai') echo 'selected'; ?>
                >
                    Selesai
                </option>

            </select>


            <button type="submit" class="btn-cari">
                Cari
            </button>


            <a href="peminjaman.php" class="btn-reset">
                Reset
            </a>


        </form>



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

                            <th>Aksi</th>

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

                                    <div class="nama-siswa">

                                        <?php
                                        echo htmlspecialchars($data['nama']);
                                        ?>

                                    </div>

                                </td>


                                <td>

                                    <div class="nama-barang">

                                        <?php
                                        echo htmlspecialchars($data['nama_barang']);
                                        ?>

                                    </div>

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


                                <td>


                                    <?php if ($data['status'] == 'Menunggu') { ?>


                                        <div class="aksi">


                                            <a
                                                href="setujui.php?id=<?php echo $data['id']; ?>"
                                                class="btn-setujui"
                                                onclick="return confirm('Setujui peminjaman ini?')"
                                            >
                                                Setujui
                                            </a>


                                            <a
                                                href="tolak.php?id=<?php echo $data['id']; ?>"
                                                class="btn-tolak"
                                                onclick="return confirm('Tolak peminjaman ini?')"
                                            >
                                                Tolak
                                            </a>


                                        </div>


                                    <?php } elseif ($data['status'] == 'Disetujui') { ?>


                                        <a
                                            href="kembalikan.php?id=<?php echo $data['id']; ?>"
                                            class="btn-kembali"
                                            onclick="return confirm('Barang sudah dikembalikan?')"
                                        >
                                            Kembalikan
                                        </a>


                                    <?php } else { ?>


                                        <span>
                                            -
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
                        Belum ada data peminjaman yang sesuai.
                    </p>

                </div>


            <?php } ?>


        </div>


        <a href="dashboard.php" class="back">
            ← Kembali ke Dashboard
        </a>


    </div>

    <script>

let dataPeminjamanSebelumnya = <?php

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


function buatAksi(item) {

    if (item.status === "Menunggu") {

        return `
            <div class="aksi">

                <a
                    href="setujui.php?id=${item.id}"
                    class="btn-setujui"
                    onclick="return confirm('Setujui peminjaman ini?')"
                >
                    Setujui
                </a>

                <a
                    href="tolak.php?id=${item.id}"
                    class="btn-tolak"
                    onclick="return confirm('Tolak peminjaman ini?')"
                >
                    Tolak
                </a>

            </div>
        `;

    }

    if (item.status === "Disetujui") {

        return `
            <a
                href="kembalikan.php?id=${item.id}"
                class="btn-kembali"
                onclick="return confirm('Barang sudah dikembalikan?')"
            >
                Kembalikan
            </a>
        `;

    }

    return `<span>-</span>`;

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
                    <div class="nama-siswa">
                        ${escapeHTML(item.nama)}
                    </div>
                </td>

                <td>
                    <div class="nama-barang">
                        ${escapeHTML(item.nama_barang)}
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

                <td>
                    ${buatAksi(item)}
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
                throw new Error("Gagal mengambil data peminjaman");
            }

            return response.json();

        })

        .then(data => {

            const dataBaru = JSON.stringify(data);

            const dataLama = JSON.stringify(
                dataPeminjamanSebelumnya
            );


            if (dataBaru !== dataLama) {

                tampilkanPeminjaman(data);

                dataPeminjamanSebelumnya = data;

                console.log("✅ Data peminjaman diperbarui");

            }

        })

        .catch(error => {

            console.error( 
                "❌ Gagal memperbarui data peminjaman:",
                error
            );

        });

}


// Cek perubahan setiap 3 detik
setInterval(updatePeminjaman, 3000);

</script>

</body>

</html>