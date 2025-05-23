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
    <title>Tambah Anggota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f7f9fc;
            color: #333;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
        }
        form {
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #34495e;
        }
        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 8px 12px;
            margin-top: 6px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, input[type="date"]:focus, textarea:focus {
            border-color: #2980b9;
            outline: none;
        }
        textarea {
            min-height: 80px;
        }
        input[type="submit"] {
            margin-top: 25px;
            background-color: #2980b9;
            color: white;
            font-weight: 700;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #1f6391;
        }
        p {
            margin-top: 15px;
            font-weight: 600;
        }
        p.success {
            color: green;
        }
        p.error {
            color: red;
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

    <h2>Form Tambah Anggota</h2>
    <form method="post" action="">
        <label>Nama Anggota:</label>
        <input type="text" name="nama_anggota" required>

        <label>Alamat:</label>
        <textarea name="alamat" required></textarea>

        <label>No HP:</label>
        <input type="text" name="no_hp" required>

        <label>Tanggal Daftar:</label>
        <input type="date" name="tanggal_daftar" required>

        <input type="submit" name="simpan" value="Simpan">
    </form>

    <a href="anggota.php">← Kembali ke Data Anggota</a>

    <?php
    if (isset($_POST['simpan'])) {
        $nama     = mysqli_real_escape_string($conn, $_POST['nama_anggota']);
        $alamat   = mysqli_real_escape_string($conn, $_POST['alamat']);
        $no_hp    = mysqli_real_escape_string($conn, $_POST['no_hp']);
        $tanggal  = mysqli_real_escape_string($conn, $_POST['tanggal_daftar']);

        $query = "INSERT INTO anggota (nama_anggota, alamat, no_hp, tanggal_daftar)
                  VALUES ('$nama', '$alamat', '$no_hp', '$tanggal')";
        $hasil = mysqli_query($conn, $query);

        if ($hasil) {
            echo "<p class='success'>✅ Anggota berhasil ditambahkan!</p>";
        } else {
            echo "<p class='error'>❌ Gagal menambahkan anggota: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>

</body>
</html>
