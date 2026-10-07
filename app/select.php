<?php
require_once '../database/conexao.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Todas</title>

    <link rel="icon" type="image/png" href="../imagens/logo32.png">

    <style>
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

        body {
            margin: 0;
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
            margin-bottom: 35px;
        }
    </style>

</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>

        <h1>Receitas</h1>

        <?php

        verTodas($pdo);

        ?>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>