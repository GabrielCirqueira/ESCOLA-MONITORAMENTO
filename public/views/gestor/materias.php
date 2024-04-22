<div class="container-gestor-info">

    <div class="campo-formulario-add" >
        <form action="Gestor_info" method="post">
            <button type="submit" class="button-menu-lateral" name="pag" value="addmateria">ADICIONAR DISCIPLINA</button>
        </form>
    </div>

    <?php if($materias != NULL){ ?>

    <div class="area-disciplinas" >
        <table>
            <thead>
                <th>NOME</th>
                <th>CURSO</th>
                <th>TURNO</th>
                <th>EXCLUIR</th>
            </thead>
            <tbody>
                    
                <?php  $trocarCor = True; foreach ($materias as $materia) { ?>

                    <?php
                    $turnos = explode(",", $materia["turno"]);
                    $nomes = [];

                    foreach ($turnos as $turno) {
                        if ($turno == "INTERMEDIÁRIO") {
                            array_push($nomes, "INT");
                        } else if ($turno == "VESPERTINO") {
                            array_push($nomes, "VESP");
                        } else {
                            array_push($nomes, "NOT");
                        }
                    }
                    ?><tr class="<?php 
                    
                        if($trocarCor){
                            echo "cor-linha-tabela-1";
                            $trocarCor = !$trocarCor;
                        }else{
                            echo "cor-linha-tabela-2";
                            $trocarCor = !$trocarCor;
                        }
                    
                    ?>" >
                    <td><?php echo $materia["nome"] ?></td>
                    <td><?php echo $materia["curso"] ?></td>
                    <td><?php echo implode(",", $nomes) ?></td>
                    <td>
                        <form action="excluir_disciplina" method="post" >
                        <button type="submit" name="button-excluir-disciplina" value="<?php echo $materia["nome"]?>" class="button-disciplina-excluir">Excluir</button>
                        </form>
                    </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } else{ ?>
         <h1>NENHUMA DISCIPLINA ADICIONADA! ADICIONE NO BOTÃO ACIMA! </h1>
         <?php }?>
</div>