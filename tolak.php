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
    "SELECT status FROM peminjaman WHERE id = ?"
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

// Hanya peminjaman yang masih Menunggu yang bisa ditolak
if ($peminjaman['status'] != 'Menunggu') {
    header("Location: peminjaman.php");
    exit;
}

// Ubah status menjadi Ditolak
$update = mysqli_prepare(
    $koneksi,
    "UPDATE peminjaman SET status = 'Ditolak' WHERE id = ?"
);

mysqli_stmt_bind_param($update, "i", $id);

if (mysqli_stmt_execute($update)) {

    header("Location: peminjaman.php");
    exit;

} else {

    echo "Gagal menolak peminjaman: " . mysqli_error($koneksi);

}

?>