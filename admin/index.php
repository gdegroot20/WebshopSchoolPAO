<?php

require_once ('../functions/main/bootstrap.php');
bootstrap('../functions/main');
bootstrap('functions');
init('../ini_files');

session_start();

$login = new Login();


if (isset($_SESSION['loggedin'])) {
	$account = $_SESSION['account'];
} else {
	die('You are not logged in!');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
	</head>

	<body class="main">
		<div id="container">
			<div id="page">
				<?php
				$header = new AdminHeader();
				echo $header -> getHeader($login);
				?>
				<nav>
					<ul>
						<li>
							Producten
						</li>
						<li>
							Categorie&euml;n
						</li>
						<li>
							Klanten
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</body>

</html>