<html>
<body>
<?php
var_dump($_POST);
$valor = $_POST['valor'];

function extenso($valor, $moeda=true,$np=true )
//$moeda true para definir se escreve Reais / Centavos para usar com numerais simples ou monetarios
{
// verifica se tem virgula decimal
if (strpos($valor,",") > 0)
{
    // retira o ponto de milhar, se tiver
    $valor = str_replace(".","",$valor);

    // troca a virgula decimal por ponto decimal
    $valor = str_replace(",",".",$valor);
}

if(!$moeda)
{
$singular  = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
$plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
}
else
{
$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
}

$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");

if(!$moeda) // se for usado apenas para numerais
{
    if($np)
        $u = array("", "uma", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
    else
        $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
}
else
{
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
}
$z=0;

$valor = number_format($valor, 2, ".", ".");
$inteiro = explode(".", $valor);
for($i=0;$i<count($inteiro);$i++)
for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
$inteiro[$i] = "0".$inteiro[$i];

$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
for ($i=0;$i<count($inteiro);$i++) {
$valor = $inteiro[$i];
$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
$t = count($inteiro)-1-$i;
$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
if ($valor == "000")$z++; elseif ($z > 0) $z--;
if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
}


return($rt ? $rt : "zero");

}
if ($valor == 100000000000){
    echo "ERRO";
}

if (isset($_POST["valor"])) {
echo "<br>";
echo "<br>";
echo extenso($valor);
}
?>
</body>
</html>
