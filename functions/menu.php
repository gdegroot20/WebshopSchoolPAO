<?php
class Menu {

	public function getMenu() {
		$output = '';
		$output .= '
		<nav id="leftside">
			<ul id="leftMenu">';
			if(isset($_GET['content']) && $_GET["content"] == "customerPage"){
				$nav= new navigate();
				$output .= $nav-> customerMenu();
			}else{
				$nav= new navigate();
				$output .= $nav-> getCat();
			}
		$output .= '
			</ul>
		</nav>
		';
		return $output;
	}

}
?>