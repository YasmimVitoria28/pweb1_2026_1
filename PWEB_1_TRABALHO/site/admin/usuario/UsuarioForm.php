<?php
// O header sempre deve ser o primeiro para carregar as funções e a sessão
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';

// Criando a instância da tabela usuario seguindo a sua db.class
$db = new db('usuario');

$mensagem = "";
$id = "";
$nome = "";
$email = "";
$telefone = "";
$login = "";
$senha = "";
$nivel_acesso = "";

// Carregar dados para edição (Usa o método find() da sua classe db)
if (!empty($_GET['editar'])) {
    $u = $db->find($_GET['editar']);
    if ($u) {
        $id           = $u->id;
        $nome         = $u->nome;
        $email        = $u->email;
        $telefone     = $u->telefone;
        $login        = $u->login;
        $nivel_acesso = $u->nivel_acesso;
    }
}

// Processar envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id           = $_POST['id'] ?? '';
    $nome         = $_POST['nome'] ?? '';
    $email        = $_POST['email'] ?? '';
    $telefone     = $_POST['telefone'] ?? '';
    $login        = $_POST['login'] ?? '';
    $senha        = $_POST['senha'] ?? '';
    $nivel_acesso = $_POST['nivel_acesso'] ?? '';

    // Validação obrigatória dos campos (Senha é obrigatória apenas se for um novo cadastro)
    if (empty($nome) || empty($email) || empty($login) || empty($nivel_acesso) || (empty($id) && empty($senha))) {
        $mensagem = "<div class='alert alert-danger'>Todos os campos (exceto telefone) são obrigatórios!</div>";
    } else {
        // Monta o vetor de dados estruturado para a db.class
        $dados = [
            'nome'         => $nome,
            'email'        => $email,
            'telefone'     => $telefone,
            'login'        => $login,
            'nivel_acesso' => $nivel_acesso
        ];

        // Se uma nova senha foi digitada, gera o hash seguro antes de salvar
        if (!empty($senha)) {
            $dados['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        }

        if (empty($id)) {
            // Se o ID estiver vazio, cria um novo registro usando store()
            $db->store($dados);
            $mensagem = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
            
            // Limpa as variáveis para novos cadastros
            $nome = $email = $telefone = $login = $senha = $nivel_acesso = ""; 
        } else {
            // Se o ID existir, atualiza o registro existente usando update()
            $db->update($id, $dados);
            $mensagem = "<div class='alert alert-success'>Usuário atualizado com sucesso!</div>";
        }
    }
}
?>

<body>
<header>
    <button class="btn btn-primary position-fixed" style="left: 20px; top: 50%; transform: translateY(-50%); z-index: 1030;" onclick="history.back()">&larr; Voltar
    </button>
</header>
</body>

<div class="container mt-4">
    <h2><?= $id ? "Editar Usuário" : "Novo Usuário" ?></h2>
    <?= $mensagem; ?>
    
    <form action="UsuarioForm.php" method="POST" class="mt-3">
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

        <div class="mb-3">
            <label class="form-label">Nível de Acesso:</label>
            <select name="nivel_acesso" class="form-select">
                <option value="">Selecione...</option>
                <option value="cliente" <?= $nivel_acesso === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                <option value="funcionario" <?= $nivel_acesso === 'funcionario' ? 'selected' : '' ?>>Funcionário</option>
                <option value="admin" <?= $nivel_acesso === 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar Usuário</button>
        <a href="UsuarioList.php" class="btn btn-secondary">Ver Listagem</a>
    </form>
</div>

<?php 
//include '../../footer.php'; 
?>