<main class="main-home-professor"> 
        <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
        <h2>PROVA DE RECUPERAÇÃO</h2>

        <h3>ALUNOS EM RECUPERAÇÃO</h3>

    <table data-aos="fade-up" class="tabela-prova-aluno">
            <thead>
                <th>RA</th>
                <th>NOME</th>
                <th>TURMA</th>
                <th>PONTOS</th>
            </thead>
            <tbody>
                <?php foreach($data["alunos"] as $ra => $aluno){?>
                    <tr>
                    <td><?= $ra?></td>
                    <td><?= $aluno["nome"] ?></td>
                    <td><?= $aluno["turma"] ?></td>
                    <td>NÃO FEZ</td>
                    </tr>
                <?php }?>
            </tbody>
        </table> 
</main>