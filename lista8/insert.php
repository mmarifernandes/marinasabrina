<html>
	<body>
		<?php
	$db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
	if (isset($_POST["inclui"])) {
		$error = "";
		// echo $_POST['selectingredientes'];
		// echo $_POST['selecttipos'];
		$x = $_POST['valor'];
		$valores = explode(",",$x);
		$total = $db->query("select count(*) as total from sabor")->fetchArray()["total"];

		
		
		//coloque aqui o código para validação dos campos recebidos
		//se ocorreu algum erro, preencha a variável $error com uma mensagem de erro
		// echo $total;
		
		if ($error == "") {
			$total++;
			$db = new SQLite3("pizzaria.db");
			$db->exec("PRAGMA foreign_keys = ON");
			$db->exec("insert into sabor (codigo, nome, tipo) values ($total, '".strtoupper($_POST["sabor"])."', '".$_POST["selecttipos"]."')");
			for($i=0;$i<count($valores);$i++){
				// echo $valores[$i];
				$db->exec("insert into saboringrediente (sabor, ingrediente) values ($total, $valores[$i])");
			}
			
			
			echo $db->changes()." pizzaria(s) incluída(s)<br>\n";
			echo $total." é o código da última pizza incluída.\n";
			$db->close();
		} else {
			echo "<font color=\"red\">".$error."</font>";
	}
} else {
	echo "<h1>Inclusão de Sabor</h1>\n";
	
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
	$results = $db->query("select tipo.codigo as tipocodigo, tipo.nome as tipo from tipo");
	while ($row = $results->fetchArray()) {
		echo "<option value=\"".$row["tipocodigo"]."\">".strtolower($row["tipo"])."</option>\n";
	}
	echo '</select>';
	echo "</td>";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Ingrediente</td>\n";
	echo "<td>";
	echo '<select id="selectingredientes" name="selectingredientes">';
	$results = $db->query("select ingrediente.codigo as ingcodigo, ingrediente.nome as ingrediente from ingrediente");
	while ($row = $results->fetchArray()) {
		echo "<option id=\"ingrediente\" value=\"".$row["ingcodigo"]."\"name=\"ingrediente\">".strtolower($row["ingrediente"])."</option>\n";
	}
	
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
?>
</body>
<script>
	let options = []
	let i=0;

	function add(){
		let table = document.querySelector("#tableingredientes");
		let select = document.querySelector("#selectingredientes")
		let valor = document.querySelectorAll("#ingrediente")


		options.push(select.value);
		options;

		let x = table.insertRow(-1);
			x.innerHTML = '<tr><td id = '+i+'><input type="hidden" name="valor" value='+options+'>'+select.options[select.value-1].text+'</td><td><label><input type="button" name = "menos" id = "menos" value="menos"  width = "2%" onclick="tira();"></label></td></tr>'
			i++;
			
		};
		
		
		function tira(){
			let table = document.querySelector("#tableingredientes");
			let tableRows = document.querySelector("#tableingredientes").rows;
			let botao = document.getElementById("menos");
			let a= table.rows[0].cells[0]
			console.log(options);
			console.log(document.getElementById("menos"));

			// var table = document.getElementById("tableID");

  for (var i = 0; i < table.rows.length; i++) {
    botao.onclick = function apaga() {
      delet(table.rows[i]);
    };
  
}
			// for (let i = 0; i < tableRows.length; i++) {
				// 	let selecionado = []
				// 	if (selecionado) {
					// 		selecionados.push(i);
					// 		console.log(selecionado);
					// 	}
					
					// }
					// for (var k = 0; k < selecionados.length; k++) {
						// table.deleteRow(options[table.value]);
						//   }
						// delet(selecionado[]);
						
						
					};
					
					function delet(){
					let table = document.querySelector("#tableingredientes");
    				table.deleteRow(table.rows[i]);
  
		};	

</script>
<?php


if (isset($_POST["inclui"])) {
	echo "<script>setTimeout(function () { window.open(\"select.php\",\"_self\"); }, 3000);</script>";
}
?>
</html>

