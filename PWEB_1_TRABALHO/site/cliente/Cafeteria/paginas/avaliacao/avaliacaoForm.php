<?php
include __DIR__ . '/../../../../../header.php';
include __DIR__ . '/../../../../admin/database/db.class.php';

$db = new db('avaliacao');
$actionError = '';
$errors = [];
$id = '';
$pedido_id = '';
$produto_id = '';
$nota = '';
$comentario = '';

$redirect_url = $_POST['redirect'] ?? '../contato.php';

// --- BUSCA SIMPLES DE PEDIDOS E PRODUTOS RELACIONADOS ---
try {
    // Busca as credenciais ou objeto do próprio arquivo db.class.php se disponível, 
    // ou cria uma conexão direta para listar as opções baseadas no nome_cafe
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=cafeteria;charset=utf8mb4", "root", "");
    $stmt = $pdo->query("SELECT p.id AS ped_id, p.numero_pedido, pr.id AS prod_id, pr.nome AS prod_nome 
                         FROM pedidos p 
                         INNER JOIN produto pr ON p.nome_cafe = pr.nome");
    $lista_pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $actionError = "Erro ao carregar lista de pedidos: " . $e->getMessage();
    $lista_pedidos = [];
}
// -------------------------------------------------------

// Carregar dados para edição
if (!empty($_GET['editar'])) {
    $a = $db->find($_GET['editar']);
    if ($a) {
        $id = $a->id;
        $pedido_id = $a->pedido_id;
        $produto_id = $a->produto_id;
        $nota = $a->nota;
        $comentario = $a->comentario;
    }
}

if (!empty($_POST)) {
    $id = $_POST['id'] ?? '';
    
    // Separa o valor combinado do Select (Ex: "3-2" vira pedido_id=3 e produto_id=2)
    $pedido_produto = $_POST['pedido_produto'] ?? '';
    if (!empty($pedido_produto)) {
        list($pedido_id, $produto_id) = explode('-', $pedido_produto);
    }

    $nota = $_POST['nota'] ?? '';
    $comentario = !empty($_POST['comentario']) ? $_POST['comentario'] : null;
    
    try {
        if (empty($pedido_id)) {
            $errors[] = "<li>A seleção do pedido/produto é obrigatória</li>";
        }
        if (empty($nota)) {
            $errors[] = "<li>A nota é obrigatória</li>";
        }

        if (empty($errors)) {
            $dados = [
                'pedido_id' => $pedido_id,
                'produto_id' => $produto_id,
                'nota' => $nota,
                'comentario' => $comentario
            ];

            if (empty($_POST['id'])) {
                $db->store($dados);
                $mensagem = "Avaliação cadastrada com sucesso!";
            } else {
                $db->update($_POST['id'], $dados);
                $mensagem = "Avaliação atualizada com sucesso!";
            }
            
            // Redireciona para a listagem com mensagem de sucesso
            header("Location: avaliacaoList.php?sucesso=" . urlencode($mensagem));
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
        body {
            background-color: #1f0408;
            color: #ffffff;
            font-family: system-ui, -apple-system, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .sidebar {
            background-color: #2a0810;
            min-height: 100vh;
            color: #E8BC73;
            border-right: 1px solid #D4A35D;
        }
        
        .sidebar h5 {
            color: #d48618;
            font-weight: bold;
        }

        .sidebar a {
            color: #E8BC73;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .sidebar a:hover {
            color: #ffffff;
            background-color: #37070E;
        }

        .sidebar a.active-coffee {
            background-color: #D4A35D !important;
            color: #37070E !important;
            font-weight: bold;
        }
        
        .card-admin {
            background-color: #2a0810 !important;
            border: 1px solid #D4A35D !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-admin:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(126, 52, 64, 0.993);
        }

        .card-title-coffee {
            color: #aaaaaa;
        }

        .btn-link-coffee {
            color: #D4A35D;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-link-coffee:hover {
            color: #ffffff;
        }

        .border-bottom-coffee {
            border-bottom: 2px solid #d48618 !important;
            border-bottom: 2px solid #d48618 !important;
        }

        .title-coffee {
            color: #d48618;
        }

        .card-status {
            background-color: #37070E !important;
            border: 1px solid #C2933C !important;
            color: #E8BC73;
        }

        .card-status-header {
            background-color: #2a0810 !important;
            color: #d48618;
            font-weight: bold;
            border-bottom: 1px solid #C2933C !important;
        }

        .alert-coffee {
            background-color: #1f0408 !important;
            border: 1px solid #D4A35D !important;
            color: #ffffff;
        }

        hr {
            background-color: #D4A35D;
            opacity: 0.3;
        }

        .form-coffee {
            background-color: #2a0810;
            border: 1px solid #D4A35D;
            border-radius: 8px;
            padding: 20px;
        }

        .form-coffee label {
            color: #E8BC73;
            font-weight: 500;
        }

        .form-coffee .form-control {
            background-color: #37070E;
            border: 1px solid #C2933C;
            color: #ffffff;
        }

        .form-coffee .form-control:focus {
            background-color: #37070E;
            border-color: #D4A35D;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(212, 163, 93, 0.25);
        }

        .form-coffee .form-select {
            background-color: #37070E;
            border: 1px solid #C2933C;
            color: #ffffff;
        }

        .form-coffee .form-select:focus {
            background-color: #37070E;
            border-color: #D4A35D;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(212, 163, 93, 0.25);
        }

        .form-coffee textarea {
            background-color: #37070E;
            border: 1px solid #C2933C;
            color: #ffffff;
        }

        .form-coffee textarea:focus {
            background-color: #37070E;
            border-color: #D4A35D;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(212, 163, 93, 0.25);
        }

        .btn-coffee-success {
            background-color: #D4A35D;
            border-color: #D4A35D;
            color: #1f0408;
            font-weight: bold;
        }

        .btn-coffee-success:hover {
            background-color: #C2933C;
            border-color: #C2933C;
            color: #1f0408;
        }

        .btn-coffee-primary {
            background-color: #37070E;
            border-color: #D4A35D;
            color: #D4A35D;
        }

        .btn-coffee-primary:hover {
            background-color: #D4A35D;
            border-color: #D4A35D;
            color: #1f0408;
        }
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
                    <a href="../../pedido/PostList.php" class="nav-link rounded p-2">
                        <i class="bi bi-file-earmark-post me-2" style="color: #D4A35D;"></i> Pedidos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../produto/ProdutoList.php" class="nav-link rounded p-2">
                        <i class="bi bi-cup-hot me-2" style="color: #D4A35D;"></i> Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../usuario/UsuarioList.php" class="nav-link rounded p-2">
                        <i class="bi bi-people me-2" style="color: #D4A35D;"></i> Usuários
                    </a>
                </li>
                <li class="nav-item">
                    <a href="avaliacaoList.php" class="nav-link active-coffee rounded p-2">
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
                    <a href="avaliacaoList.php" class="btn-coffee-primary btn">
                        <i class="bi bi-arrow-left me-2"></i>Voltar para Listagem
                    </a>
                </div>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-coffee">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <?= $error ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($actionError)): ?>
                <div class="alert alert-danger alert-coffee">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= $actionError ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-8">
                    <div class="form-coffee">
                        <form action="avaliacaoForm.php<?= $id ? '?editar=' . $id : '' ?>" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                            <div class="mb-4">
                                <label for="pedido_produto" class="form-label">
                                    <i class="bi bi-receipt me-2"></i>Selecione o Pedido / Item
                                </label>
                                <select name="pedido_produto" id="pedido_produto" class="form-select form-select-lg" required>
                                    <option value="">Selecione um pedido cadastrado...</option>
                                    <?php foreach ($lista_pedidos as $pedido): ?>
                                        <?php 
                                            $combina_valor = $pedido['ped_id'] . '-' . $pedido['prod_id'];
                                            $selecionado = ($pedido_id == $pedido['ped_id'] && $produto_id == $pedido['prod_id']) ? 'selected' : '';
                                        ?>
                                        <option value="<?= $combina_valor ?>" <?= $selecionado ?>>
                                            Pedido Nº <?= $pedido['numero_pedido'] ?> — <?= htmlspecialchars($pedido['prod_nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="nota" class="form-label">
                                    <i class="bi bi-star me-2"></i>Nota
                                </label>
                                <select name="nota" 
                                        id="nota" 
                                        class="form-select form-select-lg" 
                                        required>
                                    <option value="">Selecione...</option>
                                    <option value="5" <?= ($nota ?? '') == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐</option>
                                    <option value="4" <?= ($nota ?? '') == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐</option>
                                    <option value="3" <?= ($nota ?? '') == 3 ? 'selected' : '' ?>>⭐⭐⭐</option>
                                    <option value="2" <?= ($nota ?? '') == 2 ? 'selected' : '' ?>>⭐⭐</option>
                                    <option value="1" <?= ($nota ?? '') == 1 ? 'selected' : '' ?>>⭐</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="comentario" class="form-label">
                                    <i class="bi bi-chat-text me-2"></i>Comentário
                                </label>
                                <textarea name="comentario" 
                                          id="comentario" 
                                          class="form-control form-control-lg" 
                                          rows="4"
                                          placeholder="Digite seu comentário (opcional)"><?= htmlspecialchars($comentario ?? '') ?></textarea>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-coffee-success btn-lg">
                                    <i class="bi bi-check-lg me-2"></i>
                                    <?= $id ? "Atualizar Avaliação" : "Salvar Avaliação" ?>
                                </button>
                                <a href="avaliacaoList.php" class="btn btn-coffee-primary btn-lg">
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
                                <p class="text-muted" style="color: #E8BC73 !important;">Altere os campos necessários e clique em "Atualizar Avaliação".</p>
                            <?php else: ?>
                                <p class="mb-2"><strong>Nova Avaliação</strong></p>
                                <p class="text-muted" style="color: #E8BC73 !important;">Preencha todos os campos para cadastrar uma nova avaliação no sistema.</p>
                            <?php endif; ?>
                            
                            <hr>
                            
                            <p class="mb-1"><i class="bi bi-check-circle me-2" style="color: #D4A35D;"></i>Campos marcados são obrigatórios</p>
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