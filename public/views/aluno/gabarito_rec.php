<main class="main-home-aluno">
<center>
<h1><?=$data["nome_prova"]?></h1>
<h3>RECUPERAÇÃO</h3>

</center>
    <span><b>DISCIPLINA:</b> <?=$data["disciplina"]?></span><br>
    <span><b>VALOR: </b> <?=$data["valor"]?></span><br>

    <div class="aluno_inserir_gabarito">
        <form action="cadastrar_gabarito_aluno_rec" method="post">
            <table>
                <?php
$contador = 1;
while ($contador <= $data["QNT_perguntas"]) {?>
                 <tr>
                    <td >
                        <span><?php echo $contador ?></span>
                    </td>

                    <td>
                        <div class="Ds"><input type="radio" name="gabarito_questao_<?php echo "{$contador}" ?>" required
                            id="<?php echo "{$contador},A" ?>"    value="<?php echo "{$contador},A" ?>"><label for="<?php echo "{$contador},A" ?>">A</label></div>
                    </td>
                    <td>
                        <div class="Ds"><input type="radio" name="gabarito_questao_<?php echo "{$contador}" ?>" required
                        id="<?php echo "{$contador},B" ?>"    value="<?php echo "{$contador},B" ?>"><label for="<?php echo "{$contador},B" ?>">B</label></div>
                    </td>
                    <td>
                        <div class="Ds"><input type="radio" name="gabarito_questao_<?php echo "{$contador}" ?>" required
                        id="<?php echo "{$contador},C" ?>"    value="<?php echo "{$contador},C" ?>"><label for="<?php echo "{$contador},C" ?>">C</label></div>
                    </td>
                    <td>
                        <div class="Ds"><input type="radio" name="gabarito_questao_<?php echo "{$contador}" ?>" required
                        id="<?php echo "{$contador},D" ?>"    value="<?php echo "{$contador},D" ?>"><label for="<?php echo "{$contador},D" ?>">D</label></div>
                    </td>
                </tr>
                <?php
$contador++;}
?>
            </table>
            <br><br><br><br>
            <center>
                <input type="submit" value="Enviar Gabarito" class="botao-form-enviar">
            </center>
            <br><br><br><br>
            <br><br><br><br>
        </form>


    </div>
</main>