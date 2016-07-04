<?php 
	session_start();
	unset($_SESSION['pageview']);
	session_destroy();
	echo 'Session has been Reset';
?>
<html>
<bod>
	<a href="session.php">click here</a>
</body>
</html>