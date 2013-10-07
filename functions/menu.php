<?php
class Menu {

	public function getMenu() {
		$output = '';
		$output .= '
		<nav id="leftside">
				<ul id="leftMenu">
					<li>
						<a href="#">Categorie</a>
						<ul>
							<li>
								<a href="#">subCategorie</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Categorie</a>
						<ul>
							<li>
								<a href="#">subCategorie</a>
							</li>
							<li>
								<a href="#">subCategorie</a>
							</li>
							<li>
								<a href="#">subCategorie</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Categorie</a>
					</li>
					<li>
						<a href="#">Categorie</a>
					</li>
					<li>
						<a href="#">Categorie</a>
					</li>
				</ul>
			</nav>
		';
		return $output;
	}

}
?>