<?php

ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "vendor/autoload.php";

date_default_timezone_set('America/Sao_Paulo');


use app\config\Backup;
use app\controllers\monitoramento\ADMcontroller;
use app\controllers\monitoramento\AlunoController;
use app\controllers\monitoramento\GestorController;
use app\controllers\monitoramento\MainController;
use app\controllers\monitoramento\ProfessorController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

Backup::runBackup();

session_start();

if (!isset($_SESSION["PopUp_prova_editada"])) {

    $_SESSION["PopUp_professor"] = false;
    $_SESSION["popup_not_gestor"] = false;
    $_SESSION["PopUp_add_professor_true"] = false;
    $_SESSION["PopUp_add_materia_true"] = false;
    $_SESSION["PopUp_excluir_materia_true"] = false;
    $_SESSION["PopUp_inserir_turma"] = false;
    $_SESSION["PopUp_inserir_gabarito_professor"] = false;
    $_SESSION["PopUp_RA_NaoENC"] = false;
    $_SESSION["popup_not_turmas"] = false;
    $_SESSION["PopUp_inserir_prova"] = false;
    $_SESSION["PAG_VOLTAR"] = false;
    $_SESSION["PopUp_Excluir_prova"] = false;
    $_SESSION["PopUp_PRF_Senha"] = false;
    $_SESSION["PopUp_Prova_Feita"] = false;
    $_SESSION["Popup_aguardar_gabarito"] = false;
    $_SESSION["PopUp_editar_aluno_true"] = false;
    $_SESSION["PopUp_PRF_NaoENC"] = false;
    $_SESSION["PopUp_not_Materia"] = false;
    $_SESSION["PopUp_excluir_professor"] = false;
    $_SESSION["PopUp_editar_professor"] = false;
    $_SESSION["PopUp_add_aluno"] = false;
    $_SESSION["PopUp_Excluir_turma"] = false;
    $_SESSION["PopUp_Excluir_aluno"] = false;
    $_SESSION["PopUp_ditar_prova"] = false;
    $_SESSION["PopUp_excluir_prova"] = false;
    $_SESSION["PopUp_prova_editada"] = false;
    $_SESSION["PopUp_not_valor"] = false;
    $_SESSION["PopUp_not_QntP"] = false;

    $_SESSION["Gabarito_aluno"] = false;

    $_SESSION["GESTOR"] = false;
    $_SESSION["ALUNO"] = false;
    $_SESSION["ADM"] = false;
    $_SESSION["PROFESSOR"] = false;

}

$rotas = [
    "login_adm_verifica"            => ADMcontroller::class,
    "adm_home"                      => ADMcontroller::class,
    "adicionar_aluno"               => ADMcontroller::class,
    "editar_dados_aluno"            => ADMcontroller::class,
    "adm_info"                      => ADMcontroller::class,
    "home"                          => MainController::class,
    "ADM"                           => MainController::class,
    "login_professor"               => MainController::class,
    "login_gestor"                  => MainController::class,
    "index"                         => MainController::class,
    "login_adm"                     => MainController::class,
    "encerrar_sessao"               => MainController::class,
    "aluno_home"                    => AlunoController::class,
    "login_aluno_entrar"            => AlunoController::class,
    "cadastrar_gabarito_aluno"      => AlunoController::class,
    "cadastrar_gabarito_aluno_rec"  => AlunoController::class,
    "gabarito_aluno"                => AlunoController::class,
    "gabarito_aluno_rec"            => AlunoController::class,
    "gestor_home"                   => GestorController::class,
    "gestor_descritores"            => GestorController::class,
    "gestor_provas"                 => GestorController::class,
    "gestor_prova"                  => GestorController::class,
    "login_gestor_verifica"         => GestorController::class,
    "home_professor"                => ProfessorController::class,
    "professor_home"                => ProfessorController::class,
    "inserir_gabarito"              => ProfessorController::class,
    "ver_provas"                    => ProfessorController::class,
    "prova"                         => ProfessorController::class,
    "criar_gabarito"                => ProfessorController::class,
    "atualizar_gabarito"            => ProfessorController::class,
    "editar_prova"                  => ProfessorController::class,
    "relatorio_professor"           => ProfessorController::class,
    "relatorio_prova"               => ProfessorController::class,
    "add_recuperacao"               => ProfessorController::class,
    "criar_gabarito_respostas"      => ProfessorController::class,
    "inserir_gabarito_rec"          => ProfessorController::class,
    "criar_gabarito_rec"            => ProfessorController::class,
    "criar_gabarito_rec_resp"       => ProfessorController::class,
    "prova_recuperacao"             => ProfessorController::class,
    "editar_gabarito_recuperacao"   => ProfessorController::class,
    "atualizar_gabarito_rec"        => ProfessorController::class,
];

$action = isset($_GET["action"]) ? $_GET["action"] : "";

if ($action == "home") {
    $action = "index";
}

if (strpos($action, "/") !== false) {
    $action = "index";
    header("location: ../home");
}

if (empty($action) || strpos($action, '/') !== false) {
    $action = "index";
}

if (array_key_exists($action, $rotas)) {
    $controller = $rotas[$action];
    $method = $action;
    $controller::$method();
} else {
    MainController::index();
}

ob_end_flush();