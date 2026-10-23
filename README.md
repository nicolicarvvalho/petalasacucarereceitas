<div align="center">
<img width="1200" height="200" alt="logo Pétalas, Açúcar e Receitas" src="https://github.com/user-attachments/assets/792e2c13-d743-480f-99a1-c58dde89911e" />
</div>

# Pétalas, Açúcar e Receitas

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

Se ela não aparecer na lista, abra o arquivo de configuração do PHP (php.ini) e remova o ponto e vírgula `;` do início da linha:

```bash
extension=pdo_pgsql
```

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


### 3.3. Criar usuário e banco de dados

Abra o terminal e execute:

Se estiver usando Linux ou MacOS: 

```bash
sudo -u postgres psql
```

Se estiver usando Windows:

```bash
psql -U postgres
```

Dentro do terminal do Postgres, execute os comandos abaixo para criar o usuário e o banco de dados:

```sql
CREATE USER administrador WITH PASSWORD 'digite_uma_senha';
```

```sql
CREATE DATABASE petalas WITH OWNER administrador;
```

Para sair do terminal do PostgreSQL, digite:

```sql
\q
```

### 3.4. Importar o dump do banco de dados

O dump facilita a preparação do banco sem precisar criar manualmente cada tabela. Se o banco e o usuário já existirem, pule o passo anterior e execute diretamente a importação abaixo.

Abra o terminal e execute:

```bash
psql -U administrador -h 127.0.0.1 -d petalas -f database/estrutura.sql
```

Digite a senha quando for necessário.



### 3.5. Criar e configurar o arquivo `config.php`

O arquivo `config.php` contém as informações necessárias para conectar o PHP ao banco de dados PostgreSQL. Como esse arquivo não está disponível no meu repositório, crie manualmente:

1. Abra a pasta principal do projeto no Visual Studio Code.
2. Crie um arquivo chamado `config.php`.
3. Copie o código abaixo e cole no arquivo:

```php
<?php

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '5432');
define('DB_NAME', 'petalas');
define('DB_USER', 'administrador');
define('DB_PASS', 'sua_senha');

?>
```

4. Substitua `sua_senha` pela senha definida durante o passo 3.3.
5. Salve o arquivo.

As configurações devem corresponder ao PostgreSQL instalado no computador. Se você utilizou uma porta, um usuário ou um nome de banco diferentes, ajuste os valores conforme necessário.


### 3.6. Executar a aplicação

Na pasta principal do projeto, execute:

```bash
php -S localhost:8000
```

Caso as imagens das receitas não sejam exibidas devido a problemas de permissão no servidor Linux, acesse o diretório que contém a pasta principal do projeto e execute o comando abaixo:

```bash
chmod 777 petalasacucarereceitas/imagens/receitas/
```

Esse comando concede permissões de leitura, escrita e execução para todos os usuários na pasta imagens/receitas/, permitindo o acesso aos arquivos armazenados nela.
 
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

## 6. Informações complementares
- [Documentação Técnica](documentacao/documentacao.md)
- [Diagrama de relacionamento](documentacao/diagrama.md)
- [Product Backlog](https://linear.app/projetofinal/project/petalas-acucar-e-receitas-9b657913146c/issues?layout=list&ordering=priority&orderingDirection=desc&grouping=workflowState&subGrouping=none&showCompletedIssues=all&showSubIssues=true&showTriageIssues=true)
- [Prototipagem](https://www.figma.com/design/2zER6Y7FDChJ0DUE2YtdKN/P%C3%A9talas--A%C3%A7%C3%BAcar-e-Receitas?node-id=0-1&t=XIWeDhd1oJTaH8Da-1)

<div align="center">
<img width="1200" height="200" alt="logo Pétalas, Açúcar e Receitas" src="https://github.com/user-attachments/assets/8ba04dbe-5e8b-4fbf-83a2-1abd30f8e678" />
</div>
