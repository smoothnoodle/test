<?php 

require 'bird.php';
require 'pigeon.php';// not case sensitive
require 'penguin.php';
require 'raven.php';

$penguin = new penguin(true, 3);// not case sensitive
//echo $pigeon->getLegCount();

//$penguin->foo();//is this how to call a function?
//echo $penguin->canFly();//true == 1, false == 0 


$raven = new raven();
$raven->foo();


/*
if($penguin->canFly()){
	echo 'Can fly';
}
*/

/*
$pigeon = new pigeon(true, 2);// not case sensitive
//echo $pigeon->getLegCount();

if($pigeon->canFly()){
	echo 'Can fly';
}
*/

//echo $pigeon->canFly();
//ctrl D copy whole line

//$bird = new Bird(true, 2);
//echo $bird->getLegCount();

/*
$pigeon = new pigeon(true, 2);

echo $pigeon->getLegCount();


*/

/* lesson 3 constructor 
require 'Person.php';//not case sensitive 

$person = new person("kevin", 43);
//$person->name = 'John';
//$person->age = 20;

echo $person->sentence();
*/

?>
