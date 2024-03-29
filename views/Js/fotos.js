function atualizarTextoComFeedback(input) {
    var fileName = input.files[0].name;
    document.getElementById("fotoTexto").innerText = "Arquivo selecionado: " + fileName;
}
