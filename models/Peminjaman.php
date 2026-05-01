<?php
class Peminjaman {
    private $conn;
    public function __construct($db){ $this->conn = $db; }

    public function create($id_anggota){
        $q = $this->conn->prepare("INSERT INTO peminjaman (id_anggota, tanggal_pinjam) VALUES (?, NOW())");
        $q->execute([$id_anggota]);
        return $this->conn->lastInsertId();
    }

    public function all(){
        return $this->conn->query("SELECT p.*, a.nama FROM peminjaman p JOIN anggota a ON p.id_anggota=a.id_anggota");
    }
}
?>