<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';

$db = new db('produto');

$mensagem = "";
$id = "";
$nome = "";
$preco_unitario = "";
$categoria = "";

//  find()
if (!empty($_GET['editar'])) {
    $p = $db->find($_GET['editar']);
    if ($p) {
        $id             = $p->id;
        $nome           = $p->nome;
        $preco_unitario = $p->preco_unitario;
        $categoria      = $p->categoria;
    }
}

//envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id             = $_POST['id'] ?? '';
    $nome           = $_POST['nome'] ?? '';
    $preco_unitario = $_POST['preco_unitario'] ?? '';
    $categoria      = $_POST['categoria'] ?? '';

    if (empty($nome) || empty($preco_unitario) || empty($categoria)) {
        $mensagem = "<div class='alert alert-danger'>Todos os campos são obrigatórios!</div>";
    } else {
        // Monta o vetor de dados estruturado para a db.class
        $dados = [
            'nome'           => $nome,
            'preco_unitario' => $preco_unitario,
            'categoria'      => $categoria
        ];

        if (empty($id)) {
            // Se o ID estiver vazio, cria um novo registro usando store()
            $db->store($dados);
            $mensagem = "<div class='alert alert-success'>Produto cadastrado com sucesso!</div>";
            
            // Limpa as variáveis para novos cadastros
            $nome = $preco_unitario = $categoria = ""; 
        } else {
            // Se o ID existir, atualiza o registro existente usando update()
            $db->update($id, $dados);
            $mensagem = "<div class='alert alert-success'>Produto atualizado com sucesso!</div>";
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
    <h2><?= $id ? "Editar Produto" : "Novo Produto (Cardápio)" ?></h2>
    <?= $mensagem; ?>
    
    <form action="ProdutosForm.php" method="POST" class="mt-3">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="mb-3">
            <label class="form-label">Nome do Produto:</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nome) ?>" placeholder="Ex: Capuccino Italiano">
        </div>

        <div class="mb-3">
            <label class="form-label">Preço Unitário (R$):</label>
            <input type="number" step="0.001" name="preco_unitario" class="form-control" value="<?= htmlspecialchars($preco_unitario) ?>" placeholder="0.00">
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria:</label>
            <select name="categoria" class="form-select">
                <option value="">Selecione...</option>
                <option value="Cafés" <?= $categoria === 'Cafés' ? 'selected' : '' ?>>Cafés</option>
                <option value="Salgados" <?= $categoria === 'Salgados' ? 'selected' : '' ?>>Salgados</option>
                <option value="Doces e Tortas" <?= $categoria === 'Doces e Tortas' ? 'selected' : '' ?>>Doces e Tortas</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar Produto</button>
        <a href="ProdutoList.php" class="btn btn-secondary">Ver Listagem</a>
    </form>
</div>

