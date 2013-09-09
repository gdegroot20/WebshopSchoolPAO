<?php
function dbConnect() {
	$con = mysql_connect(DB_HOST, DB_USN, DB_PASS);

	if (!$con) {
		die("MySQL could not connect: " . mysql_error());
	}

	mysql_select_db(DB_NAME);
}
?>