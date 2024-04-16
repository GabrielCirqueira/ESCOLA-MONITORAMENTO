<?php

if(isset($_GET["action"])){

    $action = $_GET["action"];

    switch ($action) {
    
        case "login_aluno":
            include "views/head.php";
            include "views/header.php";
            include "views/aluno/login.php";
            include "views/footer.php";
            break;
    
        default:
            include "views/head.php";
            include "views/header.php";
            include "views/main.php";
            include "views/footer.php";
            break;
    }    
}else{
    include "views/head.php";
    include "views/header.php";
    include "views/main.php";
    include "views/footer.php";
}
