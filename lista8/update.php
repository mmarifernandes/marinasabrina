<html>
	<body>
		<?php
if (isset($_GET["codigo"])) {
	$db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$results = $db->query("select * from sabor where codigo = ".$_GET["codigo"]);
	
	$row = $results->fetchArray();
	
	if ($row === false) {
		echo "<font color=\"red\">pizza não encontrada</font>";
	} else {
		$options = [];
		echo "<h1>Alteração de Sabor</h1>\n";
		echo "<form name=\"update\" action=\"update.php\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"codigo\" value=\"".$row["codigo"]."\">";
		echo "<table>\n";
		echo "<tr>\n";
		echo "<td>Nome</td>\n";
		echo "<td><input type=\"text\" id=\"nome\" name=\"nome\" value=\"".ucfirst(strtolower($row["nome"]))."\" pattern=\"[a-zA-Z\s]+$\" required size=\"50\"></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>Tipo</td>\n";
		echo "<td>";
		echo "<select name='selecttipos'>";
		$results1 = $db->query("select tipo.codigo as tipocodigo, tipo.nome as tipo from tipo");
		while ($row1 = $results1->fetchArray()) {
			echo "<option name=\"".$row1["tipocodigo"]."\" value=\"".$row1["tipocodigo"]."\">".strtolower($row1["tipo"])."</option>\n";
		}
		echo "</select>";
		echo "</td>";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>Ingrediente</td>\n";
		echo "<td>";
		echo '<select id="selectingredientes" name="selectingredientes">';
		$results2 = $db->query("select ingrediente.codigo as ingcodigo, ingrediente.nome as ingrediente from ingrediente");
		while ($row2 = $results2->fetchArray()) {
			// $options[] += $row2["ingcodigo"];
			echo "<option id=\"ingrediente\" value=\"".$row2["ingcodigo"]."\"name=\"ingrediente\">".strtolower($row2["ingrediente"])."</option>\n";
		}
		
		echo '</select>';
		
		echo '<label><input type="button" id = "mais" name = "mais" value="mais" src="mais.png" width = "2%" onclick="add();"></label>';
		
		
		echo "</td>";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>Ingredientes</td>\n";
		echo "<td>";
		echo "<table id=\"tableingredientes\" border=\"1\">\n";
		$i = 0;
		$e = 1;
		$results3 = $db->query("select ingrediente.nome as ingrediente, ingrediente as ingcodigo from saboringrediente join ingrediente on saboringrediente.ingrediente = ingrediente.codigo where sabor = ".$row["codigo"]);
		while ($row3 = $results3->fetchArray()) {
			$options[] += $row3["ingcodigo"];
			$valores = implode(",",$options);
			echo "<tr id='$e'><td id = '$i'><input type='hidden' id = 'valores' name='$valores' value=".$row3["ingcodigo"].">".strtolower($row3["ingrediente"])."</td><td><label><input type='button' name = 'menos' id = 'menos' value='menos'  width = '2%' onclick='tira(this);'></label></td></tr>";
			$i++;
			$e++;
		}
		
		echo "<input type=\"hidden\" id=\"valoresteste\" name=\"valores\"  value=\"".$valores."\">";
		// echo "<input type=\"hidden\" name=\"merge\" value=\"".$merge."\">";

	echo "</table>\n";
		echo "<input type=\"hidden\" id=\"optionsarray\" name=\"optionsarray\">";

	echo "</td>";
	echo "</tr>\n";
	
	echo "</table>\n";
	echo "<input type=\"submit\" name=\"confirma\" onclick=\"return valida();\" value=\"confirma\">\n";
	echo  '<div id="mensagem" align="center" style="position:fixed; top:20px; left:10%; width:80%; padding:5px 5px 5px 5px; display:none;"></div>';

	echo "</form>\n";
}
$db->close();
} else {
	if (isset($_POST["confirma"])) {
		
		$error = 0;
			//coloque aqui o código para validação dos campos recebidos
			//se ocorreu algum erro, preencha a variável $error com uma mensagem de erro
			if($_POST["optionsarray"]== ""){
			$error++;
		}
		if($_POST["nome"] == ""){
			$error++;
		}
		if($_POST["nome"] !== "" && !preg_match("#[a-zA-Z\s]+$#", $_POST["nome"])){
			$error++;
		}

	
		if ($error == 0) {
			$post = $_POST["codigo"];
			$db = new SQLite3("pizzaria.db");
			$db->exec("PRAGMA foreign_keys = ON");
			$db->exec("update sabor set nome = '".strtoupper($_POST["nome"])."', tipo = '".$_POST["selecttipos"]."' where codigo = ".$_POST["codigo"]);
			$db->exec("delete from saboringrediente where sabor = " .$post);

			if (isset($_POST['optionsarray'])){  
				$x = $_POST['optionsarray'];
				$valores2 = explode(",",$x);
			
				
			
				for($i=0;$i<count($valores2);$i++){
				$db->exec("insert into saboringrediente (sabor, ingrediente) values ($post, '".$valores2[$i]."')");
		
				};
			}

			
			echo $db->changes()." pizza(s) alterada(s)";
			$db->close();
		} else {
			echo "<font color=\"red\">Erro!</font>";
		}
	}
}
?>
</body>
<script>
		let options = []
		let valores = []
	let i=0;
	let table = document.querySelector("#tableingredientes");
	for(let i = 0; i<table.rows.length; i++){
		options.push((document.querySelectorAll("#valores")[i]).value);
		valores.push((document.querySelectorAll("#valores")[i]).value);

	}

	for(let i = 0; i<options.length; i++){
		let select1 = document.querySelector("#selectingredientes")
		let option1 = document.querySelectorAll("#ingrediente")[options[i]-1]

		option1.disabled = true;

	}
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

			console.log(option)
			if(option.disabled = true){
				option.disabled = false
			}
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
if (isset($_POST["confirma"])) {
	echo "<script>setTimeout(function () { window.open(\"select.php\",\"_self\"); }, 3000);</script>";
}
?>
</html>

