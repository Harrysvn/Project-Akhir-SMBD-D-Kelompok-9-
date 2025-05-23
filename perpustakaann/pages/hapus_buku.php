<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php"); // jika di folder pages/
    exit;
}

include('../config/koneksi.php');

// Amankan input id dengan intval supaya hanya angka
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Hapus data dari tabel buku berdasarkan id
    $query = "DELETE FROM buku WHERE id_buku = $id";
    $hapus = mysqli_query($conn, $query);

    if ($hapus) {
        header("Location: buku.php");
        exit;
    } else {
        echo "<p style='color:red;'>❌ Gagal menghapus data: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:red;'>❌ ID buku tidak valid.</p>";
}
?>
