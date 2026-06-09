<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';
$db = new db('produto');

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
        
        // Executa a exclusão na tabela correta (produto)
        $stmtDelete = $pdo->prepare("DELETE FROM produto WHERE id = ?");
        $stmtDelete->execute([$id]);
        
        // Redireciona de volta com uma mensagem de sucesso
        header("Location: ProdutoList.php?sucesso=" . urlencode("Produto removido com sucesso!"));
        exit;
    } catch (PDOException $e) {
        die("Erro ao excluir produto: " . $e->getMessage());
    }
}

// Campo de busca funcional
$busca = $_GET['busca'] ?? '';
$produtos = $db->all();
?>

<div class="container mt-4">
    <h2>Cardápio de Produtos</h2>
    
    <form action="ProdutoList.php" method="GET" class="d-flex my-3">
        <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" class="form-control me-2" placeholder="Buscar por nome do produto...">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <a href="ProdutosForm.php" class="btn btn-primary mb-3">Novo Produto</a>

    <?php if (!empty($_GET['sucesso'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['sucesso']) ?></div>
    <?php endif; ?>

    <div class="table-responsive bg-white p-3 border rounded shadow-sm">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço Unitário</th>
                    <th>Categoria</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $encontrou = false; ?>
                <?php foreach ($produtos as $p): ?>
                    <?php 
                    // Filtro simples em PHP caso sua db.class não tenha LIKE integrado ainda
                    if (!empty($busca) && stripos($p->nome, $busca) === false) continue;
                    $encontrou = true;
                    ?>
                    <tr>
                        <td><?= $p->id ?></td>
                        <td><?= htmlspecialchars($p->nome) ?></td>
                        <td>R$ <?= number_format($p->preco_unitario, 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($p->categoria) ?></td>
                        <td class="text-center">
                            <a href="ProdutosForm.php?editar=<?= $p->id ?>" class="btn btn-sm btn-warning">Editar</a>
                            
                            <a href="ProdutoList.php?action=delete&id=<?= $p->id ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Excluir este produto definitivamente?')">
                               Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (!$encontrou): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Nenhum produto encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
//include '../footer.php'; ?>