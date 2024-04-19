<?php

namespace app\controllers\monitoramento;

use app\models\ProfessorModel;

class ProfessorController{

    public static function home_professor(){

        $info = ProfessorModel::verificarLogin($_POST["user"]);
        if ($info){

        } else {

        }
    }


}