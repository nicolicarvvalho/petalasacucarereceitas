<?php

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/login/verificaUser.php';

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['confirmar'])) {

        if (excluirUsuario($pdo, $usuario_id)) {

            session_unset();
            session_destroy();

            header("Location: login/entrar.php");
            exit();
        }
    }

    if (isset($_POST['cancelar'])) {

        header("Location: perfil.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Excluir perfil</title>

</head>

<body>

    <h1>Excluir perfil</h1>

    <p>
        Tem certeza que deseja excluir seu perfil?
    </p>

    <p>
        <strong>Atenção:</strong>
        todas as suas receitas também serão excluídas.
    </p>

    <form action="excluirPerfil.php" method="POST">

        <button type="submit" name="confirmar">
            Sim, excluir meu perfil
        </button>

        <button type="submit" name="cancelar">
            Cancelar
        </button>

    </form>

</body>

</html>