<?php 

namespace app\models\monitoramento;

use app\config\Database;
use PDO;

class GestorModel{
    
    public static function Adicionar_professor($nome,$user,$cpf,$numero){
        $sql = "INSERT INTO professores(usuario,nome,cpf,numero) VALUES(:user,:nome,:cpf,:numero)";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":user",$user);
        $query->bindValue(":nome",$nome);
        $query->bindValue(":cpf",$cpf);
        $query->bindValue(":numero",$numero);
        $query->execute();
        return $query;
    }

    public static function adicionar_materia($nome,$curso,$turnos){
        $sql = "INSERT INTO disciplinas(nome,curso,turno) VALUES(:nome,:curso,:turno)";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":nome",$nome);
        $query->bindValue(":curso",$curso);
        $query->bindValue(":turno",$turnos);
        $query->execute();
        return $query;
    }

    public static function GetMaterias(){
        $sql = "SELECT * FROM disciplinas";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function excluir_disciplina($nome){
        $sql = "DELETE FROM disciplinas WHERE nome = :nome";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindvalue(":nome",$nome);
        $query->execute();

        return $query;
    }

}