<?php 

namespace app\controllers\monitoramento;
 
use app\controllers\monitoramento\MainController;
use app\models\monitoramento\ADModel;

class ADMcontroller{

    public static function login_adm_verifica(){  
        
        if($_POST["campo_adm"] == $_ENV["SENHA_GESTOR"]){
            $_SESSION["ADM"] = True;
            header("location:adm_home");
        }else{ 
            $_SESSION["popup_not_gestor"] = True;
            header("location: login_adm");
            exit;
        }
    }
    public static function adm_home(){
        if(MainController::Verificar_sessao("ADM")){
            MainController::Templates("public/views/adm/home.php");
        }else{
            header("location: home");
        }
    } 

    public static function adicionar_professor(){
        $materias = implode(";", $_POST["materias-professor"]); 
        $info = ADModel::Adicionar_professor($_POST["nome"],$_POST["user"],$_POST["cpf"],$_POST["telefone"],$materias);

        if($info){
            $_SESSION["PopUp_add_professor_true"] = True;
            header("location: adm_home");
            exit;
        }
    }


    public static function GetMaterias(){
        $materias = ADModel::GetMaterias();
        return $materias;
    }

    public static function GetProfessores(){
        $materias = ADModel::GetProfessores();
        return $materias;
    }

    public static function adicionar_materia(){
        $turnos = implode(',', $_POST['turno-materia']);
        $insert = ADModel::adicionar_materia($_POST["nome-materia"],$_POST["materia-curso"],$turnos);

        if($insert){
            $_SESSION["PopUp_add_materia_true"] = True;
            header("location: adm_home");
            exit;
        }
    }

    public static function excluir_disciplina(){
        $query = ADModel::excluir_disciplina($_POST["button-excluir-disciplina"]);
        if($query){
            $_SESSION["PopUp_excluir_materia_true"] = True;
            header("location: adm_home");
            exit;
        }
    }

    public static function adicionar_turma(){
        $serie = $_POST["serie-turma"];
        $turno = $_POST["turno-turma"];
        $curso = $_POST["curso-turma"];
        $numero = $_POST["numero-turma"];

        if($curso == "INFORMÁTICA"){
            $curso = "IPI";
        }else if($curso == "ADMINISTRAÇÃO"){
            $curso = "ADM";
        }else{
            $curso = "HUM";
        }

        if($turno == "INTERMEDIÁRIO"){
            $nome_turma = "{$serie}ºIM0{$numero}-EMI-{$curso}";
        }
        
        else if($turno == "VESPERTINO"){
            $nome_turma = "{$serie}ºV0{$numero}-EM-{$curso}";
        }
        
        else{
            $nome_turma = "{$serie}ºN0{$numero}-EM-{$curso}";
        }
        
        if(ADModel::adicionar_turma($nome_turma,$serie,$turno,$curso)){
            $_SESSION["PopUp_inserir_turma"] = True;
            header("location: adm_home");
            exit;
        }
    }

    public static function GetTurmas(){
        $turmas = ADModel::GetTurmas();
        return $turmas;
    }



}
