<?php
$filtro_ = $data["filtro"] == false ? "GERAL" : $data["dados_turma_grafico"]["nome"];
if ($data["descritores_alunos"] != NULL) {
    $Qdescritores = count($data["descritores_alunos"]["descritores"]) + 1; 
}
$tabela = "table-notas";
?>

<main class="container-professor">
    <center>
        <h1 class="titulo-sistema-monitoramento">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2 class="nome-prova"><?= $data["nome_prova"] ?></h2>
    </center>

    <h3 class="titulo-classificacao">Classificar por:</h3>
    <div class="formulario-filtros-professor">
        <form action="" method="post">
            <input type="hidden" name="id-prova" value="<?= $_POST["id-prova"] ?>">
            <button class="botao-desempenho-geral" name="turma-filtros" value="geral" type="submit">
                <i class="fas fa-chart-bar"></i> Geral
            </button>
            <select class="select-filtros-professor" name="turma-filtros" id="">
                <option value="geral">GERAL</option>
                <?php foreach ($data["dados_turma"] as $turma) { ?>
                <option value="<?= $turma["turma_nome"] ?>"><?= $turma["turma_nome"] ?></option>
                <?php } ?>
            </select>
            <button class="botao-filtrar-turma" name="filtrar" value="filtrar" type="submit">
                <i class="fas fa-filter"></i> Filtrar
            </button>
        </form>
    </div>

    <?php if ($data["filtro"] == false) { ?>
    <h1 class="titulo-desempenho-geral">DESEMPENHO GERAL</h1>
    <br><br>

    <div class="box-grafico-geral">
        <div class="grafico-detalhes-geral">
            <center>
                <h3 class="titulo-percentual-geral">Percentual geral:</h3>
            </center>
            <span class="valor-percentual-geral"><?= $data["media_geral_porcentagem"] ?></span>
        </div>
        <div class="grafico-colunas-proficiencia">
            <hr>
            <?= $data["grafico_colunas"] ?>
            <hr>
        </div>
        <div class="grafico-alunos-acima">
            <h3 class="titulo-alunos-acima">Alunos acima de 60%:</h3>
            <span class="valor-alunos-acima"><?= $data["porcentagem_geral_acima_60"] ?></span>
        </div>
    </div>

    <h2 class="titulo-desempenho-descritores">PERCENTUAL DOS DESCRITORES</h2>
 

    <?php if ($data["descritores"] == false) { ?>
    <center>
        <h1 class="mensagem-sem-descritores">A prova não tem descritores!</h1>
    </center>
    <?php } else { ?>
    <div class="area-graficos-descritores">
        <?php foreach ($data["percentual_descritores"] as $descritor => $grafico) { ?>
        <div class="box-descritor-grafico">
            <?= $grafico ?>
            <h4 class="nome-descritor"><?= $descritor ?></h4>
        </div>
        <?php } ?>
    </div>
    <?php } ?>


    <br><br>

    <h2 class="titulo-desempenho-turmas">DESEMPENHO TOTAL DAS TURMAS</h2>
    <div class="area-grafico-rosca-turmas">
        <?php foreach ($data["dados_turma"] as $turma) { ?>
        <div class="box-grafico-rosca-turma">
            <?= $turma["grafico"] ?>
            <span class="nome-turma"><?= $turma["turma_nome"] ?></span>
        </div>
        <?php } ?>
    </div>

    <?php } else { ?>
    <h1 class="titulo-desempenho-turma"><?= $data["dados_turma_grafico"]["nome"] ?></h1>
    <div class="area-grafico-rosca-turma"></div>
    <br><br>

    <div class="box-grafico-geral">
        <div class="grafico-detalhes-geral">
            <h3 class="titulo-percentual-geral">Percentual geral:</h3>
            <span class="valor-percentual-geral"><?= $data["dados_turma_grafico"]["percentual_turma"] ?></span>
        </div>
        <div class="grafico-colunas-proficiencia">
            <hr>
            <?= $data["dados_turma_grafico"]["grafico_coluna"] ?>
            <hr>
        </div>
        <div class="grafico-alunos-acima">
            <h3 class="titulo-alunos-acima">Alunos acima de 60%:</h3>
            <span class="valor-alunos-acima"><?= $data["dados_turma_grafico"]["percentual_turma_60"] ?></span>
        </div>
    </div>

    <h2 class="titulo-desempenho-descritores">PERCENTUAL DOS DESCRITORES</h2>

    <?php if ($data["descritores"] == false) { ?>
    <center>
        <h1 class="mensagem-sem-descritores">A prova não tem descritores!</h1>
    </center>
    <?php } else { ?>
    <div class="area-graficos-descritores">
        <?php foreach ($data["dados_turma_grafico"]["descritores"] as $descritor => $grafico) { ?>
        <div class="box-descritor-grafico">
            <?= $grafico ?>
            <h4 class="nome-descritor"><?= $descritor ?></h4>
        </div>
        <?php } ?>
    </div>
    <?php } ?>

    <?php } ?>

    <div class="espaco-final"></div>

    <?php if ($data["descritores_alunos"] != NULL) { ?>
    <div class="area-button-tabelas">
        <button class="botao-descritores-alunos" onclick="mostarTabela('DESCRITORES')">
            <i class="fas fa-list"></i> DESCRITORES POR ALUNOS
        </button>
        <button class="botao-notas-alunos" onclick="mostarTabela('NOTAS')">
            <i class="fas fa-graduation-cap"></i> NOTAS ALUNOS
        </button>
    </div>

    <?php if ($data["descritores_alunos_rec"] != NULL) { ?>
    <div id="botoes-alternar-prova" class="hidden area-alternar-provas">
        <button class="botao-alternar-prova" onclick="mostarTabela('DESCRITORES')">
            <i class="fas fa-file-alt"></i> 1º PROVA
        </button>
        <button class="botao-alternar-prova" onclick="mostarTabela('REC')">
            <i class="fas fa-redo"></i> RECUPERAÇÃO
        </button>
    </div>

    <table id="table-descritores-rec" class="tabela-aluno-rec hidden">
        <thead>
            <tr>
                <th colspan="<?= count($data["descritores_alunos_rec"]["descritores"]) + 1 ?>">
                    <center>
                        <h2 class="titulo-tabela-recuperacao">DESCRITORES ALUNOS RECUPERAÇÃO</h2>
                    </center>
                </th>
            </tr>
            <tr>
                <th class="cabecalho-tabela">ALUNO</th>
                <?php foreach ($data["descritores_alunos_rec"]["descritores"] as $indice => $value) {
                            echo "<th class='cabecalho-tabela'><center>{$indice} {$value}</center></th>";
                        } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data["descritores_alunos_rec"]["ALUNOS"] as $aluno => $perguntas) { ?>
            <tr>
                <td class="aluno-nome-rec"><?= $aluno ?></td>
                <?php foreach ($perguntas as $pergunta => $value) {
                                if ($value == "ACERTOU") {
                                    echo "<td class='alternativa-acerto'>$value</td>";
                                } else {
                                    echo "<td class='alternativa-erro'>$value</td>";
                                }
                            } ?>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php } ?>

    <table id="table-descritores-primeira" class="tabela-aluno-primeira hidden">
        <thead>
            <tr>
                <th colspan="<?= $Qdescritores ?>">
                    <center>
                        <h2 class="titulo-tabela-primeira">DESCRITORES ALUNOS</h2>
                    </center>
                </th>
            </tr>
            <tr>
                <th class="cabecalho-tabela">ALUNO</th>
                <?php foreach ($data["descritores_alunos"]["descritores"] as $indice => $value) {
                        echo "<th class='cabecalho-tabela'><center>{$indice} {$value}</center></th>";
                    } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data["descritores_alunos"]["ALUNOS"] as $aluno => $perguntas) { ?>
            <tr>
                <td class="aluno-nome-primeira"><?= $aluno ?></td>
                <?php foreach ($perguntas as $pergunta => $value) {
                            if ($value == "ACERTOU") {
                                echo "<td class='alternativa-acerto'>$value</td>";
                            } else {
                                echo "<td class='alternativa-erro'>$value</td>";
                            }
                        } ?>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php if (count($data["provas_turma"]) > 0) { ?>
    <button id="export-descritores" class="botao-exportar-dados hidden"
        onclick="exportToExcel('<?= 'RESPOSTAS - (' . $filtro_ . ') ' . $data['nome_prova'] ?>', 'table-descritores-primeira')">
        <i class="fas fa-file-export"></i> EXPORTAR DADOS ACERTOS
    </button>
    <?php } ?>
    <?php } else { ?>
    <div class="area-button-tabelas">
        <button class="botao-respostas-alunos" onclick="mostarTabela('RESPOSTAS')">
            <i class="fas fa-question-circle"></i> RESPOSTAS
        </button>
        <button class="botao-notas-alunos" onclick="mostarTabela('NOTAS')">
            <i class="fas fa-graduation-cap"></i> NOTAS ALUNOS
        </button>
    </div>

    <table id="table-respostas" class="tabela-respostas hidden">
        <thead>
            <tr>
                <th class="cabecalho-tabela">ALUNO</th>
                <?php if (!empty($data["respostas_alunos"])) {
                        $questoes = array_keys(current($data["respostas_alunos"]));
                        foreach ($questoes as $questao) {
                            echo "<th class='cabecalho-tabela'><center>{$questao}</center></th>";
                        }
                    } ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data["respostas_alunos"])) {
                    foreach ($data["respostas_alunos"] as $aluno => $respostas) {
                        echo "<tr>";
                        echo "<td class='aluno-nome-respostas'>{$aluno}</td>";
                        foreach ($respostas as $resposta) {
                            if ($resposta == "ACERTOU") {
                                echo "<td class='alternativa-acerto'>{$resposta}</td>";
                            } else {
                                echo "<td class='alternativa-erro'>{$resposta}</td>";
                            }
                        }
                        echo "</tr>";
                    }
                } ?>
        </tbody>
    </table>

    <?php if (count($data["provas_turma"]) > 0) { ?>
    <button id="export-respostas" class="botao-exportar-dados hidden"
        onclick="exportToExcel('<?= 'RESPOSTAS - (' . $filtro_ . ') ' . $data['nome_prova'] ?>', 'table-respostas')">
        <i class="fas fa-file-export"></i> EXPORTAR DADOS RESPOSTAS
    </button>
    <?php } ?>
    <?php } ?>

    <table id="table-notas" class="tabela-notas-aluno">
        <thead>
            <tr>
                <th colspan="6" class="titulo-tabela-notas">
                    <center>
                        <h2 class="titulo-tabela-notas">NOTAS POR ALUNO</h2>
                    </center>
                </th>
            </tr>
            <tr>
                <th class="cabecalho-tabela">ALUNO</th>
                <th class="cabecalho-tabela">TURMA</th>
                <th class="cabecalho-tabela">P. ACERTOS</th>
                <th class="cabecalho-tabela">PONTOS</th>
                <th class="cabecalho-tabela">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data["provas_turma"] as $prova) { ?>
            <?php if($prova["status"] != "FALTOU"){ ?>
            <tr class="linha-nota-aluno <?= $prova['porcentagem'] >= 60 ? 'fundo-aprovado' : 'fundo-reprovado' ?>">
                <td><?= $prova["aluno"] ?></td>
                <td><?= $prova["turma"] ?></td>
                <td><?= number_format(($prova["acertos"] / $prova["QNT_perguntas"]) * 100, 0) ?>%</td>
                <td><?= $prova["NotaP"] ?> PONTOS</td>
                <td><?= $prova["status"] ?></td>
            </tr>
            <?php } else { ?>
            <tr class="linha-nota-faltou">
                <td><?= $prova["aluno"] ?></td>
                <td colspan="4">
                    <center>ALUNO FALTOU OU NÃO FEZ A PROVA</center>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>

    <?php if (count($data["provas_turma"]) > 0) { ?>
    <br>
    <button id="export-notas" class="botao-exportar-dados"
        onclick="exportToExcel('<?= 'NOTAS - (' . $filtro_ . ') ' . $data['nome_prova'] ?>', 'table-notas')">
        <i class="fas fa-file-export"></i> EXPORTAR DADOS NOTAS
    </button>
    <?php } ?>

    <div id="botoes-alternar-prova" class="hidden"></div>
    <div class="espaco-final"></div>
</main>