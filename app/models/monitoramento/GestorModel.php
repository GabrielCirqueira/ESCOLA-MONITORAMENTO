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
        if($filtros['serie']){
            $query .= " AND serie = :serie";
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
        if($filtros['serie']){
            $stmt->bindValue(':serie', $filtros['serie']);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetProvasFiltrados($filtros){
        $query = "SELECT * FROM gabarito_professores WHERE 1=1";
        
        if($filtros['disciplina']){
            $query .= " AND disciplina = :disciplina";
        }
        if($filtros['professor']){
            $query .= " AND nome_professor = :professor";
        }
        $stmt = Database::GetInstance()->prepare($query);

        if($filtros['disciplina']){
            $stmt->bindValue(':disciplina', $filtros['disciplina']);
        }
        if($filtros['professor']){
            $stmt->bindValue(':professor', $filtros['professor']);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetFiltro($campo,$valor){
        $sql = "SELECT * FROM gabarito_alunos WHERE $campo = :valor ";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":valor", $valor);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}