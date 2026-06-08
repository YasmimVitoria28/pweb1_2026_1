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
        if (empty($_POST['email'])) {
            $erros[] = "<li>O email é obrigatório</li>";
        }

        if (empty($_POST['senha'])) {
            $erros[] = "<li>A senha é obrigatória</li>";
        } else {
            if (strlen($_POST['senha']) < 3) {
                $erros[] = "<li>A senha deve ter no mínimo 3 caracteres</li>";
            }
        }

        if (empty($erros)) {
            $usuario = $db->findBy('email', $_POST['email']);
 
            if ($usuario && password_verify($_POST['senha'], $usuario->senha)) {
                $_SESSION['usuario_id']    = $usuario->id;
                $_SESSION['usuario_nome']  = $usuario->nome;
                $_SESSION['usuario_email'] = $usuario->email;
                $_SESSION['nivel']         = $usuario->nivel_acesso;

                $success = "Logado com sucesso!";

                if (in_array($usuario->nivel_acesso, ['admin', 'funcionario'])) {
                    redirect('./admin/index.php');
                } else {
                    redirect('./cliente/Cafeteria/index.html');
                }
            } else {
                $erros[] = "<li>E-mail ou senha incorretos.</li>";
            }
        }
    } catch (Exception $e) {
        $actionError = $e->getMessage();
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="mb-4 text-center">Login</h3>

                <?php actionMessage($success, $actionError); ?>
                <?php showValidationError($erros); ?>

                <form action="login.php" method="post">

                    <div class="mb-3">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" class="form-control"
                            value="<?php echo getFormValue($data, 'email'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" class="form-control">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Entrar</button>
                        <a href="./registrar.php" class="btn btn-outline-primary">Criar conta</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php //include './footer.php'; ?>