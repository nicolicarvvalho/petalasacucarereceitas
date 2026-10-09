<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>

    <link rel="icon" type="image/png" href="./imagens/logo32.png">


    <style>
        /* Deinxando sem bordas: */
        * {
            /* O asterisco pega tudo que é html do arquivo */
            margin: 0;
            /* Esse e o debaixo remove os espaçamentos externos e internos que o navegador coloca por padrão (*/
            padding: 0;
            box-sizing: border-box;
            /* Esse garante que  padding e border fiquem incluídas na largura e altura total do elemento, evitando que caixas destorcer ao adicionar espaçamentos. */
        }

        /* Deixando o fundo da mesma cor da imagem porque ela não tem tamanho suficiente para ficar na tela inteira: */
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            /* Ess e debaixo deixam toda a tela do navegador na cor abaixo*/
            height: 100%;
            background-color: #F7EFE1;
            /* Cor creme/bege do fundo da imagem */
        }

        .principal {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .logo {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
        }

        /* Aumentando a imagem */
        .logo img {
            display: block;
            width: 90%;
            /* Aumenta a imagem para ocupar 90% da largura disponível */
            max-width: 1100px;
            /* Define um limite bem maior para ecrãs grandes */
            height: auto;
            /* Mantém a proporção sem distorcer */
            margin: 0 auto;
        }

        .login {
            display: flex;
            justify-content: center;
            /* Centraliza os botões no meio da tela */
            gap: 30px;
            /* Controla a distância entre os dois lados (diminua o número para aproximar mais) */
            align-items: flex-end;
            /* Alinha a base dos botões */
            padding: 25px 40px;
            background-color: #d63765;
            width: 100%;
        }

        .cadastrar {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            /* Espaço entre a pergunta e o botão */
        }

        .cadastrar label {
            font-family: sans-serif;
            font-size: 0.9rem;
            color: #F7EFE1;
        }

        .botaoe {
            padding: 10px 24px;
            display: inline-block;
            background-color: #F7EFE1;
            color: #d63765;
            border: 2px solid;
            text-decoration: none;
            /* Tira o sublinhado azul do link */
            font-weight: bold;
            font-family: sans-serif;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background-color 0.2s, color 0.2s;
            text-decoration: none;
            /* Tira o sublinhado do link */

        }

        .botaoe:hover {
            opacity: 0.9;
        }

        .botaoc {
            padding: 10px 24px;
            display: inline-block;
            background-color: transparent;
            border: 2px solid #F7EFE1;
            text-decoration: none;
            /* Tira o sublinhado azul do link */
            color: #F7EFE1;
            font-weight: bold;
            font-family: sans-serif;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background-color 0.2s, color 0.2s;
        }

        .botaoc:hover {
            background-color: #F7EFE1;
            color: #d63765;
        }
    </style>

</head>

<body>


    <main class="principal">

        <div class="logo">
            <img src="./imagens/logos.png" alt="logo pétalas, açúcar e receitas">
        </div>

        <div class="login">
            <div class="cadastrar">
                <label for="cadastre-se">Ainda não tem uma conta?</label>
                <a href="login/cadastrar.php" class="botaoc">Cadastre-se</a>
            </div>
            <div class="entrar">
                <a href="login/entrar.php" class="botaoe">Entrar</a>
            </div>
        </div> <!-- essa fecha a div login -->

    </main>


</body>

</html>