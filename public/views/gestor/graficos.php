<main class="main-home">
    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
    </center>

    <div class="form">
        <form action="gestor_home" method="post">
            <button type="submit" name="geral" value="geral">VISÃO GERAL</button>
            <label for="turma">Turma:</label>
            <select name="turma" id="turma">
                <option value="SELECIONAR">SELECIONAR</option>
                <?php foreach ($data["turmas"] as $turma) { ?>
                    <option value="<?= $turma["nome"] ?>"> <?= $turma["nome"] ?> </option>
                <?php } ?>
            </select>

            <label for="turno">Turno:</label>
            <select name="turno" id="turno">
                <option value="SELECIONAR">SELECIONAR</option>
                <?php foreach ($data["turnos"] as $turno) { ?>
                    <option value="<?= $turno ?>"> <?= $turno ?> </option>
                <?php } ?>
            </select>

            <label for="disciplina">Disciplina:</label>
            <select name="disciplina" id="disciplina">
                <option value="SELECIONAR">SELECIONAR</option>
                <?php foreach ($data["disciplinas"] as $disciplina) { ?>
                    <option value="<?= $disciplina["nome"] ?>"> <?= $disciplina["nome"] ?> </option>
                <?php } ?>
            </select>

            <label for="professor">Professor:</label>
            <select name="professor" id="professor">
                <option value="SELECIONAR">SELECIONAR</option>
                <?php foreach ($data["professores"] as $professor) { ?>
                    <option value="<?= $professor["nome"] ?>"> <?= $professor["nome"] ?> </option>
                <?php } ?>
            </select>

            <input type="submit" name="filtro" value="Filtrar">
        </form>
    </div>

    <br><br><br>

    <?php if (!$data["geral"]) { ?>
        <?php if (!$data["status"]) { ?>
            <?php foreach ($data["filtros"] as $filtro => $value) {
                if ($value != null) {
                    echo "<br>" . ucfirst($filtro) . ": " . $value . "<br>";
                }
            } ?>
            <h1>NÃO FORAM ENCONTRADOS RESULTADOS PARA ESSA CONSULTA!</h1>
        <?php } ?>
    <?php } else { ?>

        <h1>DESEMPENHO ESCOLAR GERAL</h1>
        <div class="gestor_desempenho_escola">
            <div class="rosca">
                <?= $data["roscaGeral"] ?>
                <h3>DESEMPENHO GERAL</h3>
            </div>
            <hr>
            <div>
                <?= $data["colunaGeral"] ?>
                <h3>PROEFICIÊNCIA</h3>
            </div>
        </div>

        <h1>DESEMPENHO TURNO</h1>
        <div class="gestor_area_turnos_geral">
            <?php foreach ($data["dados_turnos"] as $turno => $value) { ?>
                <center>
                    <h3><?= $turno ?></h3>
                </center>
                <div class="turno">
                    <div class="turno_rosca">
                        <?= $value[0] ?>
                        <center><h4>DESEMPENHO GERAL</h4></center>
                    </div>
                    <div class="turno_coluna">
                        <?= $value[1] ?>
                        <center><h4>PROEFICIÊNCIA</h4></center>
                    </div>
                </div>
            <?php } ?>
        </div>

        <h1>DESEMPENHO TURMAS</h1>
        <div class="gestor_area_turmas_geral">
            <?php foreach ($data["dadosturmas"] as $turma => $value) { ?>
                <div>
                    <?= $value ?>
                    <span><?= $turma ?></span>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</main>
