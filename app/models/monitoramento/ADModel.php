<?php

namespace app\models\monitoramento;

use app\config\Database;
use PDO;

class ADModel
{

    public static function EditarAluno($dados)
    {
        $sql = "UPDATE alunos SET nome = :nome, turno = :turno, data_nasc = :data_nasc, turma = :turma WHERE ra = :ra";
        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':ra', $dados['ra']);
        $query->bindParam(':nome', $dados['nome']);
        $query->bindParam(':turno', $dados['turno']);
        $query->bindParam(':data_nasc', $dados['data_nasc']);
        $query->bindParam(':turma', $dados['turma']);
        $query->execute();
    
        $sql2 = "UPDATE gabarito_alunos SET turma = :turma, turno = :turno, aluno = :nome WHERE ra = :ra";
        $query2 = Database::GetInstance()->prepare($sql2);
        $query2->bindParam(':ra', $dados['ra']);
        $query2->bindParam(':turma', $dados['turma']);
        $query2->bindParam(':turno', $dados['turno']);
        $query2->bindParam(':nome', $dados['nome']);
        $query2->execute();
    
        $sql3 = "UPDATE gabarito_alunos_primeira_prova SET turma = :turma, turno = :turno, aluno = :nome WHERE ra = :ra";
        $query3 = Database::GetInstance()->prepare($sql3);
        $query3->bindParam(':ra', $dados['ra']);
        $query3->bindParam(':turma', $dados['turma']);
        $query3->bindParam(':turno', $dados['turno']);
        $query3->bindParam(':nome', $dados['nome']);
        $query3->execute();
    
        return $query && $query2 && $query3;
    }
    

    public static function EditarProfessor($dados)
    {
        $sql = "UPDATE professores SET nome = :nome, usuario = :usuario, senha = :senha, numero = :numero, disciplinas = :disciplinas WHERE id = :id";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':id', $dados['id']);
        $query->bindParam(':nome', $dados['nome']);
        $query->bindParam(':usuario', $dados['usuario']);
        $query->bindParam(':senha', $dados['senha']);
        $query->bindParam(':numero', $dados['numero']);
        $query->bindParam(':disciplinas', $dados['disciplinas']);
        $query->execute();
        return $query;
    }

    public static function AdicionarProfessor($dados)
    {
        $sql = "INSERT INTO professores (nome, usuario, senha, numero, disciplinas)
                VALUES (:nome, :usuario, :senha, :numero, :disciplinas)";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':nome', $dados['nome']);
        $query->bindParam(':usuario', $dados['usuario']);
        $query->bindParam(':senha', $dados['senha']);
        $query->bindParam(':numero', $dados['numero']);
        $query->bindParam(':disciplinas', $dados['disciplinas']);
        $query->execute();
        return $query;
    }

    public static function AdicionarAluno($dados)
    {
        $sql = "INSERT INTO alunos (ra, nome, turno, data_nasc, turma)
                    VALUES (:ra, :nome, :turno, :data_nasc, :turma)";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':ra', $dados['ra']);
        $query->bindParam(':nome', $dados['nome']);
        $query->bindParam(':turno', $dados['turno']);
        $query->bindParam(':data_nasc', $dados['data_nasc']);
        $query->bindParam(':turma', $dados['turma']);
        $query->execute();
        return $query;
    }

    public static function AdicionarTurma($dados_turma)
    {
        $sql = "INSERT INTO turmas (serie, turno, curso, nome) VALUES (:serie, :turno, :curso, :nome)";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':serie', $dados_turma['serie']);
        $query->bindParam(':turno', $dados_turma['turno']);
        $query->bindParam(':curso', $dados_turma['curso']);
        $query->bindParam(':nome', $dados_turma['nome']);
        $query->execute();

        return $query;
    }

    public static function adicionarLogsADM($dados)
    {
        $sql = "INSERT INTO logs_adm (autor,data,descricao) VALUES (:autor, :data, :descricao)";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':autor', $dados['autor']);
        $query->bindParam(':data', $dados['data']);
        $query->bindParam(':descricao', $dados['descricao']);
        $query->execute();

        return $query;
    }

    public static function adicionarLogsProfessor($dados)
    {
        $sql = "INSERT INTO logs_professor (autor,data,descricao) VALUES (:autor, :data, :descricao)";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':autor', $dados['autor']);
        $query->bindParam(':data', $dados['data']);
        $query->bindParam(':descricao', $dados['descricao']);
        $query->execute();

        return $query;
    }

    public static function AdicionarDisciplina($nomeDisciplina)
    {
        $sql = "INSERT INTO disciplinas (nome) VALUES (:nome)";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':nome', $nomeDisciplina);
        $query->execute();
        return $query;
    }

    public static function ExcluirAluno($ra)
    {
        $sql = "DELETE FROM alunos WHERE ra = :ra";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':ra', $ra);
        $query->execute();
        return $query;
    }

    public static function ExcluirAlunoTurma($turma)
    {
        $sql = "DELETE FROM alunos WHERE turma = :turma";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':turma', $turma);
        $query->execute();
        return $query;
    }

    public static function adicionarPeriodo($dados)
    {
        $sql = "INSERT INTO periodo(nome,data_inicial,data_final,data_criacao) VALUES (:NM,:DI,:DF,:DC)";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':NM', $dados["nome"]);
        $query->bindParam(':DI', $dados["dataInicial"]);
        $query->bindParam(':DF', $dados["dataFinal"]);
        $query->bindParam(':DC', $dados["data"]);
        $query->execute();
        return $query;
    }

    public static function ExcluirProfessor($id)
    {
        $sql = "DELETE FROM professores WHERE id = :id";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query;
    }

    public static function ExcluirTurma($id)
    {
        $sql = "DELETE FROM turmas WHERE id = :id";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query;
    }

    public static function ExcluirPeriodo($id)
    {
        $sql = "DELETE FROM periodo WHERE id = :id";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query;
    }
    public static function ExcluirProva($id_prova, $ra)
    {
        $sql1 = "DELETE FROM gabarito_alunos WHERE id_prova = :id AND ra = :ra";
        $query1 = Database::GetInstance()->prepare($sql1);
        $query1->bindParam(':id', $id_prova);
        $query1->bindParam(':ra', $ra);
        $query1->execute();

        $sql2 = "DELETE FROM gabarito_alunos_primeira_prova WHERE id_prova = :id AND ra = :ra";
        $query2 = Database::GetInstance()->prepare($sql2);
        $query2->bindParam(':id', $id_prova);
        $query2->bindParam(':ra', $ra);
        $query2->execute();

        return $query2;
    }
    public static function ExcluirDisciplina($idDisciplina)
    {
        $sql = "DELETE FROM disciplinas WHERE id = :id";

        $query = Database::GetInstance()->prepare($sql);
        $query->bindParam(':id', $idDisciplina);
        $query->execute();
        return $query;
    }

    public static function GetProvas()
    {
        $sql = "SELECT * FROM gabarito_alunos ORDER BY data_aluno DESC LIMIT 100 ";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public static function GetMaterias()
    {
        $sql = "SELECT * FROM disciplinas";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetProfessores()
    {
        $sql = "SELECT * FROM professores ORDER BY nome ASC ";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetLogsADM()
    {
        $sql = "SELECT * FROM logs_adm ORDER BY id DESC ";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetLogsProfessor()
    {
        $sql = "SELECT * FROM logs_professor ORDER BY id DESC ";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetTurmas()
    {
        $sql = "SELECT * FROM turmas ORDER BY nome ASC ";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetDisciplinas()
    {
        $sql = "SELECT * FROM disciplinas ORDER BY id DESC ";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetPeriodos()
    {
        $sql = "SELECT * FROM periodo ORDER BY data_criacao DESC ";
        $query = Database::GetInstance()->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
