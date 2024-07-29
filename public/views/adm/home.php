<?php $materias = $data["disciplinas"];
usort($materias, function ($a, $b) {return strcmp($a['nome'], $b['nome']);});?>
<main class="main-home">
    <section class="gestor-main">
        <div class="menu-lateral-gestor">
        <details class="details-menu-gestor"  >
                <summary class="sumary-menu-gestor">Tela Inicial</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('painel-frontal-gestor')">Painel</button>
            </details>
            <details class="details-menu-gestor"  >
                <summary class="sumary-menu-gestor">Alunos</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('alunos')">Alunos</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('provas')">Provas</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('AddAluno')">Adicionar
                    Aluno</button>
            </details>

            <details class="details-menu-gestor"  >
                <summary class="sumary-menu-gestor">Materias</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('materias')">Materias</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('adicionarMateria')">Adicionar
                    Materia</button>
            </details>

            <details class="details-menu-gestor"  >
                <summary class="sumary-menu-gestor">Professor</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('adicionarProfessor')">Adicionar
                    Professor</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('verProfessores')">Ver
                    Professores</button>
            </details>

            <details class="details-menu-gestor"  >
                <summary class="sumary-menu-gestor">Turmas</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('adicionarTurma')">Adicionar
                    Turma</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('verTurmas')">Ver
                    Turmas</button>
            </details>

            <details class="details-menu-gestor"  >
                <summary class="sumary-menu-gestor">Banco de Dados</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('database')">Backups</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('logsADM')">Logs ADM</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('logsProfessor')">Logs
                    Professor</button>
            </details>
        </div>

        <div class="info-gestor">
            <div id="conteudo">

                <div id="logsADM" class="conteudo-item">
                    <center>
                        <h1>LOGS ADM</h1>
                    </center>

                    <table class="tabela_alunos_adm">

                        <thead>
                            <tr>
                                <th>AUTOR</th>
                                <th>DESCRIÇÃO</th>
                                <th>DATA</th>
                                <th>HORA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data["logsADM"] as $logs) {?>
                            <tr>
                                <td><?=$logs["autor"]?></td>
                                <td><?=$logs["descricao"]?></td>

                                <td> <?=explode(" ", $logs["data"])[0]?> </td>
                                <td> <?=explode(":", explode(" ", $logs["data"])[1])[0] . ":" . explode(":", explode(" ", $logs["data"])[1])[1]?>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <div><br><br><br><br><br><br><br><br><br></div>
                </div>

                <div id="logsProfessor" class="conteudo-item">
                    <center>
                        <h1>LOGS PROFESSOR</h1>
                    </center>

                    <table class="tabela_alunos_adm">

                        <thead>
                            <tr>
                                <th>AUTOR</th>
                                <th>DESCRIÇÃO</th>
                                <th>DATA</th>
                                <th>HORA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data["logsPROF"] as $logs) {?>
                            <tr>
                                <td><?=$logs["autor"]?></td>
                                <td><?=$logs["descricao"]?></td>

                                <td> <?=explode(" ", $logs["data"])[0]?> </td>
                                <td> <?=explode(":", explode(" ", $logs["data"])[1])[0] . ":" . explode(":", explode(" ", $logs["data"])[1])[1]?>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <div><br><br><br><br><br><br><br><br><br></div>
                </div>

                <div id="verTurmas" class="conteudo-item">
                    <center>
                        <h1>TURMAS CADASTRADAS</h1>
                    </center>
                    <?php if ($data["turmas"]["turmas"] != null) {?>

                    <table class="tabela_alunos_adm">

                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>TURNO</th>
                                <th>SERIE</th>
                                <th>CURSO</th>
                                <th>EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data["turmas"]["turmas"] as $turma) {?>
                            <tr>
                                <td><?=$turma["nome"]?></td>
                                <td><?=$turma["turno"]?></td>
                                <td><?=$turma["serie"]?>º SÉRIE</td>
                                <td><?=$turma["curso"]?></td>
                                <td>
                                    <form action="" method="post"> <button type="submit" name="excluir-turma"
                                            value="<?=$turma['id']?>;<?=$turma["nome"]?>"
                                            class="btn-excluir">EXCLUIR</button></form>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>

                    <?php } else {?>
                    <center>
                        <h2 class="back-red">NENHUMA TURMA CADASTRADA!</h2>
                    </center>
                    <?php }?>
                    <div><br><br><br><br><br><br><br><br><br></div>

                </div>

                <div id="adicionarTurma" class="conteudo-item">

                    <div id="buttons-turmas-escolher" class="buttons-turmas-escolher">
                        <button onclick="AlterarModoAddTurma('inserir-turma-manualmente','ocultar')">Formar Nome
                            Automaticamente</button>
                        <button onclick="AlterarModoAddTurma('inserir-turma-manualmente','mostrar')">Digitar Nome
                            Manualmente</button>
                    </div>

                    <div id="inserir-turma-automaticamente">

                        <form action="" method="post" class="form-adicionar-aluno">
                            <h1>Inserção de Turmas</h1><br><br>

                            <center>

                                <div id="inserir-turma-manualmente" class="hidden">
                                    <div class="form-group-add-materia">
                                        <input type="text" id="nomeTurma" name="nomeTurma"
                                            placeholder="Digite o nome da Turma">
                                    </div>
                                </div>
                            </center>

                            <h3>SÉRIE DA TURMA:</h3>
                            <div class="radio-group">
                                <?php foreach ($data["Nseries"] as $serie) {?>
                                <input type="radio" id="<?=$serie?>Serie" name="serie_turma" required
                                    value="<?=$serie?>">
                                <label for="<?=$serie?>Serie"><?=$serie?>º SÉRIE</label>
                                <?php }?>
                            </div>

                            <h3>TURNO DA TURMA:</h3>
                            <div class="radio-group">
                                <?php foreach ($data["turnos"] as $turno) {?>
                                <input type="radio" id="turno_turma_<?=$turno?>" name="turno_adicionar" required
                                    value="<?=$turno?>">
                                <label for="turno_turma_<?=$turno?>"><?=$turno?></label>
                                <?php }?>
                            </div>

                            <h3>CURSO DA TURMA:</h3>
                            <div class="radio-group">
                                <?php foreach ($data["cursos"] as $curso) {?>
                                <input type="radio" id="curso_<?=$curso?>" name="curso_turma" required
                                    value="<?=$curso?>">
                                <label for="curso_<?=$curso?>"><?=$curso?></label>
                                <?php }?>
                            </div>

                            <h3>NUMERO DA TURMA:</h3>
                            <div class="radio-group">
                                <?php foreach ($data["NTurmas"] as $num) {?>
                                <input type="radio" id="NTurma_<?=$num?>" name="numero_turma" required
                                    value="<?=$num?>">
                                <label for="NTurma_<?=$num?>"><?=$num?>º TURMA</label>
                                <?php }?>
                            </div>
                            <br><br><br>
                            <div class="campo-formulario-add">
                                <button type="submit" name="enviar-turma-add" class="submit-button-add-materia">Inserir
                                    Turma</button>
                            </div>
                            <br><br><br><br><br><br>
                        </form>
                    </div>


                </div>

                <div id="adicionarProfessor" class="conteudo-item">
                    <div class="form-adicionar-professor">
                        <center>
                            <h1>Adicionar Professor</h1>
                        </center>
                        <form action="" method="post">
                            <div class="labels-styles">
                                <input type="text" name="nome_professor" placeholder="Nome do professor" required
                                    id="nome_professor_add">

                                <input type="text" name="usuario_acesso" placeholder="Usuario de Acesso" required
                                    id="usuario_acesso">

                                <input type="text" name="senha_acesso" placeholder="Senha de Acesso" required
                                    id="senha_acesso">
                            </div>

                            <h2>Matérias</h2>
                            <?php if ($data["disciplinas"] != null) {?>

                            <center>

                                <div class="checkbox-group-disciplinas">
                                    <?php foreach ($materias as $disciplina) {?>
                                    <div class="disciplina-box">
                                        <input type="checkbox" id="disciplina_professor_<?=$disciplina["nome"]?>"
                                            name="disciplina_professor[]" value="<?=$disciplina["nome"]?>">
                                        <label for="disciplina_professor_<?=$disciplina["nome"]?>">
                                            <div><span><?=$disciplina["nome"]?></span></div>
                                        </label>
                                    </div>
                                    <?php }?>
                                </div>
                            </center>
                            <br><br>
                            <br><br>
                            <button type="submit" name="Enviar-professor" class="submit-button-add-materia">Adicionar
                                Professor</button>

                            <?php } else {?>
                            <center>
                                <h3 class="back-red" style="width: 70%;color:black;">CADASTRE PELO MENOS UMA MATÉRIA
                                    ANTES DE INSERIR O PROFESSOR!</h3>
                            </center>
                            <?php }?>
                        </form>
                        <div>
                            <br><br>
                            <br><br>
                            <br><br>
                            <br><br>
                            <br><br>
                            <br><br>

                        </div>
                    </div>
                </div>

                <div id="verProfessores" class="conteudo-item">

                    <center>
                        <h2 id="titulo-professor">PROFESSORES CADASTRADOS</h2>
                    </center>
                    <div id="filtro-professor" class="filtro-container">
                        <input type="text" id="filtroNomeProfessores" class="filtro-nome" placeholder="Filtrar por Nome"
                            oninput="filtrarTabelaProfessores()">
                    </div>
                    <?php if ($data["professores"] != null) {?>

                    <table id="tabelaProfessores" class="tabela_alunos_adm">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>DISCIPLINA</th>
                                <th>USUARIO</th>
                                <th>SENHA</th>
                                <th>EDITAR</th>
                                <th>EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data["professores"] as $professor) {?>
                            <tr>
                                <td><?=$professor["nome"]?></td>
                                <td>
                                    <?php
$disciplinas = explode(";", $professor["disciplinas"]);
    echo count($disciplinas) . " DISCIPLINA(S)";
    ?>
                                </td>
                                <td><?=$professor["numero"]?></td>
                                <td><?=$professor["senha"]?></td>
                                <td><button
                                        onclick="ColocarDadosProf('<?=$professor['id']?>','<?=$professor['nome']?>','<?=$professor['numero']?>','<?=$professor['senha']?>','<?=$professor['disciplinas']?>')"
                                        class="btn-editar">EDITAR</button></td>
                                <td>
                                    <form action="" method="post">
                                        <button type="submit" name="excluir_professor"
                                            value="<?=$professor['id']?>;<?=$professor["nome"]?>"
                                            class="btn-excluir">EXCLUIR</button>
                                    </form>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>

                    </table>

                    <?php } else {?>
                    <center>
                        <h2 class="back-red">NENHUM PROFESSOR CADASTRADO!</h2>
                    </center>
                    <?php }?>
                    <div id="brs"><br><br><br><br><br><br><br><br><br><br><br><br></div>
                    <div id="form-editar-professor" class="form-editar-professor hidden">
                        <center>
                            <h1>Editar Professor</h1>
                            <form action="" method="post">
                                <input type="hidden" id="id-professor-editar" name="id" value="">
                                <input type="text" name="nome_professor" placeholder="Nome do professor" required
                                    id="nome_professor_editar_add">
                                <input type="text" name="usuario_acesso" placeholder="Usuario de Acesso" required
                                    id="usuario_acesso_editar">
                                <input type="text" name="senha_acesso" placeholder="Senha de Acesso" required
                                    id="senha_acesso_editar">

                                <h2>Disciplinas</h2>
                                <div class="checkbox-group-disciplinas">
                                    <?php foreach ($materias as $disciplina) {?>
                                    <div class="disciplina-box">
                                        <input type="checkbox" id="disciplina_professor_editar_<?=$disciplina["nome"]?>"
                                            name="disciplina_professor_editar[]" value="<?=$disciplina["nome"]?>">
                                        <label for="disciplina_professor_editar_<?=$disciplina["nome"]?>">
                                            <div><span><?=$disciplina["nome"]?></span></div>
                                        </label>
                                    </div>
                                    <?php }?>
                                </div>
                        </center>
                        <br><br><br><br>
                        <center>
                            <div class="buttons-editar">
                                <button type="submit" name="Enviar-edit-professor"
                                    class="btn-editar item">Salvar</button>
                                <button type="button" class="btn-excluir item"
                                    onclick="cancelarEdicao()">Cancelar</button>
                            </div>
                        </center>
                        </form>
                        <div>
                            <br><br><br><br><br><br><br><br><br><br><br><br>
                        </div>
                    </div>
                </div>

                <div id="materias" class="conteudo-item">

                    <center>
                        <h2>MATERIAS CADASTRADAS</h2>
                    </center>
                    <div id="filtro-container-materias" class="filtro-container">
                        <input type="text" id="filtroNomeMaterias" class="filtro-nome" placeholder="Filtrar por Nome"
                            oninput="filtrarTabelaMaterias()">
                    </div>
                    <?php if ($data["disciplinas"] != null) {?>

                    <table id="tabelaMaterias" class="tabela_alunos_adm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOME</th>
                                <th>EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data["disciplinas"] as $disciplina) {?>
                            <tr>
                                <td><?=$disciplina["id"]?></td>
                                <td><?=$disciplina["nome"]?></td>
                                <td>
                                    <form action="" class="form-excluir-materia" method="post">
                                        <button type="submit" name="excluir-materia"
                                            value="<?=$disciplina['id']?>;<?=$disciplina["nome"]?>"
                                            class="btn-excluir">EXCLUIR</button>
                                    </form>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php } else {?>
                    <center>
                        <h2 class="back-red">NENHUMA MATERIA CADASTRADA!</h2>
                    </center>
                    <?php }?>
                </div>

                <div id="adicionarMateria" class="conteudo-item">
                    <div class="form_add_materia_adm">
                        <form id="formAddMateria" action="" method="post">
                            <h1 class="form-title-add-materia">Adicionar Nova Matéria</h1>
                            <br>
                            <div class="form-group-add-materia">
                                <input type="text" id="nomeMateria" name="nomeMateria"
                                    placeholder="Digite o nome da matéria" required>
                            </div>
                            <br>
                            <button type="submit" name="Enviar-materia" class="submit-button-add-materia">Adicionar
                                Matéria</button>
                        </form>
                    </div>

                </div>

                <div id="AddAluno" class="conteudo-item">
                    <form action="adicionar_aluno" method="post" class="form-adicionar-aluno">
                        <h1>Adicionar Aluno</h1>
                        <div class="input-group-adicionar-aluno">
                            <h3>RA</h3>
                            <input type="text" name="ra" id="adicionarRA" placeholder="RA" required>
                        </div>
                        <div class="input-group-adicionar-aluno">
                            <h3>NOME DO ALUNO</h3>
                            <input type="text" name="nome" id="adicionarNome" placeholder="Nome" required>
                        </div>
                        <div class="input-group-adicionar-aluno">
                            <h3>DATA DE NASCIMENTO</h3>
                            <input type="date" name="data_nasc" id="adicionarDataNasc" placeholder="Data de Nascimento">
                        </div>
                        <h3>TURMA:</h3>
                        <?php if ($data["turmas"]["turmas"] != null) {?>

                        <div class="radio-group">
                            <?php foreach ($data["turmas"]["turmas"] as $turma) {?>
                            <input type="radio" id="turma_add_<?=$turma["nome"]?>" name="turma_adicionar" required
                                value="<?=$turma["nome"]?>">
                            <label for="turma_add_<?=$turma["nome"]?>"><?=$turma["nome"]?></label>
                            <?php }?>
                        </div>
                        <?php } else {?>
                        <center>
                            <h3 class="back-red">CADASTRE PELO MENOS UMA TURMA ANTES DE CONTINUAR A CADASTRAR O
                                ALUNO!</h3>
                        </center>
                        <?php }?>
                        <h3>TURNO:</h3>
                        <div class="radio-group">
                            <?php foreach ($data["turnos"] as $turnos) {?>
                            <input type="radio" id="turno_add_<?=$turnos?>" name="turno_adicionar" required
                                value="<?=$turnos?>">
                            <label for="turno_add_<?=$turnos?>"><?=$turnos?></label>
                            <?php }?>
                        </div>
                        <br><br>

                        <?php if ($data["turmas"]["turmas"] != null) {?>

                        <center>
                            <button type="submit" class="btn-salvar-adicionar-aluno">Salvar</button>
                        </center>

                        <?php } else {?>
                        <?php }?>
                        <br><br><br><br><br><br><br><br><br>
                    </form>
                </div>

                <div id="alunos" class="conteudo-item">
                    <center>
                        <h1>ALUNOS</h1>
                        <div id="filtro-container-alunos" class="filtro-container">
                            <input type="text" id="filtroRAAlunos" class="filtro-ra" placeholder="Filtrar por RA"
                                oninput="filtrarTabela('tabelaAlunos', 'filtroRAAlunos', 'filtroNomeAlunos')">
                            <input type="text" id="filtroNomeAlunos" class="filtro-nome" placeholder="Filtrar por Nome"
                                oninput="filtrarTabela('tabelaAlunos', 'filtroRAAlunos', 'filtroNomeAlunos')">
                        </div>
                    </center>
                    <?php if ($data["alunos"]["alunos"] != null) {?>
                    <table id="tabelaAlunos" class="tabela_alunos_adm">

                        <thead>
                            <tr>
                                <th>RA</th>
                                <th>ALUNO</th>
                                <th>TURMA</th>
                                <th>EDITAR</th>
                                <th>EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data["alunos"]["alunos"] as $aluno) {?>
                            <tr>
                                <td><?=$aluno["ra"]?></td>
                                <td><?=$aluno["nome"]?></td>
                                <td><?=$aluno["turma"]?></td>
                                <td><button class="btn-editar"
                                        onclick="editarAluno('<?=$aluno["ra"]?>', '<?=$aluno["nome"]?>', '<?=$aluno["turma"]?>', '<?=$aluno["turno"]?>', '<?=$aluno["data_nasc"]?>')">EDITAR</button>
                                </td>
                                <td>
                                    <form action="" method="post"><button type="submit"
                                            value="<?=$aluno["ra"]?>;<?=$aluno["nome"]?>" name="excluir-aluno"
                                            class="btn-excluir">EXCLUIR</button></form>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php } else {?>
                    <center>
                        <h2 class="back-red">NENHUM ALUNO CADASTRADO!</h2>
                    </center>
                    <?php }?>
                    <div id="formEditar" class="form-editar">
                        <form action="editar_dados_aluno" method="post">
                            <h1>EDITAR DADOS DO ALUNO</h1>
                            <div class="input-group">
                                <h3>RA</h3>
                                <input type="text" style="background-color: #BCBCBC;" name="ra" readonly id="editarRA"
                                    placeholder="RA">
                            </div>
                            <div class="input-group">
                                <h3>NOME DO ALUNO</h3>
                                <input type="text" name="nome" id="editarNome" placeholder="Nome">
                            </div>
                            <div class="input-group">
                                <h3>DATA DE NASCIMENTO</h3>
                                <input type="text" id="data" name="data" placeholder="Data de Nascimento">
                            </div>
                            <h3>TURMA:</h3>
                            <div class="radio-group">
                                <?php foreach ($data["turmas"]["turmas"] as $turma) {?>
                                <input type="radio" id="turma_<?=$turma["nome"]?>" name="turma"
                                    value="<?=$turma["nome"]?>">
                                <label for="turma_<?=$turma["nome"]?>"><?=$turma["nome"]?></label>
                                <?php }?>
                            </div>
                            <h3>TURNO:</h3>
                            <div class="radio-group">
                                <?php foreach ($data["turnos"] as $turnos) {?>
                                <input type="radio" id="turno_<?=$turnos?>" name="turno" value="<?=$turnos?>">
                                <label for="turno_<?=$turnos?>"><?=$turnos?></label>
                                <?php }?>
                            </div>
                            <button type="submit" class="btn-editar">Salvar</button>
                            <button type="button" class="btn-excluir" onclick="cancelarEdicao()">Cancelar</button>
                            <br><br><br><br><br><br><br><br><br>
                        </form>
                    </div>
                </div>

                <div id="provas" class="conteudo-item">
                    <center>
                        <h1 id="titulo-provas-feitas">PROVAS FEITAS</h1>
                    </center>
                    <div id="filtro-container-provas" class="filtro-container">
    <input type="text" id="filtroRAProvas" class="filtro-ra" placeholder="Filtrar por RA"
        oninput="filtrarTabela('tabelaProvas', 'filtroRAProvas', 'filtroNomeProvas')">
    <input type="text" id="filtroNomeProvas" class="filtro-nome" placeholder="Filtrar por Nome"
        oninput="filtrarTabela('tabelaProvas', 'filtroRAProvas', 'filtroNomeProvas')">
</div>
                    <?php if ($data["alunos"]["provas_feitas"] != null) {?>

                    <table id="tabelaProvas" class="tabela_alunos_adm">
                        <thead>
                            <tr>
                                <th>RA</th>
                                <th>ALUNO</th>
                                <th>TURMA</th>
                                <th>DATA</th>
                                <th>DISCIPLINA</th>
                                <th>PONTOS</th>
                                <th>EDITAR</th>
                                <th>EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data["alunos"]["provas_feitas"] as $aluno) {?>
                            <tr>
                                <td><?=$aluno["ra"]?></td>
                                <td><?=$aluno["aluno"]?></td>
                                <td><?=$aluno["turma"]?></td>
                                <td><?=$aluno["data_aluno"]?></td>
                                <td><?=$aluno["disciplina"]?></td>
                                <td><?=$aluno["pontos_aluno"]?></td>
                                <td><button class="btn-editar"
                                        onclick="editarProvaAluno('<?=$aluno['ra']?>', '<?=$aluno['perguntas_respostas']?>', '<?=$aluno['aluno']?>','<?=$aluno['id_prova']?>',<?=$aluno['id']?>,'<?=$aluno['disciplina']?>',<?=$aluno['data_aluno']?>)">EDITAR</button>
                                </td>


                                <td>
                                    <form action="" method="post"><button type="submit"
                                            value="<?=$aluno["ra"]?>;<?=$aluno["id_prova"]?>;<?=$aluno["aluno"]?>;<?=$aluno["disciplina"]?>"
                                            name="excluir-prova-aluno" class="btn-excluir">EXCLUIR</button></form>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php } else {?>
                    <center>
                        <h2 class="back-red">NENHUMA PROVA CADASTRADA!</h2>
                    </center>
                    <?php }?>

                    <div id="editar-prova-aluno" class="hidden">
                        <center>
                            <h1>EDITAR PROVA</h1>
                            <h3 id="nome-aluno-editar"></h3>
                            <h4 id="disciplina_prova"></h4>
                            <h4 id="data_aluno"></h4>
                            <form method="post" action="">
                                <input type="hidden" name="ra" id="ra_prova" value="">
                                <input type="hidden" name="id_prova" id="id_prova" value="">
                                <input type="hidden" name="nome_aluno_prova" id="nome_aluno_prova" value="">
                                <input type="hidden" name="id_aluno_prova" id="id_aluno_prova" value="">
                                <div id="tabela-alternativar-editar">

                                </div>
                                <br><br>
                                <div class="buttons-editar">
                                    <button type="submit" class="btn-editar item"
                                        name="enviar-prova-editada">Salvar</button>
                                    <button type="button" class="btn-excluir item" name="enviar-prova-editada"
                                        onclick="cancelarEdicao()">Cancelar</button>
                                </div>
                        </center>
                        </form>
                        <div>
                            <br><br><br><br><br><br>
                        </div>
                    </div>
                </div>

                <div id="database" class="conteudo-item">
                    <center>
                        <h1>BACKUPS BANCO DE DADOS</h1>
                    </center>
                    <div class="area-adm-backups">
                        <table>
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Minuto</th>
                                    <th>Tamanho</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data["backups"] as $arquivo): ?>
                                <tr>
                                    <td><?=$arquivo['data']?></td>
                                    <td><?=$arquivo['hora']?></td>
                                    <td><?=$arquivo['minuto']?></td>
                                    <td><?=$arquivo['tamanho']?></td>
                                    <td><a href='app/config/backups/<?=$arquivo['arquivo']?>' download>Download</a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="painel-frontal-gestor" class="painel-frontal-gestor conteudo-item active">
    <img src="https://telegra.ph/file/14ab586a79f8002b24880.png" alt="IMAGEM BRAZÃO">
    <h1>PAINEL ADMINISTRATIVO</h1>
    <div class="painel-buttons">
        <button class="painel-button" onclick="mostrarConteudo('alunos')">Alunos</button>
        <button class="painel-button" onclick="mostrarConteudo('provas')">Provas</button>
        <button class="painel-button" onclick="mostrarConteudo('AddAluno')">Adicionar Aluno</button>
        <button class="painel-button" onclick="mostrarConteudo('materias')">Materias</button>
        <button class="painel-button" onclick="mostrarConteudo('adicionarMateria')">Adicionar Materia</button>
        <button class="painel-button" onclick="mostrarConteudo('adicionarProfessor')">Adicionar Professor</button>
        <button class="painel-button" onclick="mostrarConteudo('verProfessores')">Ver Professores</button>
        <button class="painel-button" onclick="mostrarConteudo('adicionarTurma')">Adicionar Turma</button>
        <button class="painel-button" onclick="mostrarConteudo('verTurmas')">Ver Turmas</button>
        <button class="painel-button" onclick="mostrarConteudo('database')">Backups</button>
        <button class="painel-button" onclick="mostrarConteudo('logsADM')">Logs ADM</button>
        <button class="painel-button" onclick="mostrarConteudo('logsProfessor')">Logs Professor</button>
        <br><br><br>
        <br><br><br>
    </div>
        <br><br><br>
        <br><br><br>
    </div>




            </div>
    </section>
</main>