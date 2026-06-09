<?php
include __DIR__ . '/../../../../../header.php';
include __DIR__ . '/../../../../admin/database/db.class.php';

$db = new db('avaliacao');

$mensagem = "";
$id = "";
$pedido_id = "";
$produto_id = "";
$nota = "";
$comentario = "";

// CORREÇÃO DO READ: Carrega os dados para edição usando o padrão exato dos outros formulários (?editar=ID)
if (!empty($_GET['editar'])) {
    $a = $db->find($_GET['editar']);
    if ($a) {
        $id         = $a->id;
        $pedido_id  = $a->pedido_id;
        $produto_id = $a->produto_id;
        $nota       = $a->nota;
        $comentario = $a->comentario;
    }
}

// Processar envio do formulário (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'] ?? '';
    $pedido_id  = $_POST['pedido_id'] ?? '';
    $produto_id = $_POST['produto_id'] ?? '';
    $nota       = $_POST['nota'] ?? '';
    $comentario = !empty($_POST['comentario']) ? $_POST['comentario'] : null;

    // Validação de campos obrigatórios
    if (empty($pedido_id) || empty($produto_id) || empty($nota)) {
        $mensagem = "<div class='alert alert-danger'>Os campos Código do Pedido, Código do Produto e Nota são obrigatórios!</div>";
    } else {
        // Monta o array indexado com os nomes exatos das colunas do banco
        $dados = [
            'pedido_id'  => $pedido_id,
            'produto_id' => $produto_id,
            'nota'       => $nota,
            'comentario' => $comentario
        ];

        if (empty($id)) {
            // INSERT usando a estrutura do db.class
            $db->store($dados);
            $mensagem = "<div class='alert alert-success'>Avaliação cadastrada com sucesso!</div>";
            
            // Limpa os campos após cadastrar um novo
            $pedido_id = $produto_id = $nota = $comentario = ""; 
        } else {
            // UPDATE usando a estrutura do db.class
            $db->update($id, $dados);
            $mensagem = "<div class='alert alert-success'>Avaliação atualizada com sucesso!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $id ? "Editar Avaliação" : "Nova Avaliação" ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 600px;">
        <h2 class="mb-4"><?= $id ? "Editar Avaliação #$id" : "Nova Avaliação" ?></h2>
        
        <?= $mensagem; ?>
        
        <form action="avaliacaoForm.php" method="POST" class="p-4 border rounded bg-white shadow-sm mt-3">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="mb-3">
                <label class="form-label">Código do Pedido</label>
                <input type="number" class="form-control" name="pedido_id" value="<?= htmlspecialchars($pedido_id) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Código do Produto</label>
                <input type="number" class="form-control" name="produto_id" value="<?= htmlspecialchars($produto_id) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nota</label>
                <select class="form-select" name="nota" required>
                    <option value="">Selecione...</option>
                    <option value="5" <?= $nota == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐</option>
                    <option value="4" <?= $nota == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐</option>
                    <option value="3" <?= $nota == 3 ? 'selected' : '' ?>>⭐⭐⭐</option>
                    <option value="2" <?= $nota == 2 ? 'selected' : '' ?>>⭐⭐</option>
                    <option value="1" <?= $nota == 1 ? 'selected' : '' ?>>⭐</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Comentário</label>
                <textarea class="form-control" name="comentario" rows="4"><?= htmlspecialchars($comentario ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-success">Salvar Avaliação</button>
            <a href="avaliacaoList.php" class="btn btn-secondary">Ver Listagem</a>
        </form>
    </div>
</body>
</html>