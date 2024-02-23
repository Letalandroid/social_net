<?php

namespace Letalandroid\controllers;
use DateTime;

class Perfil {

    private int $uid;
    private string $username;
    private string $descripcion;
    private DateTime $fechaRegistro;

    public function __construct(int $user_id, string $username, string $descripcion, DateTime $fechaRegistro) {

        $this->uid = $user_id;
        $this->username = $username;
        $this->descripcion = $descripcion;
        $this->fechaRegistro = $fechaRegistro;

    }

}