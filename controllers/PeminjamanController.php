<?php
require_once '../config/Database.php';
require_once '../models/Peminjaman.php';
require_once '../models/DetailPeminjaman.php';

$db = (new Database())->connect();
$peminjaman = new Peminjaman($db);
$detail = new DetailPeminjaman($db);


// ================== PINJAM BUKU ==================
if (isset($_POST['pinjam'])) {

    $id_anggota = $_POST['id_anggota'];
    $id_buku    = $_POST['id_buku'];
    $jumlah     = $_POST['jumlah'];

    // VALIDASI
    if (!$id_anggota || !$id_buku || !$jumlah) {
        die("Data tidak lengkap!");
    }

    try {
        $db->beginTransaction();

        // CEK STOK
        $cek = $db->prepare("SELECT stok FROM buku WHERE id_buku=?");
        $cek->execute([$id_buku]);
        $stok = $cek->fetchColumn();

        if ($stok < $jumlah) {
            die("Stok buku tidak mencukupi!");
        }

        // INSERT PEMINJAMAN
        $id_pinjam = $peminjaman->create($id_anggota);

        // INSERT DETAIL + UPDATE STOK
        $detail->add($id_pinjam, $id_buku, $jumlah);

        $db->commit();

        header("Location: ../views/peminjaman/list.php");

    } catch (Exception $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
}


// ================== PENGEMBALIAN ==================
if (isset($_GET['kembali'])) {

    $id = $_GET['kembali'];

    try {
        $db->beginTransaction();

        // AMBIL DETAIL
        $q = $db->prepare("
            SELECT id_buku, jumlah 
            FROM detail_peminjaman 
            WHERE id_peminjaman=?
        ");
        $q->execute([$id]);
        $details = $q->fetchAll(PDO::FETCH_ASSOC);

        // KEMBALIKAN STOK
        foreach ($details as $d) {
            $db->prepare("
                UPDATE buku 
                SET stok = stok + ? 
                WHERE id_buku=?
            ")->execute([$d['jumlah'], $d['id_buku']]);
        }

        // UPDATE STATUS PEMINJAMAN
        $db->prepare("
            UPDATE peminjaman 
            SET status='kembali', tanggal_kembali=CURDATE()
            WHERE id_peminjaman=?
        ")->execute([$id]);

        $db->commit();

        header("Location: ../views/peminjaman/list.php");

    } catch (Exception $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>