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
    <title>Tambah Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f9faff;
            color: #2c3e50;
        }
        h2 {
            margin-bottom: 20px;
            font-weight: 700;
        }
        form {
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px 10px;
            margin-top: 6px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #2980b9;
            outline: none;
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
    <h2>Form Tambah Buku</h2>
    <form method="post" action="">
        <label>Judul Buku:</label>
        <input type="text" name="judul_buku" required>

        <label>Penulis:</label>
        <input type="text" name="penulis">

        <label>Penerbit:</label>
        <input type="text" name="penerbit">

        <label>Tahun Terbit:</label>
        <input type="number" name="tahun_terbit" min="1000" max="<?php echo date('Y'); ?>" placeholder="e.g., 2020">

        <label>Kategori:</label>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $kategori = mysqli_query($conn, "SELECT * FROM kategori");
            while ($k = mysqli_fetch_assoc($kategori)) {
                echo "<option value='" . htmlspecialchars($k['id_kategori']) . "'>" . htmlspecialchars($k['nama_kategori']) . "</option>";
            }
            ?>
        </select>

        <input type="submit" name="simpan" value="Simpan">
    </form>

    <a href="buku.php">← Kembali ke Data Buku</a>

    <?php
    if (isset($_POST['simpan'])) {
        $judul     = mysqli_real_escape_string($conn, $_POST['judul_buku']);
        $penulis   = mysqli_real_escape_string($conn, $_POST['penulis']);
        $penerbit  = mysqli_real_escape_string($conn, $_POST['penerbit']);
        $tahun     = intval($_POST['tahun_terbit']);
        $kategori  = mysqli_real_escape_string($conn, $_POST['id_kategori']);

        // Validasi tahun terbit jika diisi
        if ($tahun !== 0 && ($tahun < 1000 || $tahun > intval(date('Y')))) {
            echo "<p class='error'>❌ Tahun terbit tidak valid!</p>";
        } else {
            $query = "INSERT INTO buku (judul_buku, penulis, penerbit, tahun_terbit, id_kategori) 
                      VALUES ('$judul', '$penulis', '$penerbit', " . ($tahun ? $tahun : "NULL") . ", '$kategori')";
            $hasil = mysqli_query($conn, $query);

            if ($hasil) {
                echo "<p class='success'>✅ Buku berhasil ditambahkan!</p>";
            } else {
                echo "<p class='error'>❌ Gagal menambahkan buku: " . mysqli_error($conn) . "</p>";
            }
        }
    }
    ?>
</body>

</html>
