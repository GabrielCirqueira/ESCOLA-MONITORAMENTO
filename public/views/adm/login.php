<main class="main">

    <div class="login-aluno peq">
        <h1> ADM</h1>
        <form action="login_adm_verifica" method="post">
            <!-- @csrf -->
            <div class="campo-ra">
                <input class="input-campo-aluno"  name="campo_adm" type="text" placeholder="SENHA" required> 
            </div>

            <input type="submit" value="ENVIAR" >
        </form><br><br>
        <a class="Botao-voltar-lobby" href="ADM"><i class="fas fa-arrow-left" ></i></a>
    </div>

</main>