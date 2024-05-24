const buttonsModal = document.querySelectorAll('.btModal');


buttonsModal.forEach(buttonModal => {
    buttonModal.addEventListener("click", function() {
        const params = JSON.parse(this.getAttribute('data-params'));
        abrirModal(params);
    });
});

function abrirModal(params) {
    console.log(params);
    console.log(params.Foto);
    console.log(params.Cpf);
    console.log(params.Data_nascimento);
}

