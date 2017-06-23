<?php

//$a=5;
//$b=4;

test_if(5,6);//I think is a fail

function test_if($a,$b){
	//code in the dark 
	if($a>=$b){
		//echo $a." a is bigger than b ".$b;
		echo "$a a is bigger than b $b";
	}else{
		echo "b=$b is bigger than a=$a"; 
	}
}

?>