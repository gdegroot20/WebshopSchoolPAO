<?php

class Header {

	public function __construct() {
	}

	public function getHeader($login,$cart) {
		$output = '';
		
		$output.="<header>
				<div id='headerTop'>
					<div id='headerTopLinks'>";
					$output .= $login -> getLogin(false);
					if (!isset($_SESSION['loggedin'])) {
						$output .= '<a href="index.php?content=register">Register</a>';
					} else {
						$output .= '<a href="index.php?content=customerPage">Mijn account</a>';
						$account = $_SESSION['account'];
						if ($account -> hasRight('cms')) {
							$output .= '<a href="index.php?content=manage">Beheer</a>';
						}
					}
					$itemAmount = $cart->countItemsInCart();
					$totalprice = $cart->totalPriceCart();
					
					$output .= "
						<a href='index.php?content=contact'>Contact</a>
					</div>
				</div>
				<div id='headerBot'>
					<a href='../WebshopSchoolPAO'><h1>Zwart's Schoenen</h1></a>
					<div id='shoppingCart'>
						<div><span id='cartItemAmountHeader'>$itemAmount</span> | € <span id='cartTotalAmountHeader'>$totalprice,00</span></div>
						<a href='index.php?content=shoppingcart'><img src='images/header/shoppingcart.png' title='Mijn winkelwagen' /></a>
					</div>
				</div>
			</header>";
		/*
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
*/
		return $output;
	}

}
?>