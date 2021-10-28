<html>
<body>
<?php
if (isset($_GET["codigo"])) {
	$db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$results = $db->query("select sabor.nome as sabor, sabor.codigo as codigo, tipo.nome as tipo, ingrediente.nome as ingrediente from sabor join saboringrediente on saboringrediente.sabor = sabor.codigo join tipo on tipo.codigo = sabor.tipo
	join ingrediente on saboringrediente.ingrediente = ingrediente.codigo where sabor.codigo = ".$_GET["codigo"]);
	$row = $results->fetchArray();
	$db->close();
	if ($row === false) {
		echo "<font color=\"red\">pizza não encontrada</font>";
	} else {
		echo "<h1>Alteração de Sabor</h1>\n";
	echo "<form name=\"insert\" action=\"insert.php\" method=\"post\">\n";
	echo "<table>\n";
	echo "<tr>\n";
	echo "<td>Nome</td>\n";
	echo "<td><input type=\"text\" name=\"sabor\" value=\"\" size=\"50\"></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Tipo</td>\n";
	echo "<td>";
	echo '<select name="selecttipos">';
	// $results = $db->query("select tipo.codigo as tipocodigo, tipo.nome as tipo from tipo");
	// while ($row = $results->fetchArray()) {
	// 	echo "<option value=\"".$row["tipocodigo"]."\">".strtolower($row["tipo"])."</option>\n";
	// }
	echo '</select>';
	echo "</td>";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Ingrediente</td>\n";
	echo "<td>";
	echo '<select id="selectingredientes" name="selectingredientes">';
	// $results = $db->query("select ingrediente.codigo as ingcodigo, ingrediente.nome as ingrediente from ingrediente");
	// while ($row = $results->fetchArray()) {
	// 	echo "<option id=\"ingrediente\" value=\"".$row["ingcodigo"]."\"name=\"ingrediente\">".strtolower($row["ingrediente"])."</option>\n";
	// }
	echo '</select>';
	echo '<label><input type="button" name = "mais" value="mais" src="mais.png" width = "2%" onclick="add();"></label>';
	echo "</td>";
	echo "</tr>\n";
	echo "<tr>\n";
	
	
	
	echo "<td>Ingredientes</td>\n";
	echo "<td>";
	echo "<table id=\"tableingredientes\" border=\"1\">\n";
	
	echo "</table>\n";
	echo "</td>";
	echo "</tr>\n";
	
	echo "</table>\n";
	echo "<input type=\"submit\" name=\"inclui\" value=\"inclui\">\n";
	echo "</form>\n";
}
} else {
	if (isset($_POST["confirma"])) {
		$error = "";
		//coloque aqui o código para validação dos campos recebidos
		//se ocorreu algum erro, preencha a variável $error com uma mensagem de erro
		if ($error == "") {
			$db = new SQLite3("pizzaria.db");
			$db->exec("PRAGMA foreign_keys = ON");
			$db->exec("update pizzasabor set sabor = '".$_POST["sabor"]."' where codigo = ".$_POST["codigo"]);
			$db->exec("update tipo set tipo = '".$_POST["tipo"]."'where codigo = ".$_POST["codigo"]);
			$db->exec("update saboringrediente set sabor = '".$_POST["sabor"]."', ingrediente = '".$_POST["ingrediente"]."' where codigo = ".$_POST["codigo"]);

			echo $db->changes()." pizza(s) alterada(s)";
			$db->close();
		} else {
			echo "<font color=\"red\">".$error."</font>";
		}
	}
}
?>
</body>
<?php
if (isset($_POST["confirma"])) {
	echo "<script>setTimeout(function () { window.open(\"select.php\",\"_self\"); }, 3000);</script>";
}
?>
</html>

