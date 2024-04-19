<?php

namespace app\controllers\monitoramento;

use app\models\monitoramento\ProfessorModel;
use app\controllers\monitoramento;

class ProfessorController{

    public static function home_professor(){

        $info = ProfessorModel::verificarLogin($_POST["user"]);
        if ($info){
            MainController::Templates("public/views/professor/home.php");
        } else {
            header("location: login_professor");
            echo "<script> Mostrar_PopUp('PopUp_PRF_NaoENC')</script>";
        }
    }
}