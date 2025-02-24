<main class="main-home-aluno">
    <section class="main-home-aluno-section">

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
            <h2 class="titulo-principal-provas">Provas/atividades Pendentes:</h2>
        </div>
    </center>

    <?php

$provas_finalizadas = [];
$temProvaPendente = false;

if ($data["provas"] != null) {
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
        <?php if($prova["metodo"] == "prova"){?>
        <div class="linha-vertical-campo-prova"></div>
        <div class="conteudo-prova">
            <i class="fas fa-exclamation-triangle icone-alerta"></i>
            <?php }else {?>
            <div style="background-color: #C4FF5B;" class="linha-vertical-campo-prova"></div>
            <div class="conteudo-prova">
                <i style="color: #C4FF5B;" class="fas fa-exclamation-triangle icone-alerta"></i>
                <?php } ?>


                <div class="prova-detalhes">
                    <center>
                        <span class="prova-nome-disciplina">
                            <?= strtoupper($prova["disciplina"])?>
                        </span> <br>
                        <span class="prova-nome-disciplina">
                            <?=$prova["metodo"] == "prova" ? "PROVA AVALIATIVA" : "ATIVIDADE DE REVISÃO"?>
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
                <h3 style="margin:0px;"> <?=$prova["metodo"] == "prova" ? "PROVA AVALIATIVA" : "ATIVIDADE DE REVISÃO"?>
                </h3>
                <h2 style="margin:0px;"> <?=$prova["nome_prova"]?> </h2>
                <br>
                <center>

                    <div style="text-align:left;margin-left:20px;">

                        <span><b>PROFESSOR: </b><?=$prova["nome_professor"]?></span><br>
                        <span><b>DISCIPLINA:</b> <?=$prova["disciplina"]?></span><br>
                        <span><b>VALOR: </b> <?=$prova["valor"]?></span><br>
                        <span><b>DATA: </b> <?=date('d/m/Y', strtotime($prova["data_prova"]))?> </span><br>
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
<br><br><br>
        <center>
            <div class="titulo-area-provas">
                <i class="fas fa-check-circle icone-titulo"></i>
                <h2 class="titulo-principal-provas">Provas/atividades Finalizadas:</h2>
            </div>
        </center>


        <?php
if ($data["provas_feitas"] != null) {
    foreach ($data["provas_organizadas"] as $periodo => $provas) {?>



        <details class="periodo-provas">
            <summary> <i class="fas fa-calendar-alt" style="color:var(--primary-color);margin-right:10px;"> </i><?=$periodo?>
            </summary>

            <?php if ($provas == null) {?>

            <center>
                <h3>VOCÊ AINDA NÃO FEZ NENHUMA PROVA DESSE PERÍODO!</h3>
            </center>

            <?php }?>
            <br><br>

            <?php foreach ($provas as $prova) {?>

            <div class="prova-pendente">
                <?php if($prova["metodo"] == "prova"){?>

                <div class="linha-vertical-campo-prova " style="background-color:#39C000"></div>
                <div class="conteudo-prova">
                    <i class="fas fa-check fa-4x" style="color:#39C000"></i>
                    <?php }else {?>
                    <div class="linha-vertical-campo-prova " style="background-color:var(--primary-color)"></div>
                    <div class="conteudo-prova">
                        <i class="fas fa-check fa-4x" style="color:var(--primary-color)"></i>
                        <?php } ?>
                        <div class="prova-detalhes">
                            <center>
                                <span class="prova-nome-disciplina">
                                    <?= strtoupper($prova["disciplina"])?>
                                </span> <br>
                                <span class="prova-nome-disciplina">
                                    <?=$prova["metodo"] == "prova" ? "PROVA AVALIATIVA" : "ATIVIDADE DE REVISÃO"?>
                                </span> <br>
                                <span class="prova-nome-professor">
                                    <?=$prova["nome_prova"]?>
                                </span> <br>
                                <span class="prova-nome-professor">
                                    <?=date('d/m/Y', strtotime($prova["data_aluno"]))?>
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
                        list($questao, $resposta) = explode(",", base64_decode($gabarito));
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


if($liberado != null){
    while ($contador <= $prova["QNT_perguntas"]) { ?>
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
        <?php $contador++;
        }
}else{ ?>
<div class="gabarito-nao-liberado-aluno">
    <i class="fas fa-paper-plane confirmation-icon"></i>
    <h2>Sua prova foi inserida com sucesso!</h2>
    <p>Aguarde o professor liberar o acesso às respostas.</p>
    
 

    <button onclick="location.reload()" class="refresh-btn">
         Atualizar página
    </button>
</div>

    <?php 
}
        
                            
                            ?>


                        </table>

                    <?php if ($liberado == null) {
            echo "<br>";
        } else {?>
                        <?php if($prova["metodo"] == "prova"){ ?>
                        <br>
                        <span><b>VALOR DA PROVA: </b> <?=$prova["pontos_prova"]?> PONTOS</span>
                        <span><b>VALOR OBTIDO: </b> <?= $prova["pontos_aluno"]?> PONTOS</span>
                        <span><b>PORCETAGEM: </b> <?= $prova["porcentagem"]?>% DA PROVA</span>
                        <?php }else{ ?>
                        <br>
                        <span><b>PORCETAGEM: </b> <?= $prova["porcentagem"]?>% DA PROVA</span>
                        <span><b>ACERTOS: </b> <?= $prova["acertos"]?> ACERTO(S)</span>
                        <?php } ?>

                    <?php }?>

                        <button onclick="Fechar_PopUp('popup-gabarito-<?=$prova['id']?>')"
                            class="Fechar-Popup-icon">X</button>
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
    </section>
    </main>