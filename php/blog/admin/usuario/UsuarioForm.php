<?php
include '../header.php';
include '../database/db.class.php';

$db = new db('usuario');
$success = ' ';
$actionError = ' ';
$erros = [];

 if (!empty($_POST)) {
   //var_dump($_GET);
   //exit;

   try{

      if(empty($_POST['nome'])){
         $erros[] = "<li>O nome é pbrgatório</li>";
      }
      if(empty($_POST['email'])){
         $erros[] = "<li>O email é pbrgatório</li>";
      }

      if(empty($errors)){
         $db->store($_POST);
         $sucess = "Registro Salvo com Successo!";   
      }
      
      
      //redirect(./UsuarioList.php)
   }
   catch (Exception $e){
      $actionError = $e->getMessage();
   }
   catch (Exception $e){
      $actionError = $e->getMessage();
   }
   


   
 }
 ?>

   <div class="row">

   <?php actionMessage($success, $actionError) ?>
   <?php showValidationError($errors)?>
      
      <form action="UsuarioForm.php" method="post">
         <div class="col-6">
            <label for="nome">Nome</label>
            <input type="text" name="nome" class="form-control" value="<?php echo getFormValue('nome'); ?>">
         </div>

         <div class="col-6">
            <label for="email">E-mail</label>
            <input type="text" name="email" class="form-control value="<?php echo getFormValue('email'); ?>"">
         </div>

         <div class="col-6">
            <label for="telefone">Telefone</label>
            <input type="number" name="telefone" class="form-control value="<?php echo getFormValue('telefone'); ?>"">
         </div>

         <div class="col mt-2">
               <button type="submit" class="btn btn-success">Salvar</button>
               <a href="./UsuarioList.php" class="btn btn-primary"> Voltar </a>
         </div>


      </form>

   </div>


<?php
include './php/footer.php';
?>