<html>
<head><title>test password update</title>
<script type="text/javascript">

function validateForm() {

var x=document.forms["user"]["old_pwd"].value;
			if (x==null || x=="")
			  {
			  alert("old password must be filled");
			  return false;
			  }	  

var x=document.forms["user"]["new_pwd"].value;
			if (x==null || x=="")
			  {
			  alert("new password must be filled");
			  return false;
			  }	

var x=document.forms["user"]["confirm_pwd"].value;
			if (x==null || x=="")
			  {
			  alert("confirm password must be filled");
			  return false;
			  }			

var x=document.forms["user"]["new_pwd"].value;
var y=document.forms["user"]["confirm_pwd"].value;
			if (x!=y){
			  alert("Password not match");
			  return false;
			}			  

}

</script>
</head>

<body>


<!-- Main content -->


<div id="SignUP">

<form name="user" method="post" action="update_pwd.php" onsubmit="return validateForm()"> 
<td> 
<table border="0"> 

<tr> 
<td colspan="3"><strong>password update</strong></td> 
</tr>

<tr> 
<td width="180">Old Password</td> 
<td width="6">:</td> 
<td width="294"><input name="old_pwd" type="password"  size="40"></td> 

</tr>

<tr> 
<td width="180">New Password</td> 
<td width="6">:</td> 
<td width="294"><input name="new_pwd" type="password"  size="40"></td> 
</tr>


<tr> 
<td width="180">confirm New Password</td> 
<td width="6">:</td> 
<td width="294"><input name="confirm_pwd" type="password" size="40"></td>  
</tr>


<td>&nbsp;</td> 
<td>&nbsp;</td> 
<td><input type="submit" name="Submit" value="Update"></td>
</tr> 
</table> 
</td> 
</form> 

</div>

</body>
</html>