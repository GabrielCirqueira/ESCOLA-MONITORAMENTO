<main class="conteudo-principal-area">
    <center>
        <h1 class="titulo-principal-nsl"><i class="fas fa-chart-line"></i> NSL - SISTEMA DE MONITORAMENTO</h1>
    </center>

    <div class="area-formulario-filtro">
        <form action="" method="post" class="formulario-filtro-graficos">
            <button class="botao-geral-filtrar" type="submit" name="geral" value="geral"><i class="fas fa-globe"></i> GERAL</button>

            <select name="professor" id="professor" class="selecao-filtro-professor">
                <option value="SELECIONAR">PROFESSOR</option>
                <?php foreach ($data["professores"] as $nome => $professor) {
                    $selected = ($data["filtros"]["professor"] ?? '') == $professor ? 'selected' : '';?>
                <option value="<?= $professor ?>" <?= $selected ?>><?= $professor ?></option>
                <?php } ?>
            </select>

            <select name="turma" id="turma" class="selecao-filtro-turma">
                <option value="SELECIONAR">TURMA</option>
                <?php foreach ($data["turmas"] as $key => $turma) {
                    $selected = ($data["filtros"]["turma"] ?? '') == $turma ? 'selected' : '';?>
                <option value="<?= $turma ?>" <?= $selected ?>><?= $turma ?></option>
                <?php } ?>
            </select>

            <select name="periodo" id="periodo" class="selecao-filtro-periodo">
                <option value="SELECIONAR">PERÍODO</option>
                <?php foreach ($data["periodos"] as $periodo) {
                    $selected = ($data["filtros"]["periodo"] ?? '') == $periodo["nome"] ? 'selected' : '';?>
                <option value="<?= $periodo["nome"] ?>" <?= $selected ?>><?= $periodo["nome"] ?></option>
                <?php } ?>
            </select>

            <button class="botao-filtro-detalhado" type="submit" value="filtrar"><i class="fas fa-filter"></i>
                FILTRAR</button>
        </form>
    </div>

    <?php if($data["statusFiltro"]){ ?>
    <div class="area-filtros-exibidos">
        <?php foreach($data["filtros"] as $nome => $value){ 
                if($nome != "turno" && $nome != "disciplina" && $value != NULL && $nome != "datas" ){ ?>
        <div class="filtro-exibido-item">
            <span class="nome-filtro-exibido"><i class="fas fa-tag"></i> <?= $nome?></span>
            <span class="valor-filtro-exibido"><?= $value?></span>
        </div>
        <?php }
        } ?>
    </div>
    <?php }?>

    <center>
    <h1 class="titulo-desempenho-escolar"><i class="fas fa-school"></i> DESEMPENHO ESCOLAR</h1>
    </center>

    <?php if($data["statusResultados"]){?>
    <div class="caixa-graficos-proficiencia">
        <div class="grafico-alunos-acima60">
            <?= $data["grafico60"] ?>
            <span class="titulo-grafico-acima60">ALUNOS ACIMA DE 60%</span>
        </div>

        <div class="barra-divisoria"></div>

        <div class="grafico-proeficiencia-detalhado">
            <?= $data["proeficiencia"] ?>
            <span class="titulo-grafico-proeficiencia">PROEFICIÊNCIA</span>
        </div>
    </div>

    <center>
    <h1 class="titulo-turmas-graficos"><i class="fas fa-chart-pie"></i> GRÁFICO TURMA(S)</h1>

    </center>
    <div class="area-turmas-graficos">
        <?php foreach($data["graficosTurmas"] as $nome => $grafico){ ?>
        <div class="grafico-turma-unica">
            <?= $grafico ?>
            <span><?= $nome ?></span>
        </div>
        <?php } ?>
    </div>

    <center>
    <h1 class="titulo-descritores-graficos"><i class="fas fa-chart-bar"></i> GRÁFICOS DESCRITORES</h1>

    </center>
    <div class="area-descritores-graficos">
        <?php foreach($data["descritores"] as $nome => $grafico){ ?>
        <div class="grafico-descritor-unico">
            <?= $grafico ?>
            <span><?= $nome ?></span>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    <div class="mensagem-sem-resultados">
        <p><i class="fas fa-exclamation-triangle"></i> NÃO FOI ENCONTRADO PROVAS PARA ESSES FILTROS!</p>
    </div>
    <?php } ?>
</main>