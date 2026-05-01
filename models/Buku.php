<?php
class Buku {
    private $conn;
    public function __construct($db){ $this->conn = $db; }

    public function all(){
        return $this->conn->query("SELECT * FROM buku");
    }

    public function create($d){
        $q = $this->conn->prepare("INSERT INTO buku (gambar, judul, penulis, penerbit, tahun_terbit, stok) VALUES (?,?,?,?,?,?)");
        return $q->execute($d);
    }

    public function update($data) {
        $query = $this->conn->prepare("
            UPDATE buku 
            SET gambar=?, judul=?, penulis=?, penerbit=?, tahun_terbit=?, stok=?
            WHERE id_buku=?
        ");
        return $query->execute($data);
    }


    public function delete($id){
        return $this->conn->prepare("DELETE FROM buku WHERE id_buku=?")->execute([$id]);
    }

    public function find($id) {
        $query = $this->conn->prepare("SELECT * FROM buku WHERE id_buku=?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
?>