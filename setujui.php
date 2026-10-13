<?php

session_start();

include "../config/koneksi.php";

// Pastikan yang mengakses adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Cek ID peminjaman
if (!isset($_GET['id'])) {
    header("Location: peminjaman.php");
    exit;
}

$id = $_GET['id'];

// Ambil data peminjaman
$query = mysqli_prepare(
    $koneksi,
    "SELECT * FROM peminjaman WHERE id = ?"
);

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$peminjaman = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan
if (!$peminjaman) {
    echo "Data peminjaman tidak ditemukan.";
    exit;
}

// Pastikan status masih Menunggu
if ($peminjaman['status'] != 'Menunggu') {
    header("Location: peminjaman.php");
    exit;
}

$barang_id = $peminjaman['barang_id'];
$jumlah_pinjam = $peminjaman['jumlah'];

// Ambil stok barang
$query_barang = mysqli_prepare(
    $koneksi,
    "SELECT jumlah FROM barang WHERE id = ?"
);

mysqli_stmt_bind_param($query_barang, "i", $barang_id);
mysqli_stmt_execute($query_barang);

$result_barang = mysqli_stmt_get_result($query_barang);
$barang = mysqli_fetch_assoc($result_barang);

// Cek barang
if (!$barang) {
    echo "Barang tidak ditemukan.";
    exit;
}

// Cek apakah stok cukup
if ($barang['jumlah'] < $jumlah_pinjam) {

    echo "<script>
        alert('Stok barang tidak mencukupi!');
        window.location='peminjaman.php';
    </script>";

    exit;
}

// Kurangi stok barang
$stok_baru = $barang['jumlah'] - $jumlah_pinjam;

$update_barang = mysqli_prepare(
    $koneksi,
    "UPDATE barang SET jumlah = ? WHERE id = ?"
);

mysqli_stmt_bind_param(
    $update_barang,
    "ii",
    $stok_baru,
    $barang_id
);

mysqli_stmt_execute($update_barang);

// Jika stok habis, ubah status barang
if ($stok_baru == 0) {

    $update_status = mysqli_prepare(
        $koneksi,
        "UPDATE barang SET status = 'Tidak Tersedia' WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $update_status,
        "i",
        $barang_id
    );

    mysqli_stmt_execute($update_status);
}

// Ubah status peminjaman menjadi Disetujui
$update_peminjaman = mysqli_prepare(
    $koneksi,
    "UPDATE peminjaman SET status = 'Disetujui' WHERE id = ?"
);

mysqli_stmt_bind_param(
    $update_peminjaman,
    "i",
    $id
);

mysqli_stmt_execute($update_peminjaman);

// Kembali ke halaman peminjaman
header("Location: peminjaman.php");
exit;

?>