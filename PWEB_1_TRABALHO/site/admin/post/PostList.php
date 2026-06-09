<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';
$db = new db('pedidos');

// ==========================================
// MÉTODO EXCLUIR (IGUAL AO AVALIACAOlist.PHP)
// ==========================================
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $host = "localhost";
    $banco = "cafeteria";
    $usuario = "root";
    $senha = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $id = (int) $_GET['id'];
        
        // Executa a exclusão na tabela correta (pedidos)
        $stmtDelete = $pdo->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmtDelete->execute([$id]);
        
        // Redireciona de volta com uma mensagem de sucesso
        header("Location: PostList.php?sucesso=" . urlencode("Pedido removido com sucesso!"));
        exit;
    } catch (PDOException $e) {
        die("Erro ao excluir pedido: " . $e->getMessage());
    }
}

// READ (Busca os dados atualizados para listar)
$busca = $_GET['busca'] ?? '';
$pedidos = $db->all();
?>

<div class="container mt-4">
    <h2>Pedidos</h2>

    <form action="PostList.php" method="GET" class="d-flex my-3">
        <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" class="form-control me-2" placeholder="Buscar por nome do café...">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <a href="PostForm.php" class="btn btn-primary mb-3">Novo Pedido</a>

    <?php if (!empty($_GET['sucesso'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['sucesso']) ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive bg-white p-3 border rounded shadow-sm">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nº Pedido</th>
                    <th>Nome do Café</th>
                    <th>Valor Total</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $encontrou = false; ?>
                <?php foreach ($pedidos as $p): ?>
                    <?php if (!empty($busca) && stripos($p->nome_cafe, $busca) === false) continue; ?>
                    <?php $encontrou = true; ?>
                    <tr>
                        <td><?= $p->id ?></td>
                        <td><?= $p->numero_pedido ?></td>
                        <td><?= htmlspecialchars($p->nome_cafe) ?></td>
                        <td>R$ <?= number_format($p->valor_total, 2, ',', '.') ?></td>
                        <td class="text-center">
                            <a href="PostForm.php?editar=<?= $p->id ?>" class="btn btn-sm btn-warning">Editar</a>
                            
                            <a href="PostList.php?action=delete&id=<?= $p->id ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Excluir este pedido definitivamente?')">
                               Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
                <?php if (!$encontrou): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Nenhum pedido encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php //include '../footer.php'; ?>