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

    public static function GetProvas(){
        $sql = "SELECT * FROM gabarito_professores";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();
        if($query->rowCount() > 0){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return False;
        }
    }

    public static function GetProvasFinalizadas(){
        $sql = "SELECT * FROM gabarito_alunos ORDER BY aluno ASC";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();
        if($query->rowCount() > 0){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return False;
        }
    }

    public static function Inserir_dados_prova($dados){
        $sql = "INSERT INTO gabarito_alunos
        (aluno, ra, turma, id_prova, nome_professor, descritores, disciplina, nome_prova, pontos_prova, QNT_perguntas, data_aluno, acertos, pontos_aluno, perguntas_certas, descritores_certos, descritores_errados,perguntas_erradas,perguntas_respostas,porcentagem,turno,serie)
        VALUES (:ALUNO, :RA, :TURMA, :ID_PROVA, :NOME_PROFESSOR, :DESCRITORES, :DISCIPLINA, :NOME_PROVA, :PONTOS_PROVA, :QNT_PERGUNTAS, :DATA_ALUNO, :ACERTOS, :PONTOS_ALUNO, :PERGUNTAS_CERTAS, :DESCRITORES_CERTOS, :DESCRITORES_ERRADOS,:PERG_ERRADAS,:PERG_RESP,:PORC,:TURNO,:SER)";
    
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":ALUNO", $dados["aluno"]);
        $query->bindValue(":RA", $dados["ra"]);
        $query->bindValue(":TURMA", $dados["turma"]);
        $query->bindValue(":ID_PROVA", $dados["id_prova"]);
        $query->bindValue(":NOME_PROFESSOR", $dados["nome_professor"]);
        $query->bindValue(":DESCRITORES", $dados["descritores"]);
        $query->bindValue(":DISCIPLINA", $dados["disciplina"]);
        $query->bindValue(":NOME_PROVA", $dados["nome_prova"]);
        $query->bindValue(":PONTOS_PROVA", $dados["pontos_prova"]);
        $query->bindValue(":QNT_PERGUNTAS", $dados["QNT_perguntas"]);
        $query->bindValue(":DATA_ALUNO", $dados["data_aluno"]);
        $query->bindValue(":ACERTOS", $dados["acertos"]);
        $query->bindValue(":PONTOS_ALUNO", $dados["pontos_aluno"]);
        $query->bindValue(":PERGUNTAS_CERTAS", $dados["perguntas_certas"]);
        $query->bindValue(":DESCRITORES_CERTOS", $dados["descritores_certos"]); 
        $query->bindValue(":DESCRITORES_ERRADOS", $dados["descritores_errados"]);
        $query->bindValue(":PERG_ERRADAS", $dados["perguntas_erradas"]);
        $query->bindValue(":PERG_RESP", $dados["perguntas_respostas"]);
        $query->bindValue(":PORC", $dados["porcentagem"]);
        $query->bindValue(":TURNO", $dados["turno"]);
        $query->bindValue(":SER", $dados["serie"]);
        $query->execute();
    
        return $query;
    }

    public static function GetProvasbyID($id){
        $sql = "SELECT * FROM gabarito_alunos WHERE id_prova = :id";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":ID", $id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
 
}