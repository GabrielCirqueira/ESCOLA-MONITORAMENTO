<div class="container-gestor-info">
    <?php
    include "../../../../vendor/autoload.php";
    use app\controllers\monitoramento\GestorController;
    $professores = GestorController::GetProfessores();
    if($professores != NULL){?>

    <div class="area-disciplinas" >
        <table>
            <thead>
                <th>NOME</th>
                <th>USUARIO</th>
                <th>CPF</th>
                <th>NUMERO</th>
                
            </thead>
            <tbody> 
                <?php  $trocarCor = True; foreach ($professores as $professor) { ?>

                    <?php 
 
                    ?><tr class="<?php 
                    
                        if($trocarCor){
                            echo "cor-linha-tabela-1";
                            $trocarCor = !$trocarCor;
                        }else{
                            echo "cor-linha-tabela-2";
                            $trocarCor = !$trocarCor;
                        }
                    
                    ?>" >
                    <td><?php echo $professor["nome"] ?></td>
                    <td><?php echo $professor["usuario"] ?></td>
                    <td><?php echo $professor["cpf"] ?></td>
                    <td><?php echo $professor["numero"] ?></td> 
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } else{ ?>
         <h1>NENHUMA PROFESSOR ADICIONADO! </h1>
         <?php }?>
</div>