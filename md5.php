<?php 
$pwd ='ilovecats33';
$pwd2 ="ilovecats33";
$pwd3 ="cat";

//echo md5($pwd);
echo $encrypted_password = password_hash($pwd, PASSWORD_DEFAULT);
$result = password_verify($pwd3, $encrypted_password);

//var_dump($result );
?>