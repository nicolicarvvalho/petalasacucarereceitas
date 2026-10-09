<?php
require_once __DIR__ . '/../database/conexao.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';

$receita = null;
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['pesquisar'])) {
    $nome = $_POST['nome'] ?? '';

    $sql = "SELECT * FROM receitas WHERE LOWER(nome) = LOWER(:nome)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->execute();

    $receita = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$receita) {
        $erro = "Receita não encontrada.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['atualizar'])) {
    $id = $_POST['id'];
    $usuario_id = $_SESSION['usuario_id'];

    if (empty($_POST['nome']) || empty($_POST['categoria']) || empty($_POST['ingredientes']) || empty($_POST['modo_preparo']) || empty($_POST['tempo']) || empty($_POST['diiculdade'])) {
        $erro = "Preencha todos os campos obrigatórios antes de atualizar a receita.";

        $sql = "SELECT * FROM receitas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $receita = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $categoria = $_POST['categoria'];
        $nome = $_POST['nome'];
        $ingredientes = $_POST['ingredientes'];
        $modo_preparo = $_POST['modo_preparo'];
        $tempo = $_POST['tempo'];
        $unidade = $_POST['unidade'];
        $tempo_preparo = $tempo . ' ' . $unidade;
        $diiculdade = $_POST['diiculdade'];

        $imagem = $_POST['imagem_atual'];

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $nomeImagem = basename($_FILES['imagem']['name']);
            $pasta = __DIR__ . '/../imagens/receitas/';
            $caminhoImagem = $pasta . $nomeImagem;

            move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem);
            $imagem = $nomeImagem;
        }

        try {
            $sql = "UPDATE receitas 
                    SET categoria = :categoria,
                        nome = :nome,
                        ingredientes = :ingredientes,
                        modo_preparo = :modo_preparo,
                        tempo_preparo = :tempo_preparo,
                        imagem = :imagem,
                        diiculdade = :diiculdade
                    WHERE id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":categoria", $categoria);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":ingredientes", $ingredientes);
            $stmt->bindParam(":modo_preparo", $modo_preparo);
            $stmt->bindParam(":tempo_preparo", $tempo_preparo);
            $stmt->bindParam(":imagem", $imagem);
            $stmt->bindParam(":diiculdade", $diiculdade);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $sucesso = "Receita atualizada com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao atualizar receita: " . $e->getMessage();
        }

        // Recarrega os dados atualizados da receita para manter o formulário exibido e preenchido
        $sql = "SELECT * FROM receitas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $receita = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Extrai o valor numérico e a unidade do tempo_preparo (ex: "30 minutos")
$tempoNum = '';
$tempoUnidade = 'minutos';
if ($receita && !empty($receita['tempo_preparo'])) {
    $partesTempo = explode(' ', trim($receita['tempo_preparo']));
    $tempoNum = $partesTempo[0] ?? '';
    if (isset($partesTempo[1])) {
        $tempoUnidade = strtolower($partesTempo[1]);
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
            background-color: #fbf5e9;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #d63765;
        }

        .principal {
            max-width: 1000px;
            margin: 55px auto;
            padding: 0 50px 60px;
        }

        .principal h1 {
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
        .dificuldade,
        .foto,
        .tempo-campo {
            display: flex;
            flex-direction: column;
        }

        .campo label,
        .ingredientes label,
        .preparo label,
        .dificuldade>label,
        .foto label,
        .tempo-campo>label {
            font-size: 1.2rem;
            font-weight: bold;
            color: #d63765;
            margin-bottom: 12px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            border: none;
            background-color: #f0e5d2;
            padding: 12px;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        input[type="text"] {
            height: 42px;
        }

        input[type="number"] {
            width: 100px;
            height: 42px;
        }

        textarea {
            height: 160px;
            resize: none;
        }

        input::placeholder,
        textarea::placeholder {
            color: #8f7c7c;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid #d63765;
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

        .nome-campo {
            grid-column: 1;
        }

        .categoria-campo {
            grid-column: 2;
        }

        .ingredientes {
            grid-column: 1;
        }

        .preparo {
            grid-column: 1;
        }

        .foto {
            grid-column: 2;
            grid-row: 2;
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

        .dificuldade {
            grid-column: 1;
            grid-row: 4;
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
            height: 42px;
        }

        .botoes {
            grid-column: 1 / -1;
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        button,
        input[type="reset"] {
            min-width: 170px;
            height: 45px;
            padding: 8px 25px;
            border: 2px solid #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
        }

        button {
            background-color: #d63765;
            color: #fbf5e9;
        }

        input[type="reset"] {
            background-color: transparent;
            color: #d63765;
        }

        button:hover,
        input[type="reset"]:hover {
            opacity: 0.8;
        }

        .erro {
            color: #d63765;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .sucesso {
            color: #2e7d32;
            font-weight: bold;
            margin-bottom: 25px;
        }

        @media (max-width: 700px) {
            .principal {
                padding: 0 25px 35px;
            }

            .formulario {
                grid-template-columns: 1fr;
                row-gap: 30px;
            }

            .nome-campo,
            .categoria-campo,
            .ingredientes,
            .preparo,
            .foto,
            .dificuldade,
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

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="principal">

        <h1>Atualizar Receita</h1>

        <?php if ($erro != ''): ?>
            <p class="erro"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>

        <?php if ($sucesso != ''): ?>
            <p class="sucesso"><?php echo htmlspecialchars($sucesso); ?></p>
        <?php endif; ?>

        <?php if ($receita == null): ?>

            <form action="update.php" method="POST">

                <div class="formulario">

                    <div class="campo nome-campo">
                        <label for="nome">Nome da receita:</label>
                        <input type="text" name="nome" id="nome" placeholder="Digite o nome da receita" required>
                    </div>

                    <div class="botoes">
                        <button type="submit" name="pesquisar">Pesquisar</button>
                    </div>

                </div>

            </form>

        <?php else: ?>

            <form action="update.php" method="POST" enctype="multipart/form-data">

                <div class="formulario">

                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($receita['id']); ?>">
                    <input type="hidden" name="imagem_atual" value="<?php echo htmlspecialchars($receita['imagem'] ?? ''); ?>">

                    <div class="campo nome-campo">
                        <label for="nome">Nome da receita:</label>
                        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($receita['nome']); ?>" required>
                    </div>

                    <div class="campo categoria-campo">
                        <label for="categoria">Categoria:</label>

                        <div class="opcoes">
                            <input type="radio" name="categoria" id="categ1" value="Doce" <?php if (($receita['categoria'] ?? '') == 'Doce') echo 'checked'; ?>>
                            <label for="categ1">Doce</label>

                            <input type="radio" name="categoria" id="categ2" value="Salgado" <?php if (($receita['categoria'] ?? '') == 'Salgado') echo 'checked'; ?>>
                            <label for="categ2">Salgado</label>
                        </div>
                    </div>

                    <div class="ingredientes">
                        <label for="ingredientes">Ingredientes:</label>
                        <textarea id="ingredientes" name="ingredientes" required><?php echo htmlspecialchars($receita['ingredientes']); ?></textarea>
                    </div>

                    <div class="foto">
                        <label for="foto">Adicione uma foto:</label>
                        <input type="file" id="foto" name="imagem" accept="image/*">
                    </div>

                    <div class="preparo">
                        <label for="modo-preparo">Modo de Preparo:</label>
                        <textarea id="modo-preparo" name="modo_preparo" required><?php echo htmlspecialchars($receita['modo_preparo']); ?></textarea>
                    </div>

                    <div class="dificuldade">
                        <label for="dificuldade">Dificuldade:</label>

                        <div class="opcoes">
                            <input type="radio" id="opcao1" name="diiculdade" value="valor1" <?php if (($receita['diiculdade'] ?? '') == 'valor1') echo 'checked'; ?>>
                            <label for="opcao1">Fácil</label>

                            <input type="radio" id="opcao2" name="diiculdade" value="valor2" <?php if (($receita['diiculdade'] ?? '') == 'valor2') echo 'checked'; ?>>
                            <label for="opcao2">Médio</label>

                            <input type="radio" id="opcao3" name="diiculdade" value="valor3" <?php if (($receita['diiculdade'] ?? '') == 'valor3') echo 'checked'; ?>>
                            <label for="opcao3">Difícil</label>
                        </div>
                    </div>

                    <div class="campo tempo-campo">
                        <label for="tempo">Tempo:</label>

                        <div class="tempo">
                            <input type="number" id="tempo" name="tempo" min="1" value="<?php echo htmlspecialchars($tempoNum); ?>" placeholder="Ex: 30" required>

                            <select name="unidade">
                                <option value="minutos" <?php if ($tempoUnidade == 'minutos') echo 'selected'; ?>>Minutos</option>
                                <option value="horas" <?php if ($tempoUnidade == 'horas') echo 'selected'; ?>>Horas</option>
                            </select>
                        </div>
                    </div>

                    <div class="botoes">
                        <button type="submit" name="atualizar">Atualizar Receita</button>
                        <input type="reset" value="Limpar">
                    </div>

                </div>

            </form>

        <?php endif; ?>

    </main>



    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>