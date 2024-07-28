<main class="main-home-professor">
    <div class="professor-form-section">
        <center>
            <h1 class="titulo-NSL">NSL - SISTEMA DE MONITORAMENTO</h1>

            <h2 class="form-section-header">INSERIR GABARITO</h2>
        </center>

        <form action="criar_gabarito" method="post">
            <div class="professor-form-section-wrapper">
                <center>
                    <label for="nome-prova" class="professor-form-group-label">Insira o Nome da Prova</label><br>
                    <input type="text" maxlength="25" required id="nome-prova" name="nome-prova"
                        class="professor-input-text-field">
                </center>
            </div>

            <div class="professor-form-section-wrapper">
                <center>
                    <h3 class="form-section-header">DESCRITORES:</h3>
                    <div class="professor-form-group">
                        <div>
                            <input type="radio" required id="descritores_sim" name="descritores" value="sim"
                                class="custom-radio-button">
                            <label for="descritores_sim">SIM</label>
                        </div>
                        <div>
                            <input type="radio" required name="descritores" id="descritores_nao" value="não"
                                class="custom-radio-button">
                            <label for="descritores_nao">NÃO</label>
                        </div>
                    </div>
                </center>
            </div>

            <div class="professor-turmas-section">
                <center>
                    <h3 class="form-section-header">TURMAS INTERMEDIÁRIO</h3>
                    <div class="professor-turmas-container">
                        <?php foreach ($data as $turma) {if ($turma["turno"] == "INTERMEDIÁRIO") {?>
                        <div>
                            <input name="gabarito-turmas[]" id="<?=$turma["nome"]?>" type="checkbox"
                                value="<?=$turma["nome"]?>" class="custom-checkbox-button">
                            <label for="<?=$turma["nome"]?>"><?=$turma["nome"]?></label>
                        </div>
                        <?php }}?>
                    </div>

                    <h3 class="form-section-header">TURMAS VESPERTINO</h3>
                    <div class="professor-turmas-container">
                        <?php foreach ($data as $turma) {if ($turma["turno"] == "VESPERTINO") {?>
                        <div>
                            <input name="gabarito-turmas[]" id="<?=$turma["nome"]?>" type="checkbox"
                                value="<?=$turma["nome"]?>" class="custom-checkbox-button">
                            <label for="<?=$turma["nome"]?>"><?=$turma["nome"]?></label>
                        </div>
                        <?php }}?>
                    </div>
                </center>
            </div>

            <div class="professor-disciplinas-section">
                <h3 class="form-section-header">SELECIONE A DISCIPLINA CORRESPONDENTE:</h3>
                <div class="professor-disciplinas-container">
                    <?php
if (strpos($_SESSION["disciplinas"], ";")) {?>
                    <?php $materias = explode(";", $_SESSION["disciplinas"]);
    foreach ($materias as $materia) {?>
                    <div>
                        <input type="radio" required name="Materias-professor-gabarito[]" id="<?=$materia?>"
                            value="<?=$materia?>" class="custom-disciplinas-radio">
                        <label for="<?=$materia?>"><?=$materia?></label>
                    </div>
                    <?php }?>
                    <?php } else {?>
                    <div>
                        <input type="radio" required name="Materias-professor-gabarito[]" id="<?=$_SESSION["disciplinas"]?>"
                            value="<?=$_SESSION["disciplinas"]?>" class="custom-disciplinas-radio">
                        <label for="<?=$_SESSION["disciplinas"]?>"><?=$_SESSION["disciplinas"]?></label>
                    </div>
                    <?php }?>
                </div>
            </div>

            <div class="professor-form-section-wrapper">
                <center>
                    <h3 class="form-section-header">QUANTIDADE DE QUESTÕES:</h3>
                    <div class="professor-form-group">
                        <div class="professor-selectable-numbers" id="quantidade-perguntas">
                            <div class="number-box" data-value="1">1</div>
                            <div class="number-box" data-value="2">2</div>
                            <div class="number-box" data-value="3">3</div>
                            <div class="number-box" data-value="4">4</div>
                            <div class="number-box" data-value="5">5</div>
                            <div class="number-box" data-value="6">6</div>
                            <div class="number-box" data-value="7">7</div>
                            <div class="number-box" data-value="8">8</div>
                            <div class="number-box" data-value="9">9</div>
                            <div class="number-box" data-value="10">10</div>
                            <div class="number-box" data-value="11">11</div>
                            <div class="number-box" data-value="12">12</div>
                            <div class="number-box" data-value="13">13</div>
                            <div class="number-box" data-value="14">14</div>
                            <div class="number-box" data-value="15">15</div>
                            <div class="number-box" data-value="16">16</div>
                            <div class="number-box" data-value="17">17</div>
                            <div class="number-box" data-value="18">18</div>
                            <div class="number-box" data-value="19">19</div>
                            <div class="number-box" data-value="20">20</div>

                        </div>
                        <input name="qtn-perguntas" required type="hidden" class="professor-input-number-field">
                    </div>
                </center>
                <center>
                    <h3 class="form-section-header">VALOR:</h3>
                    <div class="professor-form-group">
                        <div class="professor-selectable-numbers" id="valor">
                            <div class="number-box" data-value="1">1</div>
                            <div class="number-box" data-value="2">2</div>
                            <div class="number-box" data-value="3">3</div>
                            <div class="number-box" data-value="4">4</div>
                            <div class="number-box" data-value="5">5</div>
                            <div class="number-box" data-value="6">6</div>
                            <div class="number-box" data-value="7">7</div>
                            <div class="number-box" data-value="8">8</div>
                            <div class="number-box" data-value="9">9</div>
                            <div class="number-box" data-value="10">10</div>
                            <div class="number-box" data-value="11">11</div>
                            <div class="number-box" data-value="12">12</div>
                            <div class="number-box" data-value="13">13</div>
                            <div class="number-box" data-value="14">14</div>
                            <div class="number-box" data-value="15">15</div>
                            <div class="number-box" data-value="16">16</div>
                            <div class="number-box" data-value="17">17</div>
                            <div class="number-box" data-value="18">18</div>
                            <div class="number-box" data-value="19">19</div>
                            <div class="number-box" data-value="20">20</div>
                        </div>
                        <input name="valor-prova" required type="hidden" class="professor-input-number-field">
                    </div>
                </center>
            </div>

            <br><br>
            <center>
                <input type="submit" value="Criar Gabarito" class="botao-form-enviar">
            </center>
        </form>
        <div>
            <br><br><br>
            <br><br><br>
            <br><br><br>
        </div>
    </div>
</main>
