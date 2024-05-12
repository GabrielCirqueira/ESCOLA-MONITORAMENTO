<?php 

namespace app\controllers\monitoramento;

use app\models\monitoramento\AlunoModel;

use app\controllers\monitoramento\MainController;

class AlunoController{

    public static function login_aluno_entrar(){
        $ra = $_POST["ra"];

        $query = AlunoModel::verificarLogin($ra);

        if(!$query === False){
            $_SESSION["ra"] = $ra;
            $_SESSION["nome_aluno"] = $query["nome"];
            $_SESSION["turma"] = $query["turma"];
            $_SESSION["data_nasc"] = $query["data_nasc"];
            $_SESSION["ALUNO"] = True;
            header("location: aluno_home");

        } else{
            $_SESSION["PopUp_RA_NaoENC"] = True;
            header("location: home");
            exit;
        }
    }

    public static function aluno_home(){
        if($_SESSION["ALUNO"]){

            $dados = AlunoModel::GetProvas() ;

            MainController::Templates("public/views/aluno/home.php","ALUNO", [
                "ra"                => $_SESSION["ra"],   
                "nome_aluno"        => $_SESSION["nome_aluno"],   
                "turma_aluno"       => $_SESSION["turma"],   
                "data_nasc_aluno"   => $_SESSION["data_nasc"],
                "provas"            => $dados
            ]);

        }else{
            header("location: home");
        }
    }


}