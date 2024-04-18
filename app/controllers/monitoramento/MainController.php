<?php 

namespace app\controllers\monitoramento;

class MainController{

    public static function Templates($template){
        include "public/views/head.php";
        include "public/views/header.php";
        include $template;
        include "public/views/PopUps.php";
        include "public/views/footer.php";
    }

    public static function index(){
        self::Templates("public/views/main.php");
    }

    public static function login_aluno(){
        self::Templates("public/views//aluno/login.php");
    }

    public static function login_professor(){
        self::Templates("public/views/professor/login.php");
    }

    public static function login_gestor(){
        self::Templates("public/views/gestor/login.php");
    }

    public static function login_adm(){
        self::Templates("public/views/adm/login.php");
    }
}
