<?php

require_once "vendor/autoload.php";

use app\controllers\monitoramento\MainController;
use app\controllers\monitoramento\ProfessorController;
use app\controllers\monitoramento\GestorController;
use app\controllers\monitoramento\AlunoController;

session_start();

if(!isset($_SESSION["PopUp_RA_NaoENC"])){

    $_SESSION["PopUp_professor"] = False;
    $_SESSION["popup_not_gestor"] = False;
    $_SESSION["PopUp_add_professor_true"] = False;
    $_SESSION["PopUp_add_materia_true"] = False;
    $_SESSION["PopUp_excluir_materia_true"] = False;
    $_SESSION["PopUp_inserir_turma"] = False;
    $_SESSION["PopUp_inserir_gabarito_professor"] = False;
    $_SESSION["PopUp_RA_NaoENC"] = False;
    
    $_SESSION["GESTOR"] = False;
    $_SESSION["ALUNO"] = False;
    $_SESSION["PROFESSOR"] = False;
}
    
$rotas = [
    "home"                      => MainController::class,
    "ADM"                       => MainController::class,
    "login_professor"           => MainController::class,
    "login_gestor"              => MainController::class,
    "login_adm"                 => MainController::class,
    "aluno_home"                => AlunoController::class,
    "login_aluno_entrar"        => AlunoController::class,
    "login_gestor_verifica"     => GestorController::class,
    "gestor_home"               => GestorController::class,
    "adicionar_professor"       => GestorController::class,
    "Gestor_info"               => GestorController::class,
    "adicionar_materia"         => GestorController::class,
    "excluir_disciplina"        => GestorController::class,
    "adicionar_turma"           => GestorController::class,
    "home_professor"            => ProfessorController::class,
    "professor_home"            => ProfessorController::class,
    "inserir_gabarito"          => ProfessorController::class,
    "criar_gabarito"            => ProfessorController::class,
    "criar_gabarito_respostas"  => ProfessorController::class
];

$action = isset($_GET["action"]) ? $_GET["action"] : "";

if($action == "home"){
    $action = "index";
}

if(array_key_exists($action, $rotas)) {

    $controller = $rotas[$action];
    $method = $action;
    $controller::$method();
} else{
    MainController::index();
}

if($_SESSION["PopUp_professor"] == True){
    echo "<script> Mostrar_PopUp('PopUp_PRF_NaoENC')</script>";
    $_SESSION["PopUp_professor"] = False;
}

if($_SESSION["PopUp_RA_NaoENC"] == True){
    echo "<script> Mostrar_PopUp('PopUp_RA_NaoENC')</script>";
    $_SESSION["PopUp_RA_NaoENC"] = False;
}

if($_SESSION["popup_not_gestor"] == True){
    echo "<script> Mostrar_PopUp('PopUp_PRF_NaoENC')</script>";
    $_SESSION["popup_not_gestor"] = False;
}

if($_SESSION["PopUp_add_professor_true"] == True){
    echo "<script> Mostrar_PopUp('PopUp_add_professor_true')</script>";
    $_SESSION["PopUp_add_professor_true"] = False;
}

if($_SESSION["PopUp_add_materia_true"] == True){
    echo "<script> Mostrar_PopUp('PopUp_add_materia_true')</script>";
    $_SESSION["PopUp_add_materia_true"] = False;
}
 
if($_SESSION["PopUp_excluir_materia_true"] == True){
    echo "<script> Mostrar_PopUp('PopUp_excluir_materia_true')</script>";
    $_SESSION["PopUp_excluir_materia_true"] = False;
}
 
if($_SESSION["PopUp_inserir_turma"] == True){
    echo "<script> Mostrar_PopUp('PopUp_inserir_turma')</script>";
    $_SESSION["PopUp_inserir_turma"] = False;
}

if($_SESSION["PopUp_inserir_gabarito_professor"] == True){
    echo "<script> Mostrar_PopUp('PopUp_inserir_gabarito_professor')</script>";
    $_SESSION["PopUp_inserir_gabarito_professor"] = False;
}

if($_SESSION["PopUp_RA_NaoENC"] == True){
    echo "<script> Mostrar_PopUp('PopUp_RA_NaoENC')</script>";
    $_SESSION["PopUp_RA_NaoENC"] = False;
}