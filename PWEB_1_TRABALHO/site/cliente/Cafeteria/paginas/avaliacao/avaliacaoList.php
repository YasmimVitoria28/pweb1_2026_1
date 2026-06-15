<?php
include __DIR__ . '/../../../../../header.php';
include __DIR__ . '/../../../../admin/database/db.class.php';
$db = new db('avaliacao');

// Processar exclusão direta via PDO (idêntico ao ProdutoList)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $host = "localhost";
    $banco = "cafeteria";
    $usuario = "root";
    $senha = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $id = (int) $_GET['id'];
        
        // Executa a exclusão na tabela avaliacao
        $stmtDelete = $pdo->prepare("DELETE FROM avaliacao WHERE id = ?");
        $stmtDelete->execute([$id]);
        
        // Redireciona de volta com mensagem de sucesso
        header("Location: avaliacaoList.php?sucesso=" . urlencode("Avaliação removida com sucesso!"));
        exit;
    } catch (PDOException $e) {
        die("Erro ao excluir avaliação: " . $e->getMessage());
    }
}

// Campo de busca funcional
$busca = $_GET['busca'] ?? '';
$avaliacoes = $db->all();
?>

<body>
<header>
    <button class="btn btn-primary position-fixed" style="left: 20px; top: 50%; transform: translateY(-50%); z-index: 1030;" onclick="history.back()"><!--voltar tela anterior-->
        &larr; Voltar
    </button>
</header>
</body>

<div class="container mt-4">
    <h2>Avaliações de Produtos Cadastradas</h2>
    
    <form action="avaliacaoList.php" method="GET" class="d-flex my-3">
        <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" class="form-control me-2" placeholder="Buscar por comentário...">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <a href="../contato.php" class="btn btn-primary mb-3">Nova Avaliação</a>

    <?php if (!empty($_GET['sucesso'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['sucesso']) ?></div>
    <?php endif; ?>

    <div class="table-responsive bg-white p-3 border rounded shadow-sm">
        <table class="table table-striped table-bordered align-middle">
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
                <?php $encontrou = false; ?>
                <?php foreach ($avaliacoes as $a): ?>
                    <?php 
                    // Filtro inteligente focado no texto do comentário
                    if (!empty($busca) && stripos($a->comentario ?? '', $busca) === false) continue;
                    $encontrou = true;
                    ?>
                    <tr>
                        <td><?= $a->id ?></td>
                        <td><?= $a->pedido_id ?></td>
                        <td><span class="badge bg-secondary">Produto #<?= $a->produto_id ?></span></td>
                        <td><?= str_repeat("⭐", $a->nota) ?></td>
                        <td><?= htmlspecialchars($a->comentario ?? 'Sem comentário') ?></td>
                        <td class="text-center">
                            <a href="avaliacaoForm.php?editar=<?= $a->id ?>" class="btn btn-sm btn-warning">Editar</a>
                            
                            <a href="avaliacaoList.php?action=delete&id=<?= $a->id ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Excluir esta avaliação definitivamente?')">
                               Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (!$encontrou): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Nenhuma avaliação encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

