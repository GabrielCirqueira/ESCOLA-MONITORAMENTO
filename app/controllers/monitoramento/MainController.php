<?php 

namespace app\controllers\monitoramento;

use app\models\monitoramento\GestorModel;

class MainController{

    public static function Templates($template,$user = null, $data = null){
        include "public/views/plates/head.php";
        include "public/views/plates/header-menu.php";
        include $template;
        include "public/views/plates/PopUps.php";
        include "public/views/plates/footer.php";
    }

    public static function Verificar_sessao($sessao){
        if($_SESSION[$sessao]){
            return True;
        }else{
            return false;
        }
    }

    public static function encerrar_sessao(){
        $_SESSION = array();
 
        session_destroy();

        header("location:home");
    }

    public static function ADM(){
        self::Templates("public/views/plates/main.php","home");
    }

    public static function index(){
        self::Templates("public/views/aluno/login.php","home");
    }

    public static function login_professor(){
        self::Templates("public/views/professor/login.php","home");
    }

    public static function login_gestor(){
        self::Templates("public/views/gestor/login.php","home");
    }

    public static function login_adm(){
        self::Templates("public/views/adm/login.php");
    }

    public static function gerarGraficoRosca($porcentagem) {
        $cores = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FFCD94'];
        $cor = $cores[array_rand($cores)];
        $raio = 50;
        $circunferencia = 2 * M_PI * $raio;
        $offset = $circunferencia * (1 - $porcentagem / 100);
        return "
        <svg width='120' height='120' viewBox='0 0 120 120'>
            <circle cx='60' cy='60' r='$raio' stroke='#DDDDDD' stroke-width='20' fill='none' />
            <circle class='animated-circle' cx='60' cy='60' r='$raio' stroke='$cor' stroke-width='20' fill='none'
                    stroke-dasharray='$circunferencia' stroke-dashoffset='$circunferencia' data-offset='$offset'
                    transform='rotate(-90 60 60)' />
            <text x='50%' y='50%' text-anchor='middle' dy='.3em' font-size='20' fill='#000'>$porcentagem%</text>
        </svg>";
    }
}
