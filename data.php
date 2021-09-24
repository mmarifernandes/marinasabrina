<html>
<body>
<?php
/* mostra uma mensagem de erro se data ou dias úteis forem inválidos
só calcula se data e dias úteis forem válidos
soma a quantidade de dias úteis à data e mostra a data resultante
* dias úteis são os dias da semana de segunda a sexta que não são feriados nacionais
(Confraternização Universal, Carnaval, Sexta-feira Santa, Páscoa, Tiradentes, Dia Mundial do Trabalho, Corpus Christi,
Independência do Brasil, Nossa Senhora Aparecida, Finados, Proclamação da República e Natal) */

function formata($data) {
    $data = $_POST["data"];
    $ano = substr($data, 6, 4);
    $mes = substr($data, 3, 2);
    $dia = substr($data, 0, 2);
 return mktime(0, 0, 0, $mes, $dia, $ano);  
 }

/*function checaData($data) {
    $data = explode('/', $_POST["data"]);
    $d = $data[0];
    $m = $data[1];
    $a = $data[2];
    $checa = checkdate($m,$d,$a);

if ($checa == true){
   return true;
} else {
   return false;
} }

*/
function feriados($ano, $pos) {
    $dia = 86400;
    $datas = array();
    $datas['pascoa'] = easter_date($ano);
    $datas['sexta_santa'] = $datas['pascoa'] - (2 * $dia);
    $datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
    $datas['corpus_christi'] = $datas['pascoa'] + (60 * $dia);
    $feriados = array(
        '01/01',
        date('d/m',$datas['carnaval']),
        date('d/m',$datas['sexta_santa']),
        date('d/m',$datas['pascoa']),
        '21/04',
        '01/05',
        date('d/m',$datas['corpus_christi']),
        '07/09',
        '12/10',
        '02/11',
        '15/11',
        '25/12'
    );
    return $feriados[$pos]."/".$ano;
}

?>
</body>
</html>
