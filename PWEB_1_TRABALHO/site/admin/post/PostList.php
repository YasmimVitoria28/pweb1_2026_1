<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';

// Criando a instância da tabela pedidos
$db = new db('pedidos');

// DELETE
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

// READ - Carregando todos os dados
$busca = $_GET['busca'] ?? '';
$pedidos = $db->all();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Pedidos - Grão de Ouro</title>
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

        .table-coffee {
            background-color: #2a0810;
            border: 1px solid #D4A35D;
            color: #ffffff;
        }

        .table-coffee thead {
            background-color: #37070E;
            color: #d48618;
            border-bottom: 2px solid #D4A35D;
        }

        .table-coffee tbody tr {
            border-color: #C2933C;
        }

        .table-coffee tbody tr:hover {
            background-color: #37070E !important;
        }

        .table-coffee th,
        .table-coffee td {
            color: #000000;
            vertical-align: middle;
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

        .btn-coffee-warning {
            background-color: transparent;
            border-color: #D4A35D;
            color: #D4A35D;
        }

        .btn-coffee-warning:hover {
            background-color: #D4A35D;
            border-color: #D4A35D;
            color: #1f0408;
        }

        .btn-coffee-danger {
            background-color: transparent;
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-coffee-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #ffffff;
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

        .form-coffee .form-control::placeholder {
            color: #E8BC73;
            opacity: 0.7;
        }

        .badge-coffee {
            background-color: #D4A35D;
            color: #1f0408;
        }

        .text-muted-coffee {
            color: #E8BC73 !important;
        }

        .pagination-coffee .page-link {
            background-color: #37070E;
            border-color: #C2933C;
            color: #D4A35D;
        }

        .pagination-coffee .page-link:hover {
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
                <h1 class="h2 title-coffee">
                    <i class="bi bi-file-earmark-post me-2"></i>Listagem de Pedidos
                </h1>
                <div class="text-light opacity-75">
                    <span class="badge badge-coffee fs-6">
                        <?= count($pedidos) ?> pedidos
                    </span>
                </div>
            </div>

            <!-- Mensagem de Sucesso -->
            <?php if (!empty($_GET['sucesso'])): ?>
                <div class="alert alert-success alert-coffee alert-dismissible fade show" role="alert" id="alerta-sucesso">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>Sucesso!</strong> <?= htmlspecialchars($_GET['sucesso']) ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            <?php endif; ?>

            <!-- Barra de Ações -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <a href="PostForm.php" class="btn btn-coffee-success btn-lg">
                        <i class="bi bi-plus-lg me-2"></i>Novo Pedido
                    </a>
                </div>
                <div class="col-md-6">
                    <form action="PostList.php" method="GET" class="form-coffee">
                        <div class="input-group">
                            <span class="input-group-text" style="background-color: #37070E; border: 1px solid #C2933C; color: #D4A35D;">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   name="busca" 
                                   class="form-control" 
                                   value="<?= htmlspecialchars($busca) ?>" 
                                   placeholder="Buscar por nome do café...">
                            <button type="submit" class="btn btn-coffee-success">
                                <i class="bi bi-search me-1"></i> Buscar
                            </button>
                            <?php if (!empty($busca)): ?>
                                <a href="PostList.php" class="btn btn-coffee-primary">
                                    <i class="bi bi-x-lg"></i> Limpar
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Pedidos -->
            <div class="card card-status">
                <div class="card-header card-status-header">
                    <i class="bi bi-list-ul me-2"></i>
                    <?= !empty($busca) ? "Resultados para: \"$busca\"" : "Todos os Pedidos" ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-coffee table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">#</th>
                                    <th scope="col" width="15%">Nº Pedido</th>
                                    <th scope="col" width="35%">Nome do Café</th>
                                    <th scope="col" width="20%">Valor Total</th>
                                    <th scope="col" width="25%" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $encontrou = false;
                                if (!empty($pedidos)) {
                                    foreach($pedidos as $p){
                                        // Se houver busca e o termo não for encontrado no nome do café, pula para o próximo
                                        if (!empty($busca) && stripos($p->nome_cafe, $busca) === false) {
                                            continue; 
                                        }
                                        $encontrou = true;
                                        ?>
                                        <tr>
                                            <th scope="row">
                                                <span class="badge badge-coffee"><?= $p->id ?></span>
                                            </th>
                                            <td>
                                                <strong>#<?= $p->numero_pedido ?></strong>
                                            </td>
                                            <td>
                                                <i class="bi bi-cup-hot me-2" style="color: #D4A35D;"></i>
                                                <?= htmlspecialchars($p->nome_cafe) ?>
                                            </td>
                                            <td>
                                                <span class="fw-bold" style="color: #D4A35D;">
                                                    R$ <?= number_format($p->valor_total, 2, ',', '.') ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="PostForm.php?editar=<?= $p->id ?>" 
                                                       class="btn btn-coffee-warning btn-sm"
                                                       title="Editar pedido">
                                                        <i class="bi bi-pencil me-1"></i> Editar
                                                    </a>
                                                    <a href="PostList.php?action=delete&id=<?= $p->id ?>" 
                                                       class="btn btn-coffee-danger btn-sm" 
                                                       title="Excluir pedido"
                                                       onclick="return confirm('Tem certeza que deseja excluir o pedido #<?= $p->numero_pedido ?> - <?= htmlspecialchars($p->nome_cafe) ?>?')">
                                                        <i class="bi bi-trash me-1"></i> Excluir
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                
                                if (!$encontrou) {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #D4A35D;"></i>
                                            <p class="text-muted-coffee mb-2">Nenhum pedido encontrado</p>
                                            <?php if (!empty($busca)): ?>
                                                <small style="color: #E8BC73;">
                                                    Nenhum resultado para "<strong><?= htmlspecialchars($busca) ?></strong>"
                                                </small>
                                                <br>
                                                <a href="PostList.php" class="btn btn-coffee-primary btn-sm mt-2">
                                                    <i class="bi bi-arrow-left me-1"></i> Voltar para lista completa
                                                </a>
                                            <?php else: ?>
                                                <a href="PostForm.php" class="btn btn-coffee-success btn-sm mt-2">
                                                    <i class="bi bi-plus-lg me-1"></i> Criar primeiro pedido
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($encontrou): ?>
                <div class="card-footer" style="background-color: #2a0810; border-top: 1px solid #C2933C;">
                    <div class="d-flex justify-content-between align-items-center">
                        <small style="color: #E8BC73;">
                            <i class="bi bi-info-circle me-1"></i>
                            <?php 
                            $total = 0;
                            foreach($pedidos as $p) {
                                if (!empty($busca) && stripos($p->nome_cafe, $busca) === false) {
                                    continue;
                                }
                                $total++;
                            }
                            echo "Mostrando $total pedido(s)";
                            ?>
                        </small>
                        <small style="color: #E8BC73;">
                            <i class="bi bi-currency-dollar me-1"></i>
                            Valor total: 
                            <strong style="color: #D4A35D;">
                                R$ <?php 
                                $valorTotal = 0;
                                foreach($pedidos as $p) {
                                    if (!empty($busca) && stripos($p->nome_cafe, $busca) === false) {
                                        continue;
                                    }
                                    $valorTotal += $p->valor_total;
                                }
                                echo number_format($valorTotal, 2, ',', '.');
                                ?>
                            </strong>
                        </small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>