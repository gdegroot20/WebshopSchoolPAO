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
		echo $this -> getDelta();
		return $this -> getDelta() > 450;
	}

	public function getDelta() {
		return (time() - $this -> lastActivity);
	}

}
?>