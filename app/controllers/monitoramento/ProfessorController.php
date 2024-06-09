<?php

namespace app\controllers\monitoramento;

use app\models\monitoramento\ProfessorModel;
use app\models\monitoramento\AlunoModel;
use app\controllers\monitoramento\MainController;
use DateTime;

class ProfessorController{

    public static function home_professor(){

        $info = ProfessorModel::verificarLogin($_POST["user-prof"]);
        if ($info != False){
            $_SESSION["PROFESSOR"] = True;
            $_SESSION["nome_professor"] = $info["nome"];
            $_SESSION["nome_usuario"]   = $info["usuario"];
            $_SESSION["numero"]         = $info["numero"];
            $_SESSION["disciplinas"]    = $info["disciplinas"];
            header("location: professor_home");
        } else {
            $_SESSION["PopUp_professor"] = True;
            header("location: login_professor");
            exit;
        }
    }
    public static function professor_home(){
        if($_SESSION["PROFESSOR"]){

            MainController::Templates("public/views/professor/home.php","PROFESSOR", [
                'nome'          => $_SESSION["nome_professor"],
                'nome_usuario'  => $_SESSION["nome_usuario"], 
                'numero'        => $_SESSION["numero"],
                'disciplinas'   => $_SESSION["disciplinas"]
            ]);

        }else{
            header("location: ADM");
        }
    }

    public static function inserir_gabarito(){
        
        if($_SESSION["PROFESSOR"]){
            $turmas = ProfessorModel::GetTurmas();
            MainController::Templates("public/views/professor/inserir_gabarito.php","PROFESSOR",$turmas);
        }
            else{
            header("location: ADM");
        }
    }

    public static function criar_gabarito(){

        if($_SESSION["PROFESSOR"]){

        if($_POST["gabarito-turmas"] == null){
            $_SESSION["popup_not_turmas"] = True;
            header("location: inserir_gabarito");
            exit;
        }
        
        $turmas = $_POST["gabarito-turmas"];
        $perguntas = $_POST["qtn-perguntas"];
        $valor = $_POST["valor-prova"];
        $nome = $_POST["nome-prova"];
        $materia = $_POST["Materias-professor-gabarito"];
        $descritores = $_POST["descritores"]; 

        if($_SESSION["PROFESSOR"]){
            $turmas = $_POST["gabarito-turmas"];
            $perguntas = $_POST["qtn-perguntas"];
            $valor = $_POST["valor-prova"];

            $dados = [
                "turmas"        => $turmas,
                "perguntas"     => $perguntas,
                "valor"         => $valor,
                "nome_prova"    => $nome,
                "materia"       => $materia,
                "descritores"   => $descritores
            ];
            
            MainController::Templates("public/views/professor/criar_gabarito.php","PROFESSOR",$dados);
        }
            else{
            header("location: home");
        }
    }else{
        header("location: ADM");
    }
}

    public static function criar_gabarito_respostas(){
        if($_SESSION["PROFESSOR"]){
            $gabarito_prova = [];
            $descritores_prova = [];
            $dataAtual = new DateTime();
            $dataFormatada = $dataAtual->format('Y-m-d');
    
            $contador = 1;
            
            while($contador <= $_POST["numero_perguntas"]){ 
                    $descritores_prova[$contador] = $contador .",". $_POST["DESCRITOR_".$contador];
                    $gabarito_prova[$contador] = $_POST[$contador];
    
                    $contador++;
            }
            
            $descritores = implode(";",$descritores_prova);

            if($_POST["descritor"] == "não"){
                $descritores = NULL;
            }

            $gabarito = implode(";",$gabarito_prova);
    
            $dados = [
                "turmas"        => $_POST["turmas_gabarito"],
                "perguntas"     => $_POST["numero_perguntas"],
                "valor"         => $_POST["valor_prova"],
                "data"          => $dataFormatada,
                "nome_prova"    => $_POST["nome_prova"],
                "descritores"   =>  $descritores,
                "gabarito"      =>  $gabarito,
                "nome_prof"     =>  $_SESSION["nome_professor"],
                "materia"       =>  $_POST["materia_prova"]
            ];
            if(ProfessorModel::inserir_gabarito($dados)){
                $_SESSION["PopUp_inserir_gabarito_professor"] = True;
                header("location: inserir_gabarito");
                exit;
            }
        }
        else{
            header("location: home");
        }
    }

    public static function ver_provas(){

        if($_SESSION["PROFESSOR"]){
            $provas_professores = AlunoModel::GetProvas();
            $provas_alunos = AlunoModel::GetProvasFinalizadas();
            $provas = [];     
            $_SESSION["PAG_VOLTAR"] = "professor_home";

            foreach($provas_professores as $professor){
                if($professor["nome_professor"] == $_SESSION["nome_professor"]){
                    $provas[] = $professor; 
                }
            }
            $dados = [ 
                "provas"        => $provas,
                "provas_alunos" => $provas_alunos
            ];
            MainController::Templates("public/views/professor/provas.php","PROFESSOR",$dados);

        }else{
            header("location: ADM");
        }
    }
    public static function prova() {
        if ($_SESSION["PROFESSOR"]) {
            $provas_professores = AlunoModel::GetProvas();
            $provas_alunos = AlunoModel::GetProvasFinalizadas();   
            $_SESSION["PAG_VOLTAR"] = "ver_provas";

            if(isset($_POST["id-prova"])){
                $id_prova = $_POST["id-prova"];
                $_SESSION["id_prova_professor"] = $_POST["id-prova"]; 
            }else{
                $id_prova = $_SESSION["id_prova_professor"]; 
            }

            $provas = [];
            $provas_turma = [];
            $liberado = false;
    
            foreach ($provas_professores as $prova) {
                if ($prova["id"] == $id_prova) {
                    $provaa = $prova;
                    $turmas = $prova["turmas"];
                    $nome_prova = $prova["nome_prova"];
                    $liberado = $prova["liberado"] == "SIM" ? true : false;
                }
            }
    
            foreach ($provas_alunos as $prova) {
                if ($prova["id_prova"] == $id_prova) {
                    $provas[] = $prova;
                }
            }
    
            $turma = explode(",", $turmas);
            $turma = $turma[0];
    
            if (isset($_POST["status"])) {
                if($_POST["status"] == "sim") {
                    ProfessorModel::alterar_liberado($id_prova,"SIM"); 
                }else{
                    ProfessorModel::alterar_liberado($id_prova,null);  
                }
            }
            if (isset($_POST["turma"])) {
                $turma = $_POST["turma"];

            }

            foreach ($provas as $prova) {
                if ($prova["turma"] == $turma) {
                    $provas_turma[] = $prova;
                }
            }



    
            $dados = [
                "provas" => $provas,
                "turmas" => explode(",", $turmas),
                "turma" => $turma,
                "provas_turma" => $provas_turma,
                "liberado" => $liberado,
                "prova" =>  $provaa,
                "nome_prova" => $nome_prova
            ];

            $provas_rec = ProfessorModel::GetProvaRecbyIDprova($id_prova);
            if(count($provas_rec) > 0){
                $dados["provas_rec"] = [
                    "quantidade" => count($provas_rec),
                    "provas"    => $provas_rec
                ];
            }else{
                $dados["provas_rec"] = NULL;
            }

            // echo "<pre>";
            // print_r($dados);
            // echo "</pre>";
    
            MainController::Templates("public/views/professor/prova.php", "PROFESSOR", $dados);
        }else{
            header("location: ADM");
        }
    }

    public static function prova_recuperacao(){
        $id = $_POST["prova"];
        $prova = ProfessorModel::GetProvaRecbyID($id);
        $_SESSION["PAG_VOLTAR"] = "prova";

        $alunos_prova = [];
        if(strpos($prova["alunos"],";")){
            $alunos_prova = explode(";",$prova["alunos"]);
        }else{
            $alunos_prova[] = $prova["alunos"];
        }

        $alunos = [];
        foreach(AlunoModel::GetAlunos() as $aluno){
            foreach($alunos_prova as $aln_prova){
                if($aln_prova == $aluno["ra"]){
                    $alunos[$aln_prova] = [
                        "nome" => $aluno["nome"],
                        "turma" => $aluno["turma"]
                    ];
                }
            }
        }

        uasort($alunos, function($a, $b) {
            return strcmp($a['turma'], $b['turma']);
        });

        // echo "<pre>";
        // print_r($alunos);
        // echo "</pre>";

        $dados = [
            "alunos" => $alunos
        ];

        MainController::Templates("public/views/professor/dados_prova_rec.php", "PROFESSOR", $dados);


    }
    
    public static function relatorio_professor(){
        if($_SESSION["PROFESSOR"]){
        $provas_professores = AlunoModel::GetProvas();
        $provas_alunos = AlunoModel::GetProvasFinalizadas();
        $provas = []; 
        foreach($provas_professores as $professor){
            if($professor["nome_professor"] == $_SESSION["nome_professor"]){
                $provas[] = $professor; 
            }
        }
        $dados = [ 
            "provas"        => $provas,
            "provas_alunos" => $provas_alunos
        ];
        
        MainController::Templates("public/views/professor/provas_relatorios.php", "PROFESSOR", $dados);
    }else{
        header("location: ADM");
    }
}

    public static function relatorio_prova(){
        if($_SESSION["PROFESSOR"]){
        $id_prova = $_POST["id-prova"];
        $provas = AlunoModel::GetProvasFinalizadas(); 
        $provas_professores = AlunoModel::GetProvas();
        $dados_turmas = [] ;
        $filtro_turmas = False;
    
        foreach($provas_professores as $professor){
            if($professor["id"] == $id_prova){
                $turmas = explode(",", $professor["turmas"]); 
                $nome_prova = $professor["nome_prova"];
                $descritores = explode(";",$professor["descritores"]);
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
    
        $total_pontos_geral = 0;
        $total_alunos_geral = 0;
        $total_acima_60 = 0;
        $total_alunos = 0;
    
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
                if ($porcentagem_aluno > 60) {
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
                $provas_tudo[] = $prova;
            }
        }

        usort($provas_tudo, function ($a, $b) {
            // Comparar as turmas
            $result = strcmp($a['turma'], $b['turma']);
            if ($result === 0) {
                // Se as turmas são iguais, comparar os nomes dos alunos
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

        // echo "<br>";
        // echo "<pre>";
        // print_r($provas_tudo);
        // echo "</pre>"; 

        $dados = [
            "dados_turma" => $dados_turmas,
            "nome_prova" => $nome_prova,
            "media_geral_porcentagem" => MainController::gerarGraficoRosca($media_geral_porcentagem),
            "porcentagem_geral_acima_60" => MainController::gerarGraficoRosca($porcentagem_geral_acima_60),
            "descritores" => $descriotores_sn,
            "percentual_descritores" => $media_descritores_geral,
            "grafico_colunas" => MainController::gerarGraficoColunas($porcentagem_alunos),
            "dados_turma_grafico" => $dados_turma,
            "filtro" => $filtro_turmas,
            "provas_turma" => $provas_tudo
        ];
    
        MainController::Templates("public/views/professor/relatorio_prova.php", "PROFESSOR", $dados);
    }else{
        header("location: ADM");
    }
}
    

    public static function calcularPorcentagem($total, $parte){
        if ($total == 0) {
            return 0;
        }
        return ($parte / $total) * 100;
    }

    public static function editar_prova(){

        if($_SESSION["PROFESSOR"]){

        $id = $_POST["id-prova"];
        $_SESSION["ID_PROVA_EDITAR"] = $id;

        $prova_professor = ProfessorModel::GetProvabyID($id);
        $valor = $prova_professor["valor"];
        $perguntas = $prova_professor["QNT_perguntas"];

        $gabarito = explode(";",$prova_professor["gabarito"]);

         
        if($prova_professor["descritores"] == null){
            $descritores = null;
        }else{
            $descritores = explode(";",$prova_professor["descritores"]);
        }
 

        $dados = [
            "gabarito" => $gabarito,
            "descritores" => $descritores,
            "valor"     => $valor,
            "perguntas"    => $perguntas,
            "nome"  => $prova_professor["nome_prova"],    
        ];

        // echo "<pre>";
        // print_r($dados);
        // echo "</pre>";

        MainController::Templates("public/views/professor/editar_prova.php","PROFESSOR",$dados);
    }else{
        header("location: ADM");
    }
    }

    public static function atualizar_gabarito() {
        if ($_SESSION["PROFESSOR"]) {
            $id_prova = $_SESSION["ID_PROVA_EDITAR"];
            $numero_perguntas = $_POST['numero_perguntas'];
            $descritor_flag = $_POST['descritor'];
    
            // Recuperar descritores e gabarito do formulário
            $gabarito_prova = [];
            $descritores_prova = [];
            
            for ($contador = 1; $contador <= $numero_perguntas; $contador++) {
                $descritores_prova[$contador] = $contador . "," . $_POST["DESCRITOR_" . $contador];
                $gabarito_prova[$contador] = $_POST[$contador];
            }
    
            $descritores = implode(";", $descritores_prova);
            if ($descritor_flag == "não") {
                $descritores = NULL;
            }
    
            $gabarito = implode(";", $gabarito_prova);
    
            $novo_gabarito_professor = [
                "descritores" => $descritores,
                "valor" => $_POST['valor_prova'],
                "gabarito" => $gabarito,
                "ID_prova" => $id_prova
            ];

            ProfessorModel::atualizar_gabarito_professor($novo_gabarito_professor);
      
                // Recuperar todas as provas feitas por alunos
                $provas_alunos = ProfessorModel::GetProvasFeitasbyID($id_prova);
    
                foreach ($provas_alunos as $prova_aluno) {
                    // Recalcular os resultados para cada aluno
                    $gabarito_professor = explode(";", $novo_gabarito_professor["gabarito"]);
                    $gabarito_aluno = explode(";", $prova_aluno["perguntas_respostas"]);
                    $descritores_questoes = explode(";", $prova_aluno["descritores"]);
    
                    $acertos_aluno = 0;
                    $perguntas_certas = [];
                    $perguntas_erradas = [];
                    $descritores_corretos = [];
                    $descritores_errados = [];
    
                    foreach ($gabarito_professor as $index => $resposta_correta) {
                        if ($gabarito_aluno[$index] == $resposta_correta) {
                            $acertos_aluno++;
                            $perguntas_certas[] = $gabarito_aluno[$index];
                            $descritores_corretos[] = $descritores_questoes[$index];
                        } else {
                            $perguntas_erradas[] = $gabarito_aluno[$index];
                            $descritores_errados[] = $descritores_questoes[$index];
                        }
                    }
    
                    $valor_cada_pergunta = $novo_gabarito_professor["valor"] / count($gabarito_professor);
                    $pontos_aluno = $valor_cada_pergunta * $acertos_aluno;
    
                    $dados_atualizacao = [
                        "ID" => $prova_aluno["id"],
                        "ID_prova" => $id_prova,
                        "acertos" => $acertos_aluno,
                        "porcentagem" => ($acertos_aluno / count($gabarito_professor)) * 100,
                        "pontos_aluno" => $pontos_aluno,
                        "perguntas_certas" => implode(";", $perguntas_certas),
                        "perguntas_erradas" => implode(";", $perguntas_erradas),
                        "descritores_certos" => implode(";", $descritores_corretos),
                        "descritores_errados" => implode(";", $descritores_errados),
                        "pontos_prova" => $_POST['valor_prova']
                    ];
  
                    ProfessorModel::atualizar_gabarito_aluno($dados_atualizacao);
                }
    
                $_SESSION["PopUp_inserir_prova"] = True;
                header("location: professor_home");
            
        } else {
            header("location: ADM");
        }
    }
    

    public static function add_recuperacao(){
        $id = $_SESSION["id_prova_professor"];
        $provas_professores = AlunoModel::GetProvas();
        $_SESSION["dados_prova_rec"]["id"] = $_POST["id-prova"];
        $alunos = AlunoModel::GetAlunos();

        foreach($provas_professores as $prova){
            if($prova["id"] == $id){
                $turmas = explode(",",$prova["turmas"]);
            }
        }
        $turmas_alunos = [];

        foreach($alunos as $aluno){

            foreach($turmas as $turma){
                if($aluno["turma"] == $turma){ 
                    $turmas_alunos[$turma][$aluno["ra"]] = $aluno["nome"];  
                }
            }
        }

        $turmas_truncated = [];

        foreach ($turmas_alunos as $turma => $alunos) {
            foreach ($alunos as $ra => $nome) {
                if (mb_strlen($nome) > 20) {
                    $nome = mb_substr($nome, 0, 17) . "...";
                }
                $turmas_truncated[$turma][$ra] = $nome;
            }
        }

        // echo "<pre>";
        // print_r($turmas_truncated);
        // echo "<pre>";

        $dados = [
            "alunos" => $turmas_truncated
        ];


        MainController::Templates("public/views/professor/add_recuperacao.php","PROFESSOR",$dados);

    }

    public static function inserir_gabarito_rec(){
        $alunos = implode(";",$_POST["alunos"]);
        $perguntas = $_POST["qtn-perguntas"];
        $descritores = $_POST["descritores"];
        $id_prova = $_SESSION["dados_prova_rec"]["id"];
        $_SESSION["dados_prova_rec"] = [
            "id"   => $id_prova,
            "alunos" => $alunos,
            "perguntas" => $perguntas,
            "descritores" => $descritores
        ];
        $_SESSION["GABARITO_REC"] = true;

        header("location: criar_gabarito_rec");
        // echo $alunos;
        // echo "<pre>";
        // print_r($_SESSION);
        // echo "<pre>";
    }

    public static function criar_gabarito_rec(){
        MainController::Templates("public/views/professor/criar_gabarito_rec.php","PROFESSOR",NULL);
    }

    public static function criar_gabarito_rec_resp(){
        
        foreach(AlunoModel::GetProvas() as $prova){
            if($prova["id"] == $_SESSION["dados_prova_rec"]["id"]){
                $nome_prova = $prova["nome_prova"];
                $materia = $prova["disciplina"];
                $valor = $prova["valor"];
            }
        }
        $dataHoraAtual = new DateTime();    
        $dataFormatada = $dataHoraAtual->format('Y-m-d H:i:s');

        $descritores = '';
        $gabarito = '';
    
        $total_perguntas = $_SESSION["dados_prova_rec"]["perguntas"];
    
        for ($i = 1; $i <= $total_perguntas; $i++) {
            $descritor = ($_SESSION["dados_prova_rec"]["descritores"] == "sim") ? $_POST["DESCRITOR_$i"] : "";
            $descritores .= "$i,{$descritor};";
            $resposta = $_POST["$i"];
            list($numero_pergunta, $letra_resposta) = explode(",", $resposta);
            $gabarito .= "$numero_pergunta,$letra_resposta;";
        }
    
        $descritores = rtrim($descritores, ";");
        if( $_SESSION["dados_prova_rec"]["descritores"] != "sim"){
        $descritores = NULL;
        }
        $gabarito = rtrim($gabarito, ";");

        // echo $gabarito;
        // echo "<br>";
        // echo "<br>";
        // echo $descritores;

        $dados = [
            "id_prova"      => $_SESSION["dados_prova_rec"]["id"],
            "alunos"        => $_SESSION["dados_prova_rec"]["alunos"],
            "perguntas"     => $_SESSION["dados_prova_rec"]["perguntas"],
            "valor"         => $valor,
            "data"          => $dataFormatada,
            "nome_prova"    => $nome_prova,
            "descritores"   =>  $descritores,
            "gabarito"      =>  $gabarito,
            "nome_prof"     =>  $_SESSION["nome_professor"],
            "materia"       =>  $materia
        ];

        $consulta = ProfessorModel::inserir_gabarito_recuperacao($dados);


        if($consulta){
            $_SESSION["PopUp_inserir_gabarito_professor"] = True;
            header("location: ver_provas");
            exit();
        }

        // echo "<pre>";
        // print_r($dados);
        // echo "</pre>";

    }


}