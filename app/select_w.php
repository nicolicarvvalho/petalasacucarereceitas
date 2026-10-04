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
</head>

<body>
    <?php include '../includes/header.php'; ?> <!-- Incluindo o header -->

    <h1>Pesquisar Receita</h1>

    <form action="" method="post">
    <input type="search" name="pesquisar" id="pesquisar">
    <input type="submit" value="Pesquisar">
    </form>


    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        pesquisar($pdo, $_POST['pesquisar']);
    }
    ?>
</body>

</html>