<?php

$login ="kevin@student.qut.edu.au";
$str1="@uq.edu.au";
$str2="@griffith.edu.au";
$str3="@student.qut.edu.au";

if (stristr($login,$str1,0)==true){
	echo "UQ";
	return "UQ";
};

if (stristr($login,$str2,0)==true){
	echo "Griffith";
	return "Griffith";
};

if (stristr($login,$str3,0)==true){
	echo "QUT";
	return "QUT";
};

?>