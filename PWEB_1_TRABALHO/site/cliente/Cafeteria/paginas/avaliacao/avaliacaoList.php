<?php
$host = "localhost";
$banco = "cafeteria";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // READ
    $stmt = $pdo->query("SELECT * FROM avaliacao ORDER BY id DESC");
    $avaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Avaliações</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Avaliações de Produtos Cadastradas</h2>
            <a href="../contato.html" class="btn btn-primary">Nova Avaliação</a>
        </div>

        <?php if (count($avaliacoes) > 0): ?>
            <div class="table-responsive bg-white p-3 border rounded shadow-sm">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Avaliação</th>
                            <th>ID Pedido</th>
                            <th>ID Produto</th>
                            <th>Nota</th>
                            <th>Comentário</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($avaliacoes as $linha): ?>
                            <tr>
                                <td><?= $linha['id'] ?></td>
                                <td><?= $linha['pedido_id'] ?></td>
                                <td><span class="badge bg-secondary">Produto #<?= $linha['produto_id'] ?></span></td>
                                <td><?= str_repeat("⭐", $linha['nota']) ?></td>
                                <td><?= htmlspecialchars($linha['comentario'] ?? 'Sem comentário') ?></td>
                                <td class="text-center">
                                    <a href="avaliacaoForm.php?action=edit&id=<?= $linha['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="avaliacaoForm.php?action=delete&id=<?= $linha['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir esta avaliação definitivamente?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Nenhuma avaliação encontrada no banco de dados.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>