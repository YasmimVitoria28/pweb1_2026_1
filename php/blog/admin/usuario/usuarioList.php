<?php
include '../header.php';
include '../database/db.class.php';

$db = new db('aluno');

 if (!empty($_POST)) { //$_POST é um vetor dos elementos do formulário se o método for GET -> $_POST e assim por diante.
   var_dump($_POST); //método de saída para ver os dados de um vetor no objeto
   exit;
    $db->store($_POST);
 } else{
   $dados = $db->all();
 }

 ?>
<div class="row">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">CPF</th>
      <th scope="col">Telefone</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>
    <?php
        foreache($dados as $item) {
            echo "<tr>
      <th scope='row'>$item</th>
      <td>$item->nome</td>
      <td>$item->telefone</td>
      <td>$item->email</td>
    </tr>"
        }
  </tbody>
</table>
</div>
 