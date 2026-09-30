<!-- Essa já está certo -->

<?php require_once __DIR__ . '/../includes/functions.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
</head>

<body>
    <div>
        <h1>Criar conta</h1>

        <form action="" method="post">
            <label for="email">E-mail: </label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail">
            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" placeholder="Digite uma senha forte">
            <input type="submit" value="Cadastrar">
            <input type="reset" value="Limpar ">
        </form>

    </div>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        cadastraUser($pdo, $_POST['email'], $_POST['senha']);
        header("Location: ../inicio.php");
        exit();
    }
    ?>

</body>

</html>