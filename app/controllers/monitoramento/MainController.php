<?php 

namespace app\controllers\monitoramento;

class MainController{
    public static function index(){
        include "public/views/head.php";
        include "public/views/header.php";
        include "public/views/main.php";
        include "public/views/PopUps.php";
        include "public/views/footer.php";
    }

    public static function login_aluno(){
        include "public/views/head.php";
        include "public/views/header.php";
        include "public/views//aluno/login.php";
        include "public/views/PopUps.php";
        include "public/views/footer.php";
    }
}
