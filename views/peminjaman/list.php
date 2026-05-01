<?php
require_once '../../config/Database.php';

$db = (new Database())->connect();

// JOIN semua tabel
$query = $db->query("
    SELECT p.*, a.nama, b.judul, d.jumlah
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id_anggota
    JOIN detail_peminjaman d ON p.id_peminjaman = d.id_peminjaman
    JOIN buku b ON d.id_buku = b.id_buku
    ORDER BY p.id_peminjaman DESC
");

$data = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Data Peminjaman</title>
</head>
<body>

<h1>Data Peminjaman</h1>

<a href="tambah.php" class="btn">+ Pinjam Buku</a>

<table>
<tr>
    <th>Nama</th>
    <th>Buku</th>
    <th>Jumlah</th>
    <th>Tanggal Pinjam</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php foreach($data as $row): ?>
<tr>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['judul'] ?></td>
    <td><?= $row['jumlah'] ?></td>
    <td><?= $row['tanggal_pinjam'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <?php if($row['status'] == 'dipinjam'): ?>
            <a href="../../controllers/PeminjamanController.php?kembali=<?= $row['id_peminjaman'] ?>" 
               class="edit">Kembalikan</a>
        <?php else: ?>
            <span style="color:green;">Selesai</span>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>

</table>

<div class="button-group">
    <a href="../dashboard.php" class="btn btn-dashboard">Kembali ke Dashboard</a>
</div>

</body>
</html>