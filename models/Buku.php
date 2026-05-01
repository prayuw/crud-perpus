<?php
class Buku {
    private $conn;
    public function __construct($db){ $this->conn = $db; }

    public function all(){
        return $this->conn->query("SELECT * FROM buku");
    }

    public function create($d){
        $q = $this->conn->prepare("INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok) VALUES (?,?,?,?,?)");
        return $q->execute($d);
    }

    public function delete($id){
        return $this->conn->prepare("DELETE FROM buku WHERE id_buku=?")->execute([$id]);
    }
}
?>