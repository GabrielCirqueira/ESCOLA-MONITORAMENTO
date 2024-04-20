<?php

namespace app\controllers\monitoramento;

use app\models\monitoramento\ProfessorModel;
use app\controllers\monitoramento\MainController;

class ProfessorController{

    public static function home_professor(){

        $info = ProfessorModel::verificarLogin($_POST["user-prof"]);
        if ($info){
            $_SESSION["PROFESSOR"] = True;
            header("location: professor_home");
        } else {
            $_SESSION["PopUp_professor"] = True;
            header("location: login_professor");
            exit;
        }
    }
    public static function professor_home(){
        if($_SESSION["PROFESSOR"]){
            MainController::Templates("public/views/professor/home.php");
        }else{
            header("location: home");
        }
    }
}