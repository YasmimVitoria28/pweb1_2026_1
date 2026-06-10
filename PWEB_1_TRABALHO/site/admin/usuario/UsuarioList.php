<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';

// ==========================================
// MÉTODO EXCLUIR (IGUAL AO AVALIACAOlist.PHP)
// ==========================================
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $host = "localhost";
    $banco = "cafeteria";
    $usuario = "root";
    $senha = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $id = (int) $_GET['id'];
        
        // Executa a exclusão na tabela correta (usuario)
        $stmtDelete = $pdo->prepare("DELETE FROM usuario WHERE id = ?");
        $stmtDelete->execute([$id]);
        
        // Redireciona de volta com uma mensagem de sucesso
        header("Location: UsuarioList.php?sucesso=" . urlencode("Usuário removido com sucesso!"));
        exit;
    } catch (PDOException $e) {
        die("Erro ao excluir usuário: " . $e->getMessage());
    }
}

// Criando a instância da tabela usuario
$db = new db('usuario');
$dados = $db->all(); 
?>

<body>
<header>
    <button class="btn btn-primary position-fixed" style="left: 20px; top: 50%; transform: translateY(-50%); z-index: 1030;" onclick="history.back()"><!--voltar tela anterior-->
        &larr; Voltar
    </button>
</header>
</body>


<div class="container mt-4">
    <div class="row mb-3">
        <div class="col">
            <a href="./UsuarioForm.php" class="btn btn-success"> Novo Usuário </a>
        </div>
    </div>

    <?php if (!empty($_GET['sucesso'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['sucesso']) ?></div>
    <?php endif; ?>

    <div class="table-responsive bg-white p-3 border rounded shadow-sm">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Nível de acesso</th>
                    <th scope="col">Login</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dados)): ?>
                    <?php foreach($dados as $item): ?>
                        <tr>
                            <th scope="row"><?= $item->id ?></th>
                            <td><?= htmlspecialchars($item->nome) ?></td>
                            <td><?= htmlspecialchars($item->telefone ?? 'Não informado') ?></td>
                            <td><?= htmlspecialchars($item->email) ?></td>
                            <td><?= htmlspecialchars($item->nivel_acesso ?? 'Usuário') ?></td>
                            <td><?= htmlspecialchars($item->login ?? '-') ?></td>
                            <td class="text-center">
                                <a href="UsuarioForm.php?editar=<?= $item->id ?>" class="btn btn-sm btn-warning">Editar</a>
                                
                                <a href="UsuarioList.php?action=delete&id=<?= $item->id ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Excluir este usuário definitivamente?')">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">Nenhum registro encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
//include '../../footer.php';
?>