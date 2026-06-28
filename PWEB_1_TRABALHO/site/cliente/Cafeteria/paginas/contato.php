<?php
include __DIR__ . '/../../../../header.php';
include __DIR__ . '/../../../admin/database/db.class.php';

$db = new db('avaliacao');
$actionError = '';
$errors = [];
$id = '';
$produto_id = '';
$nota = '';
$comentario = '';

$lista_produtos = [];
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cafeteria;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT id, nome, categoria, preco_unitario FROM produto ORDER BY categoria, nome");
    $lista_produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $actionError = "Erro ao carregar produtos: " . $e->getMessage();
}

// Carregar dados para edição
if (!empty($_GET['editar'])) {
    $av = $db->find($_GET['editar']);
    if ($av) {
        $id        = $av->id;
        $produto_id = $av->produto_id;
        $nota       = $av->nota;
        $comentario = $av->comentario;
    }
}

if (!empty($_POST)) {
    $id         = $_POST['id'] ?? '';
    $produto_id = $_POST['produto_id'] ?? '';
    $nota       = $_POST['nota'] ?? '';
    $comentario = $_POST['comentario'] ?? '';

    try {
        if (empty($produto_id)) $errors[] = "<li>Selecione um produto.</li>";
        if (empty($nota))       $errors[] = "<li>Selecione uma nota.</li>";

        if (empty($errors)) {
            $dados = [
                'pedido_id'  => 0,
                'produto_id' => (int) $produto_id,
                'nota'       => (int) $nota,
                'comentario' => !empty($comentario) ? $comentario : null,
            ];

            if (empty($_POST['id'])) {
                $db->store($dados);
                $mensagem = "Avaliação cadastrada com sucesso!";
            } else {
                $db->update($_POST['id'], $dados);
                $mensagem = "Avaliação atualizada com sucesso!";
            }

            header("Location: ./avaliacao/avaliacaoList.php?sucesso=" . urlencode($mensagem));
            exit;
        }
    } catch (Exception $e) {
        $actionError = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? "Editar Avaliação" : "Nova Avaliação" ?> - Grão de Ouro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #1f0408; color: #ffffff; font-family: system-ui, -apple-system, sans-serif; margin: 0; display: flex; flex-direction: column; min-height: 100vh; }
        .sidebar { background-color: #2a0810; min-height: 100vh; color: #E8BC73; border-right: 1px solid #D4A35D; }
        .sidebar h5 { color: #d48618; font-weight: bold; }
        .sidebar a { color: #E8BC73; text-decoration: none; transition: all 0.3s ease; }
        .sidebar a:hover { color: #ffffff; background-color: #37070E; }
        .sidebar a.active-coffee { background-color: #D4A35D !important; color: #37070E !important; font-weight: bold; }
        .border-bottom-coffee { border-bottom: 2px solid #d48618 !important; }
        .title-coffee { color: #d48618; }
        .card-status { background-color: #37070E !important; border: 1px solid #C2933C !important; color: #E8BC73; }
        .card-status-header { background-color: #2a0810 !important; color: #d48618; font-weight: bold; border-bottom: 1px solid #C2933C !important; }
        .alert-coffee { background-color: #1f0408 !important; border: 1px solid #D4A35D !important; color: #ffffff; }
        hr { background-color: #D4A35D; opacity: 0.3; }
        .form-coffee { background-color: #2a0810; border: 1px solid #D4A35D; border-radius: 8px; padding: 20px; }
        .form-coffee label { color: #E8BC73; font-weight: 500; }
        .form-coffee .form-control,
        .form-coffee .form-select { background-color: #37070E; border: 1px solid #C2933C; color: #ffffff; }
        .form-coffee .form-control:focus,
        .form-coffee .form-select:focus { background-color: #37070E; border-color: #D4A35D; color: #ffffff; box-shadow: 0 0 0 0.2rem rgba(212, 163, 93, 0.25); }
        .form-coffee .form-select option { background-color: #37070E; }
        .btn-coffee-success { background-color: #D4A35D; border-color: #D4A35D; color: #1f0408; font-weight: bold; }
        .btn-coffee-success:hover { background-color: #C2933C; border-color: #C2933C; color: #1f0408; }
        .btn-coffee-primary { background-color: #37070E; border-color: #D4A35D; color: #D4A35D; }
        .btn-coffee-primary:hover { background-color: #D4A35D; border-color: #D4A35D; color: #1f0408; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <div class="text-center mb-4">
                <h5>Grão de Ouro</h5>
                <span class="badge bg-warning text-dark">Administrador</span>
            </div>
            <hr>
            <ul class="nav flex-column gap-2">
                <li class="nav-item">
                    <a href="../../../admin/post/PostList.php" class="nav-link rounded p-2">
                        <i class="bi bi-file-earmark-post me-2" style="color: #D4A35D;"></i> Pedidos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../../admin/produto/ProdutoList.php" class="nav-link rounded p-2">
                        <i class="bi bi-cup-hot me-2" style="color: #D4A35D;"></i> Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../../admin/usuario/UsuarioList.php" class="nav-link rounded p-2">
                        <i class="bi bi-people me-2" style="color: #D4A35D;"></i> Usuários
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./avaliacao/avaliacaoList.php" class="nav-link active-coffee rounded p-2">
                        <i class="bi bi-star me-2" style="color: #D4A35D;"></i> Avaliações
                    </a>
                </li>
            </ul>
            <hr>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom-coffee">
                <h1 class="h2 title-coffee"><?= $id ? "Editar Avaliação" : "Nova Avaliação" ?></h1>
                <div class="text-light opacity-75">
                    <a href="./avaliacao/avaliacaoList.php" class="btn btn-coffee-primary">
                        <i class="bi bi-arrow-left me-2"></i>Voltar para Listagem
                    </a>
                </div>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-coffee">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <ul class="mb-0"><?php foreach ($errors as $e) echo $e; ?></ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($actionError)): ?>
                <div class="alert alert-danger alert-coffee">
                    <i class="bi bi-exclamation-triangle me-2"></i><?= $actionError ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-8">
                    <div class="form-coffee">
                        <form action="contato.php<?= $id ? '?editar=' . $id : '' ?>" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                            <div class="mb-4">
                                <label for="produto_id" class="form-label">
                                    <i class="bi bi-cup-hot me-2"></i>Produto Avaliado *
                                </label>
                                <select id="produto_id" name="produto_id" class="form-select form-select-lg" required>
                                    <option value="">Escolha um produto do cardápio</option>
                                    <?php foreach ($lista_produtos as $p): ?>
                                        <option value="<?= $p['id'] ?>" <?= $produto_id == $p['id'] ? 'selected' : '' ?>>
                                            [<?= htmlspecialchars($p['categoria']) ?>] — <?= htmlspecialchars($p['nome']) ?>
                                            (R$ <?= number_format($p['preco_unitario'], 2, ',', '.') ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="nota" class="form-label">
                                    <i class="bi bi-star me-2"></i>Nota (1 a 5) *
                                </label>
                                <select id="nota" name="nota" class="form-select form-select-lg" required>
                                    <option value="">Selecione uma nota</option>
                                    <option value="5" <?= $nota == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐ (Excelente)</option>
                                    <option value="4" <?= $nota == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐ (Muito Bom)</option>
                                    <option value="3" <?= $nota == 3 ? 'selected' : '' ?>>⭐⭐⭐ (Bom)</option>
                                    <option value="2" <?= $nota == 2 ? 'selected' : '' ?>>⭐⭐ (Regular)</option>
                                    <option value="1" <?= $nota == 1 ? 'selected' : '' ?>>⭐ (Ruim)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="comentario" class="form-label">
                                    <i class="bi bi-chat-text me-2"></i>Comentário
                                </label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="4"
                                          placeholder="Conte sua experiência..."><?= htmlspecialchars($comentario ?? '') ?></textarea>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-coffee-success btn-lg">
                                    <i class="bi bi-check-lg me-2"></i>
                                    <?= $id ? "Atualizar Avaliação" : "Salvar Avaliação" ?>
                                </button>
                                <a href="./avaliacao/avaliacaoList.php" class="btn btn-coffee-primary btn-lg">
                                    <i class="bi bi-x-lg me-2"></i>Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-status">
                        <div class="card-header card-status-header">
                            <i class="bi bi-info-circle me-2"></i>Informações
                        </div>
                        <div class="card-body">
                            <?php if ($id): ?>
                                <p class="mb-2"><strong>Editando Avaliação #<?= $id ?></strong></p>
                                <p style="color: #E8BC73;">Altere os campos e clique em "Atualizar Avaliação".</p>
                            <?php else: ?>
                                <p class="mb-2"><strong>Nova Avaliação</strong></p>
                                <p style="color: #E8BC73;">Preencha os campos para registrar uma avaliação.</p>
                            <?php endif; ?>
                            <hr>
                            <p class="mb-1"><i class="bi bi-check-circle me-2" style="color: #D4A35D;"></i>Produto e nota são obrigatórios</p>
                            <p class="mb-0"><i class="bi bi-check-circle me-2" style="color: #D4A35D;"></i>Comentário é opcional</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>