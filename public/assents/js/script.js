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
 
function exportToExcel(nome) {

    var table = XLSX.utils.table_to_sheet(document.querySelector('table'));

    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, table, 'Dados');

    XLSX.writeFile(wb, nome+'.xlsx');
}

function mostarTabela(tabela) {
    var descritores = document.getElementById("table-descritores-primeira");
    var descritores_rec = document.getElementById("table-descritores-rec");
    var botoes_descritores = document.getElementById("botoes-alternar-prova");
    var notas = document.getElementById("table-notas");

    if (tabela == "DESCRITORES") {
        descritores.classList.remove("hidden");
        notas.classList.add("hidden");
        descritores_rec.classList.add("hidden");
        botoes_descritores.classList.remove("hidden");
    } else if(tabela == "NOTAS"){ 
        notas.classList.remove("hidden");
        descritores.classList.add("hidden");
        descritores_rec.classList.add("hidden");
        botoes_descritores.classList.add("hidden");

    }else{
        descritores_rec.classList.remove("hidden");
        notas.classList.add("hidden");
        descritores.classList.add("hidden");

    }
}


function MostrarCaixaProfessor(caixa) {
    var area = document.getElementById("area_questoes_desc");
    var inputs = area.querySelectorAll('input, select, textarea');
    if (caixa == "questao") {
        area.style.display = 'block';
        inputs.forEach(input => input.disabled = false);
    } else {
        area.style.display = 'none';
        inputs.forEach(input => input.disabled = true);
    }
}

function addNewInput(input) {
    // Verifica se o campo atual tem algum valor
    if (input.value.trim() !== "") {
        // Obtém o índice atual
        let currentIndex = parseInt(input.parentElement.getAttribute('data-index'));
        // Obtém o próximo índice
        let nextIndex = currentIndex + 1;
        // Verifica se já existe uma caixa de entrada para o próximo índice
        if (!document.querySelector(`.area_descritores_rec .campos-selecionar-descritores[data-index="${nextIndex}"]`)) {
            // Cria um novo contêiner de descritores
            let newContainer = document.createElement('div');
            newContainer.classList.add('campos-selecionar-descritores');
            newContainer.setAttribute('data-index', nextIndex);

            // Cria um novo campo de entrada
            let newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.className = 'searchInput';
            newInput.name = `DESCRITOR_${nextIndex}`;
            newInput.placeholder = 'DESCRITOR';
            newInput.setAttribute('oninput', 'addNewInput(this)');

            // Cria um novo container para os descritores
            let newDescritoresContainer = document.createElement('div');
            newDescritoresContainer.className = 'descritoresContainer';
            newDescritoresContainer.setAttribute('data-index', nextIndex);

            // Adiciona o novo campo de entrada e o container ao novo contêiner
            newContainer.appendChild(newInput);
            newContainer.appendChild(newDescritoresContainer);

            // Adiciona o novo contêiner à área de descritores recomendados
            document.querySelector('.area_descritores_rec').appendChild(newContainer);

            // Adiciona o event listener para o novo campo de entrada
            newInput.addEventListener('input', function() {
                const inputText = this.value.trim();
                const index = this.parentElement.getAttribute('data-index');
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
        }
    }
}

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

document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = document.querySelectorAll('.searchInput');

    searchInputs.forEach(searchInput => {
        searchInput.addEventListener('input', function() {
            const inputText = this.value.trim();
            const index = this.parentElement.getAttribute('data-index');
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

    document.addEventListener('click', function(event) {
        const clickedElement = event.target;

        if (!clickedElement.classList.contains('searchInput') && !clickedElement.classList.contains('descritor')) {
            const allDescritoresContainers = document.querySelectorAll('.descritoresContainer');
            allDescritoresContainers.forEach(container => {
                container.innerHTML = ''; // Oculta todas as listas de descritores
            });
        }
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

document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = document.querySelectorAll('.searchInput');

    searchInputs.forEach(searchInput => {
        searchInput.addEventListener('input', function() {
            const inputText = this.value.trim();
            const index = this.parentElement.getAttribute('data-index');
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

    document.addEventListener('click', function(event) {
        const clickedElement = event.target;

        if (!clickedElement.classList.contains('searchInput') && !clickedElement.classList.contains('descritor')) {
            const allDescritoresContainers = document.querySelectorAll('.descritoresContainer');
            allDescritoresContainers.forEach(container => {
                container.innerHTML = ''; // Oculta todas as listas de descritores
            });
        }
    });
});