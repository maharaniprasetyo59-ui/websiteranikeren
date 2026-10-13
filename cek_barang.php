<?php

session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    http_response_code(403);
    exit;
}

$query = mysqli_query(
    $koneksi,
    "SELECT
        id,
        nama_barang,
        kategori,
        jumlah,
        kondisi,
        status
     FROM barang
     WHERE status = 'Tersedia'
     AND jumlah > 0
     ORDER BY id DESC"
);

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

header('Content-Type: application/json');

echo json_encode($data);

?>