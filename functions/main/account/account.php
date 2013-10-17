<?php
class Account {

	private $id;
	private $email;
	private $profile;
	private $serial;
	private $activated;
	private $address;
	private $lastActivity;

	public function __construct($id, $email, $profile, $serial, $activated) {
		$this -> id = $id;
		$this -> email = $email;
		$this -> profile = $profile;
		$this -> serial = $serial;
		$this -> activated = $activated;
		$this -> initAddress();
	}

	private function initAddress() {
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('SELECT * FROM `adressen` WHERE `accountid` = ?');
		$param = array($this -> id);
		$query -> execute($param);
		$rows = $query -> fetch(PDO::FETCH_ASSOC);
		$this -> address = new Address($rows['Voornaam'], $rows['Tussenvoegsel'], $rows['Achternaam'], $rows['Postcode'], $rows['Straatnaam'], $rows['Huisnummer'], $rows['Plaats']);
	}
	
	public function update() {
		$this -> lastActivity = time();
	}
	
	public function hasRight($right) {
		switch ($right) {
			case 'cms' :
				return $this -> profile == 2;				
		}
	}

	public function getName() {
		return $this -> address -> getVoornaam() . ' ' . $this -> address -> getTussenvoegsel() . ' ' . $this -> address -> getAchternaam();
	}

	public function getProfile() {
		return $this -> profile;
	}
	
	public function shouldLogout() {
		return $this -> getDelta() > 450;
	}
	
	public function getDelta() {
		return (time() - $this -> lastActivity);
	}

	public function changeAddressForm() {
		$output = '	<form action="#" method="POST">
						<table>
							<TR>
								<TD><input type="text" name="firstName" value="' . $this -> address -> getVoornaam() . '" /></TD>
							</TR>
							<TR>
								<TD><input type="text" name="middleName" value="' . $this -> address -> getTussenvoegsel() . '" /></TD>
							</TR>
							<TR>
								<TD><input type="text" name="surName" value="' . $this -> address -> getAchternaam() . '" /></TD>
							</TR>
							<TR>
								<TD><input type="text" name="streetName" value="' . $this -> address -> getStraatnaam() . '" /></TD>
							</TR>
							<TR>
								<TD><input type="text" name="homeNumber" value="' . $this -> address -> getHuisnummer() . '" /></TD>
							</TR>
							<TR>
								<TD><input type="text" name="zipCode" value="' . $this -> address -> getPostcode() . '" /></TD>
							</TR>
							<TR>
								<TD><input type="text" name="city" value="' . $this -> address -> getPlaats() . '" /></TD>
							</TR>
							<TR>
								<TD><input type="submit" name="adjustAddressInfo" value="wijzigen"></TD>
							</TR>
						</table>
					</form>';

		return $output;
	}

	private function setAddress($firstName, $midName, $surName, $streetName, $homeNumber, $zipCode, $city) {
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('UPDATE adressen SET Voornaam = ? Tussenvoegsel = ? Achternaam = ? Postcode = ? Straatnaam = ? Huisnummer = ? Plaats = ? WHERE `accountid` = ?');
		$param = array($firstName, $midName, $surName, $zipCode, $streetName, $homeNumber, $city, $this -> id);
		$query -> execute($param);

		$this -> address -> setVoornaam($firstName);
		$this -> address -> setTussenvoegsel($midName);
		$this -> address -> setAchternaam($surName);
		$this -> address -> setStraatnaam($streetName);
		$this -> address -> setHuisnummer($homeNumber);
		$this -> address -> setPostcode($zipCode);
		$this -> address -> setPlaats($city);
	}

	public function changePasswordForm() {
		$output = '	<form action="' . $_SERVER["PHP_SELF"] . '?content=customerPage&page=adjustInfo" method="POST">
						<table>
							<TR>
								<TD><input type="password" placeholder="oud wachtwoord" name="passOld"/></TD>
							</TR>
							<TR>
								<TD><input type="password" placeholder="nieuw wachtwoord" name="passNew"/></TD>
							</TR>
							<TR>
								<TD><input type="password" placeholder="herhaal wachtwoord" name="passNewCheck"/></TD>
							</TR>
							<TR>
								<TD><input type="submit" name="adjustPassword" value="wijzigen"></TD>
							</TR>
						</table>
					</form>
						';
		return $output;
	}

	public function changePassword($passOld, $passNew, $passCheck) {
		if (md5($passOld) == $this -> getPassword()) {
			if ($passNew == $passCheck) {
				$this -> setPassword($passNew);
				$output = "Wachtwoord gewijzigd";
			} else {
				$output = "Wachtwoorden komen niet overeen.";
			}
		} else {
			$output = "Onjuist wachtwoord.";
		}

		return $output;
	}

	private function getPassword() {
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('SELECT Password FROM accounts WHERE id = ?');
		$param = array($this -> id);
		$query -> execute($param);
		$fetch = $query -> fetch(PDO::FETCH_ASSOC);

		return $fetch['Password'];
	}

	private function setPassword($passNew) {
		$passNew = md5($passNew);
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('UPDATE accounts SET `Password` = ? WHERE id = ?');
		$param = array($passNew, $this -> id);
		$query -> execute($param);
		$rows = $query -> fetch(PDO::FETCH_ASSOC);
	}

	public function showOrders() {
		$output = " ";
		$orders = $this -> getOrders();
		foreach ($orders as $order) {
			$items = explode(";", $order['Producten']);
			foreach ($items as $item) {
				$item = explode(",", $item);
				$amount = $item[1];
				$item = $this -> getItem($item[0]);
				$output .= $item["Naam"] . "<BR>" . $item["Prijs"] . "<BR>";
			}
		}

		return $output;
		//var_dump($orders);
	}

	private function getOrders() {
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('SELECT * FROM bestellingen WHERE accountid = ?');
		$param = array($this -> id);
		$query -> execute($param);
		$orders = $query -> fetchAll(PDO::FETCH_ASSOC);

		return $orders;
	}

	private function getItem($item) {
		$db = $GLOBALS['DB'];
		$query = $db -> prepare("SELECT * FROM producten WHERE id=?");
		$param = array($item);
		$query -> execute($param);
		$fetch = $query -> fetch();

		return $fetch;
	}

}
?>