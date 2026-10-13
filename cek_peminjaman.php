<?php

session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    http_response_code(403);
    exit;
}

$user_id = $_SESSION['id'];

$query = mysqli_query(
    $koneksi,
    "SELECT 
        peminjaman.id,
        peminjaman.jumlah,
        peminjaman.tanggal_pinjam,
        peminjaman.tanggal_kembali,
        peminjaman.status,
        barang.nama_barang,
        barang.kategori
     FROM peminjaman
     JOIN barang ON peminjaman.barang_id = barang.id
     WHERE peminjaman.user_id = '$user_id'
     ORDER BY peminjaman.id DESC"
);

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

header('Content-Type: application/json');

echo json_encode($data);

?>