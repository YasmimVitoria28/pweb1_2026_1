<?php
include './header.php';
include './database/db.class.php';

$db = new db('usuario');
$success = ' ';
$actionError = ' ';
$errors = [];
$data = ' ';

if(!empty($_GET['id'])){
   $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {
   $data = (object) $_POST;

   try{

      if(empty($_POST['nome'])){
         $errors[] = "<li>O nome é obrigatório</li>";
      }
      if(empty($_POST['email'])){
         $errors[] = "<li>O email é obrigatório</li>";
      }
      if(empty($_POST['senha'])){
         $errors[] = "<li>A senha é obrigatória</li>";
      } else {
         if(strlen($_POST['senha']) < 3){
            $errors[] = "<li>A senha deve ter no mínimo 3 caracteres</li>";
         }
      }

      if(empty($errors)){

         $dado = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'telefone' => $_POST['telefone'] ? $_POST['telefone'] : "",
            'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
         ];

         if(empty($_POST['id'])){
            $db->store($dado);
            $success = "Usuário cadastrado com sucesso!";
         } else {
            $db->update($_POST['id'], $dado);
            $success = "Usuário atualizado com sucesso!";
         }

         redirect('./login.php');
      }
      
   }
   catch (Exception $e){
      $actionError = $e->getMessage();
   }
}
?>

<div class="row">

   <?php actionMessage($success, $actionError); ?>
   <?php showValidationError($errors); ?>
      
   <form action="UsuarioForm.php" method="post">
      <h3>Registrar usuário</h3>
      <input type="hidden" name="id" value="<?php echo getFormValue($data, 'id'); ?>">

      <div class="col-6">
         <label for="nome">Nome</label>
         <input type="text" name="nome" class="form-control" value="<?php echo getFormValue($data, 'nome'); ?>">
      </div>

      <div class="col-6">
         <label for="email">E-mail</label>
         <input type="text" name="email" class="form-control" value="<?php echo getFormValue($data, 'email'); ?>">
      </div>

      <div class="col-6">
         <label for="telefone">Telefone</label>
         <input type="number" name="telefone" class="form-control" value="<?php echo getFormValue($data, 'telefone'); ?>">
      </div>

      <div class="col-6">
         <label for="senha">Senha</label>
         <input type="password" name="senha" class="form-control" value="<?php echo getFormValue($data, 'senha'); ?>">
      </div>

      <div class="col mt-2">
         <button type="submit" class="btn btn-success">Salvar</button>Já tem uma conta? <a href="login.php" class="btn btn-primary">Faça login aqui</a>
      </div>
   </form>

</div>

<?php
//include './footer.php';
?>