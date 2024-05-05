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
}