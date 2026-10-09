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

        /* Layout em duas colunas (Imagem na esquerda, conteúdo na direita) */
        .conteudo-receita {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        /* Quadro da foto com borda rosa */
        .quadro-imagem {
            width: 280px;
            height: 280px;
            flex-shrink: 0;
            border: 2px solid #d63765;
            background-color: #f0e5d2;
        }

        .quadro-imagem img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Container do bloco de dados da receita */
        .receita {
            flex: 1;
            background-color: #f0e5d2;
            padding: 30px;
        }

        .receita h2 {
            color: #d63765;
            margin-top: 0;
            font-size: 1.7rem;
            margin-bottom: 20px;
        }

        .receita p {
            line-height: 1.6;
            margin-bottom: 15px;
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

        /* Adaptador para telas menores/celulares */
        @media (max-width: 768px) {
            .conteudo-receita {
                flex-direction: column;
                align-items: center;
            }

            .quadro-imagem {
                width: 100%;
                max-width: 320px;
                height: 260px;
            }

            .receita {
                width: 100%;
            }
        }

    </style>

</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="principal">

        <?php if ($receita): ?>

            <h1><?php echo htmlspecialchars($receita['nome']); ?></h1>

            <div class="conteudo-receita">

                <!-- Quadro da Imagem (Lado Esquerdo) -->
                <div class="quadro-imagem">
                    <?php 
                    $caminho_imagem = "../imagens/receitas/" . $receita['imagem'];
                    if (!empty($receita['imagem']) && file_exists(__DIR__ . '/' . $caminho_imagem)): 
                    ?>
                        <img src="<?php echo htmlspecialchars($caminho_imagem); ?>" 
                             alt="<?php echo htmlspecialchars($receita['nome']); ?>">
                    <?php endif; ?>
                </div>

                <!-- Detalhes da Receita (Lado Direito) -->
                <div class="receita">

                    <h2>Informações da receita</h2>

                    <p>
                        <strong>Categoria:</strong>
                        <?php echo htmlspecialchars($receita['categoria']); ?>
                    </p>

                    <p>
                        <strong>Dificuldade:</strong>
                        <?php echo htmlspecialchars($receita['dificuldade'] ?? $receita['diiculdade'] ?? ''); ?>
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