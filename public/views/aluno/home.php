<main class="main-home-aluno">
<h2>Provas Pendentes</h2>

    <?php
    if ($data["provas"] != null) {
        
        foreach ($data["provas"] as $prova) { ?>

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

        <div style="display: none;" id="popup-prova-<?= $prova["id"]?>" class="PopUp-sobreposicao">
        <div class="conteudo-popup">
            <h2> <?= $prova["nome_prova"]?> </h2>
            <br>
            <span><b>PROFESSOR: </b><?= $prova["nome_professor"]?></span><br>
            <span><b>DISCIPLINA:</b> <?= $prova["disciplina"]?></span><br>
            <span><b>VALOR:     </b>   <?= $prova["valor"]?></span><br> 
            <span><b>DATA:      </b>   <?= $prova["data_prova"]?> </span><br>
            <span><b>PERGUNTAS: </b><?= $prova["QNT_perguntas"]?> PERGUNTAS</span><br>
            
            <form method="post" action="gabarito_aluno">
                <button type="submit" value="<?= $prova['id']?>" name="id-prova" class="Fechar-Popup">ENVIAR GABARITO</button>
            </form>
            <button onclick="Fechar_PopUp('popup-prova-<?= $prova['id']?>')" class="Fechar-Popup">FECHAR</button>
        </div>
    </div>

        <?php }
    } else { ?>
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


</main>