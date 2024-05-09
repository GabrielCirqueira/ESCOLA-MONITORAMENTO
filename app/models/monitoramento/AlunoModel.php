<?php 

namespace app\models\monitoramento;

use app\config\Database;
use PDO;

class AlunoModel{
    
    public static function verificarLogin($user){
        $sql = "SELECT * FROM alunos WHERE ra = :dado";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindvalue(":dado",$user);
        $query->execute(); 
        
        if($query->rowCount() > 0){
            return $query->fetch(PDO::FETCH_ASSOC);
        }else{
            return False;
        }
    }

}