<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';


$db = new db('pedidos');

//DELETE

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    // Executa a exclusão de forma segura utilizando o db.class
    if ($db->delete($id)) {
        header("Location: PostList.php?sucesso=" . urlencode("Pedido removido com sucesso!"));
        exit;
    } else {
        die("Erro ao tentar excluir o pedido de ID: " . $id);
    }
}


//READ

$busca = $_GET['busca'] ?? '';
$pedidos = $db->all();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Pedidos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<header>
    <button class="btn btn-primary position-fixed" style="left: 20px; top: 50%; transform: translateY(-50%); z-index: 1030;" onclick="history.back()">
        &larr; Voltar
    </button>
</header>

<div class="container mt-4" style="max-width: 900px;">
    <h2>Pedidos</h2>

    <form action="PostList.php" method="GET" class="d-flex my-3">
        <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" class="form-control me-2" placeholder="Buscar por nome do café...">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <a href="PostForm.php" class="btn btn-success mb-3">Novo Pedido</a>

    <?php if (!empty($_GET['sucesso'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="alerta-sucesso">
            <strong>✓ Sucesso!</strong> <?= htmlspecialchars($_GET['sucesso']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive bg-white p-3 border rounded shadow-sm">
        <table class="table table-striped table-bordered align-middle m-0">
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
                <?php 
                $encontrou = false; 
                foreach ($pedidos as $p): 
                    // Se houver busca e o termo não for encontrado no nome do café, pula para o próximo
                    if (!empty($busca) && stripos($p->nome_cafe, $busca) === false) {
                        continue; 
                    }
                    $encontrou = true;
                ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const alerta = document.getElementById('alerta-sucesso');
    if (alerta) {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alerta);
            if (bsAlert) bsAlert.close();
        }, 5000);
    }
</script>

</body>
</html>