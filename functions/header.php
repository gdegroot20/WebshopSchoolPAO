<?php

class Header {

	public function __construct() {
	}

	public function getHeader() {
		$login = new Login();
		$output = '';
		$output .= '
		<header>
			<h1>Zwarts Schoenen</h2>
			<nav id="topMenu">
				<table>
					<tr>';
					$output .= $login -> getLogin();
					$output .= '
						<td>
						<a href="/contact">Contact</a>
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