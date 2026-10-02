<!-- Esse já está certo -->
<?php require_once __DIR__ . '/../includes/functions.php'; 
require_once '../database/conexao.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
</head>

<body>
    <div>
        <h1>Entrar</h1>

        <form action="" method="post">

            <label for="email">E-mail: </label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail">
            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
            <input type="submit" value="Entrar">
            <input type="reset" value="Limpar ">
        </form>

        <?php

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $usuario = consulta_user($pdo, $_POST['email']);
            if ($usuario['email'] == $_POST['email'] && $usuario['senha'] == $_POST['senha']) {
                session_start();
                $_SESSION['id'] = $usuario['id'];
                header("Location: ../inicio.php");
                exit();
            } else {
                echo "Usuário ou senha inválidos.";
            }
        }
        ?>
    </div>
</body>

</html>