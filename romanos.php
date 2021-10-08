<html>
<body>
<?php
var_dump($_POST);
echo "<br>";
echo "<br>";
# '/^M{0,3}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/' pattern


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
for ($i = 10; $i>0; $i--){
    
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

?>
</body>
</html>
