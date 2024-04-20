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
            $info ="public/views/gestor/VisaoGeral.php"; 
            MainController::Templates_gestor("public/views/gestor/home.php",$info);
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

    public static function Gestor_info(){
        if($_SESSION["GESTOR"]){
            $view = $_POST["pag"];
            $info ="public/views/gestor/". $view .".php"; 
            MainController::Templates_gestor("public/views/gestor/home.php",$info);
        }else{
            header("location: home");
        }
    }
}