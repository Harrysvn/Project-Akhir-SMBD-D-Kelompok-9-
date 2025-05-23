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
    <title>Data Pengembalian - Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            padding: 40px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        thead {
            background-color: #007bff;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        a.back-link {
            display: inline-block;
            margin-top: 20px;
            color: #555;
            text-decoration: none;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h2>Daftar Semua Pengembalian</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = "SELECT g.*, a.nama_anggota, b.judul_buku
                      FROM pengembalian g
                      JOIN peminjaman p ON g.id_peminjaman = p.id_peminjaman
                      JOIN anggota a ON p.id_anggota = a.id_anggota
                      JOIN buku b ON p.id_buku = b.id_buku
                      ORDER BY g.tanggal_kembali DESC";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama_anggota']}</td>
                        <td>{$row['judul_buku']}</td>
                        <td>{$row['tanggal_kembali']}</td>
                        <td>Rp " . number_format($row['denda'], 0, ',', '.') . "</td>
                      </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
    <a href="../index.php" class="back-link">← Kembali ke Beranda</a>
</body>

</html>
