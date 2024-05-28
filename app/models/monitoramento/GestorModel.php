<?php 

namespace app\models\monitoramento;

use app\config\Database;
use PDO;

class GestorModel{
      
    public static function GetResultadosFiltrados($filtros){
        $query = "SELECT * FROM gabarito_alunos WHERE 1=1";
        
        if($filtros['turma']){
            $query .= " AND turma = :turma";
        }
        if($filtros['turno']){
            $query .= " AND turno = :turno";
        }
        if($filtros['disciplina']){
            $query .= " AND disciplina = :disciplina";
        }
        if($filtros['professor']){
            $query .= " AND nome_professor = :professor";
        }
        
        $stmt = Database::GetInstance()->prepare($query);
    
        if($filtros['turma']){
            $stmt->bindValue(':turma', $filtros['turma']);
        }
        if($filtros['turno']){
            $stmt->bindValue(':turno', $filtros['turno']);
        }
        if($filtros['disciplina']){
            $stmt->bindValue(':disciplina', $filtros['disciplina']);
        }
        if($filtros['professor']){
            $stmt->bindValue(':professor', $filtros['professor']);
        }
    
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function GetFiltro($campo,$valor){
        $sql = "SELECT * FROM gabarito_alunos WHERE $campo = :valor ";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":valor", $valor);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}