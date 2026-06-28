<?php
include './header.php';
include './database/db.class.php';

$db = new db('usuario');

$success = ' ';
$actionError = ' ';
$erros = []; // Unificado para português: $erros
$data = '';

if(!empty($_GET['id'])) {
   $data = $db->find($_GET['id']);
}

if(!empty($_POST)) {
   $data = (object) $_POST;
}

if (!empty($_POST)) {
   try {
      if(empty($_POST['email'])){
         $erros[] = "<li>O email é obrigatório</li>";
      }

      // Ajustada a lógica: se estiver vazio, acusa erro. Se NÃO estiver vazio, valida a quantidade de caracteres.
      if(empty($_POST['senha'])){
         $erros[] = "<li>A senha é obrigatória</li>";
      } else {
         if(strlen($_POST['senha']) < 3){
            $erros[] = "<li>A senha deve ter no mínimo 3 caracteres</li>";
         }
      }

      // Corrigido para verificar a variável correta ($erros)
      if(empty($erros)){
         $usuario = $db->findBy('email', $_POST['email']);

         if($usuario && password_verify($_POST['senha'], $usuario->senha)){
            $_SESSION['usuario_id'] = $usuario->id;
            $_SESSION['usuario_nome'] = $usuario->nome;
            $_SESSION['usuario_email'] = $usuario->email;

            $success = "Logado com sucesso!"; // Corrigido de $sucess para $success
            redirect('index.php'); 
         } else {
            $erros[] = "<li>E-mail ou senha incorretos.</li>";
         }
      }
      
   }
   catch (Exception $e){
      $actionError = $e->getMessage();
   }
   // Removido o segundo bloco catch duplicado que gerava erro fatal
}
?>

<div class="row">

   <?php actionMessage($success, $actionError); ?>
   <?php showValidationError($erros); // Corrigido para passar $erros ?>
      
   <form action="login.php" method="post">
      <h3>Login Usuário</h3>      

      <div class="col-6 mb-2">
         <label for="email">E-mail</label>
         <input type="text" name="email" class="form-control" value="<?php echo getFormValue($data, 'email'); ?>">
      </div>

      <div class="col-6 mb-2">
         <label for="senha">Senha</label>
         <input type="password" name="senha" class="form-control" value="<?php echo getFormValue($data, 'senha'); ?>">
      </div>

      <div class="col mt-2">
            <button type="submit" class="btn btn-success">Logar</button>
            <a href="./registrar.php" class="btn btn-primary">Crie aqui</a>
      </div>
   </form>

</div>

<?php
?>