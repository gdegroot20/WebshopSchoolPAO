<?php

class Address {

	private $voornaam, $tussenvoegsel, $achternaam;
	private $postcode, $straatnaam, $huisnummer, $plaats;

	public function __construct($voornaam, $tussenvoegsel, $achternaam, $postcode, $straatnaam, $huisnummer, $plaats) {
		$this -> voornaam = $voornaam;
		$this -> tussenvoegsel = $tussenvoegsel;
		$this -> achternaam = $achternaam;
		$this -> postcode = $postcode;
		$this -> straatnaam = $straatnaam;
		$this -> huisnummer = $huisnummer;
		$this -> plaats = $plaats;
	}

	public function getVoornaam() {
		return $this -> voornaam;
	}

	public function getTussenvoegsel() {
		return $this -> tussenvoegsel;
	}

	public function getAchternaam() {
		return $this -> achternaam;
	}

}
?>