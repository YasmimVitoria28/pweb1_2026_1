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
                    <a href="#" class="nav-link active-coffee rounded p-2">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./post/PostList.php" class="nav-link rounded p-2">
                        <i class="bi bi-file-earmark-post me-2" style="color: #D4A35D;"></i> Pedidos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./produto/ProdutoList.php" class="nav-link rounded p-2">
                        <i class="bi bi-cup-hot me-2" style="color: #D4A35D;"></i> Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./usuario/UsuarioList.php" class="nav-link rounded p-2">
                        <i class="bi bi-people me-2" style="color: #D4A35D;"></i> Usuários
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../cliente/Cafeteria/paginas/avaliacao/avaliacaoList.php" class="nav-link rounded p-2">
                        <i class="bi bi-star me-2" style="color: #D4A35D;"></i> Avaliações
                    </a>
                </li>
            </ul>
            <hr>
        </nav> <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom-coffee">
                <h1 class="h2 title-coffee">Painel de Controle</h1>
                <div class="text-light opacity-75">Bem-vindo</div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-admin h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="p-3 bg-opacity-10 rounded-circle me-3" style="background-color: rgba(212, 163, 93, 0.2); color: #D4A35D;">
                                <i class="bi bi-file-earmark-post fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-title card-title-coffee mb-0">Gerenciar Pedidos</h6>
                                <a href="./post/PostList.php" class="btn btn-sm btn-link-coffee p-0 mt-1">Acessar Pedidos &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-admin h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="p-3 bg-opacity-10 rounded-circle me-3" style="background-color: rgba(212, 163, 93, 0.2); color: #D4A35D;">
                                <i class="bi bi-cup-hot fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-title card-title-coffee mb-0">Produtos (Cardápio)</h6>
                                <a href="./produto/ProdutoList.php" class="btn btn-sm btn-link-coffee p-0 mt-1">Acessar Cardápio &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-admin h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="p-3 bg-opacity-10 rounded-circle me-3" style="background-color: rgba(212, 163, 93, 0.2); color: #D4A35D;">
                                <i class="bi bi-people fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-title card-title-coffee mb-0">Usuários do Sistema</h6>
                                <a href="./usuario/UsuarioList.php" class="btn btn-sm btn-link-coffee p-0 mt-1">Acessar Cadastros &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-admin h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="p-3 bg-opacity-10 rounded-circle me-3" style="background-color: rgba(212, 163, 93, 0.2); color: #D4A35D;">
                                <i class="bi bi-star fs-3"></i>
                            </div>
                            <div>
                                <h6 class="card-title card-title-coffee mb-0">Avaliações Recebidas</h6>
                                <a href="../cliente/Cafeteria/paginas/avaliacao/avaliacaoList.php" class="btn btn-sm btn-link-coffee p-0 mt-1">Acessar Avaliações &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-status shadow-sm">
                <div class="card-header card-status-header">
                    <i class="bi bi-info-circle me-2"></i>Status do Sistema
                </div>
                <div class="card-body">
                    <p class="card-text" style="color: #ffffff;">Utilize o menu lateral ou os cartões acima para inserir, editar, listar ou remover qualquer registro da Cafeteria Grão de Ouro.</p>
                    <div class="alert alert-coffee border d-inline-block m-0">
                        <i class="bi bi-hdd-network me-2" style="color: #D4A35D;"></i> Banco de Dados Conectado: <strong style="color: #d48618;">cafeteria</strong>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

