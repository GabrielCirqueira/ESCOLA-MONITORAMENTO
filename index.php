<?php

require_once "vendor/autoload.php";

use app\controllers\monitoramento\MainController;

$rotas = [
    "" => [
        "controller" => MainController::class,
        "method" => "index"
    ],
    "home" => [
        "controller" => MainController::class,
        "method" => "index"
    ],
    "login_aluno" => [
        "controller" => MainController::class,
        "method" => "login_aluno"
    ],
    "login_professor" => [
        "controller" => MainController::class,
        "method" => "login_professor"
    ],
    "login_gestor" => [
        "controller" => MainController::class,
        "method" => "login_gestor"
    ],
    "login_adm" => [
        "controller" => MainController::class,
        "method" => "login_adm"
    ]
];

$action = isset($_GET["action"]) ? $_GET["action"] : "";
if (array_key_exists($action, $rotas)) {
    $controller = $rotas[$action]["controller"];
    $method = $rotas[$action]["method"];
    $controller::$method();
} 