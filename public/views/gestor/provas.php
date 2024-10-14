<main class="main-home-professor">
    <center>

        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1> 
    </center>
    <br>
 
    <div   class="form-filtros-gestor">
    <form id="filterFormProva" action="gestor_provas" method="post">
                <button   name="geral" class="button-vsGeral" onclick="resetFormProva()" value="geral">GERAL</button>
 
 
        <select name="disciplina" id="disciplina">
            <option value="SELECIONAR">DISCIPLINA</option>
            <?php foreach ($data["disciplinas"] as $disciplina) {
                $selected = ($data["filtros"]["disciplina"] ?? '') == $disciplina["nome"] ? 'selected' : '';
            ?>
                <option value="<?= $disciplina["nome"] ?>" <?= $selected ?>><?= $disciplina["nome"] ?></option>
            <?php } ?>
        </select>
 
        <select name="professor" id="professor">
            <option value="SELECIONAR">PROFESSOR</option>
            <?php foreach ($data["professores"] as $professor) {
                $selected = ($data["filtros"]["professor"] ?? '') == $professor["nome"] ? 'selected' : '';
            ?>
                <option value="<?= $professor["nome"] ?>" <?= $selected ?>><?= $professor["nome"] ?></option>
            <?php } ?>
        </select>

        <button class="fechar" onclick="resetFormProva()">Limpar</button>
        <input type="submit" name="filtro" value="Filtrar">
    </form>
</div>
<br><br>

<?php 
    if($data["geral"] == False){?>

        <h2>FILTROS</h2>
        <div class="filtros_exibir">
            <?php foreach ($data["filtros"] as $filtro => $value) {
                if ($value != NULL) { ?>
                    <div>
                        <h4 style="text-transform: uppercase;" > <?= $filtro ?> </h4>
                        <span> <?= $value ?> </span>
                    </div>
                <?php }
            }?>

        </div>

<?php }?>

    <?php
    $status = false;
    if ($data["status"] != False) {
        foreach ($data["provas"] as $prova) {
            $status = false;
            if ($data["provas_alunos"] != null) {
                foreach ($data["provas_alunos"] as $prova_aluno) {
                    if ($prova_aluno["id_prova"] == $prova["id"]) {
                        $status = true;
                    }
                }
            }
    ?>



            <div class="prova-pendente" style="width:85%" >
            <?php if($prova["metodo"] == "prova"){?>
                    <div class="linha-vertical-campo-prova" style="background-color: #eb7134;"></div>
                <div class="conteudo-prova">
                    <i class="fas fa-chart-bar fa-4x" style="color: #eb7134;"></i>
                    <?php }else{?>
                        <div class="linha-vertical-campo-prova" style="background-color: #BDE146;"></div>
                <div class="conteudo-prova">
                    <i class="fas fa-tasks fa-4x" style="color: #BDE146;"></i>
                    <?php }?>

                    <div class="prova-detalhes">
                        <center>
                        <span class="prova-nome-disciplina">
                                <?= $prova["nome_professor"] ?>
                            </span> <br>
                            <span class="prova-nome-disciplina">
                                <?= $prova["disciplina"] ?>
                            </span> <br>
                            <span class="prova-nome-disciplina">
                                <?= $prova["nome_prova"] ?>
                            </span> <br>
                            <span class="prova-nome-disciplina">
                                <?= $prova["data_prova"] ?>
                            </span> <br>
                            <span class="prova-nome-disciplina">
                                <?= str_replace(","," - ",$prova["turmas"]) ?>
                            </span> <br>
                        </center>
                    </div>

                    <?php if ($status == true) { ?>
                        <form method="post" action="gestor_prova">
                            <button type="submit" value="<?= $prova['id'] ?>" name="id-prova" class="botao-ver-relatorio">Relatório</button>
                        </form>
                    <?php } else { ?>
                        <button class="botao-ver-relatorio">Sem Dados</button>
                    <?php } ?>
                </div>
            </div><br>

        <?php } ?>
        <div><br><br><br><br><br><br><br><br><br></div>
        <div><br><br><br><br><br><br><br><br><br></div>
        <?php } else { ?>
        <div class="height">
            <center>
                <h1>SEM DADOS !</h1>
                <h2>Nenhuma prova inserida !</h2>
            </center>
        </div>
    <?php } ?>

</main>