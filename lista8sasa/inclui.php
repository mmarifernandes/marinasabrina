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
			$db->exec("insert into pizza (codigo, comanda, tamanho, borda) values ($total, '".strtoupper($_POST["sabor"])."', '".$_POST["selecttipos"]."')");
			// for($i=0;$i<count($valores);$i++){
			// 	// echo $valores[$i];
			// 	$db->exec("insert into comanda (numero, data) values ($total, $valores[$i])");
			// }
			
			
			echo $db->changes()." pizza(s) incluída(s)<br>\n";
			echo $total." é o código da última pizza incluída.\n";
			$db->close();
		} else {
			echo "<font color=\"red\">".$error."</font>";
	}
} else {

    echo '<form name="inclui" action="select.php" method="POST">';
    echo '<table id="table1">';
    echo "<h1>Inclusão de Pizza</h1>\n";
    echo '<tbody>';
	
    echo '<tr>';
    echo '<td><label for="numero">Número</label></td>';
    echo '<td>'.$_GET['numero'].'</td>';
    echo '</tr>';
	
    echo '<tr>';
    echo '<td><label for="data">Data</label></td>';
	    echo '<td>'.$_GET['data'].'</td>';

    echo '</tr>';
	
    echo '<tr>';
    echo '<td><label for="tamanho">Tamanho</label></td>';
    echo '<td>';
    echo '<select name="tamanho" id="tamanho">';
	$tamanho = $db->query("select tamanho.nome as tamanho, tamanho.codigo as codigo from tamanho");
    while ($tam = $tamanho->fetchArray()) {
		echo "<option value=\"".$tam["codigo"]."\">".strtolower($tam["tamanho"])."</option>";
    }
    echo '</select>';
    echo '</td>';
	
    echo '<tr>';
    echo '<td><label for="borda">Borda</label></td>';
	
    echo '<td>';
    echo '<select name="borda" id="borda">';
 	$results = $db->query("select borda.codigo as bordacodigo, borda.nome as borda from borda");
	 
    echo '<option value="nao">não</option>';
	while ($row = $results->fetchArray()) {
		echo "<option value=\"".$row["bordacodigo"]."\">".strtolower($row["borda"])."</option>\n";
	}
    echo '</select>';
    echo '</td>';
    echo '</tr>';
	
    echo '<tr>';
    echo '<td><label for="sabor">Sabor</label></td>';
    echo '<td>';
    
    echo '<select name="tipo" id="tipo" onchange="muda();">';
    $results = $db->query("select tipo.codigo as tipocodigo, tipo.nome as tipo from tipo");
	while ($row = $results->fetchArray()) {
		echo "<option value=\"".$row["tipocodigo"]."\">".strtolower($row["tipo"])."</option>\n";
	}
	echo '</select>';
    // if(isset($_GET["sabor"]))
    echo "<input type=\"hidden\" id=\"tipovalor\" name=\"tipovalor\">";
    echo '<select name="selectsabor" id="sabor">';
	
	echo '</select>';   
	echo '<label><input type="button" name = "mais" value="mais" src="mais.png" width = "2%" onclick="add();"></label>';
	echo "</td>";
    echo '</tr>';
    echo "<tr>\n";
	
    echo '<td><label for="sabores">Sabores</label></td>';
    echo '<td>';	
    echo '<table id="tablesabores" border=1></table>';
    echo "</td>";
	echo "<input type=\"hidden\" id=\"optionsarray\" name=\"optionsarray\">";
	echo "</tr>\n";
    echo '<td><input type="button" name="inclui" value="Inclui"</td>';
    echo '<tbody>';
    echo '</table>';
    echo '</form>';
}
        ?>
    </body>
    <script>
        
	function muda() {
			var select = document.getElementById("sabor");
			select.innerHTML = "";
		
		// console.log(select)
	
		switch (document.getElementById("tipo").value) {
			
				case "1":
					<?php 
$results2 = $db->query("select sabor.codigo as saborcodigo, sabor.nome as sabor from sabor where tipo = 1");
$list_count = 0;
$list_count1 = 0;
$list_count2 = 0;
	while ($row2 = $results2->fetchArray()) {
		
        ?>
	

            select.options[<?php echo $list_count; ?>]=new Option("<?php echo $row2['sabor']; ?>", "<?php echo $row2['saborcodigo']; ?>");
			<?php
                $list_count++;
            } ?>
			break;

		case "2":
 <?php 
$results3 = $db->query("select sabor.codigo as saborcodigo, sabor.nome as sabor from sabor where tipo = 2");
	// echo '<script>';
	while ($row3 = $results3->fetchArray()) {
		
        ?>
	

            select.options[<?php echo $list_count1; ?>]=new Option("<?php echo $row3['sabor']; ?>", "<?php echo $row3['saborcodigo']; ?>");
			<?php
                $list_count1++;
            } ?>
        
		break;
        case "3":
 <?php 
$results4 = $db->query("select sabor.codigo as saborcodigo, sabor.nome as sabor from sabor where tipo = 3");
	// echo '<script>';
	while ($row4 = $results4->fetchArray()) {
		
        ?>
            select.options[<?php echo $list_count2; ?>]=new Option("<?php echo $row4['sabor']; ?>", "<?php echo $row4['saborcodigo']; ?>");
			<?php
                $list_count2++;
            } ?>
        
		break;
   
    }
		for(let i = 0;i<select.options.length; i++){
			select.options[i].setAttribute('id', i);
			// console.log('asdasd')
		}
}

        
		let options = []
		let valores = []
	let i=0;
	let b =document.querySelector("#optionsarray")
		b.setAttribute('value', options )

	function add(){
					
		
		let table = document.querySelector("#tablesabores");
		let select1 = document.querySelector("#sabor")
		// let valor = document.querySelectorAll("#ingrediente")
		let botao = document.getElementById("mais");
		let x = table.insertRow(-1);
		let rowID = table.rows.length;
		x.setAttribute('id', rowID );

	
		console.log(select1.options[select1.selectedIndex].id);
		// let option = document.querySelectorAll("#ingrediente")[select.value-1]
		options.push(select1.value);
		options;
		
		
		x.innerHTML = '<tr><td id = '+i+'><input type="hidden" name="valor" value='+options+'>'+select1.options[select1.selectedIndex].text+'</td><td><input type="button" name = "menos" id = "menos" value="menos"  width = "2%" onclick="tira(this);"></td></tr>'
		i++;
		let b =document.querySelector("#optionsarray")
		b.setAttribute('value', options )
		// }
		// console.log(select.value);
		// console.log(option);

		// console.log(select.getElementsById("ingrediente"));

		// options.push(valores);
		// console.log(valores)
	};
			
	function tira(t){
		let row = t.closest('tr');
		let table = document.querySelector("#tablesabores");
		let select = document.querySelector("#sabor")
		// let option = document.querySelectorAll("#ingrediente")[options[row.rowIndex]-1]
		// let botao = document.getElementById("mais");
		// if(option.disabled = true){
			// option.disabled = false;
			// }
			// console.log(option)
			// let a = t.closest('tr').id;
			console.log(row.id-1)
			// console.log(t.closest('tr').id);
			// option.disabled = false;
			options.splice(row.rowIndex, 1);
			document.getElementById("tablesabores").deleteRow(row.rowIndex);
			let b =document.querySelector("#optionsarray")
			b.setAttribute('value', options )
			// console.log(botao);
		


	
	};
    </script> 
</html>