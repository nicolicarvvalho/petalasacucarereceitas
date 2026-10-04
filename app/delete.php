<?php
require_once '../database/conexao.php'; // Faz a conexão com o postgres
require_once __DIR__ . '/../includes/functions.php'; //Carregas as funções
require_once __DIR__ . '/../login/verificaUser.php'; //Verifica se o usuário está logado
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <h1>Apagar Receita</h1>

    <main>

        <?php

//Aqui ele confirma a exclusão:
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['confirmar'])) { //Ele pergunta se a página recebeu um formulário usando o método post e se o botão de confirmar foi apertado. Ou seja essa parte verifica se o botão de excluir receita foi pressionado

            $id = $_POST['id']; // nessa parte o php pega o id que veio do formulário escondido. Eu não queria que o usuário visse o id porque normalmente você não liga qual id você é, você quer apenas usar o aplicativo ou o site

            $sql = "SELECT * FROM receitas WHERE id = :id"; //Essa parte significa "busque na tabela receitas onde o id é = :id" O id é o parâmetro

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $receita = $stmt->fetch(); // fetch pega o resultado encontrado $receita tem a receita que foi encontrada

            if ($receita) { // o if pergunta se foi encontrada alguma receita. Se tiver encontrado mostra:

                echo "<h2>Confirmar exclusão</h2>";
                echo "<p>Você tem certeza que deseja apagar esta receita?</p>";
                echo "<h3>" . htmlspecialchars($receita['nome']) . "</h3>"; // o htmlspecialchars() protege o texto antes de coloca-lo no html. Ele pega o nome da receita.
                echo "<p>Categoria: "
                    . htmlspecialchars($receita['categoria']) //Aqui ele faz a mesma coisa porém mostra o nome da categoria
                    . "</p>";
                echo "<form action='' method='post'>"; //esse formulário é responsável pela confirmação
                echo "<input type='hidden' name='id' value='" // O hidden significa que o usuário não precisa ver esse campo
                    . $receita['id'] // o php recebe algo como "$_POST['id']"
                    . "'>";

                    //botão de apagar receita
                echo "<input type='submit' name='excluir' value='Sim, apagar receita'>";
                echo "</form>";
                echo "<br>";

                //botão de não apagar receita
                echo "<form action='' method='post'>";
                echo "<input type='submit' name='cancelar' value='Não, voltar'>";
                echo "</form>";
            }

//Excuindo a receita:

        } elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['excluir'])) { //Essa parte pergunta algo como "O usuário confirmou que quer excluir?" se sim:
            $id = $_POST['id'];
            if (apagar($pdo, $id)) { // aqui ele chama a função apagar e dá parâmetros a ela
                echo "<h2>Receita apagada!</h2>";
                echo "<p>A receita foi excluída com sucesso.</p>";
            }

//Cancelando:

        } elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['cancelar'])) { //Se o usuário clicar em cancelar mostra a mensagem:
            echo "<p>Exclusão cancelada.</p>";

//Pesquisando pelo nome:

        } elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['pesquisar'])) { //O usuário enviou o formulário? se sim:
            $nome = $_POST['nome']; // busque por receitas que tenham:
            $sql = "SELECT id, nome, categoria, tempo_preparo, dificuldade, imagem
                    FROM receitas
                    WHERE nome ILIKE :nome 
                    ORDER BY nome"; //ILIKE É uma comparação de texto do PostgreSQL que não diferencia maiúsculas de minúsculas.

            $stmt = $pdo->prepare($sql); //prepara a consulta: liga o nome ao valor (tipo "bolo" para "%bolo%)
            $busca = "%" . $nome . "%"; // pesquisa qualquer receita que tenha o nome digitado pelo usuário
            $stmt->bindParam(":nome", $busca);
            $stmt->execute(); //executa
            $receitas = $stmt->fetchAll(); //fetch all procura tudo e guarda em receitas

            if (empty($receitas)) { //empty pergunta se está vazio. Se não encontrou nenhuma receita, exibe:
                echo "<p>Nenhuma receita encontrada.</p>";
            } else { //senão:
                echo "<h2>Receitas encontradas</h2>";
                echo "<p>Escolha qual receita você deseja apagar:</p>";
                foreach ($receitas as $receita) { //para cada receita enconrada faça isso
                    echo "<article>";
                    echo "<h3>"// mostra o nome e depois a categoria
                        . htmlspecialchars($receita['nome'])
                        . "</h3>";
                    echo "<p><strong>Categoria:</strong> "
                        . htmlspecialchars($receita['categoria'])
                        . "</p>";
                        //pergunta se a receita possui tempo de preparo, se tiver mostra
                    if (!empty($receita ['tempo_preparo'])) {
                        echo "<p><strong>Tempo de preparo:</strong> "
                            . htmlspecialchars($receita['tempo_preparo'])
                            . "</p>";
                    }
                    if (!empty($receita['diiculdade'])) {
                        echo "<p><strong>Dificuldade:</strong> "
                            . htmlspecialchars($receita['diiculdade'])
                            . "</p>";
                    }
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='id' value='" // o id fica escondido
                        . $receita['id']
                        . "'>";
                    echo "<input type='submit' name='confirmar' value='Excluir esta receita'>"; // o usuário ve apenas o botão
                    echo "</form>";
                    echo "</article>";
                    echo "<hr>";
                }
            }
        }

        ?>
        <?php if ( //Essa parte é para decidir se mostra de novo o campo de digitar o nome da receita, ou seja "A página ainda não recebeu um formulário." ou 
            $_SERVER['REQUEST_METHOD'] != "POST"
            || isset($_POST['cancelar']) // o usuário cancelou a exclusão
        ): 
        ?>
            <h2>Pesquisar receita</h2>
            <form action="" method="post">
                <label for="nome">
                    Digite o nome da receita:
                </label>
                <!-- Cria o campo onde o usuário digita: -->
                <input
                    type="search"
                    name="nome"
                    id="nome"
                    required
                > 
            <!-- Cria o botão: -->
                <input
                    type="submit"
                    name="pesquisar"
                    value="Pesquisar"
                >
            <!-- Cria outro botão porém esse para limpar-->
                <input
                    type="reset"
                    value="Limpar"
                >
            </form>

        <?php endif; ?>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>