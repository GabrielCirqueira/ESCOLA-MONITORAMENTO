<main class="main-home-aluno">
    <center>
        <h1><?=$data["prova"]["nome_prova"]?></h1>

    <span><b>DISCIPLINA:</b> <?=$data["prova"]["disciplina"]?></span><br><br>
    <span><b>PROFESSOR: </b><?=$data["prova"]["nome_professor"]?></span><br><br>
    <span><b>VALOR: </b> <?=$data["prova"]["valor"]?></span><br>
    <br><br><br>
    <div >
        <form id="gabaritoForm" action="" method="post">
            <table  class="tabela-alternativas-escolher">
                <?php
$contador = 1;
while ($contador <= $data["prova"]["QNT_perguntas"]) {?>
                <tr>
                    <td >
                        <span><?php echo $contador ?></span>
                    </td>

                    <?php  foreach($data["alternativas"] as $a){?>  
                        <td>
                        <div class="Ds"><input type="radio" name="gabarito_questao_<?php echo "{$contador}" ?>" required
                            id="<?php echo "{$contador},{$a}" ?>"    value="<?php echo "{$contador},{$a}" ?>"><label for="<?php echo "{$contador},{$a}" ?>"><?= $a?></label></div>
                    </td>
                    <?php } ?>
                </tr>
                <?php
$contador++;}
?>
            </table>
            <br><br><br>
            <div>
                <center>
                    <h3>ANALISE TODAS AS RESPOSTAS ANTES <br> DE CLICAR NO BOTÃO ABAIXO!</h3>
                </center>
                <br>
            </div>
            <center>
                <div id="div_carregamento" class="hidden">
                    <div class="loader2"></div><br><br>
                    <div class="loader3"></div>

                </div>

                    <button  id="button_enviar_gabarito" onclick="MostrarCarregamento()"  type="submit" name="enviar_gabarito_aluno" class="botao-form-enviar">Enviar Gabarito</button>
            </center>

        </form>


    </div>
    <div>
        <br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br>
    </div>
    </center>
    </main>

