<?php 

require_once '../database/conexao.php';

require '../includes/functions.php'; 

require_once __DIR__ . '/../login/verificaUser.php';

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

        main {

            max-width: 1000px;

            margin: 55px auto;

            padding: 0 50px 60px;

        }

        h1 {

            font-size: 2.1rem;

            font-weight: bold;

            margin: 0 0 35px;

            color: #d63765;

        }

        .pesquisa {

            display: flex;

            gap: 15px;

            margin-bottom: 40px;

        }

        .pesquisa input[type="search"] {

            width: 500px;

            height: 42px;

            border: none;

            background-color: #f0e5d2;

            padding: 12px;

            color: #5f4b4b;

            font-family: Georgia, 'Times New Roman', Times, serif;

            font-size: 1rem;

            outline: none;

        }

        .pesquisa input[type="search"]:focus {

            outline: 2px solid #d63765;

        }

        .pesquisa input[type="submit"] {

            height: 42px;

            padding: 8px 25px;

            border: 2px solid #d63765;

            background-color: #d63765;

            color: #fbf5e9;

            font-family: Georgia, 'Times New Roman', Times, serif;

            font-size: 1rem;

            font-weight: bold;

            cursor: pointer;

        }

        .pesquisa input[type="submit"]:hover {

            opacity: 0.8;

        }

        .card-receita {

            width: 240px;

            padding: 20px;

            background-color: #f0e5d2;

            margin: 15px;

            display: inline-block;

            vertical-align: top;

        }

        .card-receita img {

            width: 100%;

            height: 150px;

            object-fit: cover;

            display: block;

            margin-bottom: 15px;

        }

        .card-receita h2 {

            color: #d63765;

            font-size: 1.2rem;

        }

        .card-receita p {

            color: #5f4b4b;

        }

        .botao-receita {

            display: inline-block;

            background-color: #d63765;

            color: #fbf5e9 !important;

            padding: 10px 15px;

            margin-top: 10px;

            text-decoration: none !important;

            font-family: Georgia, 'Times New Roman', Times, serif;

            font-weight: bold;

            border: none;

        }

        .botao-receita:hover {

            background-color: #d63765;

            color: #fbf5e9 !important;

            text-decoration: none !important;

            opacity: 0.8;

        }

        @media (max-width: 700px) {

            main {

                padding: 0 25px 35px;

            }

            .pesquisa {

                flex-direction: column;

            }

            .pesquisa input[type="search"] {

                width: 100%;

            }

        }

    </style>

</head>

<body>

    <?php include '../includes/header.php'; ?> <!-- Incluindo o header -->

    <main>

        <h1>Pesquisar Receita</h1>

        <form action="" method="post" class="pesquisa">

            <input

                type="search"

                name="pesquisar"

                id="pesquisar"

                placeholder="Digite o nome da receita"

            >

            <input

                type="submit"

                value="Pesquisar"

            >

        </form>

        <?php

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            pesquisar($pdo, $_POST['pesquisar']);

        }

        ?>

    </main>

    <?php include '../includes/footer.php'; ?>

</body>

</html>