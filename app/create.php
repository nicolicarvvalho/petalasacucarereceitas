<?php include_once '../includes/functions.php'?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétalas, Açúcar e Receitas</title>
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Incluindo o header -->

    <h1>Adicionar Receita</h1>

   <form action="" method="post">

<!-- nome da receita -->
    <label for="nome">Nome da receita: </label>
    <input type="text" name="nome" id="nome" placeholder="Digite o nome da receita">

    <!-- Categoria doce ou salgado -->
    <label for="categoria">Categoria: </label>
    <input type="radio" name="categ" id="categ" value="True">
    <label for="categoria">Doce</label>
    <input type="radio" name="categ" id="categ" value="False">
    <label for="categoria">Salgado</label><br>

    <!-- Ingredientes -->
    <label for="ingredientes">Ingredientes: </label><br>
    <textarea id="ingredientes" name="ingredientes" rows="30" cols="30"></textarea><br>

    <!-- Modo de preparo -->
    <label for="modo-preparo">Modo de Preparo: </label><br>
    <textarea id="modo-preparo" name="modo-preparo" rows="30" cols="30"></textarea><br>

    <!-- Dificuldade fácil medio ou difícil -->
    <label for="dificuldade">Dificuldade: </label>
    <input type="radio" id="opcao1" name="opcao" value="valor1">
    <label for="opcao1">Fácil </label>
    <input type="radio" id="opcao2" name="opcao" value="valor2">
    <label for="opcao2">Médio</label>
    <input type="radio" id="opcao3" name="opcao" value="valor3">
    <label for="opcao3">Difícil</label>

<!-- Tempo em minutos ou horas-->
    <label for="tempo">Tempo: </label>
    <input type="number" id="tempo" name="tempo" min="1">
    <select name="unidade">
    <option value="minutos">Minutos</option>
    <option value="horas">Horas</option>

    <!-- Campo de adicionar foto da galeria ou tirar foto-->
    <label for="foto">Adicione uma foto:</label>
    <input type="file" id="foto" name="foto" accept="image/*" capture="user"><br>

    <!-- Botão de enviar receita ou cancelar -->
    <br><input type="submit" value="Adicionar Receita">
    <input type="reset" value="Cancelar">
  
<?php

if($_SERVER['REQUEST_METHOD'] == "POST") {

    cadastrar($pdo, $_POST['usuario_id'], $_POST['categoria'], $_POST['nome'], $_POST['ingredientes'], $_POST['modo_preparo'], $_POST['tempo_preparo'], $_POST['imagem'], $_POST['diiculdade']);
    
    }
    ?>
    
    </main>
    
    <?php include __DIR__ . '/../includes/footer.php'; ?>


</form>

</body>
</html>