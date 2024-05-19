<main class="main-home-professor">
    <center>
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1> 
        <h2>  <?= $data["nome_prova"] ?></h2>
    </center>
 

<h3>Desempenho total da turma</h3>
    <div class="graficos-professor-rosca">
    <?php 
    foreach($data["dados_turma"] as $turma){ ?> 
        <div>
            <?= $turma["grafico"]?>
            <span><?= $turma["turma_nome"]?></span>
        </div>
        <?php 
    }
    ?>
    </div>

    <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
</main>