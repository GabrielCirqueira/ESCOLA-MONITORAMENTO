<main class="main-home-professor ">
    <center>

        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>PROVAS - <?= $_SESSION["nome_professor"] ?></h2>
    </center>
    <br>
    <?php
    $status = false;
    if($data != NULL){
    foreach ($data["provas"] as $prova) {
        $contador = 0;
        if ($data["provas_alunos"] != null) {

            foreach ($data["provas_alunos"] as $P_aluno) {
                if ($P_aluno["id_prova"] == $prova["id"]) {
                    $contador++;
                }
            }
        }

        if ($data["provas_alunos"] != null) {
            foreach ($data["provas_alunos"] as $prova_aluno) {
                if ($prova_aluno["id_prova"] == $prova["id"]) {
                    $status = true;
                }
            }
        }

        ?>


        <div   class="prova-pendente">
            <div class="linha-vertical-campo-prova" style="background-color: #04C636;"></div>
            <div class="conteudo-prova">
                <i class="fas fa-file-alt fa-4x" style="color: #04C636;"></i>

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
                    <div class="div_editar_ver_prova" >
                    <form method="post" action="editar_prova">
                        <button type="submit" value="<?= $prova['id'] ?>" name="id-prova" class="botao-form-editar"><i class="fas fa-pencil-alt"></i></button>
                    </form>
                    <form method="post" action="prova">
                        <button type="submit" value="<?= $prova['id'] ?>" name="id-prova" class="botao-form-enviar-prova">Ver</button>
                    </form>
                    </div>

                <?php } else { ?>
                    <button class="botao-ver-relatorio">Sem Dados</button>
                <?php } ?>
            </div>
        </div><br>

    <?php }
    }else{ ?>
    <div class="height">
        <center>
            <h1>SEM DADOS !</h1>
            <h2>Você não inseriu nenhuma prova !</h2>
        </center>
        </div>
    <?php } ?>
 
<div><br><br><br></div>
</main>