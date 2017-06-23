
<?php
//comment <? php fail to run with space in between 
//

//if_statement(10, 11);//this work?

function if_statement($a, $b){//can't use "if" as function name? 
	//$a="Zen";
	//$b="adam"; 

		if($a > $b){
			echo "a is bigger than b";
		}else{
			echo "b is bigger than a";
		}
}

//if_nest(1,4,5);

function if_nest($a, $b, $c){
//this kind loop can be dangerous, you got to test it both inside and outside
	If($a==1 || $a==2){//&& and ||ord
		if($b==3||$b==4){
			if($c==5||$c==6){// you serious?!? this is a huge error. 
				//do something 
				echo "you are in";
			
			}
		}
	}
}

//if_nest2(1,4,6);
function if_nest2($a, $b, $c){//this way is harder to debug because all the control statement on the single line. Wish it is the compiler show me which statment .....

	If(($a==1||$a==2)&&($b==3||$b==4)&&($c==5||$c==6)){// you serious?!? this is a huge error. 
				//do something 
				echo "you are in";
	}
}


//type_compare('tom');//case sensitive ' or " work the same?

function type_compare($needle){//took me 10mins overtime 
	$haystack = array('tom', 'Joe');
	$nkey = array_search($needle, $haystack);
	if ($nkey !== false) {// != doesn't work. 
		echo "Person exist";
	}else{
		echo "Person not found";
	}

}

short();

function short(){

	$var = true;
	echo $var==True ? 'true' : 'false';
	echo $var==false ? 'true' : 'false';


}


?> 
