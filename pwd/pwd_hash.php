<?php
//boolean password_verify ( string $password , string $hash )

$passwd = "Joe";
$wrong_pwd = "Joe";

echo $passwd."<br>";
echo $wrong_pwd."<br>";

$encrypted_pwd = password_hash($passwd, PASSWORD_DEFAULT);
//everytime you refresh, it change

echo $encrypted_pwd."<br>";

echo password_verify($wrong_pwd, $encrypted_pwd);

//create a form for update password 

?>