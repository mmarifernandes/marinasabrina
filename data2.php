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
