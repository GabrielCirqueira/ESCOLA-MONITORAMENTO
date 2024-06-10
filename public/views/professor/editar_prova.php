<main class="main-home-professor"> 
    <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
    <h1>EDITAR GABARITO</h1>
    <h2><?= $data["nome"] ?></h2>

    <div class="professor-editar-gabarito">
        <form action="atualizar_gabarito" method="post">
            <div class="valor_pontos_editar">
            <h2>Valor</h2>
            <input type="text" name="valor_prova" value="<?php echo $data['valor']; ?>"> 
            </div>
            <br><br>
            <!-- <pre>
                <?php print_r($data["descritores"])?>
            </pre> -->

            <input type="hidden" name="numero_perguntas" value="<?php echo $data['perguntas']; ?>">
            <input type="hidden" name="descritor" value="<?php echo isset($data['descritores']) ? 'sim' : 'não'; ?>">

            <table>
                <?php 
                $contador = 1;
                while ($contador <= $data["perguntas"]) { 
                    $resposta = explode(",", $data["gabarito"][$contador - 1])[1];
                ?>
                    <tr>
                        <td>
                            <span><?php echo $contador ?></span>
                        </td>
                        <?php if ($data["descritores"] != null) { ?>
                        <td>
                            <div class="campos-selecionar-descritores">
                                <input type="text" class="searchInput" required data-index="<?php echo $contador ?>" name="DESCRITOR_<?php echo "{$contador}" ?>" value="<?php if($contador < 10){
                                    echo substr($data['descritores'][$contador - 1], 2);
                                }else if($contador >= 10 && $contador < 100){
                                    echo substr($data['descritores'][$contador - 1], 3);
                                }else{
                                    echo substr($data['descritores'][$contador - 1], 4);
                                } ?>" placeholder="DESCRITOR">
                                <div class="descritoresContainer" data-index="<?php echo $contador ?>"></div>
                            </div>
                        </td>
                        <?php } ?>

                        <td><input type="radio" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},A" ?>" <?php echo $resposta == 'A' ? 'checked' : ''; ?>><span>A</span></td>
                        <td><input type="radio" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},B" ?>" <?php echo $resposta == 'B' ? 'checked' : ''; ?>><span>B</span></td>
                        <td><input type="radio" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},C" ?>" <?php echo $resposta == 'C' ? 'checked' : ''; ?>><span>C</span></td>
                        <td><input type="radio" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},D" ?>" <?php echo $resposta == 'D' ? 'checked' : ''; ?>><span>D</span></td>
                        <td><input type="radio" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},E" ?>" <?php echo $resposta == 'E' ? 'checked' : ''; ?>><span>E</span></td>
                    </tr>
                <?php 
                $contador++;
                } ?>
            </table>
            <br><br><br>
            <center>
                <input type="submit" value="Atualizar gabarito" class="botao-form-enviar">
            </center>
        </form>
    </div>
    <br><br><br>
</main>
