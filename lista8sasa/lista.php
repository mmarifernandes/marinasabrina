
<html>
<body>
<?php 
function url($campo, $valor) {
	$result = array();
	if (isset($_GET["numero"])) $result["numero"] = "numero=".$_GET["numero"];
	if (isset($_GET["tamanho"])) $result["tamanho"] = "tamanho=".$_GET["tamanho"];
	if (isset($_GET["borda"])) $result["borda"] = "borda=".$_GET["borda"];
	if (isset($_GET["sabor"])) $result["sabor"] = "sabor=".$_GET["sabor"];
	if (isset($_GET["valor"])) $result["valor"] = "valor=".$_GET["valor"];
    if (isset($_GET["total"])) $result["total"] = "total=".$_GET["total"];
	if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
	if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
	$result[$campo] = $campo."=".$valor;
	return("lista.php?".strtr(implode("&", $result), " ", "+"));
}

$db = new SQLite3("pizzaria.db");
$db->exec("PRAGMA foreign_keys = ON");

$limit = 5;
echo "<h1>Pizzas da comanda ".$_GET["numero"]."</h1>\n";

$value = "";
if (isset($_GET["numero"])) $value = $_GET["numero"];
if (isset($_GET["tamanho"])) $value = $_GET["tamanho"];
if (isset($_GET["borda"])) $value = $_GET["borda"];
if (isset($_GET["sabor"])) $value = $_GET["sabor"];
if (isset($_GET["valor"])) $value = $_GET["valor"];
if (isset($_GET["total"])) $value = $_GET["total"];

echo "<br>\n";

$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];


$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "numero asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);


echo "<table border=\"1\">\n";
echo "<tr>\n";

echo "<td><b>Tamanho</b> <a href=\"".url("orderby", "tamanho+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "tamanho+desc")."\">&#x25B4;</a></td>\n";

echo "<td><b>Borda</b> <a href=\"".url("orderby", "borda+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "borda+desc")."\">&#x25B4;</a></td>\n";

echo "<td><b>Sabor</b>\n";

echo "<td><b>Valor</b> <a href=\"".url("orderby", "valor+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "valor+desc")."\">&#x25B4;</a></td>\n";

echo "</tr>\n";



/*
$where = array();
if (isset($_GET["codigo"])) $where[] = "codigo = ".$_GET["codigo"];
if (isset($_GET["nome"])) $where[] = "nome like '%".strtr($_GET["nome"], " ", "%")."%'";
if (isset($_GET["genero"])) $where[] = "genero = '".$_GET["genero"]."'";
if (isset($_GET["nascimento"])) $where[] = "date(nascimento) = date('".$_GET["nascimento"]."')";
$where = (count($where) > 0) ? "where ".implode(" and ", $where) : "";*/


/*
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
".$where." group by 1"." order by ".$orderby." limit ".$limit." offset ".$offset);*/

$results = $db->query("select numero, pizza.codigo as pizza, group_concat(sabor.nome, ', ') as sabor, sabor.codigo as codigo, case
when pizza.borda is null then 'não'
else borda.nome
end as borda, max(case
when borda.preco is null then 0
else borda.preco
end+precoportamanho.preco) as valor, tamanho.nome as tamanho 
from comanda
join pizza on pizza.comanda = comanda.numero
join pizzasabor on pizza.codigo = pizzasabor.pizza
join sabor on pizzasabor.sabor = sabor.codigo 
join tipo on sabor.tipo = tipo.codigo
join mesa on mesa.codigo = comanda.mesa
join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho
left join borda on pizza.borda = borda.codigo 
join tamanho on pizza.tamanho = tamanho.codigo where comanda.numero = ".$_GET["numero"]." 
group by pizza order by ".$orderby." limit ".$limit." offset ".$offset);


while ($row = $results->fetchArray()) {
	echo "<tr>\n";	
		echo "<td>";
		echo strtolower($row["tamanho"]);
		echo "</td>";
        echo "<td>\n";
        echo mb_strtolower($row["borda"]);
        echo "</td>";	   
        echo "<td>\n";
		echo ucwords(strtolower($row["sabor"]));
		echo "</td>";	
		echo "<td>\n";
        echo "R$ ".$row["valor"];
		echo "</td>";
        echo "</tr>\n";
}	

$results2 = $db->query("select sum(tmp.preco) as total
from
	(select
		max(case
				when borda.preco is null then 0
				else borda.preco
			end+precoportamanho.preco) as preco
	from comanda
		join pizza on pizza.comanda = comanda.numero
		join pizzasabor on pizzasabor.pizza = pizza.codigo
		join sabor on pizzasabor.sabor = sabor.codigo
		join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho
		left join borda on pizza.borda = borda.codigo
	where comanda.numero = ".$_GET["numero"]." group by pizza.codigo) as tmp");

while ($row2 = $results2->fetchArray()) {	
        echo "<tr>\n";	
		echo "<td colspan=3><b>Total</b></td>\n";
		echo "<td>";
		echo '<b>'."R$ ".$row2["total"].'</b>';
		echo "</td>";
        echo "</tr>\n";
}	



echo "</table>\n";
echo "<br>\n";

echo "<button onclick=history.go(-1);>Volta </button>";

$db->close();
?>
</body>
</html>
