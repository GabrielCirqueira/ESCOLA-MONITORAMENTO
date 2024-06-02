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

        if($_SESSION["USUARIO"] == "ALUNO"){
            $location = "home";
        }else{
            $location = "ADM";
        }

        $_SESSION = array();
 
        session_destroy();

        header("location: {$location}");
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
        <svg 
        width='120' height='120' viewBox='0 0 120 120'>
            <circle cx='60' cy='60' r='$raio' stroke='#dbd9d9' stroke-width='20' fill='none' />
            <circle class='animated-circle' cx='60' cy='60' r='$raio' stroke='$cor' stroke-width='20' fill='none'
                    stroke-dasharray='$circunferencia' stroke-dashoffset='$circunferencia' data-offset='$offset'
                    transform='rotate(-90 60 60)' />
            <text x='50%' y='50%' text-anchor='middle' dy='.3em' font-size='20' fill='#000'>$porcentagem%</text>

        </svg>";
    }
 
    public static function gerarGraficoColunas($dados) {
        $largura_coluna = 50;
        $espaco_coluna = 50;
        $altura_svg = 300;

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

    public static function gerarGraficoHorizontal($dados, $descritor) {
        $altura_barra = 55;
        $largura_svg = 600;
        $altura_svg = 90; // Aumentando a altura do SVG para 90
        $margem_esquerda = 100;
    
        $cores = array(
            "Abaixo do Básico" => "#FF6B6B", // Vermelho
            "Básico" => "#FFA63D", // Laranja
            "Médio" => "#D4FF3B", // Amarelo claro
            "Avançado" => "#44C548" // Verde
        );
    
        $total = array_sum($dados);
    
        $svg = "<svg width='$largura_svg' height='$altura_svg' viewBox='0 0 $largura_svg $altura_svg' xmlns='http://www.w3.org/2000/svg'>";
        
        $svg .= "<text x='35' y='" . ($altura_barra / 2 + 14) . "' text-anchor='start' font-size='14' fill='#666' font-weight='bold'>$descritor</text>";
    
        $svg .= "<line x1='100' y1='60' x2='80' y2='47.5' stroke='#ccc' />";
        
        $svg .= "<line x1='35' y1='" . ($altura_barra / 2 + 20) . "' x2='" . $margem_esquerda . "' y2='" . ($altura_barra / 2 + 20) . "' stroke='#ccc' />";
        
        $svg .= "<line x1='$margem_esquerda' y1='0' x2='$margem_esquerda' y2='" . ($altura_barra + 50) . "' stroke='#ccc' />";
    
        $svg .= "<line x1='$margem_esquerda' y1='" . ($altura_barra + 35) . "' x2='" . ($largura_svg) . "' y2='" . ($altura_barra + 35) . "' stroke='#ccc' />";
    
        for ($i = 0; $i <= 12; $i++) {
            if ($i == 12) {
                $x_grid = ($margem_esquerda + 9.5) + $i * 40;
                $svg .= "<line x1='$x_grid' y1='35' x2='$x_grid' y2='" . ($altura_barra + 35) . "' stroke='#ccc' />";             
            } else {
                $x_grid = ($margem_esquerda + 15) + $i * 40;
                $svg .= "<line x1='$x_grid' y1='35' x2='$x_grid' y2='" . ($altura_barra + 35) . "' stroke='#ccc' />";
            }
        }
    
        $x = $margem_esquerda + 10;
    
        foreach ($dados as $proficiencia => $quantidade) {
            $largura_barra = ($quantidade / $total) * ($largura_svg - $margem_esquerda - 20);
            $svg .= "<rect x='$x' y='23' width='0' height='$altura_barra' fill='" . $cores[$proficiencia] . "'>";
            $svg .= "<animate attributeName='width' from='0' to='$largura_barra' dur='1s' fill='freeze' />";
            $svg .= "</rect>";
            if($quantidade > 0) {
                $svg .= "<text x='" . ($x + $largura_barra / 2) . "' y='20' text-anchor='middle' font-size='16' fill='#666' font-weight='bold'>" . round(($quantidade / $total) * 100) . "%</text>";
                $x += $largura_barra;
            }
        }
    
        $svg .= "</svg>";
        return $svg;
    }
    
}
