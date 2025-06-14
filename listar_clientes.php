<?php
// Arquivo: listar_clientes.php
include 'conexao.php'; // Inclui o arquivo de conexão

$sql = "SELECT id, nome, email, telefone FROM cliente";
$result = $conn->query($sql);

$clientes = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .no-records { text-align: center; color: #555; margin-top: 20px; }
        .add-button { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin-bottom: 15px;}
        .add-button:hover { background-color: #218838; }
        .voltar { background-color: #007bff; margin-left: 10px; padding: 10px 15px; border-radius: 4px; text-decoration: none; color: white;}
        .voltar:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Clientes Cadastrados</h2>
        <a href="cadastrar_cliente.php" class="add-button">+ Novo Cliente</a>
        <a href="index.html" class="voltar">Voltar ao Menu</a>

        <?php if (count($clientes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-records">Nenhum cliente cadastrado ainda.</p>
        <?php endif; ?>
    </div>
</body>
</html>