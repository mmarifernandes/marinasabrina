<html>
    <body>
        <?php 

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

function dataPascoa($ano) {
    $ano = $ano ? $ano : date("Y");
    if ($ano < 1583) {
        $A = ($ano % 4);
        $B = ($ano % 7);
        $C = ($ano % 19);
        $D = ((19 * $C + 15) % 30);
        $E = ((2 * $A + 4 * $B - $D + 34) % 7);
        $F = (int) (($D + $E + 114) / 31);
        $G = (($D + $E + 114) % 31) + 1;
        return date("d/m/Y", mktime( 0, 0, 0, $F, $G, $ano));
    } else {
        $A = ($ano % 19);
        $B = (int) ($ano/100);
        $C = ($ano % 100);
        $D = (int) ($B/4);
        $E = ($B % 4);
        $F = (int) (($B + 8) / 25);
        $G = (int) (($B - $F + 1) / 3);
        $H = ((19 * $A + $B - $D - $G + 15) % 30);
        $I = (int) ($C / 4);
        $K = ($C % 4);
        $L = ((32 + 2 * $E + 2 * $I - $H - $K)%7);
        $M = (int) (($A + 11 * $H + 22 * $L)/451);
        $P = (int) (($H + $L - 7 * $M + 114)/31);
        $Q = (($H + $L - 7 * $M + 114) % 31)+1;
        return date("d/m/Y", mktime(0, 0, 0, $P, $Q, $ano));
    }
}

function dataCarnaval($ano) {
    $ano = $ano ? $ano : date("Y");
    $a = explode("/", dataPascoa($ano));
    return date("d/m/Y", mktime(0, 0, 0, $a[1], $a[0] - 47, $a[2]));
}

function dataCorpusChristi($ano) {
    $ano = $ano ? $ano : date("Y");
    $a = explode("/", dataPascoa($ano));
    return date("d/m/Y", mktime(0, 0, 0, $a[1], $a[0] + 60, $a[2]));
}


function dataSextaSanta($ano) {
    $ano = $ano ? $ano : date( "Y" );
    $a = explode("/", dataPascoa($ano));
    return date("d/m/Y", mktime(0, 0, 0, $a[1], $a[0] - 2, $a[2]));
}

function diasUteis($data, $dias) {
            if (checaData($data) == true && checaDias($dias) == true) { 
            $data = $_POST["data"]; 
            $dias = $_POST["dias"];
            if (preg_match("(/)", $data) == true) {
                $data = implode("-", array_reverse(explode("/", $data)));
            }

            $apascoa = dataPascoa(date("Y"));
            $explodep = explode("/", $apascoa);
            $diapascoa = $explodep[0];
            $mespascoa = $explodep[1];
            $pascoa = "$mespascoa" . "-" . "$diapascoa"; 

            $acarnaval = dataCarnaval(date("Y"));
            $explodec = explode("/", $acarnaval);
            $diacarna = $explodec[0];
            $mescarna = $explodec[1];
            $carnaval = "$mescarna" . "-" . "$diacarna";

            $acc = dataCorpusChristi(date("Y"));
            $ccexplode = explode("/", $acc);
            $diacc = $ccexplode[0];
            $mescc = $ccexplode[1];
            $corpuschristi = "$mescc" . "-" . "$diacc";

            $asexta = dataSextaSanta(date("Y"));
            $sexta = explode("/", $asexta);
            $diasexta = $sexta[0];
            $sextames = $sexta[1];
            $sextasanta = "$sextames" . "-" . "$diasexta";

            $feriados = array("01-01", $carnaval, $sextasanta, $pascoa, $corpuschristi, "04-21", "05-01", "06-12", "07-09", "07-16", "09-07", "10-12", "11-02", "11-15", "12-25");
            $array = explode("-", $data);
            $c = 0;
            $qtd = 0;
            while ($qtd < $dias) {
                $c++;
                $dia = date("m-d", strtotime("+".$c."day", strtotime($data)));
                if (($diasemana = date("w", strtotime("+".$c."day", mktime(0, 0, 0, $array[1], $array[2], $array[0])))) != "0" && $diasemana != "6" && !in_array($dia, $feriados)) {
                    $qtd++;
                }
            }
            return date("d/m/Y", strtotime("+".$c."day", strtotime($data)));
        }
        }
        
        echo diasUteis($data, $dias);
        
        ?>
    </body>
</html>


Skip to content
Search or jump to…
Pull requests
Issues
Marketplace
Explore
 
@mmarifernandes 
mmarifernandes
/
marinasabrina
Private
1
00
Code
Issues
Pull requests
Actions
Projects
Security
Insights
Settings
marinasabrina/data.php /
@expresso-patronum
expresso-patronum sos
Latest commit b6ed6c0 12 hours ago
 History
 1 contributor
88 lines (78 sloc)  2.6 KB
  
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
