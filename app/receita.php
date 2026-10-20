<?php

require_once __DIR__ . '/../database/conexao.php';

require_once __DIR__ . '/../includes/functions.php';

require_once __DIR__ . '/../login/verificaUser.php';

$id = $_GET['id'] ?? '';//aqui estou pegando o id que foi enviado por meio do metodo GET e se exsitir um id estou guardando na vriável senão deixando vazio

$receita = null;//por enquanto a variavel receita está vazia

if ($id != '') {//se o id for diferente de vazio, execute:

  //ali em cima o usuario tinha um id, usando de exemplo o id = 5, o php vai executar uma busca na base de dados para encontrar a receita do ID 5. Caso a condiçõo for falsa ele pula esse bloco
    $sql = "SELECT * FROM receitas WHERE id = :id";
    $stmt = $pdo->prepare($sql);//aqui, ele envia o comando $sql para a base de dados preparar a consulta, mas sem executá-la ainda. O objeto de conexão que é o $pdo envia a variavel $sql para o servidor do banco de dados .
    $stmt->bindParam(":id", $id);//O bindParam() limpa o valor da variável $id automaticamente. Se um hacker tentar colocar comandos maliciosos na URL ele não permite

    $stmt->execute();//O PHP envia para o postgres o valor contido na variável $id vinculada no passo anterior.

    $receita = $stmt->fetch(PDO::FETCH_ASSOC); //Traz a receita encontrada na base de dados e guarda dentro da variável $receita. O PDO::FETCH_ASSOC faz isso virar uma lista organizada. A partir desse momento, é possivel usar $receita['nome'], $receita['ingredientes'], etc., no  HTML.
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

        <?php if ($receita): ?> <!-- se tem a variável receita (que começou vazia), execute: -->

            <h1><?php echo htmlspecialchars($receita['nome']); ?> </h1><!-- mostra o nome dela -->

            <div class="conteudo-receita">

                <!-- Aqui é o lugar onde a imagem aparece: -->
                <div class="quadro-imagem">

                    <?php

                    $caminho_imagem = "../imagens/receitas/" . $receita['imagem'];// isso aqui cria o endereço relativo da imagem. Esse é o endereço que o navegador precisa para conseguir encontrar e carregar a imagem na tela
                    $caminho_disco  = __DIR__ . '/../imagens/receitas/' . $receita['imagem'];// e aqui cria o caminho absoluto  dentro do disco do servidor (tipo c:/documentos/petalasacucarereceitas/imagens/receitas). esse o PHP precisa do caminho completo do disco para checar se o arquivo realmente existe na pasta antes de tentar mostrá-lo.

                    if (!empty($receita['imagem']) && file_exists($caminho_disco)):// se a imagem não estiver vazia e existir algo na variável cominho_disco, execute: 
                    ?>
                        <img src="<?php echo htmlspecialchars($caminho_imagem); ?>" alt="<?php echo htmlspecialchars($receita['nome']); ?>"> <!-- Mostre a imagem que4 está na variavel com o seu nome -->

                    <?php endif; ?>

                </div>

                <!-- Aqui o o php vai exibir os dados sobre a receita-->
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
                    </p> <!-- esse echo nl2br transforma as linhas quebradas em <br> -->

                    <a href="select.php" class="voltar">Voltar para receitas</a>

                </div>

            </div>

        <?php else: ?>

            <h1>Receita não encontrada</h1>

            <p class="erro">
                Não foi possível encontrar essa receita.
            </p>

            <a href="select.php" class="voltar">Voltar para as suas receitas</a>

        <?php endif; ?>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>