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
        var pilotoDiv = selectElement.parentElement;
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

    var labelPosicao = document.createElement('label');
    labelPosicao.textContent = 'Posição:';
    pilotoDiv.appendChild(labelPosicao);

    var selectPosicao = document.createElement('select');
    selectPosicao.name = 'posicoes[]';
    selectPosicao.required = true;
    popularPosicoesSelect(selectPosicao, proximaPosicao);
    pilotoDiv.appendChild(selectPosicao);

    var labelPiloto = document.createElement('label');
    labelPiloto.textContent = 'Piloto:';
    pilotoDiv.appendChild(labelPiloto);

    var selectPiloto = document.createElement('select');
    selectPiloto.name = 'pilotos[]';
    selectPiloto.required = true;
    popularPilotosSelect(selectPiloto, usuarios);
    pilotoDiv.appendChild(selectPiloto);

    var labelMelhorTempo = document.createElement('label');
    labelMelhorTempo.textContent = 'Melhor tempo:';
    pilotoDiv.appendChild(labelMelhorTempo);

    var inputMelhorTempo = document.createElement('input');
    inputMelhorTempo.type = 'time';
    inputMelhorTempo.name = 'melhor_tempo[]';
    inputMelhorTempo.placeholder = 'Melhor Tempo';
    inputMelhorTempo.required = true;
    pilotoDiv.appendChild(inputMelhorTempo);

    var labelPontuacao = document.createElement('label');
    labelPontuacao.textContent = 'Pontuação:';
    pilotoDiv.appendChild(labelPontuacao);

    var inputPontuacao = document.createElement('input');
    inputPontuacao.type = 'number';
    inputPontuacao.name = 'pontuacao[]';
    inputPontuacao.readOnly = true;
    pilotoDiv.appendChild(inputPontuacao);

    var btnExcluirRegistro = document.createElement('button');
    btnExcluirRegistro.type = 'button';
    btnExcluirRegistro.className = 'btn_excluirRegistro';
    btnExcluirRegistro.textContent = 'Excluir registro';
    btnExcluirRegistro.addEventListener('click', function () {
        pilotoDiv.remove();
        atualizarBotaoCadastrar();
        // Recalcular as posições e pontuações
        recalcularPosicoesEPontuacoes();
    });
    pilotoDiv.appendChild(btnExcluirRegistro);

    pilotosContainer.appendChild(pilotoDiv);

    // Gerar a pontuação inicial
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
