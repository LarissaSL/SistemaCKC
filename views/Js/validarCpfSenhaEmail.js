document.addEventListener("DOMContentLoaded", function () {
    let emailInput = document.getElementById("email");
    let confirmarEmailInput = document.getElementById("confirmarEmail");
    let emailError = document.getElementById("emailError");

    let senhaInput = document.getElementById("senha");
    let confirmarSenhaInput = document.getElementById("confirmarSenha");
    let senhaError = document.getElementById("senhaError");

    let cpfInput = document.getElementById("cpf");
    let cpfError = document.getElementById("cpfError");

    let submitButton = document.querySelector(".bt-cadastrar");

    function validarFormatoEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function validarEmails() {
        if (emailInput.value === "" && confirmarEmailInput.value === "") {
            emailError.textContent = "";
            return "";
        }

        if (emailInput.value !== "" && !validarFormatoEmail(emailInput.value)) {
            emailError.textContent = "O formato do e-mail é inválido.";
            return "O formato do e-mail é inválido.";
        }

        if (emailInput.value !== "" && confirmarEmailInput.value !== "" && emailInput.value !== confirmarEmailInput.value) {
            emailError.textContent = "Os e-mails não são iguais.";
            return "Os e-mails não são iguais.";
        }

        emailError.textContent = "";
        return "ok!";
    }

    function validarSenhas() {
        if (senhaInput.value === "" || confirmarSenhaInput.value === "") {
            senhaError.textContent = "";
            return "";
        }

        if (senhaInput.value !== confirmarSenhaInput.value) {
            senhaError.textContent = "As senhas não são iguais.";
            return "As senhas não são iguais.";
        }

        senhaError.textContent = "";
        return "ok!";
    }

    function validarCPF(cpf) {
        if (cpf === "") {
            return "";
        }

        if (cpf.length !== 11) {
            return "CPF precisa ter apenas 11 dígitos.";
        }

        const apenasNumeros = /^[0-9]+$/;
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

    function validarFormulario() {
        let emailValido = validarEmails() === "ok!";
        let senhaValida = validarSenhas() === "ok!";
        let cpfValido = validarCPF(cpfInput.value) === "ok!";

        cpfError.textContent = validarCPF(cpfInput.value) !== "ok!" ? validarCPF(cpfInput.value) : '';

        submitButton.disabled = !(emailValido && senhaValida && cpfValido);
    }

    emailInput.addEventListener("input", validarFormulario);
    confirmarEmailInput.addEventListener("input", validarFormulario);
    senhaInput.addEventListener("input", validarFormulario);
    confirmarSenhaInput.addEventListener("input", validarFormulario);
    cpfInput.addEventListener("input", validarFormulario);
});
