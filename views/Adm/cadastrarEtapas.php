<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Etapas</title>
</head>

<body>
    <h1>Cadastro de Etapas</h1>
    <section class="container">
        <form>
            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome">
            </div>

            <div>
                <label for="campeonato">Campeonato:</label>
                <select id="campeonato" name="campeonato">
                    <option value="ckc_Etapa1">CKC Etapa 1</option>
                    <option value="ddl_Etapa1">DDL Etapa1</option>
                </select>
            </div>

            <div>
                <label for="kartodromo">Kartódromo:</label>
                <select id="kartodromo" name="kartodromo">
                    <option value="kart1">Kartódromo 1</option>
                    <option value="kart2">Kartódromo 2</option>
                </select>
            </div>

            <div>
                <label for="categoria">Categoria:</label><br>
                <input type="radio" id="categoria95" name="categoria" value="95">
                <label for="categoria95">95kg</label><br>
                <input type="radio" id="categoria110" name="categoria" value="110">
                <label for="categoria110">110kg</label><br>
            </div>

            <div>
                <label for="data">Data da corrida:</label>
                <input type="date" id="data" name="data">
            </div>

            <div>
                <label for="horario">Horário:</label>
                <input type="time" id="horario" name="horario">
            </div>

            <div>
                <label for="tempo_corrida">Tempo da corrida:</label>
                <input type="time" id="tempo_corrida" name="tempo_corrida">
            </div>

            <div>
                <button type="submit">Enviar</button>
            </div>
        </form>
    </section>
</body>

</html>