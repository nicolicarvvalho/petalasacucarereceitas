<?php

require_once __DIR__ . '/../database/conexao.php';


//----------------------------------------------------------------------------------//


function cadastrar($pdo, $usuario_id, $categoria, $nome, $ingredientes, $modo_preparo, $tempo_preparo, $imagem, $diiculdade){


    // Verifica se já existe uma receita com esse nome
    $verifica = $pdo->prepare("SELECT id FROM receitas WHERE LOWER(nome) = LOWER(:nome) AND usuario_id = :usuario_id LIMIT 1");//cria a variavel verifica e nela prepara uma consulta ao banco de dados para procurar na tabela receitas onde o nome é o nome que o usuário digitou, limitando 1 linha retornada
    $verifica->bindParam(":nome", $nome);//quando eu pedir para executar, pegue o valor nome e coloque dentro da variável nome
    $verifica->bindParam(":usuario_id", $usuario_id);
    $verifica->execute();//execute

    if ($verifica->fetch()) {//Se o banco encontrar pelo menos uma linha com o dado ali e cima, o fetch() retorna false: 
        return false;
    }

    $sql = "INSERT INTO receitas (usuario_id, categoria, nome, ingredientes, modo_preparo, tempo_preparo, imagem, diiculdade) 
            VALUES (:usuario_id, :categoria, :nome, :ingredientes, :modo_preparo, :tempo_preparo, :imagem, :diiculdade)"; //fazendo uma instrução: insere dentro de receitas nessas colunas todos esses valores que o usuário digitou

    try { //tente:

        $stmt = $pdo->prepare($sql); //prepare uma conexão com o banco de dados
        $stmt->bindParam(":usuario_id", $usuario_id);// e insira na variável usuario_id o id do usuario que está e cadastrando
        $stmt->bindParam(":categoria", $categoria);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":ingredientes", $ingredientes);
        $stmt->bindParam(":modo_preparo", $modo_preparo);
        $stmt->bindParam(":tempo_preparo", $tempo_preparo);
        $stmt->bindParam(":imagem", $imagem);
        $stmt->bindParam(":diiculdade", $diiculdade);
        $stmt->execute();

        return true; //quando der certo, retorne verdadeiro. O return encerra o código

        //aqui é o tratamento de erro:
    } catch (PDOException $e) { //capture o erro do banco de dados.
    //O PDOException é o tipo de erro específico que o banco de dados gera (uma exceção do PDO). A variável $e é como uma caixa que o PHP cria na hora do erro, guardando todas as informações sobre o que deu errado no banco de dados.
        echo "Erro ao cadastrar receita: " . $e->getMessage();//exibe o erro
        //$e->getMessage(): Abre a caixa ($e) e pega apenas o texto do erro escrito pelo banco de dados
        //encerra o código e retorna false. avisa o sistema que o código falhou:
        return false;
    }
}


//----------------------------------------------------------------------------------//


function verTodas($pdo, $usuario_id, $nome = '') {//da parametros para a função: conexão com o banco, id do usuario e o nome da receita pode estar vazio

    if ($nome != '') {//se o nome da receita for diferente de vazio, execute:  

        $sql = "SELECT * FROM receitas WHERE usuario_id = :usuario_id AND nome ILIKE :nome ORDER BY nome";//  vá ao banco de dados e selecione tudo da tabela receitas onde o id do usuario é aquele que ele está logado e o nome, ignorando se as letras são minusculas ou maiusculas. Depois ordene por nome
    } else { //senão
        // Busca todas as receitas pertencentes ao usuário logado:
        $sql = "SELECT * FROM receitas WHERE usuario_id = :usuario_id ORDER BY nome";//pegue tudo da tabela receitas onde o id do usuario é aquele que está logado, depois ordene pelo nome
    }

    try {//tente:
        $stmt = $pdo->prepare($sql);//prepare uma conexão com o banco utilizando as instruções que falei a cima
        $stmt->bindParam(":usuario_id", $usuario_id);//insira na variável usuario_id o id do usuario

        if ($nome != '') {//se o nome da receita for diferente de vazio, execute:
            $nome_busca = "%" . $nome . "%";//guarda na variável nome_busca o nome da receita entre porcentagens, tipo %bolo%
            $stmt->bindParam(":nome", $nome_busca); //guarde na variável nome_busca o nome digitado pelo usuario
        }
        $stmt->execute();//execute isso a cima

        $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);//guarde na variável receitas, tudo que voce encontrou (fetchAll) e trasnforme cada linha em um array

        if (empty($receitas)) {//se a variável receitas estiver vazia, exiba:
            echo "<p style='color: #d63765;'>Você ainda não cadastrou nenhuma receita.</p>";
            return;//acaba o código
        }


        //isso aqui em baixo é responsável por exibir os cartões de receitas:
        foreach ($receitas as $receita) {//aqui o foreach percorre a lista receitas que o fetchAll mostrou e para cada vez que ele passa por uma receita ele coloca temporariamente na variavel receita. Se o banco achou 10 receitas, o código vai rodar tudo o que está aí dentro 10 vezes, gerando 10 cartões na tela.

            echo "<div class='card-receita'>";//cria o cartão

        $caminhoFisico = __DIR__ . '/../imagens/receitas/' . ($receita['imagem'] ?? '');

            if (!empty($receita['imagem']) && file_exists($caminhoFisico)) {//se a imagem que está dentro da receita não estiver vazia, execute:
                echo "<img src='/petalasacucarereceitas/imagens/receitas/" . htmlspecialchars($receita['imagem']) . "' alt='Imagem da receita'>"; //mostra o caminho da pasta para onde a imagem deve ir
            } else {//senão, se o usuario não tenha enviado nenhuma foto na hora de cadastrar, o else carrega uma imagem padrão do sistema (placeholder.png), deixando o design sempre bonito e uniforme.
                echo "<img src='/petalasacucarereceitas/imagens/placeholder.png' alt='Sem imagem'>";//fala que não tem imagem
            }

            echo "<h2>" . htmlspecialchars($receita['nome']) . "</h2>";//mostra o nome

            echo "<p><strong>Categoria:</strong> "
                . htmlspecialchars($receita['categoria']) //mostra a categoria
                . "</p>";

            echo "<p><strong>Dificuldade:</strong> "
                . htmlspecialchars($receita['diiculdade']) //mostra a dificuldade
                . "</p>";

            echo "<a href='receita.php?id=" . $receita['id'] . "' class='botao-receita'>Ver receita</a>"; //aqui tem um botão que quando o usuário clica em ver receita vai para a página de receitas e especificamente a receita do id que ele clicou

            echo "</div>";
        }

        //tratamento de erros:
    } catch (PDOException $e) { //pegue o erro que o banco falou e mostre somente o necessário
        echo "Erro: " . $e->getMessage();
    }
}


//----------------------------------------------------------------------------------//


function apagar($conexao, $id)//criando a função apagar e dando parametros a ela: conexão com o banco e o id da receita
{ // o usuário não vai ver o id, apenas o sistema

    $sql = "DELETE FROM receitas WHERE id = :id";//delete na tabela receitas onde o id é aquele que o usuario escolheu

    try {//tente

        $stmt = $conexao->prepare($sql);//preparar uma conexão com o banco, fazendo isso que eu acabei de falar
        $stmt->bindParam(":id", $id);//insira na variável id o id da receita que o usuário escolheu
        $stmt->execute();//execute isso
        return true;//se der certo, retorne true

        //tratamento de erros:
    } catch (PDOException $e) {
        echo "Erro ao apagar receita: " . $e->getMessage();
        return false;
    }
}


//----------------------------------------------------------------------------------//



function pesquisar($conexao, $usuario_id, $nome){ //criando a função pesquisar e dando parametros a ela: conexão com o banco e o nome da receita

    $sql = "SELECT id, usuario_id, categoria, nome, ingredientes, tempo_preparo, modo_preparo, imagem, diiculdade FROM receitas WHERE usuario_id = :usuario_id AND nome ILIKE :nome ORDER BY nome"; //selecione na tabela receitas tudo isso onde o nome (pode estar com letras maiusculas e minusculas) é o nome que o usuário digitou

    try {//tente:
        $stmt = $conexao->prepare($sql);//preparar consulta com o banco
        $nome = "%" . $nome . "%";//coloque em volta do nome %
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->bindParam(":nome", $nome);//insira dentro da variável nome o nome que o usuário digitou
        $stmt->execute();//e execute

        $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);//na variável receitas, coloque tudo que o fetchAll encontrou e foi transformado em array

        if (empty($receitas)) {//se a variável receitas estiver vazia, fale:
            echo "<p style='color: #d63765;'>Nenhuma receita encontrada com esse nome.</p>";
            return;//encerre o código
        }

        foreach ($receitas as $receita) {//foreach percorre os arrays que estão na variavel receitas e coloca temporariamente na variavel receita
            echo "<div class='card-receita'>"; //cria um cartão por receita

            $caminhoFisico = __DIR__ . '/../imagens/receitas/' . ($receita['imagem'] ?? ''); //coloca na variavel caminhoFisico o caminho 

            // Verifica se existe imagem cadastrada e se o arquivo  realmente existe na pasta, senão usa a imagem padrão/placeholder:
            if (!empty($receita['imagem']) && file_exists($caminhoFisico)) {//se a receita tiver imagem e o arquivo existir de verdade execute:
                echo "<img src='imagens/receitas/" . htmlspecialchars($receita['imagem']) . "' alt='Imagem de " . htmlspecialchars($receita['nome']) . "'>"; //mostra onde a imagem deve ficar

            } else { //senão
                echo "<img src='imagens/placeholder.png' alt='Imagem não inserida'>"; // mostra a foto padrão quando o usuário não tiver adicionado foto ou o arquivo sumiu da pasta
            }

            //aqui vai mostrar as informações da receita:
            echo "<h2>" . htmlspecialchars($receita['nome']) . "</h2>";

            echo "<p><strong>Categoria:</strong> "
                . htmlspecialchars($receita['categoria'])
                . "</p>";

            echo "<p><strong>Dificuldade:</strong> "
                . htmlspecialchars($receita['diiculdade'])
                . "</p>";

            echo "<a href='receita.php?id=" . $receita['id'] . "' class='botao-receita'>Ver receita</a>";//botão de ver receita que leva o usuário a página da receita que ele clicou

            echo "</div>";
        }

        //tratamento de erros:
    } catch (PDOException $e) {
        echo "Erro ao buscar receitas: " . $e->getMessage();
    }
}


//----------------------------------------------------------------------------------//



//Funções para login:


function cadastraUser($pdo, $email, $senha){//criando a função cadastra user e dando parametros a ela: conexão com o banco, email e senha

    $fotoperfil =  __DIR__ . 'perfil/padrao.png';//nessa variável fica a foto de perfil padrão que todo usuário 'ganha' quando se cadastra no site

    $sql = "INSERT INTO usuarios (email, senha, fotoperfil) VALUES (:email, :senha, :fotoperfil)";//insere dentro da tabela usuários nas colunas de email, senha e foto de perfil os valores que o usuario digitou

    try {//tente

        $stmt = $pdo->prepare($sql);//preparar uma consulta no banco de dados
        $stmt->bindParam(":email", $email);//insira dentro da variavel email, o email que o usuario digitou
        $stmt->bindParam(":senha", $senha);//insira dentro da variavel senha, a senha que o usuario digitou
        $stmt->bindParam(":fotoperfil", $fotoperfil);//insira dentro da variavel fotoperfil, a foto que o usuario escolheu
        $stmt->execute();//execute tudo isso
        return true;//quando der certo retorne true e encerre o código

        //tratamento de erros:
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        return false;
    }
}


//----------------------------------------------------------------------------------//



function consulta_user($pdo, $email) {//criando a função consulta user e dando parametros a ela: conexão com o banco e email 

    $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";//selecione na tabela usuarios nas colunas de id, email e senha onde o email é aquele que o usuário está usando

    try {//tente:
        $stmt = $pdo->prepare($sql);//preparar uma conexão com o banco
        $stmt->bindParam(":email", $email);//insira dentro da variável email aquele que o usuário está
        $stmt->execute();//execute isso
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);//guarde na variavel usuario a primeira linha que encontrou e transforme em um array
        return $usuario;// aqui a função termina e retorna o array que foi criado ali em cima

        //tratamento de erros
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}


//----------------------------------------------------------------------------------//

//Função para o crud do usuário:


function consulta_id($pdo, $usuario_id) {//criando a função consulta id e dando parametros a ela: conexão com o banco e id do usuario 

    $sql = "SELECT id, email, fotoperfil FROM usuarios WHERE id = :id";//selecione na tabela usuairos nas colunas id, email e foto de perfil o id onde o id é aquele que o usuário está usando

    try {//tente:

        $stmt = $pdo->prepare($sql);//prepare uma consulta no banco
        $stmt->bindParam(":id", $usuario_id);//insira na variavel usuario_id o id do usuario
        $stmt->execute();//execute isso
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);//dentro da variável usuario guarde a primeira que foi encontrada e transformada em array
        return $usuario;//retorne esse array

        //tratamento de erros:
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        return false;
    }
}


//----------------------------------------------------------------------------------//


function atualizaEmail($pdo, $usuario_id, $email){ //criando a função atualiza email e dando parametros a ela: conexão com o banco, id do usuario e email


    $sql = "UPDATE usuarios SET email = :email WHERE id = :id";//atualize na tabela usuarios na coluna email o email que o usuario digitar onde o id é o que o usuario está usando

    try {//tente: 

        $stmt = $pdo->prepare($sql);//prepare uma conexão com o banco
        $stmt->bindParam(":email", $email);// insira na variavel email o email que o usuario digitou
        $stmt->bindParam(":id", $usuario_id);//insira na variavel id do usuário o id que o usuario está usando
        $stmt->execute();//execute isso
        return true;//quando der certo encerre o código

        //tratamento de erros: 
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        return false;//retorne que algo deu errado
    }
}


//----------------------------------------------------------------------------------//


function atualizaSenha($pdo, $usuario_id, $senha) { //criando a função atualiza senha e dando parametros a ela: conexão com o banco, id do usuario e senha

    $sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";//atualize na tabela usuarios na coluna senha a senha que o usuario digitar onde o id é o que o usuario está usando

    try {//tente:

        $stmt = $pdo->prepare($sql);//prepare uma conexão com o banco
        $stmt->bindParam(":senha", $senha);//insira dentro da variável senha a senha que o usuário digitou
        $stmt->bindParam(":id", $usuario_id);//insira na variavel id do usuario o id que o usuario está usando
        $stmt->execute();//execute tudo isso
        return true;//quando der certo, encerre o código

        //tratamento de erros: 
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        return false;
    }
}


//----------------------------------------------------------------------------------//


function atualizaFoto($pdo, $usuario_id, $fotoperfil)//criando a função atualiza senha e dando parametros a ela: conexão com o banco, id do usuario e foto de perfil

{

    $sql = "UPDATE usuarios SET fotoperfil = :fotoperfil  WHERE id = :id";//atualize na tabela usuarios na coluna fotoperfil a foto que o usuario colocar onde o id é aquele que ele esta usando

    try {//tente
        $stmt = $pdo->prepare($sql);//preparar uma conexão com o banco
        $stmt->bindParam(":fotoperfil", $fotoperfil);//insira na variavel fotoperfil a foto que o usuario colocar
        $stmt->bindParam(":id", $usuario_id);//insira na variavel usuario id o id que ele está usando
        $stmt->execute();//execute tudo isso
        return true;//quando der certo acabe o código

        //tratamento de erros:
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        return false;
    }
}


//----------------------------------------------------------------------------------//


function excluirUsuario($pdo, $usuario_id) {//criando a função atualiza senha e dando parametros a ela: conexão com o banco e id do usuario 


    $sql = "DELETE FROM usuarios WHERE id = :id";//delete na tabela usuarios onde o id é aquele que o usuario esta usando

    try {//tente:

        $stmt = $pdo->prepare($sql);//prepare a conexão com o banco
        $stmt->bindParam(":id", $usuario_id);//insira na variável id o id que o usuario está usando
        $stmt->execute();//execute isso
        return true;//quando der certo encerre o código

        //tratamento de erros: 
    } catch (PDOException $e) {
        echo "Erro ao excluir usuário: " . $e->getMessage();
        return false;
    }
}