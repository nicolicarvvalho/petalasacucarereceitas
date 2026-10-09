<?php

require_once __DIR__ . '/../database/conexao.php'; // require once é para incluir o arquivo que está especificado no caminho. o 'once' é para qu se já estiver incluido não precisa. o __DIR__ é uma constante mágica, ela retorna o diretório completo do arquivo.

require_once __DIR__ . '/../includes/functions.php';

require_once __DIR__ . '/../login/verificaUser.php';

$erro = ''; // essa variavel tem uma string vazia

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //SERVER é uma variável super global do php, ela não precisa ser declarada antes de usar e pode ser 'chamada' em qualquer lugar do código. o REQUEST_METHOD é o índice que estou usando para acessar uma informação da variável SERVER. essa super global pode guardar várias informações mas para esse caso, preciso apenas a REQUEST_METHOD. Esse REQUEST_METHOD informa qual método HTTP foi usado, nesse caso é o POST, quando o usuário entra na página do site acontece uma requisição GET mas ao enviar o formulário acontece o POST. É como se essa linha falasse "se o método a requisição for POST execute isso:"

    // Pega o ID do usuário que está logado
    $usuario_id = $_SESSION['usuario_id']; // Essa SESSION é outra super global porém essa guarda as informações da sessão do usuáro. Uma sessão permite que o php guarde informações do usuário enquanto ele navega pelo sistema. Usando de exemplo esse próprio site, quando um usuário faz login ele automaticamente recebe um id. A SESSION guarda esse id. Isso tudo é guardado na variável usuario_id

    // Pega os dados preenchidos no formulário
    $nome = $_POST['nome'] ?? ''; //aqui tem outra variável super global, ela tem os dados enviados para o servidor através do método HTTP POST. quaqndo o usuario cria uma nova receita ele dá a ela nome, categoria, ingredientes e tudo que está aqui em baixo. O valor que o usuário digitar vai ser guardado nas variáveis. o nome está entre "" pois ele ligado ao nome do campo. Lá em baixo tem um form que pede tudo isso aqui em baixo. O nome do campo é o mesmo que está entre os colchetes. As duas interrogações são operadores, eles verificam se tem algo digitado no campo. Nesse caso, se não tiver nada escrito no campo nome ele vai deixar em branco, vazio, pois não há nada dentro das aspas simples.

    $categoria = $_POST['categ'] ?? '';

    $ingredientes = $_POST['ingredientes'] ?? '';

    $modo_preparo = $_POST['modo-preparo'] ?? '';

    $tempo = $_POST['tempo'] ?? '';

    $unidade = $_POST['unidade'] ?? '';

    $diiculdade = $_POST['opcao'] ?? '';

    // Junta o número com a unidade

    $tempo_preparo = $tempo . ' ' . $unidade; //$tempo_preparo é a variável que armazena o tempo completo de preparo da receita. $tempo é a variável que recebeu o número digitado pelo usuário. Ela está concatenando com uma string vazia e a variável $unidade. Ao final se o usuário tiver digitado o número 20 e escolhido a unidade minutos por exemplo, o php vai armazenar na variável tempo_preparo 20 minutos.

    // Por enquanto, deixa a imagem vazia
    $imagem = ''; // o php não sabe ainda se o usuario enviou uma imagem por isso ela está vazia. Se o usuario nao colocar nenhuma imagem esta tudo bem porque ela não tem nenhum valor.

    // Se o usuário escolheu uma imagem:
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) { //isset(): função que verifica se uma variável ou índice existe e não está vazia. FILE é outra variável super global, mas essa armazena informações dos arquivos que foram enviados pelo usuario por meio do formulário. o colchete com 'foto' dentro tem ligação com o campo do formulário que chama foto. && significa E. ['error']: acessa o código de erro associado ao envio do arquivo. 0 aqui indica que o PHP não registrou erro no envio do arquivo. Ou seja, a condição verifica se a entrada foto existe e se o envio não apresentou erro. Se esse for o caso executa:

        $pasta = __DIR__ . '/../imagens/receitas/';// a variável pasta guarda o caminho de destino da imagem que foi anexada pelo usuário.

        // Cria a pasta caso ela ainda não exista
        if (!is_dir($pasta)) { //is_dir() é uma função que verifica se o caminho informado corresponde a um diretório existente mas como tem um sinal de exclamação no inicio, o if significa "se o diretorio da variável pasta não existe, execute:"

            mkdir($pasta, 0777, true);//mkdir cria um diretorio, a variável é o caminho que vai ser criado, 0777 é a permissão que significa que o dono, o grupo e qualquer outro usuário do sistema possuem acesso total de leitura, escrita e execução do arquivo. se o PHP não tiver permissão para criar ou modificar arquivos naquela pasta, o envio das imagens pode falhar.
        }

        $nome_imagem = time() . '_' . basename($_FILES['foto']['name']); //aqui está criando um nome para a imagem. $nome_imagem é a variável que receberá o nome final do arquivo. time() é uma função do PHP que retorna o timestamp Unix atual, ou seja, o número de segundos desde 1º de janeiro de 1970, em UTC. O _ é uma string contendo um sublinhado, usado para separar o timestamp do nome original. basename() é uma função que extrai a parte final de um caminho. Aqui, é usada para obter o nome do arquivo enviado. $_FILES['foto']['name'] contém o nome original do arquivo recebido pelo PHP. Essa parte do código é importante pois pode ser que 2 usuários coloquem o mesmo nome da receita, para evitar conflitos bvem um número no nome da foto, esse número é decidido conforme o tempo ficaria tipo assim "1791493250_bolo.jpg"

        $caminho = $pasta . $nome_imagem;//$caminho é uma variável que vai armazenar o caminho completo do arquivo. Ele concatena a variável que guarda o caminho com o nome que foi criado ali em cima.

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho)) {// move_uploaded_file() é uma função do PHP que move um arquivo enviado por upload do local temporário para o destino indicado. Ela recebe 2 argumentos, um é a variável super global FILES que tem a entrada do campo da foto e o caminho temporário em que o PHP colocou o arquivo recebido. O segundo argumento é a variável que tem o caminho da foto.  Essa condição verifica se existe um arquivo enviado pelo campo chamado foto e se o envio não teve erro. As duas condições precisam ser verdadeiras para que execute o que está dentro das chaves. A variável lá em cima começa vazia, se uma imagem for enviada e salva com sucesso, o código altera seu valor. Caso contrário, ela continua vazia.
            $imagem = $nome_imagem;

        }

    }

    // Salva a receita no banco
    if (cadastrar($pdo, $usuario_id, $categoria, $nome, $ingredientes, $modo_preparo, $tempo_preparo, $imagem, $diiculdade)) { // aqui está chamando a função cadastrar e dando arumentos a ela. Os argumentos são todos os dados que são perguntados na tela do usuário. pdo é a conexão com banco e usuario_id é o id do usuário que está logado.

    //A função cadastrar() tenta salvar a receita no banco de dados. O if verifica o valor que essa função retorna. Se retornar um valor considerado verdadeiro, o PHP executa o bloco do if. Senão excuta o outro bloco que é o else

        header("Location: select.php"); // essa linha e a de baixo são executadas quando a função a cima retorna verdadeiro. header() é uma função do PHP que envia um cabeçalho HTTP ao navegador. O location indica pro navegador para onde ele deve acessar a página. Nesse caso, é no select.  Nesse caso, o cabeçalho Location solicita que o navegador abra outra página o select.php. 

        exit();// esse encerra a execução do código PHP imediatamente. Ele evita que o resto do arquivo continue rodando depois do redirecionamento. 

    } else {// Isso é para caso a função der errado. As funções retornam true ou false. O else é o false. Se a função cadastrar retornar false exibe a mensagem de erro:

        $erro = "Já existe uma receita com esse nome. Escolha outro nome."; //essa mensagem é para caso o usuário cadastrar uma receita e o nome já existir.
    }
}
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
            background-color: #fbf5e9 !important;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #d63765;
        }

        .principal {
            max-width: 1000px;
            margin: 55px auto;
            padding: 0 50px 60px;
        }

        .principal h1 {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 2.1rem;
            font-weight: bold;
            margin: 0 0 50px;
            color: #d63765;
        }

        .formulario {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 70px;
            row-gap: 40px;
        }

        .campo,
        .ingredientes,
        .preparo,
        .foto {
            display: flex;
            flex-direction: column;
        }

        .campo>label,
        .ingredientes>label,
        .preparo>label,
        .foto>label {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1.2rem;
            font-weight: bold;
            color: #d63765;
            margin-bottom: 12px;
        }

        .campo input[type="text"] {
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

        .campo input[type="number"] {
            width: 100px;
            height: 42px;
            border: none;
            background-color: #f0e5d2;
            padding: 10px;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        .campo select {
            height: 42px;
            border: none;
            background-color: #f0e5d2;
            padding: 8px 12px;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        input::placeholder,
        textarea::placeholder {
            color: #8f7c7c;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            opacity: 1;
        }

        textarea {
            width: 100%;
            border: none;
            background-color: #f0e5d2;
            padding: 12px;
            resize: none;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        .ingredientes {
            grid-column: 1;
        }

        .ingredientes textarea {
            height: 160px;
        }

        .preparo {
            grid-column: 1;
        }

        .preparo textarea {
            height: 160px;
        }

        .opcoes {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .opcoes label {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1.05rem;
            font-weight: normal;
            color: #5f4b4b;
            margin-right: 10px;
        }

        .opcoes input[type="radio"] {
            accent-color: #d63765;
            width: 16px;
            height: 16px;
        }

        .foto {
            grid-column: 2;
            grid-row: 2;
            align-self: start;
        }

        .foto>label {
            margin-bottom: 12px;
        }

        .foto input[type="file"] {
            width: 100%;
            height: 100px;
            padding: 25px 18px;
            background-color: #f0e5d2;
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
            padding: 10px 18px;
            margin-right: 12px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-weight: bold;
            cursor: pointer;
        }

        .tempo-campo {
            grid-column: 2;
            grid-row: 3;
        }

        .tempo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .tempo select {
            width: 130px;
        }

        .botoes {
            grid-column: 1 / -1;
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .botaoA,
        .botaoC {
            min-width: 170px;
            height: 45px;
            padding: 8px 25px;
            border: 2px solid #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .botaoA {
            background-color: #d63765;
            color: #fbf5e9;
        }

        .botaoC {
            background-color: transparent;
            color: #d63765;
        }

        .botaoA:hover,
        .botaoC:hover {
            opacity: 0.8;
        }

        .campo input[type="text"]:focus,
        .campo input[type="number"]:focus,
        .campo select:focus,
        textarea:focus {
            outline: 2px solid #d63765;
        }

        @media (max-width: 700px) {
            .principal {
                padding: 0 25px 35px;
            }

            .formulario {
                grid-template-columns: 1fr;
                row-gap: 30px;
            }

            .ingredientes,
            .preparo,
            .foto,
            .tempo-campo {
                grid-column: 1;
                grid-row: auto;
            }

            .botoes {
                grid-column: 1;
            }

        }

        .erro {
            color: #d63765;
            font-weight: bold;
            margin-bottom: 25px;
        }

    </style>

</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="principal">

        <h1>Adicionar Receita</h1>

        <?php if ($erro != ''): ?> <!-- Lá em cima tinha a variável erro, essa parte pergunta "ela tem alguma coisa diferente de um texto vazio?" -->

            <p class="erro"><?php echo $erro; ?></p> <!-- Se o cadastro falhar, o código poderá atribuir uma mensagem a ela:  "Já existe uma receita com esse nome. Escolha outro nome."-->

        <?php endif; ?>

        <form action="create.php" method="post" enctype="multipart/form-data">

            <div class="formulario">

                <div class="campo">

                    <label for="nome">Nome da receita:</label>

                    <input type="text" name="nome" id="nome" placeholder="Digite o nome da receita">

                </div>

                <div class="campo">

                    <label>Categoria:</label>

                    <div class="opcoes">

                        <input type="radio" name="categ" id="doce" value="Doce">

                        <label for="doce">Doce</label>

                        <input type="radio" name="categ" id="salgado" value="Salgado">

                        <label for="salgado">Salgado</label>

                    </div>

                </div>

                <div class="ingredientes">

                    <label for="ingredientes">Ingredientes:</label>

                    <textarea id="ingredientes" name="ingredientes" placeholder="Digite os ingredientes da receita"></textarea>

                </div>

                <div class="foto">

                    <label for="foto">Adicione uma foto:</label>

                    <input type="file" id="foto" name="foto" accept="image/*" capture="user">

                </div>

                <div class="preparo">

                    <label for="modo-preparo">Modo de Preparo:</label>

                    <textarea id="modo-preparo" name="modo-preparo" placeholder="Explique passo a passo de como preparar a receita"></textarea>

                </div>

                <div class="campo">

                    <label>Dificuldade:</label>

                    <div class="opcoes">

                        <input type="radio" id="facil" name="opcao" value="Fácil">

                        <label for="facil">Fácil</label>

                        <input type="radio" id="medio" name="opcao" value="Médio">

                        <label for="medio">Médio</label>

                        <input type="radio" id="dificil" name="opcao" value="Difícil">

                        <label for="dificil">Difícil</label>

                    </div>

                </div>

                <div class="campo tempo-campo">

                    <label for="tempo">Tempo:</label>

                    <div class="tempo">

                        <input type="number" id="tempo" name="tempo" min="1" placeholder="Ex.: 30">

                        <select name="unidade">

                            <option value="minutos">Minutos</option>

                            <option value="horas">Horas</option>

                        </select>

                    </div>

                </div>

                <div class="botoes">

                    <input type="submit" value="Adicionar Receita" class="botaoA">

                    <input type="reset" value="Cancelar" class="botaoC">

                </div>

            </div>

        </form>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>