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
                            <?= $prova["disciplina"]?>
                        </span> <br>
                        <span class="prova-nome-professor">
                        <?= $prova["nome_professor"]?>
                        </span>
                    </div>

                    <div class="button-ver-prova">
                        <button>Ver</button>
                    </div>
                </div>
            </div>
            <br>

    <?php }
    }

    ?>


</main>