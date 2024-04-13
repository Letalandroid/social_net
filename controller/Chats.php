<?php

namespace Letalandroid\controllers;

require_once '/home/letalandroid/Letalandroid/programming/php/social_net/model/Database.php';

use Letalandroid\model\Database;
use PDO;

class Chats extends Database
{

    public function __construct(private string $id_post, private string $username, private string $descripcion)
    {

        parent::__construct();
        $this->id_post = $id_post;
        $this->username = $username;
        $this->descripcion = $descripcion;
    }

    public static function add(int $id_post, int $user_id, string $descripcion)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into comentarios (id_post,user_id,descripcion) values (?,?,?)');
            $query->bindValue(1, $id_post, PDO::PARAM_INT);
            $query->bindValue(2, $user_id, PDO::PARAM_INT);
            $query->bindValue(3, $descripcion, PDO::PARAM_STR);
            $query->execute();
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public static function getAll(int $id_post)
    {
        $chats = [];
        $db = new Database();
        $query = $db->connect()->prepare('select * from all_chats where id_post=?;');
        $query->bindValue(1, $id_post, PDO::PARAM_INT);
        $query->execute();

        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            $chat = Chats::createdFromArray($r);
            array_push($chats, $chat);
        }

        return $chats;
    }

    public static function createdFromArray($arr): Chats
    {
        return new Chats($arr['id_post'], $arr['username'], $arr['descripcion']);
    }

    public function getIdPost()
    {
        return $this->id_post;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setID($v)
    {
        $this->id_post = $v;
    }
}
