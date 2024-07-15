<?php 

namespace app\controllers\monitoramento;
 
use app\controllers\monitoramento\MainController;
use app\models\monitoramento\ADModel;
use app\models\monitoramento\AlunoModel;

class ADMcontroller{

    public static function login_adm_verifica(){  
        
        if($_POST["campo_adm"] == $_ENV["SENHA_ADM"]){
            $_SESSION["ADM"] = True;
            header("location:adm_home");
        }else{
            $_SESSION["PopUp_PRF_NaoENC"] = True;
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
    
                    $data_formatada = date('d/m/Y', strtotime($data));
    
                    $caminho_arquivo = $diretorio . $arquivo;
    
                    $timestamp = strtotime("$data $hora:$minuto:00");
    
                    $tamanho_arquivo_bytes = filesize($caminho_arquivo);
    
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
                        'timestamp' => $timestamp,
                    ];
                }
            }
      
            usort($dados, function($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });
    
            MainController::Templates("public/views/adm/backups.php", "ADM", $dados);
        } else {
            header("location: ADM");
        }
    }
    

    public static function adm_home(){
        if(MainController::Verificar_sessao("ADM")){

            
        $dados = [
            "alunos" => [
                "provas_feitas" => AlunoModel::GetProvasFinalizadas(),
                "alunos"    => AlunoModel::GetAlunos()
            ],
            "turmas" => [
                "turmas" => ADModel::GetTurmas()
            ],
            "turnos" => explode(",",$_ENV["TURNOS"])
            ];

            MainController::Templates("public/views/adm/home.php","ADM",$dados);
        }else{
            header("location: home");
        }
    } 

    public static function editar_dados_aluno(){
        if($_SESSION["ADM"]){

            $dados = [
             "ra"       => $_POST["ra"],
             "nome"     => $_POST["nome"],
             "turno"    => $_POST["turno"],
             "data_nasc"     => $_POST["data"],
             "turma"    => $_POST["turma"]
            ];

            $Edit = ADModel::EditarAluno($dados);

            if($Edit){
                $_SESSION["PopUp_editar_aluno_true"] = True;
                header("location: adm_home");
                exit();
            }

        }else{
            header("location: ADM");
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
        
        // if(ADModel::adicionar_turma($nome_turma,$serie,$turno,$curso)){
        //     $_SESSION["PopUp_inserir_turma"] = True;
        //     header("location: adm_home");
        //     exit;
        // }
    }

    public static function GetTurmas(){
        $turmas = ADModel::GetTurmas();
        return $turmas;
    }



}
