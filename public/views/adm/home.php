<main class="main-home">
    <section class="gestor-main">
        <div class="menu-lateral-gestor">
            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Alunos</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('alunos')">Alunos</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('provas')">Provas</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('AddAluno')">Adicionar
                    Aluno</button>
            </details>

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Materias</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('materias')">Materia</button>
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

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Banco de Dados</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('database')">Backups</button>
            </details>
        </div>

        <div class="info-gestor">
            <div id="conteudo">

                <div id="verProfessores" class="conteudo-item">
                    <center>
                        <h2>PROFESSORES CADASTRADOS</h2>
                    </center>
                    <div id="filtro-container-materias" class="filtro-container">
                        <input type="text" id="filtroNomeProfessores" class="filtro-nome" placeholder="Filtrar por Nome"
                            oninput="filtrarTabelaProfessores()">
                    </div>
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
                                <td><button class="btn-editar">EDITAR</button></td>
                                <td>
                                    <form action="" method="post">
                                        <button type="submit" name="" value="<?=$disciplina['id']?>"
                                            class="btn-excluir">EXCLUIR</button>
                                    </form>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>

                <div id="materias" class="conteudo-item">
                    <center>
                        <h2>MATERIAS CADASTRADAS</h2>
                    </center>
                    <div id="filtro-container-materias" class="filtro-container">
                        <input type="text" id="filtroNomeMaterias" class="filtro-nome" placeholder="Filtrar por Nome"
                            oninput="filtrarTabelaMaterias()">
                    </div>
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
                                        <button type="submit" name="excluir-materia" value="<?=$disciplina['id']?>"
                                            class="btn-excluir">EXCLUIR</button>
                                    </form>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
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
                        <div class="radio-group">
                            <?php foreach ($data["turmas"]["turmas"] as $turma) {?>
                            <input type="radio" id="turma_add_<?=$turma["nome"]?>" name="turma_adicionar" required
                                value="<?=$turma["nome"]?>">
                            <label for="turma_add_<?=$turma["nome"]?>"><?=$turma["nome"]?></label>
                            <?php }?>
                        </div>
                        <h3>TURNO:</h3>
                        <div class="radio-group">
                            <?php foreach ($data["turnos"] as $turnos) {?>
                            <input type="radio" id="turno_add_<?=$turnos?>" name="turno_adicionar" required
                                value="<?=$turnos?>">
                            <label for="turno_add_<?=$turnos?>"><?=$turnos?></label>
                            <?php }?>
                        </div>
                        <br><br>
                        <center>
                            <button type="submit" class="btn-salvar-adicionar-aluno">Salvar</button>
                        </center>
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
                        <h1>PROVAS FEITAS</h1>
                    </center>
                    <div id="filtro-container-provas" class="filtro-container">
                        <input type="text" id="filtroRAProvas" class="filtro-ra" placeholder="Filtrar por RA"
                            oninput="filtrarTabela('tabelaProvas', 'filtroRAProvas', 'filtroNomeProvas')">
                        <input type="text" id="filtroNomeProvas" class="filtro-nome" placeholder="Filtrar por Nome"
                            oninput="filtrarTabela('tabelaProvas', 'filtroRAProvas', 'filtroNomeProvas')">
                    </div>
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
                                <td><button class="btn-editar">EDITAR</button>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
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
                                    <td><a href='app/config/backups/<?=$arquivo['arquivo']?>' download>Download</a></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="painel-frontal-gestor conteudo-item active">
                    <img src="https://telegra.ph/file/14ab586a79f8002b24880.png" alt="IMAGEM BRAZÃO">
                    <h1>PAINEL GESTOR</h1>
                </div>


            </div>
    </section>
</main>