<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #fbf5e9 !important;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #d63765;
        }

        .principal {
            max-width: 1000px;
            margin: 55px auto;
            padding: 0 50px 60px;
        }

        .principal h1 {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 2.1rem;
            font-weight: bold;
            margin: 0 0 50px;
            color: #d63765;
        }

        .formulario {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 70px;
            row-gap: 40px;
        }

        .campo,
        .ingredientes,
        .preparo,
        .foto {
            display: flex;
            flex-direction: column;
        }

        .campo > label,
        .ingredientes > label,
        .preparo > label,
        .foto > label {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1.2rem;
            font-weight: bold;
            color: #d63765;
            margin-bottom: 12px;
        }

        .campo input[type="text"] {
            width: 100%;
            height: 42px;
            border: none;
            background-color: #f0e5d2;
            padding: 10px 14px;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        .campo input[type="number"] {
            width: 100px;
            height: 42px;
            border: none;
            background-color: #f0e5d2;
            padding: 10px;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        .campo select {
            height: 42px;
            border: none;
            background-color: #f0e5d2;
            padding: 8px 12px;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        input::placeholder,
        textarea::placeholder {
            color: #8f7c7c;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            opacity: 1;
        }

        textarea {
            width: 100%;
            border: none;
            background-color: #f0e5d2;
            padding: 12px;
            resize: none;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        .ingredientes {
            grid-column: 1;
        }

        .ingredientes textarea {
            height: 160px;
        }

        .preparo {
            grid-column: 1;
        }

        .preparo textarea {
            height: 160px;
        }

        .opcoes {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .opcoes label {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1.05rem;
            font-weight: normal;
            color: #5f4b4b;
            margin-right: 10px;
        }

        .opcoes input[type="radio"] {
            accent-color: #d63765;
            width: 16px;
            height: 16px;
        }

        .foto {
            grid-column: 2;
            grid-row: 2;
            align-self: start;
        }

        .foto > label {
            margin-bottom: 12px;
        }

        .foto input[type="file"] {
            width: 100%;
            height: 100px;
            padding: 25px 18px;
            background-color: #f0e5d2;
            border: 3px solid #d63765;
            color: #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            cursor: pointer;
        }

        .foto input[type="file"]::file-selector-button {
            background-color: #d63765;
            color: #fbf5e9;
            border: none;
            padding: 10px 18px;
            margin-right: 12px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-weight: bold;
            cursor: pointer;
        }

        .tempo-campo {
            grid-column: 2;
            grid-row: 3;
        }

        .tempo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .tempo select {
            width: 130px;
        }

        .botoes {
            grid-column: 1 / -1;
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .botaoA,
        .botaoC {
            min-width: 170px;
            height: 45px;
            padding: 8px 25px;
            border: 2px solid #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .botaoA {
            background-color: #d63765;
            color: #fbf5e9;
        }

        .botaoC {
            background-color: transparent;
            color: #d63765;
        }

        .botaoA:hover,
        .botaoC:hover {
            opacity: 0.8;
        }

        .campo input[type="text"]:focus,
        .campo input[type="number"]:focus,
        .campo select:focus,
        textarea:focus {
            outline: 2px solid #d63765;
        }

        @media (max-width: 700px) {
            .principal {
                padding: 0 25px 35px;
            }

            .formulario {
                grid-template-columns: 1fr;
                row-gap: 30px;
            }

            .ingredientes,
            .preparo,
            .foto,
            .tempo-campo {
                grid-column: 1;
                grid-row: auto;
            }

            .botoes {
                grid-column: 1;
            }
        }
    </style>
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <main class="principal">

        <h1>Adicionar Receita</h1>

        <form action="create.php" method="POST" enctype="multipart/form-data">

            <div class="formulario">

                <div class="campo">
                    <label for="nome">Nome da receita:</label>
                    <input type="text" name="nome" id="nome" placeholder="Digite o nome da receita">
                </div>

                <div class="campo">
                    <label>Categoria:</label>

                    <div class="opcoes">
                        <input type="radio" name="categ" id="doce" value="True">
                        <label for="doce">Doce</label>

                        <input type="radio" name="categ" id="salgado" value="False">
                        <label for="salgado">Salgado</label>
                    </div>
                </div>

                <div class="ingredientes">
                    <label for="ingredientes">Ingredientes:</label>
                    <textarea id="ingredientes" name="ingredientes" placeholder="Digite os ingredientes da receita"></textarea>
                </div>

                <div class="foto">
                    <label for="foto">Adicione uma foto:</label>
                    <input type="file" id="foto" name="foto" accept="image/*" capture="user">
                </div>

                <div class="preparo">
                    <label for="modo-preparo">Modo de Preparo:</label>
                    <textarea id="modo-preparo" name="modo-preparo" placeholder="Explique passo a passo de como preparar a receita"></textarea>
                </div>

                <div class="campo">
                    <label>Dificuldade:</label>

                    <div class="opcoes">
                        <input type="radio" id="facil" name="opcao" value="valor1">
                        <label for="facil">Fácil</label>

                        <input type="radio" id="medio" name="opcao" value="valor2">
                        <label for="medio">Médio</label>

                        <input type="radio" id="dificil" name="opcao" value="valor3">
                        <label for="dificil">Difícil</label>
                    </div>
                </div>

                <div class="campo tempo-campo">
                    <label for="tempo">Tempo:</label>

                    <div class="tempo">
                        <input type="number" id="tempo" name="tempo" min="1" placeholder="Ex.: 30">

                        <select name="unidade">
                            <option value="minutos">Minutos</option>
                            <option value="horas">Horas</option>
                        </select>
                    </div>
                </div>

                <div class="botoes">
                    <input type="submit" value="Adicionar Receita" class="botaoA">
                    <input type="reset" value="Cancelar" class="botaoC">
                </div>

            </div>

        </form>

    </main>

    <?php include '../includes/footer.php'; ?>

</body>
</html>