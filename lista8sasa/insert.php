<html>
	<body>
		<?php
	if (isset($_POST["inclui"])) {
		$error = "";
		if ($error == "") {
			$db = new SQLite3("pizzaria.db");
			$db->exec("PRAGMA foreign_keys = ON");
			$db->exec("insert into comanda (numero, data, mesa, pago) values (".$_POST['numero'].",  (date('now')), ".$_POST['mesa'].", false)");
            echo $db->changes()." comanda(s) incluída(s)<br>\n";
            echo $db->lastInsertRowID()." é o código da última comanda incluída.\n";
			echo $_POST['numero'];
			$db->close();
		} else {
			echo "<font color=\"red\">".$error."</font>";
	}
} else {
    $db = new SQLite3("pizzaria.db");
    $prox = $db->query("select numero+1 as prox from comanda order by numero desc limit 1")->fetchArray();
	echo "<form name=\"insert\" action=\"insert.php\" method=\"post\">\n";
	echo "<table>\n";
    echo "<h1>Inclusão de Comanda</h1>\n";
    echo "<tbody>";

	echo "<tr>\n";
	echo '<td><label for="numero">Número</label></td>';
    echo '<td><input type="text" name="numero" id="numero" readonly value = "'.$prox['prox'].'"></td>';
    echo "<tr>\n";

    echo "<tr>\n";
	echo '<td><label for="data">Data</label></td>';
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	echo '<td>'.ucfirst(strftime('%a %d/%m/%Y', strtotime('today'))).'</td>';
    echo "</tr>\n";
	$mesa = $db->query("select mesa.nome as mesa, mesa.codigo as codigo from mesa");
    echo "<tr>\n";
	echo '<td><label for="mesa">Mesa</label></td>';
    echo '<td><select name="mesa" id="mesa">';
	while ($m = $mesa->fetchArray()) {
		echo "<option value=\"".$m["codigo"]."\">".$m["mesa"]."</option>";
    	}
	echo '</select>';
	echo '</td>';
	echo "</tr>\n";

    echo '</tbody>';
    echo '</table>';
    

	echo "<input type=\"submit\" name=\"inclui\" value=\"Inclui\">\n";
	echo "</form>\n";

}
?>
</body>
<?php
if (isset($_POST["inclui"])) {
	echo "<script>setTimeout(function () { window.open(\"select.php\",\"_self\"); }, 3000);</script>";
}
?>
</html>