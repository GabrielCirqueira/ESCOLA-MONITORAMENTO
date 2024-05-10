<main class="main-home-professor">
    <section>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>INSERIR GABARITO</h2>

        <form action="criar_gabarito" method="post">
            <div class="nome_prova">
                <label for="nome-prova">Insira o Nome da prova</label>
                <input type="text" id="nome-prova" name="nome-prova">
            </div>
            <div class="turmas-container">
                <h3 class="professor-titulo-turno">TURMAS INTERMEDIÁRIO</h3>
                <div class="professor-area-turmas">
                    <?php foreach ($data as $turma) {
                        if ($turma["turno"] == "INTERMEDIÁRIO") { ?>
                            <div>
                                <input name="gabarito-turmas[]" type="checkbox" value="<?php echo $turma["nome"] ?>">
                                <span><?php echo $turma["nome"] ?></span>
                            </div>
                        <?php }
                    } ?>
                </div>

                <h3 class="professor-titulo-turno">TURMAS VESPERTINO</h3>
                <div class="professor-area-turmas">
                    <?php foreach ($data as $turma) {
                        if ($turma["turno"] == "VESPERTINO") { ?>
                            <div>
                                <input name="gabarito-turmas[]" type="checkbox" value="<?php echo $turma["nome"] ?>">
                                <span><?php echo $turma["nome"] ?></span>
                            </div>
                        <?php }
                    } ?>
                </div>

            </div>

            <div class="disciplinas-gabarito-professor">
                <h3>SELECIONE A DISCIPLINA CORRESPONDENTE:</h3>
                <div class="professor-area-disciplinas">
                    <?php 
                    if(strpos($_SESSION["disciplinas"],";")){
                        $materias = explode(";",$_SESSION["disciplinas"]);
                        foreach ($materias as $materia) { ?>
                        <div>
                            <input type="radio" name="Materias-professor-gabarito" value="<?php echo $materia?>"><span><?php echo $materia?></span>
                            </div>
                        <?php }
                    }else{ ?>
                        <div>
                        <input type="radio" name="Materias-professor-gabarito" value="<?php echo $_SESSION["disciplinas"]?>"><span><?php echo $_SESSION["disciplinas"]?></span>
                        </div>
                    <?php }?>
                </div>
            </div>

            <div class="professor-campos">
                <div>
                    <label for="quantidade-perguntas">Quantidade de Questões:</label>
                    <input name="qtn-perguntas" id="quantidade-perguntas" type="number">
                </div>
                <div>
                    <label for="valor">Valor:</label>
                    <input name="valor-prova" id="valor" type="number">
                </div>
            </div>
            <center>
                <input type="submit" value="Criar Gabarito" class="botao-form-enviar">
            </center>
            <br><br><br>
            <br><br><br>
            <br><br><br>
            <br><br><br>
            <br><br><br>
        </form>
    </section>
</main>