<?php
require_once '../config/Database.php';

$db = (new Database())->connect();


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

    // ================== UPLOAD GAMBAR ==================
    $path = null;

    if (!empty($_FILES['gambar']['name'])) {

        $namaFile = $_FILES['gambar']['name'];
        $tmp      = $_FILES['gambar']['tmp_name'];

        $folder = "../assets/uploads/buku/";
        $namaBaru = time() . "_" . $namaFile;

        move_uploaded_file($tmp, $folder . $namaBaru);

        $path = "assets/uploads/buku/" . $namaBaru;
    }

    // INSERT DATA
    $query = $db->prepare("
        INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok, gambar)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $query->execute([
        $judul,
        $penulis,
        $penerbit,
        $tahun,
        $stok,
        $path
    ]);

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

    // ambil data lama
    $get = $db->prepare("SELECT gambar FROM buku WHERE id_buku=?");
    $get->execute([$id]);
    $old = $get->fetch(PDO::FETCH_ASSOC);

    $path = $old['gambar'];

    // CEK upload baru
    if (!empty($_FILES['gambar']['name'])) {

        $namaFile = $_FILES['gambar']['name'];
        $tmp      = $_FILES['gambar']['tmp_name'];

        $folder = "../assets/uploads/buku/";
        $namaBaru = time() . "_" . $namaFile;

        move_uploaded_file($tmp, $folder . $namaBaru);

        // hapus gambar lama
        if (!empty($old['gambar']) && file_exists("../" . $old['gambar'])) {
            unlink("../" . $old['gambar']);
        }

        $path = "assets/uploads/buku/" . $namaBaru;
    }

    // UPDATE
    $query = $db->prepare("
        UPDATE buku 
        SET judul=?, penulis=?, penerbit=?, tahun_terbit=?, stok=?, gambar=? 
        WHERE id_buku=?
    ");

    $query->execute([
        $judul,
        $penulis,
        $penerbit,
        $tahun,
        $stok,
        $path,
        $id
    ]);

    header("Location: ../views/buku/list.php");
}



// ================== HAPUS BUKU ==================
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    // cek apakah buku dipakai
    $cek = $db->prepare("SELECT COUNT(*) FROM detail_peminjaman WHERE id_buku=?");
    $cek->execute([$id]);
    $dipakai = $cek->fetchColumn();

    if ($dipakai > 0) {
        die("Buku tidak bisa dihapus karena sedang dipinjam!");
    }

    // ambil gambar
    $get = $db->prepare("SELECT gambar FROM buku WHERE id_buku=?");
    $get->execute([$id]);
    $data = $get->fetch(PDO::FETCH_ASSOC);

    // hapus file gambar
    if (!empty($data['gambar']) && file_exists("../" . $data['gambar'])) {
        unlink("../" . $data['gambar']);
    }

    // hapus data
    $query = $db->prepare("DELETE FROM buku WHERE id_buku=?");
    $query->execute([$id]);

    header("Location: ../views/buku/list.php");
}
?>