<main class="main-home ">

    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1> 
    </center>

    <div class="form">
        <form action="" method="post">
            <label for="turma">Turma:</label>
            <select name="turma" id="turma">
                <option value="SELECINAR">SELECIONAR</option>
                <?php foreach($data["turmas"] as $turma ){ ?>
                    <option value="<?= $turma["nome"] ?>"> <?= $turma["nome"] ?> </option>
                <?php } ?>
            </select>

            <label for="turno">Turno:</label>
            <select name="turno" id="turno">
                <option value="SELECINAR">SELECIONAR</option>
                <?php foreach($data["turnos"] as $turno ){ ?>
                    <option value="<?= $turno ?>"> <?= $turno ?> </option>
                <?php } ?>
            </select>

            <label for="disciplina">Disciplina:</label>
            <select name="disciplina" id="disciplina">
                <option value="SELECINAR">SELECIONAR</option>
                <?php foreach($data["disciplinas"] as $disciplina ){ ?>
                    <option value="<?= $disciplina["nome"] ?>"> <?= $disciplina["nome"] ?> </option>
                <?php } ?>
            </select>

            <label for="professor">Professor:</label>
            <select name="professor" id="professor">
                <option value="SELECINAR">SELECIONAR</option>
                <?php foreach($data["professores"] as $professor ){ ?>
                    <option value="<?= $professor["nome"] ?>"> <?= $professor["nome"] ?> </option>
                <?php } ?>
            </select>

            <input type="submit" value="Filtrar">
        </form>
    </div> 
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</main>
