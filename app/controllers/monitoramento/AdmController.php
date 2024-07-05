<?php 

namespace app\controllers\monitoramento;
 
use app\controllers\monitoramento\MainController;
use app\models\monitoramento\ADModel;

class ADMcontroller{

    public static function login_adm_verifica(){  
        
        if($_POST["campo_adm"] == $_ENV["SENHA_ADM"]){
            $_SESSION["ADM"] = True;
            header("location:adm_home");
        }else{ 
            $_SESSION["popup_not_gestor"] = True;
            header("location: login_adm");
            exit;
        }
    }

    public static function backups(){
        if($_SESSION["ADM"]){
            $diretorio = 'app/config/backups/';
            $arquivos = scandir($diretorio);
            $dados = [];
    
            foreach ($arquivos as $arquivo) {
                if ($arquivo != "index.php" && preg_match('/(\d{4}-\d{2}-\d{2})__(\d{2})-(\d{2})/', $arquivo, $matches)) {
                    $data = isset($matches[1]) ? $matches[1] : 'Data não disponível';
                    $hora = isset($matches[2]) ? $matches[2] : 'Hora não disponível';
                    $minuto = isset($matches[3]) ? $matches[3] : 'Minuto não disponível';
    
                    // Formatação da data no formato brasileiro
                    $data_formatada = date('d/m/Y', strtotime($data));
    
                    // Caminho completo para o arquivo
                    $caminho_arquivo = $diretorio . $arquivo;
    
                    // Obtém o timestamp da data e hora para ordenação
                    $timestamp = strtotime("$data $hora:$minuto:00");
    
                    // Obtém o tamanho do arquivo em bytes
                    $tamanho_arquivo_bytes = filesize($caminho_arquivo);
    
                    // Função interna para formatar o tamanho do arquivo
                    $tamanho_formatado = '';
                    $unidades = array('B', 'KB', 'MB', 'GB', 'TB');
                    for ($i = 0; $tamanho_arquivo_bytes >= 1024 && $i < 4; $i++) {
                        $tamanho_arquivo_bytes /= 1024;
                    }
                    $tamanho_formatado = round($tamanho_arquivo_bytes, 2) . ' ' . $unidades[$i];
    
                    $dados[] = [
                        'data' => $data_formatada,
                        'hora' => $hora,
                        'minuto' => $minuto,
                        'tamanho' => $tamanho_formatado,
                        'arquivo' => $arquivo,
                        'timestamp' => $timestamp, // Adiciona o timestamp aos dados
                    ];
                }
            }
    
            // Ordena os dados pela chave 'timestamp' de forma decrescente
            usort($dados, function($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });
    
            // Passa os dados ordenados para a view
            MainController::Templates("public/views/adm/backups.php", "ADM", $dados);
        } else {
            header("location: ADM");
        }
    }
    

    public static function adm_home(){
        if(MainController::Verificar_sessao("ADM")){
            MainController::Templates("public/views/adm/home.php","ADM",null);
        }else{
            header("location: home");
        }
    } 

    public static function adicionar_professor(){
        $materias = implode(";", $_POST["materias-professor"]); 
        $info = ADModel::Adicionar_professor($_POST["nome"],$_POST["user"],$_POST["cpf"],$_POST["telefone"],$materias);

        if($info){
            $_SESSION["PopUp_add_professor_true"] = True;
            header("location: adm_home");
            exit;
        }
    }


    public static function GetMaterias(){
        $materias = ADModel::GetMaterias();
        return $materias;
    }

    public static function GetProfessores(){
        $materias = ADModel::GetProfessores();
        return $materias;
    }

    public static function adicionar_materia(){
        $turnos = implode(',', $_POST['turno-materia']);
        $insert = ADModel::adicionar_materia($_POST["nome-materia"],$_POST["materia-curso"],$turnos);

        if($insert){
            $_SESSION["PopUp_add_materia_true"] = True;
            header("location: adm_home");
            exit;
        }
    }

    public static function excluir_disciplina(){
        $query = ADModel::excluir_disciplina($_POST["button-excluir-disciplina"]);
        if($query){
            $_SESSION["PopUp_excluir_materia_true"] = True;
            header("location: adm_home");
            exit;
        }
    }

    public static function adicionar_turma(){
        $serie = $_POST["serie-turma"];
        $turno = $_POST["turno-turma"];
        $curso = $_POST["curso-turma"];
        $numero = $_POST["numero-turma"];

        if($curso == "INFORMÁTICA"){
            $curso = "IPI";
        }else if($curso == "ADMINISTRAÇÃO"){
            $curso = "ADM";
        }else{
            $curso = "HUM";
        }

        if($turno == "INTERMEDIÁRIO"){
            $nome_turma = "{$serie}ºIM0{$numero}-EMI-{$curso}";
        }
        
        else if($turno == "VESPERTINO"){
            $nome_turma = "{$serie}ºV0{$numero}-EM-{$curso}";
        }
        
        else{
            $nome_turma = "{$serie}ºN0{$numero}-EM-{$curso}";
        }
        
        if(ADModel::adicionar_turma($nome_turma,$serie,$turno,$curso)){
            $_SESSION["PopUp_inserir_turma"] = True;
            header("location: adm_home");
            exit;
        }
    }

    public static function GetTurmas(){
        $turmas = ADModel::GetTurmas();
        return $turmas;
    }



}
