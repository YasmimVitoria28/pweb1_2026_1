<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';

$db = new db('pedidos');
$actionError = '';
$errors = [];
$id = '';
$numero_pedido = '';
$nome_cafe = '';
$valor_total = '';

// Carregar dados para edição
if (!empty($_GET['editar'])) {
    $ped = $db->find($_GET['editar']);
    if ($ped) {
        $id = $ped->id;
        $numero_pedido = $ped->numero_pedido;
        $nome_cafe = $ped->nome_cafe;
        $valor_total = $ped->valor_total;
    }
}

if (!empty($_POST)) {
    // Sempre pega os valores do POST primeiro (em caso de erro de validação)
    $id = $_POST['id'] ?? '';
    $numero_pedido = $_POST['numero_pedido'] ?? '';
    $nome_cafe = $_POST['nome_cafe'] ?? '';
    $valor_total = $_POST['valor_total'] ?? '';
    
    try {
        if (empty($_POST['numero_pedido'])) {
            $errors[] = "<li>O número do pedido é obrigatório</li>";
        }
        if (empty($_POST['nome_cafe'])) {
            $errors[] = "<li>O nome do café é obrigatório</li>";
        }
        if (empty($_POST['valor_total'])) {
            $errors[] = "<li>O valor total é obrigatório</li>";
        }

        if (empty($errors)) {
            $dados = [
                'numero_pedido' => $_POST['numero_pedido'],
                'nome_cafe' => $_POST['nome_cafe'],
                'valor_total' => $_POST['valor_total']
            ];

            if (empty($_POST['id'])) {
                $db->store($dados);
                $mensagem = "Pedido cadastrado com sucesso!";
            } else {
                $db->update($_POST['id'], $dados);
                $mensagem = "Pedido atualizado com sucesso!";
            }
            
            // Redireciona para a listagem com mensagem de sucesso
            header("Location: PostList.php?sucesso=" . urlencode($mensagem));
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
    <title><?= $id ? "Editar Pedido" : "Novo Pedido" ?> - Grão de Ouro</title>
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
                    <a href="./PostList.php" class="nav-link active-coffee rounded p-2">
                        <i class="bi bi-file-earmark-post me-2" style="color: #D4A35D;"></i> Pedidos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../produto/ProdutoList.php" class="nav-link rounded p-2">
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
                <h1 class="h2 title-coffee"><?= $id ? "Editar Pedido" : "Novo Pedido" ?></h1>
                <div class="text-light opacity-75">
                    <a href="PostList.php" class="btn-coffee-primary btn">
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
                        <form action="PostForm.php<?= $id ? '?editar=' . $id : '' ?>" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                            <div class="mb-4">
                                <label for="numero_pedido" class="form-label">
                                    <i class="bi bi-hash me-2"></i>Número do Pedido / Comanda
                                </label>
                                <input type="number" 
                                       name="numero_pedido" 
                                       id="numero_pedido" 
                                       class="form-control form-control-lg" 
                                       value="<?= htmlspecialchars($numero_pedido) ?>" 
                                       placeholder="Digite o número do pedido"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label for="nome_cafe" class="form-label">
                                    <i class="bi bi-cup-hot me-2"></i>Nome do Café / Produto
                                </label>
                                <input type="text" 
                                       name="nome_cafe" 
                                       id="nome_cafe" 
                                       class="form-control form-control-lg" 
                                       value="<?= htmlspecialchars($nome_cafe) ?>" 
                                       placeholder="Ex: Latte de Pistache"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label for="valor_total" class="form-label">
                                    <i class="bi bi-currency-dollar me-2"></i>Valor Total (R$)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #37070E; border: 1px solid #C2933C; color: #D4A35D;">R$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           name="valor_total" 
                                           id="valor_total" 
                                           class="form-control form-control-lg" 
                                           value="<?= htmlspecialchars($valor_total) ?>" 
                                           placeholder="0.00"
                                           required>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-coffee-success btn-lg">
                                    <i class="bi bi-check-lg me-2"></i>
                                    <?= $id ? "Atualizar Pedido" : "Salvar Pedido" ?>
                                </button>
                                <a href="PostList.php" class="btn btn-coffee-primary btn-lg">
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
                                <p class="mb-2"><strong>Editando Pedido #<?= $id ?></strong></p>
                                <p class="text-muted" style="color: #E8BC73 !important;">Altere os campos necessários e clique em "Atualizar Pedido".</p>
                            <?php else: ?>
                                <p class="mb-2"><strong>Novo Pedido</strong></p>
                                <p class="text-muted" style="color: #E8BC73 !important;">Preencha todos os campos para cadastrar um novo pedido no sistema.</p>
                            <?php endif; ?>
                            
                            <hr>
                            
                            <p class="mb-1"><i class="bi bi-check-circle me-2" style="color: #D4A35D;"></i>Todos os campos são obrigatórios</p>
                            <p class="mb-0"><i class="bi bi-check-circle me-2" style="color: #D4A35D;"></i>Valor em reais (R$)</p>
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