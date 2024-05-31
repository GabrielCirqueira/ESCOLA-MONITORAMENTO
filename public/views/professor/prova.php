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
            </div>  <br><br>
            <input type="hidden" name="id-prova" value="<?= $_POST["id-prova"] ?>">

            <select class="select-turmas-professor" name="turma" id="">

                <?php
                foreach ($data["turmas"] as $turma) { ?>
                    <option value="<?= $turma ?>"><?= $turma ?></option>
                <?php
                }
                ?>

            </select>
            <button class="button-professor-turma-enviar" name="filtrar" value="filtrar" type="submit">Filtrar</button>
 
        </center>
    </form>
    <h2><?= $data["turma"] ?></h2>

    <table class="tabela-prova-aluno">

        <thead>
            <tr>
                <th>ALUNO</th>
                <th>PONTOS</th>
                <th>ACERTOS</th>
                <th>P. ACERTOS</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($data["provas_turma"] as $prova) { ?>
                <tr>
                    <td><?= $prova["aluno"] ?></td>
                    <td><?= $prova["pontos_aluno"] ?></td>
                    <td><?= $prova["acertos"] ?></td>
                    <td><?= number_format(($prova["acertos"] / $prova["QNT_perguntas"]) * 100, 1) ?>%</td>
                </tr>

            <?php
            }

            ?>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</main>