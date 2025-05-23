<?php 
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php"); // jika di folder pages/
    exit;
}

include('../config/koneksi.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Peminjaman dan Pengembalian</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background-color: #f9fafb;
            color: #34495e;
        }
        h2 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #2c3e50;
        }
        table {
            width: 90%;
            max-width: 1000px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #2980b9;
            color: white;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #f4f7f9;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #2980b9;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Laporan: Riwayat Peminjaman & Pengembalian</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = "SELECT * FROM view_riwayat_peminjaman";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $tgl_kembali = !empty($row['tanggal_kembali']) ? $row['tanggal_kembali'] : '-';
                $denda = number_format($row['denda'], 0, ',', '.');
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama_anggota']}</td>
                        <td>{$row['judul_buku']}</td>
                        <td>{$row['tanggal_pinjam']}</td>
                        <td>{$row['tanggal_jatuh_tempo']}</td>
                        <td>{$tgl_kembali}</td>
                        <td>Rp {$denda}</td>
                      </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
    <a href="../index.php">← Kembali ke Beranda</a>
</body>
</html>
