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

    <p>Digite o nome da receita para atualizar</p>

    <form action="" method="post">
        <input type="search" name="atualiza" id="atualiza" placeholder="Digite o nome da receita">
        <input type="submit" value="Atualizar ">
        <input type="reset" value="Limpar ">
    </form>

    <?php

if($_SERVER['REQUEST_METHOD'] == "POST") {

    cadastrar($pdo, $_POST['usuario_id'], $_POST['categoria'], $_POST['nome'], $_POST['ingredientes'], $_POST['modo_preparo'], $_POST['tempo_preparo'], $_POST['imagem'], $_POST['dificuldade']);
    
    }
    ?>

</body>
</html>