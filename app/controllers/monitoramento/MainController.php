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
    
        $svg = "<svg   width='" . ((count($dados) * $largura_coluna) + ((count($dados) - 1) * $espaco_coluna) + 60) . "' height='$altura_svg' viewBox='0 0 " . ((count($dados) * $largura_coluna) + ((count($dados) - 1) * $espaco_coluna) + 60) . " $altura_svg'>";

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
        $largura_barra = 100; // Largura da barra
        $largura_svg = 200; // Largura total do SVG
        $altura_svg = 400; // Altura total do SVG
        $margem_inferior = 50; // Margem inferior para os descritores
    
        $cores = array(
            "Abaixo do Básico" => "#FF6B6B", // Vermelho
            "Básico" => "#FFA63D", // Laranja
            "Médio" => "#D4FF3B", // Amarelo claro
            "Avançado" => "#44C548" // Verde
        );
    
        $total = array_sum($dados);
    
        $svg = "<svg width='$largura_svg' height='$altura_svg' viewBox='0 0 $largura_svg $altura_svg' xmlns='http://www.w3.org/2000/svg'>";
        
        $y = $altura_svg - $margem_inferior;
    
        foreach ($dados as $proficiencia => $quantidade) {
            $altura_barra = ($quantidade / $total) * ($altura_svg - $margem_inferior);
            $y -= $altura_barra;
            $svg .= "<rect x='50' y='$y' width='$largura_barra' height='$altura_barra' fill='" . $cores[$proficiencia] . "' />";
            if ($quantidade > 0) {
                $svg .= "<text x='" . (50 + $largura_barra + 10) . "' y='" . ($y + $altura_barra / 2 + 5) . "' text-anchor='start' font-size='14' fill='#666'>" . round(($quantidade / $total) * 100) . "%</text>";
            }
        }
    
        // Adicionar a borda cinza ao redor do gráfico
        $svg .= "<rect x='50' y='" . ($altura_svg - $margem_inferior - ($altura_svg - $margem_inferior)) . "' width='$largura_barra' height='" . ($altura_svg - $margem_inferior) . "' fill='none' stroke='#ccc' stroke-width='2' />";
    
        $svg .= "<text x='" . ($largura_svg / 2) . "' y='" . ($altura_svg - 10) . "' text-anchor='middle' font-size='22' fill='#666' font-weight='bold'>$descritor</text>";
        $svg .= "</svg>";
    
        return $svg;
    }
    
}
