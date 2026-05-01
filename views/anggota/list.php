<?php
require_once '../../config/Database.php';
require_once '../../models/Anggota.php';

$db = (new Database())->connect();
$anggota = new Anggota($db);
$data = $anggota->all();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Data Anggota</title>
</head>
<body>

<h1>Data Anggota</h1>

<a href="tambah.php" class="btn">+ Tambah Anggota</a>

<table>
<tr>
    <th>Nama</th>
    <th>Alamat</th>
    <th>No HP</th>
    <th>Aksi</th>
</tr>

<?php foreach($data as $row): ?>
<tr>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['alamat'] ?></td>
    <td><?= $row['no_hp'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id_anggota'] ?>" class="edit">Edit</a>
        <a href="../../controllers/AnggotaController.php?hapus=<?= $row['id_anggota'] ?>" 
           class="hapus" 
           onclick="return confirm('Yakin hapus anggota ini?')">
           Hapus
        </a>
    </td>
</tr>
<?php endforeach; ?>

</table>

<div class="button-group">
    <a href="../dashboard.php" class="btn btn-dashboard">Kembali ke Dashboard</a>
</div>

</body>
</html>