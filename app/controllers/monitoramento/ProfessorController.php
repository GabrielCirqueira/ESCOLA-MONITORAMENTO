<?php

namespace app\controllers\monitoramento;

use app\models\monitoramento\ProfessorModel;
use app\models\monitoramento\AlunoModel;
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

            MainController::Templates("public/views/professor/home.php","PROFESSOR", [
                'nome'          => $_SESSION["nome_professor"],
                'nome_usuario'  => $_SESSION["nome_usuario"], 
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
            MainController::Templates("public/views/professor/inserir_gabarito.php","PROFESSOR",$turmas);
        }
            else{
            header("location: home");
        }
    }

    public static function criar_gabarito(){

        if($_POST["gabarito-turmas"] == null){
            $_SESSION["popup_not_turmas"] = True;
            header("location: inserir_gabarito");
            exit;
        }
        
        $turmas = $_POST["gabarito-turmas"];
        $perguntas = $_POST["qtn-perguntas"];
        $valor = $_POST["valor-prova"];
        $nome = $_POST["nome-prova"];
        $materia = $_POST["Materias-professor-gabarito"];
        $descritores = $_POST["descritores"]; 

        if($_SESSION["PROFESSOR"]){
            $turmas = $_POST["gabarito-turmas"];
            $perguntas = $_POST["qtn-perguntas"];
            $valor = $_POST["valor-prova"];

            $dados = [
                "turmas"        => $turmas,
                "perguntas"     => $perguntas,
                "valor"         => $valor,
                "nome_prova"    => $nome,
                "materia"       => $materia,
                "descritores"   => $descritores
            ];
            
            MainController::Templates("public/views/professor/criar_gabarito.php","PROFESSOR",$dados);
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
            $dataFormatada = $dataAtual->format('Y-m-d');
    
            $contador = 1;
            
            while($contador <= $_POST["numero_perguntas"]){ 
                    $descritores_prova[$contador] = $contador .",". $_POST["DESCRITOR_".$contador];
                    $gabarito_prova[$contador] = $_POST[$contador];
    
                    $contador++;
            }
            
            $descritores = implode(";",$descritores_prova);

            if($_POST["descritor"] == "não"){
                $descritores = NULL;
            }

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

    public static function ver_provas(){

        if($_SESSION["PROFESSOR"]){
            $provas_professores = AlunoModel::GetProvas();
            $provas_alunos = AlunoModel::GetProvasFinalizadas();
            $provas = []; 
            foreach($provas_professores as $professor){
                if($professor["nome_professor"] == $_SESSION["nome_professor"]){
                    $provas[] = $professor; 
                }
            }
            $dados = [ 
                "provas"        => $provas,
                "provas_alunos" => $provas_alunos
            ];
            MainController::Templates("public/views/professor/provas.php","PROFESSOR",$dados);

        }
    }
    public static function prova() {
        if ($_SESSION["PROFESSOR"]) {
            $provas_professores = AlunoModel::GetProvas();
            $provas_alunos = AlunoModel::GetProvasFinalizadas();
            $id_prova = $_POST["id-prova"];
            $provas = [];
            $provas_turma = [];
            $liberado = false;
    
            foreach ($provas_professores as $prova) {
                if ($prova["id"] == $id_prova) {
                    $turmas = $prova["turmas"];
                    $nome_prova = $prova["nome_prova"];
                    $liberado = $prova["liberado"] == "SIM" ? true : false;
                }
            }
    
            foreach ($provas_alunos as $prova) {
                if ($prova["id_prova"] == $id_prova) {
                    $provas[] = $prova;
                }
            }
    
            $turma = explode(",", $turmas);
            $turma = $turma[0];
    
            if (isset($_POST["status"])) {
                if($_POST["status"] == "sim") {
                    ProfessorModel::alterar_liberado($id_prova,"SIM"); 
                }else{
                    ProfessorModel::alterar_liberado($id_prova,null);  
                }
            }
            if (isset($_POST["turma"])) {
                $turma = $_POST["turma"];

            }

            foreach ($provas as $prova) {
                if ($prova["turma"] == $turma) {
                    $provas_turma[] = $prova;
                }
            }
    
            $dados = [
                "provas" => $provas,
                "turmas" => explode(",", $turmas),
                "turma" => $turma,
                "provas_turma" => $provas_turma,
                "liberado" => $liberado,
                "nome_prova" => $nome_prova
            ];
    
            MainController::Templates("public/views/professor/prova.php", "PROFESSOR", $dados);
        }
    }
    
    public static function relatorio_professor(){
        $provas_professores = AlunoModel::GetProvas();
        $provas_alunos = AlunoModel::GetProvasFinalizadas();
        $provas = []; 
        foreach($provas_professores as $professor){
            if($professor["nome_professor"] == $_SESSION["nome_professor"]){
                $provas[] = $professor; 
            }
        }
        $dados = [ 
            "provas"        => $provas,
            "provas_alunos" => $provas_alunos
        ];
        
        MainController::Templates("public/views/professor/provas_relatorios.php", "PROFESSOR", $dados);
    }

    public static function relatorio_prova(){
        $id_prova = $_POST["id-prova"];
        $provas = AlunoModel::GetProvasFinalizadas();
        $provas_professores = AlunoModel::GetProvas();
        $dados_turmas = [] ;

        foreach($provas_professores as $professor){
            if($professor["id"] == $id_prova){
                $turmas = explode(",", $professor["turmas"]); 
                $nome_prova = $professor["nome_prova"];	
            }
        }

        $alunos_por_turma = array();

        foreach ($provas as $prova) {
            if ($prova["id_prova"] == $id_prova) {
                $turma_prova = $prova["turma"];
                if (!isset($alunos_por_turma[$turma_prova])) {
                    $alunos_por_turma[$turma_prova] = array();
                }
                $alunos_por_turma[$turma_prova][] = $prova;
            }
        }

        foreach($alunos_por_turma as $turma){
            $pontos = 0;
            $alunos = 0;
            foreach($turma as $aluno){
                $pontos += $aluno["pontos_aluno"];
                $alunos++;
                $turma_nome = $aluno["turma"];
                $pontos_prova = $aluno["pontos_prova"];
            }
            $porcentagem = number_format((($pontos / $alunos ) / $pontos_prova) * 100,0);

            $dados_turmas[$turma_nome] = [
                "total_pontos_turma" => $pontos,
                "alunos" => $alunos,
                "pontos_prova" => $pontos_prova,
                "porcentagem" => $porcentagem,
                "turma_nome"    => $turma_nome, 
                "grafico"     => MainController::gerarGraficoRosca($porcentagem)
            ];
        } 

        $dados = [
            "dados_turma" => $dados_turmas,
            "nome_prova"  => $nome_prova
        ] ;

        MainController::Templates("public/views/professor/relatorio_prova.php", "PROFESSOR", $dados);


    }
    
}