<?php 

include 'settings.php';
date_default_timezone_set('Australia/Brisbane');

//Common on every page
//===========================================================================================================
function connect($username, $password, $host, $db_name){#reuse this code that's the aim

	$link = mysql_connect("$host", "$username", "$password");
	if(! $link){
		die("Couldn't connect to MySQL: ".mysql_error());
	}
	mysql_select_db("$db_name")or die("cannot select DB: ".mysql_error()); 
	return $link;
};

//show_all_task.php
//========================================================================================================
function display_all_tasks($link, $userid){//good coding here
//what is input and return value???

	//echo "search";
	
		//$sql = "SELECT * FROM task where status = 'open' and tasker_id != $userid;";
		
		$sql = "SELECT * FROM task where status = 'open';";

	$result = mysql_query($sql, $link);
	echo "<table border=1>";
	echo "<hd><tr><td>Name</td><td>Suburb</td><td>Price($)</td><td>Description</td></td><td>Date & Time Created</td></hd>";
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		echo "<tr><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[7]</td></tr>";
	};
	echo "</table>";

};

//=============================================================================================================

Function query($sql,$username, $password, $host, $db_name) {
	$link = connect($username, $password, $host, $db_name);
	$result = mysql_query($sql, $link);
	mysql_close($link);
	echo "run";
    return $result;
}

?>