<main>

<center>
    <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>
    <h2>BACKUPS SQL</h2>
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
            <?php foreach ($data as $arquivo): ?>
                <tr>
                    <td><?= $arquivo['data'] ?></td>
                    <td><?= $arquivo['hora'] ?></td>
                    <td><?= $arquivo['minuto'] ?></td>
                    <td><?= $arquivo['tamanho'] ?></td>
                    <td><a href='app/config/backups/<?= $arquivo['arquivo'] ?>' download>Download</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main>
