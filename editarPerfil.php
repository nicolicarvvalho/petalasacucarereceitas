<?php

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/login/verificaUser.php';

$usuario_id = $_SESSION['usuario_id'];

$usuario = consulta_id($pdo, $usuario_id);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $fotoperfil = $_POST['fotoperfil'] ?? '';
    $foto_upload = $_FILES['foto_upload'] ?? null;

    atualizaEmail($pdo, $usuario_id, $email);

    if (!empty($senha)) {
        atualizaSenha($pdo, $usuario_id, $senha);
    }

    if (!empty($fotoperfil)) {
        atualizaFoto($pdo, $usuario_id, $fotoperfil);
    }

    if ($foto_upload && $foto_upload['error'] == 0) {

    $nome_original = $foto_upload['name'];
    $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
    $novo_nome = 'usuario_' . $usuario_id . '.' . $extensao;
    $caminho = __DIR__ . '/imagens/perfil/' . $novo_nome;
    move_uploaded_file($foto_upload['tmp_name'], $caminho);
    $caminho_banco = 'perfil/' . $novo_nome;
    atualizaFoto($pdo, $usuario_id, $caminho_banco);
}

    header("Location: perfil.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
</head>

<body>

    <h1>Editar perfil</h1>

    <form action="editarPerfil.php" method="POST" enctype="multipart/form-data">

        <label for="email">E-mail:</label>

        <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>

        <label for="senha">Senha Nova:</label>

        <input type="password" id="senha" name="senha">

        <h2>Escolha uma foto de perfil</h2>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/padrao.png">
            <img src="/imagens/perfil/padrao.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/1.png">
            <img src="/imagens/perfil/1.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/2.png">
            <img src="/imagens/perfil/2.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/3.png">
            <img src="/imagens/perfil/3.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/4.png">
            <img src="/imagens/perfil/4.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/5.png">
            <img src="/imagens/perfil/5.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/6.png">
            <img src="/imagens/perfil/6.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/7.png">
            <img src="/imagens/perfil/7.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/8.png">
            <img src="/imagens/perfil/8.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/9.png">
            <img src="/imagens/perfil/9.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/10.png">
            <img src="/imagens/perfil/10.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/13.png">
            <img src="/imagens/perfil/13.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/14.png">
            <img src="/imagens/perfil/14.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/15.png">
            <img src="/imagens/perfil/15.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/16.png">
            <img src="/imagens/perfil/16.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/17.png">
            <img src="/imagens/perfil/17.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/18.png">
            <img src="/imagens/perfil/18.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/20.png">
            <img src="/imagens/perfil/20.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/21.png">
            <img src="/imagens/perfil/21.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/22.png">
            <img src="/imagens/perfil/22.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/23.png">
            <img src="/imagens/perfil/23.png" width="100">
        </label>

        <label>
            <input type="radio" name="fotoperfil" value="perfil/24.png">
            <img src="/imagens/perfil/24.png" width="100">
        </label>

        <br><br>

        <h2>Ou escolha uma foto do seu dispositivo</h2>

        <input type="file" name="foto_upload" accept="image/*" capture="user">

        <button type="submit">Salvar </button>

    </form>

</body>

</html>