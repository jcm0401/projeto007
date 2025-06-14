<?php
// Arquivo: cadastrar_cliente.php
include 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Prepara a consulta SQL para inserção
    $stmt = $conn->prepare("INSERT INTO cliente (nome, email, telefone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $telefone); // "sss" indica que são 3 strings

    // Executa a consulta
    if ($stmt->execute()) {
        $mensagem = "Cliente cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar cliente: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"] { width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .mensagem { margin-top: 15px; padding: 10px; border-radius: 4px; }
        .sucesso { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .erro { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .voltar { background-color: #007bff; margin-left: 10px;}
        .voltar:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Novo Cliente</h2>
        <?php if (!empty($mensagem)): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
        <form action="cadastrar_cliente.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone">

            <button type="submit">Salvar Cliente</button>
            <button type="button" class="voltar" onclick="window.location.href='index.html'">Voltar ao Menu</button>
        </form>
    </div>
</body>
</html>