---
Banco de Dados Pétalas
---
erDiagram

    USUARIOS {
        INTEGER id PK
        VARCHAR email
        VARCHAR senha
        TEXT fotoperfil
    }

    RECEITAS {
        INTEGER id PK
        INTEGER usuario_id
        VARCHAR categoria
        VARCHAR nome
        TEXT ingredientes
        TEXT modo_preparo
        VARCHAR tempo_preparo
        VARCHAR diiculdade
        TEXT imagem
    }

    USUARIOS ||--o{ RECEITAS : "possuem"