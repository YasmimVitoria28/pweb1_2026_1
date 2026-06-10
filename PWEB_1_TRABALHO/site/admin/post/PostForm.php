<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';
$db = new db('pedidos');

$mensagem = "";
$id = "";
$numero_pedido = "";
$nome_cafe = "";
$valor_total = "";

// Carregar dados para edição
if (!empty($_GET['editar'])) {
    $ped = $db->find($_GET['editar']);
    if ($ped) {
        $id           = $ped->id;
        $numero_pedido = $ped->numero_pedido;
        $nome_cafe    = $ped->nome_cafe;
        $valor_total  = $ped->valor_total;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id            = $_POST['id'] ?? '';
    $numero_pedido = $_POST['numero_pedido'] ?? '';
    $nome_cafe     = $_POST['nome_cafe'] ?? '';
    $valor_total   = $_POST['valor_total'] ?? '';

    if (empty($numero_pedido) || empty($nome_cafe) || empty($valor_total)) {
        $mensagem = "<div class='alert alert-danger'>Todos os campos são obrigatórios!</div>";
    } else {
        $dados = [
            'numero_pedido' => $numero_pedido,
            'nome_cafe'     => $nome_cafe,
            'valor_total'   => $valor_total
        ];

        if (empty($id)) {
            $db->store($dados);
            $mensagem = "<div class='alert alert-success'>Pedido cadastrado com sucesso!</div>";
        } else {
            $db->update($id, $dados);
            $mensagem = "<div class='alert alert-success'>Pedido atualizado com sucesso!</div>";
        }
    }
} 
?>
<body>
<header>
    <button class="btn btn-primary position-fixed" style="left: 20px; top: 50%; transform: translateY(-50%); z-index: 1030;" onclick="history.back()"><!--voltar tela anterior-->
        &larr; Voltar
    </button>
</header>
</body>
<div class="container mt-4">
    <h2><?= $id ? "Editar Pedido" : "Novo Pedido" ?></h2>
    <?= $mensagem; ?>
    <form action="PostForm.php" method="POST" class="mt-3">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="mb-3">
            <label class="form-label">Número do Pedido / Comanda:</label>
            <input type="number" name="numero_pedido" class="form-control" value="<?= htmlspecialchars($numero_pedido) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Nome do Café / Produto:</label>
            <input type="text" name="nome_cafe" class="form-control" value="<?= htmlspecialchars($nome_cafe) ?>" placeholder="Ex: Latte de Pistache">
        </div>

        <div class="mb-3">
            <label class="form-label">Valor Total (R$):</label>
            <input type="number" step="0.01" name="valor_total" class="form-control" value="<?= htmlspecialchars($valor_total) ?>">
        </div>

        <button type="submit" class="btn btn-success">Salvar Pedido</button>
        <a href="PostList.php" class="btn btn-secondary">Ver Listagem</a>
    </form>
</div>

<?php 

//include '../footer.php'; 
?>