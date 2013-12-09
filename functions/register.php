<?php
class Register {
	private $db;
	private $aErrors = array();

	public function __construct() {
		$this->db = $GLOBALS['DB'];
	}

	public function load() {
		if(isset($_POST['register'])){
			foreach($_POST as $key => $value){
				${$key} = $value;
			}
		}
		
		$output = '';

		$output .= '
		<form id=registerForm method="post" action="index.php?content=register" autocomplete="off">
			<table>
				<tr>
					<td><h4>Accountgegevens</h4></td>
				</tr>
				<tr>
					<td><input type="email" name="regEmail" value="'.isset($regEmail).'" placeholder="Email" required /></td>
				</tr>
				<tr>
					<td><input type="password" name="regPassword" placeholder="Wachtwoord" required /></td>
				</tr>
				<tr>
					<td><input type="password" name="regPasswordCheck" placeholder="Wachtwoord Opnieuw" required /></td>
				</tr>
				<tr class="separator" />
				<tr>
					<td><h4>Adresgegevens</h4></td>
				</tr>
				<tr>
					<td><input type="text" value="'.isset($vnaam).'" name="vnaam" placeholder="Voornaam" required /></td>
					<td><input type="text" value="'.isset($tnaam).'" name="tnaam" placeholder="tussenvoegsel" /></td>
					<td><input type="text" value="'.isset($anaam).'" name="anaam" placeholder="Achternaam" required /></td>
				</tr>			
				<tr>
					<td><input type="text" value="'.isset($streetname).'" name="streetname" placeholder="Straatnaam" required /></td>
					<td><input type="text" value="'.isset($streetnr).'" name="streetnr" placeholder="Straatnummer" required /></td>
				</tr>
				<tr>
					<td><input type="text" value="'.isset($postal).'" name="postal" placeholder="Postcode" required /></td>
					<td><input type="text" value="'.isset($place).'" name="place" placeholder="Plaats" required  /></td>
				</tr>
				<tr>
					<td><input type="submit" name="register"></td>
				</tr>
			</table>
		</form>
		';

		return $output;
	}

	public function checkRegister($POST){
		foreach($_POST as $key => $value){
			if(empty($value) && $key != 'tnaam'){
				$this->aErrors[]='velden mogen niet leeg zijn';
				break;
			}
		}	
		$this->checkEmail($POST['regEmail']);
		$this->checkPasswords($POST['regPassword'],$POST['regPasswordCheck']);
				
		if(count($this->aErrors) == 0)	
				$this->register($POST);
		else{
			$output=$this->displayErrors();
			$output.=$this->load();
			return $output;
		}
			
		
	}

	private function displayErrors(){
		foreach($this->aErrors as $value){
			echo $value."<br />";
		}
	}
	
	private function register($POST){
		$query = $this-> db -> prepare('INSERT INTO accounts (Password,Email,profile,Activated) VALUES (:Password,:Email,0,1)');
		$param = array(":Password" => md5($POST['regPassword']),
						":Email" => $POST['regEmail']);
		$query -> execute($param);
		$id = $this->db->lastInsertId();
		$query = $this->db -> prepare('INSERT INTO adressen (accountid,Voornaam,Tussenvoegsel,Achternaam,Postcode,Straatnaam,Huisnummer,Plaats)
								 VALUES (:accountid,:Voornaam,:Tussenvoegsel,:Achternaam,:Postcode,:Straatnaam,:Huisnummer,:Plaats)');
		$param = array(":accountid" => $id,":Voornaam" => $POST['vnaam'],":Tussenvoegsel" => $POST['tnaam'] ,
						":Achternaam" => $POST['anaam'] ,":Postcode" => $POST['postal'],":Straatnaam" => $POST['streetname'] ,":Huisnummer" => $POST['streetnr'],":Plaats" => $POST['place']);
		$query -> execute($param);
		
	}
	
	private function checkEmail($email){
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$this->aErrors[] = 'onjuist email';
		}
	}
	
	private function checkPasswords($password1,$password2){
		if($password1 != $password2){
			$this->aErrors[] = 'paswoorden komen niet overeen';
		}
		
	}

}
?>