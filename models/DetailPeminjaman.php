<?php
class DetailPeminjaman {
    private $conn;
    public function __construct($db){ $this->conn = $db; }

    public function add($id_pinjam, $id_buku, $jumlah){
        $this->conn->prepare("INSERT INTO detail_peminjaman (id_peminjaman,id_buku,jumlah) VALUES (?,?,?)")
        ->execute([$id_pinjam,$id_buku,$jumlah]);

        $this->conn->prepare("UPDATE buku SET stok = stok - ? WHERE id_buku=?")
        ->execute([$jumlah,$id_buku]);
    }
}
?>