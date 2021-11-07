<html>
<body>
<?php
if (isset($_GET["numero"])) {
    $db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
    $db->exec("update comanda set pago = 1 where comanda.numero = ".$_GET["numero"]);
    echo "Comanda n. ".$_GET["numero"]." paga!";
	$db->close();
}
?>
</body>
<script>
setTimeout(function () { window.open("select.php","_self"); }, 3000);
</script>
</html>

