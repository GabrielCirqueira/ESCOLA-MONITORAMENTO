
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

// function Mostrar_container_gestor(container){
//     document.getElementById("container-gestor-01").style.display = "none";
//     document.getElementById("container-gestor-02").style.display = "none";
//     document.getElementById("container-gestor-03").style.display = "none";
//     document.getElementById("container-gestor-04").style.display = "none";
//     document.getElementById("container-gestor-05").style.display = "none";

//     document.getElementById(container).style.display = "block";

// }

document.getElementById('cpf').addEventListener('input', function (e) {
    let cpf = e.target.value.replace(/\D/g, '');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = cpf;
});

document.getElementById('telefone').addEventListener('input', function (e) {
    let telefone = e.target.value;
    // Remove todos os caracteres que não são números
    telefone = telefone.replace(/\D/g, '');
    // Adiciona parênteses e um espaço após os 2 primeiros números
    telefone = telefone.replace(/^(\d{2})(\d)/g, '($1) $2');
    e.target.value = telefone;
});

function carregarConteudo(arquivo) {
    $.ajax({
      url: arquivo,
      type: 'GET',
      success: function(response) {
        $('#conteudo').html(response);
      }
    });
  }

  