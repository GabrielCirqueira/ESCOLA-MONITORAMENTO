<div class="container-gestor-info">
    <h1>Turmas</h1>
    
    <div class="area-caixas-turmas">
    <?php
    include "../../../../vendor/autoload.php";

    use app\controllers\monitoramento\GestorController;

    $materias = GestorController::GetTurmas();
    foreach ($materias as $materia) {
    ?>
            <div class="caixa-turmas">
                <?php 
                    if($materia["curso"] == "HUMANAS"){
                        echo str_replace("HUMANAS","HUM", $materia["nome"]);
                    }else if($materia["curso"] == "ADMINISTRAÇÃO"){
                        echo str_replace("ADMINISTRAÇÃO","ADM", $materia["nome"]);
                    }else{
                        echo str_replace("INFORMÁTICA","INFO", $materia["nome"]);
                    }

                ?>
            </div>

    <?php } ?>
    </div>

</div>