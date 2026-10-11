<?php

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php'; //Esse verificaUser eu estou pedindo para incluir para que caso o usuário não esteja logado seja redirecionado para a tela de login.

$usuario_id = $_SESSION['usuario_id']; //quqando o usuario entra no site ele abre uma sessão, ao criar uma sessão o usuario recebe um id, esse id é guardado nessa variavel
$usuario = consulta_id($pdo, $usuario_id);//Chama a função consulta_id, passando a conexão $pdo e o ID do usuário para buscar suas informações no banco de dados. Isso é guardado nessa variável

// Guarda na variável $pasta_disco o caminho completo do servidor até a pasta do carrossel.
$pasta_disco = __DIR__ . '/../imagens/carrossel/';

// Busca todas as imagens dentro de app/imagens/carrossel/
$imagens_disco = glob(
    $pasta_disco . "*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}", // A função glob() procura todos os arquivos dentro da pasta que terminam com as extensões indicadas. O parâmetro GLOB_BRACE permite fazer a busca por múltiplas extensões entre as chaves
    GLOB_BRACE
);

$imagens = []; //essa variável guarda os caminhos relativos. Está usando colchetes porque é um array, tem que ser array porque uma variável guarda apenas 1 valor. Sendo um array ela pode criar linhas e colunas para que caiba varias informações

if (!empty($imagens_disco)) {//aqui está verificando se a função glob() encontrou alguma imagem na pasta

    foreach ($imagens_disco as $img) {//percorre todos os caminhos que foram encontrados. A variavel imagens_disco tem as imagens que foram encontras. Estou pedindo para que quando o foreach percorrer a lista dar um nome temporário para a imagem encontrada

        $nome_ficheiro = basename($img); //basename() pega apenas o nome do ficheiro (ex: foto1.jpg), removendo todo o caminho do diretório. A função glob retorna o caminho inteiro do arquivo mas o navegador não entende esse caminho, por isso o basename corta esse caminho e deixa apenas o nome principal do arquivo.

        $imagens[] = "../imagens/carrossel/" . $nome_ficheiro;//aqui a variavel imagem está com o colchete vazio porque estou pedindo para adicionar nela as informações que estão na frente do igual. Precisa colocar esse caminho porque o navegador HTML precisa do caminho relativo à página web para exibir a imagem corretamente. Precisa concatenar o caminho com a variável porque o servidor precisa do caminho completo da pasta, enquanto a variável contém apenas o nome do arquivo. $nome_ficheiro muda a cada imagem encontrada no dispositivo (exemplo: na 1ª vez é "foto1.jpg", na 2ª é "bolo.png").Ficaria tipo assim: ../imagens/carrossel/foto1.jpg
    }
} else {
    // Se a pasta estiver vazia, carrega imagens de teste
    $imagens = [
        "https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&h=400&fit=crop",
        "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800&h=400&fit=crop",
        "https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=800&h=400&fit=crop"
    ];//aqui a variavel imagem aparece de novo porem estou dando a ela valores fixos. Quando o carrossel não carregar porque a pasta não tiver com imagens dentro vai carregar essas fotos que estão nos links
}

$total = count($imagens); //nessa variavel fica armazenada a quantidade de fotos que tem na lista

$regras_carrossel = ""; //Nessa variável, fica guarando a gambiarra que eu fiz para não usar javacript. Com ela é possível que quando o usuário clique em uma bolinha do carrossel a imagem mude para outra. Se chama regra porqe é como se fosse uma regra o que o css vai ter que fazer.

for ($i = 0; $i < $total; $i++) {//nesse laço de repetição ele adiciona a cada foto encontrada (que é a variável i) duas regras no css. O laço vai rodar enquanto $i for menor que $total (o número total de imagens no carrossel). A cada volta, adiciona 1 ao $i.
    $regras_carrossel .= " 
        #radio-$i:checked ~ .carrossel-track {
            transform: translateX(-" . ($i * 100) . "%);
        }
        #radio-$i:checked ~ .carrossel-nav label[for=\"radio-$i\"] {
            transform: scale(1.2);
            background: #d63765;
        }
    "; //o operador .= concatena o texto que já está salvo dentro da variavel regras_carrossel. Para não apagar a regra da foto anterior, acumulando as regras de todas as fotos em uma única variável. 
    //a segunda linha embaixo da variável fala "Quando o botão do tipo de rádio com o ID radio-$i estiver marcado ( :checked), procure o elemento irmão .carrossel-trackque está mais adiante". É com isso que quando o usuário marca uma bolinha a imagem carrega. 
    // Na linha de baixo o php calcula i * 100 para saber o quanto tem quer ter a deslocação em porcentagem. Por exemplo, (i começa no 0, então a primeira foto vai ser a 0), se i for 2 ele vai ter que se deslocar -300%, para a esquerda. 
    //"Enquanto o botão invisível de número $i estiver marcado ( :checked), navegue pelos seus elementos irmãos até encontrar o container '.carrossel-nav', e dentro dele encontre a bolinha <label> que pertence a este botão $i ."
    // Nas ultimas 2 linhas quando a bolinha for clicada fica na cor rosa.
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
            background-color: #fbf5e9;
        }

        /* Área da conta */
        .conta {
            text-align: center;
            width: 100px;
            margin-left: auto;
            margin-right: 30px;
            margin-top: 15px;
        }

        .conta a {
            text-decoration: none;
        }

        .conta img {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
        }

        .conta p {
            margin-top: 5px;
            font-weight: bold;
            color: #d63765;
        }

        .frase-carrossel {
            text-align: center;
            color: #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1.9rem;
            margin-top: 35px;
            margin-bottom: 25px;
        }

        .subfrase-carrossel {
            text-align: center;
            color: #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1.2rem;
            margin-top: 0;
            margin-bottom: 25px;
        }

        /* Container do carrossel */
        .carrossel-container {
            max-width: 800px;
            margin: 40px auto;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Esconde os radios */
        .carrossel-container input[type="radio"] {
            display: none;
        }

        /* Trilho das imagens */
        .carrossel-track {
            display: flex;
            width: 100%;
            transition: transform 0.4s ease;
        }

        /* Cada imagem ocupa toda a área do carrossel */
        .carrossel-item {
            flex: 0 0 100%;
            width: 100%;
        }

        .carrossel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        /* Bolinhas de navegação */
        .carrossel-nav {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .carrossel-nav label {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #d63765;
            cursor: pointer;
            transition: 0.3s;
        }

        <?php echo $regras_carrossel; ?> /* Aqui é onde as regras que foram escritas lá em cima são executadas */

    </style>
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Conta do usuário -->
    <div class="conta">
        <a href="../usuario/perfil.php">
            <img src="../imagens/<?php echo basename($usuario['fotoperfil']); ?>" alt="Foto de perfil"> <!-- Aqui pega o caminho da foto de perfil do usuario e com a basename limpa tudo deixando apenas o nome principal. O caminho vem do banco de dados. -->
            <p>Meu perfil</p>
        </a>
    </div>

    <!-- Carrossel -->
    <h1 class="frase-carrossel">
        Compartilhe seus melhores momentos em forma de receitas
    </h1>

    <p class="subfrase-carrossel">
        Se inspire, crie e compartilhe suas receitas favoritas
    </p>

    <div class="carrossel-container">

<!-- Aqui em baixo percorre a lista de imagens e 'cria ' um botão para cada foto que são os radios. -->
        <?php foreach ($imagens as $i => $img): ?>
            <input type="radio" name="carrossel-control" id="radio-<?php echo $i; ?>"
                <?php echo $i === 0 ? 'checked' : ''; //aqui usa o operador ternário adiciona o atributo checked apenas no primeiro botão, garantindo que a primeira imagem já venha selecionada assim que a página carrega. O ternário pergunta se a variável i é igual a zero, se isso for verdadeiro ele retorna checked senão ele não retorna nada. ?>>
        <?php endforeach; ?>

        <!-- Aqui estou criando uma div-->
        <div class="carrossel-track"> <!-- Esse carrossel-track é como uma esteira, com ajuda do css as imagens ficam posicionadas lado a lado horizontalmente -->
            <?php foreach ($imagens as $i => $img): ?> <!--O foreach está criando uma div que é a carrossel-item contendo uma tag <img> para cada imagem presente na lista $imagens. O php le a lista de fotos e quando acha a primeira atribui 0 a ela e guarda o endereço na variável img. Assim ele faz por todas as imagens. Esse => é algo como "Para cada item da lista, pegue na posição (chave) => e associe ao seu conteúdo (valor)." -->
                
                <div class="carrossel-item">
                    <img src="<?php echo $img; ?>">
                </div>
            <?php endforeach; ?>
        </div>

            <!-- Aqui são as bolinhas: -->
        <div class="carrossel-nav">
            <?php foreach ($imagens as $i => $img): ?> <!-- O foreach cria um label vazio para cada foto. No css esse label é formatado e transformado em bolinhas de navegação. O primeiro <label> ganha for="radio-0". o segundo = 1 e assim por diante.-->
                <label for="radio-<?php echo $i; ?>"></label>
            <?php endforeach; ?>
        </div>

    </div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>