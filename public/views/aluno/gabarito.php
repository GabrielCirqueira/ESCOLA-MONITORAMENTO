<main class="main-home-aluno">
    <center>
        <div class="container-prova">
            <h1><i class="fas fa-file-alt"></i> <?=$data["prova"]["nome_prova"]?></h1>
            
            <div class="info-prova">
                <span><b><i class="fas fa-book"></i> DISCIPLINA:</b> <?=$data["prova"]["disciplina"]?></span><br>
                <span><b><i class="fas fa-chalkboard-teacher"></i> PROFESSOR:</b> <?=$data["prova"]["nome_professor"]?></span><br>
                <span><b><i class="fas fa-star"></i> VALOR:</b> <?=$data["prova"]["valor"]?></span><br>
                <span><b><i class="fas fa-file-alt"></i> METODO:</b> <?=$data["prova"]["metodo"] == "prova" ? "PROVA AVALIATIVA" : "ATIVIDADE AVALIATIVA"?></span><br>
            </div>
        </div>

        <div class="container-gabarito">
            <h3><i class="fas fa-pencil-alt"></i> Preencha o gabarito abaixo</h3>
            <div class="professor-inserir-gabarito">
                <form id="gabaritoForm" action="" method="post">
                    <table class="tabela-alternativas-escolher">
                        <?php
                        $contador = 1;
                        while ($contador <= $data["prova"]["QNT_perguntas"]) {?>
                        <tr>
                            <td><span><?php echo $contador ?></span></td>
                            <?php foreach($data["alternativas"] as $a){?>  
                            <td>
                                <div class="Ds">
                                    <input type="radio" name="gabarito_questao_<?php echo "{$contador}" ?>" required
                                    id="<?php echo "{$contador},{$a}" ?>" value="<?php echo "{$contador},{$a}" ?>">
                                    <label for="<?php echo "{$contador},{$a}" ?>"><?= $a?></label>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php
                        $contador++;}
                        ?>
                    </table>
                    <br><br>
                    <div class="alerta">
                        <h3><i class="fas fa-exclamation-triangle"></i> Revise todas as respostas antes de enviar!</h3>
                    </div>
                    <br><br>
                    <center>
                        <div id="div_carregamento" class="hidden">
                            <div class="loader2"></div><br><br>
                            <div class="loader3"></div>
                        </div>
                        <button id="button_enviar_gabarito" onclick="MostrarCarregamento()" type="submit" name="enviar_gabarito_aluno" class="botao-form-enviar">
                            <i class="fas fa-paper-plane"></i> Enviar Gabarito
                        </button>
                    </center>
                </form><br>
            </div>
        </div>
        
        <div class="container-dicas">
            <h4><i class="fas fa-lightbulb"></i> Dicas para preencher:</h4>
            <ul>
                <li><i class="fas fa-check-circle"></i> Confira todas as alternativas antes de selecionar sua resposta.</li>
                <li><i class="fas fa-times-circle"></i> Se tiver dúvidas, revise o enunciado da questão novamente.</li>
                <li><i class="fas fa-clock"></i> Não se apresse, faça com cuidado.</li>
            </ul>
        </div>
    </center>
</main>
