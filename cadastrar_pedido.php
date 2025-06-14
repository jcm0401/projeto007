<?php
// Arquivo: cadastrar_pedido.php
include 'conexao.php';

$mensagem = '';

// Lógica para obter a lista de clientes para o dropdown
$clientes_disponiveis = [];
$sql_clientes = "SELECT id, nome FROM cliente ORDER BY nome ASC";
$result_clientes = $conn->query($sql_clientes);
if ($result_clientes->num_rows > 0) {
    while($row = $result_clientes->fetch_assoc()) {
        $clientes_disponiveis[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST['cliente_id'];
    $data = $_POST['data'];
    $valor_total = $_POST['valor_total'];
    $status = $_POST['status'];

    // Validação básica: verificar se o cliente_id existe
    $cliente_existe = false;
    foreach ($clientes_disponiveis as $cli) {
        if ($cli['id'] == $cliente_id) {
            $cliente_existe = true;
            break;
        }
    }

    if (!$cliente_existe) {
        $mensagem = "Erro: Cliente selecionado não é válido.";
    } else {
        $stmt = $conn->prepare("INSERT INTO pedido (cliente_id, data, valor_total, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $cliente_id, $data, $valor_total, $status); // i=int, s=string, d=double

        if ($stmt->execute()) {
            $mensagem = "Pedido cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar pedido: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedido</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-bottom: 5px; }
        input[type="date"], input[type="number"], select { width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; }
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
        <h2>Cadastro de Novo Pedido</h2>
        <?php if (!empty($mensagem)): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
        <form action="cadastrar_pedido.php" method="POST">
            <label for="cliente_id">Cliente:</label>
            <select id="cliente_id" name="cliente_id" required>
                <?php if (count($clientes_disponiveis) > 0): ?>
                    <?php foreach ($clientes_disponiveis as $cliente): ?>
                        <option value="<?php echo htmlspecialchars($cliente['id']); ?>">
                            <?php echo htmlspecialchars($cliente['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Nenhum cliente cadastrado</option>
                <?php endif; ?>
            </select>
            <?php if (count($clientes_disponiveis) == 0): ?>
                <p style="color: red;">É necessário ter clientes cadastrados para criar um pedido. <a href="cadastrar_cliente.php">Cadastrar Cliente</a></p>
            <?php endif; ?>

            <label for="data">Data do Pedido:</label>
            <input type="date" id="data" name="data" value="<?php echo date('Y-m-d'); ?>" required>

            <label for="valor_total">Valor Total:</label>
            <input type="number" step="0.01" id="valor_total" name="valor_total" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pendente">Pendente</option>
                <option value="Processando">Processando</option>
                <option value="Concluido">Concluído</option>
                <option value="Cancelado">Cancelado</option>
            </select>

            <button type="submit" <?php echo (count($clientes_disponiveis) == 0) ? 'disabled' : ''; ?>>Salvar Pedido</button>
            <button type="button" class="voltar" onclick="window.location.href='index.html'">Voltar ao Menu</button>
        </form>
    </div>
</body>
</html>