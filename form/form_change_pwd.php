<html>
<head><title>Wuuker -Password Change</title>
<link rel="stylesheet" href="css/csstable.css">

<script type="text/javascript">

function validateForm() {

var x=document.forms["user"]["email"].value;
			if (x==null || x=="")
			  {
			  alert("login name must be filled");
			  return false;
			  }

var x=document.forms["user"]["email"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
			if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
			  {
			  alert("Not a valid e-mail address");
			  return false;
			  }
			  			
}

</script>
</head>


<body>

<div id="SignUP">

<form name="user" method="post" action="form_update_pwd.php" onsubmit="return validateForm()"> 

<strong>Forget your password</strong>
</tr>
<tr> 
<td width="180">Login Email</td> 
<td width="6">:</td> 
<td width="294"><input name="email" type="text" id="email_change" size="40"></td> 
</tr>

<td>&nbsp;</td> 
<td>&nbsp;</td> 
<td><input type="submit" name="Submit" value="Submit"></td>
</tr> 
</table> 
</td> 
<a href="index.php">Back to front page</a>
</form> 

</div>

<body>
<html>