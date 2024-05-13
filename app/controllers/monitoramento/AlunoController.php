<?php

namespace app\controllers\monitoramento;

use app\models\monitoramento\AlunoModel;

use app\controllers\monitoramento\MainController;
use DateTime;

class AlunoController
{

    public static function login_aluno_entrar()
    {
        $ra = $_POST["ra"];

        $query = AlunoModel::verificarLogin($ra);

        if (!$query === False) {
            $_SESSION["ra"] = $ra;
            $_SESSION["nome_aluno"] = $query["nome"];
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

    public static function aluno_home()
    {
        if ($_SESSION["ALUNO"]) {

            $dados = AlunoModel::GetProvas();
            $provas_aluno = []; 
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

            MainController::Templates("public/views/aluno/home.php", "ALUNO", [
                "provas"            => $provas_aluno
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
                $descritor_questao = explode(",",$descritores_questoes[$contador]);
                if($gabarito_aluno[$contador] == $gabarito_professor[$contador]){
                    $descritores_corretos[] = $descritor_questao[1];
                    $acertos_aluno++;
                    $perguntas_certas[] = $gabarito_aluno[$contador];  
                }else{
                    $descritores_errados[] = $descritor_questao[1];
                }

                $contador++;
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
                "data_aluno"            => $dataFormatada,
                "acertos"               => $acertos_aluno,
                "pontos_aluno"          => $pontos_aluno,
                "perguntas_certas"      => implode(";",$perguntas_certas),
                "descritores_certos"    => implode(";",$descritores_corretos),
                "descritores_errados"   => implode(";",$descritores_errados)
            ];

            echo "<pre>";
            print_r($dados);
            echo "<pre>";
    }
    else{
        header("location: home");
    }
    }
}