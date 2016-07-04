<?php 
session_start();

if(isset($_SESSION['pageview'])){
	$_SESSION['pageview']++;
	echo 'The number of times this page has been viewed: '.$_SESSION['pageview'];

}
else{
	$_SESSION['pageview']=1;
	echo 'This is the first View';
}
?>
<html>
<body>
	<a href='sessionsreset.php'>Session reset</a> 
</body>
</html>

