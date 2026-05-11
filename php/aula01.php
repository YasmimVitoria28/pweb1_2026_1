<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $nome= "Eduarda";
        $idade= 23;
        echo "Nome: $nome, Idade:  $idade";

        echo "<br>";

        if ($idade>= 23){
            echo "abc";
        }
        else {
            echo"def";
        }
////////////////////////////////////////////////////////////////////
//      VETORES COM NÚMEROS

        $notas = [5,6,7,8,9];
        echo"<br>";

        for ($i = 0; $i < count($notas); $i++){ // 1 maneira de fazer FOR
            echo $notas[$i] . "<br>";
        }
            echo "<br>";
////////////////////////////////////////////////////////////////////
        foreach ($notas as $item){ //2 maneira de fazer FOR (mais agil), pega o número de itens da lista e roda
            echo $item . "<br>";
        }


////////////////////////////////////////////////////////////////////
//      VETORES COM STRING

        $nomes = ["Maria", "Eduarda", "Yasmim", "Vitoria"];
        echo"<br>";

        for ($i = 0; $i < count($nomes); $i++){ // 1 maneira de fazer FOR
            echo $nomes[$i] . "<br>";
        }
            echo "<br>";
////////////////////////////////////////////////////////////////////
        foreach ($nomes as $item){ //2 maneira de fazer FOR (mais agil), pega o número de itens da lista e roda
            echo $item . "<br>";
        }
        
///////////////////////////////////////////////////////////////////
        echo"<br>";
        $carro = ["modelo"=>"Mustang", "cor"=>"Red", "ano"=>1976 ];
            echo $carro['modelo'] ."-" .$carro['cor'];
            
            echo "<br>";

///////////////////////////////////////////////////////////////////
            echo"<br>";
        $carros =[
                ["modelo"=>"Mustang", "cor"=>"Red", "ano"=>1976 ],
                ["modelo"=>"Del Rey", "cor"=>"Branco", "ano"=>1980 ],
                ];

                echo $carros[0] ['modelo'] ."-" .$carros[0]['cor'];
                echo "<br>";

        foreach ($carros as $carro) {
                echo "<br>";
        foreach ($carro as $item) {
                echo "Modelo:" .$item['modelo'] ."Ano" .$item['ano'];
            };
        }
            echo "<br>";

///////////////////////////////////////////////////////////////////
 echo"<br>";
        $carros =[
                ["modelo"=>"Mustang", "cor"=>"Red", "ano"=>1976 ],
                ["modelo"=>"Del Rey", "cor"=>"Branco", "ano"=>1980 ],
                ];

                echo $carros[0] ['modelo'] ."-" .$carros[0]['cor'];
                echo "<br>";

        foreach ($carros as $carro) {
                echo "<br>";
        foreach ($carro as $item) {
                echo "Modelo:" .$item['modelo'] ."Ano" .$item['ano'];
            };
        }
            echo "<br>";

    ?>

    <p> Meu site Mustang Red <?= $carro['modelo'] . "- Ano:" . $carro['ano'] ?> </p>
</body>
</html>