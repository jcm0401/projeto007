-- Cria o banco de dados se ele não existir e o seleciona
CREATE DATABASE IF NOT EXISTS nome_do_seu_banco CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nome_do_seu_banco;

-- Tabela: cliente
CREATE TABLE IF NOT EXISTS cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telefone VARCHAR(20)
);

-- Tabela: pedido
CREATE TABLE IF NOT EXISTS pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    valor_total DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    cliente_id INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id)
        ON DELETE CASCADE -- Se o cliente for deletado, seus pedidos também serão
        ON UPDATE CASCADE -- Se o ID do cliente mudar, o ID aqui também muda
);

-- Inserções de exemplo (Opcional, para testar)
INSERT INTO cliente (nome, email, telefone) VALUES
('Ana Paula', 'ana.paula@email.com', '(47) 99876-1234'),
('Bruno Mendes', 'bruno.mendes@email.com', '(47) 99123-5678');

INSERT INTO pedido (data, valor_total, status, cliente_id) VALUES
('2025-06-01', 250.00, 'Pendente', 1),
('2025-06-05', 120.50, 'Concluído', 1),
('2025-06-06', 500.00, 'Processando', 2);