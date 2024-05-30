const buttonsModal = document.querySelectorAll('.btModal');


buttonsModal.forEach(buttonModal => {
    buttonModal.addEventListener("click", function () {
        var foto = this.getAttribute('foto'); // Foto
        var cpf = this.getAttribute('cpf'); // CPF
        var nascimento = this.getAttribute('data-nascimento'); // Data de Nascimento
        var tipo = this.getAttribute('tipo'); // Tipo
        var nome = this.getAttribute('nome'); // Nome
        var sobrenome = this.getAttribute('sobrenone'); // Sobrenome
        var email = this.getAttribute('email'); // Email
        var peso = this.getAttribute('peso'); // Peso
        var genero = this.getAttribute('genero'); // Gênero
        var telefone = this.getAttribute('telefone'); // Telefone
        var registro = this.getAttribute('data-registro'); // Data de Registro
        const container = document.querySelector('.modal-container');
        const background = document.querySelector('.contrainer');

        abrirModal(container, foto, cpf, nascimento, tipo, nome, sobrenome, email, peso, genero, telefone, registro,background);
    });
});

function abrirModal(container, foto, cpf, nascimento, tipo, nome, sobrenome, email, peso, genero, telefone, registro, background) {
    const caixaModal = document.createElement('div');
    caixaModal.innerHTML = `
            <div class="contentModal">
                <div class="headerModal">
                    <div class="contentHeder">
                        <div class="icon-close">
                            <div class="close">
                                <i class="ph ph-x" onclick='closeIcon()'></i>
                            </div>
                        </div>
                        <div class="icon-foto">
                            <div class="foto">
                                ${foto}
                            </div>
                        </div>
                        <div class="boryHeder">
                            <div class="user">
                                <span class="name">Nome:</span>
                                <p class="nameUser">${nome}</p>
                            </div>
                            <div class="user">
                                <span class="sobrenome">Sobrenome:</span>
                                <p class="sobrenomeUser">${sobrenome}</p>
                            </div>
                            <div class="user">
                                <span class="tipo">Tipo:</span>
                                <p class="tipoUser">${tipo}</p>
                            </div>
                            <div class="user">
                                <span class="cpf">CPF:</span>
                                <p class="cpfUser">${cpf}</p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="boryModal">
                    <div class="campo">

                        <div class="pesos">
                            <span class="peso">Peso:</span>
                            <p class="pesoUser">${peso}</p>
                        </div>
                        <div class="generos">
                            <span class="genero">Ggenero:</span>
                            <p class="generoUser">${genero}</p>
                        </div>
                        <div class="telefones">
                            <span class="telefone">Ttelefone:</span>
                            <p class="telefoneUser">${telefone}</p>
                        </div>
                        <div class="datas-nascimento">
                            <span class="data-nascimento">Data de Nascimento:</span>
                            <p class="data-nascimentoUser">${nascimento}</p>
                        </div>
                        <div class="emails">
                            <span class="email">Email:</span>
                            <p class="emailUser">${email}</p>
                        </div>
                        <div class="data-registros">
                            <span class="data-registro">Data de Registro:</span>
                            <p class="data-registroUser">${registro}</p>
                        </div>
                    </div>
                </div>
                <span class="line1"></span>
                <span class="line2"></span>
                <span class="line3"></span>
        </div>`;

    container.appendChild(caixaModal);
    container.classList.add('visible');
    background.classList.add('blur-background');
    console.log(container);
    
    console.log(`foto: ${foto}, cpf: ${cpf}, nascimento: ${nascimento}, tipo: ${tipo}, nome: ${nome}, sobrenome: ${sobrenome}, email: ${email}, peso: ${peso}, genero: ${genero}, fone: ${telefone}, registro: ${registro}`);
}
function closeIcon() {
    const modalContainer = document.querySelector('.modal-container');
    const background = document.querySelector('.contrainer');
    modalContainer.innerHTML = '';
    modalContainer.classList.remove('visible');
    background.classList.remove('blur-background');
}