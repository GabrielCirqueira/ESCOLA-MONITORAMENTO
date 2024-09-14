<?php 

header("Content-Type: application/json");

include "../../vendor/autoload.php";

use Dotenv\Dotenv; 

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

use app\config\Database;

$sql = "SELECT * FROM turmas";
$result = Database::GetInstance()->query($sql);

$dados = $result->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dados);

die();


