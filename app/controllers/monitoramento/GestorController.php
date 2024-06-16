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

                
            // echo "<pre>";
            // print_r($btnGeral);
            // echo "</pre>";


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
                    if (count($desc) == 2) {
                        $desc = $desc[1];
                        
                        if (!isset($contador_descritores[$desc])) {
                            $contador_descritores[$desc] = 0;
                            $acertos_descritores[$desc] = 0;
                        }
                        $contador_descritores[$desc]++;
                    }
                }
    
                foreach($descritores_certos as $descritor) { 
                    $desc = explode(",", $descritor);
                    if (count($desc) == 2) { 
                        $desc = $desc[1];
                        if (isset($acertos_descritores[$desc])) {
                            $acertos_descritores[$desc]++;
                        }
                    }
                }

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
     
        foreach ($descritores_total as $descritor => $data) {
            $quantidade = $data["quantidade"];
            $descritores_total[$descritor]["porcentagem"] = number_format($data["soma_porcentagem"] / $quantidade,1);
     
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
            $DadosTurnos = GestorModel::GetFiltro("turno", $turno);
            if(count($DadosTurnos) > 0){
                $dados_turno_geral[$turno] = [
                    MainController::gerarGraficoRosca(self::procentagemGeral($DadosTurnos)),
                    MainController::gerarGraficoColunas(self::GetProeficiencia($DadosTurnos))
                ];
            }else{
                $dados_turno_geral[$turno] = NULL; 
            }
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

            
        // echo "<pre>";
        // print_r($provas); 
        // echo "</pre>"; 

        $numero_linhas = count($provas);
        $porcentagem = 0;
  
        foreach($provas as $prova){
            $porcentagem += $prova["porcentagem"];
        }
        
        // echo $numero_linhas;

        return number_format($porcentagem / $numero_linhas, 2);
    }
    

    public static function GetProeficiencia($provas){
        $proficiência = array(
            "Abaixo do Básico" => 0,
            "Básico" => 0,
            "Médio" => 0,
            "Avançado" => 0
        );  
         
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
 
        $totalAlunos = count($provas);
        
        $porcentagensProficiência = array();
 
        foreach ($proficiência as $nivel => $quantidade) {
            if($quantidade == 0){
                $porcentagem = 0;
            }else{
                $porcentagem = number_format((($quantidade / $totalAlunos) * 100),1);
            }
        $porcentagensProficiência[$nivel] = $porcentagem;
        }
    
        return $porcentagensProficiência;
    }

    public static function DadosGeralTurno($provas){
        $dadosPorTurno = array();

        foreach ($provas as $prova) {
            $turno = $prova["turno"];
            $porcentagem = $prova["porcentagem"];
            
            if (!isset($dadosPorTurno[$turno])) {

                $dadosPorTurno[$turno] = array(
                    "quantidade" => 1,
                    "soma_porcentagem" => $porcentagem
                );
            } else {
                $dadosPorTurno[$turno]["quantidade"]++;
                $dadosPorTurno[$turno]["soma_porcentagem"] += $porcentagem;
            }
        }

        $mediasPorTurno = array();

        foreach ($dadosPorTurno as $turno => $dados) {
            $quantidade = $dados["quantidade"];
            $soma_porcentagem = $dados["soma_porcentagem"];
            $media = $soma_porcentagem / $quantidade;
            
            $mediasPorTurno[$turno] = MainController::gerarGraficoRosca(number_format($media,2));
        }

        return $mediasPorTurno;
    }

    public static function DadosGeralTurmas($provas){
        $dadosPorTurma = array();

        foreach ($provas as $prova) {
            $turma = $prova["turma"];
            $porcentagem = $prova["porcentagem"];
            
            if (!isset($dadosPorTurma[$turma])) {

                $dadosPorTurma[$turma] = array(
                    "quantidade" => 1,
                    "soma_porcentagem" => $porcentagem
                );
            } else {

                $dadosPorTurma[$turma]["quantidade"]++;
                $dadosPorTurma[$turma]["soma_porcentagem"] += $porcentagem;
            }
        }
        
        $mediasPorTurma = array();
        
        foreach ($dadosPorTurma as $turma => $dados) {
            $quantidade = $dados["quantidade"];
            $soma_porcentagem = $dados["soma_porcentagem"];
            $media = $soma_porcentagem / $quantidade;
            
            $mediasPorTurma[$turma] = MainController::gerarGraficoRosca(number_format($media,1));
        }


                
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

        ksort($turmasIntermediario);

        ksort($turmasVespertino);

        $arrayOrdenado = $turmasIntermediario + $turmasVespertino;

                return $arrayOrdenado;
    }
 
}
