<?php 
require_once __DIR__ . '/../database/connect.php';

function cadastrar($conexao, $usuario_id, $categoria, $nome, $ingredientes, $modo_preparo, $tempo_preparo, $imagem, $dificuldade){
  
        $sql = "INSERT INTO receitas (usuario_id, categoria, nome, ingredientes, modo_preparo, tempo_preparo, imagem, dificuldade) VALUES (:usuario_id, :categoria, :nome, :ingredientes, :modo_preparo, :tempo_preparo, :imagem, :dificuldade)";

        try {
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":usuario_id", $usuario_id);
            $stmt->bindParam(":categoria", $categoria);
            $stmt->bindParam(":nome",  $nome);
            $stmt->bindParam(":ingredientes",  $ingredientes);
            $stmt->bindParam(":modo_preparo",  $modo_preparo);
            $stmt->bindParam(":tempo_preparo", $tempo_preparo);
            $stmt->bindParam(":imagem", $imagem);
            $stmt->bindParam(":dificuldade", $dificuldade);


            $stmt->execute();
            echo "Receita inserida com sucesso!";
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
}

function relatorio($conexao) {
        $sql = "SELECT * FROM receitas ORDER BY nome";

         try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        // 1. Guarda todos os resultados na variável $lista_receitas
        $lista_receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. O foreach passa por cada "receita" individual da "lista_receitas"
        foreach ($lista_receitas as $receita) {
            echo "id: {$receita['id']}<br>";
            echo "nome: {$receita['nome']}<br>";
            echo "categoria: {$receita['categoria']}<br>";
            echo "ingredientes: {$receita['ingredientes']}<br>";
            echo "modo de preparo: {$receita['modo_preparo']}<br>";
            echo "tempo de preparo: {$receita['tempo_preparo']}<br>";
            echo "dificuldade: {$receita['dificuldade']}<br>";
            echo "usuario_id: {$receita['usuario_id']}<br>";
            echo "<hr>";
        }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
}

function apagar($conexao, $nome){
    $sql = "DELETE FROM receitas WHERE nome = :nome";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->execute();
        echo "Receita removida com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    }
    

function consultar($conexao, $nome_busca) {

    $sql = "SELECT * FROM receitas WHERE nome LIKE :nome"; // LIKE serve para buscar textos por aproximação

    try {
        $stmt = $conexao->prepare($sql);
        
        $stmt->execute([':nome' => "%" . $nome_busca . "%"]); // % fica antes e depois do que foi buscado, é como se ele perguntasse ao banco "ache tudo que tenha nome_busca"

        $lista_receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Mostra os resultados na tela
        foreach ($lista_receitas as $receita) {
            echo "nome: {$receita['nome']} - categoria: {$receita['categoria']}<br>";
        }

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

    

function atualizar($conexao, $usuario_id, $categoria, $nome, $ingredientes, $modo_preparo, $tempo_preparo, $imagem, $dificuldade){
  
        $sql = "INSERT INTO receitas (usuario_id, categoria, nome, ingredientes, modo_preparo, tempo_preparo, imagem, dificuldade) VALUES (:usuario_id, :categoria, :nome, :ingredientes, :modo_preparo, :tempo_preparo, :imagem, :dificuldade)";

        try {
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":usuario_id", $usuario_id);
            $stmt->bindParam(":categoria", $categoria);
            $stmt->bindParam(":nome",  $nome);
            $stmt->bindParam(":ingredientes",  $ingredientes);
            $stmt->bindParam(":modo_preparo",  $modo_preparo);
            $stmt->bindParam(":tempo_preparo", $tempo_preparo);
            $stmt->bindParam(":imagem", $imagem);
            $stmt->bindParam(":dificuldade", $dificuldade);


            $stmt->execute();
            echo "Receita atualizada com sucesso!";
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
}

//Funções para login:

function cadastra_user($conexao, $email, $senha){


        $sql = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";

        try {
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":email",  $email);
            $stmt->bindParam(":senha",  $senha);

            $stmt->execute();
            echo "Usuário cadastrado com sucesso!";
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
}

function consulta_user($conexao, $email){

$sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";

try{
$stmt = $conexao->prepare($sql);
$stmt->bindParam(":email", $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
return $usuario;
} catch (PDOException $e) {
    echo "Erro: ". $e->getMessage();
}
}
?>