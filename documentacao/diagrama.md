```Mermaid
---
Banco de Dados Pétalas
---
erDiagram

USUARIOS {
    int ID PK
    varchar email
    varchar senha
    text fotoperfil
}

RECEITAS {
    int ID PK
    usuario_id FK
    categoria varchar
    nome varchar
    ingredientes text
    modo_preparo text
    tempo_preparo varchar
    diiculdade varchar
    imagem text
}

 USUARIOS ||--o{ RECEITAS : "possuem"