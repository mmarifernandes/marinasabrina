<html>
    <body>
        <?php 
$beginday = ($_POST ["data"]);
$days  = ($_POST ["dias"]);

$workdays = diasUteis($beginday, $days);
echo $workdays;

        function diasUteis($data, $dias) {
            $data1 = strtotime($data);
            $dias1 = strtotime($dias);
            $weekends = 0;
            $c = 0;
            $qtd = 0;
            $nferiados = 0;
            while ($qtd < $dias1) {
                $c++;
                $qdia = date("N", $data1);
                if ($qdia > 5) {
                    $weekends++;
                }
                $data += 86400;
            }
        }
        
        
        
        
        
        ?>
    </body>
</html>