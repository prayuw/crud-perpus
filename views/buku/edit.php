<?php
require_once '../../config/Database.php';

$db = (new Database())->connect();

$id = $_GET['id'];
$query = $db->prepare("SELECT * FROM buku WHERE id_buku=?");
$query->execute([$id]);
$data = $query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Edit Buku</title>
</head>
<body>

<h2>Edit Buku</h2>

<form method="POST" action="../../controllers/BukuController.php" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $data['id_buku'] ?>">

<input type="file" name="gambar">
<input type="text" name="judul" value="<?= $data['judul'] ?>" required>
<input type="text" name="penulis" value="<?= $data['penulis'] ?>" required>
<input type="text" name="penerbit" value="<?= $data['penerbit'] ?>" required>
<input type="number" name="tahun" value="<?= $data['tahun_terbit'] ?>" required>
<input type="number" name="stok" value="<?= $data['stok'] ?>" required>

<button name="edit">Update</button>
<a href="list.php" class="back">Kembali</a>

</form>

</body>
</html>