

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Grão de Ouro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-admin {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card-admin:hover {
            transform: translateY(-5px);
        }
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            color: white;
        }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }
        .sidebar a:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
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
                    <a href="#" class="nav-link active rounded p-2 bg-primary text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="paginas/post/postList.php" class="nav-link rounded p-2">
                        <i class="bi bi-file-earmark-post me-2"></i> Posts
                    </a>
                </li>
                <li class="nav-item">
                    <a href="paginas/produto/produtoList.php" class="nav-link rounded p-2">
                        <i class="bi bi-cup-hot me-2"></i> Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="paginas/usuario/usuarioList.php" class="nav-link rounded p-2">
                        <i class="bi bi-people me-2"></i> Usuários
                    </a>
                </li>
                <li class="nav-item">
                    <a href="paginas/avaliacao/avaliacaoList.php" class="nav-link rounded p-2">
                        <i class="bi bi-star me-2"></i> Avaliações
                    </a>
                </li>
            </ul>
            <hr>
            <div class="d-grid">
                <a href="logout.php" class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Painel de Controle</h1>
                <div class="text-secondary">Bem-vindo de volta, Admin!</div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-admin h-100 bg-white">
                        <div class="card-body d-flex align-items-center">
                            <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle me-3">
                                <i class="bi bi-file-earmark-post fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-0">Gerenciar Posts</h6>
                                <a href="paginas/post/postList.php" class="btn btn-sm btn-link p-0 mt-1">Acessar Módulo &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-admin h-100 bg-white">
                        <div class="card-body d-flex align-items-center">
                            <div class="p-3 bg-success bg-opacity-10 text-success rounded-circle me-3">
                                <i class="bi bi-cup-hot fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-0">Produtos (Cardápio)</h6>
                                <a href="paginas/produto/produtoList.php" class="btn btn-sm btn-link p-0 mt-1 text-success">Acessar Módulo &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-admin h-100 bg-white">
                        <div class="card-body d-flex align-items-center">
                            <div class="p-3 bg-info bg-opacity-10 text-info rounded-circle me-3">
                                <i class="bi bi-people fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-0">Usuários do Sistema</h6>
                                <a href="paginas/usuario/usuarioList.php" class="btn btn-sm btn-link p-0 mt-1 text-info">Acessar Módulo &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-admin h-100 bg-white">
                        <div class="card-body d-flex align-items-center">
                            <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-circle me-3">
                                <i class="bi bi-star fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-0">Avaliações Recebidas</h6>
                                <a href="paginas/avaliacao/avaliacaoList.php" class="btn btn-sm btn-link p-0 mt-1 text-warning">Acessar Módulo &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white font-weight-bold">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Status do Sistema
                </div>
                <div class="card-body">
                    <p class="card-text">Utilize o menu lateral ou os cartões acima para inserir, editar, listar ou remover qualquer registro da Cafeteria Grão de Ouro.</p>
                    <div class="alert alert-light border d-inline-block">
                        <i class="bi bi-hdd-network me-2 text-success"></i> Banco de Dados Conectado: <strong>cafeteria</strong>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>