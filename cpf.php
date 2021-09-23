<html>
<body>
<?php
function validaCPF($cpf) {
    $cpf = $_POST['cpf'];
    if (strlen($cpf) != 11) { return false; }
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
if (isset($_POST['botao1'])) {
    $cpf = $_POST['cpf'];
    if (validaCPF($cpf) == true) {
        echo $_POST["cpf"];
    } else {
        echo 'CPF inválido';
    }
}

?>
</body>
</html>
