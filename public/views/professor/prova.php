<main class="main-home-professor height">
    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1> 
        <h2>  <?= $data["nome_prova"] ?></h2>
    </center>

    <form method="post" action="">
        
    <!-- <label class="switch">
        <input type="checkbox" name="liberar_provas" <?php // echo $data["liberado"] ? "checked" : ""?> id="toggle">
        <span class="slider round"></span>
    </label> -->

<center>

        <?php foreach ($data["turmas"] as $turma) { ?>
            <input type="hidden" name="id-prova" value="<?= $_POST["id-prova"] ?>">
            <button class="button-professor-turma" name="turma" value="<?= $turma ?>" type="submit"><?= $turma ?></button>
        <?php } ?>
</center>
    </form>
    <h2><?= $data["turma"] ?></h2>

    <table class="tabela-prova-aluno" >

        <thead>
            <tr>
                <th>ALUNO</th>
                <th>PONTOS</th>
                <th>ACERTOS</th>
                <th>P. ACERTOS</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($data["provas_turma"] as $prova) { ?>
                <tr>
                    <td><?= $prova["aluno"] ?></td>
                    <td><?= $prova["pontos_aluno"] ?></td>
                    <td><?= $prova["acertos"] ?></td>
                    <td><?= number_format(($prova["acertos"] / $prova["QNT_perguntas"]) * 100, 1) ?>%</td> 
                </tr>

            <?php
            }

            ?>
        </tbody>
    </table>

</main>