<html>
<body>
<?php
function url($campo, $valor) {
	$result = array();
	if (isset($_GET["numero"])) $result["numero"] = "numero=".$_GET["numero"];
	if (isset($_GET["data"])) $result["data"] = "data=".$_GET["data"];
	if (isset($_GET["mesa"])) $result["mesa"] = "mesa=".$_GET["mesa"];
	if (isset($_GET["pizza"])) $result["pizza"] = "pizza=".$_GET["pizza"];
    if (isset($_GET["valor"])) $result["valor"] = "valor=".$_GET["valor"];
    if (isset($_GET["pago"])) $result["pago"] = "pago=".$_GET["pago"];
	if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
	if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
	$result[$campo] = $campo."=".$valor;
	return("select.php?".strtr(implode("&", $result), " ", "+"));
}

$db = new SQLite3("pizzaria.db");
$db->exec("PRAGMA foreign_keys = ON");

$limit = 5;

echo "<h1>Cadastro de comandas</h1>\n";

echo "<select id=\"campo\" name=\"campo\">\n";
echo "<option value=\"numero\"".((isset($_GET["numero"])) ? " selected" : "").">Número</option>\n";
echo "<option value=\"data\"".((isset($_GET["data"])) ? " selected" : "").">Data</option>\n";
echo "<option value=\"mesa\"".((isset($_GET["mesa"])) ? " selected" : "").">Mesa</option>\n";
echo "<option value=\"pizza\"".((isset($_GET["pizza"])) ? " selected" : "").">Pizza</option>\n";
echo "<option value=\"valor\"".((isset($_GET["valor"])) ? " selected" : "").">Valor</option>\n";
echo "<option value=\"pago\"".((isset($_GET["pago"])) ? " selected" : "").">Pago</option>\n";
echo "</select>\n"; 

$value = "";
if (isset($_GET["numero"])) $value = $_GET["numero"];
if (isset($_GET["data"])) $value = $_GET["data"];
if (isset($_GET["mesa"])) $value = $_GET["mesa"];
if (isset($_GET["pizza"])) $value = $_GET["pizza"];
if (isset($_GET["valor"])) $value = $_GET["valor"];
if (isset($_GET["pago"])) $value = $_GET["pago"];
echo "<input type=\"text\" id=\"valor1\" name=\"valor1\" value=\"".$value."\" size=\"20\"> \n";


//ECHO '&#128179';
$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];
echo "<a href=\"\" id=\"valida\" onclick=\" valida(); value = document.getElementById('valor1').value.trim().replace(/ +/g, '+'); result = '".strtr(implode("&", $parameters), " ", "+")."'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='select.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
echo "<br>\n";

echo "<table border=\"1\">\n";
echo "<tr>\n";
echo "<td><a href=\"insert.php\">&#x1F4C4;</a></td>\n";
// $data = strftime('%Y/%m/%d', 'data');

echo "<td><b>Número</b> <a href=\"".url("orderby", "numero+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "numero+desc")."\">&#x25B4;</a></td>\n";

echo "<td><b>Data</b> <a href=\"".url("orderby", "strftime('%Y/%m/%d', data)+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "strftime('%Y/%m/%d',data)+desc")."\">&#x25B4;</a></td>\n";

echo "<td><b>Mesa</b> <a href=\"".url("orderby", "mesa+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "mesa+desc")."\">&#x25B4;</a></td>\n";

echo "<td colspan=2><b>Pizza</b> <a href=\"".url("orderby", "pizza+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "pizza+desc")."\">&#x25B4;</a></td>\n";

echo "<td><b>Valor</b> <a href=\"".url("orderby", "valor+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "valor+desc")."\">&#x25B4;</a></td>\n";

echo "<td colspan=3 id='td'><b>Pago</b> <a href=\"".url("orderby", "pago+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "pago+desc")."\">&#x25B4;</a></td>\n";
echo "<td></td>\n";
echo "</tr>\n";

$where = array();
$having = array();

if (isset($_GET["numero"])) $where[] = "numero = ".$_GET["numero"];
if (isset($_GET["data"])) $where[] = "strftime('%d/%m/%Y', data) like '%".strtr($_GET["data"], " ", "%")."%'";;
if (isset($_GET["pago"])) $where[] = $_GET["pago"] == 'sim'||$_GET["pago"] == 'Sim'? "pago == 1" : "pago == 0" ;
if (isset($_GET["mesa"])) $where[] = "mesa.nome like '%".strtr($_GET["mesa"], " ", "%")."%'";
if (isset($_GET["pizza"])) $having[] = "pizza = '".$_GET["pizza"]."'";

if (isset($_GET["valor"])) $where[] = "valor like '%".strtr($_GET["valor"], " ", "%")."%'";;
// if (isset($_GET["pago"])) $where[] = "pago = ".$_GET["pago"] == 1 ? ' pago = sim' : ' pago = nao';
$where = (count($where) > 0) ? "where ".implode(" and ", $where) : "";
$having = (count($having) > 0) ? "having ".implode(" and ", $having) : "";

echo $where;
echo $having;


if (isset($_GET["numero"])) {
	$total = $db->query("select count(*) as total from comanda ".$where)->fetchArray()["total"];
}


if (isset($_GET["data"])) {
	$total = $db->query("select count(data) as total from comanda ".$where)->fetchArray()["total"];
}

if (isset($_GET["mesa"])) {
	$total = $db->query("select count(mesa) as total from comanda join mesa on mesa.codigo = comanda.mesa ".$where)->fetchArray()["total"];
}

if (isset($_GET["pizza"])) {
	$total = $db->query("select count(pizza.codigo) as total from comanda 	
	join pizza on pizza.comanda = comanda.numero 
	join pizzasabor on pizza.codigo = pizzasabor.pizza
	 ".$where)->fetchArray()["total"];
}

if (isset($_GET["pago"])) {
	$total = $db->query("select count(pago) as total from comanda ".$where)->fetchArray()["total"];
}

if (isset($_GET["valor"])) {
	$total = $db->query("select numero, case when valor is null then 0 
	else valor
	end as total
	from(select numero, sum(tmp.preco) as valor from (select 
	max(case
			when borda.preco is null then 0
			else borda.preco 
		end + precoportamanho.preco) as preco, numero as numero
from comanda
	join pizza on pizza.comanda = comanda.numero
	join pizzasabor on pizzasabor.pizza = pizza.codigo
	join sabor on pizzasabor.sabor = sabor.codigo
	join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho
	left join borda on pizza.borda = borda.codigo group by pizza.codigo) as tmp group by 1)".$where)->fetchArray()["total"];
}
echo $where;

if (!isset($_GET["pago"]) && !isset($_GET["valor"]) && !isset($_GET["numero"]) && !isset($_GET["mesa"]) && !isset($_GET["data"]) && !isset($_GET["pizza"])){
	$total = $db->query("select count(*) as total from comanda ".$where)->fetchArray()["total"];

} 

$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "numero asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);


$results = $db->query("select numero, count(pizza.codigo) as pizza, mesa.nome as mesa, pago,
case strftime('%w', data)
when '0' then 'Dom'
when '1' then 'Seg'
when '2' then 'Ter'
when '3' then 'Qua'
when '4' then 'Qui'
when '5' then 'Sex'
when '6' then 'Sab'
end || strftime(' %d/%m/%Y',data) as data
from comanda 
join mesa on mesa.codigo = comanda.mesa
left join pizza on comanda.numero = pizza.comanda
".$where." group by 1 ".$having." order by ".$orderby." limit ".$limit." offset ".$offset);
while ($row = $results->fetchArray()){
	echo "<tr>\n";
	echo '<td>'.($row["pago"] > 0 ? "" : '<a href=\inclui.php?numero='.$row["numero"].'>&#x1F4DD;</a>').'</td>';
	echo "<td>".$row["numero"]."</td>\n";	
	echo "<td>".$row["data"]."</td>\n";	
	echo "<td>".$row["mesa"]."</td>\n";	
	echo "<td>" .$row["pizza"]."</td>\n";
		echo "<td>".($row["pizza"] > 0 ?  "<a href=\"lista.php?numero=".$row["numero"]."\">&#128064;</a>" : '')."</td>";


	$results4 = $db->query("select case when valor is null then 0 
	else valor
	end as valor
	from(select sum(tmp.preco) as valor from (select 
	max(case
			when borda.preco is null then 0
			else borda.preco 
		end + precoportamanho.preco) as preco
from comanda
	join pizza on pizza.comanda = comanda.numero
	join pizzasabor on pizzasabor.pizza = pizza.codigo
	join sabor on pizzasabor.sabor = sabor.codigo
	join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho
	left join borda on pizza.borda = borda.codigo where comanda.numero = ".$row["numero"]." group by pizza.codigo) as tmp)");	
	while ($row4 = $results4->fetchArray()){
		echo "<td>\n";
		echo "R$ ".$row4["valor"];
		echo "</td>";	
	}

	
	echo "<td>".($row["pago"] == 1 ? 'sim' : 'não')."</td>\n";
		echo "<td>".($row["pago"] == 0 && $row["pizza"] > 0 ?  "<a href=\"paga.php?numero=".$row["numero"]."\">&#128181;</a>" : '')."</td>";
		echo "<td>".($row["pago"] == 0 && $row["pizza"] > 0 ?  "<a href=\"paga.php?numero=".$row["numero"]."\">&#128179;</a>" : '')."</td>";
		echo '<td>'.($row["pizza"] == 0 ? "<a href=\"delete.php?numero=".$row["numero"]."\" onclick=\"return(confirm('Excluir comanda n. ".$row["numero"]."?'));\">&#x1F5D1;</a>" : '').'</td>';
	

	}


echo "</table>\n";
echo "<br>\n";

echo  '<div id="mensagem" align="center" style="position:fixed; top:20px; left:10%; width:80%; padding:5px 5px 5px 5px; display:none;"></div>';


for ($page = 0; $page < ceil($total/$limit); $page++) {
	echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit)."\">".($page+1)."</a>")." \n";
}

$db->close();
?>
<script>
	function mensagem(cor, texto) {
			let div = document.getElementById("mensagem");
			div.innerHTML = texto;
			div.style.display = "block";
			div.style.backgroundColor = cor;
			setTimeout(function () {
				div.style.display = "none";
			}, 3000);
		}
			

		function valida() {
		
         
				let input = document.getElementById("valor1")
				let select = document.getElementById("campo").value

				if(select === 'numero' || select === 'pizza'){
					input.setAttribute('pattern', '[0-9]+')
					console.log(input)
				}

				if(select === 'data'){
					input.setAttribute('pattern', '^([0-9]+(/[0-9]+)+)$')
					console.log(input)
				}
				if(select === 'pago'){
					input.setAttribute('pattern', '^(?:sim|nao|Sim|Não|Nao|não)')
					console.log(input)
				}
				if(select === 'mesa'){
					input.setAttribute('pattern', "(^[0-9]).")
					console.log(input)
				}

				console.log(select);
			
					let regexp = new RegExp(input.pattern);
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

</body>
</html>