<div class="container-gestor-info">
    <h1>Formulário de Inserção de Turmas</h1>

    <form action="adicionar_turma" method="post" class="formulario-add-professor">

        <div class="campo-formulario-add">
          <div>
            <center>
              <label class="label-select" for="curso">Série:</label>
            </center>
            <input type="checkbox" class="input-checkbox" name="SERIE-TURMA[]" value=""> <span>1º</span>
            <input type="checkbox" class="input-checkbox" name="SERIE-TURMA[]" value=""> <span>2º</span>
            <input type="checkbox" class="input-checkbox" name="SERIE-TURMA[]" value=""> <span>3º</span>
          </div>
        </div>

        <div class="campo-formulario-add">
          <div>
            <center>
              <label class="label-select" for="curso">Turno da turma:</label>
            </center>
            <input type="checkbox" class="input-checkbox" name="SERIE-TURMA[]" value=""> <span>INTERMEDIÁRIO</span>
            <input type="checkbox" class="input-checkbox" name="SERIE-TURMA[]" value=""> <span>VESPERTINO</span>
            <input type="checkbox" class="input-checkbox" name="SERIE-TURMA[]" value=""> <span>NOTURNO</span>
          </div>
        </div>

        <div class="campo-formulario-add">
          <div>
            <center>
              <label class="label-select" for="curso">Curso da Turma:</label>
            </center>
            <input type="checkbox" class="input-checkbox" name="SERIE-TURMA[]" value=""> <span>INFORMATICA</span>
            <input type="checkbox" class="input-checkbox" name="SERIE-TURMA[]" value=""> <span>ADMINISTRAÇÃO
            </span>
            <input type="checkbox" class="input-checkbox" name="SERIE-TURMA[]" value=""> <span>HUMANAS</span>
          </div>
        </div>
 
       

        <div class="campo-formulario-add">
            <button type="submit" class="botao-form-enviar">Inserir Matéria</button>
        </div>

    </form>

</div>