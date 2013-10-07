<?php
function dbConnect() {
	
	$db = new PDO('mysql:host=localhost;dbname=webshop;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$GLOBALS['DB'] = $db;
	
	/*$con = mysql_connect(DB_HOST, DB_USN, DB_PASS);
	if (!$con) {
		die("MySQL could not connect: " . mysql_error());
	}

	mysql_select_db(DB_NAME);*/
	return $db;
}
?>