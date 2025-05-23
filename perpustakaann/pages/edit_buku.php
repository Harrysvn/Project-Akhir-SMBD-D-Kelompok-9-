<?php 
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php"); // jika di folder pages/
    exit;
}

include('../config/koneksi.php'); 
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = $id");
$buku = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Buku - Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            padding: 40px;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        form {
            background-color: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a.back-link {
            display: inline-block;
            margin-top: 12px;
            color: #555;
            text-decoration: none;
            font-weight: 500;
        }

        a.back-link:hover {
            text-decoration: underline;
        }

        p.success {
            color: green;
            font-weight: bold;
            margin-top: 18px;
        }

        p.error {
            color: red;
            font-weight: bold;
            margin-top: 18px;
        }
    </style>
</head>

<body>
    <h2>Form Edit Buku</h2>
    <form method="post" action="">
        <label>Judul Buku:</label>
        <input type="text" name="judul_buku" value="<?= htmlspecialchars($buku['judul_buku']); ?>" required>

        <label>Penulis:</label>
        <input type="text" name="penulis" value="<?= htmlspecialchars($buku['penulis']); ?>">

        <label>Penerbit:</label>
        <input type="text" name="penerbit" value="<?= htmlspecialchars($buku['penerbit']); ?>">

        <label>Tahun Terbit:</label>
        <input type="number" name="tahun_terbit" value="<?= htmlspecialchars($buku['tahun_terbit']); ?>">

        <label>Kategori:</label>
        <select name="id_kategori">
            <?php
            $kategori = mysqli_query($conn, "SELECT * FROM kategori");
            while ($k = mysqli_fetch_assoc($kategori)) {
                $selected = ($k['id_kategori'] == $buku['id_kategori']) ? 'selected' : '';
                echo "<option value='{$k['id_kategori']}' $selected>" . htmlspecialchars($k['nama_kategori']) . "</option>";
            }
            ?>
        </select>

        <input type="submit" name="update" value="Update">
    </form>

    <a href="buku.php" class="back-link">← Kembali ke Data Buku</a>

    <?php
    if (isset($_POST['update'])) {
        $judul    = mysqli_real_escape_string($conn, $_POST['judul_buku']);
        $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
        $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
        $tahun    = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
        $kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);

        $query = "UPDATE buku SET 
                    judul_buku = '$judul', 
                    penulis = '$penulis', 
                    penerbit = '$penerbit', 
                    tahun_terbit = '$tahun', 
                    id_kategori = '$kategori'
                  WHERE id_buku = $id";
        $hasil = mysqli_query($conn, $query);

        if ($hasil) {
            echo "<p class='success'>✅ Buku berhasil diupdate!</p>";
        } else {
            echo "<p class='error'>❌ Gagal update: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>
</body>

</html>
