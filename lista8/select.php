<html>
<body>
<?php
function url($campo, $valor) {
	$result = array();
	if (isset($_GET["codigo"])) $result["codigo"] = "codigo=".$_GET["codigo"];
	if (isset($_GET["sabor"])) $result["sabor"] = "sabor=".$_GET["sabor"];
	if (isset($_GET["tipo"])) $result["tipo"] = "tipo=".$_GET["tipo"];
	if (isset($_GET["ingrediente"])) $result["ingrediente"] = "ingrediente=".$_GET["ingrediente"];
	if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
	if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
	$result[$campo] = $campo."=".$valor;
	return("select.php?".strtr(implode("&", $result), " ", "+"));
}

$db = new SQLite3("pizzaria.db");
$db->exec("PRAGMA foreign_keys = ON");

$limit = 5;

echo "<h1>Cadastro de Sabores</h1>\n";

echo "<select id=\"campo\" name=\"campo\">\n";
// echo "<option value=\"codigo\"".((isset($_GET["codigo"])) ? " selected" : "").">Código</option>\n";
echo "<option value=\"sabor\"".((isset($_GET["sabor"])) ? " selected" : "").">Sabor</option>\n";
echo "<option value=\"tipo\"".((isset($_GET["tipo"])) ? " selected" : "").">Tipo</option>\n";
echo "<option value=\"ingrediente\"".((isset($_GET["ingrediente"])) ? " selected" : "").">Ingrediente</option>\n";
echo "</select>\n"; 

$value = "";
// if (isset($_GET["codigo"])) $value = $_GET["codigo"];
if (isset($_GET["sabor"])) $value = $_GET["sabor"];
if (isset($_GET["tipo"])) $value = $_GET["tipo"];
if (isset($_GET["ingrediente"])) $value = $_GET["ingrediente"];
echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"".$value."\" size=\"20\"> \n";

$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];
echo "<a href=\"\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '".strtr(implode("&", $parameters), " ", "+")."'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='select.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
echo "<br>\n";

echo "<table border=\"1\">\n";
echo "<tr>\n";
echo "<td><a href=\"insert.php\">&#x1F4C4;</a></td>\n";
// echo "<td><b>Código</b> <a href=\"".url("orderby", "codigo+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "codigo+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Nome</b> <a href=\"".url("orderby", "sabor+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "sabor+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Tipo</b> <a href=\"".url("orderby", "tipo+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "tipo+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Ingrediente</b>\n";
echo "<td></td>\n";
echo "</tr>\n";

$where = array();
// if (isset($_GET["codigo"])) $where[] = "codigo = ".$_GET["codigo"];
if (isset($_GET["sabor"])) $where[] = "sabor.nome like '%".strtr($_GET["sabor"], " ", "%")."%'";
if (isset($_GET["tipo"])) $where[] = "tipo.nome like '%".strtr($_GET["tipo"], " ", "%")."%'";
if (isset($_GET["ingrediente"])) $where[] = "ingrediente.nome like '%".strtr($_GET["ingrediente"], " ", "%")."%'";
$where = (count($where) > 0) ? "where ".implode(" and ", $where) : "";

echo $where;
if (isset($_GET["tipo"])){
	$total = $db->query("select count(tipo) as total from sabor join tipo on sabor.tipo = tipo.codigo ".$where)->fetchArray()["total"];
}
if (isset($_GET["sabor"])){
	$total = $db->query("select count(*) as total from sabor ".$where)->fetchArray()["total"];
}
if (isset($_GET["ingrediente"])){
	$total = $db->query("select count(*) as total, sabor.nome as sabor from sabor join saboringrediente on saboringrediente.sabor = sabor.codigo join tipo on tipo.codigo = sabor.tipo
	join ingrediente on saboringrediente.ingrediente = ingrediente.codigo ".$where." group by sabor")->fetchArray()["total"];
}
if (!isset($_GET["ingrediente"]) && !isset($_GET["sabor"]) && !isset($_GET["tipo"])){
	$total = $db->query("select count(*) as total from sabor ".$where)->fetchArray()["total"];
	
}
$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "sabor asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);

$results = $db->query("select sabor.nome as sabor, sabor.codigo as codigo, tipo.nome as tipo, group_concat(ingrediente.nome, ', ') as ingrediente from sabor 
join saboringrediente on saboringrediente.sabor = sabor.codigo join tipo on tipo.codigo = sabor.tipo
join ingrediente on saboringrediente.ingrediente = ingrediente.codigo
".$where." group by sabor"." order by ".$orderby." limit ".$limit." offset ".$offset);

while ($row = $results->fetchArray()) {
	echo "<tr>";
	echo "<td><a href=\"update.php?codigo=".$row["codigo"]."\">&#x1F4DD;</a></td>\n";
	// echo "<td>".$row["codigo"]."</td>\n";
	echo "<td>".ucfirst(strtolower($row["sabor"]))."</td>\n";
	echo "<td>".strtolower($row["tipo"])."</td>\n";
	echo "<td>".strtolower($row["ingrediente"])."</td>\n";
	echo "<td><a href=\"delete.php?codigo=".$row["codigo"]."\" onclick=\"return(confirm('Excluir ".ucfirst(strtolower($row["sabor"]))."?'));\">&#x1F5D1;</a></td>\n";
	echo "</tr>";
}


echo "</table>\n";
echo "<br>\n";



for ($page = 0; $page < ceil($total/$limit); $page++) {
	echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit)."\">".($page+1)."</a>")." \n";
}

$db->close();
?>
</body>
</html>

