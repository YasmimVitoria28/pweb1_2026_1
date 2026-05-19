<?php
include '../header.php';
include '../database/db.class.php';

$db = new db('aluno');

 if (!empty($_POST)) { //$_POST é um vetor dos elementos do formulário se o método for GET -> $_POST e assim por diante.
   var_dump($_POST); //método de saída para ver os dados de um vetor no objeto
   exit;
    $db->store($_POST);
 }
 ?>

 <form action = "UsuarioForm.php" method="post">
    <h3>Form User</h3>
    <div class='col-6'>
    <label for ='nome'>Nome</label>
</div>
 </form>

 <?php
 include '../footer.php';
 ?>