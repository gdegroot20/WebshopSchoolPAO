<?php

class Login {

	private $log = '';

	public function __construct() {
		if (isset($_POST['logoff'])) {
			$this -> logout();
		} else if (isset($_POST['login'])) {
			$email = clean($_POST['loginEmail']);
			$password = clean($_POST['loginPassword']);
			$this -> log .= $this -> login($email, $password);
		}
	}

	public function getLogin($forceHome) {
		$output = '<form id="loginForm" ' . ($forceHome ? 'action="../index.php"' : '') . ' method="post">';

		$output .= $this -> log;

		if ((!isset($_SESSION['loggedin'])) || $_SESSION['loggedin'] == false) {
			$output .= $this -> getLoginform();
		} else if ($_SESSION['loggedin'] === true) {
			$account = $_SESSION['account'];
			if ($account -> shouldLogout()) {
				$this -> logout();
				header('Location: /index.php');
			} else {
				$output .= appendTD($account -> getName());
				$_POST['account'] = '';
				$_POST['pass'] = '';
				$output .= $this -> getLogoutForm();
				$account -> update();
			}
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
			$account -> update();
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

	public function logout() {
		$output = '';
		session_destroy();
		session_unset();
		session_start();
		return $output;
	}

}
?>