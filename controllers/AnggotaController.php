<?php
require_once '../config/Database.php';
require_once '../models/Anggota.php';

$db = (new Database())->connect();
$anggota = new Anggota($db);


// ================== TAMBAH ANGGOTA ==================
if (isset($_POST['tambah'])) {

    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp  = $_POST['no_hp'];

    // VALIDASI
    if (!$nama || !$alamat || !$no_hp) {
        die("Data tidak boleh kosong!");
    }

    $anggota->create([$nama, $alamat, $no_hp]);

    header("Location: ../views/anggota/list.php");
}


// ================== EDIT ANGGOTA ==================
if (isset($_POST['edit'])) {

    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp  = $_POST['no_hp'];

    // VALIDASI
    if (!$id || !$nama || !$alamat || !$no_hp) {
        die("Data tidak lengkap!");
    }

    $query = $db->prepare("
        UPDATE anggota 
        SET nama=?, alamat=?, no_hp=? 
        WHERE id_anggota=?
    ");

    $query->execute([$nama, $alamat, $no_hp, $id]);

    header("Location: ../views/anggota/list.php");
}


// ================== HAPUS ANGGOTA ==================
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    // OPTIONAL: cek apakah masih dipakai di peminjaman
    $cek = $db->prepare("SELECT COUNT(*) FROM peminjaman WHERE id_anggota=?");
    $cek->execute([$id]);
    $dipakai = $cek->fetchColumn();

    if ($dipakai > 0) {
        die("Anggota tidak bisa dihapus karena masih memiliki peminjaman!");
    }

    $query = $db->prepare("DELETE FROM anggota WHERE id_anggota=?");
    $query->execute([$id]);

    header("Location: ../views/anggota/list.php");
}
?>