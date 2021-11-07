<html>
<body>
<?php
if (isset($_GET["numero"])) {
	$db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
    $db->exec("delete from pizza where comanda = ".$_GET["numero"]);
    $db->exec("delete from comanda where comanda.numero = ".$_GET["numero"]);
	echo $db->changes()." comanda(s) excluída(s)";
	$db->close();
}
?>
</body>
<script>
setTimeout(function () { window.open("select.php","_self"); }, 3000);
</script>
</html>

