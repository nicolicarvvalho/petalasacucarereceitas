# Documentação Técnica — Pétalas, Açúcar e Receitas

## 1. Apresentação do sistema
O **Pétalas, Açúcar e Receitas** é um sistema web desenvolvido para o gerenciamento de receitas culinárias. O projeto permite que os usuários organizem suas receitas e gerenciem suas informações pessoais por meio de uma interface simples.

Esta documentação apresenta a estrutura do banco de dados, o dicionário de dados, as operações CRUD e os aspectos técnicos do funcionamento do sistema.

## 2. Funcionalidades

### 2.1. Gerenciamento de usuários

O sistema possui funcionalidades de cadastro, autenticação e encerramento de sessão. Também permite consultar e editar informações do perfil, incluindo e-mail, senha e foto de perfil.

### 2.2. Gerenciamento de receitas
O sistema permite cadastrar, consultar, pesquisar, atualizar e excluir receitas.

Cada receita contém nome, categoria, ingredientes, modo de preparo, tempo de preparo, dificuldade e pode conter imagem.


## 3. Estrutura do banco de dados
O banco de dados possui duas tabelas principais: `usuarios` e `receitas`.

### 3.1. Tabela `usuarios`
Armazena os dados dos usuários cadastrados, incluindo id, e-mail, senha e foto de perfil.

### 3.2. Tabela `receitas`
Armazena as informações das receitas e o id do usuário responsável pelo cadastro.

### 3.3. Relacionamento entre as tabelas
O relacionamento entre `usuarios` e `receitas` é do tipo **um para muitos (1:N)**. Um usuário pode cadastrar várias receitas, e cada receita está associada a um usuário por meio do campo `usuario_id`.

O campo `id` da tabela `usuarios` é a chave primária, enquanto `usuario_id`, na tabela `receitas`, é a chave estrangeira.

## 4. Dicionário de dados
O dicionário de dados descreve os campos das tabelas, seus tipos e suas finalidades. Os tipos apresentados são indicativos e devem ser conferidos no esquema SQL definitivo.

### 4.1. Tabela `usuarios`

| Campo        | Tipo de dado     | Descrição                                                |
| ------------ | ---------------- | -------------------------------------------------------- |
| `id`         | SERIAL / INTEGER | Identificador de cada usuário. Chave primária.  |
| `email`      | VARCHAR / TEXT   | Armazena o e-mail utilizado pelo usuário.                |
| `senha`      | VARCHAR / TEXT   | Armazena a senha do usuário.                             |
| `fotoperfil` | VARCHAR / TEXT   | Armazena o caminho do arquivo da foto de perfil. |

### 4.2. Tabela `receitas`

| Campo           | Tipo de dado     | Descrição                                                          |
| --------------- | ---------------- | ------------------------------------------------------------------ |
| `id`            | SERIAL / INTEGER | Identificador de cada receita. Chave primária.            |
| `usuario_id`    | INTEGER          | Identifica o usuário associado à receita. Chave estrangeira. |
| `categoria`     | VARCHAR    | Indica a categoria da receita, como doce ou salgado.               |
| `nome`          | VARCHAR    | Armazena o nome da receita.                                        |
| `ingredientes`  | TEXT             | Armazena os ingredientes necessários para o preparo.               |
| `modo_preparo`  | TEXT             | Armazena as instruções de preparo.                                   |
| `tempo_preparo` |  TEXT   | Registra o tempo necessário para preparar a receita.               |
| `imagem`        | TEXT             | Armazena o caminho da imagem.              |
| `diiculdade`    | VARCHAR    | Registra o nível de dificuldade da receita.                        |

**Observação:** o campo `diiculdade` foi mantido para ter consistência com o que está no banco de dados.

## 5. Operações CRUD

O CRUD representa as quatro operações fundamentais para manipulação de dados.

| Operação | Significado | Aplicação |
| -------- | ----------- | -------------------------------------------------------- |
| Create   | Criar       | Cadastrar usuários e receitas.  |
| Read     | Consultar   | Visualizar e pesquisar receitas e informações do perfil. |
| Update   | Atualizar   | Modificar receitas e informações do perfil. |
| Delete   | Excluir     | Remover receitas e contas de usuários. |


## 6. Organização do código

### Estrutura do projeto:

```text
petalasacucarereceitas/
├── .gitignore
├── config.php
├── index.php
├── README.md
├── app/
│   ├── create.php
│   ├── delete.php
│   ├── inicio.php
│   ├── receita.php
│   ├── select.php
│   ├── select_w.php
│   └── update.php
├── database/
|   ├── estrutura.sql
│   └── conexao.php
|
├── documentacao/
│   ├── diagrama.md
│   └── documentacao.md
├── imagens/
│   ├── carrossel/
│   ├── perfil/
│   └── receitas/
├── includes/
│   ├── footer.php
│   ├── functions.php
│   └── header.php
├── login/
│   ├── cadastrar.php
│   ├── entrar.php
│   ├── sair.php
│   └── verificaUser.php
└── usuario/
    ├── editarPerfil.php
    ├── excluirPerfil.php
    └── perfil.php
```

* **`app/`**: páginas responsáveis pelo gerenciamento das receitas.
* **`database/`**: conexão com o banco de dados.
* **`includes/`**: funções reutilizadas pelas páginas.
* **`login/`**: funcionalidades de autenticação.
* **`imagens/`**: imagens utilizadas.
* **`index.php`**: página inicial do sistema.
* **`config.php`**: configurações locais de conexão com o banco de dados.



## 7. Segurança e validação

O sistema deve considerar os seguintes cuidados:

* Verificar a autenticação antes de permitir acesso às páginas restritas.
* Utilizar consultas preparadas para interagir com o banco de dados.
* Validar os dados recebidos dos formulários.
* Aplicar `htmlspecialchars()` na saída de textos fornecidos pelos usuários.


## 8. Recursos do projeto

### Product Backlog
O Product Backlog reúne as funcionalidades, melhorias e tarefas planejadas para o desenvolvimento do projeto.

[Acesse o Product Backlog aqui ](https://linear.app/projetofinal/project/petalas-acucar-e-receitas-9b657913146c/issues?layout=list&ordering=priority&orderingDirection=desc&grouping=workflowState&subGrouping=none&showCompletedIssues=all&showSubIssues=true&showTriageIssues=true)

### Prototipagem
A prototipagem apresenta a estrutura planejada para o sistema, incluindo a organização das páginas, os elementos e a navegação entre as telas.

[Acesse a Prototipagem aqui](https://www.figma.com/design/2zER6Y7FDChJ0DUE2YtdKN/P%C3%A9talas--A%C3%A7%C3%BAcar-e-Receitas?node-id=0-1&t=XIWeDhd1oJTaH8Da-1)