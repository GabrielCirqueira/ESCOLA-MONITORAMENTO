<?php

namespace app\controllers\monitoramento;

use app\controllers\monitoramento\MainController;
use app\models\monitoramento\ADModel;
use app\models\monitoramento\AlunoModel;
use app\models\monitoramento\ProfessorModel;
use DateTime;

class PFAcontroller
{
   public static function validar_login_pfa(){
        $user = $_POST["user"];
        $senha = $_POST["senha"];

        $info = ADModel::verificarLoginPFA($user);
        if ($info != false) {
            if ($info["senha"] == $senha) {
                $_SESSION["PFA"] = true;
                $_SESSION["nome_PFA"] = $info["nome"];
                $_SESSION["disciplina_PFA"] = $info["disciplina"];
                $_SESSION["turno_PFA"] = $info["turno"];
                header("location: pfa_home");
            } else {
                $_SESSION["PopUp_PFA_NaoENC"] = true;
                header("location: login_pfa");
                exit;
            }
        } else {
            $_SESSION["PopUp_PRF_NaoENC"] = true;
            header("location: login_professor");
            exit;
        }

    }

    public static function pfa_home(){
        MainController::Templates("public/views/pfa/home.php");
    }

}
