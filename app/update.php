<?php
require_once __DIR__ . '/../database/conexao.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';

$receita = null;// por enquanto essavariável está vazia
$erro = ''; //essa também está vazia
$sucesso = '';//e essa também

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['pesquisar'])) {// se o usuario estiver logado e fazer uma requisição do método post e tiver feito uma requisição post no campo pesquisar, execute:
    $nome = $_POST['nome'] ?? ''; //guarda na variável post o resultado do ternário: se o nome existir gurde nessa variável, senão deixe vazia
    $usuario_id = $_SESSION['usuario_id'];

    $sql = "SELECT * FROM receitas WHERE LOWER(nome) = LOWER(:nome) AND usuario_id = :usuario_id";// a função lower transforma tudo que é maisuculo em minusculo porque o postgres é case sensitive. Aqui estou falando para o banco selecionar todos os nomes na tabela receitas. O banco pega o nome da receita que está guardado lá na tabela e transforma em minúsculo. A parte depois do igual o banco pega o que o usuário digitou e faz uma comparação "o que está no banco é igual ao que o usuário digitou?"

    //stmt é uma instrução
    $stmt = $pdo->prepare($sql);//aqui está sendo enviado uma instrução para o banco de dodos preparar uma consulta
    $stmt->bindParam(":nome", $nome); // estou pedindo ao php que pegue o valor que estiver dentro da variável $nome e coloque no lugar do espaço reservado :nome
    $stmt->bindParam("usuario_id", $usuario_id);
    $stmt->execute();//execute a busca

    $receita = $stmt->fetch(PDO::FETCH_ASSOC);//aqui o fetch() vai até o banco e pega apenas a primeira linha que encontrou. O PDO::FETCH_ASSOC: É uma configuração que diz ao PHP como ele deve organizar esses dados. Sem ele o php traria os dados bagunçados e duplicados. Com ele, o php transforma aquela linha do banco em um array organizado e guarda na variável receita.

    if (!$receita) { //se não existir a variável receita, fale:
        $erro = "Receita não encontrada.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['atualizar'])) {//se o usuário estiver logqado e fizer uma requisição do tipo post e tiver clicado em atualizar, execute:
    $id = $_POST['id'] ?? ''; // guarde na variavel id, o id da receita
    $usuario_id = $_SESSION['usuario_id'];//aqui guarde nessa variável o id do usuario que iniciou a sessão

    if (empty($_POST['nome']) || empty($_POST['categoria']) || empty($_POST['ingredientes']) || empty($_POST['modo_preparo']) || empty($_POST['tempo']) || empty($_POST['diiculdade'])) {
        $erro = "Preencha todos os campos obrigatórios antes de atualizar a receita.";//se o nome, categoria, ingredientes ou todas as outras coisas que estão aqui em cima estiverem vazias, mostre o erro. Os dois pipes servem para não precisar abrir vários if

        $sql = "SELECT * FROM receitas WHERE id = :id"; //guarde na variavel sql tudo que o banco achou de id na tabela receitas onde o id é o que o usuario escreveu
        $stmt = $pdo->prepare($sql); //prepare a consulta com o comando que eu falei aqui em cima
        $stmt->bindParam(":id", $id); //Quando eu falar para vc executar a busca , pegue o valor que estiver dentro da variavel id e coloque no lugar da etiqueta :id
        $stmt->execute();//execute isso
        $receita = $stmt->fetch(PDO::FETCH_ASSOC);//guarde na variável receita a primeira linha que você encontrou
    }
     else {//senão, guarde nas variáveis abaixo o que o usuario digiou nos formulários que forma enviados do tipo post:
        $categoria = $_POST['categoria'];
        $nome = $_POST['nome'];
        $ingredientes = $_POST['ingredientes'];
        $modo_preparo = $_POST['modo_preparo'];
        $tempo = $_POST['tempo'];
        $unidade = $_POST['unidade'];
        $tempo_preparo = $tempo . ' ' . $unidade; //aqui estou concatenando o tempo com a unidade e guardando na variável tempo_preparo
        $diiculdade = $_POST['diiculdade'];

        $imagem = $_POST['imagem_atual'] ?? '';

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {//se existir alguma imagem anexada e a imagem não estiver com erro, significa que o upload está certo
            $nomeImagem = time() . '_' . basename($_FILES['imagem']['name']);//aqui estou falando que é para guardar na variável nomeImagem o arquivo com o nome e estou pedindo para desconsiderar o caminho que veio com ela.
            $pasta = __DIR__ . '/../imagens/receitas/'; //aqui estou criando uma variável que contem o caminho que vai ficar a imagem que o usuario colocou

            if (!is_dir($pasta)){
                mkdir($pasta, 0777, true);
            }

            $caminhoImagem = $pasta . $nomeImagem; //aqui criei outra variavel que vai ter o caminho da imagem com o nome dela

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
            $imagem = $nomeImagem; // quando o usuario manda uma foto o php pega a foto e coloca em uma pasta temorária, se eu não tirar de lá a foto vai ser excluida. Para isso não acontecer tem que mover o arquivo carregado (move_uploaded_file). esse $_FILES['imagem']['tmp_name'] é o lugar temporário onde a foto está escondida. Estou falando para pegar a imagem que está nesse lugar temporário e colocar na variável que foi criada ali em cima.
            } else {
                $erro = "Não foi possível salvar a nova imagem na pasta. ";
            }
        }
        try { //tente atualizar a tabela receitas onde os campos abaixo foram mudados e o id é igual ao id da receita
            $sql = "UPDATE receitas 
                    SET categoria = :categoria,
                        nome = :nome,
                        ingredientes = :ingredientes,
                        modo_preparo = :modo_preparo,
                        tempo_preparo = :tempo_preparo,
                        imagem = :imagem,
                        diiculdade = :diiculdade
                    WHERE id = :id AND usuario_id = :usuario_id"; 

            $stmt = $pdo->prepare($sql); //prepare a consulta na tabela
            $stmt->bindParam(":categoria", $categoria); //mude os dados que foram alterados aqui e nos outros aqui em baixo
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":ingredientes", $ingredientes);
            $stmt->bindParam(":modo_preparo", $modo_preparo);
            $stmt->bindParam(":tempo_preparo", $tempo_preparo);
            $stmt->bindParam(":imagem", $imagem);
            $stmt->bindParam(":diiculdade", $diiculdade);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":usuario_id", $usuario_id);
            $stmt->execute();//execute isso

            //tratamento de erros:
            //se qualquer linha acima tiver dado algum erro aparece o erro $e que contém a mensagem de erro especificando o tipo de erro
            $sucesso = "Receita atualizada com sucesso!";//gurda a frase nessa variável
        } catch (PDOException $e) {
            $erro = "Erro ao atualizar receita: " . $e->getMessage(); //nessa linha em vez de deixar o PHP travar a página inteira e mostrar aquele erro feio para o usuario do seu site, você captura o erro e o guarda de forma organizada dentro da variável $erro
        }

        // Recarrega os dados atualizados da receita para manter o formulário exibido e preenchido
        $sql = "SELECT * FROM receitas WHERE id = :id";//pegue tudo na tabela receitas onde o id é o id da receita que o usuario digitou
        $stmt = $pdo->prepare($sql);//prepare a consulta
        $stmt->bindParam(":id", $id);//quando eu disser que é para executar pegue o id da receita e guarde na variavel id
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();//execute
        $receita = $stmt->fetch(PDO::FETCH_ASSOC); //guarde na variável receita a primeira linha que você encontrou
    }
}

// Extrai o valor numérico e a unidade do tempo_preparo (ex: "30 minutos")
$tempoNum = '';//essa variável começa vazia
$tempoUnidade = 'minutos'; //se não tiver nada salvo, a variável tornará padrão minutos
if ($receita && !empty($receita['tempo_preparo'])) { //se tiver algo na variável receita e se não tiver vazio o campo tempo_preparo, execute:
    $partesTempo = explode(' ', trim($receita['tempo_preparo'])); // explode corta o texto em pedaços usando o espaço em branco ' ' como tesoura e o trim remove espaços em branco desnecessários no começo ou no fim do texto (exemplo " 45 minutos " em "45 minutos"). 
    //Essa linha ficaria tipo assim : se o texto for "45 minutos", a variável $partesTempo vira um array com duas partes: o índice 0 vira "45" e o índice 1 vira "minutos".
    $tempoNum = $partesTempo[0] ?? ''; //essa variável guarda o resultado do ternário. Se o indice for 0 guarda na variável, senão deixa vazia
    if (isset($partesTempo[1])) { //aqui está verificando se existe uma segunda parte que é o tempo
        $tempoUnidade = strtolower($partesTempo[1]); // a função strtolower transforma a unidade em letras minúsculas. Assim, se no banco estava salvo "Minutos" ou "MINUTOS", o PHP padroniza para "minutos" e salva na variável tempoUndade.

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
            background-color: #fbf5e9;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #d63765;
        }

        .principal {
            max-width: 1000px;
            margin: 55px auto;
            padding: 0 50px 60px;
        }

        .principal h1 {
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
        .dificuldade,
        .foto,
        .tempo-campo {
            display: flex;
            flex-direction: column;
        }

        .campo label,
        .ingredientes label,
        .preparo label,
        .dificuldade>label,
        .foto label,
        .tempo-campo>label {
            font-size: 1.2rem;
            font-weight: bold;
            color: #d63765;
            margin-bottom: 12px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            border: none;
            background-color: #f0e5d2;
            padding: 12px;
            color: #5f4b4b;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            outline: none;
        }

        input[type="text"] {
            height: 42px;
        }

        input[type="number"] {
            width: 100px;
            height: 42px;
        }

        textarea {
            height: 160px;
            resize: none;
        }

        input::placeholder,
        textarea::placeholder {
            color: #8f7c7c;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid #d63765;
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

        .nome-campo {
            grid-column: 1;
        }

        .categoria-campo {
            grid-column: 2;
        }

        .ingredientes {
            grid-column: 1;
        }

        .preparo {
            grid-column: 1;
        }

        .foto {
            grid-column: 2;
            grid-row: 2;
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

        .dificuldade {
            grid-column: 1;
            grid-row: 4;
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
            height: 42px;
        }

        .botoes {
            grid-column: 1 / -1;
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        button,
        input[type="reset"] {
            min-width: 170px;
            height: 45px;
            padding: 8px 25px;
            border: 2px solid #d63765;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
        }

        button {
            background-color: #d63765;
            color: #fbf5e9;
        }

        input[type="reset"] {
            background-color: transparent;
            color: #d63765;
        }

        button:hover,
        input[type="reset"]:hover {
            opacity: 0.8;
        }

        .erro {
            color: #d63765;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .sucesso {
            color: #2e7d32;
            font-weight: bold;
            margin-bottom: 25px;
        }

        @media (max-width: 700px) {
            .principal {
                padding: 0 25px 35px;
            }

            .formulario {
                grid-template-columns: 1fr;
                row-gap: 30px;
            }

            .nome-campo,
            .categoria-campo,
            .ingredientes,
            .preparo,
            .foto,
            .dificuldade,
            .tempo-campo {
                grid-column: 1;
                grid-row: auto;
            }

            .botoes {
                grid-column: 1;
            }
        }

        .foto .aviso-tamanho {
            font-size: 0.95rem;
            font-weight: bold;
            color: #d63765;
            margin-bottom: 8px;
        }

    </style>
</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="principal">

        <h1>Atualizar Receita</h1>

        <?php if ($erro != ''): ?> <!-- Se a variável erro for diferente de vazia, execute: -->
            <p class="erro"><?php echo htmlspecialchars($erro); ?></p> <!-- Exiba a mensagem de erro -->
        <?php endif; ?>

        <?php if ($sucesso != ''): ?> <!-- Se a variavel sucesso for diferente de vazia, execute: --> 
            <p class="sucesso"><?php echo htmlspecialchars($sucesso); ?></p> <!-- Exiba a mensagem de sucesso -->
        <?php endif; ?>

        <?php if ($receita == null): ?> <!-- Se a variável receita estiver vazia, execute: -->

        <!-- Exibe o formulário de pesquisar receita: -->
            <form action="update.php" method="POST">

                <div class="formulario">

                    <div class="campo nome-campo">
                        <label for="nome">Nome da receita:</label>
                        <input type="text" name="nome" id="nome" placeholder="Digite o nome da receita" required>
                    </div>

                    <div class="botoes">
                        <button type="submit" name="pesquisar">Pesquisar</button>
                    </div>

                </div>

            </form>

        <?php else: ?><!-- senão (se a variável tiver dados que o fetch mandou), renderiza esse formulário completo: -->

            <form action="update.php" method="POST" enctype="multipart/form-data"><!-- sem o enctype="multipart/form-data", o navegador não consegue enviar arquivos. Ele é obrigatório para o upload de fotos funcionar.
-->

                <div class="formulario">

                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($receita['id']); ?>"><!-- Esse hidden deixa o id escondido, precisa ter o id pois é com ele que acontece a busca no banco -->
                    <input type="hidden" name="imagem_atual" value="<?php echo htmlspecialchars($receita['imagem'] ?? ''); ?>"> <!-- guarda o nome da foto antiga. Se o usuário decidir não mudar a foto da receita, o PHP usa esse valor para não apagar a imagem que já existia. -->


                    <div class="campo nome-campo"><!-- a mesma coisa acontece aqui -->
                        <label for="nome">Nome da receita:</label>
                        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($receita['nome']); ?>" required> 
                    </div>

                    <div class="campo categoria-campo">
                        <label for="categoria">Categoria:</label>

                        <div class="opcoes">
                            <input type="radio" name="categoria" id="categ1" value="Doce" <?php if (($receita['categoria'] ?? '') == 'Doce') echo 'checked'; ?>>
                            <label for="categ1">Doce</label>

                            <input type="radio" name="categoria" id="categ2" value="Salgado" <?php if (($receita['categoria'] ?? '') == 'Salgado') echo 'checked'; ?>>
                            <label for="categ2">Salgado</label>
                        </div>
                    </div>

                    <div class="ingredientes">
                        <label for="ingredientes">Ingredientes:</label>
                        <textarea id="ingredientes" name="ingredientes" required><?php echo htmlspecialchars($receita['ingredientes']); ?></textarea>
                    </div>

                    <div class="foto">
                        <label for="foto">Adicione uma foto:</label>
                        <span class="aviso-tamanho">Tamanho máximo da imagem: 1 MB</span>
                        <input type="file" id="foto" name="imagem" accept="image/*">
                    </div>

                    <div class="preparo">
                        <label for="modo-preparo">Modo de Preparo:</label>
                        <textarea id="modo-preparo" name="modo_preparo" required><?php echo htmlspecialchars($receita['modo_preparo']); ?></textarea>
                    </div>

                    <div class="dificuldade">
                        <label for="dificuldade">Dificuldade:</label>

                        <div class="opcoes">
                            <input type="radio" id="opcao1" name="diiculdade" value="facil" <?php if (($receita['diiculdade'] ?? '') == 'facil') echo 'checked'; ?>>
                            <label for="facil">Fácil</label>

                            <input type="radio" id="opcao2" name="diiculdade" value="medio" <?php if (($receita['diiculdade'] ?? '') == 'medio') echo 'checked'; ?>>
                            <label for="medio">Médio</label>

                            <input type="radio" id="opcao3" name="diiculdade" value="dificil" <?php if (($receita['diiculdade'] ?? '') == 'dificil') echo 'checked'; ?>>
                            <label for="dificil">Difícil</label>
                        </div>
                    </div>

                    <div class="campo tempo-campo">
                        <label for="tempo">Tempo:</label>

                        <div class="tempo">
                            <input type="number" id="tempo" name="tempo" min="1" value="<?php echo htmlspecialchars($tempoNum); ?>" placeholder="Ex: 30" required>

                            <select name="unidade">
                                <option value="minutos" <?php if ($tempoUnidade == 'minutos') echo 'selected'; ?>>Minutos</option>
                                <option value="horas" <?php if ($tempoUnidade == 'horas') echo 'selected'; ?>>Horas</option>
                            </select>
                        </div>
                    </div>

                    <div class="botoes">
                        <button type="submit" name="atualizar">Atualizar Receita</button>
                        <input type="reset" value="Limpar">
                    </div>

                </div>

            </form>

        <?php endif; ?>
        
    </main>



    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>