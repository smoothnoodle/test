<?php
include 'include/function_pwd.php';
set_time_limit(30);
$passwd ="18";

//$user_encrypwd = password_hash($passwd, PASSWORD_DEFAULT);
$user_encrypwd ='$2y$10$eLsNrP/9koQiIAmYvs6tiuf4P/9C9tPDvxiSdWbwMeFdqw5DOSBUe';


echo $user_encrypwd."<br>";

$crack_pwd = crack_passwd($user_encrypwd);

echo "password: ".$crack_pwd;

?>