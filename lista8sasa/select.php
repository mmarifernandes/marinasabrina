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
echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"".$value."\" size=\"20\"> \n";

//ECHO '&#128179';
$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];
echo "<a href=\"\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '".strtr(implode("&", $parameters), " ", "+")."'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='select.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
echo "<br>\n";

echo "<table border=\"1\">\n";
echo "<tr>\n";
echo "<td><a href=\"insert.php\">&#x1F4C4;</a></td>\n";
echo "<td><b>Número</b> <a href=\"".url("orderby", "numero+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "numero+desc")."\">&#x25B4;</a></td>\n";

echo "<td><b>Data</b> <a href=\"".url("orderby", "data+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "data+desc")."\">&#x25B4;</a></td>\n";

echo "<td><b>Mesa</b> <a href=\"".url("orderby", "mesa+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "mesa+desc")."\">&#x25B4;</a></td>\n";

echo "<td colspan=2><b>Pizza</b> <a href=\"".url("orderby", "pizza+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "pizza+desc")."\">&#x25B4;</a></td>\n";

echo "<td><b>Valor</b> <a href=\"".url("orderby", "valor+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "valor+desc")."\">&#x25B4;</a></td>\n";

echo "<td colspan=3 id='td'><b>Pago</b> <a href=\"".url("orderby", "pago+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "pago+desc")."\">&#x25B4;</a></td>\n";
echo "<td></td>\n";
echo "</tr>\n";

$where = array();
if (isset($_GET["numero"])) $where[] = "numero = ".$_GET["numero"];
if (isset($_GET["data"])) $where[] = "data like '%".strtr($_GET["data"], " ", "%")."%'";;
//if (isset($_GET["pago"])) $where[] = "pago = ".$_GET["pago"];
if (isset($_GET["mesa"])) $where[] = "mesa.nome like '%".strtr($_GET["mesa"], " ", "%")."%'";
if (isset($_GET["pizza"])) $where[] = "pizza = '".$_GET["pizza"]."'";
if (isset($_GET["valor"])) $where[] = "valor like '%".strtr($_GET["valor"], " ", "%")."%'";;
if (isset($_GET["pago"])) $where[] = "pago = ".$_GET["pago"] == 'sim' ? 'pago = 1' : 'pago = 0';
$where = (count($where) > 0) ? "where ".implode(" and ", $where) : "";

echo $where;
/*
if (isset($_GET["pago"])) {
	$total = $db->query("select count(pago) as total from comanda ".$where)->fetchArray()["total"];
}

if (isset($_GET["pizza"])) {
	$total = $db->query("select count(*) as total from pizza 
	join comanda on pizza.comanda = comanda.numero join pizzasabor on pizza.codigo = pizzasabor.pizza
	join sabor on pizzasabor.sabor = sabor.codigo
	join tipo on sabor.tipo = tipo.codigo".$where)->fetchArray()["total"];
}

if (isset($_GET["mesa"])) {
	$total = $db->query("select count(codigo) as total from pizza 
	join comanda on pizza.comanda = comanda.numero
	join pizzasabor on pizza.codigo = pizzasabor.pizza
	join sabor on pizzasabor.sabor = sabor.codigo
	join tipo on sabor.tipo = tipo.codigo".$where)->fetchArray()["total"];
}*/

/*
$total = $db->query("select count(*) as total from comanda 
".$where)->fetchArray()["total"];*/



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
	$total = $db->query("select count(pizza) as total from comanda 	
	join pizza on pizza.comanda = comanda.numero 
	join pizzasabor on pizza.codigo = pizzasabor.pizza
	 ".$where)->fetchArray()["total"];
}

if (isset($_GET["pago"])) {
	$total = $db->query("select count(pago) as total from comanda ".$where)->fetchArray()["total"];
}

if (isset($_GET["valor"])) {
	$total = $db->query("select max(case
	when borda.preco is null then 0
	else borda.preco
	end+precoportamanho.preco) as total from comanda 
	join pizza on pizza.comanda = comanda.numero
	join pizzasabor on pizza.codigo = pizzasabor.pizza
	join sabor on pizzasabor.sabor = sabor.codigo
	join tipo on sabor.tipo = tipo.codigo
	join mesa on mesa.codigo = comanda.mesa
	join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho
	left join borda on pizza.borda = borda.codigo
	".$where)->fetchArray()["total"];
}


if (!isset($_GET["pago"]) && !isset($_GET["numero"]) && !isset($_GET["mesa"]) && !isset($_GET["data"]) && !isset($_GET["pizza"])){
	$total = $db->query("select count(*) as total from comanda ".$where)->fetchArray()["total"];

} 

$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "numero asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);


$results = $db->query("select numero, mesa.nome as mesa, data, pizza, max(case
when borda.preco is null then 0
else borda.preco
end+precoportamanho.preco) as valor, case
when pago = 1 then 'sim' else 'não' end as pago
from comanda 
join pizza on pizza.comanda = comanda.numero
join pizzasabor on pizza.codigo = pizzasabor.pizza
join sabor on pizzasabor.sabor = sabor.codigo
join tipo on sabor.tipo = tipo.codigo
join mesa on mesa.codigo = comanda.mesa
join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho
left join borda on pizza.borda = borda.codigo 
".$where." group by 1"." order by ".$orderby." limit ".$limit." offset ".$offset);
/*
while ($row = $results->fetchArray()) {
	echo "<tr>\n";
	echo "<td><a href=\"update.php?numero=".$row["numero"]."\">&#x1F4DD;</a></td>\n";
	echo "<td>".$row["numero"]."</td>\n";
	echo "<td>".$row["data"]."</td>\n";
	echo "<td>".$row["mesa"]."</td>\n";
    echo "<td>".$row["pizza"]."</td>\n";
    //echo "<td>".$row["valor"]."</td>\n";
    echo "<td>".$row["pago"]."</td>\n";
	echo "<td><a href=\"delete.php?numero=".$row["numero"]."\" onclick=\"return(confirm('Excluir comanda número ".$row["numero"]."?'));\">&#x1F5D1;</a></td>\n";
	echo "</tr>\n";
}
*/
while ($row = $results->fetchArray()){	
	echo "<tr id='table'>\n";	
	echo "<td><a href=\"inclui.php?numero=".$row["numero"]."\">&#x1F4DD;</a></td>\n";	
	echo "<td>".$row["numero"]."</td>\n";	
	echo "<td>".$row["data"]."</td>\n";	
	echo "<td>\n";
	$results2 = $db->query("select mesa.nome as mesa from comanda join mesa on comanda.mesa = mesa.codigo where comanda.numero = ".$row["numero"]);	
	while ($row2 = $results2->fetchArray()) {		
	echo $row2["mesa"];	}	
	echo "</td>\n";	

    $results3 = $db->query("select count(codigo) as pizza from pizza join comanda on pizza.comanda = comanda.numero where comanda.numero = ".$row["numero"]);	
    while ($row3 = $results3->fetchArray()) {	
		echo "<td>\n";
		echo $row3["pizza"];	
		echo "</td>";	
	    echo "<td>\n";
}	
echo "<a href=\"lista.php?numero=".$row["numero"]."\">&#128064;</a>\n";
//&#128064;
echo "</td>\n";	

	$results4 = $db->query("select sum(tmp.preco) || ' $' as valor from (select 
	max(case
			when borda.preco is null then 0
			else borda.preco 
		end + precoportamanho.preco) || ' $' as preco
from comanda
	join pizza on pizza.comanda = comanda.numero
	join pizzasabor on pizzasabor.pizza = pizza.codigo
	join sabor on pizzasabor.sabor = sabor.codigo
	join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho
	left join borda on pizza.borda = borda.codigo where comanda.numero = ".$row["numero"]." group by pizza.codigo) as tmp");		
	while ($row4 = $results4->fetchArray()){
		echo "<td>\n";
		echo $row4["valor"];
		echo "</td>";	
	}
	
	echo "<td>".$row["pago"]."</td>\n";
	if ($row["pago"] == "não") {
		echo "<td id='td1'>".'&#128179;'."</td>\n";
		echo "<td id='td2'>".'&#128181;'."</td>\n"; 
	} else {
		echo "<td id='td1'>".'    '."</td>\n";
		echo "<td id='td2'>".'    '."</td>\n"; 
	}
	echo "<td><a href=\"delete.php?numero=".$row["numero"]."\" onclick=\"return(confirm('Excluir comanda número ".$row["numero"]."?'));\">&#x1F5D1;</a></td>\n";
	echo "</tr>\n";
	}
/*	&#128179; cartão crédito
	&#128181; dinheiro */

echo "</table>\n";
echo "<br>\n";
for ($page = 0; $page < ceil($total/$limit); $page++) {
	echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit)."\">".($page+1)."</a>")." \n";
}

$db->close();
?>
<script>

</script>

</body>
</html>

