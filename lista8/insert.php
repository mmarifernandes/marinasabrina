<html>
	<body>
		<?php
	$db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
	if (isset($_POST["inclui"])) {
		$error = "";
		// echo $_POST['selectingredientes'];
		// echo $_POST['selecttipos'];
		$x = $_POST['optionsarray'];
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
	echo "<input type=\"hidden\" id=\"optionsarray\" name=\"optionsarray\">";

	echo "</table>\n";
	echo "<input type=\"submit\" name=\"inclui\" value=\"inclui\">\n";
	echo "</form>\n";
}
?>
</body>
<script>
		let options = []
		let valores = []
	let i=0;
	let table = document.querySelector("#tableingredientes");
	for(let i = 0; i<table.rows.length; i++){
		// console.log((document.querySelectorAll("#valores")[i]).value);
		options.push((document.querySelectorAll("#valores")[i]).value);
		valores.push((document.querySelectorAll("#valores")[i]).value);

		
		// console.log(valores);
	}
	for(let i = 0; i<options.length; i++){
		let select1 = document.querySelector("#selectingredientes")
		let option1 = document.querySelectorAll("#ingrediente")[options[i]-1]

		option1.disabled = true;

	}
	let b =document.querySelector("#optionsarray")
		b.setAttribute('value', options )
	function add(){
		let table = document.querySelector("#tableingredientes");
		let select = document.querySelector("#selectingredientes")
		let valor = document.querySelectorAll("#ingrediente")
		let botao = document.getElementById("mais");
		let option = document.querySelectorAll("#ingrediente")[select.value-1]
		options.push(select.value);
		options;
		valores.push(select.value);
		valores;
		if(option.disabled == true){
			alert("Ingrediente já inserido")
		}else{
		option.disabled = true;
		let x = table.insertRow(-1);
		let rowID = table.rows.length;
		x.setAttribute('id', rowID );
		x.innerHTML = '<tr><td id = '+i+'><input type="hidden" name="valor" value='+options+'>'+select.options[select.value-1].text+'</td><td><input type="button" name = "menos" id = "menos" value="menos"  width = "2%" onclick="tira(this);"></td></tr>'
		i++;
		let b =document.querySelector("#optionsarray")
		b.setAttribute('value', options )
		}
		// console.log(select.value);
		// console.log(option);

		// console.log(select.getElementsById("ingrediente"));

		// options.push(valores);
		// console.log(valores)
	};
	
	
	function tira(t){
		let row = t.closest('tr');
		let table = document.querySelector("#tableingredientes");
		let select = document.querySelector("#selectingredientes")
		let option = document.querySelectorAll("#ingrediente")[options[row.rowIndex]-1]
		let botao = document.getElementById("mais");
		// if(option.disabled = true){
			// option.disabled = false;
			// }
			console.log(option)
			let a = t.closest('tr').id;
			console.log(row.id-1)
			// console.log(t.closest('tr').id);
			option.disabled = false;
			options.splice(row.rowIndex, 1);
			document.getElementById("tableingredientes").deleteRow(row.rowIndex);
			let b =document.querySelector("#optionsarray")
			b.setAttribute('value', options )
			// console.log(botao);
		


	
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
		
         
				var input = document.getElementById("nome")
				console.log(input.pattern);
			
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

