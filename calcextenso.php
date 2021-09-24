
<html>
<body>
<?php
var_dump($_POST);
$numeroextenso = $_POST['numeroextenso'];
$numeroextenso2 = $_POST['numeroextenso2'];

function converter($numeroextenso){

$numbers = array(
    'um' => 1,
    'dois' => 2,
    'tres' => 3,
    'quatro' => 4,
    'cinco' => 5,
    'seis' => 6,
    'sete' => 7,
    'oito' => 8,
    'nove' => 9,
    'dez' => 10,
    'onze' => 11,
    'doze' => 12,
    'treze' => 13,
    'quatorze' => 14,
    'quinze' => 15,
    'dezesseis' => 16,
    'dezessete' => 17,
    'dezoito' => 18,
    'dezenove' => 19,
    'vinte' => 20,
    'trinta' => 30,
    'quarenta' => 40,
    'cinquenta' => 50,
    'sessenta' => 60,
    'setenta' => 70,
    'oitenta' => 80,
    'noventa' => 90,
    'cem' => 100,
    'cento' => 100,
    'duzentos' => 200,
    'trezentos' => 300,
    'quatrocentos' => 400,
    'quinhentos' => 500,
    'seiscentos' => 600,
    'setecentos' => 700,
    'novecentos' => 900,
    'mil' => 1000,
    'milhao' => 1000000,
    'milhoes' => 1000000,
    'bilhoes' => 1000000000,
    'bilhao' => 1000000000);

//first we remove all unwanted characters... and keep the text
$str = str_replace(", ", " ", $numeroextenso);
echo $str;
//now we explode them word by word... and loop through them
$words = explode(" ", $numeroextenso);
echo $words;
//i devide each thousands in groups then add them at the end
//For example 2,640,234 "two million six hundred and fourty thousand two hundred and thirty four"
//is defined into 2,000,000 + 640,000 + 234

//the $total will be the variable were we will add up to
$total = 1;

//flag to force the next operation to be an addition
$force_addition = false;

//hold the last digit we added/multiplied
$last_digit = null;

//the final_sum will be the array that will hold every portion "2000000,640000,234" which we will sum at the end to get the result
$final_sum = array();

foreach ($words as $word) {

    //if its not an and or a valid digit we skip this turn
    if (!isset($numbers[$word]) && $word != "e") {
        continue;
    }

    //all small letter to ease the comparaison
    $word = strtolower($word);

    //if it's an and .. and this is the first digit in the group we set the total = 0 
    //and force the next operation to be an addition
    if ($word == "e") {
        if ($last_digit === null) {
            $total = 0;
        }
        $force_addition = true;
    } else {
        //if its a digit and the force addition flag is on we sum
        if ($force_addition) {
            $total += $numbers[$word];
            $force_addition = false;
        } else {
            //if the last digit is bigger than the current digit we sum else we multiply
            //example twenty one => 20+1,  twenty hundred 20 * 100
            if ($last_digit !== null && $last_digit > $numbers[$word]) {
                $total += $numbers[$word];
            } else {
                $total *= $numbers[$word];
            }
        }
        $last_digit = $numbers[$word];

        //finally we distinguish a group by the word thousand, million, billion  >= 1000 ! 
        //we add the current total to the $final_sum array clear it and clear all other flags...
        if ($numbers[$word] >= 1000) {
            $final_sum[] = $total;
            $last_digit = null;
            $force_addition = false;
            $total = 0;
        }
    }
}

// there is your final answer !
$final_sum[] = $total;

return array_sum($final_sum);

};

echo converter($numeroextenso);
echo "<br>";
echo converter($numeroextenso2);

?>
</body>
</html>
