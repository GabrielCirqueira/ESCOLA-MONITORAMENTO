<?php

require_once "vendor/autoload.php";

use app\controllers\monitoramento\MainController;
use app\controllers\monitoramento\ProfessorController;

$rotas = [
    "home" =>  MainController::class,
    "login_aluno"  => MainController::class,
    "login_professor" => MainController::class,
    "login_gestor" =>  MainController::class,
    "login_adm" =>  MainController::class,
    "home_professor" => ProfessorController::class
];

$action = isset($_GET["action"]) ? $_GET["action"] : "";

if($action == "home"){
    $action = "index";
}

if (array_key_exists($action, $rotas)) {

    $controller = $rotas[$action];
    $method = $action;
    $controller::$method();

}else{
    MainController::index();
}

