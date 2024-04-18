<?php

// use app\controllers\monitoramento\MainController;

// $rotas = [
//     "" => "MainController",
//     "home" => "MainController::index()",
//     "login_aluno" => "MainController::index()",
// ];

// foreach($rotas as $rota => $controlador){
//     if(isset($_GET["action"]) && $_GET["action"] == $rota){

//         $partes = explode("::", $controlador);
//         $classe = $partes[0];
//         $metodo = $partes[1];

//         $classe::$metodo();
//     }else if(!isset($_GET["action"])){
//         $teste = new MainController;
//         $teste->index();
//     }
// }


include "public/views/head.php";
include "public/views/header.php";
include "public/views/main.php";
include "public/views/PopUps.php";
include "public/views/footer.php";