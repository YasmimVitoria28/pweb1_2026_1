<?php
$host = "localhost";
$banco = "cafeteria";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'salvar') {
        $id = $_POST['id'] ?? null;
        $pedido_id = $_POST['pedido_id'];
        $produto_id = $_POST['produto_id'];
        $nota = $_POST['nota'];
        $comentario = !empty($_POST['comentario']) ? $_POST['comentario'] : null;

        if (empty($id)) {

try {
    $stmt = $pdo->prepare("INSERT INTO avaliacao (pedido_id, produto_id, nota, comentario) VALUES (?, ?, ?, ?)");
    $stmt->execute([$pedido_id, $produto_id, $nota, $comentario]);
} catch (PDOException $e) {
    // Isso vai exibir na tela o erro exato do banco de dados (ex: Violação de Chave Estrangeira)
    echo "<div class='alert alert-danger m-3'>";
    echo "<strong>Erro no Banco de Dados:</strong> " . $e->getMessage();
    echo "</div>";
    exit; // Para a execução para você conseguir ler o erro
}
        } else {
            // UPDATE
            $stmt = $pdo->prepare("UPDATE avaliacao SET pedido_id = ?, produto_id = ?, nota = ?, comentario = ? WHERE id = ?");
            $stmt->execute([$pedido_id, $produto_id, $nota, $comentario, $id]);
        }
        header("Location: avaliacaoList.php");
        exit;
    }
}

// DELETE
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM avaliacao WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: avaliacaoList.php");
    exit;
}

// READ (Para carregar os dados na tela de edição)
$dadosEdicao = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM avaliacao WHERE id = ?");
        $stmt->execute([$id]);
        $dadosEdicao = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Avaliação</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 600px;">
        <?php if ($dadosEdicao): ?>
            <h2 class="mb-4">Editar Avaliação #<?= $dadosEdicao['id'] ?></h2>
            <form action="avaliacaoForm.php" method="POST" class="p-4 border rounded bg-white shadow-sm">
                <input type="hidden" name="acao" value="salvar">
                <input type="hidden" name="id" value="<?= $dadosEdicao['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Código do Pedido</label>
                    <input type="number" class="form-control" name="pedido_id" value="<?= $dadosEdicao['pedido_id'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Código do Produto</label>
                    <input type="number" class="form-control" name="produto_id" value="<?= $dadosEdicao['produto_id'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nota</label>
                    <select class="form-select" name="nota" required>
                        <option value="5" <?= $dadosEdicao['nota'] == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐</option>
                        <option value="4" <?= $dadosEdicao['nota'] == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐</option>
                        <option value="3" <?= $dadosEdicao['nota'] == 3 ? 'selected' : '' ?>>⭐⭐⭐</option>
                        <option value="2" <?= $dadosEdicao['nota'] == 2 ? 'selected' : '' ?>>⭐⭐</option>
                        <option value="1" <?= $dadosEdicao['nota'] == 1 ? 'selected' : '' ?>>⭐</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Comentário</label>
                    <textarea class="form-control" name="comentario" rows="4"><?= htmlspecialchars($dadosEdicao['comentario'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                <a href="avaliacaoList.php" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <h3>Nenhum registro selecionado para edição.</h3>
                <a href="../contato.html" class="btn btn-primary mt-3">Voltar</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>