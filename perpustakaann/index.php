<?php 
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php"); // jika di folder pages/
    exit;
}

include('config/koneksi.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Perpustakaan Digital</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff;
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            font-size: 26px;
            color: #2c3e50;
            margin-bottom: 40px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #2980b9;
            border-bottom: 2px solid #2980b9;
            padding-bottom: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .card {
            flex: 1 1 180px;
            max-width: 200px;
            background: #ecf0f1;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            transition: background 0.3s ease, color 0.3s ease;
            text-align: center;
            cursor: pointer;
            color: #2c3e50;
            font-weight: 600;
            user-select: none;
        }
        .card:hover {
            background: #2980b9;
            color: #fff;
        }
        .card a {
            text-decoration: none;
            color: inherit;
            display: block;
            font-size: 18px;
            line-height: 1.2;
        }
        .card a span {
            font-size: 28px;
            display: block;
            margin-bottom: 8px;
            user-select: none;
        }
        @media (max-width: 600px) {
            .card-container {
                flex-direction: column;
                align-items: center;
            }
            .card {
                max-width: 300px;
                width: 90%;
            }
        }
    </style>
</head>
<body>

<h1>📚 Dashboard Perpustakaan Digital</h1>

<div class="section">
    <h2>🔄 Transaksi</h2>
    <div class="card-container">
        <div class="card"><a href="pages/peminjaman.php"><span>➕</span>Peminjaman Buku</a></div>
        <div class="card"><a href="pages/pengembalian.php"><span>🔁</span>Pengembalian Buku</a></div>
    </div>
</div>

<div class="section">
    <h2>📊 Laporan</h2>
    <div class="card-container">
        <div class="card"><a href="pages/laporan_peminjaman_anggota.php"><span>📈</span>Peminjaman Per Anggota</a></div>
        <div class="card"><a href="pages/laporan_buku_populer.php"><span>🔥</span>Buku Terpopuler</a></div>
        <div class="card"><a href="pages/laporan_denda_anggota.php"><span>💰</span>Denda Per Anggota</a></div>
        <div class="card"><a href="pages/laporan_riwayat_peminjaman.php"><span>📝</span>Riwayat Peminjaman</a></div>
    </div>
</div>

<div class="section">
    <h2>📁 Data Master</h2>
    <div class="card-container">
        <div class="card"><a href="pages/anggota.php"><span>👤</span>Data Anggota</a></div>
        <div class="card"><a href="pages/buku.php"><span>📚</span>Daftar Buku</a></div>
        <div class="card"><a href="pages/kategori.php"><span>🏷️</span>Kategori Buku</a></div>
        <div class="card"><a href="pages/daftar_peminjaman.php"><span>📦</span>Semua Peminjaman</a></div>
        <div class="card"><a href="pages/daftar_pengembalian.php"><span>📦</span>Semua Pengembalian</a></div>
    </div>
</div>
<p><a href="logout.php">🚪 Logout</a></p>

</body>
</html>

