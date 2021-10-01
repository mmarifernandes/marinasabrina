<html>
<body>
<?php
// var_dump($_POST);

$valor = $_POST['valor'];
function extenso($valor){

$unidades = array('','um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove');
$dezenas = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
$dezenas2 = array(" ", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");
$cento = array('', 'cento');
$centenas = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");

$inteiro = explode(",", $valor);
echo $valor;
echo "<br>";
echo strlen($inteiro[0]);
echo "<br>";
// foreach ($inteiro as $numero){
//     $separar = str_split($inteiro[0], 1);
//     echo $separar;
//     echo $unidade[$separar];
// }
if(strlen($inteiro[0])>=9){
$separar = str_split($inteiro[0], 3);
if($separar[0]>=100){
    if($separar[0]>=110 && substr($separar[0], 1, 2) <=19){
        $total = $centenas[$separar[0][0]]. ' e '. $dezenas2[$separar[0][1]]  .' '. $plural[3];
        
    }
    else if($separar[0][1]==0 && $separar[0][2] ==0 ){
        $total = $centenas[$separar[0][0]]. ' '.$plural[3];
    }else{
    $total = $centenas[$separar[0][0]] . ' e '. $dezenas[$separar[0][1]] .' e '. $unidades[$separar[0][2]] .' '. $plural[3];
}
}

if(strlen($inteiro[0])>=6){
$separar = str_split($inteiro[0], 3);
if($separar[1]>=100){
    if($separar[1]>=110 && substr($separar[1], 1, 2) <=19){
        $total1 = $centenas[$separar[1][0]]. ' e '. $dezenas2[$separar[1][1]]  .' '. $plural[2];
        
    }
    else if($separar[1][1]==0 && $separar[1][2] ==0 ){
        $total1 = $centenas[$separar[1][0]]. ' '.$plural[2];
    }else{
    $total1 = $centenas[$separar[1][0]] . ' e '. $dezenas[$separar[1][1]] .' e '. $unidades[$separar[1][2]] .' '. $plural[2];
}
}
}
if(strlen($inteiro[0])>=3){
    $separar = str_split($inteiro[0], 3);
    if($separar[2]>=100){
        if($separar[2]>=110 && substr($separar[2], 1, 2) <=19){
            $total2 = $centenas[$separar[2][0]]. ' e '. $dezenas2[$separar[2][1]] .' '. $plural[1];
        }
        elseif($separar[2][1]==0 && $separar[2][2] ==0 ){
            $total2 = $centenas[$separar[2][0]]. ' '.$plural[1];
        }else{
            $total2 = $centenas[$separar[2][0]] . ' e '. $dezenas[$separar[2][1]] .' e '. $unidades[$separar[2][2]] .' '. $plural[1];
        }
    }
}
}

if(strlen($inteiro[0])>=6){
$separar = str_split($inteiro[0], 3);
if($separar[0]>=100){
    if($separar[0]>=110 && substr($separar[0], 1, 2) <=19){
        $total1 = $centenas[$separar[0][0]]. ' e '. $dezenas2[$separar[0][1]]  .' '. $plural[2];
        
    }
    elseif($separar[0][1]==0 && $separar[0][2] ==0 ){
        $total1 = $centenas[$separar[0][0]]. ' '.$plural[1];
    }else{
    $total1 = $centenas[$separar[0][0]] . ' e '. $dezenas[$separar[0][1]] .' e '. $unidades[$separar[0][2]] .' '. $plural[2];
}
}

elseif(strlen($inteiro[0])>=3){
    $separar = str_split($inteiro[0], 3);
    if($separar[1]>=100){
        if($separar[1]>=110 && substr($separar[1], 1, 2) <=19){
            $total2 = $centenas[$separar[1][0]]. ' e '. $dezenas2[$separar[1][1]] .' '. $plural[1];
        }
        elseif($separar[1][1]==0 && $separar[1][2] == 0 ){
            
            $total2 = $centenas[$separar[1][0]]. ' '.$plural[1];
        }else{
            $total2 = $centenas[$separar[1][0]] . ' e '. $dezenas[$separar[1][1]] .' e '. $unidades[$separar[1][2]] .' '. $plural[1];
        }
    }
}
}


if(strlen($inteiro[0])>=3){
$separar = str_split($inteiro[0], 3);
if($separar[0]>=100){
    if($separar[0]>=110 && substr($separar[0], 1, 2) <=19){
        $total2 = $centenas[$separar[0][0]]. ' e '. $dezenas2[$separar[0][1]]  .' '. $plural[1];
        
    }
    else if($separar[0][1]==0 && $separar[0][2] ==0 ){
        $total2 = $centenas[$separar[0][0]]. ' '.$plural[1];
    }else{
    $total2 = $centenas[$separar[0][0]] . ' e '. $dezenas[$separar[0][1]] .' e '. $unidades[$separar[0][2]] .' '. $plural[1];
}
}
}
return $total .' '.$total1. ' '. $total2;
}
echo extenso($valor);
// Transcrever um valor monetário
// front-end HTML/JS
// input text valor, deve ser um valor monetário válido entre 0,01 e 999999999,99
// button enviar, só deve enviar se o valor monetário for válido

// back-end PHP
// mostra uma mensagem de erro se o valor monetário for inválido
// só deve transcrever e mostrar o valor por extenso se o valor monetário for válido


?>
</body>
</html>
