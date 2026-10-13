<?php

session_start();

include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: barang.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($koneksi, "DELETE FROM barang WHERE id='$id'");

if ($query) {
    header("Location: barang.php");
    exit;
} else {
    echo "Data gagal dihapus: " . mysqli_error($koneksi);
}

?>