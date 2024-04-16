<?php

if (isset($_GET["action"])) {

    switch ($_GET["action"]) {

        case "login_aluno":
            include "public/views/head.php";
            include "public/views/header.php";
            include "public/views/aluno/login.php";
            include "public/views/footer.php";
            break;

        case "login_professor":
            include "public/views/head.php";
            include "public/views/header.php";
            include "public/views/professor/login.php";
            include "public/views/footer.php";
            break;

        case "login_gestor":
            include "public/views/head.php";
            include "public/views/header.php";
            include "public/views/gestor/login.php";
            include "public/views/footer.php";
            break;

        case "login_adm":
            include "public/views/head.php";
            include "public/views/header.php";
            include "public/views/adm/login.php";
            include "public/views/footer.php";
            break;
        default:
            include "public/views/head.php";
            include "public/views/header.php";
            include "public/views/main.php";
            include "public/views/footer.php";
            break;
    }

} else {
    include "public/views/head.php";
    include "public/views/header.php";
    include "public/views/main.php";
    include "public/views/footer.php";
}
