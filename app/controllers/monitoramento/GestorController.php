<?php 

namespace app\controllers\monitoramento;
 
use app\controllers\monitoramento\MainController;
use app\models\monitoramento\GestorModel;
use app\models\monitoramento\AlunoModel;

class GestorController{

    public static function login_gestor_verifica(){ 
        
        if($_POST["user-gestor"] == "NSL"){
            $_SESSION["GESTOR"] = True;
            header("location:gestor_home");
        }else{
            $_SESSION["popup_not_gestor"] = True;
            header("location: login_gestor");
            exit;
        }
    }
    public static function gestor_home(){
        if(MainController::Verificar_sessao("GESTOR")){ 
                $todas_provas = AlunoModel::GetProvasFinalizadas();
                $turnos = ["INTERMEDIÁRIO","VESPERTINO"];
   
            $btnGeral = $_POST["geral"] ?? null;
            
            $turma = null;
            $turno = null;
            $disciplina = null;
            $professor = null;
 
            // Verifica se algum filtro foi aplicado
            if(isset($_POST["filtro"])){
                $turma = ($_POST['turma'] ?? null) === "SELECIONAR" ? null : $_POST['turma'];
                $turno = ($_POST['turno'] ?? null) === "SELECIONAR" ? null : $_POST['turno'];
                $disciplina = ($_POST['disciplina'] ?? null) === "SELECIONAR" ? null : $_POST['disciplina'];
                $professor = ($_POST['professor'] ?? null) === "SELECIONAR" ? null : $_POST['professor'];
            }

            if($turma == null && $turno == null && $disciplina == null && $professor == null){
                $btnGeral = true;
            }

            // Array de filtros
            $filtros = [
                "turma" => $turma,
                "turno" => $turno,
                "disciplina" => $disciplina,
                "professor" => $professor
            ];
    
            $dados = [ 
                "turmas" => GestorModel::GetTurmas(),
                "turnos" => $turnos,
                "disciplinas" => GestorModel::GetDisciplinas(),
                "professores" => GestorModel::GetProfessores(),
                "status" => false,
                "filtros"   => $filtros,
                "roscaGeral" => self::procentagemGeral($todas_provas),
                "colunaGeral" => MainController::gerarGraficoColunas(self::GetProeficiencia($todas_provas))
            ];            
            if($btnGeral){
                $dados_turmas = self::DadosGeralTurmas($todas_provas);
                $dados_turnos = self::DadosGeralTurno($todas_provas);
                $dados["dadosturmas"] = $dados_turmas;
                $dados["dadosturnos"] = $dados_turnos;
                $dados["geral"] = true;
            }else{
                $dados["geral"] = false;
            }
    
            $resultados = GestorModel::GetResultadosFiltrados($filtros);
    
            if(count($resultados) <= 0){
                $dados["status"] = false;
            }else{
                $dados["status"] = true;
            }       
    
            // Carrega o template com os dados para exibição
            MainController::Templates("public/views/gestor/graficos.php","GESTOR",$dados);
        }else{
            header("location: home");
        }
    }

    public static function procentagemGeral($provas){

        $numero_linhas = count($provas);
        $porcentagem = 0;

        foreach($provas as $prova){
            $porcentagem+= $prova["porcentagem"];
        }

        return MainController::gerarGraficoRosca(number_format($porcentagem / $numero_linhas,2));


    }

    public static function GetProeficiencia($provas){
        $proficiência = array(
            "Abaixo do Básico" => 0,
            "Básico" => 0,
            "Médio" => 0,
            "Avançado" => 0
        );  
        
        // Loop para calcular as proficiências
        foreach ($provas as $prova) {
            $porcentagem = $prova["porcentagem"];
            
            if ($porcentagem >= 0 && $porcentagem < 25) {
                $proficiência["Abaixo do Básico"]++;
            } elseif ($porcentagem >= 25 && $porcentagem < 50) {
                $proficiência["Básico"]++;
            } elseif ($porcentagem >= 50 && $porcentagem < 75) {
                $proficiência["Médio" ]++;
            } elseif ($porcentagem >= 75 && $porcentagem <= 100) {
                $proficiência["Avançado"]++;
            }
        }

        // Calcula a quantidade total de alunos
        $totalAlunos = count($provas);

        // Array para armazenar as porcentagens de proficiência
        $porcentagensProficiência = array();

        // Calcula a porcentagem de alunos em cada nível de proficiência
        foreach ($proficiência as $nivel => $quantidade) {
            $porcentagem = number_format((($quantidade / $totalAlunos) * 100),1);
            $porcentagensProficiência[$nivel] = $porcentagem;
        }
    
        return $porcentagensProficiência;
    }

    public static function DadosGeralTurno($provas){
        $dadosPorTurno = array();

        // Loop para organizar os dados por turno
        foreach ($provas as $prova) {
            $turno = $prova["turno"];
            $porcentagem = $prova["porcentagem"];
            
            // Verifica se o turno já está no array de dados por turno
            if (!isset($dadosPorTurno[$turno])) {
                // Se não estiver, cria um novo array para o turno
                $dadosPorTurno[$turno] = array(
                    "quantidade" => 1, // Inicia a contagem de provas para o turno
                    "soma_porcentagem" => $porcentagem // Inicia a soma das porcentagens para o turno
                );
            } else {
                // Se já estiver, atualiza a contagem de provas e soma as porcentagens
                $dadosPorTurno[$turno]["quantidade"]++;
                $dadosPorTurno[$turno]["soma_porcentagem"] += $porcentagem;
            }
        }

        // Array para armazenar as médias por turno
        $mediasPorTurno = array();

        // Calcular média por turno
        foreach ($dadosPorTurno as $turno => $dados) {
            $quantidade = $dados["quantidade"];
            $soma_porcentagem = $dados["soma_porcentagem"];
            $media = $soma_porcentagem / $quantidade;
            
            // Armazenar média no array de médias por turno
            $mediasPorTurno[$turno] = MainController::gerarGraficoRosca(number_format($media,2));
        }

        return $mediasPorTurno;
    }

    public static function DadosGeralTurmas($provas){
        $dadosPorTurma = array();

        // Loop para organizar os dados por turma
        foreach ($provas as $prova) {
            $turma = $prova["turma"];
            $porcentagem = $prova["porcentagem"];
            
            // Verifica se a turma já está no array de dados por turma
            if (!isset($dadosPorTurma[$turma])) {
                // Se não estiver, cria um novo array para a turma
                $dadosPorTurma[$turma] = array(
                    "quantidade" => 1, // Inicia a contagem de provas para a turma
                    "soma_porcentagem" => $porcentagem // Inicia a soma das porcentagens para a turma
                );
            } else {
                // Se já estiver, atualiza a contagem de provas e soma as porcentagens
                $dadosPorTurma[$turma]["quantidade"]++;
                $dadosPorTurma[$turma]["soma_porcentagem"] += $porcentagem;
            }
        }
        
        // Array para armazenar as médias por turma
        $mediasPorTurma = array();
        
        // Calcular média por turma
        foreach ($dadosPorTurma as $turma => $dados) {
            $quantidade = $dados["quantidade"];
            $soma_porcentagem = $dados["soma_porcentagem"];
            $media = $soma_porcentagem / $quantidade;
            
            // Armazenar média no array de médias por turma
            $mediasPorTurma[$turma] = MainController::gerarGraficoRosca(number_format($media,1));
        }


        
// Separar as turmas por turno
$turmasIntermediario = [];
$turmasVespertino = [];

foreach ($mediasPorTurma as $turma => $valor) {
    $turno = substr($turma, 3, 1);
    if ($turno === 'I') {
        $turmasIntermediario[$turma] = $valor;
    } else {
        $turmasVespertino[$turma] = $valor;
    }
}

// Ordenar as turmas intermediárias por número da série
ksort($turmasIntermediario);

// Ordenar as turmas vespertinas por número da série
ksort($turmasVespertino);

// Juntar as turmas ordenadas
$arrayOrdenado = $turmasIntermediario + $turmasVespertino;

        return $arrayOrdenado;
    }

    public static function adicionar_professor(){
        $materias = implode(";", $_POST["materias-professor"]); 
        $info = GestorModel::Adicionar_professor($_POST["nome"],$_POST["user"],$_POST["cpf"],$_POST["telefone"],$materias);

        if($info){
            $_SESSION["PopUp_add_professor_true"] = True;
            header("location: gestor_home");
            exit;
        }
    }


    public static function GetMaterias(){
        $materias = GestorModel::GetMaterias();
        return $materias;
    }

    public static function GetProfessores(){
        $materias = GestorModel::GetProfessores();
        return $materias;
    }

    public static function adicionar_materia(){
        // Converte os valores do array em uma string separada por vírgulas
        $turnos = implode(',', $_POST['turno-materia']);
        $insert = GestorModel::adicionar_materia($_POST["nome-materia"],$_POST["materia-curso"],$turnos);

        if($insert){
            $_SESSION["PopUp_add_materia_true"] = True;
            header("location: gestor_home");
            exit;
        }
    }

    public static function excluir_disciplina(){
        $query = GestorModel::excluir_disciplina($_POST["button-excluir-disciplina"]);
        if($query){
            $_SESSION["PopUp_excluir_materia_true"] = True;
            header("location: gestor_home");
            exit;
        }
    }

    public static function adicionar_turma(){
        $serie = $_POST["serie-turma"];
        $turno = $_POST["turno-turma"];
        $curso = $_POST["curso-turma"];
        $numero = $_POST["numero-turma"];

        if($turno == "INTERMEDIÁRIO"){
            $nome_turma = "{$serie}ºI0{$numero} {$curso}";
        }
        
        else if($turno == "VESPERTINO"){
            $nome_turma = "{$serie}ºV0{$numero} {$curso}";
        }
        
        else{
            $nome_turma = "{$serie}ºN0{$numero} {$curso}";
        }
        
        if(GestorModel::adicionar_turma($nome_turma,$serie,$turno,$curso)){
            $_SESSION["PopUp_inserir_turma"] = True;
            header("location: gestor_home");
            exit;
        }
    }

    public static function GetTurmas(){
        $turmas = GestorModel::GetTurmas();
        return $turmas;
    }



}
