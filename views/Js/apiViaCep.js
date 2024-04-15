document.getElementById('cep').addEventListener('blur', function () {
    const cep = this.value;
    if (cep) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if(data.bairro) {
                    document.getElementById('bairro').value = data.bairro;
                }
                if(data.logradouro) {
                    document.getElementById('rua').value = data.logradouro;
                }
            })
            .catch(error => {
                console.error(error);
            });
    }
});