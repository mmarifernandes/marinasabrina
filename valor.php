<html>
<body>
<?php


// Transcrever um valor monetário
// front-end HTML/JS
// input text valor, deve ser um valor monetário válido entre 0,01 e 999999999,99
// button enviar, só deve enviar se o valor monetário for válido

// back-end PHP
// mostra uma mensagem de erro se o valor monetário for inválido
// só deve transcrever e mostrar o valor por exdezenaso se o valor monetário for válido

var_dump($_POST);
$num = $_POST['valor'];
function convertervalor($num){ 
$numeros = array( 
1 => "um", 
2 => "dois", 
3 => "três", 
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
19 => "dezenove"); 
$dezenas = array( 
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
$centenas = array("", 1 =>"cem", 2=> "duzentos", 3=>"trezentos", 4=>"quatrocentos", 5=>"quinhentos", 6=>"seiscentos", 7=>"setecentos", 8=>"oitocentos", 9=>"novecentos");
$singular = array("", 1=>"mil", 2=>"milhão", 3=>"bilhão");
$plural = array("",1=>"mil",2=>"milhões",3=>"bilhões");



$centavos = explode(",",$num);
$num = str_replace(",", ".", $num);
$num = number_format($num, 2, ".", ",");
echo $num;
$numseparado = explode(".", $num);
$todonumero = $numseparado[0];
$centavos = $numseparado[1];
// echo substr($centavos, 0, 1);
// echo '<br>';
// echo strlen($centavos);
$invertida = array_reverse(explode(",", $todonumero));
krsort($invertida);
$palavras = "";
foreach ($invertida as $x => $i) {
    // echo '<br>';
    // echo substr($i, 2, 1);
    // echo '<br>';
    if ($i == 0) {
        continue;
    }
    if ($i < 20) {
        if(strlen($i) == 3 && substr($i, 0, 2) == 00){
            $palavras.= $numeros[substr($i, 2, 3) ];
            echo substr($i, 2, 3);
        }else{
            $palavras.= $numeros[($i)];
            $unidades.= $numeros[($i)];
            if( substr($i, 1, 2) == 10){
                $palavras.= "e ".$dezenas[(1)];
            }
            // echo '<br>';
            // echo substr($i, 1, 2);
        }
        // echo  substr($i, 0, 2);
        // echo '<br>';
        // echo $palavras;
        
        // }elseif(substr($i, 0, 1)) 
        
    }  elseif ($i < 100) {
          if (substr($i, 0, 1) == 0 && strlen($i) == 3) {
              $palavras.= $dezenas[substr($i, 1, 1) ];
            } 
            if (substr($i, 2, 1) != 0) {
                $palavras.= " e " . $numeros[substr($i, 2, 1) ];
            }
            else {
                $palavras.= $dezenas[substr($i, 0, 1) ];
                if (substr($i, 1, 1) != 0) {
                 $palavras.= " e " . $numeros[substr($i, 1, 1) ];
                }
            }
            
        } 
        elseif($i > 100 && $i <200){
            if (substr($i, 1, 1) != 0 || substr($i, 2, 1) != 0) {
                $palavras.= 'cento';
            } else {
                $palavras.= $centenas[(substr($i, 0, 1)) ];
            }
            if (substr($i, 1, 2) < 20 && substr($i, 1, 1) != 0) {
               
                $palavras.= " e " . $numeros[(substr($i, 1, 2)) ];
            } else {
                
                if (substr($i, 1, 1) != 0) {
                    // echo substr($i, 1, 1);
                    // echo '<br>';
                    $palavras.= " " . $dezenas[substr($i, 1, 1) ];
                }
                if (substr($i, 2, 1) != 0) {
                    
                $palavras.= " e " . $numeros[substr($i, 2, 1) ];
            }
        }
    }
    
    
    else {
        if (substr($i, 1, 1) != 0 || substr($i, 2, 1) != 0) {
            $palavras.= $centenas[(substr($i, 0, 1)) ];
        } else {
            $palavras.= $centenas[(substr($i, 0, 1)) ];
        }
        if (substr($i, 1, 2) < 20 && substr($i, 1, 1) != 0) {
            $palavras.= " e " . $numeros[(substr($i, 1, 2)) ];
        } else {
            if (substr($i, 1, 1) != 0) {
                $palavras.= " e " . $dezenas[substr($i, 1, 1) ];
            }
            if (substr($i, 2, 1) != 0) {
                $palavras.= " e " . $numeros[substr($i, 2, 1) ];
            }
        }
    }
    if ($x > 0) {
        if(substr($i, 0, 1) == 1 && strlen($num) == 12){
            $palavras.= " " . $singular[$x] . " e ";
        }
        else
        $palavras.= " " . $plural[$x] . "  ";

    }
}

    if ( strstr( $palavras, 'um' ) && strlen($num) <= 4) {
$palavras.= ' real';
} else {
$palavras.= ' reais';
}
if ($centavos > 0) {//arrumar
    if($todonumero != 0){
        $palavras.= " e ";
        echo '<br>';
        if ($centavos < 20 && $centavos != 10 && substr($centavos, 0, 1) != 0) {
            $palavras.= $numeros[($centavos) ];
        }
        if ($centavos == 10) {
            $palavras.= $numeros[($centavos) ];
        }
        if (substr($centavos, 0, 1) == 0) {
            // echo substr($centavos, 0, 1);
        $palavras.= $numeros[substr($centavos, 1, 1) ];

    } if ($centavos >= 20 && $centavos < 100) {
        $palavras.=  $dezenas[substr($centavos, 0, 1) ] . ' ';
        if (substr($centavos, 1, 1) != 0) {
            // echo  $numeros[substr($centavos, 1, 1) ];
            $palavras.= " e " . $numeros[substr($centavos, 1, 1) ];
        }
    }

$palavras.= ' centavos';

}else{
    $palavras = " ";
    if ($centavos < 20 && $centavos != 10) {
        $palavras.= $numeros[($centavos)];
    }
    if (substr($centavos, 0, 1) === 0) {
        $palavras.= $numeros[substr($centavos, 1, 1) ];
    } elseif ($centavos < 100 && $centavos >=20) {
        $palavras.=  $dezenas[substr($centavos, 0, 1) ] . ' ';
        echo $centavos;
    }
     if (substr($centavos, 1, 1) != 0 && $centavos < 10) {
            echo '<br>';
            echo $palavras;
            $palavras.=  $numeros[substr($centavos, 1, 1) ];
        }
        if ( strstr( $palavras, 'um' ) && strlen($centavos) <= 4) {
  $palavras.= ' centavo';
} else {
$palavras.= ' centavos';
}
}
}
return $palavras;
}

// for ($num = 0.01; $num < 1000000000; $num += 0.01){
//     echo convertervalor($num);
// }

echo '<br>';
echo "<h1 align='center'>".convertervalor("$num")."</h1>";

?>
</body>
</html>
