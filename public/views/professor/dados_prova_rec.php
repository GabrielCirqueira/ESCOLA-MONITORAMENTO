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

        <div>
        <br><br><br><br><br>
        <br><br><br><br><br>
        <br><br><br><br><br>
        </div>
</main>