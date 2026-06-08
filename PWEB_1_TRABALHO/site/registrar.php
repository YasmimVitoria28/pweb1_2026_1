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
                redirect('../../login.php');
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
                <h3 class="mb-4 text-center">Criar Conta</h3>

                <?php actionMessage($success, $actionError); ?>
                <?php showValidationError($erros); ?>

                <form action="registrar.php" method="post">

                    <div class="mb-3">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control"
                            value="<?php echo getFormValue($data, 'nome'); ?>">
                    </div>

                    <div class="mb-3">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control"
                            value="<?php echo getFormValue($data, 'email'); ?>">
                    </div>

                    <div class="mb-3">
                        <label>Telefone</label>
                        <input type="text" name="telefone" class="form-control"
                            value="<?php echo getFormValue($data, 'telefone'); ?>">
                    </div>

                    <div class="mb-3">
                        <label>Login</label>
                        <input type="text" name="login" class="form-control"
                            value="<?php echo getFormValue($data, 'login'); ?>">
                    </div>

                    <div class="mb-3">
                        <label>Senha</label>
                        <input type="password" name="senha" class="form-control">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                        <a href="../../login.php" class="btn btn-outline-primary">Já tenho conta</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php //include './footer.php'; ?>