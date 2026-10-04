<?php
require_once '../database/conexao.php';
require_once '../includes/functions.php';
require_once __DIR__ . '/../login/verificaUser.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <h1>Atualizar Receita</h1>

    <form action="create.php" method="POST" enctype="multipart/form-data"> <!-- os dados são salvos no próprio create e são enviado pelo métodos post. A parte 'enctype="multipart/form-data' permite enviar arquivos -->

        <!-- Nome da receita -->
        <label for="nome">Nome da receita: </label>
        <input type="text" name="nome" id="nome" placeholder="Digite o nome da receita">

        <!-- Categoria doce ou salgada (name mudado para categoria) -->
        <label for="categoria">Categoria: </label>
        <input type="radio" name="categoria" id="categ1" value="Doce ">
        <label for="categ1">Doce</label>
        <input type="radio" name="categoria" id="categ2" value="Salgado">
        <label for="categ2">Salgado</label><br>

        <!-- Ingredientes -->
        <label for="ingredientes">Ingredientes: </label><br>
        <textarea id="ingredientes" name="ingredientes" rows="30" cols="30"></textarea><br>

        <!-- Modo de preparo -->
        <label for="modo-preparo">Modo de Preparo: </label><br>
        <textarea id="modo-preparo" name="modo_preparo" rows="30" cols="30"></textarea><br>

        <!-- Dificuldade (name mudado para diiculdade) -->
        <label for="dificuldade">Dificuldade: </label>
        <input type="radio" id="opcao1" name="diiculdade" value="valor1">
        <label for="opcao1">Fácil </label>
        <input type="radio" id="opcao2" name="diiculdade" value="valor2">
        <label for="opcao2">Médio</label>
        <input type="radio" id="opcao3" name="diiculdade" value="valor3">
        <label for="opcao3">Difícil</label>


        <!-- Tempo em minutos ou horas -->

        <label for="tempo">Tempo: </label>
        <input type="number" id="tempo" name="tempo" min="1">
        <select name="unidade">
            <option value="minutos">Minutos</option>
            <option value="horas">Horas</option>
        </select>

        <!-- Lugar de adicionar foto  -->
        <label for="foto">Adicione uma foto:</label>
        <input type="file" id="foto" name="imagem" accept="image/*">


            <br><br>

            <!-- Botão de adicionar receita ou limpar-->
            <button type="submit">Atualizar Receita</button>
            <input type="reset" value="Limpar"> <!-- Quando esse botão é clicado o php recebe os dados -->


        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") { // se o formulário for enviado: faça o cadastro

    // Pega o ID da sessão se existir, se não usa 1
    $usuario_id = $_SESSION['usuario_id'] ?? 1; // criando uma varoável e atribuindo o id 1 para ela. Ele fala quase como 'pegue o usuário e se não tiver nada atribua o id 1"


    $imagem = null; // essa variável não tem nenhum valor, o usuário pode ou não escolher uma imagem

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) { // quando o usuário escolhe uma imagem o php coloca as informações dentro do $_FILES['imagem']. A parte do isset verifica se o upload aconteceu corretamente, ele pergunta se foi enviado e se aconteceu sem erro. Se existe uma imagem e o upload não teve erro faça:

        $nomeImagem = basename($_FILES['imagem']['name']); //Aqui tem uma variável e atribuindo a ela o nome que o usuário deu. O basename() serve para pegar somente o nome do arquivo, sem caminhos extras.

        $pasta = '../imagens/'; //Criando outra variável e dizendo a ela que o lugar onde deve guardar as imagens é o caminho na frente dela

        $caminhoImagem = $pasta . $nomeImagem; //Essa parte tem outra variável que atribui a ela o caminho da imagem. Ficaria algo como  $caminhoImagem = ../imagens/bolo.jpg
         // essa parte salva a imagem:
        move_uploaded_file( // Essa função fala algo como 'pegue o arquivo enviado e mova para o lugar que eu falei'
            $_FILES['imagem']['tmp_name'], // Aqui é o lugar onde o php guardou temporariamente a imagem
            $caminhoImagem // aqui é aonde eu quero que ela fique. É a variável criada a cima
        );

        $imagem = 'imagens/' . $nomeImagem; //Nessa variável é onde fica guardado o caminho final. Ela não tem a imagem, tem apenas o caminho
    }

    cadastrar( $pdo, $usuario_id, $_POST['categoria'],$_POST['nome'], $_POST['ingredientes'], $_POST['modo_preparo'], $_POST['tempo'],$imagem, $_POST['diiculdade']
    );
}
?>

    </form>

    <?php include '../includes/footer.php'?>
</body>

</html>