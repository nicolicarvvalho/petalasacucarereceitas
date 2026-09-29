<?php include_once '../includes/functions.php';?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Incluindo o header -->

    <h1>Atualizar Receita</h1>

    <p>Digite o nome da receita para apagar</p>

    <form action="" method="post">
        <input type="search" name="apaga" id="apaga" placeholder="Digite o nome da receita">
        <input type="submit" value="Apagar">
    </form>

    <?php
        if($_SERVER['REQUEST_METHOD']=="POST"){
        apagar($pdo, $_POST['nome']);
        } 
        ?>
</body>
</html>