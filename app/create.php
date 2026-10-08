<?php

require_once __DIR__ . '/../database/conexao.php';

require_once __DIR__ . '/../includes/functions.php';

require_once __DIR__ . '/../login/verificaUser.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Pega o ID do usuário que está logado

    $usuario_id = $_SESSION['usuario_id'];

    // Pega os dados preenchidos no formulário

    $nome = $_POST['nome'] ?? '';

    $categoria = $_POST['categ'] ?? '';

    $ingredientes = $_POST['ingredientes'] ?? '';

    $modo_preparo = $_POST['modo-preparo'] ?? '';

    $tempo = $_POST['tempo'] ?? '';

    $unidade = $_POST['unidade'] ?? '';

    $diiculdade = $_POST['opcao'] ?? '';

    // Junta o número com a unidade

    $tempo_preparo = $tempo . ' ' . $unidade;

    // Por enquanto, deixa a imagem vazia

    $imagem = '';

    // Se o usuário escolheu uma imagem

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

        $pasta = __DIR__ . '../imagens/receitas/';

        // Cria a pasta caso ela ainda não exista

        if (!is_dir($pasta)) {

            mkdir($pasta, 0777, true);

        }

        $nome_imagem = time() . '_' . basename($_FILES['foto']['name']);

        $caminho = $pasta . $nome_imagem;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho)) {

            $imagem = $nome_imagem;

        }

    }

    // Salva a receita no banco

    if (cadastrar($pdo, $usuario_id, $categoria, $nome, $ingredientes, $modo_preparo, $tempo_preparo, $imagem, $diiculdade)) {

        header("Location: select.php");

        exit();

    } else {

        $erro = "Já existe uma receita com esse nome. Escolha outro nome.";

    }

}

?>
<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pétalas, Açúcar e Receitas</title>

    <link rel="icon" type="image/png" href="../imagens/logo32.png">

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

        .campo>label,

        .ingredientes>label,

        .preparo>label,

        .foto>label {

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

        .foto>label {

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

        .erro {

            color: #d63765;

            font-weight: bold;

            margin-bottom: 25px;

        }

    </style>

</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="principal">

        <h1>Adicionar Receita</h1>

        <?php if ($erro != ''): ?>

            <p class="erro"><?php echo $erro; ?></p>

        <?php endif; ?>

        <form action="create.php" method="post" enctype="multipart/form-data">

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

                        <input type="radio" id="facil" name="opcao" value="Fácil">

                        <label for="facil">Fácil</label>

                        <input type="radio" id="medio" name="opcao" value="Médio">

                        <label for="medio">Médio</label>

                        <input type="radio" id="dificil" name="opcao" value="Difícil">

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

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>