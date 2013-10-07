<?php
class Menu {

	public function getMenu() {
		$output = '';
		$output .= '
		<nav id="leftside">
			<ul id="leftMenu">';
				$nav= new navigate();
				$output .= $nav-> getCat();
		$output .= '
			</ul>
		</nav>
		';
		return $output;
	}

}
?>