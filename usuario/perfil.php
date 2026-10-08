<?php

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';

$usuario_id = $_SESSION['usuario_id'];

$usuario = consulta_id($pdo, $usuario_id);

if (isset($_POST['excluir_perfil'])) {

    if (excluirUsuario($pdo, $usuario_id)) {

        session_unset();
        session_destroy();

        header("Location: ../login/entrar.php");
        exit();
    }
}

$foto = '../imagens/' . $usuario['fotoperfil'];
$base = '../';
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

            background-color: #fbf5e9;;

            font-family: Georgia, 'Times New Roman', Times, serif;

            color: #5f4b4b;

        }

        .perfil {

            max-width: 1000px;

            margin: 55px auto;

            padding: 0 50px 60px;

            text-align: center;

        }

        .perfil h1 {

            color: #d63765;

            font-size: 2.1rem;

            margin-bottom: 35px;

        }

        .foto-perfil {

        border-radius: 50%;
            width: 200px;

            height: 200px;

            object-fit: cover;

            display: block;

            margin: 0 auto 25px;

        }

        .email {

            color: #5f4b4b;

            font-size: 1.1rem;

            margin-bottom: 30px;

        }

        .botoes {

            display: flex;

            justify-content: center;

            gap: 15px;

        }

        .botao {

            display: inline-block;

            background-color: #d63765;

            color: #fbf5e9;

            padding: 10px 20px;

            text-decoration: none;

            font-family: Georgia, 'Times New Roman', Times, serif;

            font-weight: bold;

            border: none;

            cursor: pointer;

        }

        .botao:hover {

            opacity: 0.8;

        }
    </style>

</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>


    <main class="perfil">

        <h1>Meu Perfil</h1>

        <<img src="<?php echo '../imagens/' . $usuario['fotoperfil']; ?>" alt="Foto de perfil" class="foto-perfil">

        <p class="email">
            E-mail: <?php echo $usuario['email']; ?>
        </p>

        <div class="botoes">

            <a href="../usuario/editarPerfil.php" class="botao">Editar perfil</a>

            <a href="../usuario/excluirPerfil.php" class="botao">Excluir perfil</a>

        </div>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>


</body>

</html>