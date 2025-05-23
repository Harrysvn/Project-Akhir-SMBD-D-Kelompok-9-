<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php"); // jika di folder pages/
    exit;
}

include('../config/koneksi.php');

// Ambil ID dari URL dan amankan dengan intval agar hanya angka
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Hapus anggota berdasarkan ID
    $query = "DELETE FROM anggota WHERE id_anggota = $id";
    $hapus = mysqli_query($conn, $query);

    if ($hapus) {
        header("Location: anggota.php");
        exit;
    } else {
        echo "<p style='color:red;'>❌ Gagal menghapus data: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:red;'>❌ ID anggota tidak valid.</p>";
}
?>
