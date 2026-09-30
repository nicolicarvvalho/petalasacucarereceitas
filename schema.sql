
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);


CREATE TABLE IF NOT EXISTS receitas (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL,
    categoria VARCHAR(20) NOT NULL, 
    nome VARCHAR(150) NOT NULL,
    ingredientes TEXT NOT NULL,
    modo_preparo TEXT NOT NULL,
    tempo_preparo VARCHAR(50),
    imagem TEXT,
    diiculdade VARCHAR(50),
    
    CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);