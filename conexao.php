<?php
// Arquivo: conexao.php

$servername = "localhost"; // Geralmente 'localhost' para desenvolvimento
$username = "root";        // Seu usuário do MySQL
$password = "";            // Sua senha do MySQL (em branco se não houver)
$dbname = "nome_do_seu_banco"; // O nome do banco de dados que você vai criar

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
// Opcional: define o charset para evitar problemas com acentuação
$conn->set_charset("utf8");
// echo "Conexão bem-sucedida!"; // Apenas para teste, remova em produção
?>