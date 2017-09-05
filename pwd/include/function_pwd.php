<?php 
include 'settings.php';
date_default_timezone_set('Australia/Brisbane');

//Common on every page
//===========================================================================================================
function connect($username, $password, $host, $db_name){#reuse this code that's the aim

	$link = @mysql_connect("$host", "$username", "$password");
	if(! $link){
		die("Couldn't connect to MySQL: ".mysql_error());
	}
	mysql_select_db("$db_name")or die("cannot select DB: ".mysql_error()); 
	return $link;
};

//update_pwd.php
//===========================================================================================
function check_user_exist($link, $user_id){
	
	$sql = "select * from user where id = '$user_id';";
	
	$result = mysql_query($sql, $link);
	$count = mysql_num_rows($result);
	
	mysql_query($sql, $link);
	
	return $count;//0 user doesn't exist, 1 mean 1 user exist, 1+ there are some wrong  
}

function check_old_pwd($link, $user_id){
	
	if (check_user_exist($link, $user_id) == 1){
			//password 
			
	}else{
		echo "user doesn't exist";
	}
	
	
}
//==============================================================================================



//create_activity_report.php
//===============================================================================================
function create_activity_report($link, $user_id, $wuuk_id, $wuuk_name, $report){

	$sql = "INSERT INTO activity_report (`id`, `wuuk_id`, `wuuk_name`, `user_id`, `report`, `time_stamp`) VALUES (NULL, $wuuk_id, '$wuuk_name', $user_id, '$report', CURRENT_TIMESTAMP);";
	//echo $sql;
	mysql_query($sql, $link);
}

//create_bug_report.php
//===============================================================================================
function create_bug_report($link, $user_id, $user_name, $url_link, $bug_report){
	
	$sql = "INSERT INTO bug_report (`id`, `user_id`, `user_name`, `url`, `detail`, `timestamp`) VALUES (NULL, '$user_id', '$user_name', '$url_link', '$bug_report', CURRENT_TIMESTAMP);";
	//echo $sql;
	mysql_query($sql, $link);//missing error tacking here
}


//form_deliverer_report.php
//===========================================================================================================
function return_wuuk_name($link, $task_id){
	
	$sql ="select name from wuuk where id = '$task_id';";
	$result = mysql_query($sql,$link);
	if(!$result){
		die('Invalid query: '.mysql_error());
	};

	$name = mysql_result($result,0);
	return $name; 
	
};

//maker_detail.php
//===========================================================================================================
//display maker's detail to taker success/fail comments is a must
//joint table wuuk to this 
function display_maker_detail($link, $maker_id){
//display the lastest four tasks on the index.php

	$sql = "SELECT * FROM maker_rating where user_id = '$maker_id' and status = 'completed';";

	$result = mysql_query($sql, $link);
	$count=mysql_num_rows($result);

	if ($count ==0){echo "No Work available";}else{
		echo "<table border=1>";
		echo "<tr><th width='163px'>Rating</th><th>Comment</th><th>Result</th><th>Time completed</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td></tr>";
		};
		echo "</table>";
	};
};



//index.php 
//===========================================================================================================
function display_latest($link){
//Purpose: display the lastest four wuuk on the index.php
//Call from: index.php


	$sql = "SELECT * from wuuk where status = 'open' ORDER BY id desc LIMIT 4;";

	$result = mysql_query($sql, $link);
	$count=mysql_num_rows($result);

	if ($count ==0){echo "No Wuuk available";}else{
		echo "<table border=1>";
		echo "<tr><th width='163px'>Wuuk Name</th><th>Pay</th><th>Detail</th></tr>";
		$count =0;
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$count=$count + 1;
			if($count==1){
				echo "here";
				echo "<tr><td><span class='txt_green'>$row[2]<span></td><td>$row[4]</td><td><a href ='applytask.php?id=$row[0]'>detail</a></td></tr>";	
			}else{	
				echo "<tr><td>$row[2]</td><td>$row[4]</td><td><a href ='applytask.php?id=$row[0]'>detail</a></td></tr>";
			};
		};
		echo "</table>";
	};
};

function display_latest_unsign($link){
//Purpose: display the lastest four wuuk on the index.php
//Call from: index.php


	$sql = "SELECT * from wuuk where status = 'open' ORDER BY id desc LIMIT 4;";

	$result = mysql_query($sql, $link);
	$count=mysql_num_rows($result);

	if ($count ==0){echo "No wuuk available";}else{
		echo "<table border=1>";
		echo "<tr><th width='163px'>Name</th><th>Detail</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[2]</td><td><a href ='applytask.php?id=$row[0]'>detail</a></td></tr>";
		};
		echo "</table>";
	};
};


function check_creater_completed($link, $userid){
	$status="closed";
	$result="completed";
	
	$sql = "select * from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' and id not in (select task_id from maker_rating) order by id desc;";
	
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	
	If($isempty ==0){ return 0; }//if no rating  
	return 1; //yes rating exist
};


function check_creater_fail($link, $userid){
	$status="closed";
	$result="fail";
	$sql = "select * from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' and id not in (select task_id from maker_rating) order by id desc;";
	
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){ return 0; }//if no rating  	
	return 1; //yes rating exist
};

function check_deliverer_completed($link, $userid){

	$sql = "SELECT wuuk.id, name, suburb, price from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='completed' and wuuk.id not in(select task_id from maker_rating) ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	
	$result = mysql_query($sql, $link);
	$isEmpty=mysql_num_rows($result);
	If($isEmpty ==0){return 0;}
	return 1; //yes rating exist
};

function check_deliverer_fail($link, $userid){

	$sql = "SELECT wuuk.id, name, suburb, price from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='fail' and wuuk.id not in(select task_id from maker_rating) ORDER BY wuuk.id DESC;";
	//echo $sql."<br>"; 
	
	$result = mysql_query($sql, $link);
	$isEmpty=mysql_num_rows($result);
	If($isEmpty ==0){return 0;}
	return 1; //yes rating exist
};


function check_rating_notification($link, $userid){
	$check1=check_creater_completed($link, $userid);
	$check2=check_creater_fail($link, $userid);
	$check3=check_deliverer_completed($link, $userid);
	$check4=check_deliverer_fail($link, $userid);
	
	$count = $check1+$check2+$check3+$check4;
	
	if($count>0){
		 return $count;
	}
	return 0; //no rating
};


function check_history_notification($link, $userid){
	$check1 =check_maker_completed_history($link, $userid);
	$check2 =check_maker_fail_history($link, $userid);
	$check3 =check_taker_completed_history($link, $userid);
	$check4 =check_taker_fail_history($link, $userid);
	$check5 =check_maker_cancel_history($link, $userid,'closed','cancel');
	$check6 =check_taker_cancel_history($link, $userid);
	
	$count = $check1+$check2+$check3+$check4+$check5+$check6;
	
	if($count>0){
		 return $count;
	}
	return 0; //no rating
};

function check_display_running($link, $userid){
//purpose: display how many wuuk running
//call from: profile_wuuk.php
//change: display_maker_running.php

	$sql = "select count(*) from wuuk where tasker_id ='$userid' and status ='running' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){return 0;}//if no rating 
	return mysql_result($result,0); 
};

function check_display_open($link, $userid){
	$final_count = 0;
	$sql = "select * from wuuk where tasker_id ='$userid' and status ='open' order by id desc;";
	
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){return 0;}

		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$count = tasker_count($link, $row[0]);
			$final_count = $final_count + $count;		
		};
		return $final_count;

};

function check_display_taker_running($link, $userid){
//purpose: display taker wuuk running
//call from: profile_wuuk.php
//change: none

	$sql = "SELECT count(wuuk.id) from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'running' ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){return 0;}//if no rating 
	return mysql_result($result,0); 
};

function check_wuuk($link, $userid){
	  $wuuk_running_result=check_display_running($link, $userid);
	  $wuuk_accept_count = check_display_open($link, $userid);
	
	  $count = $wuuk_running_result + $wuuk_accept_count;
	
	if($count>0){
		 return $count;//if there is rating
	}
	return 0; //no rating
};

function check_delivery($link, $userid){
	  $delivery_running_result=check_display_taker_running($link, $userid);  
	  $count = $delivery_running_result;
	
	if($count>0){
		 return $count;//if there is rating
	}
	return 0; //no rating
};


//login.php 
//===========================================================================================================
function getid($link, $login){
//a good template for getvalue!!
	$sql = "select * from user where email = '$login';";
	$result = mysql_query($sql, $link);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	$id = $row[0];
	return $id;
};

function count_email($link, $login){
	$sql="SELECT * FROM user WHERE email='$login'"; 
	$result=mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;//1 = user email exist or 0 mean not exist\
};

function count_urby_email($link, $login){
	$sql="SELECT * FROM urby_user WHERE email='$login'"; 
	$result=mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;//1 = user email exist or 0 mean not exist\
};

function get_passwd($link, $login){
	$sql="SELECT * FROM user WHERE email='$login'"; 
	$result=mysql_query($sql, $link);
	$row=mysql_fetch_array($result);
	$passwd = $row['passwd'];//this is the problem! 
	//echo $passwd;
	return $passwd;
};

function login($count, $link, $login, $pass){
	//echo $pass;
	if ($count = 1){
		$encrypted_password = get_passwd($link, $login);//what is this for?
		
		//$passwd = get_passwd($link, $login);//old code 	

		//if ($pass == $passwd){//old code 
		if (password_verify($pass, $encrypted_password)) {// 1 is true	
			$_SESSION['login'] = $login;
			$_SESSION['userid'] = getid($link,$_SESSION['login']);
			//echo "successful";
		}else{
			echo "Wrong password";
			printf("<script>location.href='passwd.php'</script>");//what is this?
		};
		//echo $passwd;
		//$_SESSION['login'] = $count;
	}else{
			echo "you are not register";
	};
};

//admin_login.php
//============================================================================================================
function count_admin_email($link, $login){
	$sql="SELECT * FROM admin WHERE email='$login'"; 
	$result=mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;//1 = user email exist or 0 mean not exist\
};

function get_admin_passwd($link, $login){
	$sql="SELECT * FROM admin WHERE email='$login'"; 
	$result=mysql_query($sql, $link);
	$row=mysql_fetch_array($result);
	$passwd = $row['passwd'];//this is the problem! 
	//echo $passwd;
	return $passwd;
};

function admin_login($count, $link, $login, $pass){// I don't know how this work. so complicated??
	//echo $pass;
	if ($count = 1){
		//$passwd = get_admin_passwd($link, $login);
		$encrypt_passwd = get_admin_passwd($link, $login);
		//if ($pass == $passwd){
		if (password_verify($pass, $encrypt_passwd)){
			$_SESSION['admin_login'] = $login;
			printf("<script>location.href='admin.php'</script>");
		}else{
			echo "Wrong password";
			printf("<script>location.href='admin_passwd.php'</script>");//what is this? why do u do this way? route to another page call passwd?? Seriously need to take a look how ppl do it nowaday
		};
		//echo $passwd;
		//$_SESSION['login'] = $count;
	}else{
			echo "you are not register";
	};
};

//Search_name.php & Search_community.php
//============================================================================================================
function search($link, $result, $menu){//break the string into an array, single word search and mulitple word search

echo "Search for ".$menu.":  '".$result."'";

echo "<br><br>";//why one <br> doesn't work?

	if ($menu=='today'){
		$result = date('y-m-d');
		$menu='start';
		//echo $result;
	};

	if ($result==''){//test for null value, important
		$testNull = 1;
	}else{
		$testNull = 0;};

	$result1 = "%".$result."%";
	$menu1 = $menu;

	$sql = "select * from wuuk where $menu1 like '$result1' and status = 'open' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	
	if ($count == 0 ||$testNull == 1){echo "No Wuuk available";}else{
		echo "<table border=1>";
		echo "<tr><td>Community</td><td>Wuuk Name</td><td>Description</td><td>Pay(per wuuk)</td><td>Detail</td><td>Date & Time created</td></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[3]</td><td>$row[2]</td><td WIDTH='250' >$row[5]</td><td>$row[4]</td><td><a href ='applytask.php?id=$row[0]'>Apply</a></td><td>$row[8]</td></tr>";
		};
		echo "</table>";
	};
};

//ApplyTask
//============================================================================================================
function check_user($link, $taskid, $taskerid){//check is
	$sql = "select * from wuuk where id = $taskid and tasker_id = $taskerid;";
	//echo $sql;
	$result = mysql_query($sql, $link);
	$num_rows = mysql_num_rows($result);
	//echo "rows: '".$num_rows. "'";
	return $num_rows;
};

function apply_wuuk($link, $wuuk_id){//change name, really old code 
	//echo $session[$id] = $id;
	$sql = "select * from wuuk where id = '$wuuk_id';";
	$result = mysql_query($sql, $link);
	$wuuker_id = get_tasker_id($link, $wuuk_id);//change $wuuker_id to new standard
	
	
	$point = get_maker_pts($link, $wuuker_id);
	//$pts = get_maker_pts($link, $task_id);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	echo "<h2>Wuuk information:</h2>";
	echo "<table border =1>";
	
	
	echo "<tr><td>Community:</td><td>$row[3]</td></tr>";
	echo "<tr><td>Wuuk Id:</td><td>$row[0]</td></tr>";
	echo "<tr><td>Wuuk Name:</td><td>$row[2]</td></tr>";
	
	echo "<tr><td>Pay:</td><td>$row[4]</td></tr>";
	echo "<tr><td>Does the pay include the cost of supplies:</td><td>$row[10]</td></tr>";
	echo "<tr><td>Detail:</td><td>$row[5]</td></tr>";
	
	echo "<tr><td>Wuuker's point:</td><td>$point</td></tr>";
	echo "<tr><td>Wuuk's review:</td><td><a href='display_maker_stat.php?wuuk_id=$wuuk_id'>Click here</a></td></tr>";
	
	echo "<td><a href ='task_applied.php?taskid=$wuuk_id'><img src='images/apply.jpg' width='100'></a></td>";
	echo "</table>";
	echo "Please report any illegal, sexism, racism, discrimination and offensive activities <a href ='form_deliverer_report.php?id=$wuuk_id'>here</a>";

};

//task_applied.php
//============================================================================================================
function check_open($link, $taskid, $taskerid){//check is
	$sql = "select * from wuuk_offer where task_id = $taskid and user_id = $taskerid;";
	//echo $sql;
	$result = mysql_query($sql, $link);
	$num_rows = mysql_num_rows($result);
	//echo "rows: '".$num_rows. "'";
	return $num_rows;
};

function offer($link, $taskid, $taskerid){//Don't update status here
	$sql = "INSERT INTO wuuk_offer (`id` ,`task_id` ,`user_id`) VALUES (NULL , '$taskid', '$taskerid');";
	//echo $sql;
	mysql_query($sql, $link);
};

//change_password.php
//===========================================================================================================
function check_user_pwd(){
	
}

function update_user_pwd($link, $userid, $passwd){
	//call check_user_pwd() to check old password
	//update the old password with the new one 
	//is this secure enough? 
	
	$sql = "UPDATE user SET fname='$fname', lname='$lname', phone='$phone', `desc`='$study', skills='$skill' WHERE id='$userid'";
	//change database field name 

	mysql_query($sql, $link);
};




//create_work.php
//============================================================================================================
function create_task($link, $taskerid, $name, $suburb, $price, $desc, $method_contact, $cost_supply){//remember it has to be 
//purpose: insert the wuuk data into database table wuuk
//call from: create_work.php
//change: name to create_wuuk()

	$status = "open";//open should done in database
	$sql = "INSERT INTO wuuk (`id`, `tasker_id`, `name`, `suburb`, `price`, `desc`, `status`, `method_contact`, `cost_supply`) VALUES (NULL, '$taskerid', '$name', '$suburb', '$price', '$desc', '$status', '$method_contact' , '$cost_supply');";
	//echo $sql;
	mysql_query($sql, $link) or die('Invalid query: ' .mysql_error());
	
};

function display_uni($login){
$str_uq1="@uq.edu.au";
$str_uq2="@uqconnect.edu.au";
$str2="@griffith.edu.au";
$str3="@student.qut.edu.au";

if (stristr($login,$str_uq1,0)==true){
	//echo "UQ";
	return "UQ";
};

if (stristr($login,$str_uq2,0)==true){
	//echo "UQ";
	return "UQ";
};

if (stristr($login,$str2,0)==true){
	//echo "Griffith";
	return "Griffith";
};

if (stristr($login,$str3,0)==true){
	//echo "QUT";
	return "QUT";
};

return "none";
	
};


//create_user.php
//============================================================================================================
function create_user($link, $fname, $lname, $phone, $email, $sex,  $encrypt_passwd, $desc, $skill, $community, $lang){
	$sql = "INSERT INTO user (`id`, `fname`, `lname`, `phone`, `email`, `sex`, `passwd`, `desc`, `skills`, `maker_pts`, `taker_pts`,`location`, `lang` ) VALUES (NULL, '$fname', '$lname', '$phone', '$email', '$sex', '$encrypt_passwd', '$desc', '$skill', 0, 0, '$community', '$lang');";
	//echo $sql;
	$result = mysql_query($sql, $link);
	if (!$result) {//! not something???
		die('Invalid query: ' .mysql_error());// mysql_error() return msg; 1062
	};
};

function create_urby($link, $fname, $lname, $phone, $email,  $passwd, $desc, $skill, $room, $lang, $uni, $sex){
	$status = "confirmed";//this is the key, remember confirmed is important  
	$sql = "INSERT INTO urby_user (`id`, `fname`, `lname`, `phone`, `email`, `passwd`, `desc`, `skills`, `room`, `lang`, `status`,`location`, `sex`) VALUES (NULL, '$fname', '$lname', '$phone', '$email', '$passwd', '$desc', '$skill', '$room', '$lang', '$status', '$uni', '$sex');";
	//echo $sql;
	$result = mysql_query($sql, $link);
	if (!$result) {//! not something???
		die('Invalid query: ' .mysql_error());// mysql_error() return msg; 1062
	};
};

function return_user_id($link, $email){
	
	$sql = "select id from user where email ='$email';";
	//echo $sql; 
	$result = mysql_query($sql, $link);
	if (!$result) {//! not something???
		die('Invalid query: ' .mysql_error());// mysql_error() return msg; 1062
	};
	
	$userid = mysql_result($result,0);//mysql_result(data,row,field)
	return $userid;
};

function return_urby_id($link, $email){//what is this for? why I wrote this?
	$sql = "select id from urby_user where email ='$email';";
	//echo $sql;
	$result = mysql_query($sql, $link);
	if (!$result) {//! not something???
		die('Invalid query: ' .mysql_error());// mysql_error() return msg; 1062
	};
	
	$userid = mysql_result($result,0);//mysql_result(data,row,field)
	return $userid;
};

//create_admin.php
//=========================================================================================
function create_admin($link, $email, $fname, $lname, $encrypt_passwd, $class){
	
	$sql = "INSERT INTO admin (`id`, `email`, `passwd`,  `fname`, `lname`,  `class`) VALUES (NULL, '$email','$encrypt_passwd', '$fname', '$lname','$class');";
	//echo $sql;
	$result = mysql_query($sql, $link);
	if (!$result) {//! not something???
		die('Invalid query: ' .mysql_error());// mysql_error() return msg; 1062
	};
};


//vert_user.php
//============================================================================================================
function vert_user($link, $userid){

	$sql = "UPDATE user SET status='confirm' WHERE id=$userid";
	mysql_query($sql, $link);
};

//profile.php 
//============================================================================================================
function display_user($link, $userid){
//purpose: display user info  
//call from: profile.php
//change: none
//comment: Sometimes is better do it this way.. don't need loops

	$sql = "select * from user where id = '$userid';";
	$result = mysql_query($sql, $link);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	echo "<table border =1>";
	echo "<tr><td><b>Community:</b></td><td>$row[13]</td></tr>";
	//echo "<tr><td><b>First name:</b></td><td>$row[1]</td></tr>";
	//echo "<tr><td><b>Last Name:</b></td><td>$row[2]</td></tr>";
	echo "<tr><td><b>Phone:</b></td><td>$row[4]</td></tr>";
	echo "<tr><td><b>email:</b></td><td>$row[5]</td></tr>";
	//echo "<tr><td><b>$row[12] course study:</b></td><td>$row[6]</td></tr>";
	echo "<tr><td><b>Study:</b></td><td>$row[7]</td></tr>";
	echo "<tr><td><b>Skills:</b></td><td>$row[8]</td></tr>";
	echo "<tr><td><b>Total wuuker rating:</b></td><td>$row[9]</td></tr>";
	echo "<tr><td><b>Total Deliverer rating:</b></td><td>$row[10]</td></tr>";	
	echo "</table>";
	
	$userinfo = array($row[4],$row[5]);
	return $userinfo;
};

function return_user_name($link, $userid){
//purpose: display user info  
//call from: profile.php
//change: none
//comment: Sometimes is better do it this way.. don't need loops
//call from: display_taker_closed_rating.php

	$sql = "select * from user where id = '$userid';";
	$result = mysql_query($sql, $link);
	$row = mysql_fetch_array($result, MYSQL_NUM);
		
	$name = $row[1]." ".$row[2];
	return $name;
};


//form_update_user.php 
//============================================================================================================
function display_update_user($link, $userid){
//purpose: update user info
//call from: form_user_update.php 
//return array $row
//change: none
//comment: 

	$sql = "select * from user where id = '$userid';";
	$result = mysql_query($sql, $link);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	//print_r($row);
	return $row;
};

//update_user.php
//============================================================================================================
//purpose: update user info
//call from: user_update.php 
//return array $row
//change: none
//comment: 

function update_user($link, $userid, $fname, $lname, $phone, $study, $skill){
	//echo "enter the dragon";
	//echo $study;
	
	$sql = "UPDATE user SET fname='$fname', lname='$lname', phone='$phone', `desc`='$study', skills='$skill' WHERE id='$userid'";
	//change database field name 

	mysql_query($sql, $link);
};


//cancel_open_task.php
//============================================================================================================
function update_task_cancel($link, $taskid){
		//echo "search";
		$sql = "UPDATE wuuk SET result='none', status='closed' WHERE id=$taskid;";
		//echo $sql."<br>";
		mysql_query($sql, $link);
};

//profile_wuuk.php
//============================================================================================================
function tasker_count($link, $task_id){
//purpose: to count how many wuuk = task_id
//call from: profile_wuuk.php
//change: count_maker()

	$sql = "select * from wuuk_offer where task_id = $task_id";
	$result = mysql_query($sql, $link);
	$num_rows = mysql_num_rows($result);
	return $num_rows;
};

function display_open($link, $userid){
//purpose: display how many wuuk waiting to be accepted
//call from: profile_wuuk.php
//change: display_maker_open.php

	$sql = "select * from wuuk where tasker_id ='$userid' and status ='open' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){echo "No Wuuk";}
	else{
		echo "<table border=1 CELLPADDING=2 CELLSPACING=2>";
		echo "<tr><th>Wuuk id</th><th>Name of the wuuk</th><th>Description</th><th>Applied</th><th>Time created</th><th>status</th><th>Cancel</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$count = tasker_count($link, $row[0]);
			If($count==0){//there is two rows, can I write this better
				echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[5]</td><td>$count</td><td>$row[8]</td><td><a href ='check_work_status.php?id=$row[0]'>view</a></td><td><a href ='cancel_open_task.php?id=$row[0]'>cancel</a></td></tr>";
			}else{
				echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[5]</td><td><span class ='wuuker_text'>$count</span></td><td>$row[8]</td><td><a href ='check_work_status.php?id=$row[0]' class ='txt_orange' >view</a></td><td><a href ='cancel_open_task.php?id=$row[0]'>cancel</a></td></tr>";
			};
		};
		echo "</table>";
	};
};
function display_running($link, $userid){
//purpose: display how many wuuk running
//call from: profile_wuuk.php
//change: display_maker_running.php

	$sql = "select * from wuuk where tasker_id ='$userid' and status ='running' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){echo "No Wuuk";}
	else{
			echo "<table border=1>";
			echo "<tr><th>Wuuk id</th><th>Name of the wuuk</th><th>Description</th><th>Time created</th><th>Taker Contact</th></tr>";
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[5]</td><td>$row[8]</td><td><a href ='display_taker_contact.php?id=$row[0]'>detail</a></td></tr>";
			};
			echo "</table>";
	};
};

//input_rating.php
//============================================================================================================
function display_closed_maker_completed($link, $userid){
	$status="closed";
	$result="completed";
	//echo $userid." "; 
	$sql = "select * from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' and id not in (select task_id from maker_rating) order by id desc;";
	//echo $sql."<br>";
	
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	
	//move check_maker_rating here
	If($isempty ==0){echo "No Rating"; return 0; }//check does wuuk exist or not.. huge waste of resources here, not good!! 
		
	else{
		
		echo "<table border=1>";
		echo "<tr><th>Wuuk id</th><th>Name</th><th>Description</th><th>Rating</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[5]</td><td><a href ='display_maker_closed_rating.php?id=$row[0]' class='rating'>Not rated</a></td></tr>";
		};
		echo "</table>";
	};
	return 1; 
};

function display_closed_maker_fail($link, $userid){
	$status="closed";
	$result="fail";
	$sql = "select * from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' and id not in (select task_id from maker_rating) order by id desc;";
	
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){echo "No Rating";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Work id</th><th>Name</th><th>Description</th><th>Rating</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[5]</td><td><a href ='display_maker_closed_rating.php?id=$row[0]' class='rating'>No comment</a></td></tr>";
		};
		echo "</table>";
	};
};

function display_closed_taker_completed($link, $userid){

	$sql = "SELECT wuuk.id, name, suburb, price from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='completed' and wuuk.id not in(select task_id from maker_rating) ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	
	$result = mysql_query($sql, $link);
	$isEmpty=mysql_num_rows($result);
	If($isEmpty ==0){echo "No Rating";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Wuuk ID</th><th>Name of the wuuk</th><th>Suburb</th><th>Earning</th><th>Rating</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href ='form_input_maker_completed.php?taskid=$row[0]&&name=$row[1]' class='rating'>not rated</a></td></tr>";
		};
		echo "</table>";
	};
	
};

function display_closed_taker_fail($link, $userid){

	$sql = "SELECT wuuk.id, name, suburb, price from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='fail' and wuuk.id not in(select task_id from maker_rating) ORDER BY wuuk.id DESC;";
	//echo $sql."<br>"; 
	
	$result = mysql_query($sql, $link);
	$isEmpty=mysql_num_rows($result);
	If($isEmpty ==0){echo "No Rating";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Wuuk ID</th><th>Name of the wuuk</th><th>Suburb</th><th>Earning</th><th>Comment</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href ='form_input_maker_fail.php?taskid=$row[0]&&name=$row[1]' class='rating'>No comment</a></td></tr>";
		};
		echo "</table>";
	};
};

//display_maker_stat.php
//==========================================================================================================


function display_maker_stat($link, $userid, $result, $limit){
	$status="closed";
	$temp = $result;
	
	
	$sql = "select start, name from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' order by id desc LIMIT $limit;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){echo "No Record";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Date & Time</th><th>Name</th><th>Status</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$temp</td></tr>";
		};
		echo "</table>";
	};
};



//display_history.php
//==========================================================================================================
function display_maker_completed_history($link, $userid){
	$status="closed";
	$result="completed";
	
	$sql = "select * from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){echo "No Wuuk";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Work id</th><th>Name</th><th>Description</th><th>Rating</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			if(check_maker_rating($link, $row[0]) == 0){}else
			{echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[5]</td><td><a href ='display_maker_closed_rating.php?id=$row[0]'>Rated</a></td></tr>";};
		};
		echo "</table>";
	};
};

function display_maker_fail_history($link, $userid){
	$status="closed";
	$result="fail";
	$sql = "select * from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){echo "No Wuuk";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Work id</th><th>Name</th><th>Description</th><th>Rating</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			if(check_maker_rating($link, $row[0]) == 0){}else
			{echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[5]</td><td><a href ='display_maker_closed_rating.php?id=$row[0]'>comment</a></td></tr>";};
		};
		echo "</table>";
	};
};

function display_taker_completed_history($link, $userid){
	$sql = "SELECT wuuk.id, name, suburb, price from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='completed' ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isEmpty=mysql_num_rows($result);
	If($isEmpty ==0){echo "Not available";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Wuuk ID</th><th>Name of the wuuk</th><th>Suburb</th><th>Earning</th><th>Rating</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			if(check_maker_rating($link, $row[0]) == 0){}else
			{echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href ='display_taker_closed_rating.php?id=$row[0]'>rated</a></td></tr>";};
		};//few bugs here may be!!!
		echo "</table>";
	};
};

function display_taker_fail_history($link, $userid){
	$sql = "SELECT wuuk.id, name, suburb, price from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='fail' ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isEmpty=mysql_num_rows($result);
	If($isEmpty ==0){echo "Not available";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Wuuk ID</th><th>Name of the wuuk</th><th>Suburb</th><th>Earning</th><th>Comment</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			if(check_maker_rating($link, $row[0]) == 0){}else
			{echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href ='display_taker_closed_rating.php?id=$row[0]'>comment</a></td></tr>";};
		};//few bugs here may be!!!
		echo "</table>";
	};
};

function display_taker_cancel_history($link, $userid){
	$sql = "SELECT wuuk.id, name, suburb, price from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='cancel' ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	
	$result = mysql_query($sql, $link);
	$isEmpty=mysql_num_rows($result);
	If($isEmpty ==0){echo "Not available";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Wuuk ID</th><th>Name of the wuuk</th><th>Suburb</th><th>Earning</th><th>Rating</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			if(check_maker_rating($link, $row[0]) == 0){//few bugs here may be!!!
			echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href ='cancel_work.php'>Cancel</a></td></tr>";}else
			{echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href ='taski_finished_rated.php?id=$row[0]'>rating</a></td></tr>";};
		};
		echo "</table>";
	};
};

function display_maker_cancel_history($link, $userid, $status, $result){
	//echo "search";
	//echo $userid;
	$sql = "select * from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){echo "No Wuuk";}
	else{
		echo "<table border=1>";
		echo "<tr><th>Work id</th><th>Name</th><th>Description</th><th>Rating</th></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[5]</td><td><a href ='cancel_work.php'>cancelled</a></td></tr>"; 
		};
		echo "</table>";
	};
};


function check_maker_completed_history($link, $userid){
	$status="closed";
	$result="completed";
	
	$sql = "select count(*) from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	if($result === FALSE) { 
		die(mysql_error()); //better error handling
	};
	$count = mysql_result($result,0);
	return $count;
};

function check_maker_fail_history($link, $userid){
	$status="closed";
	$result="fail";
	$sql = "SELECT count(*) from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	if($result === FALSE) { 
		die(mysql_error()); //better error handling
	};
	$count = mysql_result($result,0);
	return $count; 
};

function check_taker_completed_history($link, $userid){
	$sql = "SELECT count(*) from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='completed' ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	if($result === FALSE) { 
		die(mysql_error()); //better error handling
	};
	$count = mysql_result($result,0);
	return $count; 
};

function check_taker_fail_history($link, $userid){
	$sql = "SELECT count(*) from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='fail' ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	if($result === FALSE) { 
		die(mysql_error()); //better error handling
	};
	$count = mysql_result($result,0);
	return $count; 
};

function check_maker_cancel_history($link, $userid, $status, $result){
	//echo "search";
	//echo $userid;
	$sql = "select count(*) from wuuk where tasker_id ='$userid' and status ='$status' and result ='$result' order by id desc;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	if($result === FALSE) { 
		die(mysql_error()); //better error handling
	};
	$count = mysql_result($result,0);
	return $count;
};

function check_taker_cancel_history($link, $userid){
	$sql = "SELECT count(*) from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'closed' and wuuk.result ='cancel' ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	
	$result = mysql_query($sql, $link);
	if($result === FALSE) { 
		die(mysql_error()); //better error handling
	};
	$count = mysql_result($result,0);
	return $count; 
};

//profile_wuuk.php
//============================================================================================================
function display_taker_apply($link, $userid){//test
//purpose: display taker wuuk open  
//call from: profile_wuuk.php
//change: display_maker_open()

	$sql = "SELECT wuuk.id, name, suburb, price from wuuk inner JOIN wuuk_offer ON wuuk.id=wuuk_offer.task_id and wuuk_offer.user_id = '$userid' and wuuk.status = 'open' ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){echo "Not available";}
	else{
		echo "<table border=1>";
		echo "<hd><tr><td>Wuuk id</td><td>Name</td><td>Community</td><td>Price</td><td>Detail</td></tr></hd>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href ='display_open_wuuk_detail.php?id=$row[0]'>detail</a></td></tr>";
			//printf("ID: %s  Name: %s", $row[0], $row[1]);  
		};
		echo "</table>";
	};

};

function display_taker_running($link, $userid){
//purpose: display taker wuuk running
//call from: profile_wuuk.php
//change: none

	$sql = "SELECT wuuk.id, name, suburb, price from wuuk inner JOIN wuuk_accept ON wuuk.id=wuuk_accept.task_id and wuuk_accept.user_id = '$userid' and wuuk.status = 'running' ORDER BY wuuk.id DESC;";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){echo "Not available";}
	else{
		echo "<table border=1>";
		echo "<hd><tr><td>Wuuk id</td><td>Name</td><td>University</td><td>Price</td><td>Maker Contact</td></tr></hd>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href ='display_maker_contact.php?id=$row[0]'>Contact Detail</a></td></tr>";
			//printf("ID: %s  Name: %s", $row[0], $row[1]);  
		};
		echo "</table>";
	};
};

//check_work_status.php
//============================================================================================================

function IsEmpty($link, $taskid){//Is this use? It has nothing to do with Taski_closed
	//echo "search";
	$sql = "select * from wuuk_offer where task_id ='$taskid';";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	//echo $count;
	return $count;
};

function IsIn_task_accept($link, $taskid){
	$sql = "select * from wuuk_accept where task_id ='$taskid';";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;
};

function taski_list($link, $taskid){//name change
//echo $taskid;
	//$sql = "SELECT user.fname, user.lname, user.study, user.skills, user.taker_pts, wuuk_offer.wuuk_id, wuuk_offer.user_id FROM user JOIN wuuk_offer ON wuuk_offer.user_id = user.id AND wuuk_offer.task_id ='$taskid';";
	$sql = "SELECT user.fname, user.lname , user.desc , user.skills , user.taker_pts , wuuk_offer.task_id,wuuk_offer.user_id FROM user JOIN wuuk_offer ON wuuk_offer.user_id = user.id AND wuuk_offer.task_id ='$taskid';";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	echo "<table border=1>";
	echo "<tr><th>Name</th><th>Bio</th><th>Skills</th><th>Pts Earned</th><th>Accept</th></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		echo "<tr><td>$row[0] $row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td><a href ='display_taker_apply.php?taskid=$row[5]&&userid=$row[6]'>Accept the Offer</a></td></tr>";
		//echo "test: ". $row[2];
	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
		echo "<br>";
	};
	echo "</table>";

};

//admin.php
//===============================================================
function display_transfer($link){//name change, fix the problem with copy and paste

	$sql = "Select id, fname, lname, phone, email, room, timestamp from urby_user where status = 'confirmed'";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	echo "<table border=1>";
	echo "<tr><th>id</th><th>first</th><th>last</th><th>phone</th><th>email</th><th>room</th><th>timestamp</th><th>transfer</th></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td><td><a href ='transfer_urby.php?urby_user_id=$row[0]'>transfer now</a></td></tr>";
		//echo "test: ". $row[2];
	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
		echo "<br>";
	};
	echo "</table>";

};

function display_bug_report($link){//name change, fix the problem with copy and paste

	$sql = "Select id, user_id, user_name, url, detail, timestamp from bug_report";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	echo "<table border=1>";
	echo "<tr><th>id</th><th>user_id</th><th>user_name</th><th>url</th><th>detail</th><th>timestamp</th></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td></tr>";
		//echo "test: ". $row[2];
	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
		echo "<br>";
	};
	echo "</table>";
};

function display_activity_report($link){//name change, fix the problem with copy and paste

	$sql = "Select * from activity_report";
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	echo "<table border=1>";
	echo "<tr><th>id</th><th>wuuk_id</th><th>wuuk_name</th><th>user_id</th><th>report</th><th>timestamp</th></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td></tr>";
		//echo "test: ". $row[2];
	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
		echo "<br>";
	};
	echo "</table>";
};


//Transfer_urby
//=============================================================================================================
function transfer_urby($link, $urby_user_id){
	echo $urby_user_id;
	$sql = "INSERT INTO user (fname, lname, sex, phone, email, passwd, `desc`, skills, status, location)SELECT fname, lname, sex, phone, email, passwd, `desc`, skills, status, location FROM urby_user where id = $urby_user_id;";
	echo $sql;
	mysql_query($sql, $link);
};

function update_urby($link, $urby_user_id){
	//echo "search";
	$sql = "UPDATE urby_user SET status='transfer' WHERE id=$urby_user_id;";
	//echo $sql."<br>";
	mysql_query($sql, $link);
	//echo $result
};

//display_taker_contact.php
//============================================================================================================ 
function display_taski($link, $taskid){//change name //compond 
//purpose: display taker contact detail, this is very important of the project, must work..  
//call from: display_taker_contact.php
//change: display_taker_contact()
	//echo "hello";
	//echo $taskid;
	$sql = "SELECT user.id, user.fname, user.lname, user.phone, user.email, user.desc, user.skills, user.taker_pts, user.location FROM user inner JOIN wuuk_accept ON user.id=wuuk_accept.user_id and task_id ='$taskid';";
	//$sql = "SELECT user.id FROM user inner JOIN wuuk_accept ON user.id=wuuk_accept.user_id and wuuk.task_id =4;";
	
	$result = mysql_query($sql, $link);
	$result1 = mysql_query($sql, $link);
	
	$row = mysql_fetch_array($result, MYSQL_NUM);
	echo "<table border=1>";
		echo "<tr><td><b>Community:</b></td><td>$row[8]</td></tr>";
		echo "<tr><td><b>First name:</b></td><td>$row[1]</td></tr>";
		echo "<tr><td><b>Last Name:</b></td><td>$row[2]</td></tr>";
		echo "<tr><td><b>Phone:</b></td><td>$row[3]</td></tr>";
		echo "<tr><td><b>email:</b></td><td>$row[4]</td></tr>";
		echo "<tr><td><b>Study:</b></td><td>$row[5]</td></tr>";
		echo "<tr><td><b>Skills:</b></td><td>$row[6]</td></tr>";
		echo "<tr><td><b>Total delivery rating:</b></td><td>$row[7]</td></tr>";
	echo "</table>";
	
	echo "<table border=1>";
	echo "<tr><th>Completed</th><th> Fail </th><th>Cancel</th></tr>";
	while ($row = mysql_fetch_array($result1, MYSQL_NUM)) {
		echo "<tr><td><a href ='form_input_taker_completed.php?wuuk_id=$taskid&&user_id=$row[0]&&fname=$row[1]&&lname=$row[2]'>Complete</a></td><td><a href ='form_input_taker_fail.php?wuuk_id=$taskid&&user_id=$row[0]&&fname=$row[1]&&lname=$row[2]'>Fail</a></td><td><a href ='task_confirm.php?id=$taskid'>Cancel</a></td></tr>";
	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
		echo "<br>";
	};
	echo "</table>";

};

//task_confirm.php
//============================================================================================================
function task_warning($link, $taskid){

	$sql = "SELECT * from wuuk where id =$taskid;";//how come only desc field cause error???
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	echo "<table border=1>";
	echo "<tr><td>Id</td><td>Name</td><td>Suburb</td><td>Pay</td></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>";
	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
	};
	echo "</table>";
	echo "<br>";
	echo "Cancel the work now, would result an seven days ban, if the taker launch an complaint ";
	echo "<br>";
	echo "Are u sure u want to close it?  <a href ='task_cancel_closed.php?id=$taskid'>CLOSE!!</a>";
	
	
};

//task_closed.php no longer exist.   display_maker_contact.php??
//===========================================================================================================
function display_task($link, $taskid){//display_maker_contact.php??

	$sql = "SELECT * from wuuk where id =$taskid;";// dsec is SQL standard syntax!!! 
	$result = mysql_query($sql, $link);
	
	echo "<table border='1'>";
	echo "<tr><th>Wuuk_id</th><th>Wuuk Name</th><th>Detail</th><th>Pay(hr)</th><th>Include cost of supplies</th></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	
		echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[5]</td><td>$row[4]</td><td>$row[10]</tr>";
	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
		echo "<br>";
	};
	echo "</table>";
};


function display_wuuk_time($link, $taskid){//display_maker_contact.php??

	$sql = "SELECT start from wuuk where id =$taskid;";// dsec is SQL standard syntax!!! 
	$result = mysql_query($sql, $link);
	
	$isempty = mysql_num_rows($result);
	If($isempty ==0){return 0;}//if no rating 
	
	$datetime = mysql_result($result,0);
	echo "<h2><b>$datetime</b></h2>";
	return $datetime;
	
};

function return_method_contact($link, $contact, $taskid){//this is way better function to return an single value but it will outdate soon :( 

	$sql = "SELECT method_contact from wuuk where id =$taskid;";// dsec is SQL standard syntax!!! 
	$result = mysql_query($sql, $link);
	$isempty=mysql_num_rows($result);
	If($isempty ==0){return 0;}//if no rating 
	$result = mysql_result($result,0);
	if($result == "sms"){
		return "sms ".$contact[0];
	};
	if($result == "call"){
		return "call ".$contact[0];
	};
	if($result == "email"){
		return "email ".$contact[1];
	};
	
};

//display_taker_closed_rating.php
//=======================================================================================

function get_wuuker_id($link, $taskid){
//wuuker name is easy, just query table wuuk
	$sql = "select tasker_id from wuuk where id = '$taskid';";
	$result = mysql_query($sql, $link);

	$isempty=mysql_num_rows($result);
	If($isempty ==0){return 0;}//if no rating 
	$wuuker_id=mysql_result($result,0); 
	
	return $wuuker_id; //yes rating exist
}


function get_deliverer_id($link, $taskid){
//wuuker name is easy, just query table wuuk
	$sql = "select user_id from wuuk_accept where task_id = '$taskid';";
	$result = mysql_query($sql, $link);

	$isempty=mysql_num_rows($result);
	If($isempty ==0){return 0;}//if no rating 
	$deliverer_id=mysql_result($result,0); 
	
	return $deliverer_id; //yes rating exist
}



function display_taker_rating($link, $taskid){
	$sql = "SELECT rate, comment, status FROM taker_rating where task_id =$taskid;";//how come only desc field 
	$result = mysql_query($sql, $link);
	echo "<table border=1>";
	echo "<tr><th>Rate</th><th>comment</th><th>status</th></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)){
		echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
		echo "<br>";
	};
	echo "</table>";
};

function display_maker_rating($link, $taskid){
	//echo $taskid;
	$sql = "SELECT rate, comment, status FROM maker_rating where task_id =$taskid;";//how come only desc field? because SQL standard syntax
	$result = mysql_query($sql, $link);
	echo "<table border=1>";
	echo "<tr><th>Rate</th><th>comment</th><th>status</th></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)){
		echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
		echo "<br>";
	};
	echo "</table>";
};

//remove it ;)
function check_maker_rating($link, $taskid){
	//echo $taskid." ";
	$sql = "select * from maker_rating where task_id = $taskid;";//if task_id is not exist, there is no comment.
	//echo $sql."<br>";
	$result=mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;
};

//remove it? 
function check_taker_fail($link, $taskid){
	$sql = "select * from taker_rating where wuuk_id = $taskid and status = 'fail';";
	//echo $sql;
	$result=mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;
};

function check_taker_rating($link, $taskid){
	$sql = "select * from taker_rating where wuuk_id = $taskid;";
	//echo $sql;
	$result=mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;
};

function task_completed($link, $taskid){
//may be use in more than one  
		//echo "search";
		$sql = "UPDATE wuuk SET status='closed' WHERE id=$taskid;";
		//echo $sql."<br>";
		mysql_query($sql, $link);
};

function update_task_fail($link, $taskid){
		//echo "search";
		$sql = "UPDATE wuuk SET result='fail', status='closed' WHERE id=$taskid;";
		//echo $sql."<br>";
		mysql_query($sql, $link);
};

function task_test_update($link, $taskid){
		$sql = "UPDATE wuuk SET result='fail', status='closed' WHERE id=$taskid;";
		echo $sql."<br>";
		mysql_query($sql, $link);
};

function get_taski($link, $taskid){//test successful, no use??
		$sql = "SELECT user_id FROM `wuuk_accept` WHERE task_id = $taskid;";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result, MYSQL_NUM);
		$id = $row[0];
		//echo "taski id ".$id;
		return $id;
};

function cancel_rating($link, $taskid, $taski_id){//may you should merge with wuuk_accept table... why? do u need this?
		$sql = "INSERT INTO `taker_rating (`id`, `wuuk_id`, `user_id`, `rating`, `comment`, `status`, `timestamp`) VALUES (NULL, $taskid, '$taski_id', 'cancel', '', 'cancel', CURRENT_TIMESTAMP);";
		//echo $sql."<br>";
		mysql_query($sql, $link);
};

function add_rating($link, $taskid, $taski_id){
		$sql = "UPDATE user SET taker_pts=taker_pts+1 WHERE id=$taski_id";
		//echo $sql."<br>";
		mysql_query($sql, $link);
};

function cancel_after_applied($link, $taskid){
		//echo "search";
		$sql = "UPDATE wuuk SET result='cancel', status='closed' WHERE id=$taskid;";
		//echo $sql."<br>";
		mysql_query($sql, $link);
};

//insert_taker_failure.php
//============================================================================================================
function insert_taker_failure_rating($link, $task_id, $taski_id, $comment){
	
	$sql = "INSERT INTO taker_rating (`id` ,`task_id` ,`user_id` ,`rate` ,`comment` ,`status`) VALUES (NULL , $task_id,  $taski_id, 'none', '$comment', 'fail');";
	//echo $sql;
	mysql_query($sql, $link) or die('Invalid query: ' .mysql_error());;

};

function update_taker_failure_closed($link, $taskid){
		//echo "search";
		$sql = "UPDATE wuuk SET result='fail', status='closed' WHERE id=$taskid;";
		//echo $sql."<br>";
		mysql_query($sql, $link);
};


//insert_taker_completed.php
//============================================================================================================
function taker_rating($link, $task_id, $taski_id, $rating, $comment){//insert taker's rating
//dangerous comment 
	
	$status = "completed";//
	$sql = "INSERT INTO taker_rating (`id` ,`task_id` ,`user_id` ,`rate` ,`comment` ,`status`) VALUES (NULL , $task_id,  $taski_id,  '$rating',  '$comment',  '$status');";
	//echo $sql;
	mysql_query($sql, $link) or die('Invalid query: ' .mysql_error());;

};

function reward_pts($rating){
	if ($rating == "ok"){
		$pts = 2;
	};
	if ($rating == "good"){
		$pts = 4;
	};
	if ($rating == "excellent"){
		$pts = 8;
	};
	return $pts;
};

function istaker_rating($link, $taski_id, $task_id){//check is Taker rated
	$sql="SELECT * FROM  taker_rating WHERE task_id	=  $task_id and user_id = $taski_id"; 
	$result=mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;//1 = user email exist or 0 mean not exist\
};

function taski_update($link, $taski_id, $pts){//update taker's point
	$sql ="UPDATE user SET taker_pts=taker_pts+$pts WHERE id=$taski_id;";//use full knowledge to know, you can add 
	//echo $sql;
	mysql_query($sql, $link) or die('Invalid query: '.mysql_error());
};

function taker_completed_closed($link, $taskid){
		//echo "search";
		$sql = "UPDATE wuuk SET result='completed', status='closed' WHERE id=$taskid;";
		//echo $sql."<br>";
		mysql_query($sql, $link);
};

//form_input_maker_completed.php
//============================================================================================================
function get_rating($link, $task_id, $user_id){
	$sql="SELECT * FROM taker_rating WHERE task_id	= $task_id and user_id = $user_id";
	$result=mysql_query($sql, $link);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	$rating = $row[3];
	return $rating;
};

function get_comment($link, $task_id, $user_id){//$user_id no need!!
	$sql="SELECT * FROM taker_rating WHERE task_id	= $task_id and user_id = $user_id";
	$result=mysql_query($sql, $link);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	$comment = $row[4];
	return $comment;
};

function get_tasker_id($link, $task_id){//tested and it work fine!! 
	$sql="SELECT * FROM wuuk WHERE id = $task_id";
	$result=mysql_query($sql, $link);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	$id = $row[1];
	return $id;
};

function get_maker_pts($link, $wuuker_id){//tested and it work fine!! 
	$sql="SELECT * FROM user WHERE id = $wuuker_id";
	$result=mysql_query($sql, $link);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	$id = $row[9];
	return $id;
};

//insert_rating2.php
//============================================================================================================
function maker_rating($link, $task_id, $tasker_id, $rating, $comment){//check completed
	$status = "completed";
	$sql = "INSERT INTO  maker_rating (`id` ,`task_id` ,`user_id` ,`rate` ,`comment` ,`status`) VALUES (NULL , $task_id,  $tasker_id,  '$rating',  '$comment',  '$status');";
	//echo $sql;
	mysql_query($sql, $link) or die('Invalid query: ' .mysql_error());;

};

function maker_rating_completed($link, $task_id, $tasker_id, $rating, $comment){//check completed
	$status = "completed";//should be fail
	$sql = "INSERT INTO  maker_rating (`id` ,`wuuk_id` ,`user_id` ,`rate` ,`comment` ,`status`) VALUES (NULL , $task_id,  $tasker_id,  '$rating',  '$comment',  '$status');";
	//echo $sql;
	mysql_query($sql, $link) or die('Invalid query: ' .mysql_error());;

};

function maker_rating_fail($link, $task_id, $tasker_id, $rating, $comment){//check completed
	$status = "fail";//should be fail
	$sql = "INSERT INTO  maker_rating (`id` ,`task_id` ,`user_id` ,`rate` ,`comment` ,`status`) VALUES (NULL , $task_id,  $tasker_id,  '$rating',  '$comment',  '$status');";
	//echo $sql;
	mysql_query($sql, $link) or die('Invalid query: ' .mysql_error());;

};

function isMaker_rating($link, $tasker_id, $task_id){
	$sql="SELECT * FROM  maker_rating WHERE task_id =  $task_id and user_id = $tasker_id"; 
	$result=mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;//1 = user email exist or 0 mean not exist\
};


//display_rating.php
//============================================================================================================
function display_rating_tasker($link){
//purpose: display maker rating  
//call from: display_rating.php
//change: display_maker_rating()

	$count =0;
	$sql = "SELECT id, fname, lname, skills, maker_pts, email, location FROM user order by maker_pts DESC;";//desc field, SQL standard syntax
	$result = mysql_query($sql, $link);
	echo "<table>";
	echo "<tr><th>Rank</th><th>Community</th><th>First name</th><th>Surname</th><th>skills</th><th>total pts</th></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		//$uni=display_uni($row[5]);
		$count = $count + 1;
		echo "<tr><td>$count</td><td>$row[6]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>";
	};
	echo "</table>";
};

function display_rating_taski($link){
//purpose: display taker rating  
//call from: display_rating.php
//change: display_taker_rating()

	$count =0;
	$sql = "SELECT id, fname, lname, skills, taker_pts, email, location FROM user order by taker_pts DESC;";//desc field causing problem again
	$result = mysql_query($sql, $link);
	echo "<table>";
	echo "<tr><th>Rank</th><th>Community</th><th>First name</th><th>Surname</th><th>skills</th><th>total pts</th></tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	//$uni=display_uni($row[5]);
	$count = $count + 1;
		echo "<tr><td>$count</td><td>$row[6]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>";
	};
	echo "</table>";

};

//show_all_task.php
//========================================================================================================
function is_wuuk_none($link, $userid){
	$sql ="SELECT count(*) from wuuk where status = 'open' and tasker_id != $userid;"; 
	$result = mysql_query($sql,$link);
	if($result === FALSE) { 
		die(mysql_error()); //better error handling
	};
	$count = mysql_result($result,0);
	return $count; 
	
};

function display_all_tasks($link, $userid){
//display all wuuk 
//call from index.php

	//echo $userid;
	//echo "search";
	echo "hello";
	
	if(!$_SESSION['userid']){
		$sql = "SELECT * from wuuk where status = 'open';";//if no userid??? 
	}else{
		$sql = "SELECT * from wuuk where status = 'open' and tasker_id != $userid;";//show every wuuk but not the owner's
	};

	$result = mysql_query($sql, $link);//still confuse about this.. u should know it by heart now
	if($result === FALSE) { 
		die(mysql_error()); //better error handling
	};
	
	echo "<table border=1>";
		echo "<tr><td>Community</td><td>Wuuk Name</td><td>Description</td><td>Pay(per hour)</td><td>Detail</td><td>Date & Time created</td></tr>";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "<tr><td>$row[3]</td><td>$row[2]</td><td WIDTH='250' >$row[5]</td><td>$row[4]</td><td><a href ='applytask.php?id=$row[0]'>Apply</a></td><td>$row[8]</td></tr>";
		};
		echo "</table>";

};

//============================================================================================================

function accept($link, $taskid, $taskerid){//why insert use mysql_result
	$sql = "INSERT INTO wuuk_accept (`id` ,`task_id` ,`user_id`) VALUES (NULL ,  '$taskid',  '$taskerid');";
	//echo $sql;
	$result=mysql_query($sql, $link);
	if (!$result) {//! not something???
		die('Invalid query: ' .mysql_error());// mysql_error() return msg; 1062
	};
};

function check_offer($link, $taskid, $taskerid){//use numofnow..
	$sql = "select * from wuuk_offer where wuuk_id = $taskid and user_id = $taskerid;";
	//echo $sql;
	$result=mysql_query($sql, $link);
	$count=mysql_num_rows($result);
	return $count;
};

function update($link, $taskid){
	//echo "search";
	$sql = "UPDATE wuuk SET status='running'WHERE id=$taskid;";
	//echo $sql."<br>";
	mysql_query($sql, $link);
	//echo $result
};

//display_task_detail.php
//===========================================================================================================
function display_task_applied($link, $taskid){
	//echo "search";
	$sql = "SELECT * from wuuk where id =$taskid;";//how come only desc field cause error???
	//echo $sql."<br>";
	$result = mysql_query($sql, $link);
	
	echo "<table border=1>";
	echo "<tr><th>Work id</th><th>Name</th><th>Community</th><th>Price</th><th>Description</th><th>Date&time created</tr>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)){
	    echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[8]</td></tr>";
		//printf("ID: %s  Name: %s", $row[0], $row[1]);  
		echo "<br>";
	};
	echo "</table>";
};

//test_vert.php
//===========================================================================================================
function update_user_status($link, $user_id, $status){

	$sql = "UPDATE user SET status='$status' WHERE id=$user_id;";
	echo $sql."<br>";
	mysql_query($sql, $link);
	//echo $result
};

function tasker_update($link, $tasker_id, $pts){
	$sql ="UPDATE user SET maker_pts=maker_pts+$pts WHERE id=$tasker_id;";
	//echo $sql;
	mysql_query($sql, $link) or die('Invalid query: '.mysql_error());
};


?>