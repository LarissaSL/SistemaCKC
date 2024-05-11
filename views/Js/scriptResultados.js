// Função para popular o select de posição
function popularPosicoesSelect(select) {
    // Limpa todas as opções existentes no select
    select.innerHTML = '';

    var opcoesPosicao = [
        "1º", "2º", "3º", "4º", "5º", "6º", "7º", "8º", "9º", "10º",
        "11º", "12º", "13º", "14º", "15º"
    ];

    // Adiciona as opções ao select
    opcoesPosicao.forEach(function(opcao, index) {
        var option = document.createElement('option');
        option.value = index + 1;
        option.textContent = opcao;
        select.appendChild(option);
    });
}

document.getElementById("addPiloto").addEventListener("click", function() {
    var contagemPilotos = document.querySelectorAll(".piloto").length;
    if (contagemPilotos < 15) { 
        var novoPiloto = document.createElement("div");
        novoPiloto.classList.add("piloto");

        var posicaoLabel = document.createElement("label");
        posicaoLabel.textContent = "Posição:";
        novoPiloto.appendChild(posicaoLabel);

        var posicaoSelect = document.createElement("select");
        posicaoSelect.name = "posicoes[]";
        posicaoSelect.id = "posicao" + (contagemPilotos + 1);
        novoPiloto.appendChild(posicaoSelect);

        // Popula o select de posição
        popularPosicoesSelect(posicaoSelect);

        var pilotoLabel = document.createElement("label");
        pilotoLabel.textContent = "Piloto:";
        novoPiloto.appendChild(pilotoLabel);

        var select = document.createElement("select");
        select.name = "pilotos[]";
        select.id = "piloto" + (contagemPilotos + 1);
        novoPiloto.appendChild(select);

        var qtd_voltas = document.createElement("label");
        qtd_voltas.textContent = "Qtd. de voltas:";
        novoPiloto.appendChild(qtd_voltas);

        var qtd_voltasInput = document.createElement("input");
        qtd_voltasInput.type = "number";
        qtd_voltasInput.name = "qtd_voltas[]";
        qtd_voltasInput.id = "qtd_voltas" + (contagemPilotos + 1);
        novoPiloto.appendChild(qtd_voltasInput);

        var melhorTempoLabel = document.createElement("label");
        melhorTempoLabel.textContent = "Melhor tempo:";
        novoPiloto.appendChild(melhorTempoLabel);

        var melhor_tempoInput = document.createElement("input");
        melhor_tempoInput.type = "text";
        melhor_tempoInput.name = "melhor_tempo[]";
        melhor_tempoInput.id = "melhor_tempo" + (contagemPilotos + 1);
        novoPiloto.appendChild(melhor_tempoInput);

        var advLabel = document.createElement("label");
        advLabel.textContent = "ADV:";
        novoPiloto.appendChild(advLabel);

        var advInput = document.createElement("input");
        advInput.type = "number";
        advInput.name = "adv[]";
        advInput.id = "adv" + (contagemPilotos + 1);
        novoPiloto.appendChild(advInput);

        var pontuacaoLabel = document.createElement("label");
        pontuacaoLabel.textContent = "Pontuação:";
        novoPiloto.appendChild(pontuacaoLabel);

        var pontuacaoInput = document.createElement("input");
        pontuacaoInput.type = "number";
        pontuacaoInput.name = "pontuacao[]";
        pontuacaoInput.id = "pontuacao" + (contagemPilotos + 1);
        novoPiloto.appendChild(pontuacaoInput);        

        var btn_gerarPontuacaoButton = document.createElement("button");
        btn_gerarPontuacaoButton.type = "button";
        btn_gerarPontuacaoButton.textContent = "Gerar pontuação";
        btn_gerarPontuacaoButton.classList.add("btn_gerarPontuacao");
        novoPiloto.appendChild(btn_gerarPontuacaoButton);

        document.querySelector("form").appendChild(novoPiloto);
    } else {
        alert("Limite de 15 pilotos atingido.");
    }
});

document.addEventListener("click", function(event) {
    if (event.target.classList.contains("btn_gerarPontuacao")) {
        var piloto = event.target.parentElement;
        var posicao = parseInt(piloto.querySelector("select[name='posicoes[]']").value);
        var qtd_voltas = parseInt(piloto.querySelector("input[name='qtd_voltas[]']").value);
        var melhor_tempo = parseInt(piloto.querySelector("input[name='melhor_tempo[]']").value);
        var adv = piloto.querySelector("input[name='adv[]']:checked");
        var pontuacao = parseInt(piloto.querySelector("input[name='pontuacao[]']").value);

        // Calcula a pontuação baseada na posição
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

        // Calcula a pontuação final considerando as advertências
        var pontuacaoFinal = pontuacaoPosicao;
        if (adv) {
            var advValor = adv.value;
            switch (advValor) {
                case "cortar caminho":
                    pontuacaoFinal -= 2;
                    break;
                case "bandeira de advertência":
                    pontuacaoFinal -= 3;
                    break;
                case "queimar largada":
                    pontuacaoFinal -= 5;
                    break;
            }
        }

        // Atualiza o valor do campo de pontuação com a pontuação final
        piloto.querySelector("input[name='pontuacao[]']").value = pontuacaoFinal;
    }
});