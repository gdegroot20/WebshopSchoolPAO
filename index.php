<?php
include 'functions/main/bootstrap.php';
bootstrap('functions');
init('ini_files');

session_start();

$login = new Login();
$cart = new shoppingcart();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Webshop</title>
		<meta name="description" content="" />
		<meta name="author" content="gdg" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/style.css"/>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript" src="js/util.js"></script>
		<script type="text/javascript" src="js/shoppingcart.js"></script>
		
		<?php if(!isset($_SESSION['loggedIn'])): ?>
			<script type="text/javascript" src="js/login.js"></script>
		<?php endif; ?>
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	</head>

	<body>
		<div id="container">
			<?php
			$content = new Content();
			$contentOutput= $content -> loadContent();
			
			$header = new Header();
			$headerOutput=$header -> getHeader($login,$cart);
	
			echo $headerOutput;
			echo $contentOutput;

			//echo isset($_SESSION) ? 'TRUE' : 'FALSE';
			?>
	
			<footer>
				<p>
					&copy; Gerrit de Groot en Timon de Groot
				</p>
			</footer>
		</div>
	</body>
</html>
