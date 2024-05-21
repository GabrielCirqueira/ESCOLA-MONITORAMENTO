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
        $filtro_turmas = False;
    
        foreach($provas_professores as $professor){
            if($professor["id"] == $id_prova){
                $turmas = explode(",", $professor["turmas"]); 
                $nome_prova = $professor["nome_prova"];
                $descritores = explode(";",$professor["descritores"]);
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
    
        $total_pontos_geral = 0;
        $total_alunos_geral = 0;
        $total_acima_60 = 0;
        $total_alunos = 0;
    
        foreach($alunos_por_turma as $turma){
            $pontos = 0;
            $alunos = 0;
            $alunos_acima_60 = 0;
            foreach($turma as $aluno){
                $pontos += $aluno["pontos_aluno"];
                $alunos++;
                $turma_nome = $aluno["turma"];
                $pontos_prova = $aluno["pontos_prova"];
                $porcentagem_aluno =  ($aluno["acertos"] / $aluno["QNT_perguntas"]) * 100;
                if($aluno["descritores"] == null ){
                    $descriotores_sn = false;
                }else{
                    $descriotores_sn = true;
                }
                if ($porcentagem_aluno > 60) {
                    $alunos_acima_60++;
                    $total_acima_60++;
                }
            }
            
            $porcentagem_acima_60 = number_format(($alunos_acima_60 / $alunos) * 100, 1);
    
            $dados_turmas[$turma_nome] = [
                "total_pontos_turma" => $pontos,
                "alunos" => $alunos,
                "pontos_prova" => $pontos_prova,
                "porcentagem" => number_format((($pontos / $alunos ) / $pontos_prova) * 100, 0),
                "porcentagem_acima_60" => $porcentagem_acima_60,
                "turma_nome" => $turma_nome, 
                "grafico" => MainController::gerarGraficoRosca(number_format((($pontos / $alunos ) / $pontos_prova) * 100, 1))
            ];
    
            $total_pontos_geral += $pontos;
            $total_alunos_geral += $alunos;
            $total_alunos += $alunos;
        } 
    
        $media_geral_porcentagem = number_format((($total_pontos_geral / $total_alunos_geral) / $pontos_prova) * 100, 2); 
        $porcentagem_geral_acima_60 = number_format(($total_acima_60 / $total_alunos) * 100, 1);
        


        $acertos_por_descritor = [];
 
        foreach ($alunos_por_turma as $turma => $alunos) {
            $acertos_por_descritor[$turma] = [];
        
            foreach ($alunos as $aluno) {
                $descritores_certos = explode(';', $aluno['descritores_certos']);
        
                foreach ($descritores_certos as $descritor) {
                    if (!isset($acertos_por_descritor[$turma][$descritor])) {
                        $acertos_por_descritor[$turma][$descritor] = 1;
                    } else {
                        $acertos_por_descritor[$turma][$descritor]++;
                    }
                }
            }
        }
        
        $percentual_por_descritor = [];
        
        foreach ($acertos_por_descritor as $turma => $acertos) {
            $total_alunos = count($alunos_por_turma[$turma]);
        
            foreach ($acertos as $descritor => $quantidade_acertos) {
                $percentual = ($quantidade_acertos / $total_alunos) * 100;
                $percentual_por_descritor[$turma][$descritor] = $percentual;
            }
        }

        $percentual_descritores_turmas = [];

foreach ($percentual_por_descritor as $turma => $descritores) {
    $descritores_modificados = [];

    $percentuais_sem_questao = [];

    foreach ($descritores as $descritor => $percentual) {
        if (!empty($descritor)) {
            $nome_descritor = explode(',', $descritor)[1];

            if (!isset($percentuais_sem_questao[$nome_descritor])) {
                $percentuais_sem_questao[$nome_descritor] = [$percentual];
            } else {
                $percentuais_sem_questao[$nome_descritor][] = $percentual;
            }
        }
    }

    foreach ($percentuais_sem_questao as $nome_descritor => $percentuais) {
        $media_percentual = array_sum($percentuais) / count($percentuais);
        $descritores_modificados[$nome_descritor] = $media_percentual;
    }

    $percentual_descritores_turmas[$turma] = $descritores_modificados;
}
        
$media_descritores_geral = array();

foreach ($percentual_descritores_turmas as $turma) {
    foreach ($turma as $descritor => $percentual) {
        if (!isset($media_descritores_geral[$descritor])) {
            $media_descritores_geral[$descritor] = 0;
        }
        $media_descritores_geral[$descritor] += $percentual / count($percentual_descritores_turmas);
    }
}

        foreach($media_descritores_geral as $descritor => $percentual) {
            $media_descritores_geral[$descritor] = MainController::gerarGraficoRosca(number_format($percentual, 1));
        }
        
        $contador_alunos = 0;

        $medida_geral = [
            "Abaixo do Básico" => 0,
            "Básico" => 0,
            "Médio" => 0,
            "Avançado" => 0,
        ];
        
        $porcentagem_alunos_turma = [];
        $contador_turma = 0;
        
        foreach($alunos_por_turma as $turma){
            $medida_turma = [
                "Abaixo do Básico" => 0,
                "Básico" => 0,
                "Médio" => 0,
                "Avançado" => 0,
            ];
        
            $contador_alunos_turma = 0;
            foreach($turma as $aluno){
                $percentual = ($aluno["acertos"] / $aluno["QNT_perguntas"]) * 100;
                if($percentual <= 25){
                    $medida_turma["Abaixo do Básico"] += 1;
                }else if($percentual <= 50) {
                    $medida_turma["Básico"] += 1;
                }else if($percentual <= 75){
                    $medida_turma["Médio"] += 1;
                }else{
                    $medida_turma["Avançado"] += 1;
                }
                $contador_alunos_turma++;
                $nome = $aluno["turma"];
            }
        
            $porcentagem_turma = [];
            foreach ($medida_turma as $categoria => $quantidade) {
                $porcentagem_turma[$categoria] = number_format(($quantidade / $contador_alunos_turma) * 100, 0);
            }
        
            $porcentagem_alunos_turma[$nome] = $porcentagem_turma;
         
            foreach ($medida_turma as $categoria => $quantidade) {
                $medida_geral[$categoria] += $quantidade;
            }
        
            $contador_alunos += $contador_alunos_turma;
        }
         
        $porcentagem_alunos = [];
        foreach ($medida_geral as $categoria => $quantidade) {
            $porcentagem_alunos[$categoria] = number_format(($quantidade / $contador_alunos) * 100, 0);
        }
        $dados_turma = null;

        if(isset($_POST["turma-filtros"])){
            $turma = $_POST["turma-filtros"];
            if($turma != "geral"){
                $filtro_turmas = True;

                $grafico_descritores_turma = [];
                foreach($percentual_descritores_turmas[$turma] as $descritor => $percentual){
                    $grafico_descritores_turma[$descritor] = MainController::gerarGraficoRosca(number_format($percentual,1));
                }
    
                $dados_turma = [
                    "nome"=> $turma,
                    "grafico_coluna" => MainController::gerarGraficoColunas($porcentagem_alunos_turma[$turma]),
                    "descritores" => $grafico_descritores_turma,
                    "percentual_turma" => MainController::gerarGraficoRosca($dados_turmas[$turma]["porcentagem"]),
                    "percentual_turma_60" => MainController::gerarGraficoRosca($dados_turmas[$turma]["porcentagem_acima_60"]) 
                ];
            }else{
                $filtro_turmas = False;
            }
           
        }

        // echo "<br>";
        // echo "<pre>";
        // print_r($dados_turma);
        // echo "</pre>";

        $dados = [
            "dados_turma" => $dados_turmas,
            "nome_prova" => $nome_prova,
            "media_geral_porcentagem" => MainController::gerarGraficoRosca($media_geral_porcentagem),
            "porcentagem_geral_acima_60" => MainController::gerarGraficoRosca($porcentagem_geral_acima_60),
            "descritores" => $descriotores_sn,
            "percentual_descritores" => $media_descritores_geral,
            "grafico_colunas" => MainController::gerarGraficoColunas($porcentagem_alunos),
            "dados_turma_grafico" => $dados_turma,
            "filtro" => $filtro_turmas
        ];
    
        MainController::Templates("public/views/professor/relatorio_prova.php", "PROFESSOR", $dados);
    }
    

    public static function calcularPorcentagem($total, $parte){
        if ($total == 0) {
            return 0;
        }
        return ($parte / $total) * 100;
    }

}