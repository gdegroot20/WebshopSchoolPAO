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
	public function getPostcode() {
		return $this -> postcode;
	}

	public function getStraatnaam() {
		return $this -> straatnaam;
	}

	public function getHuisnummer() {
		return $this -> huisnummer;
	}
	
	public function getPlaats() {
		return $this -> plaats;
	}
	
	public function setVoornaam($voornaam) {
		$this -> voornaam = $voornaam;
	}

	public function setTussenvoegsel($tussenvoegsel) {
		$this -> tussenvoegsel = $tussenvoegsel;
	}

	public function setAchternaam($achternaam) {
		$this -> achternaam = $achternaam;
	}
	public function setPostcode($postcode) {
		$this -> postcode = $postcode;
	}

	public function setStraatnaam($straatnaam) {
		$this -> straatnaam = $straatnaam;
	}

	public function setHuisnummer($huisnummer) {
		$this -> huisnummer = $huisnummer;
	}
	
	public function setPlaats($plaats) {
		$this -> plaats = $plaats;
	}

}
?>