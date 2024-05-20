<main class="main-home-professor">
    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2> <?= $data["nome_prova"] ?></h2>
    </center>

    <h3>Classificar por:</h3>
    <div class="buttons-professor">
        <form action="relatorio_prova" method="post">
                    <input type="hidden" name="id-prova" value="<?= $_POST["id-prova"] ?>">
            <button class="button-professor-turma" name="turma-filtros" value="geral" type="submit">Desempenho Geral</button>
            <?php
            foreach ($data["dados_turma"] as $turma) { ?>
                <div>
                    <button class="button-professor-turma" name="turma-filtros" value="<?= $turma["turma_nome"] ?>" type="submit"><?= $turma["turma_nome"] ?></button>
                </div>
            <?php
            }
            ?>

        </form>
    </div>

    <?php if($data["filtro"] == false){ ?>
    <h3>Desempenho total das turmas</h3>
    <div class="graficos-professor-rosca">
        <?php
        foreach ($data["dados_turma"] as $turma) { ?>
            <div>
                <?= $turma["grafico"] ?>
                <span><?= $turma["turma_nome"] ?></span>
            </div>
        <?php
        }
        ?>
    </div>
    <br><br>
    <div class="professor-grafico-geral-60">
        <div>
            <h3>Percentual geral:</h3>
            <span><?= $data["media_geral_porcentagem"] ?></span>
        </div>
        <hr>
        <div>
            <h3>alunos acima de 60%:</h3>
            <span><?= $data["porcentagem_geral_acima_60"] ?></span>
        </div>
    </div>

    <h2>PERCENTUAL DOS DESCRITORES</h2>

    <div class="area-graficos-descritores">

        <?php if ($data["descritores"] == false) { ?>
            <h1>A prova não tem descritores!</h1>
            <?php } else {
            foreach ($data["percentual_descritores"] as $descritor => $grafico) { ?>
                <div>

                    <?= $grafico ?>
                    <h4><?= $descritor ?></h4>
                </div>

        <?php
            }
        } ?>
    </div>

    <?= $data["grafico_colunas"]?>
<br><br>

<?php }else{?>
    <h3>Desempenho <?= $data["dados_turma_grafico"]["nome"]?></h3>
    <div class="graficos-professor-rosca">
  
    </div>
    <br><br>
    <div class="professor-grafico-geral-60">
        <div>
            <h3>Percentual geral:</h3>
            <span><?= $data["dados_turma_grafico"]["percentual_turma"] ?></span>
        </div>
        <hr>
        <div>
            <h3>alunos acima de 60%:</h3>
            <span><?= $data["dados_turma_grafico"]["percentual_turma_60"] ?></span>
        </div>
    </div>

    <h2>PERCENTUAL DOS DESCRITORES</h2>

    <div class="area-graficos-descritores">

        <?php if ($data["descritores"] == false) { ?>
            <h1>A prova não tem descritores!</h1>
            <?php } else {
            foreach ($data["dados_turma_grafico"]["descritores"] as $descritor => $grafico) { ?>
                <div>

                    <?= $grafico ?>
                    <h4><?= $descritor ?></h4>
                </div>

        <?php
            }
        } ?>
    </div>

    <?= $data["dados_turma_grafico"]["grafico_coluna"]?>    
<?php }?>
</main>