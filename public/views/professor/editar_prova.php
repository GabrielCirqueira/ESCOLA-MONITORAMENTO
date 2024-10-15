<main class="main-home-professor">
    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h1>EDITAR GABARITO</h1>
        <h2><?=$data["nome"]?></h2>

        <div class="">
            <form action="atualizar_gabarito" method="post">
                <div class="valor_pontos_editar">
                    <h2>Valor</h2>
                    <input type="text" name="valor_prova" value="<?=$data['valor'];?>">
                </div>
                <br><br>
                <!-- <pre>
                <?php print_r($data["descritores"])?>
            </pre> -->

                <?php if ($data["descritores"] != null) {?>
                <center>
                    <h3>Nos descritores, Não esqueça de colocar a "_" e o <br> prefixo da materia, Exemplo : "D027_M"
                    </h3>
                </center>
                <center>
                    <h4>Não coloque o descritor sem o prefixo </h4>
                </center>
                <?php }?>

                <input type="hidden" name="numero_perguntas" value="<?=$data['perguntas'];?>">
                <input type="hidden" name="descritor"
                    value="<?=isset($data['descritores']) ? 'sim' : 'não';?>">

                <table class="tabela-alternativas-escolher">
                    <?php
$contador = 1;
while ($contador <= $data["perguntas"]) {
    $resposta = explode(",", base64_decode($data["gabarito"][$contador - 1]))[1];
    ?>
                    <tr>
                        <td>
                            <span><?=$contador?></span>
                        </td>
                        <?php if ($data["descritores"] != null) {?>
                        <td>
                            <div style="display: block;" class="campos-selecionar-descritores">
                                <input type="text" class="searchInput" required data-index="<?=$contador?>"
                                    name="DESCRITOR_<?="{$contador}"?>" value="<?php if ($contador < 10) {
        echo substr($data['descritores'][$contador - 1], 2);
    } else if ($contador >= 10 && $contador < 100) {
        echo substr($data['descritores'][$contador - 1], 3);
    } else {
        echo substr($data['descritores'][$contador - 1], 4);
    }?>" placeholder="DESCRITOR">
                                <div style="display: block;" class="descritoresContainer"
                                    data-index="<?=$contador?>"></div>
                            </div>
                        </td>
                        <?php }?>

                        <?php  foreach($data["alternativas"] as $a){?>  
                            
                            <td>
                            <div  class="Ds" ><input type="radio" name="<?="{$contador}"?>" required
                                    value="<?="{$contador},{$a}"?>" id="<?="{$contador},{$a}"?>"
                                    <?=$resposta == $a ? 'checked' : '';?>><label
                                    for="<?="{$contador},{$a}"?>"><?= $a?></label></div>
                        </td>

                        <?php } ?>

                      
                       

                        <td style="padding: 13px;border-top: solid 1px white; border-bottom:  solid 1px white;"></td>

                        <td>
    <div class="label-anular">
        <input type="radio" id="anular_<?php echo "{$contador}" ?>" name="<?php echo "{$contador}" ?>" required value="<?php echo "{$contador},null" ?>" <?php echo $resposta == 'null' ? 'checked' : ''; ?>>
        <label for="anular_<?php echo "{$contador}" ?>">Anular Questão</label>
    </div>
</td>
                    </tr>
                    <?php
$contador++;
}?>
                </table>
                <br>

                <h3>Ao selecionar a opção “anular questão” , a questão<br> será anulada e todos os alunos que escolheram
                    <br>qualquer alternativa para essa questão receberão pontuação.</h3>

                <br><br><br>
                <input type="submit" value="Atualizar gabarito" class="botao-form-enviar">
    </center>
    </form>
    </div>
    <br><br><br>
</main>