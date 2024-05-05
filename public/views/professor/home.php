<main class="main-home-professor">
    <section>
        <div class="dados-professor">
            <h1>DADOS DO PROFESSOR</h1>
            <h3>Nome:</h3>
            <?php echo $data["nome"] ?></span>
            <h3>Disciplina(s)</h3>
            <?php echo str_replace(";", "<br>", $data["disciplinas"]) ?></span>
            <br>
            <br>
        </div>

        <a href="inserir_gabarito" class="btn-home-professor">INSERIR GABARITO</a> <br>
        <a href="ver_gabarito" class="btn-home-professor">VER GABARITOS</a>

    </section>
</main>