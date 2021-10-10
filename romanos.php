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


for ($i = 1; $i< 11; $i++){
    if(converte($_POST[$i]) != $romanos['M'] &&  converte($_POST[$i]) != $romanos['CM'] && converte($_POST[$i]) != $romanos['D'] && converte($_POST[$i]) != $romanos['CD'] && converte($_POST[$i]) != $romanos['C']&& converte($_POST[$i]) != $romanos['XC'] && converte($_POST[$i]) != $romanos['L']&& converte($_POST[$i]) != $romanos['XL'] && converte($_POST[$i]) != $romanos['X']&& converte($_POST[$i]) != $romanos['IX'] && converte($_POST[$i]) != $romanos['V'] && converte($_POST[$i]) != $romanos['IV'] && converte($_POST[$i]) != $romanos['I']){
                    echo "</h1>";
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
    }
?>
</body>
</html>
