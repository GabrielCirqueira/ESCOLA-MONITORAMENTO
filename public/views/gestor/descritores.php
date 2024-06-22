<main class="main-home">
    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
    </center>

    <div class="form-filtros-gestor">
        <form id="filterFormDesc" action="gestor_descritores" method="post">
            <button class="button-vsGeral" onclick="resetFormDesc()">GERAL</button>

            <select name="turma" id="turma">
                <option value="SELECIONAR">TURMA</option>
                <?php foreach ($data["turmas"] as $turma) {
                    $selected = ($data["filtros"]["turma"] ?? '') == $turma["nome"] ? 'selected' : '';
                ?>
                    <option value="<?= $turma["nome"] ?>" <?= $selected ?>><?= $turma["nome"] ?></option>
                <?php } ?>
            </select>

            <select name="turno" id="turno">
                <option value="SELECIONAR">TURNO</option>
                <?php foreach ($data["turnos"] as $turno) {
                    $selected = ($data["filtros"]["turno"] ?? '') == $turno ? 'selected' : '';
                ?>
                    <option value="<?= $turno ?>" <?= $selected ?>><?= $turno ?></option>
                <?php } ?>
            </select>

            <select name="disciplina" id="disciplina">
                <option value="SELECIONAR">DISCIPLINA</option>
                <?php
                foreach ($data["disciplinas"] as $disciplina) {
                    $selected = ($data["filtros"]["disciplina"] ?? '') == $disciplina ? 'selected' : '';
                ?>
                    <option value="<?= $disciplina ?>" <?= $selected ?>><?= $disciplina ?></option>
                <?php } ?>
            </select>

            <select name="serie" id="serie">
                <option value="SELECIONAR">SÉRIE</option>
                <?php
                $selected_1 = ($data["filtros"]["serie"] ?? '') == '1' ? 'selected' : '';
                $selected_2 = ($data["filtros"]["serie"] ?? '') == '2' ? 'selected' : '';
                $selected_3 = ($data["filtros"]["serie"] ?? '') == '3' ? 'selected' : '';
                $desc = $data["descritor"] != false ? $data["descritor"] : "";
                ?>
                <option value="1" <?= $selected_1 ?>>1º Série</option>
                <option value="2" <?= $selected_2 ?>>2º Série</option>
                <option value="3" <?= $selected_3 ?>>3º Série</option>
            </select>
            <div class="descritor-pesquisar-grafico">
                <input type="text" class="searchInput" value="<?= $desc ?>" data-index="0" name="DESCRITOR" id="descritor" placeholder="DESCRITOR">
                <div class="descritoresContainer" data-index="0"></div>
            </div>
            <button class="fechar" onclick="resetFormDesc()">Limpar</button>
            <input type="submit" name="filtro" value="Filtrar">
        </form>
    </div>

    <?php if ($data["geral"]) { ?>

        <h2> DESEMPENHO GERAL DESCRITORES</h2>

        <div class="area-descritores-cores">

            <div class="descritores-cor">
                <div style="background-color:#FF6B6B ;"></div>
                <span>Abaixo do Básico
                </span>
            </div>

            <div class="descritores-cor">
                <div style="background-color:#FFA63D ;"></div>
                <span>Básico
                </span>
            </div>

            <div class="descritores-cor">
                <div style="background-color:#D4FF3B ;"></div>
                <span>Médio</span>
            </div>

            <div class="descritores-cor">
                <div style="background-color:#44C548 ;"></div>
                <span>Avançado</span>
            </div>

        </div>
        <div><br><br><br></div>
        <div class="area-descritores">
            <?php foreach ($data["descritores"] as $descritor => $value) { ?>

                <?= $value["proeficiencia"] ?>

            <?php } ?>
        </div>

    <?php } else { ?>
        <h2>FILTROS</h2>
        <div class="filtros_exibir">
            <?php foreach ($data["filtros"] as $filtro => $value) {
                if ($value != NULL) { ?>
                    <div>
                        <h4> <?= $filtro ?> </h4>
                        <?php if ($filtro == "serie") { ?>
                            <span> <?= $value ?>º Série </span>
                        <?php } else { ?>
                            <span> <?= $value ?> </span>
                        <?php } ?>
                    </div>
                <?php }
            }
            if ($data["descritor"] != false) { ?>
                <div>
                    <h4>DESCRITOR</h4>
                    <span> <?= $data["descritor"] ?> </span>
                </div>
            <?php
            } ?>

        </div>

        <div class="area-descritores-cores">

            <div class="descritores-cor">
                <div style="background-color:#FF6B6B ;"></div>
                <span>Abaixo do Básico</span>
            </div>

            <div class="descritores-cor">
                <div style="background-color:#FFA63D ;"></div>
                <span>Básico</span>
            </div>

            <div class="descritores-cor">
                <div style="background-color:#D4FF3B ;"></div>
                <span>Médio</span>
            </div>

            <div class="descritores-cor">
                <div style="background-color:#44C548 ;"></div>
                <span>Avançado</span>
            </div>

        </div>

        <div class="area-descritores">
            <?php
            $exibir = false;
            foreach ($data["descritores"] as $descritor => $value) {
                if ($data["descritor"] == false) {

                    $exibir = True;
            ?>
                    <?= $value["proeficiencia"] ?>
                    <?php } else {
                    if ($descritor == $data["descritor"]) {
                        $exibir = True;
                    ?>
                        <?= $value["proeficiencia"] ?>
                <?php
                    }
                }
            } ?>
 
        </div>
    <?php }
               if ($exibir == false) { ?>

                <div>
                    <h2>NÃO FORAM ENCOTRADOS RESULTADOS PARA SUA BUSCA!</h2>
                </div>
            <?php } ?> 

    <div><br><br><br><br><br></div>
    <div><br><br><br><br><br></div>
    <div><br><br><br><br><br></div>
    <div><br><br><br><br><br></div>

</main>