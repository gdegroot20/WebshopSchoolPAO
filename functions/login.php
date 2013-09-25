<?php

class Login {

	public function __construct() {
	}

	public function getLogin() {
		$output = '';

		if (isset($_POST['login'])) {
			$email = clean($_POST['loginEmail']);
			$password = clean($_POST['loginPassword']);
			$this -> login($email, $password);
		}

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
					<input type="text" title="E-mail" name="loginEmail" placeholder="E-mail">
				</td>
				<td>
					<input type="password" title="Wachtwoord" name="loginPassword" placeholder="Wachtwoord">
				</td>
				<td>
					<input type="submit" name="login" value="Login">
				</td>
		</form>';

		return $output;
	}

	private function getLogoutForm() {
		$output = '';

		$output .= '
		<form id="logoutForm" action="index.php" method="post">
				<td>
					<input type="submit" name="logout" value="Log uit">
				</td>
		</form>';

		return $output;
	}

	private function login($email, $password) {

		if (!isset($GLOBALS['DB']))
			$GLOBALS['DB'] = dbConnect();

		$db = $GLOBALS['DB'];

		$query = $db -> prepare('SELECT * FROM `accounts` WHERE `Email` = ? AND `Password` = ?');
		$param = array($email, md5($password));
		$query -> execute($param);

		$rows = $query -> fetch(PDO::FETCH_ASSOC);

		if (!$rows) {
			echo 'Query Failed!';
		} else {
			
		}

	}

	private function logout() {

	}

}
?>