<?php 

namespace app\controllers\monitoramento;
 
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
            $turnos = ["INTERMEDIÁRIO","VESPERTINO"];
            

            $dados = [ 
                "turmas" => GestorModel::GetTurmas(),
                "turnos" => $turnos,
                "disciplinas" => GestorModel::GetDisciplinas(),
                "professores" => GestorModel::GetProfessores()
            ];

            MainController::Templates("public/views/gestor/graficos.php","GESTOR",$dados);
            // MainController::Templates("public/views/gestor/home.php","GESTOR");
        }else{
            header("location: home");
        }
    }

    public static function adicionar_professor(){
        $materias = implode(";", $_POST["materias-professor"]); 
        $info = GestorModel::Adicionar_professor($_POST["nome"],$_POST["user"],$_POST["cpf"],$_POST["telefone"],$materias);

        if($info){
            $_SESSION["PopUp_add_professor_true"] = True;
            header("location: gestor_home");
            exit;
        }
    }


    public static function GetMaterias(){
        $materias = GestorModel::GetMaterias();
        return $materias;
    }

    public static function GetProfessores(){
        $materias = GestorModel::GetProfessores();
        return $materias;
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

    public static function adicionar_turma(){
        $serie = $_POST["serie-turma"];
        $turno = $_POST["turno-turma"];
        $curso = $_POST["curso-turma"];
        $numero = $_POST["numero-turma"];

        if($turno == "INTERMEDIÁRIO"){
            $nome_turma = "{$serie}ºI0{$numero} {$curso}";
        }
        
        else if($turno == "VESPERTINO"){
            $nome_turma = "{$serie}ºV0{$numero} {$curso}";
        }
        
        else{
            $nome_turma = "{$serie}ºN0{$numero} {$curso}";
        }
        
        if(GestorModel::adicionar_turma($nome_turma,$serie,$turno,$curso)){
            $_SESSION["PopUp_inserir_turma"] = True;
            header("location: gestor_home");
            exit;
        }
    }

    public static function GetTurmas(){
        $turmas = GestorModel::GetTurmas();
        return $turmas;
    }



}