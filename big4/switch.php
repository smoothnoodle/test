<?php

$i = 1;//without $i, this code will return in an error
//Notice: Undefined variable: i in C:\xampp\htdocs\test\big4\switch.php on line 5
//i equals 0

function switch1($i){

    if ($i == 0) {
        echo "i equals 0";
    } elseif ($i == 1) {
        echo "i equals 1<br>";
    } elseif ($i == 2) {
        echo "i equals 2";
    }

    switch ($i) {
        case 0:
            echo "i equals 0";
            break;
        case 1:
            echo "i equals 1";
            break;
        case 2:
            echo "i equals 2";
            break;
    };
};

switch1($i);

?>