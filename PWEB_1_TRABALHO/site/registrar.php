<?php
include __DIR__ . '/../header.php';
include __DIR__ . '/admin/database/db.class.php';

$db = new db('usuario');

$success = ' ';
$actionError = ' ';
$erros = [];
$data = '';

if (!empty($_POST)) {
    $data = (object) $_POST;

    try {
        if (empty($_POST['nome'])) {
            $erros[] = "<li>O nome é obrigatório</li>";
        }
        if (empty($_POST['email'])) {
            $erros[] = "<li>O email é obrigatório</li>";
        }
        if (empty($_POST['telefone'])) {
            $erros[] = "<li>O telefone é obrigatório</li>";
        }
        if (empty($_POST['login'])) {
            $erros[] = "<li>O login é obrigatório</li>";
        }
        if (empty($_POST['senha'])) {
            $erros[] = "<li>A senha é obrigatória</li>";
        } elseif (strlen($_POST['senha']) < 3) {
            $erros[] = "<li>A senha deve ter no mínimo 3 caracteres</li>";
        }

        if (empty($erros)) {
            $emailExiste = $db->findBy('email', $_POST['email']);
            $loginExiste = $db->findBy('login', $_POST['login']);

            if ($emailExiste) {
                $erros[] = "<li>Este e-mail já está cadastrado</li>";
            } elseif ($loginExiste) {
                $erros[] = "<li>Este login já está em uso</li>";
            } else {
                $dados = [
                    'nome'         => $_POST['nome'],
                    'email'        => $_POST['email'],
                    'telefone'     => $_POST['telefone'],
                    'login'        => $_POST['login'],
                    'senha'        => password_hash($_POST['senha'], PASSWORD_DEFAULT),
                    'nivel_acesso' => 'cliente'
                ];

                $db->store($dados);
                $success = "Cadastro realizado com sucesso!";
                redirect('./login.php');
            }
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
    <title>Criar Conta - Grão de Ouro</title>
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
        
        .form-container {
            background-color: #2a0810;
            border: 1px solid #D4A35D;
            border-radius: 15px;
            padding: 2.5rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        
        .title-coffee {
            color: #d48618;
            font-weight: bold;
        }

        .form-control-coffee {
            background-color: #1f0408 !important;
            border: 1px solid #C2933C !important;
            color: #ffffff !important;
        }

        .form-control-coffee:focus {
            border-color: #D4A35D !important;
            box-shadow: 0 0 0 0.25rem rgba(212, 163, 93, 0.25) !important;
        }

        .form-label-coffee {
            color: #E8BC73;
            font-weight: 500;
        }

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
            transform: translateY(-1px);
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
            transform: translateY(-1px);
        }

        .alert-coffee {
            background-color: #1f0408 !important;
            border: 1px solid #D4A35D !important;
            color: #ffffff !important;
        }

        hr {
            background-color: #D4A35D;
            opacity: 0.3;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center py-5">
    <div class="form-container shadow">
        
        <div class="text-center mb-4">
            <i class="bi bi-cup-hot-fill fs-2" style="color: #D4A35D;"></i>
            <h2 class="title-coffee mt-2">Criar Conta</h2>
            <p class="text-light opacity-75 small">Cadastre-se para realizar seus pedidos no Grão de Ouro</p>
        </div>

        <div class="mb-3">
            <?php actionMessage($success, $actionError); ?>
            <?php showValidationError($erros); ?>
        </div>

        <form action="registrar.php" method="post">

            <div class="mb-3">
                <label class="form-label form-label-coffee">Nome Completo</label>
                <input type="text" name="nome" class="form-control form-control-coffee"
                       value="<?php echo getFormValue($data, 'nome'); ?>" placeholder="Digite seu nome">
            </div>

            <div class="mb-3">
                <label class="form-label form-label-coffee">E-mail</label>
                <input type="email" name="email" class="form-control form-control-coffee"
                       value="<?php echo getFormValue($data, 'email'); ?>" placeholder="nome@exemplo.com">
            </div>

            <div class="mb-3">
                <label class="form-label form-label-coffee">Telefone</label>
                <input type="text" name="telefone" class="form-control form-control-coffee"
                       value="<?php echo getFormValue($data, 'telefone'); ?>" placeholder="(00) 00000-0000">
            </div>

            <div class="mb-3">
                <label class="form-label form-label-coffee">Login de Usuário</label>
                <input type="text" name="login" class="form-control form-control-coffee"
                       value="<?php echo getFormValue($data, 'login'); ?>" placeholder="Escolha um nome de usuário">
            </div>

            <div class="mb-4">
                <label class="form-label form-label-coffee">Senha</label>
                <input type="password" name="senha" class="form-control form-control-coffee" placeholder="Mínimo 3 caracteres">
            </div>

            <hr class="mb-4">

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-coffee-primary py-2">
                    <i class="bi bi-person-plus-fill me-2"></i>Finalizar Cadastro
                </button>
                <a href="./login.php" class="btn btn-coffee-outline py-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Já tenho conta (Entrar)
                </a>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 

include __DIR__ . '/../footer.php';
?>