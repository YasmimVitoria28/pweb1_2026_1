<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';
$db = new db('produto');

// Campo de busca funcional
$busca = $_GET['busca'] ?? '';

if (!empty($busca)) {
    // Se a sua classe possuir um método de filtro específico, use-o aqui.
    // Caso use o padrão ->all(), traremos todos e filtramos no PHP ou via SQL customizado.
    $produtos = $db->all(); // Exemplo base
} else {
    $produtos = $db->all();
}
?>

<div class="container mt-4">
    <h2>Cardápio de Produtos</h2>
    
    <!-- Barra de Busca Funcional -->
    <form 
    n="ProdutoList.php" method="GET" class="d-flex my-3">
        <input type="text" name="busca" value="<?= $busca ?>" class="form-control me-2" placeholder="Buscar por nome do produto...">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <a href="ProdutosForm.php" class="btn btn-primary mb-3">Novo Produto</a>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço Unitário</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $p): ?>
                <?php 
                // Filtro simples em PHP caso sua db.class não tenha LIKE integrado ainda
                if (!empty($busca) && stripos($p->nome, $busca) === false) continue;
                ?>
                <tr>
                    <td><?= $p->id ?></td>
                    <td><?= $p->nome ?></td>
                    <td>R$ <?= number_format($p->preco_unitario, 2, ',', '.') ?></td>
                    <td><?= $p->categoria ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php 
//include '../footer.php'; ?>