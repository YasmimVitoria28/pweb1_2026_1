<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Grão de Ouro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-color: #1f0408;
            color: #ffffff;
            font-family: system-ui, -apple-system, sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .welcome-container {
            background-color: #2a0810;
            border: 1px solid #D4A35D;
            border-radius: 15px;
            padding: 3rem;
            max-width: 550px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        
        .title-coffee {
            color: #d48618;
            font-weight: bold;
        }

        /* ESTILO DOS BOTÕES BASEADO NO LAYOUT ORIGINAL */
        .btn-coffee-primary {
            background-color: #D4A35D !important;
            color: #37070E !important;
            font-weight: bold;
            border: 1px solid #D4A35D;
            transition: all 0.3s ease;
        }
        
        .btn-coffee-primary:hover {
            background-color: #ffffff !important;
            color: #2a0810 !important;
            border-color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-coffee-outline {
            background-color: transparent;
            color: #E8BC73;
            border: 1px solid #D4A35D;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-coffee-outline:hover {
            background-color: #37070E;
            color: #ffffff;
            border-color: #ffffff;
            transform: translateY(-2px);
        }

        hr {
            background-color: #D4A35D;
            opacity: 0.3;
            margin: 2rem 0;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="welcome-container text-center shadow">
        
        <div class="mb-3">
            <i class="bi bi-cup-hot fs-1" style="color: #D4A35D;"></i>
        </div>
        <h1 class="display-5 title-coffee mb-2">Grão de Ouro</h1>
        <p class="text-light opacity-75 lead">Seja bem-vindo à nossa cafeteria virtual</p>
        
        <hr>

        <div class="mb-4">
            <a href="./site/cliente/Cafeteria/paginas/cafe.html" class="btn btn-lg btn-coffee-primary w-100 py-3 shadow-sm">
                <i class="bi bi-journal-richtext me-2"></i>Ver Nosso Cardápio
            </a>
        </div>

        <div class="row g-3">
            <div class="col-6">
                <a href="./site/login.php" class="btn btn-coffee-outline w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                </a>
            </div>
            <div class="col-6">
                <a href="./site/registrar.php" class="btn btn-coffee-outline w-100 py-2">
                    <i class="bi bi-person-plus me-2"></i>Registrar
                </a>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
include __DIR__ . '/footer.php';
?>