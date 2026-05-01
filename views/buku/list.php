<?php
require_once '../../config/Database.php';
require_once '../../models/Buku.php';

$db = (new Database())->connect();
$buku = new Buku($db);
$data = $buku->all();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Data Buku</title>
</head>
<body>

<h2>📚 Data Buku</h2>

<a href="tambah.php" class="btn">+ Tambah Buku</a>

<table>
<tr>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Penerbit</th>
    <th>Tahun</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>

<?php foreach($data as $row): ?>
<tr>
    <td><?= $row['judul'] ?></td>
    <td><?= $row['penulis'] ?></td>
    <td><?= $row['penerbit'] ?></td>
    <td><?= $row['tahun_terbit'] ?></td>
    <td><?= $row['stok'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id_buku'] ?>" class="edit">Edit</a>
        <a href="../../controllers/BukuController.php?hapus=<?= $row['id_buku'] ?>" class="hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>