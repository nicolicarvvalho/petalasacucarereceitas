<?php
require_once __DIR__ . '/../config.php'; // require_once verifica se o arquivo já foi incluído antes. Se já foi, ele não carrega o arquivo de novo.
// carrega as configurações do banco que estão no config.php.

try { //Tente executar esse código. Se acontecer algum erro depois eu resolvo
    // Se DB_PORT não existir, ele assume a porta 5432 automaticamente
    $port = defined('DB_PORT') ? DB_PORT : '5432'; // É tipo um if: se DB_PORT estiver definida, use ela senão use a 5432. Porta 5432 é a padrão

    $dsn = "pgsql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_NAME; //dns ó onde fica as informações que dizem ao PHP onde está o banco e qual banco ele deve acessar. Nessa parte vai guardar os dados que estão no config.php na variável dns. Nesse caso ficaria algo como "pgsql:host=localhost;port=5432;dbname=petalas"
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [ //Criando a conexão pdo, aqui é onde o php se conecta com o banco de dados. PDO é uma ferramenta do PHP usada para trabalhar com bancos de dados. dns é onde está o banco. DB_USER é o usuário do banco e DB_PASS é a senha do banco. Tudo isso fica armazenado na variável pdo.
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Aqui é o tratamento de erros
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Aqui também, ele fala algo como "Se acontecer um erro no banco faça uma exceção
    ]); // aqui acaba a configuração do pdo, se tudo der dado certo o pdo tem uma conexão com o banco de dados
} catch (PDOException $e) { // o erro é pego pelo catch, se algo tiver dado na conexão faça:  o erro fica guardado na variável e
    die("Erro ao conectar ao PostgreSQL: " . $e->getMessage()); // die significa "para a execução do programa" e o e->getMessage()) pega a mensagem do erro usando a variável criada acima
}

?>


