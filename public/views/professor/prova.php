<main class="main-home-professor">
    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2> <?= $data["nome_prova"] ?></h2>
    </center>

    <form method="post" action="">
        <center>
            <div class="alternar-liberar-gabarito">
                <span>Aluno pode ver o resultado?</span>
                <?php if ($data["liberado"] == "SIM") { ?>

                    <button type="submit" name="status" value="sim" class="button-prova-liberado" style="background-color: #0394b9;">SIM</button>
                    <button type="submit" name="status" value="não" class="button-prova-liberado">NÃO</button>
                <?php } else { ?>
                    <button type="submit" name="status" value="sim" class="button-prova-liberado">SIM</button>
                    <button type="submit" name="status" value="não" class="button-prova-liberado" style="background-color: #0394b9;">NÃO</button>

                <?php } ?>
            </div> <br><br>
            <input type="hidden" name="id-prova" value="<?= $_POST["id-prova"] ?>">


        </center>
    </form>

    <div class="detalhes-prova">
        <table style="width: 360px;">
            <th style="text-align: center;" colspan="2">DETALHES PROVA</th>

            <tr>
                <td>VALOR</td>
                <td><?= $data["prova"]["valor"] ?> Pontos</td>
            </tr>
            <tr>
                <td>PERGUNTAS</td>
                <td><?= $data["prova"]["QNT_perguntas"] ?> Questões</td>
            </tr>
            <tr>
                <th style="text-align: center;" colspan="2">TURMAS</th>
            </tr>
            <?php
            $turmas = explode(",", $data["prova"]["turmas"]);
            $turmaCount = count($turmas);
            for ($i = 0; $i < $turmaCount; $i += 2) { ?>
                <tr>
                    <td style="background-color: #E9E9E9;">
                        <?= $turmas[$i] ?>
                    </td>
                    <td style="background-color: #E9E9E9;">
                        <?= isset($turmas[$i + 1]) ? $turmas[$i + 1] : '' ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <?php
    if ($data["provas_rec"] != NULL) { ?>
        <center>
            <div class="area_provas_rec_professor">
                <h3>Essa prova tem <?= $data["provas_rec"]["quantidade"] ?> recuperação </h3>
                <form action="prova_recuperacao" method="post">
                    <?php
                    for ($i = 0; $i < $data["provas_rec"]["quantidade"]; $i++) { ?>
                        <button name="prova" value="<?= $data["provas_rec"]["provas"][$i]["id"] ?>"><?= $i + 1 ?>ª Recuperação</button>
                        <br>
                    <?php }
                    ?>
                </form>
            </div>
        </center>
    <?php } ?>

    <form action="add_recuperacao" method="post">
        <input type="hidden" name="id-prova" value="<?= $_POST["id-prova"] ?>">
        <button type="submit" class="button-add-recp">ADICIONAR RECUPERAÇÃO</button>
    </form>


    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</main>