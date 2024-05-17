<main class="main-home-professor height" >
    <center>

<h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>PROVAS - <?= $_SESSION["nome_professor"]?></h2>
    </center>
<br>
<?php 
foreach($data["provas"] as $prova){ 
    $contador = 0;
    foreach($data["provas_alunos"] as $P_aluno){
        if($P_aluno["id_prova"] == $prova["id"]){
            $contador++;
        }
    }
    
    ?>


<div class="prova-pendente">
                    <div class="linha-vertical-campo-prova" style="background-color: #04C636;" ></div>
                    <div class="conteudo-prova">
                        <i class="fas fa-file-alt fa-4x" style="color: #04C636;"></i>

                        <div class="prova-detalhes">
                            <center>

                            <span class="prova-nome-disciplina">
                            <?= $prova["nome_prova"] ?>
                            </span> <br>
                            <span class="prova-nome-disciplina">
                            <?= $prova["data_prova"] ?>
                            </span> <br>
                            <span class="prova-nome-professor">
                                <?= $contador ?> aluno(s) Fizeram a prova.
                            </span>
                            </center>
                        </div>
 
                        
                        <form method="post" action="prova">
                            <button type="submit" value="<?= $prova['id'] ?>" name="id-prova" class="botao-form-enviar">Ver</button>
                        </form>
                    </div>
                </div><br>

<?php }?>
  

</main>