<?php
include 'functions/bootstrap.php';
bootstrap('functions');
init('ini_files');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>index</title>
		<meta name="description" content="" />
		<meta name="author" content="gdg" />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/style.css"/>
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	</head>

	<body>
		<div>
			<header>
				<span>
					<A>Zwart's Schoenen</A>
				</span>
				
			</header>
			
			<nav id='leftside'>
				<ul id='leftMenu'>
					<li>
						<a href='#'>Categorie</a>
						<ul>
							<li>
								<a href='#'>subCategorie</a>
							</li>
						</ul>
					</li>
					<li>
						<a href='#'>Categorie</a>
						<ul>
							<li>
								<a href='#'>subCategorie</a>
							</li>
							<li>
								<a href='#'>subCategorie</a>
							</li>
							<li>
								<a href='#'>subCategorie</a>
							</li>
						</ul>
					</li>
					<li>
						<a href='#'>Categorie</a>
					</li>
					<li>
						<a href='#'>Categorie</a>
					</li>
					<li>
						<a href='#'>Categorie</a>
					</li>
				</ul>
			</nav>
			

			<div id="content">
				<?php //echo contactForm();?>
				
				<!--
				<table id="item_list">
					<TR>
						<td class='item_image'  rowspan="2">
							<img src='' />
						</td>
						<td class='item_name' colspan="2">
							<b>title</b>
						</td>
					</TR>
					<TR>
						<td class='item_description' colspan="2">
							description negerin enzo
						</td>
						<td>
							<table class='item_price_table'>
								<tr>
									<td>
										Nu voor:
									</td>
								</tr>
								<tr>
									<td>
										€ 300,
									</td>
									<td>
										00
									</td>
								</tr>
								<tr>
									<td>
										<button>bestellen</button>
									</td>
								</tr>
							</table>
						</td>
					</TR>
					<TR>
						<td class='item_image'  rowspan="2">
							<img src='' />
						</td>
						<td class='item_name' colspan="2">
							title
						</td>
					</TR>
					<TR>
						<td class='item_description' colspan="2">
							description negerin enzo
						</td>
						<td>
							<table class='item_price_table'>
								<tr>
									<td>
										Nu voor:
									</td>
								</tr>
								<tr>
									<td>
										€ 300,
									</td>
									<td>
										00
									</td>
								</tr>
								<tr>
									<td>
										<button>bestellen</button>
									</td>
								</tr>
							</table>
						</td>
					</TR>
				</table>
				-->
			</div>

			<footer>
				<p>
					&copy;
				</p>
			</footer>
		</div>
	</body>
</html>
