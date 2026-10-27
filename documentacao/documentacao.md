# Documentação Técnica — Pétalas, Açúcar e Receitas

## Sumário

1. [Apresentação do sistema](#1-apresentação-do-sistema)
2. [Funcionalidades](#2-funcionalidades)
   - [Levantamento de requisitos](#23-levantamento-de-requisitos)
3. [Estrutura do banco de dados](#3-estrutura-do-banco-de-dados)
4. [Dicionário de dados](#4-dicionário-de-dados)
5. [Operações CRUD](#5-operações-crud)
6. [Organização do código](#6-organização-do-código)
7. [Segurança e validação](#7-segurança-e-validação)
8. [Recursos do projeto](#8-recursos-do-projeto)
9. [Controle de Versões](#9-controle-de-versões)

---

## 1. Apresentação do sistema

O **Pétalas, Açúcar e Receitas** é um sistema web desenvolvido para o gerenciamento de receitas culinárias. O projeto permite que os usuários organizem suas receitas e gerenciem suas informações pessoais por meio de uma interface simples.

O projeto foi desenvolvido utilizando PHP, HTML, CSS e PostgreSQL. A comunicação entre a aplicação e o banco de dados é realizada por meio do PDO (PHP Data Objects).

## 2. Funcionalidades

### 2.1. Gerenciamento de usuários

- Cadastro de novos usuários.
- Login e logout.
- Edição das informações do perfil.
- Atualização de e-mail e senha.
- Alteração da foto de perfil.

### 2.2. Gerenciamento de receitas

- Cadastro de receitas.
- Consulta das receitas cadastradas.
- Pesquisa de receitas pelo nome.
- Atualização das informações de uma receita.
- Exclusão de receitas.
- Armazenamento de informações como nome, categoria, ingredientes, modo de preparo, tempo de preparo, dificuldade e imagem.

### 2.3. Levantamento de requisitos

O levantamento de requisitos identifica as funcionalidades que o sistema deve oferecer, as condições de funcionamento e as regras que orientam seu uso.

#### 2.3.1. Requisitos funcionais (RF)

Os requisitos funcionais descrevem as ações que o sistema deve permitir ao usuário.

- **RF01 — Cadastro de usuários:** permitir que novos usuários criem uma conta.
- **RF02 — Autenticação:** permitir que usuários cadastrados façam login e encerrem sua sessão.
- **RF03 — Gerenciamento do perfil:** permitir a edição das informações pessoais, incluindo e-mail, senha e foto de perfil.
- **RF04 — Cadastro de receitas:** permitir o cadastro de receitas com informações como nome, categoria, ingredientes, modo de preparo, tempo de preparo, dificuldade e imagem.
- **RF05 — Consulta de receitas:** permitir a visualização das receitas cadastradas.
- **RF06 — Pesquisa de receitas:** permitir a pesquisa de receitas pelo nome.
- **RF07 — Atualização de receitas:** permitir a alteração das informações de uma receita cadastrada.
- **RF08 — Exclusão de receitas:** permitir a exclusão de receitas cadastradas.

#### 2.3.2. Requisitos não funcionais (RNF)

Os requisitos não funcionais descrevem características técnicas e condições de funcionamento do sistema.

- **RNF01 — Tecnologia:** o sistema deve ser desenvolvido utilizando PHP, HTML e CSS.
- **RNF02 — Banco de dados:** o sistema deve utilizar PostgreSQL para armazenar os dados.
- **RNF03 — Acesso ao banco de dados:** a comunicação entre PHP e PostgreSQL deve ser realizada por meio do PDO.
- **RNF04 — Usabilidade:** a interface deve organizar as funcionalidades de maneira simples, facilitando a navegação.
- **RNF05 — Configuração:** as configurações locais de conexão com o banco de dados devem ficar no arquivo `config.php`, que não deve ser enviado ao repositório Git.

#### 2.3.3. Regras de negócio (RN)

As regras de negócio estabelecem condições para o funcionamento das funcionalidades do sistema.

- **RN01 — Cadastro de receitas:** as receitas devem possuir as informações necessárias para seu cadastro, conforme os campos obrigatórios definidos no banco de dados.
- **RN02 — Identificação dos usuários:** cada usuário deve possuir um identificador próprio, representado pelo campo `id` da tabela `usuarios`.
- **RN03 — Associação de receitas:** o campo `usuario_id` da tabela `receitas` armazena o identificador do usuário associado à receita.
- **RN04 — Identificação das receitas:** cada receita deve possuir um identificador próprio, representado pelo campo `id` da tabela `receitas`.
- **RN05 — Acesso ao sistema:** as páginas que exigem autenticação devem verificar a sessão do usuário, conforme a implementação do sistema.

## 3. Estrutura do banco de dados

O banco de dados PostgreSQL utilizado no projeto possui duas tabelas principais: `usuarios` e `receitas`.

### 3.1. Tabela `usuarios`

A tabela `usuarios` armazena as informações das contas cadastradas no sistema.

Seus principais campos são:

- `id`: identificador do usuário.
- `email`: endereço de e-mail do usuário.
- `senha`: senha armazenada pelo sistema.
- `fotoperfil`: caminho ou referência da imagem de perfil.

O campo `id` é a chave primária da tabela e identifica cada usuário.

### 3.2. Tabela `receitas`

A tabela `receitas` armazena as informações das receitas cadastradas.

Seus principais campos são:

- `id`: identificador da receita.
- `usuario_id`: identificador do usuário associado à receita.
- `categoria`: categoria da receita, como doce ou salgado.
- `nome`: nome da receita.
- `ingredientes`: ingredientes necessários.
- `modo_preparo`: instruções de preparo.
- `tempo_preparo`: tempo necessário para preparar a receita.
- `diiculdade`: nível de dificuldade da receita.
- `imagem`: caminho ou referência da imagem da receita.

O campo `id` é a chave primária da tabela e identifica cada receita.

### 3.3. Relacionamento entre as tabelas

A coluna `usuario_id`, presente na tabela `receitas`, armazena o identificador do usuário associado a cada receita. Esse identificador corresponde à coluna `id` da tabela `usuarios`.

### 3.4. Integridade dos dados

As chaves primárias (`PRIMARY KEY`) identificam exclusivamente os registros de cada tabela.

Na tabela `usuarios`, a chave primária é `id`. Na tabela `receitas`, a chave primária também é `id`.

O campo `usuario_id` permite associar uma receita ao identificador de um usuário.

Nesse caso, o uso de `INNER JOIN` não é obrigatório para representar essa associação. Ele é um recurso SQL que pode ser utilizado em consultas para recuperar informações relacionadas de duas ou mais tabelas.

## 4. Dicionário de dados

O dicionário de dados apresenta os campos das tabelas, seus tipos e suas características conforme o esquema do banco de dados.

### 4.1. Tabela `usuarios`

| Campo | Tipo de dado | Restrição | Descrição |
|---|---|---|---|
| `id` | INTEGER | PRIMARY KEY | Identificador do usuário |
| `email` | VARCHAR(100) | NOT NULL | E-mail do usuário |
| `senha` | VARCHAR(255) | NOT NULL | Senha armazenada pelo sistema |
| `fotoperfil` | TEXT | Permite NULL | Caminho da foto de perfil |

### 4.2. Tabela `receitas`

| Campo | Tipo de dado | Restrição | Descrição |
|---|---|---|---|
| `id` | INTEGER | PRIMARY KEY | Identificador da receita |
| `usuario_id` | INTEGER | NOT NULL | Identificador do usuário associado à receita |
| `categoria` | VARCHAR(20) | NOT NULL | Categoria da receita |
| `nome` | VARCHAR(150) | NOT NULL | Nome da receita |
| `ingredientes` | TEXT | NOT NULL | Lista de ingredientes |
| `modo_preparo` | TEXT | NOT NULL | Instruções de preparo |
| `tempo_preparo` | VARCHAR(50) | Permite NULL | Tempo de preparo |
| `diiculdade` | VARCHAR(50) | Permite NULL | Dificuldade da receita |
| `imagem` | TEXT | Permite NULL | Caminho ou referência da imagem |

**Observação:** o nome do campo `diiculdade` foi mantido conforme definido no banco de dados, garantindo a correspondência entre a documentação e a estrutura implementada.

Os campos `id` das duas tabelas utilizam sequências para gerar identificadores automaticamente, conforme a configuração do banco de dados.

## 5. Operações CRUD

CRUD é a sigla para as quatro operações básicas de manipulação de dados: Create, Read, Update e Delete.

No projeto, essas operações são utilizadas para gerenciar as receitas.

| Operação | Significado | Funcionalidade no projeto |
|---|---|---|
| Create | Criar | Cadastrar uma nova receita |
| Read | Ler/consultar | Consultar e pesquisar receitas |
| Update | Atualizar | Alterar os dados de uma receita |
| Delete | Excluir | Excluir uma receita cadastrada |

As operações são realizadas por meio de páginas PHP e consultas SQL, utilizando a conexão com o banco de dados PostgreSQL.

## 6. Organização do código

O projeto está organizado em pastas para separar as páginas da aplicação, a conexão com o banco de dados, as funcionalidades compartilhadas, as imagens e a documentação.

### 6.1. Estrutura de pastas e arquivos

```text
petalasacucarereceitas/
├── app/
│   ├── create.php
│   ├── delete.php
│   ├── inicio.php
│   ├── receita.php
│   ├── select.php
│   ├── select_w.php
│   └── update.php
├── database/
│   ├── conexao.php
│   └── estrutura.sql
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
├── usuario/
│   ├── editarPerfil.php
│   ├── excluirPerfil.php
│   └── perfil.php
├── .gitignore
├── config.php
├── index.php
└── README.md
```

O arquivo `config.php` contém as configurações locais de conexão com o banco de dados e é mantido fora do versionamento, conforme a configuração do `.gitignore`. Por isso, ele deve ser criado e configurado no ambiente em que o projeto será executado.

### 6.2. Arquivo de conexão com o banco de dados

O arquivo `database/conexao.php` é responsável por estabelecer a comunicação entre a aplicação PHP e o PostgreSQL.

Ele inclui o arquivo `config.php`, obtém as configurações necessárias e cria a conexão utilizando PDO (PHP Data Objects).

O PDO permite executar consultas SQL e tratar possíveis erros durante a comunicação com o banco de dados.

### 6.3. Arquivo de funções

O arquivo `includes/functions.php` contém todas as funções utilizadas em diferentes partes do sistema, como operações de cadastro, consulta, pesquisa, atualização e exclusão de dados.

### 6.4. Páginas da aplicação

Os arquivos da pasta `app/` correspondem às páginas relacionadas às operações com receitas e à navegação da aplicação.

A pasta `login/` contém os arquivos relacionados ao cadastro, à autenticação e ao encerramento da sessão dos usuários.

A pasta `usuario/` contém páginas para consulta, edição e exclusão da conta do usuário.

A pasta `includes/` reúne elementos e funções compartilhados entre diferentes páginas, como o cabeçalho e o rodapé.

A pasta `imagens/` armazena os recursos visuais utilizados pelo sistema, como imagens do carrossel, fotos de perfil e imagens das receitas.

## 7. Segurança e validação

O projeto utiliza recursos de PHP e PDO para implementar funcionalidades relacionadas à segurança e ao tratamento dos dados.

- **Autenticação:** a sessão do usuário é utilizada para identificar quem está autenticado e controlar o acesso às páginas restritas.
- **Consultas ao banco de dados:** o PDO é utilizado para realizar a comunicação com o PostgreSQL. Quando as consultas utilizam instruções preparadas e parâmetros, isso ajuda a reduzir o risco de SQL Injection.
- **Validação de dados:** os dados enviados pelos formulários devem ser verificados antes de serem utilizados ou armazenados.
- **Exibição de conteúdo:** a função `htmlspecialchars()`, quando utilizada na saída de dados, ajuda a evitar que conteúdo fornecido pelo usuário seja interpretado como HTML pelo navegador.

## 8. Recursos do projeto

### 8.1. Product Backlog

O Product Backlog reúne as funcionalidades e tarefas planejadas para o desenvolvimento do projeto, permitindo acompanhar as atividades e seu andamento.

Link para o projeto no Linear:

[Product Backlog — Pétalas, Açúcar e Receitas](https://linear.app/projetofinal/project/petalas-acucar-e-receitas-9b657913146c/issues?layout=list&ordering=priority&orderingDirection=desc&grouping=workflowState&subGrouping=none&showCompletedIssues=true)

### 8.2. Protótipo

O protótipo foi desenvolvido no Figma para representar visualmente as telas e a organização da interface do sistema.

Link para o protótipo no Figma:

[Protótipo — Pétalas, Açúcar e Receitas](https://www.figma.com/design/2zER6Y7FDChJ0DUE2YtdKN/P%C3%A9talas--A%C3%A7%C3%BAcar-e-Receitas?node-id=0-1&t=XIWeDhd1oJTaH8Da-1)

### 8.3. Diagrama do banco de dados

O diagrama do banco de dados está disponível no arquivo [`diagrama.md`](diagrama.md), localizado na pasta `documentacao/`.

### 8.4. Script do banco de dados

O script SQL utilizado para estruturar o banco de dados está disponível no arquivo [`estrutura.sql`](../database/estrutura.sql), localizado na pasta `database/`.

## 9. Controle de Versões

| Versão | Data | Alterações realizadas | Autora |
|:---:|:---:|---|:---:|
| 1.0 | 25/09/2026 | Início da documentação e da prototipagem, organização das tarefas e criação do DER. | Nicoli |
| 1.1 | 30/09/2026 | Registro dos requisitos funcionais, requisitos não funcionais e regras de negócio do sistema. | Nicoli |
| 1.2 | 02/10/2026 | Atualização do diagrama do banco de dados e detalhamento dos campos das tabelas. | Nicoli |
| 1.3 | 09/10/2026 | Organização dos arquivos. | Nicoli |
| 1.4 | 14/10/2026 | Finalização das instruções e execução do projeto. | Nicoli |
| 1.5 | 22/10/2026 | Organização do sumário e revisão da documentação técnica. | Nicoli |
| 1.6 | 27/10/2026 | Revisão da documentação técnica e do README. | Nicoli |