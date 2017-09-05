<?php 
session_start();
include 'include/function_pwd.php';
error_reporting(-1);
$link = connect($username, $password, $host, $db_name);//every page need this?

//if(!$_SESSION["login"]){header("Location: out.php");}
//$userid = $_SESSION['userid'];
$userid = 1;
//$link = connect($username, $password, $host, $db_name);

echo $old_pwd = $_POST['old_pwd'];
echo "<br>";
//echo $new_pwd = mysqli_real_escape_string($_POST['new_pwd']);
//echo $new_pwd = mysql_real_escape_string($_POST['new_pwd']);//Deprecated: mysql_real_escape_string(): mysql extension
echo $new_pwd = $_POST['new_pwd'];//Deprecated: mysql_real_escape_string(): mysql extension

echo "<br>";
//echo $confirm_pwd = mysql_real_escape_string($_POST['confirm_pwd']);
echo $confirm_pwd = $_POST['confirm_pwd'];
echo "<br>";

echo $encrypted_old_pwd = password_hash($old_pwd, PASSWORD_DEFAULT);
echo "<br>";

echo check_user_exist($link, $userid);

echo "<br>";

//echo check_old_pwd($link, $encrypted_old_pwd);

//echo $encrypted_$new_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
//echo $encrypted_$confirm_pwd = password_hash($confirm_pwd, PASSWORD_DEF//AULT);

//update_user_pwd($link, $userid, $passwd);

//mysql_close($link);//is this right place to put it or in the function 

?>