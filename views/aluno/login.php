<main class="main">

    <div id="campo-ra" class="login-aluno">
        <h1>LOGIN - ALUNO</h1>

        <div class="campo-ra">
            <input class="input-campo-aluno" id="RA" type="text" placeholder="Digite Seu RA" required>
        </div>

        <input type="submit">
        <button onclick="Mostrar_campo_email()" class="button-enter-email">Entrar com Email e Senha</button>
        <br>
        <a class="Botao-voltar-lobby" href="home">Voltar</a>

    </div>

    <div id="campo-email" class="login-aluno">
        <h1>LOGIN - ALUNO</h1>

        <div class="campo-ra">
            <input class="input-campo-aluno" type="text" placeholder="Digite Seu Email" required>
            <input class="input-campo-aluno" type="text" placeholder="Digite Sua Senha" required>
        </div>

        <input type="submit">
        <button onclick="Mostrar_campo_ra()" class="button-enter-email">Entrar com RA</button>
        <br>
        <a class="Botao-voltar-lobby" href="home">Voltar</a>
    </div>

</main>