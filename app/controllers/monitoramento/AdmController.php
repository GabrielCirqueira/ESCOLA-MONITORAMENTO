<?php

namespace app\controllers\monitoramento;

use app\controllers\monitoramento\MainController;
use app\controllers\monitoramento\RelatorioPeriodo;
use app\controllers\monitoramento\Relatorio;
use app\models\monitoramento\ADModel;
use app\models\monitoramento\AlunoModel;
use app\models\monitoramento\ProfessorModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdmController
{

    public static function login_adm_verifica()
    {

        if ($_POST["campo_adm"] == $_ENV["SENHA_ADM"]) {
            $_SESSION["ADM"] = true;
            header("location:adm_home");
        } else {
            $_SESSION["PopUp_PRF_NaoENC"] = true;
            header("location: login_adm");
            exit;
        }
    }

    public static function backups()
    {
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

        usort($dados, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });
        return $dados;
    }

    public static function adm_home()
    {
        if (MainController::Verificar_sessao("ADM")) {

            self::Get_forms();

            $dados = [
                "alunos" => [
                    "provas_feitas" => ADModel::GetProvas(),
                    "alunos" => AlunoModel::GetAlunos(),
                ],
                "turmas" => [
                    "turmas" => ADModel::GetTurmas(),
                ],
                "turnos" => explode(",", $_ENV["TURNOS"]),
                "cursos" => explode(",", $_ENV["CURSOS"]),
                "NTurmas" => explode(",", $_ENV["NUMERO_TURMAS"]),
                "Nseries" => explode(",", $_ENV["NUMEROS_SERIES"]),
                "periodos" => ADModel::GetPeriodos(),
                "disciplinas" => ADModel::GetDisciplinas(),
                "logsADM" => ADModel::GetLogsADM(),
                "logsPROF" => ADModel::GetLogsProfessor(),
                "PFAs" => ADModel::GetPFA(),
                "backups" => self::backups(),
                "professores" => ADModel::GetProfessores(),
            ];

            MainController::Templates("public/views/adm/home.php", "ADM", $dados);
        } else {
            header("location: home");
        }
    }

    public static function Get_forms()
    {

        if (isset($_POST["Enviar-periodo"])) {
            $dataAtual = new \DateTime();
            $dataFormatada = $dataAtual->format('Y-m-d H:i:s');

            $dados = [
                "nome" => $_POST["NomePeriodo"],
                "dataInicial" => $_POST["dataInicial"],
                "dataFinal" => $_POST["dataFinal"],
                "data" => $dataFormatada,
            ];
            if (ADModel::adicionarPeriodo($dados)) {
                self::inserirLogsADM("Foi adicionado o período {$dados["nome"]}.");
                $_SESSION["PopUp_add_periodo"] = true;
                header("location: adm_home");
                exit();
            }

        }

        if (isset($_POST["excluir-periodo"])) {
            $periodo = explode(";", $_POST["excluir-periodo"]);
            if (ADModel::ExcluirPeriodo($periodo[0])) {

                self::inserirLogsADM("O período {$periodo[1]} foi excluído.");
                $_SESSION["PopUp_excluir_periodo"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["excluir-pfa"])) {
            $PFA = explode(";", $_POST["excluir-pfa"]);
            if (ADModel::ExcluirPFA($PFA[0])) {

                self::inserirLogsADM("O PFA {$PFA[1]} foi excluído.");
                $_SESSION["PopUp_Excluir_PFA"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["enviar-prova-editada"])) {

            $contador = 1;
            $perguntas = [];

            $prova = ProfessorModel::GetProvabyID($_POST["id_prova"]);


            while ($contador <= $prova["QNT_perguntas"]) {
                    $perguntas[] = $_POST["gabarito_questao_" . $contador];
                    $contador++;
            }

            $dadosProva = [
                "gabarito" => implode(";", $perguntas),
                "id_prova" => $_POST["id_prova"],
                "ra" => $_POST["ra"],
                "nome" => $_POST["nome_aluno_prova"],
                "id" => $_POST["id_aluno_prova"],
                "turma" => $_POST["turmas_prova"]
            ];

            MainController::pre($dadosProva);

            self::alterarProvaAluno($dadosProva);
        }

        if (isset($_POST["enviar-turma-add"])) {

            $dados_turma = [
                "serie" => $_POST["serie_turma"],
                "turno" => $_POST["turno_adicionar"],
                "curso" => $_POST["curso_turma"],
                "numero" => $_POST["numero_turma"],
            ];

            if ($_POST["nomeTurma"] == null) {
                $dados_turma["nome"] = self::formarNomeTurma($dados_turma);
            } else {
                $dados_turma["nome"] = $_POST["nomeTurma"];
            }

            if (ADModel::AdicionarTurma($dados_turma)) {
                self::inserirLogsADM("Foi adicionado a turma {$dados_turma["nome"]}.");
                $_SESSION["PopUp_inserir_turma"] = true;
                header("location: adm_home");
                exit();
            }

        }

        if (isset($_POST["excluir-turma"])) {
            $turma = explode(";", $_POST["excluir-turma"]);
            if (ADModel::ExcluirTurma($turma[0])) {

                self::inserirLogsADM("A turma {$turma[1]} foi excuída.");
                $_SESSION["PopUp_Excluir_turma"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["salvarPFA"])) {
            
            $dados = [
                "nome" => $_POST["nome"],
                "usuario" => $_POST["user"],
                "senha" => $_POST["senha"],
                "disciplina" => $_POST["disciplinaPFA"],
                "turno" => $_POST["TurnoPFA"]
            ];

            if (ADModel::inserirPFA($dados)) {

                self::inserirLogsADM("O usuario de PFA {$dados["nome"]} foi adicionando.");
                $_SESSION["PopUp_Inserir_PFA"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["excluir-prova-aluno"])) {
            $prova = explode(";", $_POST["excluir-prova-aluno"]);
            if (ADModel::ExcluirProva($prova[1], $prova[0])) {

                self::inserirLogsADM("A Prova do aluno(a) {$prova[2]} da materia {$prova[3]} Foi Excluída.");
                $_SESSION["PopUp_excluir_prova"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["excluir_professor"])) {
            $professor = explode(";", $_POST["excluir_professor"]);
            if (ADModel::ExcluirProfessor($professor[0])) {

                self::inserirLogsADM("O professor {$professor[1]} foi excluído.");

                $_SESSION["PopUp_excluir_professor"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["excluir-aluno"])) {
            $aluno = explode(";", $_POST["excluir-aluno"]);
            if (ADModel::ExcluirAluno($aluno[0])) {

                self::inserirLogsADM("O aluno(a) {$aluno[1]} foi excluído.");

                $_SESSION["PopUp_Excluir_aluno"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["Enviar-edit-professor"])) {

            if ($_POST["disciplina_professor_editar"] == null) {
                $_SESSION["PopUp_not_Materia"] = true;
                header("location: adm_home");
                exit();
            }

            $dados_editar_professor = [
                "id" => $_POST["id"],
                "nome" => $_POST["nome_professor"],
                "usuario" => explode(" ", $_POST["nome_professor"])[0],
                "senha" => $_POST["senha_acesso"],
                "numero" => $_POST["usuario_acesso"],
                "disciplinas" => implode(";", $_POST["disciplina_professor_editar"]),
            ];

            if (ADModel::EditarProfessor($dados_editar_professor)) {

                self::inserirLogsADM("O professor {$dados_editar_professor["nome"]} foi Editado.");

                $_SESSION["PopUp_editar_professor"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["Enviar-professor"])) {

            if ($_POST["disciplina_professor"] == null) {
                $_SESSION["PopUp_not_Materia"] = true;
                header("location: adm_home");
                exit();
            }

            $dados_inserir_professor = [
                "nome" => $_POST["nome_professor"],
                "usuario" => explode(" ", $_POST["nome_professor"])[0],
                "senha" => $_POST["senha_acesso"],
                "numero" => $_POST["usuario_acesso"],
                "disciplinas" => implode(";", $_POST["disciplina_professor"]),
            ];

            if (ADModel::AdicionarProfessor($dados_inserir_professor)) {

                self::inserirLogsADM("O professor {$dados_inserir_professor["nome"]} foi Adicionado.");
                $_SESSION["PopUp_add_professor_true"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["Enviar-materia"])) {
            if (ADModel::AdicionarDisciplina($_POST["nomeMateria"])) {

                self::inserirLogsADM("A matéria {$_POST["nomeMateria"]} foi Adicionada.");
                $_SESSION["PopUp_add_materia_true"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["excluir-materia"])) {
            $materia = explode(";", $_POST["excluir-materia"]);
            if (ADModel::ExcluirDisciplina($materia[0])) {

                self::inserirLogsADM("A matéria {$materia[1]} foi excluída.");

                $_SESSION["PopUp_excluir_materia_true"] = true;
                header("location: adm_home");
                exit();
            }
        }

        if (isset($_POST["enviarRelatorio"])) {
            self::gerarRelatorioGeral();
        }

        if (isset($_POST["enviarCorSistema"])) {
            $primaryColor = $_POST['color'];

            $primaryColorH = self::darkenColor($primaryColor, 30);
            $primaryColorBG = self::transparentColor($primaryColor, 0.2);
            $primaryColorBGeasy = self::transparentColor($primaryColor, 0.05);

            $cssContent = ":root {
                --primary-color: $primaryColor;
                --primary-colorh: $primaryColorH;
                --primary-colorBG: $primaryColorBG;
                --primary-colorBGeasy: $primaryColorBGeasy;
            }";

            file_put_contents('public/assents/css/variaveis.css', $cssContent);

                self::inserirLogsADM("A Cor do Sistema foi alterada para {$primaryColor}.");

                $_SESSION["PopUp_Cor_Sistema"] = true;
                header("location: adm_home");
                exit();
        }
    }

    public static function transparentColor($hex, $alpha) {
        return $hex . dechex(round($alpha * 255));
    }

    public static function darkenColor($hex, $percent) {
        $hex = str_replace("#", "", $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $r = max(0, min(255, $r - ($r * $percent / 100)));
        $g = max(0, min(255, $g - ($g * $percent / 100)));
        $b = max(0, min(255, $b - ($b * $percent / 100)));

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }

    public static function alterarProvaAluno($dados)
    {
        // MainController::pre($dados);
        $prova = ProfessorModel::GetProvabyID($dados["id_prova"]);

        $gabarito_professor = explode(";", $prova["gabarito"]);
        $gabarito_aluno = explode(";", $dados["gabarito"]);
        $perguntas_certas = [];
        $perguntas_erradas = [];
        $perguntas_respostas = [];
        $descritores_corretos = [];
        $descritores_errados = [];
        $acertos_aluno = 0;
        $valor_cada_pergunta = $prova["valor"] / $prova["QNT_perguntas"];
        $descritores_questoes = $prova["descritores"] != null ? explode(";", $prova["descritores"]) : null;


        $contador = 0;
        MainController::pre($descritores_questoes);
        while ($contador < $prova["QNT_perguntas"]) {
            if ($gabarito_aluno[$contador] == $gabarito_professor[$contador]) {
                $descritores_corretos[] = $descritores_questoes != null ? $descritores_questoes[$contador] : null;
                $acertos_aluno++;
                $perguntas_certas[] = $gabarito_aluno[$contador];
                $perguntas_respostas[] = $gabarito_aluno[$contador];
            } else {
                $descritores_errados[] = $descritores_questoes != null ? $descritores_questoes[$contador] : null;
                $perguntas_respostas[] = $gabarito_aluno[$contador];
                $perguntas_erradas[] = $gabarito_aluno[$contador];
            }


            $contador++;
        }

        if ($prova["id"] == null) {
            $descritores_corretos = null;
            $descritores_errados = null;
        } else {
            $descritores_corretos = implode(";", $descritores_corretos);
            $descritores_errados = implode(";", $descritores_errados);
        }

        $pontos_aluno = $valor_cada_pergunta * $acertos_aluno;
        if (is_float($pontos_aluno)) {
            $pontos_aluno = number_format($pontos_aluno, 1);
        }

        $dados_atualizacao = [
            "ra" => $dados["ra"],
            "ID" => $dados["id"],
            "ID_prova" => $dados["id_prova"],
            "acertos" => $acertos_aluno,
            "descritores" => $prova["descritores"],
            "turma" => $dados["turma"],
            "porcentagem" => (number_format(round($pontos_aluno),0) / $prova["valor"]) * 100,
            "pontos_aluno" => number_format(round($pontos_aluno),0),
            "pontos_aluno_quebrado" => number_format($pontos_aluno,1),
            "perguntas_respostas" => $dados["gabarito"],
            "perguntas_certas" => implode(";", $perguntas_certas),
            "perguntas_erradas" => implode(";", $perguntas_erradas),
            "descritores_certos" => $descritores_questoes != null ? $descritores_corretos : null,
            "descritores_errados" => $descritores_questoes != null ? $descritores_errados : null,
            "pontos_prova" => $prova["valor"],
        ];

        MainController::pre($dados_atualizacao);


        if (ProfessorModel::atualizar_gabarito_aluno($dados_atualizacao) && ProfessorModel::atualizar_gabarito_aluno_primeira($dados_atualizacao)) {
            self::inserirLogsADM("A Prova do aluno(a) {$dados["nome"]} da materia {$prova["disciplina"]} Foi Editada.");
            $_SESSION["PopUp_ditar_prova"] = true;
            header("location: adm_home");
            exit();
        }

    }

    public static function inserirLogsADM($string)
    {
        $dados_logs = [
            "data" => date('Y-m-d H:i:s'),
            "autor" => "ADM",
            "descricao" => $string,
        ];

        $query = ADModel::adicionarLogsADM($dados_logs);

        return $query;
    }

    public static function editar_dados_aluno()
    {
        if ($_SESSION["ADM"]) {

            $dados = [
                "ra" => $_POST["ra"],
                "nome" => $_POST["nome"],
                "turno" => $_POST["turno"],
                "data_nasc" => $_POST["data"],
                "turma" => $_POST["turma"],
            ];


            $Edit = ADModel::EditarAluno($dados);

            if ($Edit) {
                self::inserirLogsADM("O aluno(a) {$dados["nome"]} foi editado.");
                $_SESSION["PopUp_editar_aluno_true"] = true;
                header("location: adm_home");
                exit();
            }

        } else {
            header("location: ADM");
        }
    }

    public static function adicionar_aluno()
    {
        $dados = [
            "ra" => $_POST["ra"],
            "nome" => $_POST["nome"],
            "turno" => $_POST["turno_adicionar"],
            "data_nasc" => $_POST["data_nasc"] ?? null,
            "turma" => $_POST["turma_adicionar"],
        ];

        $query = ADModel::AdicionarAluno($dados);

        if ($query) {
            self::inserirLogsADM("O aluno(a) {$dados["nome"]} foi adicionado.");
            $_SESSION["PopUp_add_aluno"] = true;
            header("location: adm_home");
            exit();
        }

    }

    public static function formarNomeTurma($dados)
    {
        $serie = $dados["serie"];
        $turno = $dados["turno"];
        $curso = $dados["curso"];
        $numero = $dados["numero"];

        if ($curso == "INFORMÁTICA") {
            $curso = "IPI";
        } else if ($curso == "ADMINISTRAÇÃO") {
            $curso = "ADM";
        } else {
            $curso = "HUM";
        }

        if ($turno == "INTERMEDIÁRIO") {
            $nome_turma = "{$serie}ºIM0{$numero}-EMI-{$curso}";
        } else if ($turno == "VESPERTINO") {
            $nome_turma = "{$serie}ºV0{$numero}-EM-{$curso}";
        } else {
            $nome_turma = "{$serie}ºN0{$numero}-EM-{$curso}";
        }

        return $nome_turma;
    }

    public static function GetTurmas()
    {
        $turmas = ADModel::GetTurmas();
        return $turmas;
    }

    public static function gerarRelatorioGeral(){
        $superArray = GestorController::gerarSuperArrayCompleto();
        $superArrayPeriodo = self::gerarSuperArrayDetalhado();
    
        // Cria uma nova instância do Spreadsheet
        $spreadsheet = new Spreadsheet();
    
        // Remove a aba padrão criada automaticamente
        $spreadsheet->removeSheetByIndex(0);
    
        // Gera as abas da primeira planilha
        $filename1 = Relatorio::gerarRelatorioGeral($superArray);
        $reader1 = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet1 = $reader1->load($filename1);
    
        // Adiciona as abas da primeira planilha ao novo Spreadsheet
        foreach ($spreadsheet1->getSheetNames() as $sheetName) {
            $sheet = $spreadsheet1->getSheetByName($sheetName);
    
            // Usa addExternalSheet para adicionar a aba de forma segura
            try {
                $spreadsheet->addExternalSheet($sheet);
            } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                // Se o nome da aba já existir, renomeia a aba
                $originalSheetName = $sheetName;
                $counter = 1;
                while ($spreadsheet->sheetNameExists($sheetName)) {
                    $sheetName = $originalSheetName . ' (' . $counter . ')';
                    $counter++;
                }
                $sheet->setTitle($sheetName);
                $spreadsheet->addExternalSheet($sheet);
            }
        }
    
        // Gera as abas da segunda planilha
        $filename2 = RelatorioPeriodo::gerarRelatorioGeral($superArrayPeriodo);
        $reader2 = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet2 = $reader2->load($filename2);
    
        // Adiciona as abas da segunda planilha ao novo Spreadsheet
        foreach ($spreadsheet2->getSheetNames() as $sheetName) {
            $sheet = $spreadsheet2->getSheetByName($sheetName);
    
            // Usa addExternalSheet para adicionar a aba de forma segura
            try {
                $spreadsheet->addExternalSheet($sheet);
            } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                // Se o nome da aba já existir, renomeia a aba
                $originalSheetName = $sheetName;
                $counter = 1;
                while ($spreadsheet->sheetNameExists($sheetName)) {
                    $sheetName = $originalSheetName . ' (' . $counter . ')';
                    $counter++;
                }
                $sheet->setTitle($sheetName);
                $spreadsheet->addExternalSheet($sheet);
            }
        }
    
        // Salva o arquivo final
        $writer = new Xlsx($spreadsheet);
        $filename = 'relatorio_completo.xlsx';
        $writer->save($filename);
    
        // Envia o arquivo para o navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        readfile($filename);
        unlink($filename);
        unlink($filename1);
        unlink($filename2);
        exit;
    }

    public static function gerarSuperArrayDetalhado() {
        // Verifica se o gestor está autenticado
        $provas = AlunoModel::provasFinalizadas();
        $atividades = AlunoModel::GetAtividadesFinalizadas();
        $provaAma = AlunoModel::GetAmaFinalizadas();
    
        // Inicializa o super array
        $superArray = [
            "geral" => [
                "provas" => [],
                "atividades" => [],
                "ama" => [],
            ],
            "por_periodo" => [
                "provas" => [],
                "atividades" => [],
                "ama" => [],
            ],
        ];
    
        // Processa os dados gerais
        $superArray["geral"]["provas"] = self::processarDadosGerais($provas);
        $superArray["geral"]["atividades"] = self::processarDadosGerais($atividades);
        $superArray["geral"]["ama"] = self::processarDadosGerais($provaAma);
    
        // Processa os dados por período
        $superArray["por_periodo"]["provas"] = self::processarDadosPorPeriodoDetalhado($provas);
        $superArray["por_periodo"]["atividades"] = self::processarDadosPorPeriodoDetalhado($atividades);
        $superArray["por_periodo"]["ama"] = self::processarDadosPorPeriodoDetalhado($provaAma);
    
        return $superArray;
    }
    
    // Função para processar dados gerais
    private static function processarDadosGerais($dados) {
        $total = count($dados);
        $somaPorcentagem = 0;
        $alunosAcima60 = 0;
    
        foreach ($dados as $item) {
            $porcentagem = ($item["acertos"] / $item["QNT_perguntas"]) * 100;
            $somaPorcentagem += $porcentagem;
    
            if ($porcentagem >= 60) {
                $alunosAcima60++;
            }
        }
    
        return [
            "total_alunos" => $total,
            "media_porcentagem" => $total > 0 ? number_format($somaPorcentagem / $total, 2) : 0,
            "porcentagem_acima_60" => $total > 0 ? number_format(($alunosAcima60 / $total) * 100, 2) : 0,
        ];
    }
    
    // Função para processar dados por período (com detalhes de turmas e disciplinas)
    private static function processarDadosPorPeriodoDetalhado($dados) {
        // Obtém os períodos cadastrados
        $periodos = ADModel::GetPeriodos();
        $dadosPorPeriodo = [];
    
        // Inicializa o array de dados por período
        foreach ($periodos as $periodo) {
            $dadosPorPeriodo[$periodo["nome"]] = [
                "total_alunos" => 0,
                "soma_porcentagem" => 0,
                "alunos_acima_60" => 0,
                "turmas" => [],
            ];
        }
    
        // Processa cada item (prova, atividade ou AMA)
        foreach ($dados as $item) {
            $dataInsercao = $item["data_aluno"]; // Supondo que a data de inserção está nesse campo
            $porcentagem = ($item["acertos"] / $item["QNT_perguntas"]) * 100;
            $turma = $item["turma"];
            $disciplina = $item["disciplina"];
    
            // Encontra o período correspondente à data de inserção
            foreach ($periodos as $periodo) {
                $dataInicial = $periodo["data_inicial"];
                $dataFinal = $periodo["data_final"];
    
                if ($dataInsercao >= $dataInicial && $dataInsercao <= $dataFinal) {
                    $nomePeriodo = $periodo["nome"];
    
                    // Atualiza os dados gerais do período
                    $dadosPorPeriodo[$nomePeriodo]["total_alunos"]++;
                    $dadosPorPeriodo[$nomePeriodo]["soma_porcentagem"] += $porcentagem;
    
                    if ($porcentagem >= 60) {
                        $dadosPorPeriodo[$nomePeriodo]["alunos_acima_60"]++;
                    }
    
                    // Inicializa os dados da turma, se necessário
                    if (!isset($dadosPorPeriodo[$nomePeriodo]["turmas"][$turma])) {
                        $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma] = [
                            "total_alunos" => 0,
                            "soma_porcentagem" => 0,
                            "alunos_acima_60" => 0,
                            "disciplinas" => [],
                        ];
                    }
    
                    // Atualiza os dados da turma
                    $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["total_alunos"]++;
                    $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["soma_porcentagem"] += $porcentagem;
    
                    if ($porcentagem >= 60) {
                        $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["alunos_acima_60"]++;
                    }
    
                    // Inicializa os dados da disciplina, se necessário
                    if (!isset($dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["disciplinas"][$disciplina])) {
                        $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["disciplinas"][$disciplina] = [
                            "total_alunos" => 0,
                            "soma_porcentagem" => 0,
                            "alunos_acima_60" => 0,
                        ];
                    }
    
                    // Atualiza os dados da disciplina
                    $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["disciplinas"][$disciplina]["total_alunos"]++;
                    $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["disciplinas"][$disciplina]["soma_porcentagem"] += $porcentagem;
    
                    if ($porcentagem >= 60) {
                        $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["disciplinas"][$disciplina]["alunos_acima_60"]++;
                    }
    
                    break; // Sai do loop após encontrar o período correspondente
                }
            }
        }
    
        // Calcula médias e porcentagens para cada período, turma e disciplina
        foreach ($dadosPorPeriodo as $nomePeriodo => $dadosPeriodo) {
            if ($dadosPeriodo["total_alunos"] > 0) {
                $dadosPorPeriodo[$nomePeriodo]["media_porcentagem"] = number_format($dadosPeriodo["soma_porcentagem"] / $dadosPeriodo["total_alunos"], 2);
                $dadosPorPeriodo[$nomePeriodo]["porcentagem_acima_60"] = number_format(($dadosPeriodo["alunos_acima_60"] / $dadosPeriodo["total_alunos"]) * 100, 2);
            } else {
                $dadosPorPeriodo[$nomePeriodo]["media_porcentagem"] = 0;
                $dadosPorPeriodo[$nomePeriodo]["porcentagem_acima_60"] = 0;
            }
    
            foreach ($dadosPeriodo["turmas"] as $turma => $dadosTurma) {
                if ($dadosTurma["total_alunos"] > 0) {
                    $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["media_porcentagem"] = number_format($dadosTurma["soma_porcentagem"] / $dadosTurma["total_alunos"], 2);
                    $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["porcentagem_acima_60"] = number_format(($dadosTurma["alunos_acima_60"] / $dadosTurma["total_alunos"]) * 100, 2);
                } else {
                    $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["media_porcentagem"] = 0;
                    $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["porcentagem_acima_60"] = 0;
                }
    
                foreach ($dadosTurma["disciplinas"] as $disciplina => $dadosDisciplina) {
                    if ($dadosDisciplina["total_alunos"] > 0) {
                        $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["disciplinas"][$disciplina]["media_porcentagem"] = number_format($dadosDisciplina["soma_porcentagem"] / $dadosDisciplina["total_alunos"], 2);
                        $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["disciplinas"][$disciplina]["porcentagem_acima_60"] = number_format(($dadosDisciplina["alunos_acima_60"] / $dadosDisciplina["total_alunos"]) * 100, 2);
                    } else {
                        $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["disciplinas"][$disciplina]["media_porcentagem"] = 0;
                        $dadosPorPeriodo[$nomePeriodo]["turmas"][$turma]["disciplinas"][$disciplina]["porcentagem_acima_60"] = 0;
                    }
                }
            }
        }
    
        return $dadosPorPeriodo;
    }

}
