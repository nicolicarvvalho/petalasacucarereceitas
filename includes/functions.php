<?php
require_once __DIR__ . '/../database/conexao.php';?>

<?php function cadastrar($pdo, $usuario_id, $categoria, $nome, $ingredientes, $modo_preparo, $tempo_preparo, $imagem, $diiculdade){
  
        $sql = "INSERT INTO receitas (usuario_id, categoria, nome, ingredientes, modo_preparo, tempo_preparo, imagem, diiculdade) VALUES (:usuario_id, :categoria, :nome, :ingredientes, :modo_preparo, :tempo_preparo, :imagem, :diiculdade)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":usuario_id", $usuario_id);
            $stmt->bindParam(":categoria", $categoria);
            $stmt->bindParam(":nome",  $nome);
            $stmt->bindParam(":ingredientes",  $ingredientes);
            $stmt->bindParam(":modo_preparo",  $modo_preparo);
            $stmt->bindParam(":tempo_preparo",  $tempo_preparo);
            $stmt->bindParam(":imagem",  $imagem);
            $stmt->bindParam(":diiculdade",  $diiculdade);

            $stmt->execute();
            echo "Receita inserida com sucesso!";
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
}

///falta ver se está funcionando:

function verTodas($pdo) {
    $sql = "SELECT * FROM receitas ORDER BY nome";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($receitas as $receita) {
            echo "usuario_id: {$receita['usuario_id']}<br>";
            echo "categoria: {$receita['categoria']}<br>";
            echo "nome: {$receita['nome']}<br>";
            echo "ingredientes: {$receita['ingredientes']}<br>";
            echo "modo_preparo: {$receita['modo_preparo']}<br>";
            echo "tempo_preparo: {$receita['tempo_preparo']}<br>";
            echo "imagem: {$receita['imagem']}<br>";
            echo "dificuldade: {$receita['diiculdade']}<br>";
            echo "<hr>";
        }

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function apagar($conexao, $id) { // o usuáiro não vai ver o id, apenas o sistema
    $sql = "DELETE FROM receitas WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Erro ao apagar receita: " . $e->getMessage();
        return false;
    }
}
    

function pesquisar($conexao, $nome){

    $sql = "SELECT usuario_id, categoria, nome, ingredientes, tempo_preparo, modo_preparo, imagem, diiculdade 
            FROM receitas 
            WHERE nome LIKE :nome";

    try{

        $stmt = $conexao->prepare($sql);
        $nome = "%" . $nome . "%"; // nessa parte o php pega a palavra digitada pelo usuário e a coloca entre %. Desse jeito o banco de dados interpreta algo como 'procure %$nome% em qualquer parte do nome'
        $stmt->bindParam(":nome", $nome);
        $stmt->execute();
        $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC); // O fetch all procura em tudo

        foreach ($receitas as $receita) { //Com a ajuda do foreach passa por cada receita
            echo "Usuario_id: {$receita['usuario_id']}<br>";
            echo "Categoria: {$receita['categoria']}<br>";
            echo "Nome: {$receita['nome']}<br>";
            echo "Ingredientes: {$receita['ingredientes']}<br>";
            echo "Tempo: {$receita['tempo_preparo']}<br>";
            echo "Modo de preparo: {$receita['modo_preparo']}<br>";
            echo "Imagem: {$receita['imagem']}<br>";
            echo "Dificuldade: {$receita['diiculdade']}<br>";
            echo "<hr>";
        }

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

    }
}

//Funções para login:

// Esses já estão certos
function cadastraUser($pdo, $email, $senha) {

    $sql = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();

        return true;

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        return false;
    }
}
function consulta_user($pdo, $email){

$sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";

try{
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":email", $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
return $usuario;
} catch (PDOException $e) {
    echo "Erro: ". $e->getMessage();
}
}
?>