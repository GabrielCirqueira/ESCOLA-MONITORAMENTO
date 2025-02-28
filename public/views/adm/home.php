<?php $materias = $data["disciplinas"];
usort($materias, function ($a, $b) {return strcmp($a['nome'], $b['nome']);});?>
<main class="main-home">
    <section class="gestor-main">
        <div class="menu-lateral-gestor">
            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Tela Inicial</summary>
                <button class="button-details-menu-gestor"
                    onclick="mostrarConteudo('painel-frontal-gestor')">Painel</button>
            </details>
            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Alunos</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('alunos')">Alunos</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('provas')">Provas</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('AddAluno')">Adicionar
                    Aluno</button>
            </details>

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Materias</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('materias')">Materias</button>
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
                <summary class="sumary-menu-gestor">PFA</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('adicionarPFA')">Adicionar
                    PFA</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('verPFA')">Ver
                    PFA's</button>
            </details>

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Turmas</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('adicionarTurma')">Adicionar
                    Turma</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('verTurmas')">Ver
                    Turmas</button>
            </details>

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Banco de Dados</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('database')">Backups</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('logsADM')">Logs ADM</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('logsProfessor')">Logs
                    Professor</button>
            </details>

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Períodos</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('addperiodo')">Adicionar
                    Período</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('periodos')">Ver Períodos</button>

            </details>

            <details class="details-menu-gestor">
                <summary class="sumary-menu-gestor">Sistema</summary>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('corSistema')">Cor Sistema</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('relatorioSistema')">Relatorio Geral</button>
                <button class="button-details-menu-gestor" onclick="mostrarConteudo('reset')">Reset</button>

            </details>
        </div>

        <div class="info-gestor">
            <div id="conteudo">

            <div class="conteudo-item" id="reset">
            <div class="container-backup-completo">
                <header class="cabecalho-backup-detalhado">
                <h1><i class="fa fa-database"></i> Backup do Ano Anterior</h1>
                </header>
                <main class="conteudo-backup-explicativo">
                <p>Esta página oferece a opção de baixar os dados de backup referentes ao ano anterior. Ao clicar no botão abaixo, você fará o download de uma pasta compactada que contém o backup SQL completo do banco de dados e o relatório em formato XLSX.</p>
                <p>Esses arquivos são essenciais para a manutenção, auditoria e verificação dos dados, garantindo a integridade e a segurança das informações armazenadas.</p>
                <div class="box-botao-backup">
                    <a href="app\config\backups\relatorio_Geral.zip" class="botao-enviar-relatorio" download>
                    <i class="fa fa-download"></i> Baixar Backup
                    </a>
                </div>
                </main>
            </div>
            </div>

            <div class="conteudo-item" id="relatorioSistema">

                <section class="relatorio-sistema-detalhado">
                    <div class="container-informacao-relatorio">
                        <h2><i class="fa fa-file-alt"></i> Relatório do Sistema</h2>
                        <p class="texto-explicativo-relatorio">Este relatório oferece uma visão abrangente sobre os turnos, provas, turmas e disciplinas do sistema. Com informações detalhadas, o relatório permite análises precisas para auxiliar na tomada de decisões estratégicas e no acompanhamento do desempenho acadêmico.</p>
                        <div class="caixa-detalhes-relatorio">
                        <ul class="lista-detalhe-relatorio">
                            <li><i class="fa fa-clock"></i> <strong>Turnos:</strong> Intermediario & Vespertino</li>
                            <li><i class="fa fa-pencil-alt"></i> <strong>Provas:</strong> Avaliações periódicas e simulados e AMA</li>
                            <li><i class="fa fa-users"></i> <strong>Turmas:</strong> 1º, 2º, 3º séries com grupos diversificados</li>
                            <li><i class="fa fa-book"></i> <strong>Disciplinas:</strong> Matemática, Português, História...</li>
                        </ul>
                        </div>
                        <div class="caixa-botao-relatorio">
                            <p class="texto-adicional-relatorio">Ao enviar, o sistema processará os dados e gerará um relatório completo em XLSX, pronto para download.</p>
                            <form action="" method="post">
                                <button name="enviarRelatorio" type="submit" class="botao-enviar-relatorio">
                                <i class="fa fa-download"></i> Enviar e Baixar Relatório
                                </button>
                            </form>
                        </div>
                    </div>
                </section>

            </div>

                <div class="conteudo-item" id="corSistema">

                <div class="caixa-central-geral">
    
                    <div class="estrutura-caixa-configuracao">
                        
                        <div class="bloco-superior-informacoes">
                            <h2><i class="fas fa-palette"></i> Personalizar Sistema</h2>
                            <p><i class="fas fa-brush"></i> Escolha uma cor para personalizar o sistema</p>
                        </div>

                        <form action="" method="post" class="estrutura-formulario-ajuste">
                            <div class="container-seletor-paleta">
                                <button type="button" id="botao-seletor" class="botao-abrir-seletor">
                                    <i class="fas fa-eyedropper"></i> Escolher Cor
                                </button>
                                <div id="color-picker"></div>
                                <input type="hidden" name="color" id="selected-color">
                            </div>

                            <div class="botoes-area">
                                <button name="enviarCorSistema" type="submit" class="botao-acao-confirmar">
                                    <i class="fas fa-save"></i> Salvar Cor
                                </button>
                                <button type="reset" class="botao-acao-reset">
                                    <i class="fas fa-times"></i> Resetar
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const botaoSeletor = document.getElementById("botao-seletor");
                        const inputColor = document.getElementById("selected-color");

                        const picker = new Picker({
                            parent: botaoSeletor,
                            popup: "bottom",
                            alpha: false,
                            color: "#ff7b00",
                            onChange: (color) => {
                                inputColor.value = color.hex;
                                botaoSeletor.style.backgroundColor = color.hex;
                            }
                        });

                        botaoSeletor.addEventListener("click", () => picker.open());
                    });
                </script>
                </div>

                <div id="periodos" class="conteudo-item">

                    <?php if ($data["periodos"] != null) {?>

                    <table id="tabelaMaterias" class="tabela_alunos_adm">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>DATA INICIAL</th>
                                <th>DATA FINAL</th>
                                <th>EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data["periodos"] as $periodo) {?>
                            <tr>
                                <td><?=$periodo["nome"]?></td>
                                <td><?=date('d/m/Y', strtotime($periodo["data_inicial"]))?></td>
                                <td><?=date('d/m/Y', strtotime($periodo["data_final"]))?></td>
                                <td>
                                    <form action="" class="form-excluir-materia" method="post">
                                        <button type="submit" name="excluir-periodo"
                                            value="<?=$periodo['id']?>;<?=$periodo["nome"]?>"
                                            class="btn-excluir">EXCLUIR</button>
                                    </form>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php } else {?>
                    <center>
                        <h2 class="back-red">NENHUM PERÍODO CADASTRADO!</h2>
                    </center>
                    <?php }?>
                </div>

                <div id="addperiodo" class="conteudo-item">
                    <div class="form_add_materia_adm">
                        <form id="formAddMateria" action="" method="post">
                            <h1 class="form-title-add-materia">Adicionar Novo Período de provas</h1>
                            <br>
                            <div class="form-group-add-materia">
                                <input type="text" name="NomePeriodo" placeholder="Digite o nome do Período" required>
                            </div>
                            <div class="data-periodo">
                                <div>
                                    <label for="dataInicial">DATA INICIAL DO PERIODO:</label>
                                    <input id="dataInicial" name="dataInicial" type="date">
                                </div>
                                <div>
                                    <label for="dataFinal">DATA FINAL DO PERIODO:</label>
                                    <input id="dataFinal" name="dataFinal" type="date">
                                </div>
                            </div>
                            <br>
                            <button type="submit" name="Enviar-periodo" class="submit-button-add-materia">Adicionar
                                Período</button>
                        </form>
                    </div>
                </div>

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
                                <td><?=date('d/m/Y', strtotime(explode(" ", $logs["data"])[0]))?></td>

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
                                <td><?=date('d/m/Y', strtotime(explode(" ", $logs["data"])[0]))?></td>
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

                <div id="adicionarPFA" class="conteudo-item">
                    <div class="form-adicionar-aluno">
                        <center>
                            <h1>Adicionar PFA</h1>
                        </center>
                        <form action="" method="post">
                            <div class="input-group-adicionar-aluno">
                                <h3>Nome PFA</h3>
                                <input type="text" name="nome" placeholder="Nome" required>
                            </div>
                            <div class="input-group-adicionar-aluno">
                                <h3>Usuario de Acesso</h3>
                                <input type="text" name="user" placeholder="Usuario" required>
                            </div>

                            <div class="input-group-adicionar-aluno">
                                <h3>Senha de Acesso</h3>
                                <input type="text" name="senha" placeholder="Senha" required>
                            </div>


                            <h2>Disciplina do Usuário PFA</h2>

                            <div class="radio-group">
                                <input type="radio" id="materiaPFA_M" name="disciplinaPFA" required value="Matemática">
                                <label for="materiaPFA_M">Matemática</label>

                                <input type="radio" id="materiaPFA_P" name="disciplinaPFA" required
                                    value="Língua Portuguesa">
                                <label for="materiaPFA_P">Língua Portuguesa</label>
                            </div>

                            <h2>Turno do Usuário PFA</h2>

                            <div class="radio-group">
                                <input type="radio" id="TurnoPFA_I" name="TurnoPFA" required value="INTERMEDIÁRIO">
                                <label for="TurnoPFA_I">INTERMEDIÁRIO</label>

                                <input type="radio" id="TurnoPFA_V" name="TurnoPFA" required value="VESPERTINO">
                                <label for="TurnoPFA_V">VESPERTINO</label>
                            </div>
                            <center>

                                <button type="submit" name="salvarPFA"
                                    class="btn-salvar-adicionar-aluno">Salvar</button>
                            </center>



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

                <div id="verPFA" class="conteudo-item">

                    <center>
                        <h2>PFA's CADASTRADOS</h2>
                    </center>

                    <?php if ($data["PFAs"] != null) {?>

                    <table id="tabelaMaterias" class="tabela_alunos_adm">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>TURNO</th>
                                <th>DISCIPLINA</th>
                                <th>USUARIO</th>
                                <th>SENHA</th>
                                <th>EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data["PFAs"] as $PFA) {?>
                            <tr>
                                <td><?=$PFA["nome"]?></td>
                                <td><?=$PFA["turno"]?></td>
                                <td><?=$PFA["disciplina"]?></td>
                                <td><?=$PFA["usuario"]?></td>
                                <td><?=$PFA["senha"]?></td>
                                <td>
                                    <form action="" class="form-excluir-pfa" method="post">
                                        <button type="submit" name="excluir-pfa"
                                            value="<?=$PFA['id']?>;<?=$PFA["nome"]?>"
                                            class="btn-excluir">EXCLUIR</button>
                                    </form>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php } else {?>
                    <center>
                        <h2 class="back-red">NENHUMA PFA CADASTRADO!</h2>
                    </center>
                    <?php }?>
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
                                oninput="filtrarAlunos()">
                            <input type="text" id="filtroNomeAlunos" class="filtro-nome" placeholder="Filtrar por Nome"
                                oninput="filtrarAlunos()">
                            <select id="selecionar-turmas-aluno" onchange="filtrarAlunos()">
                                <option value="SELECIONAR">SELECIONAR</option>
                                <?php foreach ($data["turmas"]["turmas"] as $turma) {?>
                                <option value="<?=$turma["nome"]?>"><?=$turma["nome"]?></option>
                                <?php }?>
                            </select>
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
                    <br><br><br><br><br>
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
                                <th>NOME P.</th>
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
                                <td><?=date('d/m/Y', strtotime($aluno["data_aluno"]))?></td>
                                <td><?=$aluno["disciplina"]?></td>
                                <td><?=$aluno["nome_prova"]?></td>
                                <td><?=$aluno["pontos_aluno"]?></td>
                                <td><button class="btn-editar"
                                        onclick="editarProvaAluno('<?=$aluno['ra']?>', '<?=$aluno['perguntas_respostas']?>', '<?=$aluno['aluno']?>','<?=$aluno['id_prova']?>',<?=$aluno['id']?>,'<?=$aluno['disciplina']?>',<?=$aluno['data_aluno']?>,'<?=$aluno['turma']?>')">EDITAR</button>
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

                    <div id="editar-prova-aluno" class="hidden form-editar">
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
                                <br>
                                <h3>TURMA CADASTRADA NA PROVA:</h3>
                                <div class="radio-group">
                                    <?php foreach ($data["turmas"]["turmas"] as $turma) {?>
                                    <input type="radio" id="turma_prova_<?=$turma["nome"]?>" name="turmas_prova"
                                        value="<?=$turma["nome"]?>">
                                    <label for="turma_prova_<?=$turma["nome"]?>"><?=$turma["nome"]?></label>
                                    <?php }?>
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

                <div id="painel-frontal-gestor" class="painel-frontal-gestor conteudo-item active painel-customized-layout">
  <header class="painel-header-section">
    <div class="painel-header-image-wrapper">
      <img src="https://telegra.ph/file/14ab586a79f8002b24880.png" alt="IMAGEM BRAZÃO" class="painel-header-image">
    </div>
    <div class="painel-header-text-wrapper">
      <h1 class="painel-header-title">PAINEL ADMINISTRATIVO</h1>
      <p class="painel-header-subtitle">
        Bem-vindo ao painel do gestor. Aqui você pode gerenciar alunos, professores e muito mais!
      </p>
    </div>
  </header>


  <section class="painel-info-cards-section">
    <div class="painel-info-card">
      <div class="painel-info-card-icon"><i class="fas fa-user-graduate"></i></div>
      <div class="painel-info-card-content">
        <h3 class="painel-info-card-title">Alunos</h3>
        <p class="painel-info-card-text">Gerencie os dados dos alunos de forma rápida e eficiente.</p>
      </div>
    </div>
    <div class="painel-info-card">
      <div class="painel-info-card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
      <div class="painel-info-card-content">
        <h3 class="painel-info-card-title">Professores</h3>
        <p class="painel-info-card-text">Adicione e verifique informações dos professores.</p>
      </div>
    </div>
    <div class="painel-info-card">
      <div class="painel-info-card-icon"><i class="fas fa-book"></i></div>
      <div class="painel-info-card-content">
        <h3 class="painel-info-card-title">Matérias</h3>
        <p class="painel-info-card-text">Organize e adicione matérias facilmente.</p>
      </div>
    </div>
  </section>

  <section class="painel-buttons-grid-section">
    <h2 class="painel-buttons-grid-title"><i class="fas fa-th"></i> Atalhos Rápidos</h2>
    <div class="painel-buttons-grid-wrapper">
      <button class="painel-button-custom-style" onclick="mostrarConteudo('alunos')">
        <i class="fas fa-user-graduate"></i> Alunos
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('provas')">
        <i class="fas fa-file-alt"></i> Provas
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('AddAluno')">
        <i class="fas fa-user-plus"></i> Adicionar Aluno
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('materias')">
        <i class="fas fa-book-open"></i> Matérias
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('adicionarMateria')">
        <i class="fas fa-plus-circle"></i> Adicionar Matéria
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('adicionarProfessor')">
        <i class="fas fa-chalkboard-teacher"></i> Adicionar Professor
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('verProfessores')">
        <i class="fas fa-eye"></i> Ver Professores
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('adicionarTurma')">
        <i class="fas fa-users"></i> Adicionar Turma
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('verTurmas')">
        <i class="fas fa-eye"></i> Ver Turmas
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('adicionarPFA')">
        <i class="fas fa-eye"></i> Adicionar PFA
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('verPFA')">
        <i class="fas fa-eye"></i> Ver PFA's
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('database')">
        <i class="fas fa-database"></i> Backups
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('logsADM')">
        <i class="fas fa-file-alt"></i> Logs ADM
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('logsProfessor')">
        <i class="fas fa-file-alt"></i> Logs Professor
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('addperiodo')">
        <i class="fas fa-calendar-plus"></i> Adicionar Período
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('periodos')">
        <i class="fas fa-calendar-alt"></i> Períodos
      </button>
      <button class="painel-button-custom-style" onclick="mostrarConteudo('corSistema')">
        <i class="fas fa-paint-brush"></i> Cor do Sistema
      </button>

      <button class="painel-button-custom-style" onclick="mostrarConteudo('relatorioSistema')">
        <i class="fas fa-chart-line"></i> Relatórios
        </button>

        <button class="painel-button-custom-style" onclick="mostrarConteudo('reset')">
        <i class="fas fa-cog"></i> Reset
        </button>
    </div>
  </section>
</div>

            </div>
    </section>
</main>