<?php
class Register {

	public function __construct() {
	}

	public function load() {
		$output = '';

		$output .= '
		<form id=registerForm method="post" action="index.php?content=register" autocomplete="off">
			<table>
				<tr>
					<td><h4>Accountgegevens</h4></td>
				</tr>
				<tr>
					<td><input type="email" name="regEmail" placeholder="Email" required /></td>
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
					<td><input type="text" name="vnaam" placeholder="Voornaam" required /></td>
					<td><input type="text" name="tnaam" placeholder="tussenvoegsel" /></td>
					<td><input type="text" name="anaam" placeholder="Achternaam" required /></td>
				</tr>			
				<tr>
					<td><input type="text" name="streetname" placeholder="Straatnaam" required /></td>
					<td><input type="text" name="streetnr" placeholder="Straatnummer" required /></td>
				</tr>
				<tr>
					<td><input type="text" name="postal" placeholder="Postcode" required /></td>
					<td><input type="text" name="place" placeholder="Plaats" required /></td>
				</tr>
				<tr>
					<td><input type="submit" name="register"></td>
				</tr>
			</table>
		</form>
		';

		return $output;
	}

}
?>