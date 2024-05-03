<main class="main-home">

  <section class="gestor-main">
    <div class="menu-lateral-gestor">

      <details class="details-menu-gestor" >
        <summary class="sumary-menu-gestor" >materias</summary>
        <button class="button-details-menu-gestor" onclick="carregarConteudo('public/views/gestor/materias/materias.php')">materia</button> 
        <button class="button-details-menu-gestor" onclick="carregarConteudo('public/views/gestor/materias/addmateria.php')">adicionar materia</button>
      </details>

      <details class="details-menu-gestor" >
        <summary class="sumary-menu-gestor" >Professor</summary>
        <button class="button-details-menu-gestor" onclick="carregarConteudo('public/views/gestor/professor/AddProf.php')">Adicionar Professor</button>
        <button class="button-details-menu-gestor" onclick="carregarConteudo('public/views/gestor/professor/Professores.php')">Ver professores</button>
      </details>

      <details class="details-menu-gestor" >
        <summary class="sumary-menu-gestor" >Turmas</summary>
        <button class="button-details-menu-gestor" onclick="carregarConteudo('public/views/gestor/turmas/AddTurma.php')">Adicionar Turma</button>
        <button class="button-details-menu-gestor" onclick="carregarConteudo('public/views/gestor/professor/Professores.php')">Ver Turmas</button>
      </details>


      <!-- 
      <form action="Gestor_info" method="post">

          <button type="submit" class="button-menu-lateral" name="pag" value="VisaoGeral">VISÃO GERAL</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="addprof">ADD PROF</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="professores">PROFESSORES</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="addturma">TURMAS</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="addturma">ADD TURMA</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="addaluno">ADD ALUNO</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="materias">DISCIPLINAS</button>
    
      </form> -->

      <!-- <button onclick="Mostrar_container_gestor('container-gestor-01')" class="button-menu-lateral">VISÃO GERAL</button>
      <button onclick="Mostrar_container_gestor('container-gestor-02')" class="button-menu-lateral">ADD PROF</button>
      <button onclick="Mostrar_container_gestor('container-gestor-02')" class="button-menu-lateral">PROFESSORES</button>
      <button onclick="Mostrar_container_gestor('container-gestor-03')" class="button-menu-lateral">ADD TURMA</button>
      <button onclick="Mostrar_container_gestor('container-gestor-04')" class="button-menu-lateral">ADD ALUNO</button>
      <button onclick="Mostrar_container_gestor('container-gestor-05')" class="button-menu-lateral">DESCRITORES</button> -->
    </div>

    <div class="info-gestor">
      <div id="conteudo">
        <div class="painel-frontal-gestor" >
          <img src="https://telegra.ph/file/14ab586a79f8002b24880.png" alt="IMAGEM BRAZÃO">
          <h1>PAINEL GESTOR</h1>
        </div>
      </div>
    </div>

  </section>
</main>