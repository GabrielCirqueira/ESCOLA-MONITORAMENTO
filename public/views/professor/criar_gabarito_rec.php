<main class="main-home-professor"> 
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>GABARITO DE RECUPERAÇÃO</h2>

        <div class="professor-inserir-gabarito">
            <form action="criar_gabarito_rec_resp" method="post">

                <table>
                    <?php $contador = 1;
                    while ($contador <= $_SESSION["dados_prova_rec"]["perguntas"]) { ?>
                        <tr>
                            <td>
                                <span><?php echo $contador ?></span>
                            </td>
                            <?php if($_SESSION["dados_prova_rec"]["descritores"] == "sim"){  ?>
                            <td>
                                <div class="campos-selecionar-descritores">
                                    <input type="text" class="searchInput" required data-index="<?php echo $contador ?>" name="DESCRITOR_<?php echo "{$contador}"?>" placeholder="DESCRITOR">
                                    <div class="descritoresContainer" data-index="<?php echo $contador ?>"></div>
                                </div>
                            </td>
                            <?php }?>
                            
                            <td><div class="Ds" ><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},A"?>"><span>A</span></div></td>

                            <td><div class="Ds" ><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},B"?>"><span>B</span></div></td>

                            <td><div class="Ds" ><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},C"?>"><span>C</span></div></td>

                            <td><div class="Ds" ><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},D"?>"><span>D</span></div></td>
                            
                            <!-- <td><div class="Ds" ><input type="radio" name="<?php echo "{$contador}"?>" required value="<?php echo "{$contador},E"?>"><span>E</span></div></td> -->
                        </tr>
                    <?php $contador++;
                    } ?>
                </table>
            <br><br><br>
            <center>
                <input type="submit" value="Criar gabarito de recuperação" class="botao-form-enviar">
            </center>
            </form>
        </div>
        <br><br><br>
            <br><br><br>
            <br><br><br>
            <br><br><br>
            <br><br><br> 
</main>