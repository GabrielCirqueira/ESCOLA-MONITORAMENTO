<?php 

include "../../vendor/autoload.php";

use app\config\Database;

$sql = "SELECT * FROM descritores";
$result = Database::GetInstance()->query($sql);

$dados = $result->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dados);