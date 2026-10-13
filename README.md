# 🌸 Pétalas, Açúcar e Receitas

## 1. Sobre o projeto

O **Pétalas, Açúcar e Receitas** é um sistema web desenvolvido para o gerenciamento de receitas. O usuário pode criar uma conta, fazer login, adicionar, consultar, pesquisar, editar e excluir receitas, além de atualizar as informações do perfil.

### Tecnologias utilizadas

* PHP
* HTML
* CSS
* PostgreSQL
* PDO para conexão com o banco de dados

## 2. Pré-requisitos

Antes de executar o projeto, certifique que os seguintes programas estão instalados:

* PHP: https://www.php.net/downloads
* PostgreSQL: https://www.postgresql.org/download/
* Git: https://git-scm.com/downloads

Após instalar o PHP e o Git, abra o terminal e execute os comandos abaixo para verificar se estão funcionando:

```bash
php -v
git --version
```

Para verificar a instalação do PostgreSQL, execute:

```bash
psql --version
```

Caso algum comando não seja reconhecido, verifique se o programa foi instalado corretamente e se está configurado no PATH do sistema.

Também é necessário que a extensão `pdo_pgsql` esteja habilitada no PHP, pois ela permite a conexão com o PostgreSQL.

Para verificar as extensões habilitadas, execute:

```bash
php -m
```

Procure por `pdo_pgsql` na lista apresentada.

## 3. Como acessar e executar o projeto

### 3.1. Clonar o repositório

1. Abra o Visual Studio Code.
2. Abra o terminal na pasta em que deseja salvar o projeto.
3. Execute o comando abaixo para baixar os arquivos do GitHub:

```bash
git clone https://github.com/nicolicarvvalho/petalasacucarereceitas.git
```

4. Entre na pasta do projeto:

```bash
cd petalasacucarereceitas
```


### 3.2. Instalar e configurar o PostgreSQL

Caso ainda não esteja instalado, acesse o site oficial:

https://www.postgresql.org/download/

Selecione o sistema operacional e siga as instruções de instalação. Durante o processo, defina uma senha para o usuário administrador `postgres` e guarde-a em um local seguro.

### 3.3. Criar o banco de dados

Abra o terminal e execute:

```bash
psql -U administrador -c "CREATE DATABASE petalas;"
```

Esse comando cria o banco de dados.
Se o banco já existir, utilize o banco existente em vez de executar novamente o comando.

### 3.4. Importar o dump do banco de dados

O dump facilita a preparação do banco sem precisar criar manualmente cada tabela. Execute:

```bash
psql -U administrador -d petalas -f database/dump_petalas.sql
```

Digite a senha do PostgreSQL quando precisar.


### 3.5. Criar e configurar o arquivo `config.php`

O arquivo `config.php` contém as informações necessárias para conectar o PHP ao banco de dados PostgreSQL. Como esse arquivo não está disponível no repositório, crie manualmente:

1. Abra a pasta principal do projeto no Visual Studio Code.
2. Crie um novo arquivo chamado `config.php`.
3. Copie o código abaixo e cole no arquivo:

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'petalas');
define('DB_USER', 'administrador');
define('DB_PASS', 'sua_senha');
```

4. Substitua `sua_senha` pela senha definida durante a instalação do PostgreSQL.
5. Salve o arquivo.

As configurações devem corresponder ao PostgreSQL instalado no computador. Se você utilizou uma porta, um usuário ou um nome de banco diferentes, ajuste os valores conforme necessário.


### 3.6. Executar a aplicação

Na pasta principal do projeto, execute:

```bash
php -S localhost:8000
```


### 3.7. Acessar pelo navegador

Com o servidor em execução, abra o navegador e acesse:

http://localhost:8000/index.php

Se a página não abrir, confira se o servidor foi iniciado na pasta correta, se o PHP está funcionando e se o caminho corresponde ao arquivo inicial do projeto.

## 4. Como testar o sistema

Após acessar a aplicação, realize os seguintes testes:

1. Criar uma conta de usuário.
2. Entrar com os dados cadastrados.
3. Adicionar uma receita.
4. Consultar e pesquisar receitas.
5. Editar uma receita.
6. Atualizar as informações do perfil.
7. Excluir uma receita.
8. Sair da conta e verificar o redirecionamento para a tela de login.

## 5. Observações

* O PostgreSQL precisa estar em execução para que o sistema acesse o banco de dados.
* A conexão configurada em `config.php` deve corresponder aos dados do banco instalado.
