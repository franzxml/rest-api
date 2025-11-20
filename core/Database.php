<?php

class Database
{
    private $type;
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $sslmode;
    public $conn;

    public function __construct() {

        // PostgreSQL Supabase
        $this->type = "pgsql";

        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->port = getenv('DB_PORT') ?: '6543'; 
        $this->db_name = getenv('DB_NAME') ?: 'postgres';

        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');

        $this->sslmode = getenv('DB_SSLMODE') ?: 'require';

        $this->connect();
    }

    private function connect() {

        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name};sslmode={$this->sslmode}";

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

        } catch (PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }
    }
}