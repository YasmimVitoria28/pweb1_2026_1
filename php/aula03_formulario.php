<?php
include'./header.php';
?>

<form action="resultadoFormAluno.php" method="get">
    <div class="col-6">
        <label for="nome">Nome</label>
        <input type="text" name="nome" class="form-control">
    </div>
    <div class="col-6">
        <label for="email">Email</label>
        <input type="text" name="email" class="form-control">
    </div>

    <div class="mt">
        <button type="submit" class="btn btn-primary"></button>
    </div>
</form>

<?php
include './footer.php';
?>