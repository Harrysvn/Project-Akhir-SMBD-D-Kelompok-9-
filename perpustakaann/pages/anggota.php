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
    <title>Data Anggota - Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            padding: 40px;
        }

        h2 {
            color: #333;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-tambah {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            display: inline-block;
        }

        .btn-tambah:hover {
            background-color: #218838;
        }

        .btn-edit {
            color: #ffc107;
        }

        .btn-hapus {
            color: #dc3545;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        th, td {
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

        .back-link {
            margin-top: 20px;
            display: inline-block;
            color: #555;
        }
    </style>
</head>
<body>
    <h2>Data Anggota</h2>
    <a class="btn-tambah" href="tambah_anggota.php">+ Tambah Anggota</a><br><br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Tanggal Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $query = "SELECT * FROM anggota";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_anggota']}</td>
                    <td>{$row['alamat']}</td>
                    <td>{$row['no_hp']}</td>
                    <td>{$row['tanggal_daftar']}</td>
                    <td>
                        <a class='btn-edit' href='edit_anggota.php?id={$row['id_anggota']}'>Edit</a> |
                        <a class='btn-hapus' href='hapus_anggota.php?id={$row['id_anggota']}' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
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
