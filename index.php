<?php

require_once "vendor/autoload.php";

use app\controllers\monitoramento\MainController;
use app\controllers\monitoramento\ProfessorController;
use app\controllers\monitoramento\GestorController;
use app\controllers\monitoramento\AlunoController;

session_start();

$options = [
    "PopUp_professor" => "PopUp_PRF_NaoENC",
    "PopUp_RA_NaoENC" => "PopUp_RA_NaoENC",
    "popup_not_gestor" => "PopUp_PRF_NaoENC",
    "PopUp_add_professor_true" => "PopUp_add_professor_true",
    "PopUp_add_materia_true" => "PopUp_add_materia_true",
    "PopUp_excluir_materia_true" => "PopUp_excluir_materia_true",
    "PopUp_inserir_turma" => "PopUp_inserir_turma",
    "PopUp_inserir_gabarito_professor" => "PopUp_inserir_gabarito_professor",
];

if (!isset($_SESSION["PopUp_RA_NaoENC"])) {
    foreach ($options as $key => $value) {
        $_SESSION[$key] = false;
    }

    $_SESSION["GESTOR"] = false;
    $_SESSION["ALUNO"] = false;
    $_SESSION["PROFESSOR"] = false;
}

$rotas = [
    "aluno_home"                => AlunoController::class,
    "login_aluno_entrar"        => AlunoController::class,
    "home"                      => MainController::class,
    "ADM"                       => MainController::class,
    "login_professor"           => MainController::class,
    "login_gestor"              => MainController::class,
    "login_adm"                 => MainController::class,
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
if ($action == "home") $action = "index";

if (array_key_exists($action, $rotas)) {
    $controller = $rotas[$action];
    $method = $action;
    $controller::$method();
} else {
    MainController::index();
}

foreach ($options as $key => $value) {
    if ($_SESSION[$key]) {
        echo "<script> Mostrar_PopUp('$value')</script>";
        $_SESSION[$key] = false;
    }
}
