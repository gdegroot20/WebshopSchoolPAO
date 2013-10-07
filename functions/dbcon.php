<?php
function dbConnect() {
	
	$db = new PDO('mysql:host=localhost;dbname=webshop;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$GLOBALS['DB'] = $db;
	
	return $db;
}
?>