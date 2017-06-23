<?php
//foreach loop

$arr = array(1,2,3,4);

$array = [
    [1, 2],
    [3, 4],
];


function foreach_1($arr){

	foreach($arr as &$value){//directly modify array elements within the loop precede $value with &
	//this is powerful, u can manipulate 
		$value = $value *2;
		//echo $value;
	}
//foreach does not support the ability to suppress error messages using '@'.
//what??
	unset($value);//without an unset($value), $value is still a reference to the last item: $arr[3]
}

function display_foreach($arr){

	foreach ($arr as $key => $value) {
	    // $arr[3] will be updated with each value from $arr...
	    echo "{$key} => {$value} <br>";
	    //print_r($arr);
	}
}


function foreach_2($arr){

	reset($arr);//what is this?
	while (list(, $value) = each($arr)) {//list? display no keys
	    echo "Value: $value<br />\n";

	}
}

function foreach_3($arr){

	reset($arr);
	while (list($key, $value) = each($arr)) {
    	echo "Key: $key; Value: $value<br />\n";
    };
}

function foreach_4($array){

	foreach ($array as list($a, $b)){
	   echo "A: $a; B: $b<br>";//\n doesn't work?
	};
}

function foreach_5(){//outdated PHP5.5.0.. I am on 5.5.11. still work?
	foreach (array(1, 2, 3, 4) as &$value) {
	    $value = $value * 2;
	}
};


//foreach_1($arr);
//foreach_2($arr);
//foreach_3($arr);
//foreach_4($array);//double array;
//foreach_5();

display_foreach($arr);

?>