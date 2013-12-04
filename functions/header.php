<?php

class Header {

	public function __construct() {
	}

	public function getHeader($login) {
		$output = '';
		$output .= '
		<header>
			<h1>Zwarts Schoenen</h2>
			<nav id="topMenu">
				<table>
					<tr>';
					$output .= $login -> getLogin(false);
					if (!isset($_SESSION['loggedin'])) {
						$output .= '
						<td>
						<a href="index.php?content=register">Registreer</a>
						</td>';
					} else {
						$output .= '
						<td>
						<a href="index.php?content=customerPage">Account</a>
						</td>';
						$account = $_SESSION['account'];
						if ($account -> hasRight('cms')) {
							$output .= '
							<td>
							<a href="index.php?content=manage">Beheer</a>
							</td>';
						}
					}
					$output .= '
						<td>
						<a href="index.php?content=contact">Contact</a>
						</td>
						<td>
							<a href="index.php?content=shoppingcart" title="mijn winkelwagen"><img style="height:20px;"src="images/header/shoppingcart.png" /></a>
						</td>
					</tr>
				</table>
			</nav>
		</header>
		';

		return $output;
	}

}
?>