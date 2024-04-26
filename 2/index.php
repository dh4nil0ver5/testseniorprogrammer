<?php 
$rows = 10;
 
for ($i = 1; $i <= $rows; $i++) { 
    for ($j = 1; $j <= (11 - $i); $j++) {
        echo $j . " ";
    }
    echo PHP_EOL;  
}
?>
