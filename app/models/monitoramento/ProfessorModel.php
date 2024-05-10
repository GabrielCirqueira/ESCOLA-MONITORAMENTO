<?php 

namespace app\models\monitoramento;

use app\config\Database;
use PDO;

class ProfessorModel{
    
    public static function verificarLogin($user){
        $sql = "SELECT * FROM professores WHERE usuario = :dado";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindvalue(":dado",$user);
        $query->execute(); 
        
        if($query->rowCount() > 0){
            return $query->fetch(PDO::FETCH_ASSOC);
        }else{
            return False;
        }
    }

    public static function GetTurmas(){
        $sql = "SELECT * FROM turmas";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute(); 
        return $query->fetchAll(PDO::FETCH_ASSOC); 
        }

    public static function Inserir_gabarito($dados){
        $sql = "INSERT INTO gabarito_professores
        (nome_professor,nome_prova,turmas,descritores,valor,QNT_perguntas,data_prova,gabarito,disciplina)
        VALUES (:NPRF,:NPRV,:TR,:DES,:VLR,:QTPR,:DTPRV,:GABARITO,:MT)";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindvalue(":NPRF",$dados["nome_prof"]);
        $query->bindvalue(":NPRV",$dados["nome_prova"]);
        $query->bindvalue(":TR",$dados["turmas"]);
        $query->bindvalue(":DES",$dados["descritores"]);
        $query->bindvalue(":VLR",$dados["valor"]);
        $query->bindvalue(":QTPR",$dados["perguntas"]);
        $query->bindvalue(":DTPRV",$dados["data"]);
        $query->bindvalue(":GABARITO",$dados["gabarito"]);
        $query->bindvalue(":MT",$dados["materia"]);
        $query->execute();

        return $query;
    }
}