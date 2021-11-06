<html>
    <body>
    <?php
	$db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
	if (isset($_POST["inclui"])) {
		$error = "";
	
		$x = $_POST['optionsarray'];
		$valores = explode(",",$x);
		// echo $x;
		$total = $db->query("select count(*) as total from pizza")->fetchArray()["total"];
		
		
		//coloque aqui o código para validação dos campos recebidos
		//se ocorreu algum erro, preencha a variável $error com uma mensagem de erro
		// echo $total;
		
		if ($error == "") {
			$total++;
			$db = new SQLite3("pizzaria.db");
			$db->exec("PRAGMA foreign_keys = ON");
			// echo $_POST['tamanho'];

			if($_POST["borda"] == "0"){
				$db->exec("insert into pizza (codigo, comanda, tamanho) values ($total, '".$_POST['numero']."', '".$_POST["tamanho"]."')");

			}else{
			
			$db->exec("insert into pizza (codigo, comanda, tamanho, borda) values ($total, '".$_POST['numero']."', '".$_POST["tamanho"]."', '".$_POST["borda"]."')");
			};
			for($i=0;$i<count($valores);$i++){
					// echo $valores[$i];
					$db->exec("insert into pizzasabor (pizza, sabor) values ($total, $valores[$i])");
			}
				
				
				echo $db->changes()." pizza(s) incluída(s)<br>\n";
				echo $total." é o código da última pizza incluída.\n";
				$db->close();
			} else {
				echo "<font color=\"red\">".$error."</font>";
			}


if (isset($_POST["inclui"])) {
	echo "<script>setTimeout(function () { window.open(\"select.php\",\"_self\"); }, 3000);</script>";
}


		} else {

			echo "<form name=\"incluiform\" action=\"inclui.php\" method=\"post\">\n";
			echo '<table id="table1">';
			echo "<h1>Inclusão de Pizza</h1>\n";
			echo '<tbody>';
			
			echo '<tr>';
			echo '<td><label for="numero">Comanda:</label></td>';
			echo '<td>'.$_GET['numero'].'</td>';
			echo '</tr>';
				echo "<input type=\"hidden\" id=\"numero\" name=\"numero\" value=\"".$_GET['numero']."\">";

			
			echo '<tr>';
			echo '<td><label for="data">Data</label></td>';
			$data = $db->query("select case strftime('%w', data)
when '0' then 'Dom'
when '1' then 'Seg'
when '2' then 'Ter'
when '3' then 'Qua'
when '4' then 'Qui'
when '5' then 'Sex'
when '6' then 'Sab'
end || strftime(' %d/%m/%Y',data) as data from comanda where numero = ".$_GET['numero']);
			while ($row = $data->fetchArray()) {
			echo '<td>'.$row['data'].'</td>';
			}
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
	 
    echo '<option value="0">não</option>';
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
		    echo '<option value="selecione">Selecione</option>';

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
    echo '<tbody>';
    echo '</table>';
    echo "<input type=\"submit\" name=\"inclui\" value=\"inclui\">";
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
	

            select.options[<?php echo $list_count; ?>]=new Option("<?php echo strtolower($row2['sabor']); ?>", "<?php echo $row2['saborcodigo']; ?>");
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
	

            select.options[<?php echo $list_count1; ?>]=new Option("<?php echo strtolower($row3['sabor']); ?>", "<?php echo $row3['saborcodigo']; ?>");
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
            select.options[<?php echo $list_count2; ?>]=new Option("<?php echo strtolower($row4['sabor']); ?>", "<?php echo $row4['saborcodigo']; ?>");
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

        
		let options1 = []
		let valores = []
	let i=0;
	let b =document.querySelector("#optionsarray")
		b.setAttribute('value', options1 )

	function add(){
					
		

		let select1 = document.querySelector("#sabor")

		let option = select1.options[select1.selectedIndex].value;

		if(options1.indexOf(option) !== -1) {
			alert("Ingrediente já inserido");
			return;
		}else{
			let table = document.querySelector("#tablesabores");
			let botao = document.getElementById("mais");
			let x = table.insertRow(-1);
			let rowID = table.rows.length;
			let b =document.querySelector("#optionsarray")
			options1.push(select1.value);
	
			// console.log(option);
			// let option = document.querySelectorAll("#ingrediente")[select.value-1]
			
			
			x.setAttribute('id', rowID );
			x.innerHTML = '<tr><td id = '+i+'><input type="hidden" name="valor" value='+options1+'>'+select1.options[select1.selectedIndex].text+'</td><td><input type="button" name = "menos" id = "menos" value="menos"  width = "2%" onclick="tira(this);"></td></tr>'
			i++;
			b.setAttribute('value', options1 )
			
			
		}
	};
			
	function tira(t){
		let row = t.closest('tr');
		let table = document.querySelector("#tablesabores");
		let select1 = document.querySelector("#sabor")
		// let option =select1.options[t.closest('tr').rowIndex]


		// select1.option[options1[select1.options[t.closest('tr').rowIndex].id]].disabled = false;

		// console.log(select1.options[options1[select1.options[t.closest('tr').rowIndex].id]])

			// console.log(t.parentElement.previousElementSibling);
			// let a = t.closest('tr').id;
			// console.log(row.id-1)
			// console.log(t.closest('tr').id);
			options1.splice(row.rowIndex, 1);
			document.getElementById("tablesabores").deleteRow(row.rowIndex);
			let b =document.querySelector("#optionsarray")
			b.setAttribute('value', options1 )
			// console.log(botao);
		


	
	};
    </script> 

</html>