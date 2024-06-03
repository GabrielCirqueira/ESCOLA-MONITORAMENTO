<?php 

namespace app\controllers\monitoramento;
 
use app\controllers\monitoramento\MainController; 
use app\models\monitoramento\AlunoModel;
use app\models\monitoramento\ADModel;
use app\models\monitoramento\GestorModel;

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
    public static function gestor_home() {
        if (isset($_SESSION["GESTOR"])) {

            $btnGeral = isset($_POST["geral"]) || !isset($_POST["filtro"]);
            $dados = null;
            $dados = self::processarFiltros($btnGeral);



            MainController::Templates("public/views/gestor/graficos.php", "GESTOR", $dados);
            // MainController::Templates("public/views/gestor/descritores.php", "GESTOR", $dados);


        } else {
            header("location: ADM");
        }
    }

    public static function gestor_descritores(){
        if (isset($_SESSION["GESTOR"])) {

            $turnos = ["INTERMEDIÁRIO", "VESPERTINO"];



            $filtros = self::obterFiltros();
            $resultados = GestorModel::GetResultadosFiltrados($filtros);
            $descritores = self::DadosDescritores(self::Descritores($resultados));

            uasort($descritores, function ($a, $b) {
                return $a['porcentagem'] <=> $b['porcentagem'];
            });


            // echo "<pre>";
            // print_r($descritores);
            // echo "</pre>";
            $disciplinas = ["Língua Portuguesa", "Matemática", "Física", "Biologia", "Química"];

            $dados = [
                "filtros"       => $filtros,
                "turmas"        => ADModel::GetTurmas(),
                "professores"   => ADModel::GetProfessores(),
                "turnos"        => $turnos,
                "descritores"   => $descritores,
                "disciplinas"   => $disciplinas
            ];

            if(isset($_POST["DESCRITOR"])){
                $dados["descritor"] = $_POST["DESCRITOR"];
            }else{
                $dados["descritor"] = False;
            }

            $btnGeral = isset($_POST["geral"]) || !isset($_POST["filtro"]); 

            if($btnGeral){
                $dados["geral"] = True;
            }else{
                $dados["geral"] = False;
            }

            MainController::Templates("public/views/gestor/descritores.php", "GESTOR", $dados);
        }else{
            header("location:ADM");
        }
    }
 
    public static function Descritores($provas_alunos) {
        $provas_professores = AlunoModel::GetProvas();
        // $provas_alunos = AlunoModel::GetProvasFinalizadas();
    
        $descritores_alunos_todos = [];
    
        foreach($provas_alunos as $prova){
            if($prova["descritores"] != null){             
                $descritor_aluno = [];
                $descritores_P = explode(";", $prova["descritores"]);
                $descritores_certos = $prova["descritores_certos"] ? explode(";", $prova["descritores_certos"]) : [];
                $descritores_errados = $prova["descritores_errados"] ? explode(";", $prova["descritores_errados"]) : [];
                
                $contador_descritores = [];
                $acertos_descritores = [];
    
                // Contar quantas questões existem para cada descritor
                foreach($descritores_P as $descritor) { 
                    $desc = explode(",", $descritor); 
                    if (count($desc) == 2) { // Verifica se explode resultou em dois elementos
                        $desc = $desc[1];
                        
                        if (!isset($contador_descritores[$desc])) {
                            $contador_descritores[$desc] = 0;
                            $acertos_descritores[$desc] = 0;
                        }
                        $contador_descritores[$desc]++;
                    }
                }
    
                // Contar quantos acertos para cada descritor
                foreach($descritores_certos as $descritor) { 
                    $desc = explode(",", $descritor);
                    if (count($desc) == 2) { // Verifica se explode resultou em dois elementos
                        $desc = $desc[1];
                        if (isset($acertos_descritores[$desc])) {
                            $acertos_descritores[$desc]++;
                        }
                    }
                }
    
                // Calcular a porcentagem de acertos por descritor
                foreach($contador_descritores as $desc => $total) {
                    if ($total > 0) {
                        $acertos = $acertos_descritores[$desc];
                        $porcentagem = ($acertos / $total) * 100;
                        $descritor_aluno[$desc] = $porcentagem;
                    }
                }
 
                $descritores_alunos_todos[] = $descritor_aluno;
            }
        }
    
        // echo "<pre>";
        // print_r($descritores_alunos_todos);
        // // print_r($provas_alunos);
        // echo "</pre>";
        // echo "<br>";
    
        return $descritores_alunos_todos;
    }

    public static function DadosDescritores($DescAlunos) { 
        $descritores_total = [];
    
        // Inicialize o array descritores_total com as estruturas necessárias
        foreach ($DescAlunos as $descritores) {
            foreach ($descritores as $descritor => $value) {
                if (!isset($descritores_total[$descritor])) {
                    $descritores_total[$descritor] = [
                        "soma_porcentagem" => 0,
                        "quantidade" => 0,
                        "proeficiencia" => [
                            "Abaixo do Básico" => 0,
                            "Básico" => 0,
                            "Médio" => 0,
                            "Avançado" => 0
                        ],
                    ];
                }
            }
        }
    
        // Calcule a soma das porcentagens e a contagem de proficiências
        foreach ($DescAlunos as $descritores) {
            foreach ($descritores as $descritor => $value) {
                $descritores_total[$descritor]["soma_porcentagem"] += $value;
                $descritores_total[$descritor]["quantidade"]++;
    
                if ($value < 25) {
                    $descritores_total[$descritor]["proeficiencia"]["Abaixo do Básico"]++;
                } elseif ($value >= 25 && $value < 50) {
                    $descritores_total[$descritor]["proeficiencia"]["Básico"]++;
                } elseif ($value >= 50 && $value < 75) {
                    $descritores_total[$descritor]["proeficiencia"]["Médio"]++;
                } else {
                    $descritores_total[$descritor]["proeficiencia"]["Avançado"]++;
                }
            }
        }
    
        // Calcule a porcentagem geral e a porcentagem de cada faixa de proficiência para cada descritor
        foreach ($descritores_total as $descritor => $data) {
            $quantidade = $data["quantidade"];
            $descritores_total[$descritor]["porcentagem"] = number_format($data["soma_porcentagem"] / $quantidade,1);
    
            // Calcular a porcentagem para cada faixa de proficiência
            foreach ($data["proeficiencia"] as $faixa => $contagem) {
                $descritores_total[$descritor]["proeficiencia"][$faixa] = number_format(($contagem / $quantidade) * 100,0);
            }
    
            unset($descritores_total[$descritor]["soma_porcentagem"]);
            unset($descritores_total[$descritor]["quantidade"]);
        }

        foreach($descritores_total as $descritor => $value){
            $descritores_total[$descritor]["proeficiencia"] = MainController::gerarGraficoHorizontal($value["proeficiencia"],$descritor);
            $descritores_total[$descritor]["porcentagem_grafico"] = MainController::gerarGraficoRosca($value["porcentagem"]);
            $descritores_total[$descritor]["porcentagem"] = $value["porcentagem"];
        }
    
        // echo "<pre>";
        // print_r($descritores_total);
        // echo "</pre>";
    
        return $descritores_total;
    }
    
    private static function obterFiltros() {
        $turma = ($_POST['turma'] ?? null) === "SELECIONAR" ? null : ($_POST['turma'] ?? null);
        $turno = ($_POST['turno'] ?? null) === "SELECIONAR" ? null : ($_POST['turno'] ?? null);
        $disciplina = ($_POST['disciplina'] ?? null) === "SELECIONAR" ? null : ($_POST['disciplina'] ?? null);
        $professor = ($_POST['professor'] ?? null) === "SELECIONAR" ? null : ($_POST['professor'] ?? null);
        $serie = ($_POST['serie'] ?? null) === "SELECIONAR" ? null : ($_POST['serie'] ?? null);
    
        return [
            "turma" => $turma,
            "turno" => $turno,
            "disciplina" => $disciplina,
            "professor" => $professor,
            "serie" => $serie
        ];
    }
    
    private static function gerarDadosTurnos() {
        $dados_turno_geral = [];
        $turnos = ["INTERMEDIÁRIO", "VESPERTINO"];
        
        foreach ($turnos as $turno) {
            $dados_turno_geral[$turno] = [
                MainController::gerarGraficoRosca(self::procentagemGeral(GestorModel::GetFiltro("turno", $turno))),
                MainController::gerarGraficoColunas(self::GetProeficiencia(GestorModel::GetFiltro("turno", $turno)))
            ];
        }
    
        return $dados_turno_geral;
    }
    
    private static function processarFiltros($btnGeral) {
        $todas_provas = AlunoModel::GetProvasFinalizadas();
        $turnos = ["INTERMEDIÁRIO", "VESPERTINO"];
    
        $filtros = self::obterFiltros();
    
        $dados_turno_geral = self::gerarDadosTurnos();
    
        $dados = [
            "turmas" => ADModel::GetTurmas(),
            "turnos" => $turnos,
            "disciplinas" => ADModel::GetDisciplinas(),
            "professores" => ADModel::GetProfessores(),
            "status" => false,
            "filtros" => $filtros,
            "roscaGeral" =>  MainController::gerarGraficoRosca(self::procentagemGeral($todas_provas)),
            "colunaGeral" => MainController::gerarGraficoColunas(self::GetProeficiencia($todas_provas)),
            "dados_turnos" => $dados_turno_geral,
            "geral" => $btnGeral
        ];
    
        if ($btnGeral) {
            $dados["dadosturmas"] = self::DadosGeralTurmas($todas_provas);
            $dados["dadosturnos"] = self::DadosGeralTurno($todas_provas);
        }
    
        $resultados = GestorModel::GetResultadosFiltrados($filtros);

        // self::DadosDescritores(self::Descritores($resultados)); 


        // echo "<pre>";
        // print_r($resultados);
        // echo "</pre>";
        
        if (count($resultados) > 0) {
            $dados["graficos_filtro"] = self::GetGraficosFiltros($resultados);
        } else {
            $dados["graficos_filtro"] = NULL;
        }
    
        $dados["status"] = count($resultados) > 0;
    
        return $dados;
    }
    
    public static function GetGraficosFiltros($provas) {
        $proeficiencia = self::GetProeficiencia($provas);
        $porcentagem = self::procentagemGeral($provas);
    
        $dados = [
            "proeficiencia" => MainController::gerarGraficoColunas($proeficiencia),
            "porcentagem" => MainController::gerarGraficoRosca($porcentagem)
        ];
        return $dados;
    }
    

    public static function procentagemGeral($provas){

        $numero_linhas = count($provas);
        $porcentagem = 0;

        foreach($provas as $prova){
            $porcentagem+= $prova["porcentagem"];
        }


        return number_format($porcentagem / $numero_linhas,2);


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
 
}
