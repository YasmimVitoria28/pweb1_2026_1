<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensagem_sucesso = $_SESSION['mensagem_sucesso'] ?? '';
$mensagem_erro = $_SESSION['mensagem_erro'] ?? '';

unset($_SESSION['mensagem_sucesso']);
unset($_SESSION['mensagem_erro']);
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
        body { color: #D4A35D; }
        h2, h3, .form-label, .footer-label, .text-muted, p strong { color: #D4A35D !important; }

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
        .btn-enviar { transition: all 0.3s ease; }
        .btn-enviar:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <?php if ($mensagem_sucesso): ?>
        <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert" id="alerta-sucesso">
            <strong>✓ Sucesso!</strong> <?= htmlspecialchars($mensagem_sucesso) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <?php if ($mensagem_erro): ?>
        <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert" id="alerta-erro">
            <strong>✗ Erro!</strong> <?= htmlspecialchars($mensagem_erro) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <header class="cabecalho">
        <nav class="navbar">
            <a href="../index.html">
                <img src="../img/logo.jpg" alt="Logo" class="logo">
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
                    <h2 class="titulo-formulario">Avaliar Produto</h2>

                    <form action="avaliacao/avaliacaoForm.php" method="POST">
                        <input type="hidden" name="acao" value="salvar">
                        <input type="hidden" name="token" value="<?= session_id() ?>">
                        <input type="hidden" name="redirect" value="<?= htmlspecialchars('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>">

                        <div class="mb-3">
                            <label for="pedido_id" class="form-label">Código do Pedido *</label>
                            <input type="number" id="pedido_id" name="pedido_id" class="form-control" placeholder="Ex: 101" min="1" required>
                            <small class="text-muted">Informe o número do seu pedido</small>
                        </div>

                        <div class="mb-3">
                            <label for="produto_id" class="form-label">Código do Produto *</label>
                            <input type="number" id="produto_id" name="produto_id" class="form-control" placeholder="Ex: 5" min="1" required>
                            <small class="text-muted">Código do produto que deseja avaliar</small>
                        </div>

                        <div class="mb-3">
                            <label for="nota" class="form-label">Nota (1 a 5) *</label>
                            <select id="nota" name="nota" class="form-select" required>
                                <option value="">Selecione uma nota</option>
                                <option value="5">⭐⭐⭐⭐⭐ (Excelente)</option>
                                <option value="4">⭐⭐⭐⭐ (Muito Bom)</option>
                                <option value="3">⭐⭐⭐ (Bom)</option>
                                <option value="2">⭐⭐ (Regular)</option>
                                <option value="1">⭐ (Ruim)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="comentario" class="form-label">Comentário</label>
                            <textarea id="comentario" name="comentario" class="form-control" rows="4"
                                      placeholder="Conte-nos sua experiência com o produto..."
                                      maxlength="500"></textarea>
                            <small class="text-muted">Máximo de 500 caracteres</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-enviar">Enviar Avaliação</button>
                            <a href="./avaliacao/avaliacaoList.php" class="btn btn-outline-secondary d-flex align-items-center">Ver Avaliações</a>
                            <button type="reset" class="btn btn-outline-danger">Limpar</button>
                        </div>
                    </form>
                </div>
            </section>

            <section class="mapas">
                <div class="mapa">
                    <h2 class="titulo-formulario">Nossa Localização</h2>
                    <div class="info-contato mb-3">
                        <p><strong>📍 Endereço:</strong> Rua das Flores, 123 - Centro</p>
                        <p><strong>📞 Telefone:</strong> (49) 9 9999-9999</p>
                        <p><strong>⏰ Horário de Funcionamento:</strong> Seg-Sex: 08h às 18h | Sáb: 08h às 12h</p>
                    </div>
                    <iframe
                        width="100%"
                        height="300"
                        style="border: 1px solid #ddd; border-radius: 8px;"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=-52.60079294443131%2C-27.13799612309493%2C-52.59779959917069%2C-27.136616471356163&amp;layer=mapnik&amp;marker=-27.137306299353984%2C-52.599296271800995"
                        allowfullscreen>
                    </iframe>
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
                <a href="https://instagram.com/graodeourocafe" class="footer-valor footer-link" target="_blank" rel="noopener noreferrer">@graodeourocafe</a>
            </div>
            <div class="linha">|</div>
            <div class="footeritem">
                <span class="footer-label">Email</span>
                <span class="footer-valor">contato@graodeouro.com.br</span>
            </div>
        </nav>
        <div class="text-center mt-3">
            <small>&copy; 2026 Café Grão de Ouro - Todos os direitos reservados</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const alertaSucesso = document.getElementById('alerta-sucesso');
        const alertaErro = document.getElementById('alerta-erro');
        
        if(alertaSucesso) {
            setTimeout(() => bootstrap.Alert.getOrCreateInstance(alertaSucesso).close(), 5000);
        }
        if(alertaErro) {
            setTimeout(() => bootstrap.Alert.getOrCreateInstance(alertaErro).close(), 5000);
        }
    </script>

</body>
</html>