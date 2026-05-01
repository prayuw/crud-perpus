<?php
require_once '../config/Database.php';
require_once '../models/Buku.php';

$db = (new Database())->connect();
$buku = new Buku($db);


// ================== TAMBAH BUKU ==================
if (isset($_POST['tambah'])) {

    $judul   = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit= $_POST['penerbit'];
    $tahun   = $_POST['tahun'];
    $stok    = $_POST['stok'];

    // VALIDASI
    if (!$judul || !$penulis || !$penerbit || !$tahun || !$stok) {
        die("Data tidak boleh kosong!");
    }

    $buku->create([$judul, $penulis, $penerbit, $tahun, $stok]);

    header("Location: ../views/buku/list.php");
}


// ================== EDIT BUKU ==================
if (isset($_POST['edit'])) {

    $id      = $_POST['id'];
    $judul   = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit= $_POST['penerbit'];
    $tahun   = $_POST['tahun'];
    $stok    = $_POST['stok'];

    // VALIDASI
    if (!$id || !$judul || !$penulis || !$penerbit || !$tahun || !$stok) {
        die("Data tidak lengkap!");
    }

    $query = $db->prepare("
        UPDATE buku 
        SET judul=?, penulis=?, penerbit=?, tahun_terbit=?, stok=? 
        WHERE id_buku=?
    ");

    $query->execute([$judul, $penulis, $penerbit, $tahun, $stok, $id]);

    header("Location: ../views/buku/list.php");
}


// ================== HAPUS BUKU ==================
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    // CEK apakah buku sedang dipakai di peminjaman
    $cek = $db->prepare("SELECT COUNT(*) FROM detail_peminjaman WHERE id_buku=?");
    $cek->execute([$id]);
    $dipakai = $cek->fetchColumn();

    if ($dipakai > 0) {
        die("Buku tidak bisa dihapus karena sedang dipinjam!");
    }

    $query = $db->prepare("DELETE FROM buku WHERE id_buku=?");
    $query->execute([$id]);

    header("Location: ../views/buku/list.php");
}
?>