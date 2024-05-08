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
                    id int AUTO_INCREMENT primary key,
                    usuario varchar(255),
                    nome varchar(255),
                    cpf varchar(14),
                    numero varchar(30),
                    disciplinas varchar(255)
                );";
            
            $disciplinas = "CREATE TABLE IF NOT EXISTS disciplinas(
                id int AUTO_INCREMENT primary key,
                nome varchar(255),
                curso varchar(255),
                turno varchar(255)
            );";
            
            $turmas = "CREATE TABLE IF NOT EXISTS turmas(
                id int AUTO_INCREMENT primary key,
                nome varchar(255),
                turno varchar(255),
                serie varchar(255),
                curso varchar(255)
            );";

            $alunos = "CREATE TABLE IF NOT EXISTS alunos(
                ra int primary key,
                nome varchar(255),
                data_nasc varchar(255),
                turma varchar(255)                
                );";

            $descritores = "CREATE TABLE IF NOT EXISTS descritores(
                id int AUTO_INCREMENT primary key,
                descritor varchar(255),
                habilidade text,
                materia varchar(255)                
                );";

            $gabarito_provas_professores = "CREATE TABLE IF NOT EXISTS gabarito_professores(
                id int AUTO_INCREMENT primary key,
                nome_professor varchar(255),
                nome_prova varchar(255),
                turmas varchar(255),
                descritores varchar(255),
                valor int,
                numero_perguntas int,
                data_prova date,
                gabarito varchar(255)     
                );";

            self::GetInstance()->query($professores);
            self::GetInstance()->query($disciplinas);
            self::GetInstance()->query($turmas);
            self::GetInstance()->query($alunos);
            self::GetInstance()->query($descritores);

    }

}

