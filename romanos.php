<html>
<body>
<?php
var_dump($_POST);
echo "<br>";
print_r($_POST);
echo "<br>";
echo "<br>";
# '/^M{0,3}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/' pattern
$romano2 = $_POST['romano2'];

function converte($result) {
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
	$romano = $_POST['romano1'];

foreach ($romanos as $key => $valor) {
    while (strpos($romano, $key) === 0) {
        $result += $valor;
        $romano = substr($romano, strlen($key));
    }
}
	return $result;
}
echo $result;




?>
</body>
</html>
