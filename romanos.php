<html>
<body>
<?php
$romanos = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1);

function converte($romano1) {
    $romanos = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    );
    $result = 0;

foreach ($romanos as $key => $valor) {
    while (strpos($romano1, $key) === 0) {
        $result += $valor;
        $romano1 = substr($romano1, strlen($key));
    }
}
return $result;
}



    if(!preg_match("(^(?=[MDCLXVI])M*(C[MD]|D?C{0,3})(X[CL]|L?X{0,3})(I[XV]|V?I{0,3})$)", $_POST[1])){
            echo "<h1>";
            echo 'ERRO';
            echo "</h1>";
        return false;
    }
    

else{
$total = converte($_POST[1]);
for ($i = 1; $i< 11; $i++){
    $numero = $_POST;

            if ($numero['operador'.$i] == "+") {
                    $b = converte($numero[$i+1]);
                    $total += $b;
                };
            if ($numero['operador'.$i] == "-") {
                    $c= converte($numero[$i+1]);
                    $total -= $c;
                };
            if ($numero['operador'.$i] == "*") {
                    $d= converte($numero[$i+1]);
                    $total *= $d;
                };
            if ($numero['operador'.$i] == "/") {
                    $e= converte($numero[$i+1]);
                    $total /= $e;
                };

        }
        echo '<h1>'.intval($total).'</h1>';
        echo '<br>';

echo '<br>';
    }
    
?>
</body>
</html>
