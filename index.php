<?php

require_once "vendor/autoload.php";

date_default_timezone_set('America/Sao_Paulo'); 

use app\controllers\monitoramento\MainController;
use app\controllers\monitoramento\ProfessorController;
use app\controllers\monitoramento\GestorController;
use app\controllers\monitoramento\AlunoController;
use app\controllers\monitoramento\ADMcontroller;

use app\config\Backup;

use Dotenv\Dotenv; 

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

Backup::runBackup();

session_start();

if(!isset($_SESSION["PopUp_PRF_Senha"])){

    $_SESSION["PopUp_professor"] = False;
    $_SESSION["popup_not_gestor"] = False;
    $_SESSION["PopUp_add_professor_true"] = False;
    $_SESSION["PopUp_add_materia_true"] = False;
    $_SESSION["PopUp_excluir_materia_true"] = False;
    $_SESSION["PopUp_inserir_turma"] = False;
    $_SESSION["PopUp_inserir_gabarito_professor"] = False;
    $_SESSION["PopUp_RA_NaoENC"] = False;
    $_SESSION["popup_not_turmas"] = False;
    $_SESSION["PopUp_inserir_prova"] = False;
    $_SESSION["PAG_VOLTAR"] = False;
    $_SESSION["PopUp_Excluir_prova"] = False;
    $_SESSION["PopUp_PRF_Senha"] = False;
    
    $_SESSION["GESTOR"] = False;
    $_SESSION["ALUNO"] = False;
    $_SESSION["ADM"] = False;
    $_SESSION["PROFESSOR"] = False;
}
    
$rotas = [ 
    "login_adm_verifica"            => ADMcontroller::class,
    "adm_home"                      => ADMcontroller::class,
    "backups"                       => ADMcontroller::class,
    "adicionar_professor"           => ADMcontroller::class,
    "adm_info"                      => ADMcontroller::class,
    "adicionar_materia"             => ADMcontroller::class,
    "excluir_disciplina"            => ADMcontroller::class,
    "adicionar_turma"               => ADMcontroller::class,
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
    "prova_recuperacao"             => ProfessorController::class
];

$action = isset($_GET["action"]) ? $_GET["action"] : "";

if($action == "home"){
    $action = "index";
}

if(strpos($action,"/") !== False){
    $action = "index";
    header("location: ../home");
}

// Verifica se a ação está vazia ou contém uma barra
if (empty($action) || strpos($action, '/') !== false) {
    $action = "index";
}

if(array_key_exists($action, $rotas)) {
    $controller = $rotas[$action];
    $method = $action;
    $controller::$method();
} else {
    MainController::index();
}

$popups = array(
    "PopUp_professor",
    "PopUp_RA_NaoENC",
    "popup_not_turmas",
    "popup_not_gestor",
    "PopUp_add_professor_true",
    "PopUp_add_materia_true",
    "PopUp_excluir_materia_true",
    "PopUp_inserir_turma",
    "PopUp_inserir_gabarito_professor",
    "PopUp_inserir_prova"
);

if($_SESSION["PopUp_professor"] == True){
    echo "<script> Mostrar_PopUp('PopUp_PRF_NaoENC')</script>";
    $_SESSION["PopUp_professor"] = False;
}

if($_SESSION["PopUp_PRF_Senha"] == True){
    echo "<script> Mostrar_PopUp('PopUp_PRF_Senha')</script>";
    $_SESSION["PopUp_PRF_Senha"] = False;
}

if($_SESSION["PopUp_RA_NaoENC"] == True){
    echo "<script> Mostrar_PopUp('PopUp_RA_NaoENC')</script>";
    $_SESSION["PopUp_RA_NaoENC"] = False;
}

if($_SESSION["popup_not_turmas"] == True){
    echo "<script> Mostrar_PopUp('popup_not_turmas')</script>";
    $_SESSION["popup_not_turmas"] = False;
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

if($_SESSION["PopUp_inserir_prova"] == True){
    echo "<script> Mostrar_PopUp('PopUp_inserir_prova')</script>";
    $_SESSION["PopUp_inserir_prova"] = False;
}

if($_SESSION["PopUp_Excluir_prova"] == True){
    echo "<script> Mostrar_PopUp('PopUp_Excluir_prova')</script>";
    $_SESSION["PopUp_Excluir_prova"] = False;
}