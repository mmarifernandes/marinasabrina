
<html>
<body>
<?php
var_dump($_POST);
$numeroextenso = $_POST['numeroextenso'];
$numeroextenso2 = $_POST['numeroextenso2'];
$operacao = $_POST['operador'];
echo $operacao;

function converter($numeroextenso){

$numbers = array(
    'um' => 1,
    'dois' => 2,
    'tres' => 3,
    'quatro' => 4,
    'cinco' => 5,
    'seis' => 6,
    'sete' => 7,
    'oito' => 8,
    'nove' => 9,
    'dez' => 10,
    'onze' => 11,
    'doze' => 12,
    'treze' => 13,
    'quatorze' => 14,
    'quinze' => 15,
    'dezesseis' => 16,
    'dezessete' => 17,
    'dezoito' => 18,
    'dezenove' => 19,
    'vinte' => 20,
    'trinta' => 30,
    'quarenta' => 40,
    'cinquenta' => 50,
    'sessenta' => 60,
    'setenta' => 70,
    'oitenta' => 80,
    'noventa' => 90,
    'cem' => 100,
    'cento' => 100,
    'duzentos' => 200,
    'trezentos' => 300,
    'quatrocentos' => 400,
    'quinhentos' => 500,
    'seiscentos' => 600,
    'setecentos' => 700,
    'novecentos' => 900,
    'mil' => 1000,
    'milhao' => 1000000,
    'milhoes' => 1000000,
    'bilhoes' => 1000000000,
    'bilhao' => 1000000000,
    'milhão' => 1000000,
    'milhões' => 1000000,
    'bilhões' => 1000000000,
    'bilhão' => 1000000000);

$str = str_replace(",", " e", $numeroextenso);

$numeroextenso = str_replace(",", " e", $numeroextenso);
$numeroextenso = str_replace("ã", "a", $numeroextenso);
$numeroextenso = str_replace("õ", "o", $numeroextenso);
$words = explode(" ", $numeroextenso);
// echo $numeroextenso;
$total = 1;

$force_addition = false;

$last_digit = null;

$final_sum = array();

foreach ($words as $word) {

    if (!isset($numbers[$word]) && $word != "e") {
        continue;
    }

    $word = strtolower($word);

    if ($word == "e") {
        if ($last_digit === null) {
            $total = 0;

        }
        $force_addition = true;
    } else {

        if ($force_addition) {
            $total += $numbers[$word];
            $force_addition = false;

        } else {

            if ($last_digit !== null && $last_digit >= $numbers[$word]) {
                $total += $numbers[$word];
            } else {
                $total *= $numbers[$word];
            }
        }
        $last_digit = $numbers[$word];

        if ($numbers[$word] >= 1000) {
            $final_sum[] = $total ;
            $last_digit = null;
            $force_addition = false;
            $total = 0;
        }
    }
}
$final_sum[] = $total;
return array_sum($final_sum);

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

    echo "<center>";
    echo "<br>";
    echo "<h1>";
    echo $total;
    echo "</h1>";
    echo "<br>";
echo "<center>";
echo "<br>";
echo "<h1>";
echo converter($numeroextenso);
echo "</h1>";
echo "<br>";
echo "<h1>";
echo converter($numeroextenso2);
echo "</h1>";

?>
</body>
</html>
