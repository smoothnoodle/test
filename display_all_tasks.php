<?php
	session_start(); 
	include 'include/functions.php';
	if(!$_SESSION["login"]){header("Location: out.php");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
  <title>TaskMe</title>
    <link rel="stylesheet" href="css/common.css">
</head>

<body>

<?php include "include/header2.php" ?>

<!-- Site navigation menu -->

<ul id="list-nav">
<li><a href="index.php">Home</a></li>
<li><a href="task_f.php">Create Task</a></li>
<li><a href="profile.php">Profile</a></li>
<li><a href="display_rating.php">Rating</a></li>
</ul>

<!-- Main content -->
<br>

<h1>All Available tasks</h1>

<?php
$userid = $_SESSION['userid'];

$link = connect($username, $password, $host, $db_name);

display_all_tasks($link, $userid);

mysql_close($link);

?>
</body>
</html>