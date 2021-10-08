<html>
    <body>
        <?php 


/* $data = 2020-08-08;
$qtdDias = 5;
O cálculo com as funções vai ficar da seguinte maneira:
$resultado = date('d/m/Y', strtotime("+{$qtdDias} days",strtotime($data)));*/
/* mostra uma mensagem de erro se data ou dias úteis forem inválidos
só calcula se data e dias úteis forem válidos
soma a quantidade de dias úteis à data e mostra a data resultante
* dias úteis são os dias da semana de segunda a sexta que não são feriados nacionais
(Confraternização Universal, Tiradentes, Dia Mundial do Trabalho,
Independência do Brasil, Nossa Senhora Aparecida, Finados, Proclamação da República e Natal) */
echo "<b>POST</b>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";
echo "<hr>";

function checaData($data) { //CHECA SE A DATA É REAL
    $data = explode("/", $_POST["data"]);
    $d = $data[0];
    $m = $data[1];
    $a = $data[2];
    $checa = checkdate($m, $d, $a);
if ($checa == true) { return true; } else { echo "DATA INVÁLIDA!"; } 

} 

function checaDias($dias) { //CHECA SE O DIA É VALIDO
    $dias = $_POST["dias"];
if (!is_numeric($dias) || $dias < 0) { echo "DIA INVÁLIDO!"; } else { return true; } 

}

function diasUteis($data, $dias) {
    if (checaData($data) == true && checaDias($dias) == true) { 
    $data = $_POST["data"];
    $dias = $_POST["dias"];
    $a = explode("/", $data);
    $ano = strtotime($a[2]);
    $dia = 86400;
    $datas = array();
    $datas["pascoa"] = easter_date($ano);
    $datas["sextasanta"] = $datas["pascoa"] - (2 * $dia);
    $datas["carnaval"] = $datas["pascoa"] - (47 * $dia);
    $datas["corpuschristi"] = $datas["pascoa"] + (60 * $dia);
    $feriados = array(
        "01-01", 
        "04-21", 
        "05-01", 
        "09-07", 
        "10-12", 
        "11-02", 
        "11-15", 
        "12-25",
        date("m-d", $datas["carnaval"]),
        date("m-d", $datas["sextasanta"]),
        date("m-d", $datas["pascoa"]),
        date("m-d", $datas["corpuschristi"]),
    ); 
    print_r($feriados);
    if (preg_match("(/)", $data) == true) {
        $data = implode("-", array_reverse(explode("/", $data)));
    }
    $array = explode("-", $data);
    $c = 0;
    $qtd = 0;
    while ($qtd < $dias) {
        $c++;
        $diaa = date("m-d", strtotime("+".$c."day", strtotime($data)));
        if (($diasemana = date("w", strtotime("+".$c."day", mktime(0, 0, 0, $array[1], $array[2], $array[0])))) != "0" && $diasemana != "6" && !in_array($diaa, $feriados)) {
            $qtd++;
        }
    }
    return date("d/m/Y", strtotime("+".$c."day", strtotime($data)));
}
}



echo diasUteis($data, $dias);
//print_r(feriadosMoveis($data));
?>
</body>
</html>

<html>
<body>
<?php
/* $data = 2020-08-08;
$qtdDias = 5;

O cálculo com as funções vai ficar da seguinte maneira:

$resultado = date('d/m/Y', strtotime("+{$qtdDias} days",strtotime($data)));*/
/* mostra uma mensagem de erro se data ou dias úteis forem inválidos
só calcula se data e dias úteis forem válidos
soma a quantidade de dias úteis à data e mostra a data resultante
* dias úteis são os dias da semana de segunda a sexta que não são feriados nacionais
(Confraternização Universal, Tiradentes, Dia Mundial do Trabalho,
Independência do Brasil, Nossa Senhora Aparecida, Finados, Proclamação da República e Natal) */
echo "<b>POST</b>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";
echo "<hr>";

function checaData($data) { //CHECA SE A DATA É REAL
    $data = explode("/", $_POST["data"]);
    $d = $data[0];
    $m = $data[1];
    $a = $data[2];
    $checa = checkdate($m, $d, $a);
if ($checa == true) { return true; } else { echo "DATA INVÁLIDA!"; } 

} 

function checaDias($dias) { //CHECA SE O DIA É VALIDO
    $dias = $_POST["dias"];
if (!is_numeric($dias) || $dias < 0) { echo "DIA INVÁLIDO!"; } else { return true; } 

}

function diasUteis($data, $dias) {
    if (checaData($data) == true && checaDias($dias) == true) { 
    $data = $_POST["data"];
    $dias = $_POST["dias"];
    $a = explode("/", $data);
    //$ano = strtotime($a[2]);
    $dia = 86400;
    $datas = array();
    $datas["pascoa"] = easter_date($a[2]);
    $datas["sextasanta"] = $datas["pascoa"] - (2 * $dia);
    $datas["carnaval"] = $datas["pascoa"] - (47 * $dia);
    echo date("m-d", $datas["carnaval"]);
    echo '<br>';
    $datas["corpuschristi"] = $datas["pascoa"] + (60 * $dia);
    $feriados = array(
        "01-01", 
        "04-21", 
        "05-01", 
        "09-07", 
        "10-12", 
        "11-02", 
        "11-15", 
        "12-25",
        date("m-d", $datas["carnaval"]),
        date("m-d", $datas["sextasanta"]),
        date("m-d", $datas["pascoa"]),
        date("m-d", $datas["corpuschristi"]),
    ); 
    print_r($feriados);
    if (preg_match("(/)", $data) == true) {
        $data = implode("-", array_reverse(explode("/", $data)));
    }
    $array = explode("-", $data);
    $c = 0;
    while ($c < $dias) {
        $c++;
        $diaa = date("m-d", strtotime("+".$c."day", strtotime($data)));
        echo $diaa;
        echo '<br>';
        $diasemana = date("w", strtotime("+".$c."day", mktime(0, 0, 0, $array[1], $array[2], $array[0])));
        echo $diasemana;
        if ($diasemana != "0" && $diasemana != "6" && !in_array($diaa, $feriados)) {
           continue;
        } else {
            $c++;
        }
        echo $diasemana;
    }
    return date("d/m/Y", strtotime("+".$c."day", strtotime($data)));
}
}



echo "<h1 align='center'>".diasUteis($data, $dias)."</h1>";
//print_r(feriadosMoveis($data));
?>
</body>
</html>
© 2021 GitHub, Inc.
Terms
Privacy
Security
Status
Docs
Contact GitHub
Pricing
API
Training
Blog
About
Loading complete



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
        $romano1= substr($romano1, strlen($key));
    }
}
	return $result;
}
// echo converte($romano1);
// $valor1 = converte($valor1);
// echo converte($valor[$i]);
for ($i = 0; $i<11; $i++){
    $total = converte($_POST[2]);

    
    // if (($index = array_search('+', $operadores)) !== false) {
    //     $total += converte($_POST[$i]);
    //     // array_splice($numeros, $index - 1, 3, $numeros[$index - 1] + $numeros[$index + 1]);
    // }
        if (($index = array_search('+', $operadores)) !== false) {
        $total += converte($_POST[$i]);
     
        // array_splice($numeros, $index - 1, 3, $numeros[$index - 1] + $numeros[$index + 1]);
    }
    //     if (($index = array_search('*', $operadores)) !== false) {
    //         echo 'aaa';
    //     $total += $total * converte($numeros[0][$i]);
    //     // array_splice($numeros, $index - 1, 3, $numeros[$index - 1] + $numeros[$index + 1]);
    // }
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
