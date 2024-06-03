<body>
  <header class="header">

    <div class="menu">
      <?php if ($user != "ALUNO" && $user != "home") { ?>
        <i class="fas fa-bars fa-2x" id="icone-menu-esquerdo-lateral" style="color:gray;width:20px"></i>

      <?php } ?>
    </div>

    <div class="img-tile">

      <img src="public/assents/img/imagem3.png" alt="">
      <h1 class="header__title">ESCOLA NSL</h1>
      </a>

    </div>

    <!-- <h4>SISTEMA DE MONITORAMENTO</h4> -->

    <div class="user">
      <?php if ($user != "home") { ?>
        <i class="far fa-user fa-2x" id="icone-menu-lateral" style="color:gray"></i>
      <?php } ?>
    </div>

  </header>
  <div class="boton-header"></div>


  <!-- MENU LATERAL -->


  <div id="area_menu_lateral" class="area_menu_lateral"></div>

  <div id="menu-lateral-icone-conteudo" class="menu-lateral-main">

    <div class="icone-menu-lateral-fechar">
      <i class="fas fa-times fa-2x" style="color: gray;"></i>
    </div>

    <div class="conteudo-menu-lateral">

      <div class="menu-lateral-main-header">

        <div>
          <img src="public/assents/img/imagem3.png" alt="BRAZÃO NSL">
        </div>

        <h2>Perfil</h2>
      </div>
      <div class="menu-lateral-main-main">
        <?php if ($user == "ALUNO") { ?>
          <h4>NOME:</h4>
          <span><?= $_SESSION["nome_aluno"] ?></span>
          <hr>
          <h4>RA:</h4>
          <span><?= $_SESSION["ra"] ?></span>
          <hr>
          <h4>TURMA:</h4>
          <span><?= $_SESSION["turma"] ?></span>
          <hr>
          <br>

        <?php } else if ($user == "PROFESSOR") { ?>
          <h4>NOME:</h4>
          <span><?= $_SESSION["nome_professor"] ?></span>
          <hr>
          <h4>DISCIPLINA(S):</h4>
          <span>
            <?php

            if (strpos($_SESSION["disciplinas"], ";")) {
              $materias = explode(";", $_SESSION["disciplinas"]);
              foreach ($materias as $materia) { ?>
                <span><?= $materia ?> <br> </span>
              <?php }
            } else { ?>
              <span><?= $_SESSION["disciplinas"] ?></span>
            <?php } ?>
          </span>
          <hr>
        <?php } else if ($user == "GESTOR") { ?>


        <?php } ?>
        <br>
        <?php $_SESSION["USUARIO"] = $user ?>
        <a class="button-sair-menu" href="encerrar_sessao">Sair</a>

      </div>

      <div class="menu-lateral-main-footer">
        Gabriel Cirqueira $)
      </div>
    </div>

  </div>

  <div id="menu-lateral-esquerdo-icone-conteudo" class="menu-lateral-esquerdo-main">



    <div class="conteudo-menu-lateral-erquerdo">

      <div class="menu-lateral-main-header">

        <div>
          <img src="public/assents/img/imagem3.png" alt="BRAZÃO NSL">
        </div>

        <h2>MENU</h2>
      </div>
      <div class="menu-lateral-main-main">

        <div class="menu-lateral-esquerdo-botoes" >

          <?php if ($user == "GESTOR") { ?>
            <a class="button-menu" href="gestor_home">DESEMPENHO ESCOLAR</a>
            <hr>
            <a class="button-menu" href="gestor_descritores">DESEMPENHO DESCRITORES</a>
          <?php } else if ($user == "PROFESSOR") { ?>
            <a class="button-menu" href="professor_home">TELA INICIAL</a>
            <hr>
            <a class="button-menu" href="inserir_gabarito">ADD PROVA</a>
            <hr>
            <a class="button-menu" href="ver_provas">PROVAS</a>
            <hr>
            <a class="button-menu" href="relatorio_professor">RELATORIOS</a> 

          <?php } ?>
        </div>

      </div>

      <div class="menu-lateral-main-footer">
        Gabriel Cirqueira $)
      </div>
    </div>

    <div class="icone-menu-lateral-esquerdo-fechar">
      <i class="fas fa-times fa-2x" style="color: gray;"></i>
    </div>

  </div>