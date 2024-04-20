<?php

session_start();

if(!isset($_SESSION["PopUp_professor"])){

    $_SESSION["PopUp_professor"] = False;
    $_SESSION["popup_not_gestor"] = False;
    $_SESSION["PopUp_add_professor_true"] = False;

    $_SESSION["GESTOR"] = False;
    $_SESSION["PROFESSOR"] = False;

}



require_once "vendor/autoload.php";

use app\controllers\monitoramento\MainController;
use app\controllers\monitoramento\ProfessorController;
use app\controllers\monitoramento\GestorController;

$rotas = [
    "home" =>  MainController::class,
    "login_aluno"  => MainController::class,
    "login_professor" => MainController::class,
    "login_gestor" =>  MainController::class,
    "login_adm" =>  MainController::class,
    "home_professor" => ProfessorController::class,
    "login_gestor_verifica" => GestorController::class,
    "gestor_home" => GestorController::class,
    "professor_home" => ProfessorController::class,
    "adicionar_professor" => GestorController::class
];

$action = isset($_GET["action"]) ? $_GET["action"] : "";

if($action == "home"){
    $action = "index";
}

if(array_key_exists($action, $rotas)) {

    $controller = $rotas[$action];
    $method = $action;
    $controller::$method();

// } else if(strpos($action,"/") && strpos($action,"gestor_home")){

//     $string = explode("/",$action);
//     $pag = $string[0];
//     $info = $string[1];
//     $controller = $rotas[$pag];
//}

}
else{
    MainController::index();
}

if($_SESSION["PopUp_professor"] == True){
    echo "<script> Mostrar_PopUp('PopUp_PRF_NaoENC')</script>";
    $_SESSION["PopUp_professor"] = False;
}

if($_SESSION["popup_not_gestor"] == True){
    echo "<script> Mostrar_PopUp('PopUp_PRF_NaoENC')</script>";
    $_SESSION["popup_not_gestor"] = False;
}

if($_SESSION["PopUp_add_professor_true"] == True){
    echo "<script> Mostrar_PopUp('PopUp_add_professor_true')</script>";
    $_SESSION["PopUp_add_professor_true"] = False;
}
