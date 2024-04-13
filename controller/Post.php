<?php

namespace Letalandroid\controllers;

require_once '/home/letalandroid/Letalandroid/programming/php/social_net/model/Database.php';
use Letalandroid\model\Database;
use PDO;

class Post extends Database {
    private string $id;

    public function __construct(private string $username, private string $descripcion, private string $fechaRegistro) {

        parent::__construct();

        $this->id = uniqid();
        $this->username = $username;
        $this->descripcion = $descripcion;
        $this->fechaRegistro = $fechaRegistro;

    }

    public static function add(int $user_id, string $descripcion)
    {
        try {
            $db = new Database();
            $date = date('Y-m-d H:i:s');
            $query = $db->connect()->prepare('insert into posts (user_id,descripcion,fechaRegistro) values (?,?,?)');
            $query->bindValue(1, $user_id, PDO::PARAM_INT);
            $query->bindValue(2, $descripcion, PDO::PARAM_STR);
            $query->bindValue(3, $date, PDO::PARAM_STR);
            $query->execute();
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public static function getAll() {
        $posts = [];
        $db = new Database();
        $query = $db->connect()->prepare('select * from all_post order by 1 desc;');
        $query->execute();

        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            $post = Post::createdFromArray($r);
            array_push($posts, $post);
        }

        return $posts;
    }

    public static function createdFromArray($arr): Post {
        $post = new Post($arr['username'], $arr['descripcion'], $arr['fechaRegistro']);
        $post->setID($arr['id_post']);

        return $post;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getFecha()
    {
        return $this->fechaRegistro;
    }

    public function setID($v) {
        $this->id = $v;
    }
}