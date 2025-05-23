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
    <title>Data Buku - Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            padding: 40px;
        }

        h2 {
            color: #333;
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

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-edit {
            color: #ffc107;
            margin-right: 8px;
            font-weight: bold;
        }

        .btn-hapus {
            color: #dc3545;
            font-weight: bold;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            color: #555;
        }
    </style>
</head>

<body>
    <h2>Data Buku</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>ID Kategori</th>
                <th>Aksi</th> <!-- Tambah header aksi -->
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = "SELECT * FROM buku";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['judul_buku']}</td>
                    <td>{$row['penulis']}</td>
                    <td>{$row['penerbit']}</td>
                    <td>{$row['tahun_terbit']}</td>
                    <td>{$row['id_kategori']}</td>
                    <td>
                        <a class='btn-edit' href='edit_buku.php?id={$row['id_buku']}'>Edit</a> |
                        <a class='btn-hapus' href='hapus_buku.php?id={$row['id_buku']}' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
    <br>
    <a class="back-link" href="../index.php">← Kembali ke Beranda</a>
</body>

</html>
