<main class="main-home-professor">
    <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO <i class="fas fa-chalkboard-teacher"></i></h1>

    <!-- Introdução com dicas -->
    <div class="introducao-professor">
        <h2>Bem-vindo(a), Professor(a)!</h2>
        <p>Preencha o gabarito com as alternativas corretas e, caso necessário, os descritores. Aqui estão algumas
            dicas:</p>
        <ul>
            <li><i class="fas fa-info-circle"></i> Verifique se todas as questões estão com as alternativas corretas
                antes de enviar.</li>
            <li><i class="fas fa-check"></i> Utilize o prefixo correto para os descritores, como "D027_M" para
                Matemática.</li>
            <li><i class="fas fa-users"></i> Abaixo estão as turmas selecionadas para esta prova. Verifique se todas
                estão corretas.</li>
        </ul>
    </div>

    <div class="professor-dados-gabarito-criar">
        <div class="dados-gabarito">
            <div class="info-card">
                <h3><i class="fas fa-users"></i> Turmas:</h3>
                <div class="turma-colunas">
                    <?php foreach ($data["turmas"] as $turma) {
                    echo "<div class='turma-item'><span>{$turma}</span></div>";
                }?>
                </div>
            </div>
            <div class="info-card">
                <h3><i class="fas fa-file-alt"></i> Valor da Prova:</h3>
                <p><?php echo $data["valor"] ?> pontos</p>
            </div>
            <div class="info-card">
                <h3><i class="fas fa-question-circle"></i> Questões:</h3>
                <p><?php echo $data["perguntas"] ?> questões</p>
            </div>
        </div>
    </div>
    <br><br><br>

    <div class="professor-inserir-gabarito">
        <form action="criar_gabarito_respostas" method="post">
            <input type="hidden" name="numero_perguntas" value="<?php echo $data['perguntas']; ?>">
            <input type="hidden" name="turmas_gabarito" value="<?php echo implode(",", $data['turmas']); ?>">
            <input type="hidden" name="valor_prova" value="<?php echo $data["valor"]; ?>">
            <input type="hidden" name="nome_prova" value="<?php echo $data["nome_prova"]; ?>">
            <input type="hidden" name="materia_prova" value="<?php echo $data["materia"]; ?>">
            <input type="hidden" name="descritor" value="<?php echo $data["descritores"]; ?>">

            <div class="tabela-gabarito">
            <h3><i class="fas fa-pencil-alt"></i> Preencha o gabarito abaixo</h3>
                <table class="tabela-alternativas-escolher">
                    <?php $contador = 1;
        while ($contador <= $data["perguntas"]) {?>
                    <tr>
                        <td><span><?php echo $contador ?></span></td>
                        <?php if ($data["descritores"] == "sim") {?>
                        <td>
                            <div class="campos-selecionar-descritores">
                                <input type="text" class="searchInput" required data-index="<?php echo $contador ?>"
                                    name="DESCRITOR_<?php echo "{$contador}" ?>" maxlength="8" placeholder="DESCRITOR">
                            </div>
                        </td>
                        <?php }?>
                        <?php foreach($data["alternativas"] as $a){?>
                        <td>
                            <div class="Ds">
                                <input type="radio" id="<?= $a?>_<?php echo "{$contador}" ?>"
                                    name="<?php echo "{$contador}" ?>" required
                                    value="<?php echo "{$contador},{$a}" ?>">
                                <label for="<?= $a?>_<?php echo "{$contador}" ?>"><?= $a?></label>
                            </div>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php $contador++;}?>
                </table>

                <div class="alerta">
                        <h3><i class="fas fa-exclamation-triangle"></i> Revise todas as respostas antes de enviar!</h3>
                    </div>
                    <br>


            <br><br><br>
            <center>
                <input type="submit" value="Criar Gabarito" class="botao-form-enviar">
            </center>
            </div>
            </form>
    </div>
    <br><br><br>
</main>