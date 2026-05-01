<?php
class Anggota {
    private $conn;
    public function __construct($db){ $this->conn = $db; }

    public function all(){
        return $this->conn->query("SELECT * FROM anggota");
    }

    public function create($d){
        $q = $this->conn->prepare("INSERT INTO anggota (nama, alamat, no_hp) VALUES (?,?,?)");
        return $q->execute($d);
    }
}
?>