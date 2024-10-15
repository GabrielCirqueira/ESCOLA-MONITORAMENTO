<main class="tela-adm-seguranca-sistema">
    <section class="seguranca-container">
        <h1 class="seguranca-titulo">
            <i class="fas fa-shield-alt"></i> Segurança do Sistema
        </h1>

        <div class="seguranca-info">
            <p>
                Nosso sistema de monitoramento é desenvolvido para garantir a máxima segurança dos dados de professores e alunos. A seguir, detalhamos os principais aspectos de segurança implementados no sistema.
            </p>

            <h2 class="seguranca-subtitulo"><i class="fas fa-lock"></i> 1. Criptografia dos Gabaritos</h2>
            <p>
                Todos os gabaritos, dos professores, são armazenados de forma <strong>criptografada</strong>. Isso significa que as respostas não são armazenadas em texto claro no banco de dados.
            </p>
            <p>
                <strong>O que é criptografia?</strong> É o processo de transformar informações legíveis em um formato ilegível, usando algoritmos matemáticos.
            </p>

            <h2 class="seguranca-subtitulo"><i class="fas fa-database"></i> 2. Segurança do Banco de Dados</h2>
            <p>
                O <strong>banco de dados</strong> é onde todas as informações do sistema são armazenadas. Ele é protegido por múltiplas camadas de segurança e as informações sensíveis, como gabaritos, são armazenadas de forma criptografada.
            </p>
            <p>
                Aqui está um exemplo de como um gabarito é salvo no banco de dados:
            </p>
            <div class="gabarito-exemplo">
                <h3>Exemplo de gabarito criptografado:</h3>
                <code>MSxudWxs;MixudWxs;MyxudWxs;NCxudWxs;NSxudWxs;NixudWxs;NyxudWxs;OCxudWxs;OSxudWxs;MTAsbnVsbA==</code>
            </div>
            <p>
                Esse código embaralhado é o gabarito que é armazenado no banco de dados. Mesmo que alguém tenha acesso, eles não conseguirão entender as respostas originais.
            </p>

            <h2 class="seguranca-subtitulo"><i class="fas fa-check-circle"></i> 3. Correção Automática</h2>
            <p>
            Nenhuma pessoa, ou administrador do sistema com acesso ao banco de dados, pode visualizar os gabaritos em texto claro. 
                Após a correção automática, o sistema gera relatórios detalhados sobre o desempenho dos alunos. Esses relatórios 
            são acessíveis apenas pelos <strong>professores e gestores</strong>, garantindo a privacidade dos dados.
            </p>

            <h2 class="seguranca-subtitulo"><i class="fas fa-user-shield"></i> 4. Acesso Restrito e Relatórios de Desempenho</h2>
            <p>
                Apenas <strong>professores e gestores</strong> têm acesso aos relatórios gerados após a correção automática. Esses relatórios contêm informações detalhadas sobre o desempenho dos alunos, mas são mantidos em um ambiente seguro e protegido por autenticação.
            </p>
        </div>

        <div class="seguranca-detalhes">
            <h2>Resumo das principais características de segurança:</h2>
            <ul>
                <li><i class="fas fa-user-shield"></i> Acesso restrito a professores e alunos cadastrados</li>
                <li><i class="fas fa-database"></i> Armazenamento seguro com criptografia</li>
                <li><i class="fas fa-check-circle"></i> Correção automatizada das provas</li>
                <li><i class="fas fa-file-alt"></i> Relatórios detalhados de desempenho acessíveis somente por professores e gestores</li>
            </ul>
        </div>
    </section>
</main>
