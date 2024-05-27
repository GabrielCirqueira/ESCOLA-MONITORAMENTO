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

    public static function gerarGraficoRosca($porcentagem, $corPersonalizada = null) {
        // Definindo cores para cada intervalo de porcentagem, caso não haja cor personalizada
        if ($corPersonalizada === null) {
            if ($porcentagem < 10) {
                $cor = "#fa4b4b"; // Vermelho claro
            } elseif ($porcentagem < 20) {
                $cor = "#fa684b"; // Laranja claro
            } elseif ($porcentagem < 30) {
                $cor = "#fa9a4b"; // Amarelo claro
            } elseif ($porcentagem < 40) {
                $cor = "#fab14b"; // Salmão claro
            } elseif ($porcentagem < 50) {
                $cor = "#fad14b"; // Amarelo Marfim
            } elseif ($porcentagem < 60) {
                $cor = "#faeb4b"; // Caqui claro
            } elseif ($porcentagem < 70) {
                $cor = "#e8fa4b"; // Verde Pálido
            } elseif ($porcentagem < 80) {
                $cor = "#c5fa4b"; // Azul Pálido
            } elseif ($porcentagem < 90) {
                $cor = "#93ed4e"; // Verde claro
            } else {
                $cor = "#30bf00"; // Verde
            }
        } else {
            $cor = $corPersonalizada;
        }
    
        $raio = 50;
        $circunferencia = 2 * M_PI * $raio;
        $offset = $circunferencia * (1 - $porcentagem / 100);
    
        return "
        <svg width='120' height='120' viewBox='0 0 120 120'>
            <circle cx='60' cy='60' r='$raio' stroke='#dbd9d9' stroke-width='20' fill='none' />
            <circle class='animated-circle' cx='60' cy='60' r='$raio' stroke='$cor' stroke-width='20' fill='none'
                    stroke-dasharray='$circunferencia' stroke-dashoffset='$circunferencia' data-offset='$offset'
                    transform='rotate(-90 60 60)' />
            <text x='50%' y='50%' text-anchor='middle' dy='.3em' font-size='20' fill='#000'>$porcentagem%</text>
        </svg>";
    }
 
    public static function gerarGraficoColunas($dados) {
        $largura_coluna = 50; // Largura de cada coluna em pixels
        $espaco_coluna = 50; // Espaço entre as colunas
        $altura_svg = 300; // Altura total do SVG
    
        // Define as cores mais claras para cada faixa de proficiência
        $cores = array(
            "Abaixo do Básico" => "#ff5e5e", // Vermelho claro
            "Básico" => "#ffba52", // Laranja claro
            "Médio" => "#b7ff42", // Amarelo claro
            "Avançado" => "#2bd937" // Verde claro
        );
    
        $svg = "<svg width='" . ((count($dados) * $largura_coluna) + ((count($dados) - 1) * $espaco_coluna) + 60) . "' height='$altura_svg' viewBox='0 0 " . ((count($dados) * $largura_coluna) + ((count($dados) - 1) * $espaco_coluna) + 60) . " $altura_svg'>";
    
        $svg .= "<text x='" . (((count($dados) * $largura_coluna) + ((count($dados) - 1) * $espaco_coluna) + 40) / 2) . "' y='20' text-anchor='middle' font-size='16'>ALUNOS</text>";
        for ($i = 10; $i <= 100; $i += 10) {
            $y = 250 - ($i / 100 * 200); 
            $svg .= "<line x1='20' y1='$y' x2='" . ((count($dados) * $largura_coluna) + ((count($dados) - 1) * $espaco_coluna) + 40) . "' y2='$y' stroke='#ccc' stroke-dasharray='5,5'/>";
            $svg .= "<text x='0' y='" . ($y + 5) . "' font-size='12'>$i</text>";
        }
        $x = 20;
        foreach ($dados as $proficiencia => $quantidade) {
            $altura_coluna = ($quantidade / 100) * 200;
            $svg .= "<rect x='$x' y='" . (250 - $altura_coluna) . "' width='$largura_coluna' height='$altura_coluna' fill='" . $cores[$proficiencia] . "'>";
            $svg .= "<animate attributeName='height' from='0' to='$altura_coluna' dur='1s' fill='freeze' />";
            $svg .= "</rect>";
            $svg .= "<text x='" . ($x + $largura_coluna / 2) . "' y='" . (250 - $altura_coluna - 5) . "' text-anchor='middle' font-size='14'>" . $quantidade . "%</text>";
            $svg .= "<text x='" . ($x + $largura_coluna / 2) . "' y='270' text-anchor='middle' font-size='14'>$proficiencia</text>";
            $x += $largura_coluna + $espaco_coluna;
        }
        $svg .= "</svg>";
    
        return $svg;
    }
    
}
