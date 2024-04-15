function carregarPagina(action) {
    var url = 'index.php?action=' + encodeURIComponent(action);
    window.location.href = url;
    return false; // Para evitar que o link padrão seja seguido
}

setTimeout( function() {
    console.log("hello")
},1000)