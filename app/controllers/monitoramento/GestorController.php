<?php 

namespace app\controllers\monitoramento;

use app\controllers\monitoramento\MainController;

class GestorController{

    public static function login_gestor_verifica(){ 
        
        if($_POST["user-gestor"] == "#VANIAMELHOTUTOR"){
            $_SESSION["GESTOR"] = True;
            header("location:gestor_home");
        }else{
            $_SESSION["popup_not_gestor"] = True;
            header("location: login_gestor");
            exit;
        }
    }

    public static function gestor_home(){
        if($_SESSION["GESTOR"]){
            MainController::Templates("public/views/gestor/home.php");
        }else{
            header("location: home");
        }
    }
}