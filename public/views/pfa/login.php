<main class="main">

    <div class="login-aluno">
        <h1>PFA</h1>

        <form action="validar_login_pfa" method="post">

            <div class="campo-ra">
                <input class="input-campo-aluno" type="text" name="user" id="USER-PFA" required>
                <label class="label-campo-login" for="USER-PFA">Usuário</label>
            </div>
            <div class="campo-ra">
                <input class="input-campo-aluno" type="password" id="SENHA-PFA" name="senha" required>
                <label class="label-campo-login" for="SENHA-PFA">Senha</label>
                </div><br><br>
            <input type="submit" value="ENVIAR" >
        </form><br>
        <a class="Botao-voltar-lobby" href="ADM"><i class="fas fa-arrow-left" ></i></a>

    </div>

</main>
