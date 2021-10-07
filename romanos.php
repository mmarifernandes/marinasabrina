<html>
<body>
<?php
var_dump($_POST);
echo "<br>";
echo "<br>";
# '/^M{0,3}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/' pattern
$valor1 = $_POST['valor1'];
echo $valor1;

function converte($valor1) {
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
    while (strpos($valor1, $key) === 0) {
        $result += $valor;
        $valor1 = substr($valor1, strlen($key));
    }
}
	return $result;
}
$valor1 = converte($valor1);
for ($i = 0; $i<=10; $i++){
    echo $_POST["valor".$i] . ' | ';

}

?>
</body>
</html>
