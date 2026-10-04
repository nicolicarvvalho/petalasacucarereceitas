<?php
require_once __DIR__ . '/../includes/functions.php'; ?>

<?php

require_once __DIR__ . '/../includes/functions.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Cadastra o novo usuário
    if (cadastraUser($pdo, $email, $senha)) {

        // Depois de cadastrar, vai para a página inicial
        header("Location: ../inicio.php");
        exit();

    } else {

        $erro = "Não foi possível criar a conta.";
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>

        <style>
      * {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    background-color: #fbf5e9;
    font-family: Georgia, 'Times New Roman', Times, serif;
    color: #d63765;
}

.conteudo {
    max-width: 1000px;
    margin: 45px auto;
    padding: 0 50px 50px;
}

h1 {
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 0 35px;
    color: #d63765;
}

.formulario {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px 55px;
}

.campo {
    display: flex;
    flex-direction: column;
}

.campo > label {
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-size: 1.15rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: #d63765;
}

.campo input[type="text"],
.campo input[type="number"],
.campo select {
    width: 100%;
    height: 38px;
    border: none;
    background-color: #f3ead9;
    padding: 8px 12px;
    color: #5f4b4b;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-size: 1rem;
    outline: none;
}

.campo input[type="text"]:focus,
.campo input[type="number"]:focus,
.campo select:focus,
textarea:focus {
    outline: 2px solid #d63765;
    outline-offset: 1px;
}

input::placeholder,
textarea::placeholder {
    color: #9b8585;
    font-family: Georgia, 'Times New Roman', Times, serif;
    opacity: 1;
}

textarea {
    width: 100%;
    border: none;
    background-color: #f3ead9;
    padding: 12px;
    color: #5f4b4b;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-size: 1rem;
    resize: none;
    outline: none;
}

.ingredientes {
    grid-column: 1;
}

.ingredientes textarea {
    height: 145px;
}

.modo-preparo {
    grid-column: 1;
}

.modo-preparo textarea {
    height: 145px;
}

.opcoes {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
}

.opcoes label {
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-size: 1rem;
    font-weight: normal;
    margin-right: 8px;
    margin-bottom: 0;
}

.opcoes input[type="radio"] {
    accent-color: #d63765;
    width: 15px;
    height: 15px;
}

.tempo {
    display: flex;
    gap: 10px;
}

.tempo input {
    width: 100px !important;
}

.tempo select {
    width: 130px;
}

.foto {
    grid-column: 2;
    grid-row: 2 / span 2;
    align-self: start;
}

.foto > label {
    margin-bottom: 12px;
}

.foto input[type="file"] {
    width: 100%;
    min-height: 95px;
    padding: 30px 20px;
    background-color: #f3ead9;
    border: 3px solid #d63765;
    color: #d63765;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-size: 1rem;
    cursor: pointer;
}

.foto input[type="file"]::file-selector-button {
    background-color: #d63765;
    color: #fbf5e9;
    border: none;
    padding: 9px 18px;
    margin-right: 12px;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight: bold;
    cursor: pointer;
}

.botoes {
    grid-column: 1 / -1;
    display: flex;
    gap: 15px;
    margin-top: 5px;
}

.botao {
    min-width: 150px;
    height: 42px;
    border: 2px solid #d63765;
    background-color: #d63765;
    color: #fbf5e9;
    padding: 8px 22px;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

.botao:hover {
    opacity: 0.85;
}

.botao.cancelar {
    background-color: transparent;
    color: #d63765;
}

.botao.cancelar:hover {
    background-color: #d63765;
    color: #fbf5e9;
}

@media (max-width: 700px) {
    .conteudo {
        padding: 0 25px 35px;
    }

    .formulario {
        grid-template-columns: 1fr;
    }

    .ingredientes,
    .modo-preparo,
    .foto {
        grid-column: 1;
        grid-row: auto;
    }

    .botoes {
        grid-column: 1;
    }
}
    </style>

</head>

<body>

    <div class="telaCadastro">

        <div class="ladoEsquerdo">
            <div class="logo">
                <img src="../imagens/logos.png" alt="Pétalas, Açúcar e Receitas Logo">
            </div>
        </div>

        <div class="ladoDireito">

            <h1>Criar Conta</h1>

            <form action="" method="post" class="cadastro">

                <div class="email">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="email">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" placeholder="Digite uma senha forte" required>
                </div>

                <input type="submit" value="Criar Conta" class="botaos">

                <input type="reset" value="Limpar Campos" class="botaol">

            </form>

        </div>

    </div>


    <!-- Isso aqui é para caso o usuário digite uma senha ou usuário errado a mensagem de erro não fique feia -->
     <?php if (!empty($erro)): ?>
            <p style="color: #F7EFE1; margin-top: 15px; text-align: center; font-family: sans-serif; font-size: 0.9rem;">
                <?php echo $erro; ?>
            </p>
        <?php endif; ?>


</body>

</html>