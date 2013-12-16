<?php

class AdminHeader {

	public function __construct() {
	}

	public function getHeader($login) {
		$output = '';
		$output .= '
		<header >
			<h1>Beheer</h2>
			<nav id="topMenu">
				<table>
					<tr>';
					$output .= $login -> getLogin(true);
					$output .= '
						<td>
							<a href="../admin/">Home CMS</a>
						</td>
						<td>
						| <a href="../">Terug naar de homepage</a> |
						</td>'. (isset($_SERVER['HTTP_REFERER']) ? '<td>
							<a href="'.$_SERVER['HTTP_REFERER'].'">Vorige</a> |
						</td>' : '').
					'</tr>
				</table>
			</nav>
		</header>
		';

		return $output;
	}

}
?>