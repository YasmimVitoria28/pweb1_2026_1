<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';

$db = new db('produto');
$actionError = '';
$errors = [];
$id = '';
$nome = '';
$preco_unitario = '';
$categoria = '';

if (!empty($_GET['editar'])) {
    $p = $db->find($_GET['editar']);
    if ($p) {
        $id = $p->id;
        $nome = $p->nome;
        $preco_unitario = $p->preco_unitario;
        $categoria = $p->categoria;
    }
}

if (!empty($_POST)) {
    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $preco_unitario = $_POST['preco_unitario'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    
    try {
        if (empty($_POST['nome'])) {
            $errors[] = "<li>O nome do produto é obrigatório</li>";
        }
        if (empty($_POST['preco_unitario'])) {
            $errors[] = "<li>O preço unitário é obrigatório</li>";
        }
        if (empty($_POST['categoria'])) {
            $errors[] = "<li>A categoria é obrigatória</li>";
        }

        if (empty($errors)) {
            $dados = [
                'nome' => $_POST['nome'],
                'preco_unitario' => $_POST['preco_unitario'],
                'categoria' => $_POST['categoria']
            ];

            if (empty($_POST['id'])) {
                $db->store($dados);
                $mensagem = "Produto cadastrado com sucesso!";
            } else {
                $db->update($_POST['id'], $dados);
                $mensagem = "Produto atualizado com sucesso!";
            }
            
            header("Location: ProdutoList.php?sucesso=" . urlencode($mensagem));
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
    <title><?= $id ? "Editar Produto" : "Novo Produto" ?> - Grão de Ouro</title>
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

        .form-coffee .form-control,
        .form-coffee .form-select {
            background-color: #37070E;
            border: 1px solid #C2933C;
            color: #ffffff;
        }

        .form-coffee .form-control:focus,
        .form-coffee .form-select:focus {
            background-color: #37070E;
            border-color: #D4A35D;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(212, 163, 93, 0.25);
        }

        .form-coffee .form-select option {
            background-color: #2a0810;
            color: #ffffff;
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
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <div class="text-center mb-4">
                <h5>Grão de Ouro</h5>
                <span class="badge bg-warning text-dark">Administrador</span>
            </div>
            <hr>
            <ul class="nav flex-column gap-2">
                <li class="nav-item">
                    <a href="../post/PostList.php" class="nav-link rounded p-2">
                        <i class="bi bi-file-earmark-post me-2" style="color: #D4A35D;"></i> Pedidos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="ProdutoList.php" class="nav-link active-coffee rounded p-2">
                        <i class="bi bi-cup-hot me-2" style="color: #D4A35D;"></i> Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../usuario/UsuarioList.php" class="nav-link rounded p-2">
                        <i class="bi bi-people me-2" style="color: #D4A35D;"></i> Usuários
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../cliente/Cafeteria/paginas/avaliacao/avaliacaoList.php" class="nav-link rounded p-2">
                        <i class="bi bi-star me-2" style="color: #D4A35D;"></i> Avaliações
                    </a>
                </li>
            </ul>
            <hr>
        </nav>

        <!-- Conteúdo Principal -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom-coffee">
                <h1 class="h2 title-coffee"><?= $id ? "Editar Produto" : "Novo Produto" ?></h1>
                <div class="text-light opacity-75">
                    <a href="ProdutoList.php" class="btn-coffee-primary btn">
                        <i class="bi bi-arrow-left me-2"></i>Voltar para Listagem
                    </a>
                </div>
            </div>

            <!-- Mensagens de Erro -->
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

            <!-- Formulário -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-coffee">
                        <form action="ProdutosForm.php<?= $id ? '?editar=' . $id : '' ?>" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                            <div class="mb-4">
                                <label for="nome" class="form-label">
                                    <i class="bi bi-cup-hot me-2"></i>Nome do Produto
                                </label>
                                <input type="text" 
                                       name="nome" 
                                       id="nome" 
                                       class="form-control form-control-lg" 
                                       value="<?= htmlspecialchars($nome) ?>" 
                                       placeholder="Ex: Capuccino Italiano"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label for="preco_unitario" class="form-label">
                                    <i class="bi bi-currency-dollar me-2"></i>Preço Unitário (R$)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #37070E; border: 1px solid #C2933C; color: #D4A35D;">R$</span>
                                    <input type="number" 
                                           step="0.001" 
                                           name="preco_unitario" 
                                           id="preco_unitario" 
                                           class="form-control form-control-lg" 
                                           value="<?= htmlspecialchars($preco_unitario) ?>" 
                                           placeholder="0.00"
                                           required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="categoria" class="form-label">
                                    <i class="bi bi-tag me-2"></i>Categoria
                                </label>
                                <select name="categoria" 
                                        id="categoria" 
                                        class="form-select form-select-lg" 
                                        required>
                                    <option value="">Selecione uma categoria...</option>
                                    <option value="Cafés" <?= $categoria === 'Cafés' ? 'selected' : '' ?>>☕ Cafés</option>
                                    <option value="Salgados" <?= $categoria === 'Salgados' ? 'selected' : '' ?>>🥐 Salgados</option>
                                    <option value="Doces e Tortas" <?= $categoria === 'Doces e Tortas' ? 'selected' : '' ?>>🍰 Doces e Tortas</option>
                                </select>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-coffee-success btn-lg">
                                    <i class="bi bi-check-lg me-2"></i>
                                    <?= $id ? "Atualizar Produto" : "Salvar Produto" ?>
                                </button>
                                <a href="ProdutoList.php" class="btn btn-coffee-primary btn-lg">
                                    <i class="bi bi-x-lg me-2"></i>Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Card de Informações -->
                <div class="col-lg-4">
                    <div class="card card-status">
                        <div class="card-header card-status-header">
                            <i class="bi bi-info-circle me-2"></i>Informações
                        </div>
                        <div class="card-body">
                            <?php if ($id): ?>
                                <p class="mb-2"><strong>Editando Produto #<?= $id ?></strong></p>
                                <p class="text-muted" style="color: #E8BC73 !important;">Altere os campos necessários e clique em "Atualizar Produto".</p>
                            <?php else: ?>
                                <p class="mb-2"><strong>Novo Produto</strong></p>
                                <p class="text-muted" style="color: #E8BC73 !important;">Preencha todos os campos para cadastrar um novo produto no cardápio.</p>
                            <?php endif; ?>
                            
                            <hr>
                            
                            <p class="mb-1"><i class="bi bi-check-circle me-2" style="color: #D4A35D;"></i>Todos os campos são obrigatórios</p>
                            <p class="mb-1"><i class="bi bi-check-circle me-2" style="color: #D4A35D;"></i>Preço com até 3 casas decimais</p>
                            <p class="mb-0"><i class="bi bi-check-circle me-2" style="color: #D4A35D;"></i>Escolha a categoria correta</p>
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