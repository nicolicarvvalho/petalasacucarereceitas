<?php

require_once __DIR__ . '/../database/conexao.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';


$usuario_id = $_SESSION['usuario_id'];//guarda na variável usuario_id a sessão do usuario

$usuario = consulta_id($pdo, $usuario_id); //guarda na variavel usuario o resultado da função consulta_id

if ($_SERVER['REQUEST_METHOD'] == "POST") {//se o usuario tiver feito uma requisição do tipo post:

    $email = $_POST['email'] ?? '';//guarda o resultado do ternário: se o usuario tiver feitouma requisição no campo email do tipo post guarda nela senão deixa vazia
    $senha = $_POST['senha'] ?? '';//mesma coisa
    $fotoperfil = $_POST['fotoperfil'] ?? '';//mesma coisa
    $foto_upload = $_FILES['foto_upload'] ?? null;//mesma coisa, porem com null pois a super golbal FILES não guarda strings por isso não usa ' '

    atualizaEmail($pdo, $usuario_id, $email);//chama a função atualizaEmail

    if (!empty($senha)) { //se a senha for diferente de vazia
        atualizaSenha($pdo, $usuario_id, $senha); //chama a função atualizaSenha
    }

    if (!empty($fotoperfil)) {//se a foto de perfil for diferente de vazia
        atualizaFoto($pdo, $usuario_id, $fotoperfil); //chama a função que atualiza a foto
    }

    if ($foto_upload && $foto_upload['error'] == 0) { //se a variável que guarda a foto existir e não tiver dado erro :
    $pasta_perfil = __DIR__ . '/../imagens/perfil/'; //gurda na variável pasta_perfil que tem o caminho para a imagem ficar
    
    // Cria a pasta caso não exista
    if (!is_dir($pasta_perfil)) { //se o diretorio pasta perfil não existir:
        mkdir($pasta_perfil, 0777, true); //cria a pasta e dá permissões a ela. o 077 fala que qualquer parte do site ou o próprio sistema pode ler, escrever (salvar arquivos) e deletar coisas dentro desta pasta. o true cria alguma pasta que estiver faltando, por exemplo se a pasta imagens não existir ele pode criar para que o código não quebre
    }

    $nome_original = $foto_upload['name'];//guarda na variavel nome_original o nome da foto que o usuario fez upload
    $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);//na variavel extensão fica guardada a extensão da imagem que o usuario enviou. Na linha de cima com o nome da foto dava para descobrir a extensão da imagem, aqui dá para guardar somente a extensão. 
    //A função pathinfo varre o texto, acha o ponto e isola o final. 
    //PATHINFO_EXTENSION é tipo um filtro, é com ele que é possível pegar somente a extensão.
    $novo_nome = 'usuario_' . $usuario_id . '.' . $extensao; //nessa variavel fica guardada o novo do nome da foto. Exemplo: usuario_8.png
    $caminho = $pasta_perfil . $novo_nome; //nessa variável fica guardada a pasta onde fica as fotos com o novo nome da foto

    if (move_uploaded_file($foto_upload['tmp_name'], $caminho)) { //quando o arquivo é enviado pelo usuario ele fica em uma pasta temporária. Por iso tem que mover esse arquivo para a pasta caminho
        $caminho_banco = 'perfil/' . $novo_nome; //nessa variável ica guardada o nome que vai ser salvo. Exemplo: perfil/usuario_8.png
        atualizaFoto($pdo, $usuario_id, $caminho_banco);//chama a função atualizaFoto
    }
}
}

$base = '../'; //essa variável fica guardando uma parte do caminho. Tive que criar ela porque os meus includes estavam dando conflito
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
            background-color: #fbf5e9;
            padding: 0;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #5f4b4b;
        }

        .principal {
            max-width: 1000px;
            margin: 55px auto;
            padding: 0 50px 60px;
        }

        h1 {
            color: #d63765;
            font-size: 2.1rem;
            font-weight: bold;
            margin-bottom: 35px;
            text-align: center;
        }

        .campo {
            display: flex;
            flex-direction: column;
            max-width: 600px;
            margin: 0 auto 30px;
        }

        .campo label {
            color: #d63765;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .campo input[type="email"],
        .campo input[type="password"] {
            width: 100%;
            height: 42px;
            border: none;
            background-color: #f0e5d2;
            padding: 10px 14px;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        .campo input[type="email"]:focus,
        .campo input[type="password"]:focus {
            outline: 2px solid #d63765;
        }

        h2 {
            color: #d63765;
            font-size: 1.5rem;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 25px;
        }

        .fotos {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            max-width: 800px;
            margin: 0 auto 40px;
        }

        .foto-opcao {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            background-color: #d63765;
            border-radius: 10px;
            cursor: pointer;
        }

        .foto-opcao img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            display: block;
            border-radius: 5px;
        }

        .foto-opcao input[type="radio"] {
            display: none;
        }

        .foto-opcao:has(input[type="radio"]:checked) {
            outline: 4px solid #5f4b4b;
            outline-offset: 3px;
        }

        .upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 35px;
        }

        .upload input[type="file"] {
            width: 100%;
            max-width: 500px;
            padding: 15px;
            background-color: #f0e5d2;
            border: 2px solid #d63765;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            cursor: pointer;
        }

        .upload input[type="file"]::file-selector-button {
            background-color: #d63765;
            color: #fbf5e9;
            border: none;
            padding: 10px 15px;
            margin-right: 10px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-weight: bold;
            cursor: pointer;
        }

        /* Container flexível para colocar os botões lado a lado */
        .botoes-grupo {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        .botao {
            display: inline-block;
            margin: 0;
            padding: 10px 25px;
            background-color: #d63765;
            color: #fbf5e9;
            border: 2px solid #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .botao:hover {
            opacity: 0.8;
        }

        .voltar {
            display: inline-block;
            padding: 10px 25px;
            color: #d63765;
            background-color: transparent;
            border: 2px solid #d63765;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            font-family: Georgia, 'Times New Roman', Times, serif;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .voltar:hover {
            background-color: #d63765;
            color: #ffffff;
        }

        @media (max-width: 800px) {
            .fotos {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 600px) {
            .principal {
                padding: 0 25px 35px;
            }

            .fotos {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
    <link rel="icon" type="image/png" href="../imagens/logo32.png">

</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>



    <main class="principal">

        <h1>Editar perfil</h1>

        <form action="editarPerfil.php" method="POST" enctype="multipart/form-data">

            <div class="campo">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>
            </div>

            <div class="campo">
                <label for="senha">Senha Nova:</label>
                <input type="password" id="senha" name="senha">
            </div>

            <h2>Escolha uma foto de perfil</h2>

            <div class="fotos">
                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/padrao.png" style="border-radius: 100%;">
                    <img src="../imagens/perfil/padrao.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/1.png">
                    <img src="../imagens/perfil/1.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/2.png">
                    <img src="../imagens/perfil/2.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/3.png">
                    <img src="../imagens/perfil/3.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/4.png">
                    <img src="../imagens/perfil/4.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/5.png">
                    <img src="../imagens/perfil/5.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/6.png">
                    <img src="../imagens/perfil/6.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/7.png">
                    <img src="../imagens/perfil/7.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/8.png">
                    <img src="../imagens/perfil/8.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/9.png">
                    <img src="../imagens/perfil/9.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/10.png">
                    <img src="../imagens/perfil/10.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/13.png">
                    <img src="../imagens/perfil/13.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/14.png">
                    <img src="../imagens/perfil/14.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/15.png">
                    <img src="../imagens/perfil/15.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/16.png">
                    <img src="../imagens/perfil/16.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/17.png">
                    <img src="../imagens/perfil/17.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/18.png">
                    <img src="../imagens/perfil/18.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/20.png">
                    <img src="../imagens/perfil/20.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/21.png">
                    <img src="../imagens/perfil/21.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/22.png">
                    <img src="../imagens/perfil/22.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/23.png">
                    <img src="../imagens/perfil/23.png">
                </label>

                <label class="foto-opcao">
                    <input type="radio" name="fotoperfil" value="perfil/24.png">
                    <img src="../imagens/perfil/24.png">
                </label>
            </div>

            <h2>Ou escolha uma foto do seu dispositivo</h2>

            <div class="upload">
                <input type="file" name="foto_upload" accept="image/*" capture="user">
            </div>

            <div class="botoes-grupo">
                <button type="submit" class="botao">Salvar</button>
                <a href="./perfil.php" class="voltar">Voltar</a>
            </div>

        </form>

    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>