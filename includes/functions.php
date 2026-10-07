<?php

require_once __DIR__ . '/../database/conexao.php';

function cadastrar($pdo, $usuario_id, $categoria, $nome, $ingredientes, $modo_preparo, $tempo_preparo, $imagem, $diiculdade)

{

    // Verifica se já existe uma receita com esse nome

    $verifica = $pdo->prepare("SELECT id FROM receitas WHERE LOWER(nome) = LOWER(:nome) LIMIT 1");

    $verifica->bindParam(":nome", $nome);

    $verifica->execute();

    if ($verifica->fetch()) {

        return false;

    }

    $sql = "INSERT INTO receitas (usuario_id, categoria, nome, ingredientes, modo_preparo, tempo_preparo, imagem, diiculdade) 
            VALUES (:usuario_id, :categoria, :nome, :ingredientes, :modo_preparo, :tempo_preparo, :imagem, :diiculdade)";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":usuario_id", $usuario_id);

        $stmt->bindParam(":categoria", $categoria);

        $stmt->bindParam(":nome", $nome);

        $stmt->bindParam(":ingredientes", $ingredientes);

        $stmt->bindParam(":modo_preparo", $modo_preparo);

        $stmt->bindParam(":tempo_preparo", $tempo_preparo);

        $stmt->bindParam(":imagem", $imagem);

        $stmt->bindParam(":diiculdade", $diiculdade);

        $stmt->execute();

        return true;

    } catch (PDOException $e) {

        echo "Erro ao cadastrar receita: " . $e->getMessage();

        return false;

    }

}

//falta ver se está funcionando:

function verTodas($pdo, $nome = '') {

    if ($nome != '') {

        $sql = "SELECT * FROM receitas WHERE nome ILIKE :nome ORDER BY nome";

    } else {

        $sql = "SELECT * FROM receitas ORDER BY nome";

    }

    try {

        $stmt = $pdo->prepare($sql);

        if ($nome != '') {

            $nome = "%" . $nome . "%";

            $stmt->bindParam(":nome", $nome);

        }

        $stmt->execute();

        $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($receitas as $receita) {

            echo "<div class='card-receita'>";

            if (!empty($receita['imagem'])) {

                echo "<img src='../imagens/receitas/" . htmlspecialchars($receita['imagem']) . "' alt='Imagem da receita'>";

            }

            echo "<h2>" . htmlspecialchars($receita['nome']) . "</h2>";

            echo "<p><strong>Categoria:</strong> "

                . htmlspecialchars($receita['categoria'])

                . "</p>";

            echo "<p><strong>Dificuldade:</strong> "

                . htmlspecialchars($receita['diiculdade'])

                . "</p>";

            echo "<a href='receita.php?id=" . $receita['id'] . "' class='botao-receita'>Ver receita</a>";

            echo "</div>";

        }

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

    }

}



function apagar($conexao, $id)

{ // o usuáiro não vai ver o id, apenas o sistema

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

function pesquisar($conexao, $nome)

{

    $sql = "SELECT id, usuario_id, categoria, nome, ingredientes, tempo_preparo, modo_preparo, imagem, diiculdade 
            FROM receitas 
            WHERE nome ILIKE :nome
            ORDER BY nome";

    try {

        $stmt = $conexao->prepare($sql);

        $nome = "%" . $nome . "%";

        $stmt->bindParam(":nome", $nome);

        $stmt->execute();

        $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($receitas as $receita) {

            echo "<div class='card-receita'>";

            if (!empty($receita['imagem'])) {

                echo "<img src='../imagens/receitas/" . htmlspecialchars($receita['imagem']) . "' alt='Imagem da receita'>";

            }

            echo "<h2>" . htmlspecialchars($receita['nome']) . "</h2>";

            echo "<p><strong>Categoria:</strong> "

                . htmlspecialchars($receita['categoria'])

                . "</p>";

            echo "<p><strong>Dificuldade:</strong> "

                . htmlspecialchars($receita['diiculdade'])

                . "</p>";

            echo "<a href='receita.php?id=" . $receita['id'] . "' class='botao-receita'>Ver receita</a>";

            echo "</div>";

        }

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

    }

}

//Funções para login:

// Esses já estão certos

function cadastraUser($pdo, $email, $senha)

{

    // O sistema define a foto inicial do usuário

    $fotoperfil = 'perfil/padrao.png';

    $sql = "INSERT INTO usuarios (email, senha, fotoperfil)

            VALUES (:email, :senha, :fotoperfil)";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":email", $email);

        $stmt->bindParam(":senha", $senha);

        $stmt->bindParam(":fotoperfil", $fotoperfil);

        $stmt->execute();

        return true;

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

        return false;

    }

}

function consulta_user($pdo, $email)

{

    $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":email", $email);

        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario;

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

    }

}

//Função para o crud do usuário:

function consulta_id($pdo, $usuario_id)

{

    $sql = "SELECT id, email, fotoperfil

            FROM usuarios

            WHERE id = :id";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $usuario_id);

        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario;

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

        return false;

    }

}

function atualizaEmail($pdo, $usuario_id, $email)

{

    $sql = "UPDATE usuarios

            SET email = :email

            WHERE id = :id";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":email", $email);

        $stmt->bindParam(":id", $usuario_id);

        $stmt->execute();

        return true;

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

        return false;

    }

}

function atualizaSenha($pdo, $usuario_id, $senha)

{

    $sql = "UPDATE usuarios

            SET senha = :senha

            WHERE id = :id";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":senha", $senha);

        $stmt->bindParam(":id", $usuario_id);

        $stmt->execute();

        return true;

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

        return false;

    }

}

function atualizaFoto($pdo, $usuario_id, $fotoperfil)

{

    $sql = "UPDATE usuarios

            SET fotoperfil = :fotoperfil

            WHERE id = :id";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":fotoperfil", $fotoperfil);

        $stmt->bindParam(":id", $usuario_id);

        $stmt->execute();

        return true;

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

        return false;

    }

}

function excluirUsuario($pdo, $usuario_id)

{

    $sql = "DELETE FROM usuarios WHERE id = :id";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $usuario_id);

        $stmt->execute();

        return true;

    } catch (PDOException $e) {

        echo "Erro ao excluir usuário: " . $e->getMessage();

        return false;

    }

}