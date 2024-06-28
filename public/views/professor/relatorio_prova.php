<?php
$filtro_ = $data["filtro"] == false ? "GERAL" : $data["dados_turma_grafico"]["nome"];
if($data["descritores_alunos"] != NULL){
    $Qdescritores = count($data["descritores_alunos"]["descritores"]) + 1; 
}
?>

<main class="main-home-professor">
    <center>
        <h1 data-aos="fade-up" class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2 data-aos="fade-up"><?= $data["nome_prova"] ?></h2>
    </center>

    <h3 data-aos="fade-up">Classificar por:</h3>
    <div data-aos="fade-up" class="buttons-professor">
        <form action="relatorio_prova" method="post">
            <input type="hidden" name="id-prova" value="<?= $_POST["id-prova"] ?>">
            <button data-aos="fade-up" class="button-professor-turma" name="turma-filtros" value="geral" type="submit">Desempenho Geral</button>
            <select data-aos="fade-up" name="turma-filtros" id="">
                <?php foreach ($data["dados_turma"] as $turma) { ?>
                    <option value="<?= $turma["turma_nome"] ?>"><?= $turma["turma_nome"] ?></option>
                <?php } ?>
            </select>
            <button data-aos="fade-up" class="button-professor-turma-enviar" name="filtrar" value="filtrar" type="submit">Filtrar</button>
        </form>
    </div>

    <?php if ($data["filtro"] == false) { ?>

        <h1 data-aos="fade-up">DESEMPENHO GERAL</h1>

        <br><br>
        <div data-aos="fade-up" class="professor-grafico-geral-60">
            <div>
                <h3>Percentual geral:</h3>
                <span><?= $data["media_geral_porcentagem"] ?></span>
            </div>
            <hr>
            <div>
                <h3>Alunos acima de 60%:</h3>
                <span><?= $data["porcentagem_geral_acima_60"] ?></span>
            </div>
        </div>

        <h2 data-aos="fade-up">PERCENTUAL DOS DESCRITORES</h2>

        <div data-aos="fade-up" class="area-graficos-descritores">
            <?php if ($data["descritores"] == false) { ?>
                <h1>A prova não tem descritores!</h1>
                <?php } else {
                foreach ($data["percentual_descritores"] as $descritor => $grafico) { ?>
                    <div data-aos="fade-up">
                        <?= $grafico ?>
                        <h4><?= $descritor ?></h4>
                    </div>
            <?php }
            } ?>
        </div>

        <h3 data-aos="fade-up">Nível de proficiência</h3>
        <div data-aos="fade-up">
            <?= $data["grafico_colunas"] ?>

        </div>
        <br><br>

        <h3 data-aos="fade-up">Desempenho total das turmas</h3>
        <div data-aos="fade-up" class="graficos-professor-rosca-turmas">
            <?php foreach ($data["dados_turma"] as $turma) { ?>
                <div data-aos="fade-up">
                    <?= $turma["grafico"] ?>
                    <span><?= $turma["turma_nome"] ?></span>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <h3 data-aos="fade-up">Desempenho <?= $data["dados_turma_grafico"]["nome"] ?></h3>
        <div data-aos="fade-up" class="graficos-professor-rosca">
        </div>
        <br><br>
        <div data-aos="fade-up" class="professor-grafico-geral-60">
            <div>
                <h3>Percentual geral:</h3>
                <span><?= $data["dados_turma_grafico"]["percentual_turma"] ?></span>
            </div>
            <hr>
            <div>
                <h3>Alunos acima de 60%:</h3>
                <span><?= $data["dados_turma_grafico"]["percentual_turma_60"] ?></span>
            </div>
        </div>

        <h2 data-aos="fade-up">PERCENTUAL DOS DESCRITORES</h2>

        <div data-aos="fade-up" class="area-graficos-descritores">
            <?php if ($data["descritores"] == false) { ?>
                <h1>A prova não tem descritores!</h1>
                <?php } else {
                foreach ($data["dados_turma_grafico"]["descritores"] as $descritor => $grafico) { ?>
                    <div data-aos="fade-up">
                        <?= $grafico ?>
                        <h4><?= $descritor ?></h4>
                    </div>
            <?php }
            } ?>
        </div>

        <h3 data-aos="fade-up">Nível de Proficiência</h3>
        <?= $data["dados_turma_grafico"]["grafico_coluna"] ?>
    <?php } ?>

<div><br><br><br><br></div>
    <?php if($data["descritores_alunos"] != NULL){ ?>
    <div class="area_button_tabelas">
        <button onclick="mostarTabela('DESCRITORES')" >DESCRITORES POR ALUNOS</button>
        <button onclick="mostarTabela('NOTAS')" >NOTAS ALUNOS</button>
    </div>
    
    <?php if($data["descritores_alunos_rec"] != NULL){ ?>
        <div id="botoes-alternar-prova" class=" hidden" >
        <button onclick="mostarTabela('DESCRITORES')" >1º PROVA</button>
        <button onclick="mostarTabela('REC')" >RECUPERAÇÃO</button>
    </div>

    <table id="table-descritores-rec" class="tabela-prova-aluno hidden">
        <thead>
            <tr>
                <th colspan="<?= count($data["descritores_alunos_rec"]["descritores"]) + 1 ?>">
                    <center>
                        <h2 style="margin: 3px;">DESCRITORES ALUNOS RECUPERAÇÃO</h2>
                    </center>
                </th>
            </tr>
            <tr>
                <th>ALUNO</th>
                <?php foreach ($data["descritores_alunos_rec"]["descritores"] as $indice => $value) {
                    echo "<th><center>{$indice} {$value}</center></th>";
                } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data["descritores_alunos_rec"]["ALUNOS"] as $aluno => $perguntas ) { ?>
            <tr>
                <td style="background-color: #B4F1E7;" > <?= $aluno ?> </td>
                <?php 
                foreach($perguntas as $pergunta => $value){?>
                <?php 
                if($value == "ACERTOU"){
                    echo "<td class='alternativa-marcada-true' >$value</td>";
                }else{
                    echo "<td class='alternativa-marcada-false' >$value</td>";
                }
                ?> 
                <?php }?>
            </tr>
            <?php 
        } ?>
        </tbody>
    </table>

    <?php } ?>

    <table id="table-descritores-primeira" class="tabela-prova-aluno hidden">
        <thead>
            <tr>
                <th colspan="<?= $Qdescritores?>">
                    <center>
                        <h2 style="margin: 3px;">DESCRITORES ALUNOS</h2>
                    </center>
                </th>
            </tr>
            <tr>
                <th>ALUNO</th>
                <?php foreach ($data["descritores_alunos"]["descritores"] as $indice => $value) {
                    echo "<th><center>{$indice} {$value}</center></th>";
                } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data["descritores_alunos"]["ALUNOS"] as $aluno => $perguntas ) { ?>
            <tr>
                <td style="background-color: #B4F1E7;" > <?= $aluno ?> </td>
                <?php 
                foreach($perguntas as $pergunta => $value){?>
                        <?php 
                if($value == "ACERTOU"){
                    echo "<td class='alternativa-marcada-true' >$value</td>";
                }else{
                    echo "<td class='alternativa-marcada-false' >$value</td>";
                }
                ?> 
                <?php }?>
            </tr>
            <?php 
        } ?>
        </tbody>
    </table>
    <?php } ?>

    <table id="table-notas" data-aos="fade-up" class="tabela-prova-aluno">
        <thead>
            <tr>
                <th colspan="6">
                    <center>
                        <h2 style="margin: 3px;">NOTAS POR ALUNO</h2>
                    </center>
                </th>
            </tr>
            <tr>
                <th>ALUNO</th>
                <th>TURMA</th>
                <th>PONTOS</th>
                <th>PONTOS REC</th>
                <!-- <th>ACERTOS</th>
                <th>P. ACERTOS</th> -->
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data["provas_turma"] as $prova) { ?>
                <tr>
                    <td><?= $prova["aluno"] ?></td>
                    <td><?= $prova["turma"] ?></td>
                    <td><?= $prova["NotaP"] ?></td>
                    <!-- <td><?= $prova["acertos"] ?></td>
                    <td><?= number_format(($prova["acertos"] / $prova["QNT_perguntas"]) * 100, 1) ?>%</td> -->
                    <td><?= $prova["notaRec"] ?></td>
                    <td><?= $prova["status"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php if (count($data["provas_turma"]) > 0) { ?>
        <button data-aos="fade-up" class="export-excel" onclick="exportToExcel('<?= '(' . $filtro_ . ') ' . $data['nome_prova'] ?>')">EXPORTAR DADOS</button>
    <?php } ?>
    <div id="botoes-alternar-prova" class=" hidden" >
    </div>
    <div><br><br><br><br><br><br><br><br></div>
</main>