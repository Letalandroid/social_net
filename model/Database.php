<?php

namespace Letalandroid\model;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $db;
    private string $user;
    private string $password;
    private string $charset;
    public $conn;
    public function __construct()
    {
        $this->host = 'localhost';
        $this->db = 'social_net'; // Change this
        $this->user = 'root';
        $this->password = '';
        $this->charset = 'utf8mb4';
    }

    public function connect() {
        try {
            $connection = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            return new PDO($connection, $this->user, $this->password, $options);
        } catch (PDOException $ex) {
            echo "Error en la conexión: $ex";
        }
    }
}
