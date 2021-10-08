<html>
    <body>
        <?php 

function checaData($data) { //CHECA SE A DATA É REAL
    $data = explode("/", $_POST["data"]);
    $d = $data[0];
    $m = $data[1];
    $a = $data[2];
    $checa = checkdate($m, $d, $a);
if ($checa == true) { return true; } else { echo "DATA INVÁLIDA!"; } 

} 

function checaDias($dias) { //CHECA SE O DIA É VALIDO
    $dias = $_POST["dias"];
if (!is_numeric($dias) || $dias < 0) { echo "DIA INVÁLIDO!"; } else { return true; } 

}

function dataPascoa($ano) {
    $ano = $ano ? $ano : date("Y");
    if ($ano < 1583) {
        $A = ($ano % 4);
        $B = ($ano % 7);
        $C = ($ano % 19);
        $D = ((19 * $C + 15) % 30);
        $E = ((2 * $A + 4 * $B - $D + 34) % 7);
        $F = (int) (($D + $E + 114) / 31);
        $G = (($D + $E + 114) % 31) + 1;
        return date("d/m/Y", mktime( 0, 0, 0, $F, $G, $ano));
    } else {
        $A = ($ano % 19);
        $B = (int) ($ano/100);
        $C = ($ano % 100);
        $D = (int) ($B/4);
        $E = ($B % 4);
        $F = (int) (($B + 8) / 25);
        $G = (int) (($B - $F + 1) / 3);
        $H = ((19 * $A + $B - $D - $G + 15) % 30);
        $I = (int) ($C / 4);
        $K = ($C % 4);
        $L = ((32 + 2 * $E + 2 * $I - $H - $K)%7);
        $M = (int) (($A + 11 * $H + 22 * $L)/451);
        $P = (int) (($H + $L - 7 * $M + 114)/31);
        $Q = (($H + $L - 7 * $M + 114) % 31)+1;
        return date("d/m/Y", mktime(0, 0, 0, $P, $Q, $ano));
    }
}

function dataCarnaval($ano) {
    $ano = $ano ? $ano : date("Y");
    $a = explode("/", dataPascoa($ano));
    return date("d/m/Y", mktime(0, 0, 0, $a[1], $a[0] - 47, $a[2]));
}

function dataCorpusChristi($ano) {
    $ano = $ano ? $ano : date("Y");
    $a = explode("/", dataPascoa($ano));
    return date("d/m/Y", mktime(0, 0, 0, $a[1], $a[0] + 60, $a[2]));
}


function dataSextaSanta($ano) {
    $ano = $ano ? $ano : date( "Y" );
    $a = explode("/", dataPascoa($ano));
    return date("d/m/Y", mktime(0, 0, 0, $a[1], $a[0] - 2, $a[2]));
}

function diasUteis($data, $dias) {
            if (checaData($data) == true && checaDias($dias) == true) { 
            $data = $_POST["data"]; 
            $dias = $_POST["dias"];
            if (preg_match("(/)", $data) == true) {
                $data = implode("-", array_reverse(explode("/", $data)));
            }

            $apascoa = dataPascoa(date("Y"));
            $explodep = explode("/", $apascoa);
            $diapascoa = $explodep[0];
            $mespascoa = $explodep[1];
            $pascoa = "$mespascoa" . "-" . "$diapascoa"; 

            $acarnaval = dataCarnaval(date("Y"));
            $explodec = explode("/", $acarnaval);
            $diacarna = $explodec[0];
            $mescarna = $explodec[1];
            $carnaval = "$mescarna" . "-" . "$diacarna";

            $acc = dataCorpusChristi(date("Y"));
            $ccexplode = explode("/", $acc);
            $diacc = $ccexplode[0];
            $mescc = $ccexplode[1];
            $corpuschristi = "$mescc" . "-" . "$diacc";

            $asexta = dataSextaSanta(date("Y"));
            $sexta = explode("/", $asexta);
            $diasexta = $sexta[0];
            $sextames = $sexta[1];
            $sextasanta = "$sextames" . "-" . "$diasexta";

            $feriados = array("01-01", $carnaval, $sextasanta, $pascoa, $corpuschristi, "04-21", "05-01", "06-12", "07-09", "07-16", "09-07", "10-12", "11-02", "11-15", "12-25");
            $array = explode("-", $data);
            $c = 0;
            $qtd = 0;
            while ($qtd < $dias) {
                $c++;
                $dia = date("m-d", strtotime("+".$c."day", strtotime($data)));
                if (($diasemana = date("w", strtotime("+".$c."day", mktime(0, 0, 0, $array[1], $array[2], $array[0])))) != "0" && $diasemana != "6" && !in_array($dia, $feriados)) {
                    $qtd++;
                }
            }
            return date("d/m/Y", strtotime("+".$c."day", strtotime($data)));
        }
        }
        
        echo diasUteis($data, $dias);
        
        ?>
    </body>
</html>