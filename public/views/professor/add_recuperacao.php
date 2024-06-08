<main class="height">
    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>ADICIONAR RECUPERAÇÃO</h2>
    </center>

    <form action="inserir_gabarito_rec" class="form-area-alunos-rec" method="post">

        <div class="professor-area-alunos-rec">
            <?php foreach ($data["alunos"] as $turma => $alunos) { ?>
                <h3><?= $turma ?></h3>
                <?php foreach ($alunos as $ra => $aluno) { ?>
                    <div class="professor-rec-aluno-checkbox">
                        <input type="checkbox" name="alunos[]" id="<?= $ra ?>" value="<?= $ra ?>"> <label for="<?= $ra ?>"><?= $aluno ?></label>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <div><br><br><br></div>

        <div class="professor-descritores">
                
                <H3>DESCRITORES:</H3>

                <div class="professor-descritores-marcar" >
                    <div><input type="radio" required name="descritores" value="sim"><span>SIM</span></div>
                    <div><input type="radio" required name="descritores" value="não"><span>NÃO</span></div>
                </div>
            </div>

            <div class="professor-campos">
                <div>
                    <label for="quantidade-perguntas">Quantidade de Questões:</label>
                    <input name="qtn-perguntas" required  id="quantidade-perguntas" type="number">
                </div>

            </div>





            <center>
                <input type="submit" value="Criar Gabarito de Recuperação" class="botao-form-enviar">
            </center>

    </form>
    <div><br><br><br><br><br><br></div>

</main>