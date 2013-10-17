<?php

class CMS {

	function __construct() {
	}

	public function load() {
		$output = '';
		if (isset($_GET['content'])) {
			if ($_GET['content'] == 'cat') {
				if (isset($_GET['action'])) {
					if ($_GET['action'] == 'view') {
						if (isset($_GET['cat'])) {
							$output .= $this -> view($_GET['cat']);
						}
					} else if ($_GET['action'] == 'edit') {
						$output .= $this -> edit();
					} else if ($_GET['action'] == 'delete') {
						$output .= $this -> delete();
					}
				} else {
					$output .= '
						<div id="category">
						<h2>Categorie&euml;n</h2>';
					$output .= $this -> loadCategories();
				}
			}
		} else {
			$output .= '
			<nav>
				<ul>
					<li>
						Producten
					</li>
					<li>
						<a href="index.php?content=cat">Categorie&euml;n</a>
					</li>
					<li>
						Klanten
					</li>
				</ul>
			</nav>
		';
		}
		return $output;
	}

	private function loadCategories() {
		$output = '';
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('SELECT * FROM `categorieën`');
		$query -> execute();
		$output .= '<table id="categoryTable">';
		while ($result = $query -> fetch(PDO::FETCH_ASSOC)) {
			$output .= '<tr>';
			foreach ($result as $key => $value) {
				if ($key == 'Naam') {
					$output .= '<td>';
					$output .= '<a href="index.php?content=cat&action=view&cat=' . $result['id'] . '">' . $value . '</a>';
					$output .= '</td>';
				}
			}
			$output .= '</tr>';
		}
		$output .= '</table>';
		return $output;
	}

	private function view($id) {
		$output = '';
		$db = $GLOBALS['DB'];
		$queryCat = $db -> prepare('SELECT * FROM `categorieën` WHERE id = ?');
		$queryCat -> execute(array(clean($id)));
		$querySub = $db -> prepare('SELECT * FROM `subcategorieën` WHERE `parentid` = ?');
		$querySub -> execute(array(clean($id)));

		$result = $queryCat -> fetch(PDO::FETCH_ASSOC);
		$output .= '<div id="category">';
		$output .= '<h2>' . $result['Naam'] . '</h2>';

		$output .= '<table id="categoryTable">';
		while ($result = $querySub -> fetch(PDO::FETCH_ASSOC)) {
			$output .= '<tr>';
			foreach ($result as $key => $value) {
				if ($key == 'Naam') {
					$output .= '<td><a>' . $value . '</a></td>';
					$output .= '<td>';
					$output .= '<a href="index.php?content=cat&action=edit&subcat=' . $result['id'] . '"><img class="edit" src="images/edit.png"</a>';
					$output .= '<a href="index.php?content=cat&action=delete&subcat=' . $result['id'] . '" onclick="return checkDelete(' . '\'' . $value . '\'' . ')"><img class="delete" src="images/delete.png" /></a>';
					$output .= '</td>';
				}
			}
			$output .= '</tr>';
		}
		$output .= '</table>';
		$output .= '</div>';

		return $output;
	}

	private function edit() {
		$output = '';
		if (isset($_GET['cat'])) {
			$id = clean($_GET['cat']);
		} else if (isset($_GET['subcat'])) {
			$id = clean($_GET['subcat']);
		}
		return $output;
	}

	private function delete() {
		$output = '';
		if (isset($_GET['cat'])) {
			$id = clean($_GET['cat']);
		} else if (isset($_GET['subcat'])) {
			$id = clean($_GET['subcat']);
		}
		return $output;
	}

}
?>