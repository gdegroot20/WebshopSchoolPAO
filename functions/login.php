<?php

class Login {

	public function __construct() {
	}

	public function getLogin() {
		$output = '';
		if (isset($_SESSION['login'])) {
			$login = $_SESSION['login'];
			if ($login == 'loggedin')
				$this -> getLogoutForm();
			echo 'Logged in!';
		} else {
			$output .= $this -> getLoginForm();
		}
		return $output;
	}

	private function getLoginForm() {
		$output = '';

		$output .= '
		<form id="loginForm" action="index.php" method="post">
				<td>
					<input type="text" name="loginUsername" placeholder="Username">
				</td>
				<td>
					<input type="text" name="loginPassword" placeholder="Password">
				</td>
				<td>
					<input type="submit" name="login" value="Login">
				</td>
		</form>';

		return $output;
	}

	private function getLogoutForm() {
		$output = '';

		return $output;
	}

	private function login($username, $password) {

	}

	private function logout() {

	}

}
?>