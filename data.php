<html>
<body>
<?php
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
if ($checa == true) { return true; } else { echo 'DATA INVÁLIDA!'; } 

} 

function checaDias($dias) { //CHECA SE O DIA É VALIDO
    $dias = $_POST['dias'];
if (!is_numeric($dias) || $dias < 0) { echo 'DIA INVÁLIDO!'; } else { return true; } 

}


function diasUteis($data, $dias) {
    if (checaData($data) == true && checaDias($dias) == true) { 
    $data = substr($_POST["data"], 0, 10); #tem q mudar pro formato americano pq o date não funciona na data brasileira
    $feriados = feriados($data);
    $dias = $_POST["dias"];
    if (preg_match("(/)", $data) == true) {
        $data = implode("-", array_reverse(explode("/", $data)));
    }
    $array = explode("-", $data);
    $c = 0;
    $qtd = 0;
    while ($qtd < $dias) {
        $c++;
        $diaa = date("m-d", strtotime('+'.$c.'day', strtotime($data)));
        if (($diasemana = date('w', strtotime('+'.$c.'day', mktime(0, 0, 0, $array[1], $array[2], $array[0])))) != '0' && $diasemana != '6' && !in_array($diaa, $feriados)) {
            $qtd++;
        }
    }
    return date("d/m/Y", strtotime("+".$c."day", strtotime($data)));
}
}

function feriados($ano) {
$ano = date('Y', strtotime($ano));
$dia = 86400;
/*$datas = array();
$datas['pascoa'] = easter_date($ano);
$datas['sextasanta'] = $datas['pascoa'] - (2 * $dia);
$datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
$datas['corpuschristi'] = $datas['pascoa'] + (60 * $dia);*/
$datas = array(
    'pascoa' => easter_date($ano),
    'sextasanta' => 'pascoa' - (2 * $dia),
    'carnaval' => 'pascoa' - (47 * $dia),
    'corpuschristi' => 'pascoa' + (60 * $dia)
);
$feriados = array(
    "01-01", 
    "04-21", 
    "05-01", 
    "09-07", 
    "10-12", 
    "11-02", 
    "11-15", 
    "12-25",
date('m-d', $datas['carnaval']),
date('m-d', $datas['sextasanta']),
date('m-d', $datas['pascoa']),
date('m-d', $datas['corpuschristi']),
); 

    return $feriados;
}
echo diasUteis($data, $dias);
print_r(feriados($anodadata));
?>
</body>
</html>
