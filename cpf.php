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

    if (!isset($cpf)) { return false; }

    if (strlen($cpf) != 11) { return false; }

    if (!preg_match("#^[0-9]{9}-[0-9]{2}$#", $_POST["cpf"])) { return false;  }

    if (is_numeric($cpf) == false) { return false; }

    for ($i = 9; $i < 11; $i++) { 
        for ($d = 0, $c = 0; $c < $i; $c++) { // c = 0 1 2 3 4 5 6 7 8 9 numero base
            $d += $cpf[$c] * (($i + 1) - $c); } // d soma cpf na pos c e multiplica pelas duas ultimas pos, diminui base
        $d = ((10 * $d) % 11) % 10; /// verifica se os 2 ultimos batem c o calculo
        if ($cpf[$c] != $d) { return false; } // se não, false
        if (str_repeat($d, 11) == $cpf) { return false; } // p n repetir
    }
    return true; // se sim, true

}
echo("<script>console.log('PHP: " . validaCPF($cpf) . "');</script>");

if (isset($_POST['botao1'])) {
    $cpf = $_POST['cpf'];
    if (validaCPF($cpf) == true) {
       echo "CPF válido";
      echo "<br>";
        echo $_POST["cpf"];
    } else {
        echo "CPF inválido";
    }
} 
?>
</body>
</html>
