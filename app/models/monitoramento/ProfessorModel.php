<?php 

namespace app\models\monitoramento;

use app\config\Database;
use PDO;

class ProfessorModel{
    
    public static function verificarLogin($user){
        $sql = "SELECT * FROM professores WHERE numero = :dado";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindvalue(":dado",$user);
        $query->execute(); 
        
        if($query->rowCount() > 0){
            return $query->fetch(PDO::FETCH_ASSOC);
        }else{
            return False;
        }
    }   

    public static function GetTurmas(){
        $sql = "SELECT * FROM turmas";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute(); 
        return $query->fetchAll(PDO::FETCH_ASSOC); 
        }

    public static function Inserir_gabarito($dados){
        $sql = "INSERT INTO gabarito_professores
        (nome_professor,nome_prova,turmas,descritores,valor,QNT_perguntas,data_prova,gabarito,disciplina)
        VALUES (:NPRF,:NPRV,:TR,:DES,:VLR,:QTPR,:DTPRV,:GABARITO,:MT)";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindvalue(":NPRF",$dados["nome_prof"]);
        $query->bindvalue(":NPRV",$dados["nome_prova"]);
        $query->bindvalue(":TR",$dados["turmas"]);
        $query->bindvalue(":DES",$dados["descritores"]);
        $query->bindvalue(":VLR",$dados["valor"]);
        $query->bindvalue(":QTPR",$dados["perguntas"]);
        $query->bindvalue(":DTPRV",$dados["data"]);
        $query->bindvalue(":GABARITO",$dados["gabarito"]);
        $query->bindvalue(":MT",$dados["materia"]);
        $query->execute();

        return $query;
    }

    public static function alterar_liberado($id,$state){
        $sql = "UPDATE gabarito_professores SET liberado = :STATE WHERE id = :ID";
    
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":STATE",$state); 
        $query->bindValue(":ID", $id);
        $query->execute();

        return $query;
    }

    public static function alterar_liberadoRec($id,$state){
        $sql = "UPDATE gabarito_professores_recuperacao SET liberado = :STATE WHERE id = :ID";
    
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":STATE",$state); 
        $query->bindValue(":ID", $id);
        $query->execute();

        return $query;
    }

    public static function alterar_liberado_ver($id,$state){
        $sql = "UPDATE gabarito_professores SET liberar_prova = :STATE WHERE id = :ID";
    
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":STATE",$state); 
        $query->bindValue(":ID", $id);
        $query->execute();

        return $query;
    }

    public static function GetProvabyID($id){
        $sql = "SELECT * FROM gabarito_professores WHERE id = :id";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function GetProvaRecbyIDprova($id){
        $sql = "SELECT * FROM gabarito_professores_recuperacao WHERE id_prova = :id";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetProvaRecbyID($id){
        $sql = "SELECT * FROM gabarito_professores_recuperacao WHERE id = :id";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function GetProvaRec(){
        $sql = "SELECT * FROM gabarito_professores_recuperacao";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute(); 
        return $query->fetchAll(PDO::FETCH_ASSOC); 
    }

    public static function GetProvaPrimeira(){
        $sql = "SELECT * FROM gabarito_alunos_primeira_prova";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute(); 
        return $query->fetchAll(PDO::FETCH_ASSOC); 
    }

    public static function GetProvaRecAlunos(){
        $sql = "SELECT * FROM gabarito_alunos_recuperacao";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute(); 
        return $query->fetchAll(PDO::FETCH_ASSOC); 
    }

    public static function GetProvasFeitasbyID($id){
        $sql = "SELECT * FROM gabarito_alunos WHERE id_prova = :id ORDER BY turma ASC";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function atualizar_gabarito_aluno($dados) {
        $sql = "UPDATE gabarito_alunos SET acertos = :AC, porcentagem = :PORC, pontos_aluno = :PN, perguntas_certas = :PC, perguntas_erradas = :PE, descritores_certos = :DC, descritores_errados = :DE, pontos_prova = :PV WHERE id = :ID_ALUNO AND id_prova = :ID_PROVA";
    
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":AC", $dados["acertos"]);
        $query->bindValue(":PORC", $dados["porcentagem"]);
        $query->bindValue(":PN", $dados["pontos_aluno"]);
        $query->bindValue(":PC", $dados["perguntas_certas"]);
        $query->bindValue(":PE", $dados["perguntas_erradas"]);
        $query->bindValue(":DC", $dados["descritores_certos"]);
        $query->bindValue(":DE", $dados["descritores_errados"]);
        $query->bindValue(":PV", $dados["pontos_prova"]);
        $query->bindValue(":ID_ALUNO", $dados["ID"]);
        $query->bindValue(":ID_PROVA", $dados["ID_prova"]);
        $query->execute();
    
        return $query;
    }

    public static function atualizar_gabarito_professor($dados) {
        $sql = "UPDATE gabarito_professores SET descritores = :DESC, valor = :VALOR, gabarito = :GAB WHERE id = :ID";
    
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":DESC", $dados["descritores"]);
        $query->bindValue(":VALOR", $dados["valor"]);
        $query->bindValue(":GAB", $dados["gabarito"]);
        $query->bindValue(":ID", $dados["ID_prova"]);
        $query->execute();
    
        return $query;
    }

    public static function inserir_gabarito_recuperacao($dados){
        $sql = "INSERT INTO gabarito_professores_recuperacao
        (id_prova, alunos, nome_professor, nome_prova, descritores, disciplina, valor, QNT_perguntas, data_prova_rec, gabarito)
        VALUES (:IDPROVA, :ALUNOS, :NOMEPROF, :NOMEPROVA, :DESCRITORES, :DISCIPLINA, :VALOR, :QTPERGUNTAS, :DATAPROVAREC, :GABARITO)";
    
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":IDPROVA", $dados["id_prova"]);
        $query->bindValue(":ALUNOS", $dados["alunos"]);
        $query->bindValue(":NOMEPROF", $dados["nome_prof"]);
        $query->bindValue(":NOMEPROVA", $dados["nome_prova"]);
        $query->bindValue(":DESCRITORES", $dados["descritores"]);
        $query->bindValue(":DISCIPLINA", $dados["materia"]);
        $query->bindValue(":VALOR", $dados["valor"]);
        $query->bindValue(":QTPERGUNTAS", $dados["perguntas"]);
        $query->bindValue(":DATAPROVAREC", $dados["data"]);
        $query->bindValue(":GABARITO", $dados["gabarito"]); 
        $query->execute();
    
        return $query;
    }

    public static function inserir_gabarito_recuperacao_pesquisa($dados){
        $sql = "INSERT INTO gabarito_professores_recuperacao
        (id_prova, alunos, nome_professor, disciplina, nome_prova, valor, QNT_perguntas, descritores, data_prova_rec, metodo)
        VALUES (:id_prova, :alunos, :nome_professor, :disciplina, :nome_prova, :valor, :QNT_perguntas, :descritores, :data_prova_rec, :metodo)";
        
        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":id_prova", $dados["id_prova"]);
        $query->bindValue(":alunos", $dados["alunos"]);
        $query->bindValue(":nome_professor", $dados["nome_professor"]);
        $query->bindValue(":disciplina", $dados["disciplina"]);
        $query->bindValue(":nome_prova", $dados["nome_prova"]);
        $query->bindValue(":valor", $dados["valor"]);
        $query->bindValue(":QNT_perguntas", $dados["QNT_perguntas"]);
        $query->bindValue(":descritores", $dados["descritores"]);
        $query->bindValue(":data_prova_rec", $dados["data_prova_rec"]);
        $query->bindValue(":metodo", $dados["metodo"]);
        $query->execute();
    
        return $query;
    }
    
    public static function ExcluirProvaAluno($id){
        $sql = "DELETE FROM gabarito_alunos WHERE id_prova = :id";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();

        return $query;
    }

    public static function ExcluirProvaProf($id){
        $sql = "DELETE FROM gabarito_professores WHERE id = :id";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();

        return $query;
    }

}