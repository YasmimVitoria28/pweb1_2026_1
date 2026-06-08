<?php
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';
$db = new db('produto');

$mensagem = "";

// Processar envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco_unitario = $_POST['preco_unitario'] ?? '';
    $categoria = $_POST['categoria'] ?? '';

    // Validação obrigatória do formulário
    if (empty($nome) || empty($preco_unitario) || empty($categoria)) {
        $mensagem = "<div class='alert alert-danger'>Todos os campos são obrigatórios!</div>";
    } else {
        $dados = [
            'nome' => $nome,
            'preco_unitario' => $preco_unitario,
            'categoria' => $categoria
        ];
        
        $db->store($dados);
        $mensagem = "<div class='alert alert-success'>Produto cadastrado com sucesso!</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Cadastrar Produto (Cardápio)</h2>
    <?= $mensagem; ?>
    <form action="ProdutosForm.php" method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Nome do Produto:</label>
            <input type="text" name="nome" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Preço Unitário (R$):</label>
            <input type="number" step="0.01" name="preco_unitario" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Categoria:</label>
            <select name="categoria" class="form-select">
                <option value="">Selecione...</option>
                <option value="Cafés">Cafés</option>
                <option value="Salgados">Salgados</option>
                <option value="Doces e Tortas">Doces e Tortas</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar Produto</button>
        <a href="ProdutoList.php" class="btn btn-secondary">Ver Listagem</a>
    </form>
</div>

<?php 
//include '../footer.php';
 ?>