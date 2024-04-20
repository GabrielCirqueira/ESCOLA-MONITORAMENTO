<div class="container-gestor-info">
    <h1>Formulário de Inserção de Matérias</h1>

    <form action="adicionar_professor" method="post" class="formulario-add-professor">

        <div class="campo-formulario-add">
            <label for="nome">Nome Da Matéria:</label>
            <input type="text" id="nome-materia" name="user" class="input-add" required>
        </div>

        <div class="campo-formulario-add">
            <label class="label-select" for="curso">Curso Relacionado a Matéria:</label>
            <select class="input-select" name="materia-curso" id="curso">
                <option value="HUMANAS">HUMANAS</option>
                <option value="CIÊNCIAS DA NATUREZA">CIÊNCIAS DA NATUREZA</option>
                <option value="LINGUAGENS">LINGUAGENS</option>
                <option value="INFORMÁTICA">INFORMÁTICA</option>
                <option value="ADMINISTRAÇÃO">ADMINISTRAÇÃO</option>
            </select>
        </div>

        <div class="campo-formulario-add">
            <div>
                <span class="titulo-label-input">Selecione o turno da eletiva:</span><br>               
                <input type="checkbox" class="input-checkbox" name="turno[]" value="INTERMEDIÁRIO"> <span>INTERMEDIÁRIO</span> <br>
                <input type="checkbox" class="input-checkbox" name="turno[]" value="VESPERTINO"> <span>VESPERTINO </span> <br>
                <input type="checkbox" class="input-checkbox" name="turno[]" value="NOTURNO"> <span> NOTURNO</span> <br>
                    <br>
            </div>
        </div>

        <div class="campo-formulario-add">
            <button type="submit" class="botao-form-enviar">Inserir Matéria</button>
        </div>

    </form>

</div>