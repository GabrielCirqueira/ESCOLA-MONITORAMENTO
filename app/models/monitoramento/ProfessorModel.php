<?php 

namespace app\models\monitoramento;

use app\config\Database;

class ProfessorModel{
    
    public static function verificarLogin($user){
        $sql = "SELECT * FROM professores WHERE usuario = :dado";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindvalue(":dado",$user);
        $query->execute(); 
        
        if($query->rowCount() > 0){
            return True;
        }else{
            return False;
        }

    }

}