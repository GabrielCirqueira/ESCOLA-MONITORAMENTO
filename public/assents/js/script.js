
function Mostrar_campo_email() {
    document.querySelector("#campo-ra").style.display = "none";
    document.querySelector("#campo-email").style.display = "block";
    const container = document.querySelector(".login-aluno");
    container.style.height = "480px"
}

function Mostrar_campo_ra() {
    document.querySelector("#campo-ra").style.display = "block";
    document.querySelector("#campo-email").style.display = "none";
    const container = document.querySelector(".login-aluno");
    container.style.height = "400px"
}

function Fechar_PopUp(popup){ 
    document.getElementById(popup).style.display = 'none'
}

function Mostrar_PopUp(popup){
    document.getElementById(popup).style.display = 'block'
}

function Mostrar_container_gestor(container){
    document.getElementById("container-gestor-01").style.display = "none";
    document.getElementById("container-gestor-02").style.display = "none";
    document.getElementById("container-gestor-03").style.display = "none";
    document.getElementById("container-gestor-04").style.display = "none";
    document.getElementById("container-gestor-05").style.display = "none";

    document.getElementById(container).style.display = "block";

}