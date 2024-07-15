<main class="main-home">
    <section class="gestor-main">
        <div class="menu-lateral-gestor">

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Alunos</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('alunos')">Alunos</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('provas')">Provas</button>
            </details>

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Materias</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('materia')">Materia</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('adicionarMateria')">Adicionar
                    Materia</button>
            </details>

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Professor</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('adicionarProfessor')">Adicionar
                    Professor</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('verProfessores')">Ver
                    Professores</button>
            </details>

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Turmas</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('adicionarTurma')">Adicionar
                    Turma</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('verTurmas')">Ver Turmas</button>
            </details>
        </div>

        <div class="info-gestor">
            <div id="conteudo">
                <div class="painel-frontal-gestor conteudo-item active">
                    <img src="https://telegra.ph/file/14ab586a79f8002b24880.png" alt="IMAGEM BRAZÃO">
                    <h1>PAINEL GESTOR</h1>
                </div>

                <div id="alunos" class="conteudo-item">
                    <div id="filtro-container" class="filtro-container">
                        <input type="text" id="filtroRA" class="filtro-ra" placeholder="Filtrar por RA"
                            oninput="filtrarAlunos()">
                        <input type="text" id="filtroNome" class="filtro-nome" placeholder="Filtrar por Nome"
                            oninput="filtrarAlunos()">
                    </div>
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
                                        onclick="editarAluno('<?= $aluno["ra"] ?>', '<?= $aluno["nome"] ?>', '<?= $aluno["turma"] ?>', '<?= $aluno["turno"] ?>', '<?= $aluno["data_nasc"] ?>')">EDITAR</button>
                                </td>
                                <td> <button class="btn-excluir">EXCLUIR</button> </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
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
                                <?php foreach($data["turmas"]["turmas"] as $turma) { ?>
                                <input type="radio" id="turma_<?= $turma["nome"] ?>" name="turma"
                                    value="<?= $turma["nome"] ?>">
                                <label for="turma_<?= $turma["nome"] ?>"><?= $turma["nome"] ?></label>
                                <?php } ?>
                            </div>
                            <h3>TURNO:</h3>
                            <div class="radio-group">
                                <?php foreach($data["turnos"] as $turnos) { ?>
                                <input type="radio" id="turno_<?= $turnos ?>" name="turno" value="<?= $turnos ?>">
                                <label for="turno_<?= $turnos ?>"><?= $turnos ?></label>
                                <?php } ?>
                            </div>
                            <button type="submit" class="btn-editar">Salvar</button>
                            <button type="button" class="btn-excluir" onclick="cancelarEdicao()">Cancelar</button>
                        </form>
                    </div>
                </div>



            </div>
    </section>
</main>