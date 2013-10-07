<?php

class Login {

	public function __construct() {
	}

	public function getLogin() {
		$output = '<form id="loginForm" action="index.php" method="post">';

		session_start();

		if (isset($_POST['logoff'])) {
			$this -> logout();
		}

		if (isset($_POST['login'])) {
			$email = clean($_POST['loginEmail']);
			$password = clean($_POST['loginPassword']);
			$output .= $this -> login($email, $password);
		}

		if ((!isset($_SESSION['loggedin'])) || $_SESSION['loggedin'] == false) {
			$output .= $this -> getLoginform();
		} elseif ($_SESSION['loggedin'] === true) {
			$account = $_SESSION['account'];
			$output .= appendTD($account -> getName());
			$_POST['account'] = '';
			$_POST['pass'] = '';
			$output .= $this -> getLogoutForm();
		}

		return $output . '</form>';
	}

	private function getLoginForm() {
		$output = '';

		$output .= '
				<td>
					<input type="text" title="E-mail" name="loginEmail" placeholder="E-mail">
				</td>
				<td>
					<input type="password" title="Wachtwoord" name="loginPassword" placeholder="Wachtwoord">
				</td>
				<td>
					<input type="submit" name="login" value="Login">
				</td>';

		return $output;
	}

	private function getLogoutForm() {
		$output = '';

		$output .= '
				<td>
					<input type="submit" name="logoff" value="Log uit">
				</td>';

		return $output;
	}

	private function login($email, $password) {
		$output = '';

		if (!isset($GLOBALS['DB']))
			$GLOBALS['DB'] = dbConnect();

		$db = $GLOBALS['DB'];

		$query = $db -> prepare('SELECT * FROM `accounts` WHERE `Email` = ? AND `Password` = ?');
		$param = array($email, md5($password));
		$query -> execute($param);

		$rows = $query -> fetch(PDO::FETCH_ASSOC);
		$rowCount = $query -> rowCount();

		if ($rowCount == 1) {
			$account = new Account($rows['id'], $rows['Email'], $rows['profile'], $rows['Serial'], $rows['Activated']);
			$_SESSION['account'] = $account;
			$_SESSION['loggedin'] = true;
			$output .= appendTD('Succesvol ingelogd!');
		} else {
			$output .= appendTD('Ongeldige login gegevens');
		}
		if (!$rows) {
			$output .= appendTD('Inloggen mislukt!');
		}
		return $output;
	}

	private function logout() {
		$output = '';
		session_destroy();
		$_SESSION = array();
		return $output;
	}

}
?>