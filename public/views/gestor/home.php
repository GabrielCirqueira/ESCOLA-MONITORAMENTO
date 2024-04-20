<main class="main-home">

  <section class="gestor-main">
    <div class="menu-lateral-gestor">

      <form action="Gestor_info" method="post">

          <button type="submit" class="button-menu-lateral" value="geral">VISÃO GERAL</button>
          <button type="submit" class="button-menu-lateral" value="addprof">ADD PROF</button>
          <button type="submit" class="button-menu-lateral" value="professores">PROFESSORES</button>
          <button type="submit" class="button-menu-lateral" value="addturma">ADD TURMA</button>
          <button type="submit" class="button-menu-lateral" value="addaluno">ADD ALUNO</button>
    
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
        
          include $info;
        ?>

    </div>
  </section>

</main>