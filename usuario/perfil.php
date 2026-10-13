<?php

require_once __DIR__ . '/../database/conexao.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';

$usuario_id = $_SESSION['usuario_id']; //guarda na variável usuario_id a sessão que o usuario começou

$usuario = consulta_id($pdo, $usuario_id); //guarda na variável usuario o resultado da função consulta_id

if (isset($_POST['excluir_perfil'])) { //se o botão de excluir perfil for clicado

    if (excluirUsuario($pdo, $usuario_id)) { //se a função excluir usuario funcionar

        session_unset();//apaga os dados do usuario da sessão
        session_destroy();//destroi os dados

        header("Location: ../login/cadastrar.php");//redireciona para a página de cadastrar
        exit();
    }
}

$nome_foto = !empty($usuario['fotoperfil']) ? basename($usuario['fotoperfil']) : '../imagens/perfil/padrao.png';//guarda na variavel nome_foto: se a foto de perfil do usuario estiver perfil e ele não tiver colocado nenhuma foto, automaticamente dá ao usuario a foto de perfil padrão

$base = '../';//variavelque guarda uma parte do caminho
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
            background-color: #fbf5e9;
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

        <img src="../imagens/perfil/<?php echo $nome_foto; ?>" alt="Foto de perfil" class="foto-perfil"><!--mostra o caminho que está guardada a foto e mostra ela -->

        <p class="email">
            E-mail: <?php echo htmlspecialchars($usuario['email'] ?? ''); ?><!--mostra o caminho do usuario -->
        </p>

        <div class="botoes">

            <a href="../usuario/editarPerfil.php" class="botao">Editar perfil</a>
            <a href="../usuario/excluirPerfil.php" class="botao">Excluir perfil</a>

        </div>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>


</body>

</html>