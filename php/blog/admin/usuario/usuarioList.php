<?php
include '../header.php';
include '../database/db.class.php';

// Criando a instância da tabela aluno
$db = new db('usuario');

// CORRIGIDO: Retirado de dentro do if($_POST). Agora carrega os dados sempre!
$dados = $db->all(); 
?>

<div class="container mt-4">
    <div class="row mb-3">
        <div class="col">
            <a href="./UsuarioForm.php" class="btn btn-success"> Novo </a>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">E-mail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Agora $dados sempre existirá, evitando o erro no foreach
                if (!empty($dados)) {
                    foreach($dados as $item){
                        // CORRIGIDO: Adicionado o <tr> no início do echo para abrir a linha da tabela
                        echo "<tr>
                            <th scope='row'>$item->id</th>
                            <td>$item->nome</td>
                            <td>$item->telefone</td>
                            <td>$item->email</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Nenhum registro encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
//include '../../footer.php';
?>