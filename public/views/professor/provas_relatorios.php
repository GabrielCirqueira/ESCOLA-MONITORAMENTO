<main class="main-home-professor height">
    <center>

        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>PROVAS - <?= $_SESSION["nome_professor"] ?></h2>
    </center>
    <br>
    <?php
    $status = false; 
    foreach ($data["provas"] as $prova) {
        $status = false; 
        if($data["provas_alunos"] != null){ 
            foreach($data["provas_alunos"] as $prova_aluno){
                if($prova_aluno["id_prova"] == $prova["id"]){
                    $status = true; 

                }
            }
        } 
    ?>


        <div class="prova-pendente">
            <div class="linha-vertical-campo-prova" style="background-color: #eb7134;"></div>
            <div class="conteudo-prova">
                <i class="fas fa-chart-bar fa-4x" style="color: #eb7134;"></i>

                <div class="prova-detalhes">
                    <center>

                        <span class="prova-nome-disciplina">
                            <?= $prova["nome_prova"] ?>
                        </span> <br>
                        <span class="prova-nome-disciplina">
                            <?= $prova["data_prova"] ?>
                        </span> <br>
                    </center>
                </div>

                <?php if($status == true){?>
                <form method="post" action="relatorio_prova">
                    <button type="submit" value="<?= $prova['id'] ?>" name="id-prova" class="botao-ver-relatorio">Relatorio</button>
                </form>
                <?php }else{?>
                    <button class="botao-ver-relatorio">Sem Dados</button>
                <?php }?>
            </div>
        </div><br>

    <?php } ?>


</main>