CREATE DATABASE IF NOT EXISTS cafeteria;
USE cafeteria;

CREATE TABLE IF NOT EXISTS pedidos (
    id INT(10) NOT NULL AUTO_INCREMENT,
    numero_pedido INT(10) NOT NULL,
    nome_cafe VARCHAR(50) NOT NULL DEFAULT '',
    valor_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS produto (
    id INT(10) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50) NULL DEFAULT NULL,
    preco_unitario DECIMAL(20,6) NULL DEFAULT NULL,
    categoria VARCHAR(50) NULL DEFAULT NULL,
    PRIMARY KEY (id)
);

USE cafeteria;

-- Opção A: Se você puder apagar a tabela e criá-la do zero com a coluna correta:
DROP TABLE IF EXISTS avaliacao;

CREATE TABLE avaliacao (
    id INT(10) NOT NULL AUTO_INCREMENT,
    pedido_id INT(10) NOT NULL,
    produto_id INT(10) NOT NULL, 
    nota INT(1) NOT NULL,
    comentario TEXT NULL DEFAULT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_avaliacao_produto FOREIGN KEY (produto_id) REFERENCES produto(id) 
);

CREATE TABLE IF NOT EXISTS usuario (
    id INT(10) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(800) NOT NULL,
    nivel_acesso VARCHAR(20) NOT NULL DEFAULT 'cliente',
    PRIMARY KEY (id)
);

INSERT INTO usuario (nome, telefone, email, login, senha, nivel_acesso) 
VALUES (
    'Administrador Geral', 
    '49999999999', 
    'admin@email.com', 
    'admin', 
    '$2y$10$fN8X7z9iVb8EwM5vT7YpNeWz7pG3JbK8F9Q7R5C2yXz5v8I9mN1q', /**senha 123*/
    'admin'
);