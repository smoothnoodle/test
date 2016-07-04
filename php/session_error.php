<?php
//http://stackoverflow.com/questions/25149848/error-reporting-in-php-session
//google: php session error off


session_start(); 
if (isset($_SESSION['Testing'])){
  echo "Value Exists";   
  $userid = $_SESSION['userid'];
}else{
  echo "Value does not exist"; 
  
}

?>