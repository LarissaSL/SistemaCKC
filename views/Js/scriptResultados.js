document.addEventListener('DOMContentLoaded', function () {
    // Inicializa a primeira vez se necessário
    if (document.querySelectorAll(".piloto").length === 0) {
        adicionarPiloto();
    }
});

// Adiciona evento ao botão de adicionar piloto
document.getElementById("addPiloto").addEventListener("click", function () {
    adicionarPiloto();
    atualizarBotaoCadastrar();
});

// Delegação de eventos para o botão de excluir registro
document.getElementById("pilotosContainer").addEventListener("click", function (event) {
    if (event.target && event.target.className == "btn_excluirRegistro") {
        var pilotoDiv = event.target.closest('.piloto');
        var linhaDiv = pilotoDiv.nextElementSibling;
        pilotoDiv.remove();
        if (linhaDiv && linhaDiv.classList.contains('line')) {
            linhaDiv.remove();
        }
        atualizarBotaoCadastrar();
        recalcularPosicoesEPontuacoes();
    
    }
});

// Função para popular o select de posições
function popularPosicoesSelect(selectElement, posicaoInicial) {
    var posicoes = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15"];
    posicoes.forEach(function (posicao) {
        var option = document.createElement("option");
        option.value = posicao;
        option.textContent = posicao + " º";
        selectElement.appendChild(option);
    });

    // Define a posição inicial do select
    selectElement.value = posicaoInicial;

    // Adiciona evento de mudança ao select
    selectElement.addEventListener('change', function () {
        var pilotoDiv = selectElement.closest('.piloto');
        gerarPontuacao(pilotoDiv);
    });
}

// Função para popular o select de pilotos
function popularPilotosSelect(selectElement, usuarios) {
    usuarios.forEach(function (usuario) {
        var option = document.createElement("option");
        option.value = usuario.id;
        option.textContent = usuario.nome + ' ' + usuario.sobrenome;
        selectElement.appendChild(option);
    });
}

// Função para adicionar um novo piloto
function adicionarPiloto() {
    var pilotosContainer = document.getElementById('pilotosContainer');
    var numeroPilotos = document.querySelectorAll('.piloto').length;
    var proximaPosicao = (numeroPilotos + 1).toString();

    var pilotoDiv = document.createElement('div');
    pilotoDiv.className = 'piloto';

    var campos = [
        { label: 'Posição:', tipo: 'select', id: 'posicao', nome: 'posicoes[]', fn: popularPosicoesSelect },
        { label: 'Piloto:', tipo: 'select', nome: 'pilotos[]', fn: popularPilotosSelect },
        { label: 'Melhor tempo:', tipo: 'input', nome: 'melhor_tempo[]', inputType: 'time' },
        { label: 'Pontuação:', tipo: 'input', nome: 'pontuacao[]', inputType: 'number', readOnly: true }
    ];

    campos.forEach(campo => {
        var divCampo = document.createElement('div');
        divCampo.className = 'campos';

        var label = document.createElement('label');
        label.textContent = campo.label;
        divCampo.appendChild(label);

        if (campo.tipo === 'select') {
            var select = document.createElement('select');
            select.name = campo.nome;
            select.required = true;
            if (campo.id) {
                select.id = campo.id; // Adiciona o ID ao elemento select
            }
            campo.fn(select, campo.nome === 'posicoes[]' ? proximaPosicao : usuarios);
            divCampo.appendChild(select);
        } else if (campo.tipo === 'input') {
            var input = document.createElement('input');
            input.type = campo.inputType;
            input.name = campo.nome;
            input.placeholder = campo.label;
            input.required = true;
            if (campo.readOnly) {
                input.readOnly = true;
            }
            divCampo.appendChild(input);
        }

        pilotoDiv.appendChild(divCampo);
    });

    

    var btnExcluirRegistro = document.createElement('button');
    btnExcluirRegistro.type = 'button';
    btnExcluirRegistro.className = 'btn_excluirRegistro';
    btnExcluirRegistro.textContent = 'Excluir registro';
    pilotoDiv.appendChild(btnExcluirRegistro);

    var lineDiv = document.createElement('div');
    lineDiv.className = 'line';

    pilotosContainer.appendChild(pilotoDiv);
    pilotosContainer.appendChild(lineDiv);

    gerarPontuacao(pilotoDiv);

}

// Função para gerar a pontuação baseada na posição
function gerarPontuacao(pilotoDiv) {
    var posicao = parseInt(pilotoDiv.querySelector("select[name='posicoes[]']").value);
    var pontuacaoPosicao;
    switch (posicao) {
        case 1:
            pontuacaoPosicao = 20;
            break;
        case 2:
            pontuacaoPosicao = 18;
            break;
        case 3:
            pontuacaoPosicao = 16;
            break;
        case 4:
            pontuacaoPosicao = 14;
            break;
        case 5:
            pontuacaoPosicao = 12;
            break;
        case 6:
            pontuacaoPosicao = 10;
            break;
        case 7:
            pontuacaoPosicao = 9;
            break;
        case 8:
            pontuacaoPosicao = 8;
            break;
        case 9:
            pontuacaoPosicao = 7;
            break;
        case 10:
            pontuacaoPosicao = 6;
            break;
        case 11:
            pontuacaoPosicao = 5;
            break;
        case 12:
            pontuacaoPosicao = 4;
            break;
        case 13:
            pontuacaoPosicao = 3;
            break;
        case 14:
            pontuacaoPosicao = 2;
            break;
        case 15:
            pontuacaoPosicao = 1;
            break;
        default:
            pontuacaoPosicao = 0; // Caso a posição não esteja no intervalo de 1 a 15
    }

    pilotoDiv.querySelector("input[name='pontuacao[]']").value = pontuacaoPosicao;

    var pilotoSelect = pilotoDiv.querySelector("select[name='pilotos[]']");
    var nomePiloto = pilotoSelect.options[pilotoSelect.selectedIndex].text;

    console.log("Pontuação calculada para " + nomePiloto + ": " + pontuacaoPosicao);
}

// Função para atualizar o botão de cadastrar
function atualizarBotaoCadastrar() {
    var btCadastrar = document.getElementById("bt-Cadastrar");
    btCadastrar.disabled = document.querySelectorAll(".piloto").length === 0;
}

// Função para recalcular as posições e pontuações quando um registro for excluído
function recalcularPosicoesEPontuacoes() {
    var pilotos = document.querySelectorAll('.piloto');
    pilotos.forEach(function (pilotoDiv, index) {
        var novaPosicao = (index + 1).toString();
        var selectPosicao = pilotoDiv.querySelector("select[name='posicoes[]']");
        selectPosicao.value = novaPosicao;
        gerarPontuacao(pilotoDiv);
    });
}
