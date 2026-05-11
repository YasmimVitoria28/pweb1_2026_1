<?php

include_once './database/db.class.php';


//instanciar um objt da classe DB

$conn = new db("aluno");

$dados = [
    'nome' => "Yasmim",
    'telefone' => "49998346409",
    'email' => "yasmim.vsr07@aluno.ifsc.edu.br",
];

$conn->store($dados);
echo "dados inseridos com sucesso";


