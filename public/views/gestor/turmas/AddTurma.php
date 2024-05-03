<div class="container-gestor-info">
  <h1>Formulário de Inserção de Turmas</h1>

  <form action="adicionar_turma" method="post" class="formulario-add-professor">

    <div class="campo-formulario-add">
      <h3>Série:</h3>
      <div class="form-radio">
        <div><input class="radio-input" name="serie-turma" type="radio" value="1" ><span>1º</span></div>
        <div><input class="radio-input" name="serie-turma" type="radio" value="2" ><span>2º</span></div>
        <div><input class="radio-input" name="serie-turma" type="radio" value="3" ><span>3º</span></div>
      </div>
    </div>

    <div class="campo-formulario-add">
      <h3>Turno da turma:</h3>
      <div class="form-radio">
        <div><input class="radio-input" name="turno-turma" type="radio" value="INTERMEDIÁRIO" ><span>INTERMEDIÁRIO</span></div>
        <div><input class="radio-input" name="turno-turma" type="radio" value="VESPERTINO" ><span>VESPERTINO</span></div>
        <div><input class="radio-input" name="turno-turma" type="radio" value="NOTURNO" ><span>NOTURNO</span></div>
      </div>
    </div>

    <div class="campo-formulario-add">
      <h3>Curso da Turma:</h3>
      <div class="form-radio">
        <div><input class="radio-input" name="curso-turma" type="radio" value="INFORMÁTICA" ><span>INFORMÁTICA</span></div>
        <div><input class="radio-input" name="curso-turma" type="radio" value="ADMINISTRAÇÃO" ><span>ADMINISTRAÇÃO</span></div>
        <div><input class="radio-input" name="curso-turma" type="radio" value="HUMANAS" ><span>HUMANAS</span></div>
      </div>
    </div>

    <div class="campo-formulario-add">
      <h3>Numero da Turma:</h3>
      <div class="form-radio">
        <div><input class="radio-input" name="numero-turma" type="radio" value="1" ><span>1</span></div>
        <div><input class="radio-input" name="numero-turma" type="radio" value="2" ><span>2</span></div>
        <div><input class="radio-input" name="numero-turma" type="radio" value="3" ><span>3</span></div>
        <div><input class="radio-input" name="numero-turma" type="radio" value="4" ><span>4</span></div>
      </div>
    </div>

    <div class="campo-formulario-add">
      <button type="submit" class="botao-form-enviar">Inserir Turma</button>
    </div>

  </form>
</div>