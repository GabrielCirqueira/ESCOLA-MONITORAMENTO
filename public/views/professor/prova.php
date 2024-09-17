<main class="main-home-professor">
    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2> <?=$data["nome_prova"]?></h2>
    </center>

    <form method="post" action="">
        <center>
            <div class="alternar-liberar-gabarito">
                <span>Aluno pode ver o resultado(gabarito)?</span><br><br>
                <?php if ($data["liberado"] == "SIM") {?>

                <button type="submit" name="status" value="sim" class="button-prova-liberado"
                    style="background-color: #16c1aa;">SIM</button>
                <button type="submit" name="status" value="não" class="button-prova-liberado">NÃO</button>
                <?php } else {?>
                <button type="submit" name="status" value="sim" class="button-prova-liberado">SIM</button>
                <button type="submit" name="status" value="não" class="button-prova-liberado"
                    style="background-color: #16c1aa;">NÃO</button>

                <?php }?>
            </div> <br><br>

            <div class="alternar-liberar-gabarito">
                <span>
                    O aluno que faltou tem permissão para realizar a prova?
                </span><br><br>

                <?php if ($data["liberar_prova"] == true) {?>

                <button type="submit" name="status-liberado" value="sim" class="button-prova-liberado"
                    style="background-color: #16c1aa;">SIM</button>
                <button type="submit" name="status-liberado" value="não" class="button-prova-liberado">NÃO</button>
                <?php } else {?>
                <button type="submit" name="status-liberado" value="sim" class="button-prova-liberado">SIM</button>
                <button type="submit" name="status-liberado" value="não" class="button-prova-liberado"
                    style="background-color: #16c1aa;">NÃO</button>

                <?php }?>
            </div> <br><br>


            <input type="hidden" name="id-prova" value="<?=$_SESSION["id_prova_professor"]?>">

                   <b><span>*As Alterações acima serão aplicadas para todas as turmas*</p></b>
        </center>
    </form>
<div><br><br></div>
    <div class="detalhes-prova">
        <table style="width: 360px;">
            <th style="text-align: center;" colspan="2">DETALHES PROVA</th>

            <tr>
                <td>VALOR</td>
                <td><?=$data["prova"]["valor"]?> Pontos</td>
            </tr>
            <tr>
                <td>PERGUNTAS</td>
                <td><?=$data["prova"]["QNT_perguntas"]?> Questões</td>
            </tr>
            <tr>
                <th style="text-align: center;" colspan="2">TURMAS</th>
            </tr>
            <?php
$turmas = explode(",", $data["prova"]["turmas"]);
$turmaCount = count($turmas);
for ($i = 0; $i < $turmaCount; $i += 2) {?>
            <tr>
                <td style="background-color: #E9E9E9;">
                    <?=$turmas[$i]?>
                </td>
                <td style="background-color: #E9E9E9;">
                    <?=isset($turmas[$i + 1]) ? $turmas[$i + 1] : ''?>
                </td>
            </tr>
            <?php
}
?>
        </table>
    </div>

    <div class="area-professor-botoes-prova">

        <?php
if ($data["provas_rec"] != null) {?>
        <center>
            <div class="area_provas_rec_professor">
                <form action="prova_recuperacao" method="post">
                    <?php
for ($i = 0; $i < $data["provas_rec"]["quantidade"]; $i++) {?>
                            <button name="prova" value="<?=$data["provas_rec"]["provas"][$i]["id"]?>"><?=$i + 1?>ª
                                RECUPERAÇÃO</button>
                            <br>
                    <?php }
    ?>
                </form>
            </div>
        </center>
        <?php }?>

<?php if (2 == 3) {?>
    <form action="add_recuperacao" method="post">
            <input type="hidden" name="id-prova" value="<?=$_SESSION["id_prova_professor"]?>">
            <button type="submit" class="button-add-recp">ADICIONAR RECUPERAÇÃO</button>
        </form>
<?php }?>

<br><br><br>

        <button class="excluir-prova" onclick="Mostrar_PopUp('PopUp_excluir_prova')">EXCLUIR PROVA</button>

    </div>

    <div style="display: none;" id="PopUp_excluir_prova" class="PopUp-sobreposicao">
        <div class="conteudo-popup">
            <h2>CUIDADO!</h2>
            <p>Excluir a prova resultará na perda de todos os dados registrados, incluindo os dos alunos que fizeram
                essa prova!</p>

            <b>
                <p>Deseja excluir?</p>
            </b>

            <div class="inserir-usuario-excluir-prova">
                <form method="post" action="">
                    <div>
                        <label for="user">Insira seu Usuario:</label>
                        <input required id="user" name="user" type="text">
                    </div>
                    <br><br>
                    <button type="submit" name="enviar-user" value="e" class="botao-form-enviar">Excluir Prova</button>
                </form>
            </div>

            <button onclick="Fechar_PopUp('PopUp_excluir_prova')" class="Fechar-Popup-icon">X</button>
        </div>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</main>