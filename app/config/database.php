<?php 

namespace app\config;

use PDO;

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
            
            $disciplinas = "CREATE TABLE IF NOT EXISTS disciplinas(
                nome varchar(255),
                turno varchar(255),
                curso varhcar(255)
            );";

            self::GetInstance()->query($professores);
            self::GetInstance()->query($disciplinas);

    }

}