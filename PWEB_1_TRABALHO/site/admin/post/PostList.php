<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';
$db = new db('pedidos');

$busca = $_GET['busca'] ?? '';
$pedidos = $db->all();
?>

<div class="container mt-4">
    <h2>Pedidos</h2>

    <form action="PostList.php" method="GET" class="d-flex my-3">
        <input type="text" name="busca" value="<?= $busca ?>" class="form-control me-2" placeholder="Buscar por nome do café...">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <a href="PostForm.php" class="btn btn-primary mb-3">Novo Pedido</a>

    <?php if (!empty($_GET['sucesso'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['sucesso']) ?></div>
    <?php endif; ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nº Pedido</th>
                <th>Nome do Café</th>
                <th>Valor Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $p): ?>
                <?php if (!empty($busca) && stripos($p->nome_cafe, $busca) === false) continue; ?>
                <tr>
                    <td><?= $p->id ?></td>
                    <td><?= $p->numero_pedido ?></td>
                    <td><?= $p->nome_cafe ?></td>
                    <td>R$ <?= number_format($p->valor_total, 2, ',', '.') ?></td>
                    <td>
                        <a href="PostForm.php?editar=<?= $p->id ?>" class="btn btn-sm btn-warning">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php //include '../footer.php'; ?>