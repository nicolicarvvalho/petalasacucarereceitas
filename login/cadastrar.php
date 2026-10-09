<?php
session_start(); // Inicia a sessão para permitir o login automático

require_once __DIR__ . '/../includes/functions.php';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    try {
        if (cadastraUser($pdo, $email, $senha)) {
            // Busca o usuário recém-criado para obter o ID e logar automaticamente
            $usuario = consulta_user($pdo, $email);
            
            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                
                // Redireciona para a página inicial (caminho correto)
                header("Location: ../app/inicio.php");
                exit();
            }
        } else {
            $erro = "Não foi possível criar a conta.";
        }
    } catch (PDOException $e) {
        $erro = "Não foi possível criar a conta. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas - Cadastrar</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Georgia, 'Times New Roman', Times, serif;
            background-color: #f6edde;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .telaEntrar {
            display: flex;
            width: 900px;
            max-width: 95%;
            height: 500px;
            background-color: #f6edde;
        }

        .ladoEsquerdo {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .logo img {
            width: 100%;
            max-width: 500px;
            height: auto;
            display: block;
        }

        .ladoDireito {
            flex: 1;
            background-color: #d63765;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            transform: translateX(50px);
        }

        .entrar {
            width: 100%;
            max-width: 320px;
        }

        .ladoDireito h1 {
            color: #f6edde;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 35px;
            margin-top: 0;
        }

        .email {
            margin-bottom: 25px;
            display: flex;
            flex-direction: column;
        }

        .email label {
            color: #f6edde;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .email input {
            background-color: transparent;
            border: 2px solid #f6edde;
            padding: 12px;
            color: #f6edde;
            font-size: 1rem;
            outline: none;
        }

        .email input::placeholder {
            color: #f6edde;
            opacity: 0.7;
        }

        /* Botão de enviar */
        .botaos {
            display: block;
            width: 100%;
            background-color: #f6edde;
            color: #d63765;
            border: none;
            padding: 12px 0;
            font-size: 1.1rem;
            font-weight: bold;
            font-family: Georgia, 'Times New Roman', Times, serif;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-bottom: 10px;
        }

        .botaos:hover {
            background-color: #f6edde;
        }

        /* Botão de limpar */
        .botaol {
            display: block;
            width: 100%;
            background-color: transparent;
            color: #f6edde;
            border: 1px solid #f6edde;
            padding: 8px 0;
            font-size: 0.9rem;
            cursor: pointer;
            opacity: 0.8;
        }

        .botaol:hover {
            opacity: 1;
        }

        /* Botão de voltar/login */
        .botaov {
            display: block;
            width: 30%;
            background-color: transparent;
            color: #f6edde;
            border: 1px solid #f6edde;
            padding: 8px 0;
            font-size: 0.9rem;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            opacity: 0.8;
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
            box-sizing: border-box;
            transition: opacity 0.2s;
        }          

        .botaov:hover {
            opacity: 1;
            background-color: #f6edde;
            color: #d63765;
        }

        .pergunta {
            font-size: 14px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #f6edde;
            display: block;
            margin-top: 15px;
            text-align: center;
        }
    </style>

        <link rel="icon" type="image/png" href="../imagens/logo32.png">

</head>

<body>

    <div class="telaEntrar">

        <div class="ladoEsquerdo">
            <div class="logo">
                <img src="../imagens/logos.png" alt="Pétalas, Açúcar e Receitas Logo">
            </div>
        </div>

        <div class="ladoDireito">

            <h1>Criar Conta</h1>

            <form action="" method="post" class="entrar">

                <div class="email">
                    <label for="email">E-mail: </label>
                    <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="email">
                    <label for="senha">Senha: </label>
                    <input type="password" name="senha" id="senha" placeholder="Digite uma senha forte" required>
                </div>

                <input type="submit" value="Criar Conta" class="botaos">
                <input type="reset" value="Limpar" class="botaol">
            </form>

            <?php if (!empty($erro)): ?>
                <p style="color: #F7EFE1; margin-top: 15px; text-align: center; font-family: sans-serif; font-size: 0.9rem;">
                    <?php echo $erro; ?>
                </p>
            <?php endif; ?>

        </div>

    </div>

</body>

</html>