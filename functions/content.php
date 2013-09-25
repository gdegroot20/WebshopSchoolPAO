<?php

class Content {

	private $content, $action;

	function __construct($content, $action) {
		$content = clean($content);
		$this -> content = $content;
		$this -> action = $action;
	}

	public function loadContent() {
		$output = '';
		$login = new Login();
		$output .= $login -> getLogin();
		return $output;
	}

}
?>