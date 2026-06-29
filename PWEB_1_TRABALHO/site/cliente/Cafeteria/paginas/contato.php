<?php
include __DIR__ . '/../../../../header.php';
include __DIR__ . '/../../../admin/database/db.class.php';

$db = new db('avaliacao');
$dbProduto = new db('produto');

$mensagem_sucesso = '';
$mensagem_erro    = '';

$id         = null;
$produto_id = '';
$nota       = '';
$comentario = '';

if (!empty($_GET['editar'])) {
    $av = $db->find((int) $_GET['editar']);
    if ($av) {
        $id         = $av->id;
        $produto_id = $av->produto_id;
        $nota       = $av->nota;
        $comentario = $av->comentario;
    }
}

$lista_produtos = $dbProduto->all();
$produtosMap = [];
foreach ($lista_produtos as $p) {
    $produtosMap[$p->id] = $p;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_post    = !empty($_POST['id']) ? (int) $_POST['id'] : null;
    $produto_id = $_POST['produto_id'] ?? '';
    $nota       = $_POST['nota']       ?? '';
    $comentario = $_POST['comentario'] ?? '';
    $erros      = [];

    if (empty($produto_id)) $erros[] = "Selecione um produto.";
    if (empty($nota))       $erros[] = "Selecione uma nota.";

    if (empty($erros)) {
        $dados = [
            'pedido_id'  => 0,
            'produto_id' => (int) $produto_id,
            'nota'       => (int) $nota,
            'comentario' => !empty($comentario) ? $comentario : null,
        ];

        try {
            if ($id_post) {
                $db->update($id_post, $dados);
                $mensagem_sucesso = "Avaliação atualizada com sucesso!";
            } else {
                $db->store($dados);
                $mensagem_sucesso = "Avaliação enviada com sucesso! Obrigado pelo seu feedback.";
            }
            $id = null; $produto_id = ''; $nota = ''; $comentario = '';
        } catch (Exception $e) {
            $mensagem_erro = "Erro ao salvar: " . $e->getMessage();
        }
    } else {
        $mensagem_erro = implode('<br>', $erros);
    }
}

$avaliacoes = $db->all();
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contato - Café Grão de Ouro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css" />
    <style>
        .alert-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
    </style>
</head>
<body>

    <?php if ($mensagem_sucesso): ?>
        <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
            <strong>✓ Sucesso!</strong> <?= htmlspecialchars($mensagem_sucesso) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($mensagem_erro): ?>
        <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
            <strong>✗ Erro!</strong> <?= $mensagem_erro ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <header class="cabecalho">
        <nav class="navbar">
            <a href="../index.html">
                <img src="../../../admin/categoria/img/logo.jpg" alt="Logo" class="logo">
            </a>
            <div class="row">
                <div class="card" style="width: 18rem;">
                    <a href="./cafe.html">
                        <img src="../../../admin/categoria/img/produtos.jpeg" class="card-img-top cardimg" alt="Cardápio">
                        <span>Cardápio</span>
                    </a>
                    <div class="card-body"></div>
                </div>
                <div class="card" style="width: 18rem;">
                    <a href="./sobre.html">
                        <img src="../../../admin/categoria/img/sobrenos.png" class="card-img-top cardimg" alt="Sobre Nós">
                        <span>Sobre Nós</span>
                    </a>
                    <div class="card-body"></div>
                </div>
                <div class="card" style="width: 18rem;">
                    <a href="./contato.php">
                        <img src="../../../admin/categoria/img/telefone.jpeg" class="card-img-top cardimg" alt="Contato">
                        <span>Contato</span>
                    </a>
                    <div class="card-body"></div>
                </div>
            </div>
        </nav>
    </header>

    <main class="corpo">
        <article class="coments">

            <section class="formularios">
                <div class="formulario">
                    <h2 class="titulo-formulario">
                        <?= $id ? 'Editar Avaliação' : 'Avaliar Produto' ?>
                    </h2>

                    <form action="contato.php" method="POST">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="produto_id" class="form-label text-warning fw-bold">Produto *</label>
                            <select id="produto_id" name="produto_id" class="form-select bg-dark text-white border-warning" required>
                                <option value="">Escolha um produto do cardápio</option>
                                <?php foreach ($lista_produtos as $p): ?>
                                    <option value="<?= $p->id ?>" <?= (string)$p->id === (string)$produto_id ? 'selected' : '' ?>>
                                        [<?= htmlspecialchars($p->categoria) ?>] — <?= htmlspecialchars($p->nome) ?>
                                        (R$ <?= number_format($p->preco_unitario, 2, ',', '.') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nota" class="form-label text-warning fw-bold">Nota *</label>
                            <select id="nota" name="nota" class="form-select bg-dark text-white border-warning" required>
                                <option value="">Selecione uma nota</option>
                                <option value="5" <?= $nota == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐ (Excelente)</option>
                                <option value="4" <?= $nota == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐ (Muito Bom)</option>
                                <option value="3" <?= $nota == 3 ? 'selected' : '' ?>>⭐⭐⭐ (Bom)</option>
                                <option value="2" <?= $nota == 2 ? 'selected' : '' ?>>⭐⭐ (Regular)</option>
                                <option value="1" <?= $nota == 1 ? 'selected' : '' ?>>⭐ (Ruim)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="comentario" class="form-label text-warning fw-bold">Comentário</label>
                            <textarea id="comentario" name="comentario"
                                      class="form-control bg-dark text-white border-warning"
                                      rows="4"
                                      placeholder="Conte sobre sua experiência..."><?= htmlspecialchars($comentario ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-warning text-dark fw-bold">
                            <?= $id ? 'Salvar Alterações' : 'Enviar Avaliação' ?>
                        </button>
                        <?php if ($id): ?>
                            <a href="contato.php" class="btn btn-outline-secondary ms-2">Cancelar</a>
                        <?php endif; ?>
                    </form>

                    <hr class="mt-5">
                    <h3 class="titulo-formulario mt-4">Avaliações dos Clientes</h3>

                    <?php if (!empty($avaliacoes)): ?>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Nota</th>
                                        <th>Comentário</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($avaliacoes as $a):
                                        $prod = $produtosMap[$a->produto_id] ?? null;
                                        $nomeProd = $prod ? htmlspecialchars($prod->nome) : "Produto #{$a->produto_id}";
                                    ?>
                                    <tr>
                                        <td><?= $nomeProd ?></td>
                                        <td><?= str_repeat("⭐", $a->nota) ?></td>
                                        <td><?= htmlspecialchars($a->comentario ?? 'Sem comentário') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="mt-3">Nenhuma avaliação ainda. Seja o primeiro a avaliar!</p>
                    <?php endif; ?>
                </div>
            </section>

            <section class="mapas">
                <div class="mapa">
                    <h2 class="titulo-formulario">Localização</h2>
                    <iframe width="100%" height="100%"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=-52.60079294443131%2C-27.13799612309493%2C-52.59779959917069%2C-27.136616471356163&amp;layer=mapnik&amp;marker=-27.137306299353984%2C-52.599296271800995"
                        style="border: 1px solid black"></iframe>
                </div>
            </section>

        </article>
    </main>

    <footer class="footer">
        <nav class="footergrid">
            <div class="footeritem">
                <span class="footer-label">Contato</span>
                <span class="footer-valor">(49) 9 9999-9999</span>
            </div>
            <div class="linha">|</div>
            <div class="footeritem">
                <span class="footer-label">Instagram</span>
                <a href="https://instagram.com/graodeourocafe" class="footer-valor footer-link" target="_blank">@graodeourocafe</a>
            </div>
        </nav>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>