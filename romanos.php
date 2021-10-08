<html>
<body>
<?php
// var_dump($_POST);
// echo "<br>";
// echo "<br>";
# '/^M{0,3}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/' pattern

$numeros = array($_POST);
$operadores = array(
    $_POST['operador1'], $_POST['operador2'], $_POST['operador3'], $_POST['operador4'], $_POST['operador5'], $_POST['operador6'], $_POST['operador7'], $_POST['operador8'], $_POST['operador9'], $_POST['operador10']
);

function converte($key) {
    $romano1 = $_POST["1"];
    $romano2 = $_POST['2'];
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

$romano = intval($key);
foreach ($romanos as $key => $valor) {
    while (strpos($romano1, $key) === 0) {
        $result += $valor;
        $romano1 = substr($romano1, strlen($key));
    }
}
	return $result;
}
// echo converte($romano1);
// $valor1 = converte($valor1);
// echo converte($valor[$i]);
for ($i = 0; $i<11; $i++){
    $total = converte($_POST[2]);

    
    echo  converte($_POST[$i]); // mostra todos os valores
    echo '<br>';
    if($_POST['operador'.$i] == '+'){
    echo $total =  converte($_POST[$i]) + converte($_POST[$i-1]);
    }
        if($_POST['operador'.$i] == '-'){
    echo $total = converte( $_POST[$i]) -  converte( $_POST[$i-1]);
    }
            if($_POST['operador'.$i] == '*'){
    echo $total =  converte( $_POST[$i]) *  converte($_POST[$i-1]);
    }
            if($_POST['operador'.$i] == '/'){
    echo $total =  converte( $_POST[$i]) / converte($_POST[$i-1]);
    }
    echo '<br>';
    echo $_POST['operador'.$i];
}
echo $total;
// $numeros = array();
    // $numeros[] = converte($_POST[$i]); 
    // echo  converte($_POST[$i]); // mostra todos os valores
    // echo '<br>';
    // if($_POST['operador'.$i] == '+'){
        // $total += converte($_POST[$i]);
        // echo 'aaaa';
        // }
        // if($_POST['operador'.$i] == '-'){
            // $total = $total - converte($_POST[$i]);
            // echo $total;
            // }
            

    // while ($_POST['operador'.$i] == '+'){
    //      $total += converte($_POST[$i]);
    // }
    //     while ($_POST['operador'.$i] == '-'){
    //     $total = $total - converte($_POST[$i]);
    // }
    //         if($_POST['operador'.$i] == '*'){
    // echo $total = converte($_POST[$i]) * converte($_POST[$i-1]);
    // }
    //         if($_POST['operador'.$i] == '/'){
    // echo $total = converte($_POST[$i]) / converte($_POST[$i-1]);
    // }
    // echo '<br>';
    // echo $_POST['operador'.$i];

print_r ($numeros);
print_r ($operadores);
// echo $total;

?>
</body>
</html>
