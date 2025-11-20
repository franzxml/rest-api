<?php
require_once __DIR__ . '/../core/Database.php';

class MahasiswaModel
{
    private $conn;
    private $table = "mahasiswa";

    public function __construct()
    {
        // langsung pakai properti conn dari Database
        $this->conn = (new Database())->conn;
    }

    public function getAll()
    {
        $sql = "select * from {$this->table} order by id desc";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $sql = "select * from {$this->table} where id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public function store($data)
    {
        $sql = "insert into {$this->table} (nama, jurusan) values (:nama, :jurusan)";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            ":nama" => $data["nama"],
            ":jurusan" => $data["jurusan"]
        ]);

        return [
            "success" => $ok,
            "id" => $ok ? $this->conn->lastInsertId() : null
        ];
    }

    public function update($id, $data)
    {
        $sql = "update {$this->table} set nama = :nama, jurusan = :jurusan where id = :id";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            ":nama" => $data["nama"],
            ":jurusan" => $data["jurusan"],
            ":id" => $id
        ]);
        return ["success" => $ok];
    }

    public function delete($id)
    {
        $sql = "delete from {$this->table} where id = :id";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([":id" => $id]);
        return ["success" => $ok];
    }
}