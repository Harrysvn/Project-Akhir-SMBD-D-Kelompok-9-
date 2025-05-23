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
    <title>Pengembalian Buku</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background-color: #f9fafb;
            color: #2c3e50;
        }
        h2, h3 {
            color: #34495e;
            margin-bottom: 15px;
            font-weight: 600;
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
            display: block;
            margin-top: 10px;
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

    <h2>Form Pengembalian Buku</h2>
    <form method="post" action="">
        <label>Pilih Peminjaman:</label>
        <select name="id_peminjaman" required>
            <option value="">-- Pilih --</option>
            <?php
            $query = "SELECT p.id_peminjaman, a.nama_anggota, b.judul_buku
                      FROM peminjaman p
                      JOIN anggota a ON p.id_anggota = a.id_anggota
                      JOIN buku b ON p.id_buku = b.id_buku
                      WHERE p.status = 'Dipinjam'";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['id_peminjaman']}'>
                        {$row['nama_anggota']} - {$row['judul_buku']}
                      </option>";
            }
            ?>
        </select>

        <label>Tanggal Kembali:</label>
        <input type="date" name="tanggal_kembali" required>

        <input type="submit" name="kembalikan" value="Kembalikan">
    </form>

    <?php
    if (isset($_POST['kembalikan'])) {
        $id_peminjaman = $_POST['id_peminjaman'];
        $tgl_kembali = $_POST['tanggal_kembali'];

        // Ambil tanggal jatuh tempo
        $get = mysqli_query($conn, "SELECT tanggal_jatuh_tempo FROM peminjaman WHERE id_peminjaman = $id_peminjaman");
        $data = mysqli_fetch_assoc($get);
        $tgl_jatuh = $data['tanggal_jatuh_tempo'];

        // Hitung denda
        $telat = (strtotime($tgl_kembali) - strtotime($tgl_jatuh)) / (60*60*24);
        $denda = ($telat > 0) ? $telat * 1000 : 0;

        // Simpan ke tabel pengembalian
        $insert = mysqli_query($conn, "INSERT INTO pengembalian (id_peminjaman, tanggal_kembali, denda)
                             VALUES ('$id_peminjaman', '$tgl_kembali', '$denda')");

        if($insert){
            // Update status di tabel peminjaman
            mysqli_query($conn, "UPDATE peminjaman SET status = 'Dikembalikan' WHERE id_peminjaman = $id_peminjaman");
            echo "<p class='success'>✅ Buku berhasil dikembalikan. Denda: Rp " . number_format($denda, 0, ',', '.') . "</p>";
        } else {
            echo "<p class='error'>❌ Gagal menyimpan pengembalian: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>

    <hr>
    <h3>Riwayat Pengembalian</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Kembali</th>
            <th>Denda</th>
        </tr>
        <?php
        $no = 1;
        $query = "SELECT a.nama_anggota, b.judul_buku, g.tanggal_kembali, g.denda
                  FROM pengembalian g
                  JOIN peminjaman p ON g.id_peminjaman = p.id_peminjaman
                  JOIN anggota a ON p.id_anggota = a.id_anggota
                  JOIN buku b ON p.id_buku = b.id_buku
                  ORDER BY g.id_pengembalian DESC";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>$no</td>
                    <td>{$row['nama_anggota']}</td>
                    <td>{$row['judul_buku']}</td>
                    <td>{$row['tanggal_kembali']}</td>
                    <td>Rp " . number_format($row['denda'], 0, ',', '.') . "</td>
                  </tr>";
            $no++;
        }
        ?>
    </table>
    <br>
    <a href="../index.php">← Kembali ke Beranda</a>
</body>
</html>
