document.addEventListener("DOMContentLoaded", function () {
    let emailInput = document.getElementById("email");
    let confirmarEmailInput = document.getElementById("confirmarEmail");
    let emailError = document.getElementById("emailError");
    let submitButton = document.querySelector(".bt-alterar");

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

    function validarFormulario() {
        let emailValido = validarEmails() === "ok!";
        submitButton.disabled = !emailValido;
    }

    emailInput.addEventListener("input", validarFormulario);
    confirmarEmailInput.addEventListener("input", validarFormulario);
});