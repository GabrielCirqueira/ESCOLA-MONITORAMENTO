<?php

include "../../vendor/autoload.php";

use app\config\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$sql = "SELECT * FROM gabarito_alunos ORDER BY data_aluno DESC";
$result = Database::GetInstance()->query($sql);

$dados = $result->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dados);