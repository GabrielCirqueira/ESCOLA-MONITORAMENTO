<?php 

namespace app\controllers\monitoramento;
 
use app\controllers\monitoramento\MainController; 
use app\models\monitoramento\AlunoModel;
use app\models\monitoramento\ADModel;
use app\models\monitoramento\GestorModel;
use app\models\monitoramento\ProfessorModel;

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
        if ($_SESSION["GESTOR"]) {

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


        if($todas_provas != NULL){

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
    }else{
        return False;
    }
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
 

    public static function gestor_provas(){
        if($_SESSION["GESTOR"]){
            $provas_alunos = AlunoModel::GetProvasFinalizadas();
            $provas = [];

            $disciplina = ($_POST['disciplina'] ?? null) === "SELECIONAR" ? null : ($_POST['disciplina'] ?? null);
            $professor  = ($_POST['professor'] ?? null) === "SELECIONAR" ? null : ($_POST['professor'] ?? null);

            if($professor == null && $disciplina == null){
                $geral = True;
            }else{
                $geral = False;
            }
        
            $filtros =  [
                "disciplina" => $disciplina,
                "professor" => $professor
            ];

            $provas_professores = GestorModel::GetProvasFiltrados($filtros);


            if($provas_professores != NULL){
                foreach($provas_professores as $professor){
                    $provas[] = $professor; 
                }
    
                usort($provas, function($a, $b) {
                    return strtotime($b['data_prova']) - strtotime($a['data_prova']);
                });
    
                $status = True;
    

            }else{
                $status = False;
            }
    
            // echo "<pre>";
            // print_r($provas);
            // echo "</pre>";

            $dados = [ 
                "provas"        => $provas,
                "filtros"       => $filtros,
                "disciplinas"   => ADModel::GetDisciplinas(),
                "professores"   => ADModel::GetProfessores(),
                "provas_alunos" => $provas_alunos,
                "status"        => $status,
                "geral"         => $geral
            ];
 
    
            MainController::Templates("public/views/gestor/provas.php","GESTOR",$dados);
    
        } else {
            header("location: ADM");
        }
    }

    public static function gestor_prova(){
        if($_SESSION["GESTOR"]){
            $id_prova = $_POST["id-prova"];
            $_SESSION["PAG_VOLTAR"] = "relatorio_professor";
            $provas = AlunoModel::GetProvasFinalizadas(); 
            $provasRec = ProfessorModel::GetProvaRecAlunos(); 
            $provasPrimeira = ProfessorModel::GetProvaPrimeira(); 
            $provas_professores = AlunoModel::GetProvas();
            $dados_turmas = [];
            $filtro_turmas = False;
            $status_desc = False; 
        
            foreach($provas_professores as $professor){
                if($professor["id"] == $id_prova){
                    $turmas = explode(",", $professor["turmas"]); 
                    $nome_prova = $professor["nome_prova"];
                    $descritores = explode(";",$professor["descritores"]);
                    if($professor["descritores"] != NULL){
                        $status_desc = True;
                    }else{
                        $status_desc = False;
                    }
                }
            } 
        
            $alunos_por_turma = array();
            foreach ($provas as $prova) {
                if ($prova["id_prova"] == $id_prova) {
                    $turma_prova = $prova["turma"];
                    if (!isset($alunos_por_turma[$turma_prova])) {
                        $alunos_por_turma[$turma_prova] = array();
                    }
                    $alunos_por_turma[$turma_prova][] = $prova;
                }
            }
    
            $alunos_por_turma_rec = array();
            foreach ($provasRec as $prova) {
                if ($prova["id_prova"] == $id_prova) {
                    $turma_prova = $prova["turma"];
                    if (!isset($alunos_por_turma_rec[$turma_prova])) {
                        $alunos_por_turma_rec[$turma_prova] = array();
                    }
                    $alunos_por_turma_rec[$turma_prova][] = $prova;
                }
            }
    
            $alunos_por_turma_primeira = array();
            foreach ($provasPrimeira as $prova) {
                if ($prova["id_prova"] == $id_prova) {
                    $turma_prova = $prova["turma"];
                    if (!isset($alunos_por_turma_primeira[$turma_prova])) {
                        $alunos_por_turma_primeira[$turma_prova] = array();
                    }
                    $alunos_por_turma_primeira[$turma_prova][] = $prova;
                }
            }
        
            $total_pontos_geral = 0;
            $total_alunos_geral = 0;
            $total_acima_60 = 0;
            $total_alunos = 0;
        
            // echo "<pre>";
            // print_r($alunos_por_turma);
            // echo "</pre>";
            
    
    
            foreach($alunos_por_turma as $turma){
                $pontos = 0;
                $alunos = 0;
                $alunos_acima_60 = 0;
                foreach($turma as $aluno){
                    $pontos += $aluno["pontos_aluno"];
                    $alunos++;
                    $turma_nome = $aluno["turma"];
                    $pontos_prova = $aluno["pontos_prova"];
                    $porcentagem_aluno =  ($aluno["acertos"] / $aluno["QNT_perguntas"]) * 100;
                    if($aluno["descritores"] == null ){
                        $descriotores_sn = false;
                    }else{
                        $descriotores_sn = true;
                    }
                    if ($porcentagem_aluno >= 60) {
                        $alunos_acima_60++;                                                         
                        $total_acima_60++;
                    }
                }
                
                $porcentagem_acima_60 = number_format(($alunos_acima_60 / $alunos) * 100, 1);
                
                $dados_turmas[$turma_nome] = [
                    "total_pontos_turma" => $pontos,
                    "alunos" => $alunos,
                    "pontos_prova" => $pontos_prova,
                    "porcentagem" => number_format((($pontos / $alunos ) / $pontos_prova) * 100, 0),
                    "porcentagem_acima_60" => $porcentagem_acima_60,
                    "turma_nome" => $turma_nome, 
                    "grafico" => MainController::gerarGraficoRosca(number_format((($pontos / $alunos ) / $pontos_prova) * 100, 1))
                ];
        
                $total_pontos_geral += $pontos;
                $total_alunos_geral += $alunos;
                $total_alunos += $alunos;
            } 
        
            $media_geral_porcentagem = number_format((($total_pontos_geral / $total_alunos_geral) / $pontos_prova) * 100, 2); 
            $porcentagem_geral_acima_60 = number_format(($total_acima_60 / $total_alunos) * 100, 1);
            
    
    
            $acertos_por_descritor = [];
     
            foreach ($alunos_por_turma as $turma => $alunos) {
                $acertos_por_descritor[$turma] = [];
            
                foreach ($alunos as $aluno) {
                    $descritores_certos = explode(';', $aluno['descritores_certos']);
            
                    foreach ($descritores_certos as $descritor) {
                        if (!isset($acertos_por_descritor[$turma][$descritor])) {
                            $acertos_por_descritor[$turma][$descritor] = 1;
                        } else {
                            $acertos_por_descritor[$turma][$descritor]++;
                        }
                    }
                }
            }
            
            $percentual_por_descritor = [];
            
            foreach ($acertos_por_descritor as $turma => $acertos) {
                $total_alunos = count($alunos_por_turma[$turma]);
            
                foreach ($acertos as $descritor => $quantidade_acertos) {
                    $percentual = ($quantidade_acertos / $total_alunos) * 100;
                    $percentual_por_descritor[$turma][$descritor] = $percentual;
                }
            }
    
            $percentual_descritores_turmas = [];
    
    foreach ($percentual_por_descritor as $turma => $descritores) {
        $descritores_modificados = [];
    
        $percentuais_sem_questao = [];
    
        foreach ($descritores as $descritor => $percentual) {
            if (!empty($descritor)) {
                $nome_descritor = explode(',', $descritor)[1];
    
                if (!isset($percentuais_sem_questao[$nome_descritor])) {
                    $percentuais_sem_questao[$nome_descritor] = [$percentual];
                } else {
                    $percentuais_sem_questao[$nome_descritor][] = $percentual;
                }
            }
        }
    
        foreach ($percentuais_sem_questao as $nome_descritor => $percentuais) {
            $media_percentual = array_sum($percentuais) / count($percentuais);
            $descritores_modificados[$nome_descritor] = $media_percentual;
        }
    
        $percentual_descritores_turmas[$turma] = $descritores_modificados;
    }
    
    $media_descritores_geral = array();
    
    foreach ($percentual_descritores_turmas as $turma) {
        foreach ($turma as $descritor => $percentual) {
            if (!isset($media_descritores_geral[$descritor])) {
                $media_descritores_geral[$descritor] = 0;
            }
            $media_descritores_geral[$descritor] += $percentual / count($percentual_descritores_turmas);
        }
    }
    
            foreach($media_descritores_geral as $descritor => $percentual) {
                $media_descritores_geral[$descritor] = MainController::gerarGraficoRosca(number_format($percentual, 1));
            }
            
            $contador_alunos = 0;
    
            $medida_geral = [
                "Abaixo do Básico" => 0,
                "Básico" => 0,
                "Médio" => 0,
                "Avançado" => 0,
            ];
            
            $porcentagem_alunos_turma = [];
            $contador_turma = 0;
            
            foreach($alunos_por_turma as $turma){
                $medida_turma = [
                    "Abaixo do Básico" => 0,
                    "Básico" => 0,
                    "Médio" => 0,
                    "Avançado" => 0,
                ];
            
                $contador_alunos_turma = 0;
                foreach($turma as $aluno){
                    $percentual = ($aluno["acertos"] / $aluno["QNT_perguntas"]) * 100;
                    if($percentual <= 25){
                        $medida_turma["Abaixo do Básico"] += 1;
                    }else if($percentual <= 50) {
                        $medida_turma["Básico"] += 1;
                    }else if($percentual <= 75){
                        $medida_turma["Médio"] += 1;
                    }else{
                        $medida_turma["Avançado"] += 1;
                    }
                    $contador_alunos_turma++;
                    $nome = $aluno["turma"];
                }
            
                $porcentagem_turma = [];
                foreach ($medida_turma as $categoria => $quantidade) {
                    $porcentagem_turma[$categoria] = number_format(($quantidade / $contador_alunos_turma) * 100, 0);
                }
            
                $porcentagem_alunos_turma[$nome] = $porcentagem_turma;
             
                foreach ($medida_turma as $categoria => $quantidade) {
                    $medida_geral[$categoria] += $quantidade;
                }
            
                $contador_alunos += $contador_alunos_turma;
            }
             
            $porcentagem_alunos = [];
            foreach ($medida_geral as $categoria => $quantidade) {
                $porcentagem_alunos[$categoria] = number_format(($quantidade / $contador_alunos) * 100, 0);
            }
            $dados_turma = null;
    
            if(isset($_POST["filtrar"])){
                $turma = $_POST["turma-filtros"];
                if($turma != "geral"){
                    $filtro_turmas = True;
    
                    $grafico_descritores_turma = [];
                    foreach($percentual_descritores_turmas[$turma] as $descritor => $percentual){
                        $grafico_descritores_turma[$descritor] = MainController::gerarGraficoRosca(number_format($percentual,1));
                    }
        
                    $dados_turma = [
                        "nome"=> $turma,
                        "grafico_coluna" => MainController::gerarGraficoColunas($porcentagem_alunos_turma[$turma]),
                        "descritores" => $grafico_descritores_turma,
                        "percentual_turma" => MainController::gerarGraficoRosca($dados_turmas[$turma]["porcentagem"]),
                        "percentual_turma_60" => MainController::gerarGraficoRosca($dados_turmas[$turma]["porcentagem_acima_60"]) 
                    ];
                }else{
                    $filtro_turmas = False;
                }
               
            }
    
            $turmass = array_column($dados_turmas, 'turma_nome');
     
            array_multisort($turmass, SORT_ASC, $dados_turmas);
    
            $provas_tudo = [];
    
            foreach ($provas as $prova) {
                if ($prova["id_prova"] == $id_prova) {
    
                    $prova["NotaP"] = "INDEFINIDO";
                    foreach($provasPrimeira as $pm){
                        if($pm["id_prova"] == $prova["id_prova"]){
                            if($pm["ra"] == $prova["ra"]){
                                $prova["NotaP"] = $pm["pontos_aluno"];
                            }
                        }
                    }
    
                    if($prova["recuperacao"] != NULL){
                        foreach($provasRec as $pr){
                            if($pr["id_prova"] == $prova["id_prova"]){
                                if($pr["ra"] == $prova["ra"]){
                                    $prova["notaRec"] = $pr["pontos_aluno"];
                                }
                            }
                        }
                    }else{
                        $prova["notaRec"] = "INDEFINIDO";
                    }
    
                    $provas_tudo[] = $prova;
                }
            }
    
            usort($provas_tudo, function ($a, $b) {
                $result = strcmp($a['turma'], $b['turma']);
                if ($result === 0) {
                    return strcmp($a['aluno'], $b['aluno']);
                }
                return $result;
            });
    
            if(isset($_POST["filtrar"])){
                $turma = $_POST["turma-filtros"];
                if($turma != "geral"){
                $provas_filtro = [];
                foreach($provas_tudo as $prova){
                        if($prova["turma"] == $turma){
                            $provas_filtro[] = $prova;
                        }
                    }
                    
                    $provas_tudo = $provas_filtro;
                }           
            }
            
            $descritores_por_aluno_primeira = $status_desc ? ProfessorController::calcular_descritores_por_aluno($alunos_por_turma_primeira) : null;
            $descritores_por_aluno_rec = $status_desc ? ProfessorController::calcular_descritores_por_aluno($alunos_por_turma_rec) : null;
    
            // echo "<br>";
            // echo "<pre>";
            // print_r($alunos_por_turma_primeira);
            // echo "</pre>"; 
 

    
            $dados = [
                "dados_turma"                   => $dados_turmas,
                "nome_prova"                    => $nome_prova,
                "media_geral_porcentagem"       => MainController::gerarGraficoRosca($media_geral_porcentagem),
                "porcentagem_geral_acima_60"    => MainController::gerarGraficoRosca($porcentagem_geral_acima_60),
                "descritores"                   => $descriotores_sn,
                "percentual_descritores"        => $media_descritores_geral,
                "grafico_colunas"               => MainController::gerarGraficoColunas($porcentagem_alunos),
                "dados_turma_grafico"           => $dados_turma,
                "filtro"                        => $filtro_turmas,
                "provas_turma"                  => $provas_tudo,
                "descritores_alunos"            => $descritores_por_aluno_primeira,
                "descritores_alunos_rec"        => $descritores_por_aluno_rec
            ];
        
                MainController::Templates("public/views/gestor/prova.php", "GESTOR", $dados);
        }else{
            header("location: ADM");
        }
    }
}
