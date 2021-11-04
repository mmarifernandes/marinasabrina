<html>
    <body>
    <?php
    $db = new SQLite3("pizzaria.db");
    $db->exec("PRAGMA foreign_keys = ON");
    $numero = $db->query("select comanda.numero as numero from comanda where numero = ".$_GET['numero']) ->fetchArray();
    $tamanho = $db->query("select tamanho.nome as tamanho from tamanho");

    echo '<form name="inclui" action="select.php" method="POST">';
    echo '<table id="table1">';
    echo "<h1>Inclusão de Pizza</h1>\n";
    echo '<tbody>';

    echo '<tr>';
    echo '<td><label for="numero">Número</label></td>';
    echo '<td><input type="number" name="numero" id="numero" value="'.$numero["numero"].'" readonly></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td><label for="data">Data</label></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td><label for="tamanho">Tamanho</label></td>';
    echo '<td>';
    echo '<select name="tamanho" id="tamanho">';
    while ($tam = $tamanho->fetchArray()) {
        echo "<option value=\"".$tam["codigo"]."\">".$tam["tamanho"]."</option>";
    }
    echo '</select>';
    echo '</td>';

    echo '<tr>';
    echo '<td><label for="borda">Borda</label></td>';

    echo '<td>';
    echo '<select name="borda" id="borda">';
    echo '<option value="sim">Sim</option>';
    echo '<option value="nao">Não</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td><label for="sabor">Sabor</label></td>';
    echo '<td>';

    echo '<select name="sabor" id="sabor" onchange="tipo(this.value)">';
    $results = $db->query("select * from tipo");
    while ($tipo = $results -> fetchArray()) {
        echo "<option value=\"".$tipo["codigo"]."\">".$tipo["nome"]."</option>";
        }
        echo '</select>';
        echo '<select class="sabores" name="salgadatrad" id="salgadatrad" value="1" hidden>';
        $salgadatrad = $db->query("select sabor.nome as nome from sabor join tipo on sabor.tipo = tipo.codigo where tipo.codigo = 1");
        while($st = $salgadatrad->fetchArray()) {
            echo "<option value=\"".$row["codigo"]."\">".$row["nome"]."</option>";
        }
        echo '</select>';


        echo '<select class="sabores" name="salgadaespecial" id="salgadaespecial" value="2" hidden>';
        $salgadaespecial = $db->query("select sabor.nome as nome from sabor join tipo on sabor.tipo = tipo.codigo where tipo.codigo = 2");
        while($se = $salgadaespecial->fetchArray()) {
            echo "<option value=\"".$salgadaespecial["codigo"]."\">".$salgadaespecial["nome"]."</option>";
        }
        echo '</select>';


        echo '<select class="sabores" name="docetrad" id="docetrad" value="3" hidden>';
        $docetrad = $db->query("select sabor.nome as nome from sabor join tipo on sabor.tipo = tipo.codigo where tipo.codigo = 3");
        while($dt = $docetrad->fetchArray()) {
            echo "<option value=\"".$dt["codigo"]."\">".$dt["nome"]."</option>";
        }
        echo '</select>';
        echo '<input name="add" type="button" value="mais" onclick="add();">'; //add function
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td><label for="sabores">Sabores</label></td>';
        echo '<td>';
        echo '</td></tr>';
        echo '<table id="table2"></table>';


        echo '<td><input type="submit" name="inclui" value="Inclui"</td>';
        echo '<tr>';
        echo '<tbody>';
        echo '</table>';
        echo '</form>';
        echo '<form name="letraE" action="select.php" method="post">';
    ?>
    </body>
    <script>
		let options = []
		let valores = []
	let i=0;
	let table = document.querySelector("#table1");
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
    </script>
</html>