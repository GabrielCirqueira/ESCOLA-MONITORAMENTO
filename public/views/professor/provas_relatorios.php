<main class="main-home-professor">
    <center>

        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>RELATÓRIOS - <?= $_SESSION["nome_professor"] ?></h2>
    </center>
    <br>
    <?php
    $status = false;
    if ($data != NULL) {
        foreach ($data["provas"] as $periodo => $provas) {?>
            <details class="periodo-provas" >
                <summary> <?=$periodo?> </summary>
        <?php
        foreach($provas as $prova){
            $status = false;
            if ($data["provas_alunos"] != null) {
                foreach ($data["provas_alunos"] as $prova_aluno) {
                    if ($prova_aluno["id_prova"] == $prova["id"]) {
                        $status = true;
                    }
                }
            }
            
            $contador = 0;

            foreach ($data["provas_alunos"] as $P_aluno) {
                if ($P_aluno["id_prova"] == $prova["id"]) {
                    $contador++;
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
                                <?= $prova["nome_prova"] ?>
                            </span> <br>
                            <span class="prova-nome-disciplina">
                                <?= $prova["data_prova"] ?>
                            </span> <br>
                            <span class="prova-nome-professor">
                            <?= $contador ?> aluno(s) Fizeram a prova.
                        </span>
                        </center>
                    </div>

                    <?php if ($status == true) { ?>
                        <form method="post" action="relatorio_prova">
                            <button type="submit" value="<?= $prova['id'] ?>" name="id-prova" class="botao-ver-relatorio">Relatorio</button>
                        </form>
                    <?php } else { ?>
                        <button class="botao-ver-relatorio">Sem Dados</button>
                    <?php } ?>
                </div>
            </div><br>

            <?php } ?>
        </details>
        <?php }
     ?>
    <div><br><br><br><br><br><br><br><br><br></div>
    <div><br><br><br><br><br><br><br><br><br></div>
    <?php } else { ?>
    <div class="height">
        <center>
            <h1>SEM DADOS !</h1>
            <h2>Você não inseriu nenhuma prova !</h2>
        </center>
        </div>
    <?php } ?>
 
<div><br><br><br></div>
</main>