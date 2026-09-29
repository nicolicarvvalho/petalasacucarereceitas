<?php include_once '../includes/functions.php' ?>

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
        <input type="search" name="pesquisar" id="pesquisar" placeholder="Digite o nome da receita">
        <button type="submit">Pesquisar</button>
    </form>
    
    <?php 

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Cria a variável pegando o texto do input
        $nome_busca = $_POST['pesquisar'] ?? ''; // As interrogações funcionam como um se senão: se algo tiver sido digitado ele guara na variável nome_busca senão ele deixa vazio

        //Chama a função 
        consultar($pdo, $nome_busca);
    }
    ?>


</body>
</html>