<?php 

$first = "kevin";
$last = "shum";
$uid = "smoohtn00dle";
$pwd = "1234";
$pwd2 = "1234";

echo $encrypted_password = password_hash($pwd, PASSWORD_DEFAULT);
//$encrypted_password ='$2y$10$fE4zHcqQ6x/Zuk0Wtb';


//$hash = password_verify($pwd2, $encrypted_password);

//echo $pwd;
//echo $encrypted_password;
//echo $pwd_wrong;
//echo $hash; //0 is false 

if (password_verify($pwd2, $encrypted_password)) {// 1 is true 
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}


?>