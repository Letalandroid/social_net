<?php

namespace Letalandroid\controllers;

require_once '/home/letalandroid/Letalandroid/programming/php/social_net/model/Database.php';

use Letalandroid\model\Database;
use PDO;

class Reactions extends Database
{
    private string $id;

    public function __construct(private int $id_post, private int $user_id, private bool $value)
    {

        parent::__construct();

        $this->id = uniqid();
        $this->id_post = $id_post;
        $this->user_id = $user_id;
        $this->value = $value;
    }

    public static function update(int $id_post, int $user_id)
    {
        try {
            $db = new Database();
            // Verificar si ya existe una reacción del usuario al post
            $query_check = $db->connect()->prepare('SELECT * FROM reacciones WHERE id_post = ? AND user_id = ?');
            $query_check->bindValue(1, $id_post, PDO::PARAM_INT);
            $query_check->bindValue(2, $user_id, PDO::PARAM_INT);
            $query_check->execute();
            $existing_reaction = $query_check->fetch(PDO::FETCH_ASSOC);

            if ($existing_reaction) {
                $value = !$existing_reaction['value'];
                $query_update = $db->connect()->prepare('UPDATE reacciones SET value = ?
                                                WHERE id_post = ? AND user_id = ?');
                $query_update->bindValue(1, $value, PDO::PARAM_INT);
                $query_update->bindValue(2, $id_post, PDO::PARAM_INT);
                $query_update->bindValue(3, $user_id, PDO::PARAM_INT);
                $query_update->execute();
            } else {
                $value = true;
                $query_insert = $db->connect()->prepare('INSERT INTO reacciones (id_post, user_id, value)
                                                VALUES (?, ?, ?)');
                $query_insert->bindValue(1, $id_post, PDO::PARAM_INT);
                $query_insert->bindValue(2, $user_id, PDO::PARAM_INT);
                $query_insert->bindValue(3, $value, PDO::PARAM_INT);
                $query_insert->execute();
            }
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public static function getAll(int $post_id)
    {
        $reactions = [];
        $db = new Database();
        $query = $db->connect()->prepare('select * from reacciones where id_post=? and value=true;');
        $query->bindValue(1, $post_id, PDO::PARAM_INT);
        $query->execute();

        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            $reaction = Reactions::createdFromArray($r);
            array_push($reactions, $reaction);
        }

        return count($reactions);
    }

    public static function getAllUsers(int $post_id, int $user_id)
    {
        $reactions = [];
        $db = new Database();
        $query = $db->connect()->prepare('select * from reacciones
                    where id_post=? and value=true and user_id=?;');
        $query->bindValue(1, $post_id, PDO::PARAM_INT);
        $query->bindValue(2, $user_id, PDO::PARAM_INT);
        $query->execute();

        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            $reaction = Reactions::createdFromArray($r);
            array_push($reactions, $reaction);
        }

        return $reactions;
    }

    public static function createdFromArray($arr): Reactions
    {
        $reaction = new Reactions($arr['id_post'], $arr['user_id'], $arr['value']);
        $reaction->setID($arr['id_post']);

        return $reaction;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdPost()
    {
        return $this->id_post;
    }
    public function getUserId()
    {
        return $this->user_id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setID($v)
    {
        $this->id = $v;
    }
}
