<?php
class Register {

	public function __construct() {
	}

	public function getForm() {
		$output = '';

		$output .= '
		<form id=registerForm method="post" action="index.php?content=register" autocomplete="off">
			<table>
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
					<td><input type="text" name="vnaam" placeholder="Voornaam" required /></td>
					<td><input type="text" name="tnaam" placeholder="tussenvoegsel" /></td>
					<td><input type="text" name="anaam" placeholder="Achternaam" required /></td>
				</tr>			
				<tr>
					<td></td>
				</tr>
			</table>
		</form>
		';

		return $output;
	}

}
?>