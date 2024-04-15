
function Mostrar_campo_email(){
 

    const campo_ra = document.getElementById("campo-ra")
    const campo_email = document.getElementById("campo-email") 
    const container = document.querySelector(".login-aluno")

    campo_ra.style.display = "none"
    campo_email.style.display = "block"
    campo_email.style.height = "480px"

}

function Mostrar_campo_ra(){ 

    const campo_ra = document.getElementById("campo-ra")
    const campo_email = document.getElementById("campo-email") 
    const container = document.querySelector(".login-aluno")

    campo_ra.style.display = "block"
    campo_email.style.display = "none"
    container.style.height = "400px"
}