<?php

require_once __DIR__ . '/../database/conexao.php'; // Faz a conexão com o postgres

require_once __DIR__ . '/../includes/functions.php'; //Carregas as funções

require_once __DIR__ . '/../login/verificaUser.php'; //Verifica se o usuário está logado

$receitas = []; //isso aqui cria um array vazio. Essa variável guarda as receitas encontradas na pesquisa. Pode guardar várias porque o usuário pode ter receitas com nomes iguais ou parecidos.
$receita = null; // null é a ausência de um valor. Essa variável é usada para guardar uma única receita que foi selecionada para confirmação da exclusão.
$erro = '';// essa variável ainda não guarda nada

/*Pesquisando pelo nome:*/
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['pesquisar'])) { //O usuário enviou o formulário? se sim:

    $nome = $_POST['nome'] ?? ''; // busque por receitas que tenham:

    $sql = "SELECT id, nome, categoria, tempo_preparo, diiculdade, imagem
            FROM receitas
            WHERE nome ILIKE :nome
            ORDER BY nome"; //ILIKE É uma comparação de texto do PostgreSQL que não diferencia maiúsculas de minúsculas.

    $stmt = $pdo->prepare($sql); //prepara a consulta: liga o nome ao valor (tipo "bolo" para "%bolo%"). O prepare() prepara a consulta SQL para receber os valores dos parâmetros. O $stmt guarda o objeto que representa essa consulta preparada.

    $busca = "%" . $nome . "%"; // pesquisa qualquer receita que tenha o nome digitado pelo usuário

    $stmt->bindParam(":nome", $busca); // O bindParam() associa o parâmetro :nome ao valor da variável $busca.

    $stmt->execute(); //executa

    $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch all procura tudo e guarda em receitas. O PDO::FETCH_ASSOC indica que cada linha será representada por um array associativo, em que os nomes das colunas são as chaves.

    //aqui ele verifica se achou alguma receita:
    if (empty($receitas)) { //empty pergunta se está vazio. Se não encontrou nenhuma receita, exibe:

        $erro = "Nenhuma receita encontrada.";

    }

}

/*Aqui ele confirma a exclusão:*/
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['confirmar'])) { //Ele pergunta se a página recebeu um formulário usando o método post e se o botão de confirmar foi apertado. O PHP entra nesse bloco quando a requisição é POST e os dados recebidos tem confirmar.

    $id = $_POST['id']; // nessa parte o php pega o id que veio do formulário escondido. Eu não queria que o usuário visse o id porque normalmente você não liga qual id você é, você quer apenas usar o aplicativo ou o site. 

    $sql = "SELECT * FROM receitas WHERE id = :id"; //Essa parte significa "busque na tabela receitas onde o id é = :id" O id é o parâmetro

    //Essas três linhas preparam a consulta, associam o ID recebido ao parâmetro :id e executam a busca:
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $receita = $stmt->fetch(PDO::FETCH_ASSOC); // Se encontrar a receita, $receita será um array associativo com seus dados. Se não encontrar nenhuma linha, o resultado será false

    if (!$receita) { // o if pergunta se foi encontrada alguma receita. Se não encontrou:

        $erro = "Receita não encontrada.";

    }//Essa etapa recupera a receita selecionada para que o sistema possa confirmar qual registro será excluído antes de realizar a exclusão de fato.

}

/*Excuindo a receita:*/
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['excluir'])) { //Essa parte é uma condição  que verifica se a requisição é POST e se foi enviado um campo chamado excluir.

    $id = $_POST['id'];// aqui recebe novamente o ID da receita selecionada, agora no formulário responsável por fazer a exclusão.

    if (apagar($pdo, $id)) { // aqui ele chama a função apagar e dá parâmetros a ela: pdo que é a conexão com o banco e o id que é para apagar

        header("Location: delete.php?apagada=1"); // aqui o header solicita que o navegador abra novamente a página delete.php, desta vez com ?apagada=1 no endereço. O ? inicia uma parte da URL chamada query string, e apagada=1 é um parâmetro enviado pela URL. O sistema redireciona para a mesma página depois de excluir a receita porque ele mostra uma mensagem de sucesso.
        exit();//aqui ele encerra o código

    }
}

/*Cancelando:*/
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['cancelar'])) { //Se o usuário clicar em cancelar mostra a mensagem:

    $receitas = []; //Limpa a lista de receitas que estava guardada na variável.
    $receita = null; // Remove da variável a referência aos dados da receita que estava selecionada para confirmação.

    //Isso serve para limpar os dados usados pelo PHP nessa execução, para que a página não continue tratando a receita anterior como selecionada.

}

/*Mensagem depois de apagar:*/
if (isset($_GET['apagada'])) {// $_GET é outra variável superglobal do PHP. Ela contém os parâmetros recebidos pela URL. Quando o navegador é redirecionado para 'delete.php?apagada=1' o parâmetro apagada fica disponível em $_GET['apagada']. isset($_GET['apagada']) verifica se esse parâmetro existe e não é vazio. Se ele não for:

    $erro = "Receita apagada com sucesso.";

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

        .campo {
            display: flex;
            flex-direction: column;
        }

        .campo label {
            font-size: 1.2rem;
            font-weight: bold;
            color: #d63765;
            margin-bottom: 12px;
        }

        input[type="text"],
        input[type="search"] {
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

        input[type="search"] {
            height: 42px;
        }

        input::placeholder {
            color: #8f7c7c;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
        }

        input[type="text"]:focus,
        input[type="search"]:focus {
            outline: 2px solid #d63765;
        }

        .botoes {
            grid-column: 1 / -1;
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        button,
        input[type="submit"],
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

        button,
        input[type="submit"] {
            background-color: #d63765;
            color: #fbf5e9;
        }

        input[type="reset"] {
            background-color: transparent;
            color: #d63765;
        }

        button:hover,
        input[type="submit"]:hover,
        input[type="reset"]:hover {
            opacity: 0.8;
        }

        article {
            background-color: #f0e5d2;
            padding: 25px;
            margin-bottom: 25px;
        }

        article h3 {
            color: #d63765;
            margin-top: 0;
        }

        .confirmacao {
            background-color: #f0e5d2;
            padding: 30px;
            max-width: 700px;
        }

        .confirmacao h2 {
            margin-top: 0;
        }

        .erro {
            color: #d63765;
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

            .botoes {
                grid-column: 1;
            }
        }

    </style>

</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="principal">

        <?php if ($receita == null && empty($receitas)): ?>

            <h1>Apagar Receita</h1>

            <form action="delete.php" method="POST">

                <div class="formulario">

                    <div class="campo">

                        <label for="nome">Digite o nome da receita:</label>

                        <input type="search" name="nome" id="nome" placeholder="Digite o nome da receita" required>
                    </div>

                    <div class="botoes">

                        <input type="submit" name="pesquisar" value="Pesquisar">
                    </div>

                </div>

            </form>

            <?php if ($erro != ''): ?> <!-- aqui verifica se a variável $erro é diferente de um texto vazio.-->

                <p class="erro"><?php echo htmlspecialchars($erro); ?></p>

            <?php endif; ?>

        <?php elseif (!empty($receitas)): ?>

            <h1>Apagar Receita</h1>

            <h2>Receitas encontradas</h2>

            <p>Escolha qual receita você deseja apagar:</p>

            <?php foreach ($receitas as $receitaEncontrada): ?>

                <article>

                    <h3><?php echo htmlspecialchars($receitaEncontrada['nome']); ?></h3>

                    <p><strong>Categoria:</strong>
                        <?php echo htmlspecialchars($receitaEncontrada['categoria']); ?>
                    </p>

                    <?php if (!empty($receitaEncontrada['tempo_preparo'])): ?>

                        <p><strong>Tempo de preparo:</strong>
                            <?php echo htmlspecialchars($receitaEncontrada['tempo_preparo']); ?>
                        </p>

                    <?php endif; ?>

                    <?php if (!empty($receitaEncontrada['diiculdade'])): ?>

                        <p><strong>Dificuldade:</strong>
                            <?php echo htmlspecialchars($receitaEncontrada['diiculdade']); ?>
                        </p>

                    <?php endif; ?>

                    <form action="delete.php" method="POST">

                        <input type="hidden" name="id" value="<?php echo $receitaEncontrada['id']; ?>">

                        <input type="submit" name="confirmar" value="Excluir esta receita">

                    </form>

                </article>

                <hr>

            <?php endforeach; ?>

        <?php elseif ($receita != null): ?>

            <h1>Apagar Receita</h1>

            <div class="confirmacao">

                <h2>Confirmar exclusão</h2>

                <p>Você tem certeza que deseja apagar esta receita?</p>

                <h3><?php echo htmlspecialchars($receita['nome']); ?></h3>

                <p><strong>Categoria:</strong>
                    <?php echo htmlspecialchars($receita['categoria']); ?>
                </p>

                <div class="botoes">

                    <form action="delete.php" method="POST">

                        <input type="hidden" name="id" value="<?php echo $receita['id']; ?>">

                        <input type="submit" name="excluir" value="Sim, apagar receita">

                    </form>

                    <form action="delete.php" method="POST">

                        <input type="submit" name="cancelar" value="Não, voltar">

                    </form>

                </div>

            </div>

        <?php endif; ?>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>