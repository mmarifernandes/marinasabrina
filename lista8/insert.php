<html>
	<body>
		<?php
	$db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
	if (isset($_POST["inclui"])) {
		$error = 0;
		// echo $_POST['selectingredientes'];
		// echo $_POST['selecttipos'];
		$x = $_POST['optionsarray'];
		$valores = explode(",",$x);
		$total = $db->query("select count(*) as total from sabor")->fetchArray()["total"];

		if($_POST["optionsarray"]== ""){
			$error++;
		}
		if($_POST["sabor"] == ""){
			$error++;
		}

		if($_POST["sabor"] !== "" && !preg_match("#[a-zA-Z\s]+$#", $_POST["sabor"])){
			$error++;
		}
	
		//coloque aqui o código para validação dos campos recebidos
		//se ocorreu algum erro, preencha a variável $error com uma mensagem de erro
		// echo $total;
		
		if ($error == 0) {
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
			echo "<font color=\"red\">".$error." ERRO(S)</font>";
	}
} else {
	echo "<h1>Inclusão de Sabor</h1>\n";
	
	echo "<form name=\"insert\" action=\"insert.php\" method=\"post\">\n";
	echo "<table>\n";
	echo "<tr>\n";
	echo "<td>Nome</td>\n";
	echo "<td><input type=\"text\" id=\"nome\" name=\"sabor\" value=\"\" pattern=\"[a-zA-Z\s]+$\" required size=\"50\"></td>\n";
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
	echo "<input type=\"hidden\" id=\"optionsarray\" name=\"optionsarray\">";

	echo "</table>\n";
	echo "<input type=\"submit\" name=\"inclui\" onclick=\"return valida();\" value=\"inclui\" >\n";
	echo  '<div id="mensagem" align="center" style="position:fixed; top:20px; left:10%; width:80%; padding:5px 5px 5px 5px; display:none;"></div>';

	echo "</form>\n";
}
?>
</body>
<script>
		let options = []
	
	let i=0;
	let table = document.querySelector("#tableingredientes");
	

		let b =document.querySelector("#optionsarray")
		b.setAttribute('value', options )

	function add(){
		let select = document.querySelector("#selectingredientes")
		let option = select.options[select.selectedIndex].value;
		
		
		if(options.indexOf(option) !== -1){
			alert("Ingrediente já inserido")
		}else{
			let table = document.querySelector("#tableingredientes");
			let x = table.insertRow(-1);
			let rowID = table.rows.length;
			let b =document.querySelector("#optionsarray")
			options.push(select.value);



		x.setAttribute('id', rowID );
		x.innerHTML = '<tr><td id = '+i+'><input type="hidden" name="valor" value='+options+'>'+select.options[select.value-1].text+'</td><td><input type="button" name = "menos" id = "menos" value="menos"  width = "2%" onclick="tira(this);"></td></tr>'
		i++;
		b.setAttribute('value', options )
		}

	};
	
	
	function tira(t){
		let row = t.closest('tr');
		let table = document.querySelector("#tableingredientes");
		let select = document.querySelector("#selectingredientes")
		let option = document.querySelectorAll("#ingrediente")[options[row.rowIndex]-1]

			console.log(row.id-1)

			options.splice(row.rowIndex, 1);
			document.getElementById("tableingredientes").deleteRow(row.rowIndex);
			let b =document.querySelector("#optionsarray")
			b.setAttribute('value', options )



	
	};

	function mensagem(cor, texto) {
			var div = document.getElementById("mensagem");
			div.innerHTML = texto;
			div.style.display = "block";
			div.style.backgroundColor = cor;
			setTimeout(function () {
				div.style.display = "none";
			}, 3000);
		}

		function valida() {
		let table = document.querySelector("#tableingredientes");

		if(table.rows.length === 0){

				mensagem("red", "ERRO");
				return false;
				
			}
         
				var input = document.getElementById("nome")
				console.log(input);
			
					var regexp = new RegExp(input.pattern);
					if (!regexp.test(input.value)) {
						mensagem("red", "ERRO");
						input.value = "";
						input.focus();
						return false;
					}else{
						mensagem("green", "OK");
						return true;
					};
            }
</script>
<?php


if (isset($_POST["inclui"])) {
	echo "<script>setTimeout(function () { window.open(\"select.php\",\"_self\"); }, 3000);</script>";
}
?>
</html>

