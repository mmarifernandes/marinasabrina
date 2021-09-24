<html>
<body>
<?php
var_dump($_POST);
$valor = $_POST['valor'];

function extenso($valor){
if (strpos($valor,",") > 0)
{
    $valor = str_replace(",",".",$valor);
};

$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");


$centenas = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
$dezenas = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
$dezenas2 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");


$unidades = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");

$x=0;

$valor = number_format($valor, 2, ".", ".");
$inteiro = explode(".", $valor);
for($i=0;$i<count($inteiro);$i++)
for($y=strlen($inteiro[$i]);$y<3;$y++)
$inteiro[$i] = "0".$inteiro[$i];

$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
for ($i=0;$i<count($inteiro);$i++) {
$valor = $inteiro[$i];
$calculocentenas = (($valor > 100) && ($valor < 200)) ? "cento" : $centenas[$valor[0]];
$calculodezenas = ($valor[1] < 2) ? "" : $dezenas[$valor[1]];
$calculounidades = ($valor > 0) ? (($valor[1] == 1) ? $dezenas2[$valor[2]] : $unidades[$valor[2]]) : "";

$r = $calculocentenas.(($calculocentenas && ($calculodezenas || $calculounidades)) ? " e " : "").$calculodezenas.(($calculodezenas &&
$calculounidades) ? " e " : "").$calculounidades;
$t = count($inteiro)-1-$i;
$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
if ($valor == "000")$x++; elseif ($x > 0) $x--;
if (($t==1) && ($x>0) && ($inteiro[0] > 0)) $r .= (($x>1) ? " de " : "").$plural[$t];
if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($x < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
}


return($rt ? $rt : "ERRO");

}
if ($valor > 999999999.99){
    echo "ERRO";
}

if (isset($_POST["valor"]) && $valor <= 999999999.99 ) {
echo "<br>";
echo "<br>";
echo extenso($valor);
}
?>
</body>
</html>
