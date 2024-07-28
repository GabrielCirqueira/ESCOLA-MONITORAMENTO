<main class="main-home-professor">
    <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
    <h2>GABARITO</h2>

    <div class="professor-dados-gabarito-criar">
        <center>
            <h3>Turma(s):</h3>
            <br>
            <div class="turma-colunas">
                <?php foreach ($data["turmas"] as $turma) {
    echo "<span>{$turma}</span>";
}?>
            </div>
            <br>
            <h3>Valor: <?php echo $data["valor"] ?></h3>
            <br>
            <h3>Questões: <?php echo $data["perguntas"] ?></h3>
        </center>
    </div>

    <?php if ($data["descritores"] == "sim") {?>
        <center>
            <h3>Nos descritores, Não esqueça de colocar a "_" e o <br> prefixo da materia, Exemplo : "D027_M"</h3>
            <h4>Não coloque o descritor sem o prefixo</h4>
        </center>
    <?php }?>

    <div class="professor-inserir-gabarito">
        <form action="criar_gabarito_respostas" method="post">
            <input type="hidden" name="numero_perguntas" value="<?php echo $data['perguntas']; ?>">
            <input type="hidden" name="turmas_gabarito" value="<?php echo implode(",", $data['turmas']); ?>">
            <input type="hidden" name="valor_prova" value="<?php echo $data["valor"]; ?>">
            <input type="hidden" name="nome_prova" value="<?php echo $data["nome_prova"]; ?>">
            <input type="hidden" name="materia_prova" value="<?php echo $data["materia"]; ?>">
            <input type="hidden" name="descritor" value="<?php echo $data["descritores"]; ?>">

            <table class="tabela-alternativas-escolher">
                <?php $contador = 1;
while ($contador <= $data["perguntas"]) {?>
                    <tr>
                        <td>
                            <span><?php echo $contador ?></span>
                        </td>
                        <?php if ($data["descritores"] == "sim") {?>
                        <td>
                            <div class="campos-selecionar-descritores">
                                <input type="text" class="searchInput" required data-index="<?php echo $contador ?>" name="DESCRITOR_<?php echo "{$contador}" ?>" placeholder="DESCRITOR">
                                <div class="descritoresContainer" data-index="<?php echo $contador ?>"></div>
                            </div>
                        </td>
                        <?php }?>

                        <td><div class="Ds"><input type="radio" id="A_<?php echo "{$contador}" ?>" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},A" ?>"><label for="A_<?php echo "{$contador}" ?>">A</label></div></td>
                        <td><div class="Ds"><input type="radio" id="B_<?php echo "{$contador}" ?>" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},B" ?>"><label for="B_<?php echo "{$contador}" ?>">B</label></div></td>
                        <td><div class="Ds"><input type="radio" id="C_<?php echo "{$contador}" ?>" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},C" ?>"><label for="C_<?php echo "{$contador}" ?>">C</label></div></td>
                        <td><div class="Ds"><input type="radio" id="D_<?php echo "{$contador}" ?>" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},D" ?>"><label for="D_<?php echo "{$contador}" ?>">D</label></div></td>
                    </tr>
                <?php $contador++;}?>
            </table>
            <br><br><br>
            <center>
                <input type="submit" value="Criar Gabarito" class="botao-form-enviar">
            </center>
        </form>
    </div>
    <br><br><br>
</main>
