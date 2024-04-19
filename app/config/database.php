<?php 

namespace app\config;

class Database{

    private static $conn;

    public static function GetInstance(){
        if(self::$conn === NULL){
            self::$conn = new PDO("mysql:host=localhost;dbname=monitoramento","root","");
            self::CreateTable();
        }
        return self::$conn;
    }

    public static function CreateTable(){
        $professores = "CREATE TABLE IF NOT EXISTS professores(
                usuario varchar(255),
                nome varchar(255),
                cpf varchar(14),
                numero varchar(30)
            );";
        
        self::GetInstance()->query($professores);

}

}