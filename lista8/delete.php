<html>
<body>
<?php
if (isset($_GET["codigo"])) {
	$db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("delete from saboringrediente where sabor = ".$_GET["codigo"]);
	$db->exec("delete from pizzasabor where sabor = ".$_GET["codigo"]);
	$db->exec("delete from sabor where sabor.codigo = ".$_GET["codigo"]);
	echo $db->changes()." pizza(s) excluída(s)";
	$db->close();
}
?>
</body>
<script>
setTimeout(function () { window.open("select.php","_self"); }, 3000);
</script>
</html>

