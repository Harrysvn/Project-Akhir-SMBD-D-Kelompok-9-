<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php"); // jika di folder pages/
    exit;
}

include('../config/koneksi.php');

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data anggota berdasarkan ID
$data = mysqli_query($conn, "SELECT * FROM anggota WHERE id_anggota = $id");
$anggota = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Anggota</title>
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
            max-width: 500px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a.back-link {
            display: inline-block;
            margin-top: 10px;
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
            margin-top: 20px;
        }

        p.error {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2>Edit Data Anggota</h2>
    <form method="post" action="">
        <label>Nama Anggota:</label>
        <input type="text" name="nama_anggota" value="<?= htmlspecialchars($anggota['nama_anggota']); ?>" required>

        <label>Alamat:</label>
        <textarea name="alamat" required><?= htmlspecialchars($anggota['alamat']); ?></textarea>

        <label>No HP:</label>
        <input type="text" name="no_hp" value="<?= htmlspecialchars($anggota['no_hp']); ?>" required>

        <label>Tanggal Daftar:</label>
        <input type="date" name="tanggal_daftar" value="<?= htmlspecialchars($anggota['tanggal_daftar']); ?>" required>

        <input type="submit" name="update" value="Update">
    </form>

    <a href="anggota.php" class="back-link">← Kembali ke Data Anggota</a>

    <?php
    if (isset($_POST['update'])) {
        $nama    = mysqli_real_escape_string($conn, $_POST['nama_anggota']);
        $alamat  = mysqli_real_escape_string($conn, $_POST['alamat']);
        $no_hp   = mysqli_real_escape_string($conn, $_POST['no_hp']);
        $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal_daftar']);

        $query = "UPDATE anggota SET 
                    nama_anggota = '$nama',
                    alamat = '$alamat',
                    no_hp = '$no_hp',
                    tanggal_daftar = '$tanggal'
                  WHERE id_anggota = $id";
        $hasil = mysqli_query($conn, $query);

        if ($hasil) {
            echo "<p class='success'>✅ Data berhasil diupdate!</p>";
        } else {
            echo "<p class='error'>❌ Gagal update: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>
</body>

</html>
