<?php 

namespace app\controllers\monitoramento;

use app\config\Database;
use app\controllers\monitoramento\MainController;
use app\models\monitoramento\GestorModel;

class GestorController{

    public static function login_gestor_verifica(){ 
        
        if($_POST["user-gestor"] == "NSL"){
            $_SESSION["GESTOR"] = True;
            header("location:gestor_home");
        }else{
            $_SESSION["popup_not_gestor"] = True;
            header("location: login_gestor");
            exit;
        }
    }

    public static function gestor_home(){
        if(MainController::Verificar_sessao("GESTOR")){
            $info ="VisaoGeral"; 
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
        if(MainController::Verificar_sessao("GESTOR")){
            $view = $_POST["pag"];
            MainController::Templates_gestor("public/views/gestor/home.php",$view);
        }else{
            header("location: home");
        }
    }

    public static function adicionar_materia(){
        // Converte os valores do array em uma string separada por vírgulas
        $turnos = implode(',', $_POST['turno-materia']);
        $insert = GestorModel::adicionar_materia($_POST["nome-materia"],$_POST["materia-curso"],$turnos);

        if($insert){
            $_SESSION["PopUp_add_materia_true"] = True;
            header("location: gestor_home");
            exit;
        }
    }

    public static function excluir_disciplina(){
        $query = GestorModel::excluir_disciplina($_POST["button-excluir-disciplina"]);
        if($query){
            $_SESSION["PopUp_excluir_materia_true"] = True;
            header("location: gestor_home");
            exit;
        }
    }
}