<?php

function contactForm(){
	$content='	<div id="contact">
					<h1>
					Contact
					</h1>
					<p>
						Heeft u een vraag? Stel het ons gerust!
						<BR>
						<BR>
						Contact gegevens:
						<table>
							<TR>
								<TD>
									adres:
								</TD>
								<TD>
									wegmetnummer 83
	
								</TD>
							</TR>
							<TR>
								<TD>
									Plaats:
								</TD>
								<TD>
									Zwolle
								</TD>
							</TR>
							<TR>
								<TD>
									Postcode:
								</TD>
								<TD>
									8080LL
								</TD>
							</TR>
							<TR>
								<TD>
									telnummer:
								</TD>
								<TD>
									8080808080
								</TD>
							</TR>
							
						</table>
					</p>
					<form  method="POST" action="procces/contactForm.php">
						<table>
							<TR>
								<TD>
									Naam:
								</TD>
								<TD>
									<input type="text" name="name" placeholder="naam"/>
								</TD>
							</TR>
							<TR>
								<TD>
									Email:
								</TD>
								<TD>
									<input type="text" name="email" placeholder="email"/>
								</TD>
							</TR>
							<TR>
								<TD>
									Onderwerp:
								</TD>
								<TD>
									<input type="text" name="subject" placeholder="Onderwerp"/>
								</TD>
							</TR>
							<TR>
								<TD>
									Bericht:
								</TD>
								<TD>
									<textarea name="message" placeholder="typ uw bericht"></textarea>
								</TD>
							</TR>
							<TR>
								<TD>
									
								</TD>
								<TD>
									<button>Verzenden</button>
								</TD>
							</TR>
						</table>
					</form>
				</div>';
	return $content;
}


?>