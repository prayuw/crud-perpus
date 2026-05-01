<?php
require_once '../../config/Database.php';

$db = (new Database())->connect();

// ambil anggota & buku
$anggota = $db->query("SELECT * FROM anggota");
$buku    = $db->query("SELECT * FROM buku WHERE stok > 0");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Pinjam Buku</title>
</head>
<body>

<h2>📚 Pinjam Buku</h2>

<form method="POST" action="../../controllers/PeminjamanController.php">

<label>Anggota</label>
<select name="id_anggota" required>
    <option value="">-- Pilih Anggota --</option>
    <?php foreach($anggota as $a): ?>
        <option value="<?= $a['id_anggota'] ?>">
            <?= $a['nama'] ?>
        </option>
    <?php endforeach; ?>
</select>

<label>Buku</label>
<select name="id_buku" required>
    <option value="">-- Pilih Buku --</option>
    <?php foreach($buku as $b): ?>
        <option value="<?= $b['id_buku'] ?>">
            <?= $b['judul'] ?> (Stok: <?= $b['stok'] ?>)
        </option>
    <?php endforeach; ?>
</select>

<input type="number" name="jumlah" placeholder="Jumlah" required min="1">

<button name="pinjam">Pinjam</button>
<a href="list.php" class="back">Kembali</a>

</form>

</body>
</html>