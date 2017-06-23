<html>
<head>
<title>Form CSS only </title>
<link rel="stylesheet" href="css/test.css">
</head>
<body>
<?php
	echo $email= $_POST['email'];//it work!! 
?>

<form action="/action_page.php">
  

  <div class="container">

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
	
	<label><b>confirm Password</b></label>
    <input type="password" placeholder="confirm Password" name="confirm_psw" required>

    <button type="submit">Login</button>
    <input type="checkbox" checked="checked"> Remember me
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>

</body>
</html>