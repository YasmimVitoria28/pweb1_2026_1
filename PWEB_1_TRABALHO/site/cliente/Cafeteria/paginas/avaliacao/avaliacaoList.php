<?php
include __DIR__ . '/../../../../../header.php';
include __DIR__ . '/../../../../admin/database/db.class.php';

$db = new db('avaliacao');

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $db->destroy($id);
    header("Location: avaliacaoList.php?sucesso=" . urlencode("Avaliação removida com sucesso!"));
    exit;
}

$busca = $_GET['busca'] ?? '';
$avaliacoes = $db->all();
$dbProduto = new db('produto');
$produtos = $dbProduto->all();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Avaliações - Grão de Ouro</title>
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
        .table-coffee { background-color: #2a0810; border: 1px solid #D4A35D; color: #ffffff; }
        .table-coffee thead { background-color: #37070E; color: #d48618; border-bottom: 2px solid #D4A35D; }
        .table-coffee tbody tr { border-color: #C2933C; }
        .table-coffee tbody tr:hover { background-color: #37070E !important; }
        .table-coffee th, .table-coffee td { color: #000000; vertical-align: middle; }
        .btn-coffee-success { background-color: #D4A35D; border-color: #D4A35D; color: #1f0408; font-weight: bold; }
        .btn-coffee-success:hover { background-color: #C2933C; border-color: #C2933C; color: #1f0408; }
        .btn-coffee-primary { background-color: #37070E; border-color: #D4A35D; color: #D4A35D; }
        .btn-coffee-primary:hover { background-color: #D4A35D; border-color: #D4A35D; color: #1f0408; }
        .btn-coffee-warning { background-color: transparent; border-color: #D4A35D; color: #D4A35D; }
        .btn-coffee-warning:hover { background-color: #D4A35D; border-color: #D4A35D; color: #1f0408; }
        .btn-coffee-danger { background-color: transparent; border-color: #dc3545; color: #dc3545; }
        .btn-coffee-danger:hover { background-color: #dc3545; border-color: #dc3545; color: #ffffff; }
        .form-coffee .form-control { background-color: #37070E; border: 1px solid #C2933C; color: #ffffff; }
        .form-coffee .form-control:focus { background-color: #37070E; border-color: #D4A35D; color: #ffffff; box-shadow: 0 0 0 0.2rem rgba(212, 163, 93, 0.25); }
        .form-coffee .form-control::placeholder { color: #E8BC73; opacity: 0.7; }
        .badge-coffee { background-color: #D4A35D; color: #1f0408; }
        .text-muted-coffee { color: #E8BC73 !important; }
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
                    <a href="../../../../admin/post/PostList.php" class="nav-link rounded p-2">
                        <i class="bi bi-file-earmark-post me-2" style="color: #D4A35D;"></i> Pedidos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../../../admin/produto/ProdutoList.php" class="nav-link rounded p-2">
                        <i class="bi bi-cup-hot me-2" style="color: #D4A35D;"></i> Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../../../admin/usuario/UsuarioList.php" class="nav-link rounded p-2">
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
                <h1 class="h2 title-coffee">
                    <i class="bi bi-star me-2"></i>Listagem de Avaliações
                </h1>
                <span class="badge badge-coffee fs-6"><?= count($avaliacoes) ?> avaliações</span>
            </div>

            <?php if (!empty($_GET['sucesso'])): ?>
                <div class="alert alert-success alert-coffee alert-dismissible fade show" role="alert" id="alerta-sucesso">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>Sucesso!</strong> <?= htmlspecialchars($_GET['sucesso']) ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-md-6">
                    <a href="../contato.php" class="btn btn-coffee-success btn-lg">
                        <i class="bi bi-plus-lg me-2"></i>Nova Avaliação
                    </a>
                </div>
                <div class="col-md-6">
                    <form action="avaliacaoList.php" method="GET" class="form-coffee">
                        <div class="input-group">
                            <span class="input-group-text" style="background-color: #37070E; border: 1px solid #C2933C; color: #D4A35D;">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="busca" class="form-control"
                                   value="<?= htmlspecialchars($busca) ?>"
                                   placeholder="Buscar por comentário...">
                            <button type="submit" class="btn btn-coffee-success">
                                <i class="bi bi-search me-1"></i> Buscar
                            </button>
                            <?php if (!empty($busca)): ?>
                                <a href="avaliacaoList.php" class="btn btn-coffee-primary">
                                    <i class="bi bi-x-lg"></i> Limpar
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-status">
                <div class="card-header card-status-header">
                    <i class="bi bi-list-ul me-2"></i>
                    <?= !empty($busca) ? "Resultados para: \"$busca\"" : "Todas as Avaliações" ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-coffee table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Produto</th>
                                    <th width="10%">Nota</th>
                                    <th width="45%">Comentário</th>
                                    <th width="15%" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $encontrou = false;
                                if (!empty($avaliacoes)):
                                    foreach ($avaliacoes as $a):
                                        if (!empty($busca) && stripos($a->comentario ?? '', $busca) === false) continue;
                                        $encontrou = true;

                                        $produto = null;
                                        foreach ($produtos as $pr) {
                                            if ($pr->id == $a->produto_id) { $produto = $pr; break; }
                                        }
                                        $nomeProduto     = $produto ? htmlspecialchars($produto->nome)      : "Produto #{$a->produto_id}";
                                        $categoriaProduto = $produto ? htmlspecialchars($produto->categoria) : "Sem categoria";
                                ?>
                                <tr>
                                    <th><span class="badge badge-coffee"><?= $a->id ?></span></th>
                                    <td>
                                        <i class="bi bi-cup-hot me-2" style="color: #D4A35D;"></i>
                                        <strong><?= $nomeProduto ?></strong><br>
                                        <small style="color: #E8BC73;">[<?= $categoriaProduto ?>]</small>
                                    </td>
                                    <td><span style="color: #D4A35D; font-size: 1.2em;"><?= str_repeat("⭐", $a->nota) ?></span></td>
                                    <td>
                                        <i class="bi bi-chat-text me-2" style="color: #D4A35D;"></i>
                                        <?= htmlspecialchars($a->comentario ?? 'Sem comentário') ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="../contato.php?editar=<?= $a->id ?>" class="btn btn-coffee-warning btn-sm">
                                                <i class="bi bi-pencil me-1"></i> Editar
                                            </a>
                                            <a href="avaliacaoList.php?action=delete&id=<?= $a->id ?>"
                                               class="btn btn-coffee-danger btn-sm"
                                               onclick="return confirm('Tem certeza que deseja excluir esta avaliação?')">
                                                <i class="bi bi-trash me-1"></i> Excluir
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    endforeach;
                                endif;

                                if (!$encontrou): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #D4A35D;"></i>
                                        <p class="text-muted-coffee mb-2">Nenhuma avaliação encontrada</p>
                                        <?php if (!empty($busca)): ?>
                                            <small style="color: #E8BC73;">Nenhum resultado para "<strong><?= htmlspecialchars($busca) ?></strong>"</small><br>
                                            <a href="avaliacaoList.php" class="btn btn-coffee-primary btn-sm mt-2">
                                                <i class="bi bi-arrow-left me-1"></i> Voltar para lista completa
                                            </a>
                                        <?php else: ?>
                                            <a href="../contato.php" class="btn btn-coffee-success btn-sm mt-2">
                                                <i class="bi bi-plus-lg me-1"></i> Criar primeira avaliação
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
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
                            foreach ($avaliacoes as $a) {
                                if (!empty($busca) && stripos($a->comentario ?? '', $busca) === false) continue;
                                $total++;
                            }
                            echo "Mostrando $total avaliação(ões)";
                            ?>
                        </small>
                        <small style="color: #E8BC73;">
                            <i class="bi bi-star me-1"></i> Média geral:
                            <strong style="color: #D4A35D;">
                                <?php
                                $soma = 0; $qtd = 0;
                                foreach ($avaliacoes as $a) {
                                    if (!empty($busca) && stripos($a->comentario ?? '', $busca) === false) continue;
                                    $soma += $a->nota; $qtd++;
                                }
                                echo $qtd > 0 ? number_format($soma / $qtd, 1) . ' ⭐' : '0 ⭐';
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