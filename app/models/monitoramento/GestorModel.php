<?php 

namespace app\models\monitoramento;

use app\config\Database;

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

}