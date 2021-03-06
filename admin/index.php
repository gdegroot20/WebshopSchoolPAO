<?php

require_once ('../functions/main/bootstrap.php');
bootstrap('../functions/main');
bootstrap('functions');
init('../ini_files');
dbConnect();

session_start();

$login = new Login();
$cms = new CMS();

if (isset($_SESSION['loggedin'])) {
	$account = $_SESSION['account'];
} else {
	die('You are not logged in!');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		<script type="text/javascript" src="scripts/main.js"></script>
	</head>

	<body class="main">
		<div id="container">
			<div id="page">
				<?php
				$header = new AdminHeader();
				echo $header -> getHeader($login);
				echo $cms -> load();
				?>
			</div>
		</div>
	</body>

</html>