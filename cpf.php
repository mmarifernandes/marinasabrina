<html>
<body>
<?php

echo "<b>POST</b>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";
echo "<hr>";

function validaCPF($cpf) {

    $cpf = str_replace("-", "", $_POST['cpf']);

    if(!isset($cpf)){ 
        return false; 
    }

    if(strlen($cpf) != 11){ 
        return false; 
    }

    if(!preg_match("#^[0-9]{9}-[0-9]{2}$#", $_POST["cpf"])){
        return false;  
    }

    if(!is_numeric($cpf)){ 
        return false; 
    }

    for($i = 9; $i < 11; $i++){ 
        for($d = 0, $c = 0; $c < $i; $c++) {    
        $d+= $cpf[$c] * (($i + 1) - $c); 
    }
        $d = ((10 * $d) % 11) % 10;
        if($cpf[$c] != $d){ 
            return false; 
        } 
        if(str_repeat($d, 11) == $cpf){ 
            return false; 
        }
    }
    return true; 
}
echo("<script>console.log('PHP: " . validaCPF($cpf) . "');</script>");

if (isset($_POST['botao1'])) {
    $cpf = $_POST['cpf'];
    if (validaCPF($cpf) == true) {
    echo "<center>";
    echo "<br>";
    echo "<h1>";
    echo "CPF válido";
    echo "<br>";
    echo $_POST["cpf"];
    echo "</h1>";
    } else {
    echo "<center>";
    echo "<br>";
    echo "<h1>";
    echo "CPF inválido!!!!!!!!!!!!!!!!";
    echo "</h1>";
    }
} 
?>
</body>
</html>
