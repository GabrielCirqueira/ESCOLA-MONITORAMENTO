<main class="main-home-aluno">
    <br><br>
    <center>

    <div class="caixa-boas-vindas">
    <div class="boas-vindas-header">
        <div class="icone-boas-vindas">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="boas-vindas-texto">
            <h3>Bem-vindo, <?= $_SESSION["nome_aluno"] ?>!</h3>
            <p>Este é o seu sistema de monitoramento acadêmico.</p>
        </div>
        </div>

    <div class="mensagem-sistema">
        <i class="fas fa-check-circle"></i>
        <p>Verifique se há provas disponíveis para você realizar.</p>
    </div>

    <div class="mensagem-sistema">
        <i class="fas fa-file-alt"></i>
        <p>Logo abaixo você poderá visualizar os gabaritos e provas lançados.</p>
    </div>

    <div class="mensagem-alerta">
        <i class="fas fa-exclamation-triangle"></i>
        <p>Atenção: Certifique-se de não lançar o gabarito na disciplina errada!</p>
    </div>

</div>



    </center>
    <br>


    <center>
    <div class="titulo-area-provas">
    <i class="fas fa-tasks icone-titulo"></i>
    <h2 class="titulo-principal-provas">Provas Pendentes:</h2>
</div>
    </center>

    <?php
$provas_finalizadas = [];
$temProvaPendente = false;

if ($data["provas"] != null || $data["rec"] != null) {
    foreach ($data["provas"] as $prova) {
        $prova_feita = false;
        if ($data["provas_feitas"] != null) {
            foreach ($data["provas_feitas"] as $prova_feita_item) {
                if ($prova["id"] == $prova_feita_item["id_prova"]) {
                    $provas_finalizadas[] = true;
                    $prova_feita = true;
                    break;
                }
            }
        }

        if ($prova["liberar_prova"] != null) {
            $prova_feita = true;
        }

        if (!$prova_feita) {
            $temProvaPendente = true;
            $provas_finalizadas[] = false;
            ?>



<div class="prova-pendente">
    <div class="linha-vertical-campo-prova"></div>
    <div class="conteudo-prova">
        <i class="fas fa-exclamation-triangle icone-alerta"></i>
        
        <div class="prova-detalhes">
            <center>
                <span class="prova-nome-disciplina">
                    <?=$prova["disciplina"]?>
                </span> <br>
                <span class="prova-nome-professor">
                    <?=$prova["nome_prova"]?>
                </span> <br>
                <span class="prova-nome-professor">
                    <?=$prova["nome_professor"]?>
                </span>
            </center>
        </div>
        <div class="button-ver-prova">
            <button onclick="Mostrar_PopUp('popup-prova-<?=$prova['id']?>')">
                <i class="fas fa-eye"></i> Ver
            </button>
        </div>
    </div>
</div>


    <br>

    <div style="display: none; padding-top:10%; " id="popup-prova-<?=$prova["id"]?>" class="PopUp-sobreposicao">
        <div class="conteudo-popup">
            <br>
            <h2> <?=$prova["nome_prova"]?> </h2>
            <br>
            <center>

                <div style="text-align:left;margin-left:20px;">

                    <span><b>PROFESSOR: </b><?=$prova["nome_professor"]?></span><br>
                    <span><b>DISCIPLINA:</b> <?=$prova["disciplina"]?></span><br>
                    <span><b>VALOR: </b> <?=$prova["valor"]?></span><br>
                    <span><b>DATA: </b> <?=$prova["data_prova"]?> </span><br>
                    <span><b>QUESTÕES: </b><?=$prova["QNT_perguntas"]?> </span><br>
                </div>
            </center>

            <form method="post" action="gabarito_aluno">
                <button type="submit" value="<?=$prova['id']?>" name="id-prova" class="Fechar-Popup">ENVIAR
                    GABARITO</button>
            </form>
            <button onclick="Fechar_PopUp('popup-prova-<?=$prova['id']?>')" class="Fechar-Popup-icon">X</button>
        </div>
    </div>

    <?php
}
    }

    if ($data["rec"] != null) {
        foreach ($data["rec"] as $provaa) {
            if ((!isset($provaa["statuss"]) && $provaa["liberar_prova"] == null)) {
                ?>


    <div class="prova-pendente">
        <div style="background-color: #B35A37;" class="linha-vertical-campo-prova"></div>
        <div class="conteudo-prova">
            <i class="fas fa-exclamation-triangle fa-4x" style="color: #B35A37;"></i>

            <div class="prova-detalhes">
                <center>
                    <span class="prova-nome-disciplina">RECUPERAÇÃO</span><br>
                    <span class="prova-nome-disciplina">
                        <?=$provaa["disciplina"]?>
                    </span> <br>
                    <span class="prova-nome-professor">
                        <?=$provaa["nome_professor"]?>
                    </span>
                </center>
            </div>

            <div class="button-ver-prova">
                <button onclick="Mostrar_PopUp('popup-prova-<?=$provaa['id']?>')">Ver</button>
            </div>
        </div>
    </div>
    <br>

    <div style="display: none;" id="popup-prova-<?=$provaa["id"]?>" class="PopUp-sobreposicao">
        <div class="conteudo-popup">
            <br>
            <h2> RECUPERAÇÃO </h2>
            <h3> <?=$provaa["nome_prova"]?> </h3>
            <br>
            <div style="text-align:left;">

                <span><b>PROFESSOR: </b><?=$provaa["nome_professor"]?></span><br>
                <span><b>DISCIPLINA:</b> <?=$provaa["disciplina"]?></span><br>
                <span><b>VALOR: </b> <?=$provaa["valor"]?></span><br>
                <span><b>QUESTÕES: </b><?=$provaa["QNT_perguntas"]?> </span><br>
            </div>

            <form method="post" action="gabarito_aluno_rec">
                <button type="submit" value="<?=$provaa['id']?>" name="id-prova" class="Fechar-Popup">ENVIAR
                    GABARITO</button>
            </form>
            <button onclick="Fechar_PopUp('popup-prova-<?=$provaa['id']?>')" class="Fechar-Popup-icon">X</button>
        </div>
    </div>

    <?php
}
        }
    }
}

if (!$temProvaPendente) {
    ?>
    <br><br>
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
    <br><br>
    <?php
}
?>

    <center>
    <div class="titulo-area-provas">
    <i class="fas fa-check-circle icone-titulo"></i>
    <h2 class="titulo-principal-provas">Provas Finalizadas:</h2>
</div>
    </center>


    <?php
if ($data["provas_feitas"] != null) {
    foreach ($data["provas_organizadas"] as $periodo => $provas) {?>



    <details class="periodo-provas">
        <summary> <i class="fas fa-calendar-alt" style="color:#0dad98;margin-right:10px;"> </i><?=$periodo?> </summary>

        <?php if ($provas == null) {?>

        <center>
            <h3>VOCÊ AINDA NÃO FEZ NENHUMA PROVA DESSE PERÍODO!</h3>
        </center>

        <?php }?>
        <br><br>

        <?php foreach ($provas as $prova) {?>

        <div class="prova-pendente">
            <div class="linha-vertical-campo-prova " style="background-color:#39C000"></div>
            <div class="conteudo-prova">
                <i class="fas fa-check fa-4x" style="color:#39C000"></i>

                <div class="prova-detalhes">
                    <center>
                        <span class="prova-nome-disciplina">
                            <?=$prova["disciplina"]?>
                        </span> <br>
                        <span class="prova-nome-professor">
                            <?=$prova["nome_prova"]?>
                        </span> <br>
                        <span class="prova-nome-professor">
                            <?=$prova["data_aluno"]?>
                        </span>
                    </center>
                </div>

                <div class="button-ver-prova">
                    <button onclick="Mostrar_PopUp('popup-gabarito-<?=$prova['id']?>')">Resultado</button>
                </div>
            </div>
        </div><br>

        <div style="display: none; padding-top:10%; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);"
            id="popup-gabarito-<?=$prova["id"]?>" class="PopUp-sobreposicao">
            <div class="conteudo-popup">
                <br>
                <h4> <?=$prova["nome_prova"]?></h4>



                <table>
                    <?php
$contador = 1;
        $alternativas = $data["alternativas"];
        $gabarito_professor = [];
        $gabarito_aluno = [];

        if ($prova["status"] == "Fez só a recuperação" || $prova["status"] == "Recuperação: nota maior que a 1º prova") {
            foreach ($data["rec"] as $PP) {
                if ($PP["id_prova"] == $prova["id_prova"]) {
                    foreach (explode(";", $PP["gabarito"]) as $gabarito) {
                        list($questao, $resposta) = explode(",", $gabarito);
                        $gabarito_professor[$questao] = $resposta;
                        $liberado = $PP["liberado"];
                    }
                }
            }
        } else {
            foreach ($data["provas"] as $P) {
                if ($P["id"] == $prova["id_prova"]) {
                    foreach (explode(";", $P["gabarito"]) as $gabarito) {
                        list($questao, $resposta) = explode(",", $gabarito);
                        $gabarito_professor[$questao] = $resposta;
                        $liberado = $P["liberado"];
                    }
                }
            }
        }

        foreach (explode(";", $prova["perguntas_respostas"]) as $resposta) {
            list($questao, $resposta) = explode(",", $resposta);
            $gabarito_aluno[$questao] = $resposta;
        }



        while ($contador <= $prova["QNT_perguntas"]) {?>
                    <tr>
                        <td class="numero"><?=$contador?></td>
                        <?php
$contador2 = 0;
            $resposta_correta = $gabarito_professor[$contador];

            $resposta_aluno = $gabarito_aluno[$contador];
            if ($liberado != null) {
                while ($contador2 < count($alternativas)) {
                    $alternativa_atual = $alternativas[$contador2];
                    $classe = "";
                    // echo $resposta_aluno;
                    // echo "<br>";
                    if ($resposta_aluno == $alternativa_atual) {

                        if ($resposta_aluno == $resposta_correta || $resposta_correta == "null") {
                            $classe = "alternativa-marcada-true";

                        } else {
                            $classe = "alternativa-marcada-false";

                        }
                    } elseif ($resposta_correta == $alternativa_atual && $resposta_aluno != $resposta_correta) {
                        $classe = "alternativa-marcada-true-gray";
                    }

                    echo "<td class='{$classe}'>{$alternativa_atual}</td>";

                    $contador2++;
                }
            } else {
                while ($contador2 < count($alternativas)) {
                    $alternativa_atual = $alternativas[$contador2];
                    $classe = "";

                    if ($resposta_aluno == $alternativa_atual) {
                        $classe = "alternativa-marcada";
                    }

                    echo "<td class='{$classe}'>{$alternativa_atual}</td>";

                    $contador2++;
                }
            }
            ?>
                    </tr>
                    <?php $contador++;}?>
                </table>

                <?php if ($liberado == null) {
            echo "<h5>O PROFESSOR AINDA NÃO LIBEROU O ACESSO AS RESPOSTAS!</h5>";
        } else {?>
                <br>
                <span><b>VALOR DA PROVA:</b> <?=$prova["pontos_prova"]?></span> <br>
                <span><b>VALOR OBTIDO:</b> <?= $prova["pontos_aluno"]?> PONTOS</span>
                <?php
}?>

                <button onclick="Fechar_PopUp('popup-gabarito-<?=$prova['id']?>')" class="Fechar-Popup-icon">X</button>
            </div>
        </div>

        <?php }?>
        <br><br>
    </details>

    <?php }?>
    <?php
} else {?>

    <h4>Você não realizou nenhuma prova!</h4>


    <?php
}?>
    <div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
</main>