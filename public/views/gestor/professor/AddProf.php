<div class="container-gestor-info">

  <h1>Formulário de Inserção de Professor</h1>

  <form action="adicionar_professor" method="post" class="formulario-add-professor">

    <div class="campo-formulario-add">
      <label for="username">Nome de Usuário:</label>
      <input type="text" id="username" name="user" class="input-add" required>
    </div>

    <div class="campo-formulario-add">
      <label for="nome">Nome Completo:</label>
      <input type="text" id="nome" name="nome" class="input-add" required>
    </div>

    <div class="campo-formulario-add">
      <label for="cpf">CPF:</label>
      <input type="text" id="cpf" name="cpf" maxlength="14" class="input-add" required>
    </div>

    <div class="campo-formulario-add">
      <label for="telefone">Número de Telefone:</label>
      <input type="tel" id="telefone" maxlength="14" name="telefone" class="input-add" required>
    </div>

    <div class="campo-formulario-add">
      <span>Disciplina(s) do professor:</span>
      <?php
      include "../../../../vendor/autoload.php";
      use app\controllers\monitoramento\GestorController;
      $materias = GestorController::GetMaterias();
       if($materias != NULL){ ?>
      <div class="input-checkbox-materias">
        <?php
        foreach ($materias as $materia) { ?>
        <div>
        <input class="input-checkbox" type="checkbox" name="materias-professor[]" value="<?php echo $materia["nome"] ?>">
          <span><?php echo $materia["nome"] ?></span>
        </div>
        <?php } ?>
      </div>
        <?php } else{ ?>
            <h1>NENHUMA DISCIPLINA ADICIONADA! <br> </h1>

          <?php }?>

    </div>
    
    <?php if($materias != NULL){?>

    <div class="campo-formulario-add">
      <button type="submit" class="botao-form-enviar">Inserir Professor</button>
    </div>
    <?php }?>

  </form>

</div>