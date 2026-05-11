<?php
include '../header.php';
include '../database/db.class.php';

$db = new db('aluno');

 if (!empty($_POST)) {
    $db->store($_POST);
 }
 ?>

 <form action = "UsuarioForm.php" method="post">
    <h3>Form User</h3>
    <div class='col-6'>
    <label for ='nome'>Nome</label>
</div>
 </form>