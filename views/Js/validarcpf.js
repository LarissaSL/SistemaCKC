
document.addEventListener("DOMContentLoaded", function () {
    let cpfInput = document.getElementById("cpf");
    let cpfError = document.getElementById("cpfError");
    let submitButton = document.querySelector(".bt-cadastrar");

    function validarCPF(cpf) {
        if (cpf.length !== 11) {
            return "CPF precisa ter apenas 11 digitos.";
        }

        const apenasNumeros = new RegExp('^[0-9]+$');
        if (!apenasNumeros.test(cpf)) {
            return "CPF precisa ter apenas dígitos.";
        }


        let soma = 0;
        for (let i = 0; i < 9; i++) {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let resto = 11 - (soma % 11);
        let digitoVerificador1 = (resto === 10 || resto === 11) ? 0 : resto;
        if (digitoVerificador1 !== parseInt(cpf.charAt(9))) {
            return "CPF inválido";
        }
        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        }
        resto = 11 - (soma % 11);
        let digitoVerificador2 = (resto === 10 || resto === 11) ? 0 : resto;
        if (digitoVerificador2 !== parseInt(cpf.charAt(10))) {
            return "CPF inválido";
        }
        return "ok!";
    }

    cpfInput.addEventListener("input", function () {
        if (validarCPF(cpfInput.value) !== "ok!") {
            cpfError.textContent = validarCPF(cpfInput.value);
            submitButton.disabled = true;
        } else {
            cpfError.textContent = "";
            submitButton.disabled = false;
        }
    });
});

