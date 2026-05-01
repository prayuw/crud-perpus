<?php
require_once '../config/Database.php';

$db = (new Database())->connect();

// HITUNG DATA
$total_buku = $db->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$total_anggota = $db->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
$total_pinjam = $db->query("SELECT COUNT(*) FROM peminjaman WHERE status='dipinjam'")->fetchColumn();
$total_kembali = $db->query("SELECT COUNT(*) FROM peminjaman WHERE status='kembali'")->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Dashboard</title>
</head>
<body>

<h1>Dashboard Perpustakaan</h1>

<div class="dashboard">

    <div class="card">
        <h3><?= $total_buku ?></h3>
        <p>Total Buku</p>
    </div>

    <div class="card">
        <h3><?= $total_anggota ?></h3>
        <p>Total Anggota</p>
    </div>

    <div class="card">
        <h3><?= $total_pinjam ?></h3>
        <p>Sedang Dipinjam</p>
    </div>

    <div class="card">
        <h3><?= $total_kembali ?></h3>
        <p>Sudah Kembali</p>
    </div>

</div>

<h2>Menu</h2>

<div class="menu">
    <a href="buku/list.php">Kelola Buku</a>
    <a href="anggota/list.php">Kelola Anggota</a>
    <a href="peminjaman/list.php">Peminjaman</a>
    <a href="detail_peminjaman/list.php">Detail Peminjaman Buku</a>
</div>

</body>
</html>