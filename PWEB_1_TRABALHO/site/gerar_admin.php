<?php
// Configurações de acesso ao seu banco de dados
$host = "localhost";
$banco = "cafeteria";
$usuario = "root";
$senha = "";

try {
    // Conexão nativa via PDO
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Remove qualquer registro antigo para evitar erro de duplicidade (coluna UNIQUE)
    $stmtDelete = $pdo->prepare("DELETE FROM usuario WHERE login = 'admin' OR email = 'admin@email.com'");
    $stmtDelete->execute();

    // 2. Prepara os dados do administrador
    $nome = 'Administrador Geral';
    $telefone = '49999999999';
    $email = 'admin@email.com';
    $login = 'admin';
    // O próprio PHP da sua máquina gera o hash da senha '123' agora mesmo
    $senha_hash = password_hash('123', PASSWORD_BCRYPT); 
    $nivel_acesso = 'admin';

    // 3. Query nativa de inserção na tabela 'usuario'
    $sql = "INSERT INTO usuario (nome, telefone, email, login, senha, nivel_acesso) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmtInsert = $pdo->prepare($sql);
    $stmtInsert->execute([$nome, $telefone, $email, $login, $senha_hash, $nivel_acesso]);

    echo "<div style='font-family: Arial, sans-serif; padding: 20px; max-width: 500px; margin: 40px auto; border: 1px solid #d4edda; background-color: #d4edda; color: #155724; border-radius: 5px;'>";
    echo "<h2 style='margin-top: 0;'>🎉 Admin Criado com Sucesso!</h2>";
    echo "<p>O usuário foi injetado de forma nativa e a senha está perfeitamente sincronizada.</p>";
    echo "<hr style='border-top: 1px solid #c3e6cb;'>";
    echo "<p><strong>E-mail para o login:</strong> admin@email.com</p>";
    echo "<p><strong>Senha:</strong> 123</p>";
    echo "<a href='login.php' style='display: inline-block; padding: 8px 15px; background-color: #155724; color: white; text-decoration: none; border-radius: 3px; margin-top: 10px;'>Ir para o Login</a>";
    echo "</div>";

} catch (PDOException $e) {
    echo "<div style='font-family: Arial, sans-serif; padding: 20px; max-width: 500px; margin: 40px auto; border: 1px solid #f8d7da; background-color: #f8d7da; color: #721c24; border-radius: 5px;'>";
    echo "<h2 style='margin-top: 0;'>❌ Erro no Banco de Dados:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}