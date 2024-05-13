<main class="main-home-aluno">
    <h2>Provas Pendentes:</h2>

    <?php
    $provas_finalizadas = [];
    $temProvaPendente = false; // Variável para verificar se há provas pendentes

    if ($data["provas"] != null) {
        foreach ($data["provas"] as $prova) {
            $prova_feita = false;
            foreach ($data["provas_feitas"] as $prova_feita_item) {
                if ($prova["id"] == $prova_feita_item["id_prova"]) {
                    $provas_finalizadas[] = true;
                    $prova_feita = true;
                    break;
                }
            }
            if (!$prova_feita) {
                $temProvaPendente = true; // Marca que há uma prova pendente
                $provas_finalizadas[] = false;
    ?>
                <div class="prova-pendente">
                    <div class="linha-vertical-campo-prova"></div>
                    <div class="conteudo-prova">
                        <i class="fas fa-exclamation-triangle fa-4x" style="color: #EFCC00;"></i>

                        <div class="prova-detalhes">
                            <span class="prova-nome-disciplina">
                                <?= $prova["disciplina"] ?>
                            </span> <br>
                            <span class="prova-nome-professor">
                                <?= $prova["nome_professor"] ?>
                            </span>
                        </div>

                        <div class="button-ver-prova">
                            <button onclick="Mostrar_PopUp('popup-prova-<?= $prova['id'] ?>')">Ver</button>
                        </div>
                    </div>
                </div>
                <br>

                <div style="display: none;" id="popup-prova-<?= $prova["id"] ?>" class="PopUp-sobreposicao">
                    <div class="conteudo-popup">
                        <h2> <?= $prova["nome_prova"] ?> </h2>
                        <br>
                        <span><b>PROFESSOR: </b><?= $prova["nome_professor"] ?></span><br>
                        <span><b>DISCIPLINA:</b> <?= $prova["disciplina"] ?></span><br>
                        <span><b>VALOR: </b> <?= $prova["valor"] ?></span><br>
                        <span><b>DATA: </b> <?= $prova["data_prova"] ?> </span><br>
                        <span><b>PERGUNTAS: </b><?= $prova["QNT_perguntas"] ?> PERGUNTAS</span><br>

                        <form method="post" action="gabarito_aluno">
                            <button type="submit" value="<?= $prova['id'] ?>" name="id-prova" class="Fechar-Popup">ENVIAR GABARITO</button>
                        </form>
                        <button onclick="Fechar_PopUp('popup-prova-<?= $prova['id'] ?>')" class="Fechar-Popup">FECHAR</button>
                    </div>
                </div>

        <?php
            }
        }
    }

    // Verifica se não há provas pendentes e imprime a div "TUDO EM DIA"
    if (!$temProvaPendente) {
        ?>
        <div class="nao_tem_prova">
            <span>TUDO EM DIA 📚 </span>
            <div>
                <img src="public/assents/img/semprovas.gif" alt="">
            </div>
            <div>
                <center>
                    <p>VOCÊ NÃO TEM PROVAS PENDENTES <br> A SEREM FEITAS 🤠</p>
                </center>
            </div>
        </div>
    <?php
    }
    ?>

    <h2>Provas Finalizadas:</h2>

    <?php
    if ($data["provas"] != null) {
        foreach ($data["provas_feitas"] as $prova) { ?>
            <div class="prova-pendente">
                <div class="linha-vertical-campo-prova " style="background-color:green"></div>
                <div class="conteudo-prova">
                    <i class="fas fa-check fa-4x" style="color:green"></i>

                    <div class="prova-detalhes">
                        <span class="prova-nome-disciplina">
                            <?= $prova["disciplina"] ?>
                        </span> <br>
                        <span class="prova-nome-professor">
                            <?= $prova["nome_professor"] ?>
                        </span>
                    </div>

                    <div class="button-ver-prova">
                        <button onclick="Mostrar_PopUp('popup-prova-<?= $prova['id'] ?>')">Resultado</button>
                    </div>
                </div>
            </div><br>

            <div style="display: none;" id="popup-prova-<?= $prova["id"] ?>" class="PopUp-sobreposicao">
                <div class="conteudo-popup">
                    <h2> <?= $prova["nome_prova"] ?> </h2>
                    <br>
                    <span><b>PROFESSOR: </b><?= $prova["nome_professor"] ?></span><br>

                    <table>
                    <?php 
    $contador = 1;
    $alternativas = ["A","B","C","D","E"];
    while ($contador <= $prova["QNT_perguntas"]) { ?>
        <tr>
            <td><?=$contador?></td>
            <?php 
            $contador2 = 0;
            $gabarito_aluno_tudo = array_merge(explode(";",$prova["perguntas_certas"]),explode(";",$prova["perguntas_erradas"])); 

            while($contador2 < 5){
                $classe = "";
                $pergunta_respota = explode(",",$gabarito_aluno_tudo[$contador - 1]); 
                if($pergunta_respota[1] == $alternativas[$contador2]){
                    $classe = "alternativa-marcada";
                }
                echo "<td class='{$classe}' >{$alternativas[$contador2]}</td>";

                $contador2++;
            }
            ?> 
        </tr>
    <?php $contador++; } ?>

                       
                    </table>

                    <button onclick="Fechar_PopUp('popup-prova-<?= $prova['id'] ?>')" class="Fechar-Popup">FECHAR</button>
                </div>
            </div>

        <?php }
    } else { ?>

        <h4>Voê não realizou nenhuma prova!</h4>

    <?php
    } ?>
    <br><br><br><br><br><br><br><br><br><br>
</main>