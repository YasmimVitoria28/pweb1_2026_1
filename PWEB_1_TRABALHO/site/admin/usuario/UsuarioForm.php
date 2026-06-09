<?php
// O header sempre deve ser o primeiro para carregar as funções e a sessão
include __DIR__ . '/../../../header.php';
include '../database/db.class.php';

$db = new db('usuario');
$success = ' ';
$actionError = ' ';
$erros = []; 

if (!empty($_POST)) {
   try {
      if(empty($_POST['nome'])){
         $erros[] = "<li>O nome é obrigatório</li>";
      }
      if(empty($_POST['email'])){
         $erros[] = "<li>O email é obrigatório</li>";
      }

      if(empty($erros)){
         $db->store($_POST);
         $success = "Registro Salvo com Sucesso!"; 
         redirect('./UsuarioList.php'); 
      }
      
   }
   catch (Exception $e){
      $actionError = $e->getMessage();
   }

}
?>

<div class="row">

   <?php actionMessage($success, $actionError); ?>
   <?php showValidationError($erros); ?>
      
   <form action="UsuarioForm.php" method="post">
      
      <div class="col-6 mb-2">
         <label for="nome">Nome</label>
         <input type="text" name="nome" class="form-control" value="<?php echo getFormValue($_POST, 'nome'); ?>">
      </div>

      <div class="col-6 mb-2">
         <label for="email">E-mail</label>
         <input type="text" name="email" class="form-control" value="<?php echo getFormValue($_POST, 'email'); ?>">
      </div>

      <div class="col-6 mb-2">
         <label for="telefone">Telefone</label>
         <input type="text" name="telefone" class="form-control" value="<?php echo getFormValue($_POST, 'telefone'); ?>">
      </div>

      <div class="col-6 mb-2">
         <label for="senha">Senha</label>
         <input type="password" name="senha" class="form-control" value="<?php echo getFormValue($data, 'senha'); ?>">
      </div>

      <div class="col-6 mb-2">
         <label for="nome">Login</label>
         <input type="text" name="nome" class="form-control" value="<?php echo getFormValue($_POST, 'login'); ?>">
      </div>

      <div class="col mt-3">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="./UsuarioList.php" class="btn btn-primary"> Voltar </a>
      </div>

   </form>

</div>
<?php
//include '../../footer.php';
?>