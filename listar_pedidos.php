<?php
// Arquivo: listar_pedidos.php
include 'conexao.php'; // Inclui o arquivo de conexão

// Junta as tabelas pedido e cliente para pegar o nome do cliente
$sql = "SELECT p.id, p.data, p.valor_total, p.status, c.nome AS cliente_nome
        FROM pedido p
        JOIN cliente c ON p.cliente_id = c.id
        ORDER BY p.data DESC"; // Ordena pelos pedidos mais recentes

$result = $conn->query($sql);

$pedidos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $pedidos[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 900px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
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
        <h2>Pedidos Registrados</h2>
        <a href="cadastrar_pedido.php" class="add-button">+ Novo Pedido</a>
        <a href="index.html" class="voltar">Voltar ao Menu</a>

        <?php if (count($pedidos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['cliente_nome']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['data']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($pedido['valor_total'], 2, ',', '.')); ?></td>
                            <td><?php echo htmlspecialchars($pedido['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-records">Nenhum pedido cadastrado ainda.</p>
        <?php endif; ?>
    </div>
</body>
</html>