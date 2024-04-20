<?php 

namespace app\controllers\monitoramento;

use app\controllers\monitoramento\MainController;
use app\models\monitoramento\GestorModel;

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
            $info = "public/views/gestor/VisaoGeral.php";
            MainController::Templates("public/views/gestor/home.php");
        }else{
            header("location: home");
        }
    }

    public static function adicionar_professor(){
        $info = GestorModel::Adicionar_professor($_POST["nome"],$_POST["user"],$_POST["cpf"],$_POST["telefone"]);

        if($info){
            $_SESSION["PopUp_add_professor_true"] = True;
            header("location: gestor_home");
            exit;
        }
    }

    public static function Gestor_info($pag){
        if($_SESSION["GESTOR"]){
            $info = "public/views/gestor/" . $pag . ".php";
            MainController::Templates("public/views/gestor/home.php");
        }else{
            header("location: home");
        }
    }
}