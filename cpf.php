<html>
<body>
<?php

echo "<b>POST</b>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";
echo "<hr>";

function validaCPF($cpf) {
    $cpf = $_POST['cpf'];
    
    if (strlen($cpf) != 11) { return false; }
    if ($cpf == "11111111111" || "22222222222" || "33333333333" || "44444444444" || 
    "55555555555" || "66666666666" || "77777777777" || "88888888888" || "99999999999"){
        return false;
    }
    for ($i = 9; $i < 11; $i++) {
        for ($d = 0, $c = 0; $c < $i; $c++) {
            $d += $cpf[$c] * (($i + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}
echo("<script>console.log('PHP: " . validaCPF($cpf) . "');</script>");

if (!isset($_POST["cpf"])) {
	echo "COM ERRO";
};
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
