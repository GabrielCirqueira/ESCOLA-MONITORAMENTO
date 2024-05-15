<main class="main-home-professor"> 
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>GABARITO</h2>

        <div class="professor-dados-gabarito-criar">
            <h3>Turma(s):</h3>
            <?php foreach ($data["turmas"] as $turma) {
                echo $turma;
                echo "<br>";
            } ?>
            <h3>Valor:</h3>
            <?php echo $data["valor"] ?>
            <h3>Perguntas:</h3>
            <?php echo $data["perguntas"] ?>
        </div>

        <div class="professor-inserir-gabarito">
            <form action="criar_gabarito_respostas" method="post">
                <input type="hidden" name="numero_perguntas" value="<?php echo $data['perguntas']; ?>">
                <input type="hidden" name="turmas_gabarito" value="<?php echo implode(",",$data['turmas']); ?>">
                <input type="hidden" name="valor_prova" value="<?php echo $data["valor"]; ?>">
                <input type="hidden" name="nome_prova" value="<?php echo $data["nome_prova"]; ?>">
                <input type="hidden" name="materia_prova" value="<?php echo $data["materia"]; ?>">
                <input type="hidden" name="descritor" value="<?php echo $data["descritores"]; ?>">

                <table>
                    <?php $contador = 1;
                    while ($contador <= $data["perguntas"]) { ?>
                        <tr>
                            <td>
                                <span><?php echo $contador ?></span>
                            </td>
                            <?php if($data["descritores"] == "sim"){  ?>
                            <td>
                                <div class="campos-selecionar-descritores">
                                    <input type="text" class="searchInput" required data-index="<?php echo $contador ?>" name="DESCRITOR_<?php echo "{$contador}"?>" placeholder="DESCRITOR">
                                    <div class="descritoresContainer" data-index="<?php echo $contador ?>"></div>
                                </div>
                            </td>
                            <?php }?>
                            
                            <td><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},A"?>"><span>A</span></td>
                            <td><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},B"?>"><span>B</span></td>
                            <td><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},C"?>"><span>C</span></td>
                            <td><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},D"?>"><span>D</span></td>
                            <td><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},E"?>"><span>E</span></td>
                        </tr>
                    <?php $contador++;
                    } ?>
                </table>
            <br><br><br>
            <center>
                <input type="submit" value="Criar gabarito" class="botao-form-enviar">
            </center>
            </form>
        </div>
        <br><br><br>
            <br><br><br>
            <br><br><br>
            <br><br><br>
            <br><br><br> 
</main>