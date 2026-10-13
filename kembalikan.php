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

// Hanya peminjaman yang Disetujui yang bisa dikembalikan
if ($peminjaman['status'] != 'Disetujui') {
    header("Location: peminjaman.php");
    exit;
}

$barang_id = $peminjaman['barang_id'];
$jumlah = $peminjaman['jumlah'];

// Tambahkan kembali stok barang
$update_barang = mysqli_prepare(
    $koneksi,
    "UPDATE barang
     SET jumlah = jumlah + ?,
         status = 'Tersedia'
     WHERE id = ?"
);

mysqli_stmt_bind_param(
    $update_barang,
    "ii",
    $jumlah,
    $barang_id
);

mysqli_stmt_execute($update_barang);

// Ubah status peminjaman menjadi Selesai
$update_peminjaman = mysqli_prepare(
    $koneksi,
    "UPDATE peminjaman
     SET status = 'Selesai'
     WHERE id = ?"
);

mysqli_stmt_bind_param(
    $update_peminjaman,
    "i",
    $id
);

if (mysqli_stmt_execute($update_peminjaman)) {

    header("Location: peminjaman.php");
    exit;

} else {

    echo "Gagal memproses pengembalian.";

}

?>