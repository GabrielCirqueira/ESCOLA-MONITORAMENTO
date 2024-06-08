<?php

namespace app\controllers\monitoramento;

use app\models\monitoramento\AlunoModel;

use app\controllers\monitoramento\MainController;
use DateTime;

class AlunoController
{

    public static function login_aluno_entrar(){
        $ra = $_POST["ra"];

        $query = AlunoModel::verificarLogin($ra);

        if (!$query === False) {
            $_SESSION["ra"] = $ra;
            $_SESSION["nome_aluno"] = $query["nome"];
            $_SESSION["turno"] = $query["turno"];
            $_SESSION["turma"] = $query["turma"];
            $_SESSION["data_nasc"] = $query["data_nasc"];
            $_SESSION["ALUNO"] = True;
            header("location: aluno_home");
        } else {
            $_SESSION["PopUp_RA_NaoENC"] = True;
            header("location: home");
            exit;
        }
    }

    public static function aluno_home(){
        if ($_SESSION["ALUNO"]) {

            $dados = AlunoModel::GetProvas();
            $provas_feitas = AlunoModel::GetProvasFinalizadas();
            $provas_aluno = []; 
            $provas_aluno_feitas = []; 
            if ($dados != null) {
                foreach ($dados as $prova) {
                    if (strpos($prova["turmas"], ",")) {
                        $turmas = explode(",", $prova["turmas"]);
                        foreach ($turmas as $turma) {
                            if ($turma == $_SESSION["turma"]) {
                                $provas_aluno[] = $prova; 
                            }
                        }
                    } else {
                        if ($prova["turmas"] == $_SESSION["turma"]) {
                            $provas_aluno[] = $prova;
                        }
                    }
                }
            }else{
                $provas_aluno = null;
            }

            if($provas_feitas != null) {
                foreach ($provas_feitas as $prova) {
                    if ($prova["ra"] == $_SESSION["ra"]) {
                        $provas_aluno_feitas[] = $prova;
                    }
                }
            } else {
                $provas_aluno_feitas = null;
            }

            MainController::Templates("public/views/aluno/home.php", "ALUNO", [
                "provas"            => $provas_aluno,
                "provas_feitas"     => $provas_aluno_feitas
            ]);
        } else {
            header("location: home");
        }
    }

    public static function gabarito_aluno(){
        if($_SESSION["ALUNO"]){
            $id = $_POST["id-prova"];
            $dados = AlunoModel::GetProvas();
            
            foreach($dados as $prova){
                if($prova["id"] == $id){
                    $_SESSION["prova_gabarito"] = $prova;
                    MainController::Templates("public/views/aluno/gabarito.php", "ALUNO", $prova);
                }
            }
        }else{
            header("location: home");
        }

    }

    public static function cadastrar_gabarito_aluno(){
        if($_SESSION["ALUNO"]){
            $gabarito_professor = explode(";",$_SESSION["prova_gabarito"]["gabarito"]); 
            $gabarito_aluno = [];
            $perguntas_certas = [];
            $perguntas_erradas = [];
            $perguntas_respostas = [];
            $descritores_corretos = [];
            $descritores_errados = [];
            $acertos_aluno = 0; 
            $dataAtual = new DateTime();
            $dataFormatada = $dataAtual->format('Y-m-d');
            $valor_cada_pergunta = $_SESSION["prova_gabarito"]["valor"] / $_SESSION["prova_gabarito"]["QNT_perguntas"] ;
            $descritores_questoes = explode(";",$_SESSION["prova_gabarito"]["descritores"]);

            $contador = 1;
            while($contador <= $_SESSION["prova_gabarito"]["QNT_perguntas"]){
                $gabarito_aluno[] = $_POST["gabarito_questao_". $contador];
                $contador++;
            } 

            $contador = 0;

            while($contador < $_SESSION["prova_gabarito"]["QNT_perguntas"]){ 
                if($gabarito_aluno[$contador] == $gabarito_professor[$contador]){
                    $descritores_corretos[] = $descritores_questoes[$contador];
                    $acertos_aluno++;
                    $perguntas_certas[] = $gabarito_aluno[$contador];  
                    $perguntas_respostas[] = $gabarito_aluno[$contador];  
                }else{
                    $descritores_errados[] = $descritores_questoes[$contador];
                    $perguntas_respostas[] = $gabarito_aluno[$contador];  
                    $perguntas_erradas[] = $gabarito_aluno[$contador];
                }

                $contador++;
            }
 

            if($_SESSION["prova_gabarito"]["id"] == NULL){
                $descritores_corretos = NULL;
                $descritores_errados = NULL;
            }else{
                $descritores_corretos = implode(";", $descritores_corretos);
                $descritores_errados = implode(";", $descritores_errados);
            }

            $pontos_aluno = $valor_cada_pergunta * $acertos_aluno;
            if(is_float($pontos_aluno)){
                $pontos_aluno = number_format($pontos_aluno,1);
            }
    
            $dados = [
                "aluno"                 => $_SESSION["nome_aluno"],
                "ra"                    => $_SESSION["ra"],
                "turma"                 => $_SESSION["turma"],
                "id_prova"              => $_SESSION["prova_gabarito"]["id"],
                "nome_professor"        => $_SESSION["prova_gabarito"]["nome_professor"],
                "descritores"           => $_SESSION["prova_gabarito"]["descritores"], 
                "disciplina"            => $_SESSION["prova_gabarito"]["disciplina"],
                "nome_prova"            => $_SESSION["prova_gabarito"]["nome_prova"],
                "pontos_prova"          => $_SESSION["prova_gabarito"]["valor"],
                "QNT_perguntas"         => $_SESSION["prova_gabarito"]["QNT_perguntas"],
                "turno"                 => $_SESSION["turno"],
                "porcentagem"           => ($acertos_aluno / $_SESSION["prova_gabarito"]["QNT_perguntas"] ) * 100,
                "serie"                 => substr($_SESSION["turma"],0,1),
                "data_aluno"            => $dataFormatada,
                "acertos"               => $acertos_aluno,
                "pontos_aluno"          => $pontos_aluno,
                "perguntas_certas"      => implode(";",$perguntas_certas),
                "perguntas_respostas"   => implode(";",$perguntas_respostas),
                "perguntas_erradas"     => implode(";",$perguntas_erradas),
                "descritores_certos"    => $descritores_corretos,
                "descritores_errados"   => $descritores_errados
            ];

            if(AlunoModel::Inserir_dados_prova($dados)){
                $_SESSION["PopUp_inserir_prova"] = True;
                header("location:aluno_home");
            }
    }
    else{
        header("location: home");
    }
    }
}