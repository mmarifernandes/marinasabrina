<html>
<body>
<?php


// Transcrever um valor monetário
// front-end HTML/JS
// input text valor, deve ser um valor monetário válido entre 0,01 e 999999999,99
// button enviar, só deve enviar se o valor monetário for válido

// back-end PHP
// mostra uma mensagem de erro se o valor monetário for inválido
// só deve transcrever e mostrar o valor por extenso se o valor monetário for válido

var_dump($_POST);
$num = $_POST['valor'];
function numberTowords($num)
{ 
$ones = array( 
1 => "um", 
2 => "dois", 
3 => "tres", 
4 => "quatro", 
5 => "cinco", 
6 => "seis", 
7 => "sete", 
8 => "oito", 
9 => "nove", 
10 => "dez", 
11 => "onze", 
12 => "doze", 
13 => "treze", 
14 => "quatorze", 
15 => "quinze", 
16 => "dezesseis", 
17 => "dezessete", 
18 => "dezoito", 
19 => "dezenove" 
); 
$tens = array( 
1 => "dez",
2 => "vinte", 
3 => "trinta", 
4 => "quarenta", 
5 => "cinquenta", 
6 => "sessenta", 
7 => "setenta", 
8 => "oitenta", 
9 => "noventa" 
); 
$centenas = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
$hundreds = array(
"hundred",
"mil",
"milhão",
"bilhão"
);
$plural = array(
"",
"",
"milhões",
"bilhões"
);
$centavos = explode(",",$num);
$num = str_replace(",", ".", $num);
$num = number_format($num, 2, ".", ",");
echo $num;
$num_arr = explode(".", $num);
$wholenum = $num_arr[0];
$centavos = $num_arr[1];
echo '<br>';
echo substr($centavos, 1, 1);
$whole_arr = array_reverse(explode(",", $wholenum));
krsort($whole_arr);
$words = "";
foreach ($whole_arr as $key => $i) {
    if ($i == 0) {
        continue;
    }
    if ($i < 20) {
        $words.= $ones[($i) ];
        $unidade.= $ones[($i) ];
    } elseif ($i < 100) {
        if (substr($i, 0, 1) == 0 && strlen($i) == 3) {
            $words.= $tens[substr($i, 1, 1) ];
            if (substr($i, 2, 1) != 0) {
                $words.= " " . $ones[substr($i, 2, 1) ];
            }
        } else {
            $words.= $tens[substr($i, 0, 1) ];
            if (substr($i, 1, 1) != 0) {
                $words.= " " . $ones[substr($i, 1, 1) ];
            }
        }
    } else {

        if (substr($i, 1, 1) != 0 || substr($i, 2, 1) != 0) {
            $words.= $centenas[(substr($i, 0, 1)) ] . ' e ';
        } else {
            $words.= $centenas[(substr($i, 0, 1)) ];
        }
        if (substr($i, 1, 2) < 20 && substr($i, 1, 1) != 0) {
            $words.= " " . $ones[(substr($i, 1, 2)) ];
        } else {
            if (substr($i, 1, 1) != 0) {
                $words.= " " . $tens[substr($i, 1, 1) ];
            }
            if (substr($i, 2, 1) != 0) {
                $words.= " " . $ones[substr($i, 2, 1) ];
            }
        }
    }
    if ($key > 0) {
        if(substr($i, 0, 1) == 1){
            $words.= " " . $hundreds[$key] . " ";
        }
      else
        $words.= " " . $plural[$key] . " ";
    }
}
$words.= ' reais';
if ($centavos > 0) {
    $words.= " e ";
    if ($centavos < 20 && $centavos != 10) {
        $words.= $ones[($centavos) ];
    }
    if (substr($centavos, 0, 1) === 0) {
        $words.= $ones[substr($centavos, 1, 1) ];
    } elseif ($centavos < 100) {
        $words.= $tens[substr($centavos, 0, 1) ];
        if (substr($centavos, 1, 1) != 0) {
            $words.= " " . $ones[substr($centavos, 1, 1) ];
        }
    }
    $words.= ' centavos';
}
return $words;
}

echo "<p align='center' style='color:blue'>".numberTowords("$num")."</p>";
// function extenso($valor){
// if (strpos($valor,",") > 0)
// {
//     $valor = str_replace(",",".",$valor);
// };

// $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
// $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");

// $centenas = array("", "cem", "duzentos", "trezentos", "quatrocentos",
// "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
// $dezenas = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
// "sessenta", "setenta", "oitenta", "noventa");
// $dezenas2 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
// "dezesseis", "dezesete", "dezoito", "dezenove");


// $unidades = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");

// $x=0;

// $valor = number_format($valor, 2, ".", ".");
// $inteiro = explode(".", $valor);
// for($i=0; $i<count($inteiro); $i++)
// for($y=strlen($inteiro[$i]);$y<3;$y++)
// $inteiro[$i] = "0".$inteiro[$i];

// $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
// for ($i=0;$i<count($inteiro);$i++) {
// $valor = $inteiro[$i];
// $calculocentenas = (($valor > 100) && ($valor < 200)) ? "cento" : $centenas[$valor[0]];
// $calculodezenas = ($valor[1] < 2) ? "" : $dezenas[$valor[1]];
// $calculounidades = ($valor > 0) ? (($valor[1] == 1) ? $dezenas2[$valor[2]] : $unidades[$valor[2]]) : "";

// $r = $calculocentenas.(($calculocentenas && ($calculodezenas || $calculounidades)) ? " e " : "").$calculodezenas.(($calculodezenas &&
// $calculounidades) ? " e " : "").$calculounidades;
// $t = count($inteiro)-1-$i;
// $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
// if ($valor == "000")$x++; elseif ($x > 0) $x--;
// if (($t==1) && ($x>0) && ($inteiro[0] > 0)) $r .= (($x>1) ? " de " : "").$plural[$t];
// if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
// ($inteiro[0] > 0) && ($x < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
// }


// return($rt ? $rt : "ERRO");

// }
// if ($valor > 999999999.99){
//     echo "ERRO";
// }

// if (isset($_POST["valor"]) && $valor <= 999999999.99 ) {
// echo "<br>";
// echo "<br>";
// echo extenso($valor);
// }
?>
</body>
</html>
