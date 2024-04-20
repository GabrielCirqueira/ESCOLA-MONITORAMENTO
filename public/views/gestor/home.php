<main class="main-home">

  <section class="gestor-main">
    <div class="menu-lateral-gestor">

      <form action="Gestor_info" method="post">

          <button type="submit" class="button-menu-lateral" name="pag" value="VisaoGeral">VISÃO GERAL</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="addprof">ADD PROF</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="professores">PROFESSORES</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="addturma">TURMAS</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="addturma">ADD TURMA</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="addaluno">ADD ALUNO</button>
          <button type="submit" class="button-menu-lateral" name="pag" value="addmateria">ADD DISCIPLINA</button>
    
      </form>

      <!-- <button onclick="Mostrar_container_gestor('container-gestor-01')" class="button-menu-lateral">VISÃO GERAL</button>
      <button onclick="Mostrar_container_gestor('container-gestor-02')" class="button-menu-lateral">ADD PROF</button>
      <button onclick="Mostrar_container_gestor('container-gestor-02')" class="button-menu-lateral">PROFESSORES</button>
      <button onclick="Mostrar_container_gestor('container-gestor-03')" class="button-menu-lateral">ADD TURMA</button>
      <button onclick="Mostrar_container_gestor('container-gestor-04')" class="button-menu-lateral">ADD ALUNO</button>
      <button onclick="Mostrar_container_gestor('container-gestor-05')" class="button-menu-lateral">DESCRITORES</button> -->
    </div>
    <div class="info-gestor">

        <?php 
          require_once $info;
        ?>

    </div>
  </section>

</main>