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
    <title>Data Peminjaman</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background-color: #f9fafb;
            color: #2c3e50;
        }
        h2 {
            margin-bottom: 15px;
            font-weight: 600;
            color: #34495e;
        }
        form {
            background: #fff;
            padding: 20px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 500px;
            margin-bottom: 40px;
        }
        label {
            font-weight: 600;
            margin-top: 10px;
            display: block;
            color: #34495e;
        }
        select, input[type="date"], input[type="submit"] {
            width: 100%;
            padding: 8px 12px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1.5px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        select:focus, input[type="date"]:focus {
            border-color: #2980b9;
            outline: none;
        }
        input[type="submit"] {
            background-color: #2980b9;
            color: white;
            font-weight: 600;
            cursor: pointer;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #1f6391;
        }
        table {
            width: 100%;
            max-width: 900px;
            border-collapse: collapse;
            background: #fff;
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
        p {
            font-weight: 600;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        p.success {
            color: green;
        }
        p.error {
            color: red;
        }
        a {
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
    <h2>Form Peminjaman Buku</h2>
    <form method="post" action="">
        <label>Nama Anggota:</label>
        <select name="id_anggota" required>
            <option value="">-- Pilih Anggota --</option>
            <?php
            $anggota = mysqli_query($conn, "SELECT * FROM anggota");
            while ($a = mysqli_fetch_assoc($anggota)) {
                echo "<option value='{$a['id_anggota']}'>{$a['nama_anggota']}</option>";
            }
            ?>
        </select>

        <label>Judul Buku:</label>
        <select name="id_buku" required>
            <option value="">-- Pilih Buku --</option>
            <?php
            $buku = mysqli_query($conn, "SELECT * FROM buku");
            while ($b = mysqli_fetch_assoc($buku)) {
                echo "<option value='{$b['id_buku']}'>{$b['judul_buku']}</option>";
            }
            ?>
        </select>

        <label>Tanggal Pinjam:</label>
        <input type="date" name="tanggal_pinjam" required>

        <label>Tanggal Jatuh Tempo:</label>
        <input type="date" name="tanggal_jatuh_tempo" required>

        <input type="submit" name="simpan" value="Simpan">
    </form>

    <?php
    if (isset($_POST['simpan'])) {
        $id_anggota = $_POST['id_anggota'];
        $id_buku = $_POST['id_buku'];
        $tgl_pinjam = $_POST['tanggal_pinjam'];
        $tgl_tempo = $_POST['tanggal_jatuh_tempo'];
        $status = 'Dipinjam';

        $query = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_jatuh_tempo, status)
                  VALUES ('$id_anggota', '$id_buku', '$tgl_pinjam', '$tgl_tempo', '$status')";
        $hasil = mysqli_query($conn, $query);

        if ($hasil) {
            echo "<p class='success'>✅ Data peminjaman berhasil disimpan!</p>";
        } else {
            echo "<p class='error'>❌ Gagal menyimpan: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>

    <hr>

    <h2>Daftar Peminjaman Aktif</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $q = "SELECT p.*, a.nama_anggota, b.judul_buku
              FROM peminjaman p
              JOIN anggota a ON p.id_anggota = a.id_anggota
              JOIN buku b ON p.id_buku = b.id_buku
              ORDER BY p.id_peminjaman DESC";
        $r = mysqli_query($conn, $q);
        while ($row = mysqli_fetch_assoc($r)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_anggota']}</td>
                    <td>{$row['judul_buku']}</td>
                    <td>{$row['tanggal_pinjam']}</td>
                    <td>{$row['tanggal_jatuh_tempo']}</td>
                    <td>{$row['status']}</td>
                </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>

    <br>
    <a href="../index.php">← Kembali ke Beranda</a>
</body>
</html>
