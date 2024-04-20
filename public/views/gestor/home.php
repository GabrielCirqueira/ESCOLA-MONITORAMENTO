<main class="main-home">

    <section class="gestor-main">
        <div class="menu-lateral-gestor">
            <button onclick="Mostrar_container_gestor('container-gestor-01')" class="button-menu-lateral">VISÃO GERAL</button>
            <button onclick="Mostrar_container_gestor('container-gestor-02')" class="button-menu-lateral">ADD PROF</button>
            <button onclick="Mostrar_container_gestor('container-gestor-03')" class="button-menu-lateral">ADD TURMA</button>
            <button onclick="Mostrar_container_gestor('container-gestor-04')" class="button-menu-lateral">ADD ALUNO</button>
            <button onclick="Mostrar_container_gestor('container-gestor-05')" class="button-menu-lateral">DESCRITORES</button>
        </div>
        <div class="info-gestor">
            <div id="container-gestor-01" class="container-gestor-info">
                <h1>VISÃO GERAL</h1>
            </div>


            <div id="container-gestor-02" class="container-gestor-info">
            <h1 class="titulo-formulario">Formulário de Inserção de Professor</h1>
  <form action="#" method="POST" class="formulario-professor">
    <div class="campo-formulario">
      <label for="username" class="rotulo">Nome de Usuário:</label>
      <input type="text" id="username" name="username" class="campo-texto" required>
    </div>
    <div class="campo-formulario">
      <label for="nome" class="rotulo">Nome Completo:</label>
      <input type="text" id="nome" name="nome" class="campo-texto" required>
    </div>
    <div class="campo-formulario">
      <label for="cpf" class="rotulo">CPF:</label>
      <input type="text" id="cpf" name="cpf" class="campo-texto" required>
    </div>
    <div class="campo-formulario">
      <label for="telefone" class="rotulo">Número de Telefone:</label>
      <input type="tel" id="telefone" name="telefone" class="campo-texto" required>
    </div>
    <div class="campo-formulario">
      <button type="submit" class="botao-enviar">Inserir Professor</button>
    </div>
  </form>
            </div>


            <div id="container-gestor-03" class="container-gestor-info">
                <h1>ADICIONAR TURMA</h1>
            </div>


            <div id="container-gestor-04" class="container-gestor-info">
                <h1>ADICIONAR ALUNO</h1>
            </div>


            <div id="container-gestor-05" class="container-gestor-info">
                <h1>DESCRITORES</h1>
            </div>
        </div>
    </section>

</main>