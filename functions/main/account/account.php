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

	public function changeAddress($firstName, $midName, $surName, $streetName, $homeNumber, $zipCode, $city) {
		$output = "";
		if (!empty($firstName) && !empty($midName) && !empty($surName) && !empty($streetName) && !empty($homeNumber) && !empty($zipCode) && !empty($city)) {
			$patterns = array("/[^\d\/:*?\"<>\|]$/", "/^\d+$/", "/^[1-9][0-9]{3}\s?[a-zA-Z]{2}$/");

			if (preg_match($patterns[0], $firstName) && preg_match($patterns[0], $midName) && preg_match($patterns[0], $surName) && preg_match($patterns[0], $streetName) && preg_match($patterns[1], $homeNumber) && preg_match($patterns[2], $zipCode) && preg_match($patterns[0], $city)) {

				$this -> setAddress(clean($firstName), clean($midName), clean($surName), clean($streetName), clean($homeNumber), clean($zipCode), clean($city));
				$output .= "Gegevens succesvol aangepast";
			} else {
				$output .= "Bepaalde velden zijn niet juist ingevuld";
			}
		} else {
			$output .= "Velden mogen niet leeg zijn";
		}
		return $output;
	}

	private function setAddress($firstName, $midName, $surName, $streetName, $homeNumber, $zipCode, $city) {
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('UPDATE adressen SET Voornaam = ? ,Tussenvoegsel = ? ,Achternaam = ?, Postcode = ? ,Straatnaam = ? ,Huisnummer = ? ,Plaats = ? WHERE `accountid` = ?');
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
		$output = "<div id='viewOrders'>";
		$orders = $this -> getOrders();
		foreach ($orders as $order) {
			$output .= "	<table class='tableviewOrders'>
							<TR>
								<TD>BestelNummer : " . $order['id'] . " | Datum besteld : " . $order['BestelDag'] . "
							</TR>
							<table class='innerTableViewOrders'>
								<TR>
									<TD>Product</TD>
									<TD>Hoeveelheid</td>
									<TD>prijs</td>
									<td>totaal Prijs</td>
								</TR>";

			$items = explode(";", $order['Producten']);
			$totaalprijs = 0;
			foreach ($items as $item) {
				$item = explode(",", $item);
				$amount = $item[1];
				$item = $this -> getItem($item[0]);
				$prijs = $item["Prijs"] * $amount;
				$totaalprijs += $prijs;
				$output .= "	<TR>
								<TD><img src='#'/><a href='#'> " . $item["Naam"] . "</a></TD>
								<TD>" . $amount . "</TD>
								<TD>€ " . $item["Prijs"] . "</TD>
								<TD>€ " . $prijs . "</TD>
							</TR>";
			}
			$output .= '		<TR>
								<TD></TD>
								<TD></TD>
								<TD><b>Totaal</b></TD>
								<TD>€ ' . $totaalprijs . '</TD>
							</TR>
						</table>
					</table>';
		}
		$output .= '</div>';
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

	public function confirmCheckout() {
		if (isset($_SESSION['Items']) && !empty($_SESSION['Items'])) {
			foreach ($_POST as $key => $value) {
				if (preg_match("/amount/", $key)) {
					if (ctype_digit($key) && ctype_digit($value)) {
						$key = explode("_", $key);
						$item = $key[1];
						$_SESSION["Items"][$item] = $value;
					}
				}
			}
			$cart = new shoppingcart();
			$output = $cart -> showFinalOrder();
		}
		return $output;
	}

	public function checkout() {
		$this -> setOrder();
		$output = "Dank u voor uw bestelling!";
		return $output;
	}

	private function setOrder() {
		$accountid = $this -> id;
		$cart = $_SESSION["Items"];
		$items = '';
		$params = array();
		foreach ($cart as $item => $amount) {
			$items .= $item . "," . $amount . ";";
			$param = array($amount, $item);
			$params[] = $param;
		}
		$items = substr_replace($items, "", -1);
		$phpdate = time();
		$dateOrder = date('Y-m-d', $phpdate);

		//$_SESSION['Items'] = "";
		//unset($_SESSION["Items"]);

		$db = $GLOBALS['DB'];
		$query = $db -> prepare("INSERT INTO bestellingen (`accountid`,`producten`,`besteldag`) VALUES(?,?,?)");
		$param = array($accountid, $items, $dateOrder);
		$query -> execute($param);
		foreach ($params as $param) {
			$query = $db -> prepare("UPDATE Producten SET Voorraad= Voorraad - ? WHERE id = ? ");
			$query -> execute($param);
		}
	}

}
?>