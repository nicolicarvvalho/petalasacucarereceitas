<?php

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['confirmar'])) {

        if (excluirUsuario($pdo, $usuario_id)) {

            session_unset();
            session_destroy();

            header("Location: ../login/entrar.php");
            exit();
        }
    }

    if (isset($_POST['cancelar'])) {

        header("Location: perfil.php");
        exit();
    }
}
$base = '../';
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

    <?php include '../includes/header.php'; ?>

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

    <?php include '../includes/footer.php'; ?>

</body>

</html>