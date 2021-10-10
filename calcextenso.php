
<html>
<body>
<?php

$numeroextenso = $_POST['numeroextenso'];
$numeroextenso2 = $_POST['numeroextenso2'];
$operacao = $_POST['operador'];

$numeros = array('um' => 1, 'dois' => 2, 'tres' => 3, 'quatro' => 4, 'cinco' => 5, 'seis' => 6, 'sete' => 7, 'oito' => 8, 'nove' => 9, 'dez' => 10, 'onze' => 11, 'doze' => 12,
    'treze' => 13, 'quatorze' => 14, 'quinze' => 15, 'dezesseis' => 16, 'dezessete' => 17, 'dezoito' => 18, 'dezenove' => 19, 'vinte' => 20, 'trinta' => 30,
    'quarenta' => 40, 'cinquenta' => 50, 'sessenta' => 60, 'setenta' => 70, 'oitenta' => 80, 'noventa' => 90, 'cem' => 100, 'cento' => 100, 'duzentos' => 200,
    'trezentos' => 300, 'quatrocentos' => 400, 'quinhentos' => 500, 'seiscentos' => 600, 'setecentos' => 700, 'novecentos' => 900, 'mil' => 1000,
    'milhao' => 1000000, 'milhoes' => 1000000);



function converter($numeroextenso){

$numeros = array('um' => 1, 'dois' => 2, 'tres' => 3, 'quatro' => 4, 'cinco' => 5, 'seis' => 6, 'sete' => 7, 'oito' => 8, 'nove' => 9, 'dez' => 10, 'onze' => 11, 'doze' => 12,
    'treze' => 13, 'quatorze' => 14, 'quinze' => 15, 'dezesseis' => 16, 'dezessete' => 17, 'dezoito' => 18, 'dezenove' => 19, 'vinte' => 20, 'trinta' => 30,
    'quarenta' => 40, 'cinquenta' => 50, 'sessenta' => 60, 'setenta' => 70, 'oitenta' => 80, 'noventa' => 90, 'cem' => 100, 'cento' => 100, 'duzentos' => 200,
    'trezentos' => 300, 'quatrocentos' => 400, 'quinhentos' => 500, 'seiscentos' => 600, 'setecentos' => 700, 'novecentos' => 900, 'mil' => 1000,
    'milhao' => 1000000, 'milhoes' => 1000000);

$str = str_replace(",", " e", $numeroextenso);

$numeroextenso = str_replace(",", " e", $numeroextenso);
$numeroextenso = str_replace("ã", "a", $numeroextenso);
$numeroextenso = str_replace("á", "a", $numeroextenso);
$numeroextenso = str_replace("à", "a", $numeroextenso);
$numeroextenso = str_replace("â", "a", $numeroextenso);
$numeroextenso = str_replace("é", "e", $numeroextenso);
$numeroextenso = str_replace("è", "e", $numeroextenso);
$numeroextenso = str_replace("ê", "e", $numeroextenso);
$numeroextenso = str_replace("õ", "o", $numeroextenso);
$numeroextenso = str_replace("ó", "o", $numeroextenso);
$numeroextenso = str_replace("ò", "o", $numeroextenso);
$numeroextenso = str_replace("ô", "o", $numeroextenso);
$numeroextenso = str_replace("í", "i", $numeroextenso);
$numeroextenso = str_replace("ì", "i", $numeroextenso);
$numeroextenso = str_replace("ú", "u", $numeroextenso);
$numeroextenso = str_replace("ù", "u", $numeroextenso);
$numeroextenso = str_replace("û", "u", $numeroextenso);

$words = explode(" ", $numeroextenso);
$ultimo = '';
$resultado = 0;
$somar = 0;
$total = 1;

foreach ($words as $word) {

    $word = strtolower($word);
    
    if($word == "e") {
        $somar = 1;
        continue;
    }
    else{
        if($somar == 1) {
            $total += $numeros[$word];
            $somar = 0;
        }
        else if($somar == 0){
            if($ultimo !== '' && $ultimo > $numeros[$word]) {
                $total += $numeros[$word];
            }else{
                $total *= $numeros[$word];
            }
        }
        $ultimo = $numeros[$word];
        if($numeros[$word] >= 1000) {
            $resultado += $total;
            $total = 0;
            $ultimo = '';
            $somar = 0;
        }
    }
}
$resultado += $total;
return $resultado;

};

$valor1 = converter($numeroextenso);
$valor2 = converter($numeroextenso2);
if($operacao == '+'){
    $total = $valor1 + $valor2; 
    
}
if($operacao == '*'){
    $total = $valor1 * $valor2; 
    
}
if($operacao == '-'){
    $total = $valor1 - $valor2; 
    
}
if($operacao == '/'){
    $total = $valor1 / $valor2; 
    
}

if ($valor1 === 0 || $valor2 === 0){
            echo "</h1>";
            echo "<h1>";
            echo 'ERRO';
            echo "</h1>";
        }
        else{
echo "<center>";
echo "<br>";
echo "<h1>";
echo converter($numeroextenso);
echo $operacao;
echo converter($numeroextenso2);
echo "</h1>";
echo "<h1>";
echo "=";
echo "</h1>";
echo "<h1>";
echo intval($total);
echo "</h1>";
echo "<br>";
}

?>
</body>
</html>
