<main class="main-home-professor"> 
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>PROVA DE RECUPERAÇÃO</h2>

        <form method="post" action="">
        <center>
            
            <input type="hidden" name="prova" value="<?=$data["id"]?>">
            <div class="alternar-liberar-gabarito">
                <span>Aluno pode ver o resultado(gabarito)?</span><br><br>
                <?php if ($data["liberado"] == "SIM") {?>

                <button type="submit" name="status" value="sim" class="button-prova-liberado"
                    style="background-color: #0394b9;">SIM</button>
                <button type="submit" name="status" value="não" class="button-prova-liberado">NÃO</button>
                <?php } else {?>
                <button type="submit" name="status" value="sim" class="button-prova-liberado">SIM</button>
                <button type="submit" name="status" value="não" class="button-prova-liberado"
                    style="background-color: #0394b9;">NÃO</button>

                <?php }?>
            </div> <br><br>

             
            <div class="alternar-liberar-gabarito">
                <span>
                    O aluno que faltou tem permissão para realizar a prova?
                </span><br><br>

                <?php if ($data["liberar_prova"] == true) {?>

                <button type="submit" name="status-liberado" value="sim" class="button-prova-liberado"
                    style="background-color: #0394b9;">SIM</button>
                <button type="submit" name="status-liberado" value="não" class="button-prova-liberado">NÃO</button>
                <?php } else {?>
                <button type="submit" name="status-liberado" value="sim" class="button-prova-liberado">SIM</button>
                <button type="submit" name="status-liberado" value="não" class="button-prova-liberado"
                    style="background-color: #0394b9;">NÃO</button>

                <?php }?>
            </div> <br><br>
 

                   <b><span>*As Alterações acima seram aplicadas para todas as turmas*</p></b>
        </center>
    </form>

        <h3>ALUNOS EM RECUPERAÇÃO</h3>

        
    <table  class="tabela-prova-aluno">
            <thead>
                <!-- <th>RA</th> -->
                <th>NOME</th>
                <th>TURMA</th> 
                <th>PONTOS</th> 
                <th>STATUS</th> 
            </thead>
            <tbody>
                <?php foreach($data["alunos"] as $ra => $aluno){?>
                    <tr>
                    <!-- <td><?= $ra?></td> -->
                    <td><?= $aluno["nome"] ?></td>
                    <td><?= $aluno["turma"] ?></td>
                    <td><?= $aluno["Pontos"] ?></td> 
                    <td><?= $aluno["status"] ?></td> 
                    </tr>
                <?php }?>
            </tbody>
        </table>

        <br><br><br>

        <form method="post" action="editar_gabarito_recuperacao">
            <input type="hidden" value="<?=$data["id_prova"]?>" name="id_prova_origin">
            <button type="submit" name="id-prova" value="<?=$data["id"]?>" class="botao-form-enviar">Editar Gabarito</button>
        </form>
        <br><br><br>
        <button class="excluir-prova" onclick="Mostrar_PopUp('PopUp_excluir_prova')">Excluir Recuperação</button>

        <div id="PopUp_excluir_prova" class="PopUp-sobreposicao">
        <div class="conteudo-popup">
            <h2>CUIDADO!</h2>
            <p>Excluir a prova de recuperação resultará na perda de todos os dados registrados, incluindo os dos alunos que fizeram essa prova!</p>

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
                    <button type="submit" name="enviar-user" value="e" class="botao-form-enviar">Excluir Recuperação</button>
                </form>
            </div>

            <button onclick="Fechar_PopUp('PopUp_excluir_prova')" class="Fechar-Popup-icon">X</button>
        </div>
    </div>

        <div>
        <br><br><br><br><br>
        <br><br><br><br><br>
        <br><br><br><br><br>
        </div>
</main>