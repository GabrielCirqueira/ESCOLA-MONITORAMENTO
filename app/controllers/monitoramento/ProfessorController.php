<?php

namespace app\controllers\monitoramento;

use app\models\monitoramento\ProfessorModel;
use app\controllers\monitoramento\MainController;
use DateTime;

class ProfessorController{

    public static function home_professor(){

        $info = ProfessorModel::verificarLogin($_POST["user-prof"]);
        if ($info != False){
            $_SESSION["PROFESSOR"] = True;
            $_SESSION["nome_professor"] = $info["nome"];
            $_SESSION["nome_usuario"]   = $info["usuario"];
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
                'nome'          => $_SESSION["nome_professor"],
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
        $nome = $_POST["nome-prova"];
        $materia = $_POST["Materias-professor-gabarito"];

        if($_SESSION["PROFESSOR"]){
            $turmas = $_POST["gabarito-turmas"];
            $perguntas = $_POST["qtn-perguntas"];
            $valor = $_POST["valor-prova"];

            $dados = [
                "turmas"        => $turmas,
                "perguntas"     => $perguntas,
                "valor"         => $valor,
                "nome_prova"    => $nome,
                "materia"       => $materia
            ];
            
            MainController::Templates("public/views/professor/criar_gabarito.php",$dados);
        }
            else{
            header("location: home");
        }
    }

    public static function criar_gabarito_respostas(){
        if($_SESSION["PROFESSOR"]){
            $gabarito_prova = [];
            $descritores_prova = [];
            $dataAtual = new DateTime();
            $dataFormatada = $dataAtual->format('d-m-Y');
    
            $contador = 1;
            
            while($contador <= $_POST["numero_perguntas"]){ 
                    $descritores_prova[$contador] = $contador .",". $_POST["DESCRITOR_".$contador];
                    $gabarito_prova[$contador] = $_POST[$contador];
    
                    $contador++;
            }
            
            $descritores = implode(";",$descritores_prova);
            $gabarito = implode(";",$gabarito_prova); 
    
            $dados = [
                "turmas"        => $_POST["turmas_gabarito"],
                "perguntas"     => $_POST["numero_perguntas"],
                "valor"         => $_POST["valor_prova"],
                "data"          => $dataFormatada,
                "nome_prova"    => $_POST["nome_prova"],
                "descritores"   =>  $descritores,
                "gabarito"      =>  $gabarito,
                "nome_prof"     =>  $_SESSION["nome_professor"],
                "materia"       =>  $_POST["materia_prova"]
            ];
            if(ProfessorModel::inserir_gabarito($dados)){
                $_SESSION["PopUp_inserir_gabarito_professor"] = True;
                header("location: inserir_gabarito");
                exit;
            }
        }
        else{
            header("location: home");
        }
    }
}