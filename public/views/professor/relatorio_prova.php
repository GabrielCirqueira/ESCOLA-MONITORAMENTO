<?php 
$filtro_ = $data["filtro"] == false ? "GERAL" : $data["dados_turma_grafico"]["nome"]; 
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

    <?php if($data["filtro"] == false){ ?>
        
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
        
        <h3 data-aos="fade-up">Nível de Proficiência</h3>
        <div data-aos="fade-up">
        <?= $data["grafico_colunas"]?>

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
        <h3 data-aos="fade-up">Desempenho <?= $data["dados_turma_grafico"]["nome"]?></h3>
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
        <?= $data["dados_turma_grafico"]["grafico_coluna"]?>    
    <?php } ?>

    <h2 data-aos="fade-up">NOTAS POR ALUNO</h2>
    <table data-aos="fade-up" class="tabela-prova-aluno">
        <thead>
            <tr>
                <th>ALUNO</th>
                <th>TURMA</th>
                <th>PONTOS</th>
                <th>ACERTOS</th>
                <th>P. ACERTOS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data["provas_turma"] as $prova) { ?>
                <tr >
                    <td><?= $prova["aluno"] ?></td>
                    <td><?= $prova["turma"] ?></td>
                    <td><?= $prova["pontos_aluno"] ?></td>
                    <td><?= $prova["acertos"] ?></td>
                    <td><?= number_format(($prova["acertos"] / $prova["QNT_perguntas"]) * 100, 1) ?>%</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php if(count($data["provas_turma"]) > 0){ ?>
        <button data-aos="fade-up" class="export-excel" onclick="exportToExcel('<?=  '(' . $filtro_ . ') ' .$data['nome_prova']?>')">EXPORTAR DADOS</button>
    <?php } ?>

    <div><br><br><br><br><br><br><br><br></div>
</main>