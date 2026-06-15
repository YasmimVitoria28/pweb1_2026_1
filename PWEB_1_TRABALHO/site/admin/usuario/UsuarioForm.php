<?php

include __DIR__ . '/../../../header.php';
include '../database/db.class.php';


$db = new db('usuario');

$mensagem = "";
$id = "";
$nome = "";
$email = "";
$telefone = "";
$login = "";
$senha = "";


if (!empty($_GET['editar'])) {
    $u = $db->find($_GET['editar']);
    if ($u) {
        $id       = $u->id;
        $nome     = $u->nome;
        $email    = $u->email;
        $telefone = $u->telefone;
        $login    = $u->login;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = $_POST['id'] ?? '';
    $nome     = $_POST['nome'] ?? '';
    $email    = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $login    = $_POST['login'] ?? '';
    $senha    = $_POST['senha'] ?? '';

    if (empty($nome) || empty($email) || empty($login) || (empty($id) && empty($senha))) {
        $mensagem = "<div class='alert alert-danger'>Todos os campos (exceto telefone) são obrigatórios!</div>";
    } else {
        
        $dados = [
            'nome'     => $nome,
            'email'    => $email,
            'telefone' => $telefone,
            'login'    => $login
        ];

        // gera o hash 
        if (!empty($senha)) {
            $dados['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        }

        if (empty($id)) {
           
            $db->store($dados);
            $mensagem = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
            
            
            $nome = $email = $telefone = $login = $senha = ""; 
        } else {
            
            $db->update($id, $dados);
            $mensagem = "<div class='alert alert-success'>Usuário atualizado com sucesso!</div>";
        }
    }
}
?>

<header>
    <button class="btn btn-primary position-fixed" style="left: 20px; top: 50%; transform: translateY(-50%); z-index: 1030;" onclick="history.back()">&larr; Voltar
    </button>
</header>

<div class="container mt-4" style="max-width: 700px;">
    <h2><?= $id ? "Editar Usuário" : "Novo Usuário" ?></h2>
    <?= $mensagem; ?>
    
    <form action="" method="POST" class="mt-3">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="mb-3">
            <label class="form-label">Nome Completo:</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nome) ?>" placeholder="Ex: João da Silva">
        </div>

        <div class="mb-3">
            <label class="form-label">E-mail:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" placeholder="Ex: joao@email.com">
        </div>

        <div class="mb-3">
            <label class="form-label">Telefone:</label>
            <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($telefone) ?>" placeholder="Ex: (49) 99999-9999">
        </div>

        <div class="mb-3">
            <label class="form-label">Login de Usuário:</label>
            <input type="text" name="login" class="form-control" value="<?= htmlspecialchars($login) ?>" placeholder="Ex: joao.silva">
        </div>

        <div class="mb-3">
            <label class="form-label">Senha:</label>
            <input type="password" name="senha" class="form-control" placeholder="<?= $id ? 'Deixe em branco para manter a senha atual' : 'Digite a senha do usuário' ?>">
        </div>

        <button type="submit" class="btn btn-success">Salvar Usuário</button>
        <a href="UsuarioList.php" class="btn btn-secondary">Ver Listagem</a>
    </form>
</div>