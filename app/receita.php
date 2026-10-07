<?php

require_once '../database/conexao.php';

require_once __DIR__ . '/../includes/functions.php';

require_once __DIR__ . '/../login/verificaUser.php';

$id = $_GET['id'] ?? '';

$receita = null;

if ($id != '') {

    $sql = "SELECT * FROM receitas WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":id", $id);

    $stmt->execute();

    $receita = $stmt->fetch(PDO::FETCH_ASSOC);

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
            color: #5f4b4b;
        }

        .principal {
            max-width: 1000px;
            margin: 55px auto;
            padding: 0 50px 60px;
        }

        h1 {
            color: #d63765;
            font-size: 2.1rem;
            margin-bottom: 35px;
        }

        .imagem-receita {
            width: 100%;
            max-width: 500px;
            height: 300px;
            object-fit: cover;
            display: block;
            margin: 0 auto 30px;
        }

        .receita {
            background-color: #f0e5d2;
            padding: 30px;
        }

        .receita h2 {
            color: #d63765;
            margin-top: 0;
            font-size: 1.7rem;
        }

        .receita p {
            line-height: 1.6;
        }

        .receita strong {
            color: #d63765;
        }

        .voltar {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #d63765;
            color: #fbf5e9;
            text-decoration: none;
            font-weight: bold;
        }

        .voltar:hover {
            opacity: 0.8;
        }

        .erro {
            color: #d63765;
            font-weight: bold;
        }

    </style>

</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="principal">

        <?php if ($receita): ?>

            <h1><?php echo htmlspecialchars($receita['nome']); ?></h1>

            <?php if (!empty($receita['imagem'])): ?>

                <img src="../imagens/receitas/<?php echo htmlspecialchars($receita['imagem']); ?>" 
                     alt="Imagem da receita" 
                     class="imagem-receita">

            <?php endif; ?>

            <div class="receita">

                <h2>Informações da receita</h2>

                <p>
                    <strong>Categoria:</strong>
                    <?php echo htmlspecialchars($receita['categoria']); ?>
                </p>

                <p>
                    <strong>Dificuldade:</strong>
                    <?php echo htmlspecialchars($receita['diiculdade']); ?>
                </p>

                <p>
                    <strong>Tempo de preparo:</strong>
                    <?php echo htmlspecialchars($receita['tempo_preparo']); ?>
                </p>

                <p>
                    <strong>Ingredientes:</strong><br>
                    <?php echo nl2br(htmlspecialchars($receita['ingredientes'])); ?>
                </p>

                <p>
                    <strong>Modo de preparo:</strong><br>
                    <?php echo nl2br(htmlspecialchars($receita['modo_preparo'])); ?>
                </p>

                <a href="select.php" class="voltar">Voltar para receitas</a>

            </div>

        <?php else: ?>

            <h1>Receita não encontrada</h1>

            <p class="erro">
                Não foi possível encontrar essa receita.
            </p>

            <a href="select.php" class="voltar">Voltar para receitas</a>

        <?php endif; ?>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>