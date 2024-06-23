<?php 

include "../../vendor/autoload.php";

use Dotenv\Dotenv; 

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

use app\config\Database;

$sql = "SELECT * FROM descritores";
$result = Database::GetInstance()->query($sql);

$dados = $result->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dados);