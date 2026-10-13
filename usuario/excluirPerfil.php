<?php

require_once __DIR__ . '/../database/conexao.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';


$usuario_id = $_SESSION['usuario_id']; //guarda na variável usuario_id a sessão que o usuario começou

if ($_SERVER['REQUEST_METHOD'] == "POST") { //se o usuario que está logado tiver feito uma requisição do tipo post, execute:

    if (isset($_POST['confirmar'])) {//se o botão de confirmar for pressionado:

        if (excluirUsuario($pdo, $usuario_id)) { //se a função funcionar:

            session_unset();// apaga todos os valores que estavam guardados dentro das variáveis de sessão.
            session_destroy();////Destrói completamente o arquivo de sessão que estava salvo no servidor para aquele usuário específico.

            header("Location: ../login/cadastrar.php");//redireciona para a página de cadastrar
            exit();//encerra o código
        }
    }

    if (isset($_POST['cancelar'])) {//se o usuario tiver pressionado o botão de cancelar

        header("Location: perfil.php");//redireciona para a página de perfil
        exit();//encerra o código
    }
}
$base = '../'; //variável que guarda o caminho
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Excluir perfil</title>

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
            text-align: center;
        }

        h1 {
            color: #d63765;
            font-size: 2.1rem;
            font-weight: bold;
            margin-bottom: 35px;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        strong {
            color: #d63765;
        }

        .botoes {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .botao {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d63765;
            color: #fbf5e9;
            text-decoration: none;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            font-weight: bold;
            border: 2px solid #d63765;
            cursor: pointer;
        }

        .botao.cancelar {
            background-color: transparent;
            color: #d63765;
        }

        .botao:hover {
            opacity: 0.8;
        }

    </style>
    <link rel="icon" type="image/png" href="../imagens/logo32.png">

</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="principal">

        <h1>Excluir perfil</h1>

        <p>
            Tem certeza que deseja excluir seu perfil?
        </p>

        <p>
            <strong>Atenção:</strong>
            todas as suas receitas também serão excluídas.
        </p>

        <form action="excluirPerfil.php" method="POST">

            <div class="botoes">

                <button type="submit" name="confirmar" class="botao">
                    Sim, excluir meu perfil
                </button>

                <button type="submit" name="cancelar" class="botao cancelar">
                    Cancelar
                </button>

            </div>

        </form>

    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>