<?php

namespace Letalandroid\controllers;

require_once '../model/Database.php';
use Letalandroid\model\Database;
use PDO;

class Usuario extends Database {
    private string $id;

    public function __construct(private string $correo, private string $password) {

        parent::__construct();

        $this->id = uniqid();
        $this->$correo = $correo;
        $this->$password = $password;

    }

    public static function add(string $correo, string $password)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into usuarios (correo,password) values (?,?)');
            $query->bindValue(1, $correo, PDO::PARAM_STR);
            $query->bindValue(2, $password, PDO::PARAM_STR);
            $query->execute();
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public static function getLastId()
    {
        try {
            $usuarios = [];
            $db = new Database();
            $query = $db->connect()->prepare('select * from usuarios order by 1 desc limit 1');
            $query->execute();

            while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
                $usuario = Usuario::createdFromArray($r);
                array_push($usuarios, $usuario);
            }

            return $usuarios;
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    // public static function edit(int $id, string $title, string $content)
    // {
    //     $db = new Database();
    //     $query = $db->connect()->prepare('update notes set title=?, content=? where id=?');
    //     $query->bindValue(1,$title, PDO::PARAM_STR);
    //     $query->bindValue(2, $content, PDO::PARAM_STR);
    //     $query->bindValue(3, $id, PDO::PARAM_INT);
    //     $query->execute();
    // }

    // public static function delete(int $id)
    // {
    //     $db = new Database();
    //     $query = $db->connect()->prepare('delete from notes where id=?');
    //     $query->bindValue(1, $id, PDO::PARAM_INT);
    //     $query->execute();
    // }

    public static function getAll() {
        $usuarios = [];
        $db = new Database();
        $query = $db->connect()->prepare('select * from usuarios;');
        $query->execute();

        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            $usuario = Usuario::createdFromArray($r);
            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }

    public static function createdFromArray($arr): Usuario {
        $usuario = new Usuario($arr['correo'], $arr['password']);
        $usuario->setID($arr['user_id']);

        return $usuario;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setID($v) {
        $this->id = $v;
    }
}