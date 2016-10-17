<?php 

//objects
$object = new stdclass; 
$object->names = ['John','Billy','Susan','Max'];

foreach ($object->names as $name){
	echo $name.'<br>';
}