<main class="main-home-professor">
    <section>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>INSERIR GABARITO</h2>

        <form action="gabarito" method="post">
            <div class="turmas-container">

                <h3 class="professor-titulo-turno">TURMAS INTERMEDIÁRIO</h3>
                <div class="professor-area-turmas">
                    <?php foreach ($data as $turma) {
                        if ($turma["turno"] == "INTERMEDIÁRIO") { ?>
                            <div>
                                <input type="checkbox" value="<?php echo $turma["id"] ?>">
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
                                <input type="checkbox" value="<?php echo $turma["id"] ?>">
                                <span><?php echo $turma["nome"] ?></span>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>

            <div class="professor-campos">
                <div>
                    <label for="quantidade-perguntas">Quantidade de perguntas:</label>
                    <input id="quantidade-perguntas" type="number">
                </div>
                <div>
                    <label for="valor">Valor:</label>
                    <input id="valor" type="number">
                </div>
            </div>
            <center>
                <input type="submit" value="Criar gabarito" class="botao-form-enviar">
            </center>
            <br><br><br>
        </form>
    </section>
</main>