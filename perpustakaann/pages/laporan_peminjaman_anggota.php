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
    <title>Laporan Peminjaman Per Anggota</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background-color: #f5f7fa;
            color: #2c3e50;
        }
        h2 {
            margin-bottom: 20px;
            font-weight: 600;
        }
        table {
            width: 60%;
            max-width: 700px;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background: white;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #2980b9;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #ecf0f1;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #2980b9;
            font-weight: 600;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Laporan: Jumlah Peminjaman Per Anggota</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Jumlah Peminjaman</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = "SELECT * FROM view_peminjaman_per_anggota";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama_anggota']}</td>
                        <td>{$row['jumlah_peminjaman']}</td>
                      </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
    <a href="../index.php">← Kembali ke Beranda</a>
</body>
</html>
