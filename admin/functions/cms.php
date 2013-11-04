<?php

class CMS {

	function __construct() {
		$account = $_SESSION['account'];
		if (!$account -> hasRight('cms')) {
			header('Location: ../');
		}
	}

	public function load() {
		$output = '';
		if (isset($_GET['content'])) {
			if ($_GET['content'] == 'cat') {
				if (isset($_POST['add'])) {
					$output .= $this -> add();
				}
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
		$query = $db -> prepare('SELECT * FROM `categorieën` ORDER BY `Naam` ASC');
		$query -> execute();
		$output .= '<table id="categoryTable">';
		$output .= '<form method="post">
						<tr>
						<td><input type="text" placeholder="Categorie toevoegen" name="name"></td>
						<td><input id="addButton" type="submit" name="add" value=""></td>
						</tr>
					</form>';
		while ($result = $query -> fetch(PDO::FETCH_ASSOC)) {
			$output .= '<tr>';
			foreach ($result as $key => $value) {
				if ($key == 'Naam') {
					$output .= '<td>';
					$output .= '<a href="index.php?content=cat&action=view&cat=' . $result['id'] . '">' . $value . '</a>';
					$output .= '</td>';
					$output .= '<td>';
					$output .= '<a href="index.php?content=cat&action=edit&cat=' . $result['id'] . '"><img class="edit" src="images/edit.png" /></a>							
								<a href="index.php?content=cat&action=delete&cat=' . $result['id'] . '" onclick="return checkDelete(' . '\'' . $result['Naam'] . '\'' . ')"><img class="delete" src="images/delete.png" /></a>';
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
		$querySub = $db -> prepare('SELECT * FROM `subcategorieën` WHERE `parentid` = ? ORDER BY `Naam`	ASC ');
		$querySub -> execute(array(clean($id)));

		$result = $queryCat -> fetch(PDO::FETCH_ASSOC);
		$output .= '<div id="category">';
		$output .= '<table id="categoryTable">';

		$output .= '<tr>
						<td>
							<h2>' . $result['Naam'] . '</h2>
						</td>
						<td>
							<a href="index.php?content=cat&action=edit&cat=' . $result['id'] . '"><img class="edit" src="images/edit.png" /></a>							
							<a href="index.php?content=cat&action=delete&cat=' . $result['id'] . '" onclick="return checkDelete(' . '\'' . $result['Naam'] . '\'' . ')"><img class="delete" src="images/delete.png" /></a>
						</td>
					</tr>';
		$output .= '<form method="post">
						<tr>
							<td><input type="text" placeholder="Categorie toevoegen" name="name"></td>
							<td><input id="addButton" type="submit" name="add" value=""></td>
						</tr>
					</form>';
		while ($result = $querySub -> fetch(PDO::FETCH_ASSOC)) {
			$output .= '<tr>';
			foreach ($result as $key => $value) {
				if ($key == 'Naam') {
					$output .= '<td><a>' . $value . '</a></td>';
					$output .= '<td>';
					$output .= '<a href="index.php?content=cat&action=edit&subcat=' . $result['id'] . '"><img class="edit" src="images/edit.png"></a>';
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
		if (isset($_POST['update'])) {
			$table = (isset($_GET['cat']) ? 'categorieën' : 'subcategorieën');
			$type = (isset($_GET['cat']) ? 'cat' : 'subcat');
			$id = (isset($_GET['cat']) ? $_GET['cat'] : $_GET['subcat']);
			$name = $_POST['name'];
			$db = $GLOBALS['DB'];
			$query = $db -> prepare('UPDATE `' . $table . '` SET `Naam` = ? WHERE `id` = ?');
			$query -> execute(array(clean($name), clean($id)));
			if (isset($_GET['subcat'])) {
				$query = $db -> prepare('SELECT `parentid` FROM `subcategorieën` WHERE `id` = ?');
				$query -> execute(array(clean($id)));
				$row = $query -> fetch(PDO::FETCH_ASSOC);
				$id = $row['parentid'];
			}
			header('Location: index.php?content=cat&action=view&cat=' . $id);
			exit();
		} else {
			$output .= '<form method="post"><table>';
			$table = (isset($_GET['cat']) ? 'categorieën' : 'subcategorieën');
			$type = (isset($_GET['cat']) ? 'cat' : 'subcat');
			$id = (isset($_GET['cat']) ? $_GET['cat'] : $_GET['subcat']);
			$db = $GLOBALS['DB'];

			$query = $db -> prepare('SELECT * FROM ' . $table . ' WHERE `id` = ?');
			$query -> execute(array(clean($id)));

			while ($row = $query -> fetch(PDO::FETCH_ASSOC)) {
				$output .= $this -> editForm($row, $type);
			}
			$output .= '</table></form>';

		}
		return $output;
	}

	private function editForm($row, $type) {
		$output = '';
		$output .= '<input type="text" name="name" value="' . $row['Naam'] . '">';
		$output .= '<input type="hidden" name="' . $type . '">';
		$output .= '<input type="submit" name="update" value="Wijzigen">';
		return $output;
	}

	private function add() {
		$output = '';
		$output .= 'Add';
		$name = $_POST['name'];
		$db = $GLOBALS['DB'];
		if (isset($_GET['cat'])) {
			$query = $db -> prepare('INSERT INTO `subcategorieën` (`Naam`, `parentid`) VALUES (?, ?)');
			$query -> execute(array(clean($name), clean($_GET['cat'])));
		} else {
			$query = $db -> prepare('INSERT INTO `categorieën` (`Naam`) VALUES (?)');
			$query -> execute(array(clean($name)));
		}
		return $output;
	}

	private function delete() {
		$output = '';
		if (isset($_GET['cat'])) {
			$id = clean($_GET['cat']);
			$db = $GLOBALS['DB'];
			$query = $db -> prepare('DELETE FROM `categorieën` WHERE `id` = ?');
			$query -> execute(array($id));
			$query = $db -> prepare('DELETE FROM `subcategorieën` WHERE `parentid` = ?');
			$query -> execute(array($id));
		} else if (isset($_GET['subcat'])) {
			$id = clean($_GET['subcat']);
			$db = $GLOBALS['DB'];
			$query = $db -> prepare('DELETE FROM `subcategorieën` WHERE `id` = ?');
			$query -> execute(array($id));
		}
		return $output;
	}

}
?>