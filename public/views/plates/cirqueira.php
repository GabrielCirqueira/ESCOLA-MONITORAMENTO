<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Provas - Gabriel Cirqueira</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0500ffff;
            --primary-colorh: #030099;
            --primary-colorBG: #0500ffff33;
            --primary-colorBGeasy: #0500ffffd;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: var(--primary-colorBG);
            color: #333;
            line-height: 1.6;
        }
        header {
            background: var(--primary-color);
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            font-size: 2.5em;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        header p {
            font-size: 1.2em;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .card {
            background: #fff;
            border: 1px solid var(--primary-colorBGeasy);
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card h2 {
            margin-bottom: 15px;
            color: var(--primary-color);
            font-size: 1.8em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card p {
            margin-bottom: 15px;
            text-align: justify;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .btn {
            display: inline-block;
            background: var(--primary-color);
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: var(--primary-colorh);
        }
        footer {
            background: var(--primary-color);
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        .feature-list {
            list-style: none;
            padding-left: 0;
        }
        .feature-list li {
            margin-bottom: 10px;
            font-size: 1.1em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1><i class="fas fa-laptop-code"></i>Sistema de Provas</h1>
        <p>Desenvolvido por Gabriel Cirqueira</p>
    </header>
    <div class="container">
        <div class="card">
            <h2><i class="fas fa-info-circle"></i> Sobre o Sistema</h2>
            <p>Eu, Gabriel Cirqueira, desenvolvi este sistema do zero enquanto estava no 3º ano do ensino médio na escola <i class="fas fa-school"></i> "NOSSA SENHORA DE LOURDES". Programei o sistema sozinho, criando uma solução completa para gerenciamento e monitoramento de provas.</p>
        </div>
        <div class="grid">
            <div class="card">
                <h2><i class="fas fa-user-shield"></i> Área do Administrador</h2>
                <p>A tela de administrador permite inserir professores, alunos, matérias, períodos de provas, realizar backups, adicionar turmas e gerenciar provas.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-user-plus"></i> Inserir Professores e Alunos</li>
                    <li><i class="fas fa-book"></i> Gerenciar Matérias</li>
                    <li><i class="fas fa-calendar-alt"></i> Configurar Períodos de Provas</li>
                    <li><i class="fas fa-database"></i> Realizar Backups</li>
                    <li><i class="fas fa-users"></i> Adicionar Turmas</li>
                </ul>
                <a href="#" class="btn"><i class="fas fa-cogs"></i> Acessar Admin</a>
            </div>
            <div class="card">
                <h2><i class="fas fa-chalkboard-teacher"></i> Área do Professor</h2>
                <p>Na área do professor, é possível selecionar as turmas para a realização de provas, criar um gabarito espelho e acessar relatórios detalhados.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-clipboard-list"></i> Selecionar Turmas</li>
                    <li><i class="fas fa-edit"></i> Criar Gabarito Espelho</li>
                    <li><i class="fas fa-chart-bar"></i> Visualizar Relatórios</li>
                </ul>
                <a href="#" class="btn"><i class="fas fa-chart-bar"></i> Acessar Professor</a>
            </div>
            <div class="card">
                <h2><i class="fas fa-user-graduate"></i> Área do Aluno</h2>
                <p>Na área do aluno, todas as provas realizadas são listadas. O aluno pode lançar seu gabarito e enviar as respostas para correção automática, comparando com o gabarito do professor.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-list"></i> Listar Provas Realizadas</li>
                    <li><i class="fas fa-pen"></i> Lançar Gabarito</li>
                    <li><i class="fas fa-check"></i> Correção Automática</li>
                </ul>
                <a href="#" class="btn"><i class="fas fa-check-circle"></i> Acessar Aluno</a>
            </div>
            <div class="card">
                <h2><i class="fas fa-chart-line"></i> Área do Gestor</h2>
                <p>A área do gestor oferece acesso completo a todos os dados, com gráficos interativos e filtros por professor, turma e disciplina para análise detalhada dos resultados.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-filter"></i> Filtros Avançados</li>
                    <li><i class="fas fa-chart-pie"></i> Gráficos Interativos</li>
                    <li><i class="fas fa-search"></i> Análise de Resultados</li>
                </ul>
                <a href="#" class="btn"><i class="fas fa-tasks"></i> Acessar Gestor</a>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 - Sistema de Provas | Desenvolvido por Gabriel Cirqueira</p>
    </footer>
</body>
</html>
