<?php

//while_1(1);

function while_1($i){
	
	while($i<10){
		echo $i;
		$i=$i+1;
	}
}

//while_2(1);

function while_2($i){
//this is good! I think this is the best version. 
	while($i<10){
		echo $i++;
	}
}

//while_3(1);

function while_3($i){
	
	while ($i <= 10):
	    echo $i;
	    $i++;
	endwhile;
}

//while_4(0);

function while_4($i){
//while use in array
$arr = array("orange", "banana", "apple", "raspberry");

	while ($i < count($arr)) {
	   $a = $arr[$i];
	   echo $a ."\n";
	   $i++;
	}
}

function while_5(){
//you can use it this way 
$q1 = 'some query on a set of tables'; 
$q2 = 'similar query on a another set of tables'; 

if ( ($r1=mysql_query($q1)) && ($r2=mysql_query($q2)) ) { 

     while (($row=mysql_fetch_assoc($r1))||($row=mysql_fetch_assoc($r2))) { 

         /* do something with $row coming from $r1 and $r2 */ 

      } 
   } 

}

//test_while();

function test_while(){
echo "testing while loop ";

$i=0;
	while($i<10){
		echo $i;
		$i++;
	}

}


test2_while();

function test2_while(){
	echo " testing while loop2 ";
	$i = 0;
	while($i<10){
		echo $i;
		$i++;
	};
};

?>