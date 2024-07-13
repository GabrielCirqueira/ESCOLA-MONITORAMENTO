AOS.init();
 

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
    document.getElementById(popup).style.display = 'none';
}

function Mostrar_PopUp(popup){
    document.getElementById(popup).style.display = 'block';
}
 
// function Mostrar_container_gestor(container){
//     document.getElementById("container-gestor-01").style.display = "none";
//     document.getElementById("container-gestor-02").style.display = "none";
//     document.getElementById("container-gestor-03").style.display = "none";
//     document.getElementById("container-gestor-04").style.display = "none";
//     document.getElementById("container-gestor-05").style.display = "none";

//     document.getElementById(container).style.display = "block";

// }

function carregarConteudo(arquivo) {
    $.ajax({
      url: arquivo, 
      success: function(response) {
        $('#conteudo').html(response);
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = document.querySelectorAll('.searchInput');

    searchInputs.forEach(searchInput => {
        searchInput.addEventListener('input', function() {
            const inputText = this.value.trim();
            const index = this.dataset.index;
            const descritoresContainer = document.querySelector(`.descritoresContainer[data-index="${index}"]`);

            if (inputText.length === 0) {
                descritoresContainer.innerHTML = '';
                return;
            }

            fetch('app/config/GetDescritores.php')
                .then(response => response.json())
                .then(data => {
                    const filteredDescritores = data.filter(descritor => {
                        return descritor.descritor.toLowerCase().includes(inputText.toLowerCase());
                    });

                    renderDescritores(filteredDescritores, descritoresContainer);
                })
                .catch(error => console.error('Erro ao obter descritores:', error));
        });
    });

    function renderDescritores(descritores, container) {
        container.innerHTML = '';

        descritores.forEach(descritor => {
            const div = document.createElement('div');
            div.textContent = descritor.descritor;
            div.classList.add('descritor');
            div.addEventListener('click', function() {
                container.previousElementSibling.value = descritor.descritor;
                container.innerHTML = ''; // Oculta a lista de descritores após a seleção
            });
            container.appendChild(div);
        });
    }

    // Adiciona um event listener para clicar em qualquer parte do documento
    document.addEventListener('click', function(event) {
        const clickedElement = event.target;

        // Verifica se o clique ocorreu fora do campo de busca e da lista de descritores
        if (!clickedElement.classList.contains('searchInput') && !clickedElement.classList.contains('descritor')) {
            const allDescritoresContainers = document.querySelectorAll('.descritoresContainer');
            allDescritoresContainers.forEach(container => {
                container.innerHTML = ''; // Oculta todas as listas de descritores
            });
        }
    });
}); 
 
const menu = document.getElementById("area_menu_lateral")
const menuBtn = document.getElementById("icone-menu-lateral")
const menu_conteudo = document.getElementById("menu-lateral-icone-conteudo")
const icone_fechar_menu = document.querySelector(".icone-menu-lateral-fechar")
//menu esquerdo
const menuBtnleft = document.getElementById("icone-menu-esquerdo-lateral")
const menu_conteudo_left = document.getElementById("menu-lateral-esquerdo-icone-conteudo")
const icone_fechar_menu_left = document.querySelector(".icone-menu-lateral-esquerdo-fechar")
 

icone_fechar_menu.addEventListener('click', function() {
    menu.style.display = "none"
    menu.style.backgroundColor = "rgba(0, 0, 0, 0)"
    document.body.classList.remove('no-scroll');
    menu_conteudo.style.right = '-320px'
})

menuBtn.addEventListener('click', function() {
    document.body.classList.add('no-scroll');
    menu.style.display = "block"
    menu.style.backgroundColor = "rgba(0, 0, 0, 0.507)"
    menu_conteudo.style.right = '0px'
})

icone_fechar_menu_left.addEventListener('click', function() {
    menu.style.display = "none"
    menu.style.backgroundColor = "rgba(0, 0, 0, 0)"
    menu_conteudo_left.style.left = '-320px'
    document.body.classList.remove('no-scroll');
})

menuBtnleft.addEventListener('click', function() {
    menu.style.display = "block"
    menu.style.backgroundColor = "rgba(0, 0, 0, 0.507)"
    document.body.classList.add('no-scroll');
    menu_conteudo_left.style.left = '0px'
})

document.addEventListener("DOMContentLoaded", function() {
    const circles = document.querySelectorAll('.animated-circle');
    circles.forEach(circle => {
        const offset = circle.getAttribute('data-offset');
        circle.style.setProperty('--offset', offset);
        circle.style.animation = 'none';
        void circle.offsetWidth; 
        circle.style.animation = null; 
    });
});

function resetForm() {
    const form = document.getElementById('filterForm');
    form.reset();
 
    document.getElementById('turma').selectedIndex = 0;
    document.getElementById('turno').selectedIndex = 0;
    document.getElementById('disciplina').selectedIndex = 0;
    document.getElementById('serie').selectedIndex = 0;
    document.getElementById('professor').selectedIndex = 0;
}

function resetFormProva() {
    const form = document.getElementById('filterFormProva'); 
    document.getElementById('disciplina').selectedIndex = 0; 
    document.getElementById('professor').selectedIndex = 0;
}

function resetFormDesc() {
    const form = document.getElementById('filterFormDesc');
    form.reset(); 
    document.getElementById('turma').selectedIndex = 0;
    document.getElementById('turno').selectedIndex = 0;
    document.getElementById('disciplina').selectedIndex = 0;
    document.getElementById('serie').selectedIndex = 0; 
    document.getElementById('descritor').value = '';
}

// document.addEventListener('DOMContentLoaded', (event) => { 
//     const formularios = document.querySelectorAll('form');

//     formularios.forEach(formulario => {
//         formulario.addEventListener('submit', function(event) {
//             event.preventDefault();  
//         });
//     });
// });
 
function exportToExcel(nome, tableId) {
    var table = document.getElementById(tableId); 

    var sheet = XLSX.utils.table_to_sheet(table);

    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, sheet, 'Dados');

    XLSX.writeFile(wb, nome + '.xlsx');
}

function mostarTabela(tabela) {
    var descritores = document.getElementById("table-descritores-primeira");
    var descritores_rec = document.getElementById("table-descritores-rec");
    var botoes_descritores = document.getElementById("botoes-alternar-prova");
    var respostas = document.getElementById("table-respostas");
    var notas = document.getElementById("table-notas");

    var tableNotas = document.getElementById("export-notas");
    var tableDesc = document.getElementById("export-descritores");
    var tableResp = document.getElementById("export-respostas");

    if (tabela == "RESPOSTAS") {
        if(tableNotas) tableNotas.classList.add("hidden");
        if(tableDesc) tableDesc.classList.add("hidden");
        if(tableResp) tableResp.classList.remove("hidden");
        if (notas) notas.classList.add("hidden");
        if (respostas) respostas.classList.remove("hidden");
        if (descritores) descritores.classList.add("hidden");
        if (descritores_rec) descritores_rec.classList.add("hidden");
        if (botoes_descritores) botoes_descritores.classList.add("hidden");
    } else if (tabela == "DESCRITORES") {
        if(tableNotas) tableNotas.classList.add("hidden");
        if(tableDesc) tableDesc.classList.remove("hidden");
        if(tableResp) tableResp.classList.add("hidden");
        if (descritores) descritores.classList.remove("hidden");
        if (notas) notas.classList.add("hidden");
        if (respostas) respostas.classList.add("hidden");
        if (descritores_rec) descritores_rec.classList.add("hidden");
        if (botoes_descritores) botoes_descritores.classList.remove("hidden");
    } else if (tabela == "NOTAS") {
        if(tableNotas) tableNotas.classList.remove("hidden");
        if(tableDesc) tableDesc.classList.add("hidden");
        if(tableResp) tableResp.classList.add("hidden");
        if (notas) notas.classList.remove("hidden");
        if (descritores) descritores.classList.add("hidden");
        if (respostas) respostas.classList.add("hidden");
        if (descritores_rec) descritores_rec.classList.add("hidden");
        if (botoes_descritores) botoes_descritores.classList.add("hidden");
    } else {
        if (descritores_rec) descritores_rec.classList.remove("hidden");
        if (notas) notas.classList.add("hidden");
        if (descritores) descritores.classList.add("hidden");
    }
}

function MostrarCarregamento() {
    var form = document.querySelector('form');
    var radiosValidos = true;

    form.querySelectorAll('input[type=radio]').forEach(function(radio) {
        var name = radio.getAttribute('name');
        var radioGroup = form.querySelectorAll('input[type=radio][name="' + name + '"]');
        var checked = Array.from(radioGroup).some(radio => radio.checked);

        if (!checked) {
            radiosValidos = false;
        }
    });

    if (radiosValidos) {
        var carregar = document.getElementById("div_carregamento");
        var button_gab = document.getElementById("button_enviar_gabarito");

        carregar.classList.remove("hidden");
        button_gab.classList.add("hidden");
    } else {
        return false;
    }
}