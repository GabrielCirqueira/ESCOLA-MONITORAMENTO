<?php

namespace app\controllers\monitoramento;

use app\models\monitoramento\ProfessorModel;
use app\controllers\monitoramento\MainController;

class ProfessorController{

    public static function home_professor(){

        $info = ProfessorModel::verificarLogin($_POST["user-prof"]);
        if ($info != False){
            $_SESSION["PROFESSOR"] = True;
            $_SESSION["nome"]           = $info["nome"];
            $_SESSION["nome_usuario"]   = $info["usuario"];
            $_SESSION["cpf"]            = $info["cpf"];
            $_SESSION["numero"]         = $info["numero"];
            $_SESSION["disciplinas"]    = $info["disciplinas"];
            header("location: professor_home");
        } else {
            $_SESSION["PopUp_professor"] = True;
            header("location: login_professor");
            exit;
        }
    }
    public static function professor_home(){
        if($_SESSION["PROFESSOR"]){

            MainController::Templates("public/views/professor/home.php", [
                'nome'          => $_SESSION["nome"],
                'nome_usuario'  => $_SESSION["nome_usuario"],
                'cpf'           => $_SESSION["cpf"],
                'numero'        => $_SESSION["numero"],
                'disciplinas'   => $_SESSION["disciplinas"]
            ]);

        }else{
            header("location: home");
        }
    }

    public static function inserir_gabarito(){
        
        if($_SESSION["PROFESSOR"]){
            $turmas = ProfessorModel::GetTurmas();
            MainController::Templates("public/views/professor/inserir_gabarito.php",$turmas);
        }
            else{
            header("location: home");
        }
    }

    public static function criar_gabarito(){
        $turmas = $_POST["gabarito-turmas"];
        $perguntas = $_POST["qtn-perguntas"];
        $valor = $_POST["valor-prova"];

        if($_SESSION["PROFESSOR"]){
            $turmas = $_POST["gabarito-turmas"];
            $perguntas = $_POST["qtn-perguntas"];
            $valor = $_POST["valor-prova"];

            $dados = [
                "turmas"    => $turmas,
                "perguntas" => $perguntas,
                "valor"     => $valor
            ];
            
            MainController::Templates("public/views/professor/criar_gabarito.php",$dados);
        }
            else{
            header("location: home");
        }

    }
}