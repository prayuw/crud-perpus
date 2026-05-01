<?php
require_once '../../config/Database.php';

$db = (new Database())->connect();

$id = $_GET['id'];
$query = $db->prepare("SELECT * FROM anggota WHERE id_anggota=?");
$query->execute([$id]);
$data = $query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Edit Anggota</title>
</head>
<body>

<h2>✏️ Edit Anggota</h2>

<form method="POST" action="../../controllers/AnggotaController.php">

<input type="hidden" name="id" value="<?= $data['id_anggota'] ?>">

<input type="text" name="nama" value="<?= $data['nama'] ?>" required>
<input type="text" name="alamat" value="<?= $data['alamat'] ?>" required>
<input type="text" name="no_hp" value="<?= $data['no_hp'] ?>" required>

<button name="edit">Update</button>
<a href="list.php" class="back">Kembali</a>

</form>

</body>
</html>