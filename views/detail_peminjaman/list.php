<?php
require_once '../../config/Database.php';

$db = (new Database())->connect();

// JOIN semua tabel
$query = $db->query("
    SELECT 
        d.id_detail,
        a.nama,
        b.judul,
        d.jumlah,
        p.tanggal_pinjam,
        p.status
    FROM detail_peminjaman d
    JOIN peminjaman p ON d.id_peminjaman = p.id_peminjaman
    JOIN anggota a ON p.id_anggota = a.id_anggota
    JOIN buku b ON d.id_buku = b.id_buku
    ORDER BY d.id_detail DESC
");

$data = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Detail Peminjaman</title>
</head>
<body>

<h1>Detail Peminjaman</h1>

<a href="../peminjaman/list.php" class="btn"> Kembali ke Peminjaman</a>

<table>
<tr>
    <th>Nama</th>
    <th>Judul Buku</th>
    <th>Jumlah</th>
    <th>Tanggal Pinjam</th>
    <th>Status</th>
</tr>

<?php foreach($data as $row): ?>
<tr>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['judul'] ?></td>
    <td><?= $row['jumlah'] ?></td>
    <td><?= $row['tanggal_pinjam'] ?></td>
    <td>
        <?php if($row['status'] == 'dipinjam'): ?>
            <span style="color:orange;">Dipinjam</span>
        <?php else: ?>
            <span style="color:green;">Kembali</span>
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