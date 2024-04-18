<?php

use app\controllers\monitoramento\MainControllera;

$rotas = [
    "/" => "MainController::index()",
    "/home" => "MainController::index()"
];

foreach($rotas as $rota => $controlador){
    if(isset($_GET["action"]) && $_GET["action"] == $rota){

        $partes = explode("::", $controlador);
        $classe = $partes[0];
        $metodo = $partes[1];

        $classe::$metodo();
    }else if(!isset($_GET["action"])){
        MainControllera::index();
    }
}