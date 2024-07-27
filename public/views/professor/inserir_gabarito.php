<main class="main-home-professor">
    <center>
        <h1 data-aos="fade-up" class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
    </center>

    <h2 data-aos="fade-up">INSERIR GABARITO</h2>

    <form action="criar_gabarito" method="post" data-aos="fade-up">
        <div class="nome_prova">
            <label for="nome-prova">Insira o Nome da Prova</label>
            <input type="text" maxlength="25" required id="nome-prova" name="nome-prova">
        </div>

        <div class="professor-descritores" data-aos="fade-up">
            <h3>DESCRITORES:</h3>

            <div class="radio-group">
                    <div>

                        <input type="radio" required id="descritores_sim" name="descritores" value="sim">
                        <label style="width: 150px;" for="descritores_sim">SIM</label>

                        <input type="radio" required name="descritores" id="descritores_nao" value="não">
                        <label style="width: 150px;" for="descritores_nao">NÃO</label>
                    </div>
            </div>
        </div>

        <div class="turmas-container" data-aos="fade-up">
            <h3 class="professor-titulo-turno">TURMAS INTERMEDIÁRIO</h3>

            <div class="professor-area-turmas">
                <?php foreach ($data as $turma) {if ($turma["turno"] == "INTERMEDIÁRIO") {?>
                <div>
                    <input name="gabarito-turmas[]" id="<?=$turma["nome"]?>" type="checkbox"
                        value="<?=$turma["nome"]?>">
                    <label for="<?=$turma["nome"]?>"><?=$turma["nome"]?></label>
                </div>
                <?php }}?>
            </div>

            <h3 class="professor-titulo-turno">TURMAS VESPERTINO</h3>
            <div class="professor-area-turmas">
                <?php foreach ($data as $turma) {if ($turma["turno"] == "VESPERTINO") {?>
                <div>
                    <input name="gabarito-turmas[]" id="<?=$turma["nome"]?>" type="checkbox"
                        value="<?=$turma["nome"]?>">
                    <label for="<?=$turma["nome"]?>"><?=$turma["nome"]?></label>
                </div>
                <?php }}?>
            </div>
        </div>

        <div class="disciplinas-gabarito-professor" data-aos="fade-up">
            <h3>SELECIONE A DISCIPLINA CORRESPONDENTE:</h3>
            <div class="radio-group">
                <?php
if (strpos($_SESSION["disciplinas"], ";")) {?>

                <div>
                    <?php $materias = explode(";", $_SESSION["disciplinas"]);
    foreach ($materias as $materia) {?>
                    <input type="radio" name="Materias-professor-gabarito" id="<?=$materia?>" required
                        value="<?=$materia?>">
                    <label for="<?=$materia?>"><?=$materia?></label>

                    <?php }?>
                </div>

                <?php } else {?>
                <div>
                    <input type="radio" name="Materias-professor-gabarito" id="<?=$_SESSION["disciplinas"]?>" required
                        value="<?=$_SESSION["disciplinas"]?>">
                    <label for="<?=$_SESSION["disciplinas"]?>"><?=$_SESSION["disciplinas"]?></label>

                </div>
                <?php }?>
            </div>
        </div>

        <div class="professor-campos" data-aos="fade-up">
            <div>
                <label for="quantidade-perguntas">Quantidade de Questões:</label>
                <input name="qtn-perguntas" required id="quantidade-perguntas" type="number">
            </div>
            <div>
                <label for="valor">Valor:</label>
                <input name="valor-prova" required id="valor" type="number">
            </div>
        </div>

        <center data-aos="fade-up">
            <input type="submit" value="Criar Gabarito" class="botao-form-enviar">
        </center>
    </form>
    <div>
        <br><br><br>
        <br><br><br>
        <br><br><br>
    </div>

</main>