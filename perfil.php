<?php

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/login/verificaUser.php';

$usuario_id = $_SESSION['usuario_id'];

$usuario = consulta_id($pdo, $usuario_id);

if (isset($_POST['excluir_perfil'])) {

    if (excluirUsuario($pdo, $usuario_id)) {

        session_unset();
        session_destroy();

        header("Location: login/entrar.php");
        exit();
    }
}

$foto = '/imagens/' . $usuario['fotoperfil'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
</head>

<body>

    <?php include './includes/header.php'; ?>


    <h1>Meu Perfil</h1>

    <img src="<?php echo '/imagens/' . $usuario['fotoperfil']; ?>" alt="Foto de perfil" width="200">

    <p>
        E-mail: <?php echo $usuario['email']; ?>
    </p>

    <a href="editarPerfil.php">Editar perfil</a>

    <a href="excluirPerfil.php"> Excluir perfil </a>

    <?php include './includes/footer.php'; ?>


</body>

</html>