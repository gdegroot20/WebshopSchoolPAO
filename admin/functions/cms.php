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
							$output .= $this -> viewCategory($_GET['cat'], TRUE);
						}
					} else if ($_GET['action'] == 'edit') {
						$output .= $this -> editCategory();
					} else if ($_GET['action'] == 'delete') {
						$output .= $this -> delete();
					}
				} else {
					$output .= '
						<div id="category">
						<h2>Categorie&euml;n</h2>';
					$output .= $this -> loadCategories();
				}
			} else if ($_GET['content'] == 'item') {
				if (isset($_GET['action'])) {
					if (isset($_GET['action'])) {
						switch ($_GET['action']) {
							case 'view' :
								if (isset($_GET['cat']))
									$output .= $this -> viewCategory($_GET['cat'], FALSE, 'list');
								break;
							case 'list' :
								if (isset($_GET['subcat']))
									$output .= $this -> listItems($_GET['subcat']);
								break;
							case 'edit' :
								if (isset($_GET['item']))
									$output .= $this -> editItem();
								break;
							case 'add' :
								if (isset($_GET['subcat']))
									$output .= $this -> addItem();
								break;
							case 'delete' :
								if (isset($_GET['item']))
									$output .= $this -> deleteItem();
								break;
						}
					}
				} else {
					$output .= $this -> loadItems();
				}
			} else if ($_GET['content'] == 'order') {
				if (isset($_GET['action'])) {
					switch ($_GET['action']) {
						default :
							$output .= $this -> listOrders();
							break;
					}
				}
			}
		} else {
			$output .= '
			<nav>
				<ul>
					<li>
						<a href="index.php?content=item">Producten</a>
					</li>
					<li>
						<a href="index.php?content=cat">Categorieën</a>
					</li>
					<li>
						<a href="index.php?content=order">Bestellingen</a>
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

	private function loadItems() {
		$output = '';
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('SELECT * FROM `categorieën` ORDER BY `Naam` ASC');
		$query -> execute();
		$output .= '<table id="categoryTable">';
		$output .= '<h2>Items - Categorieën</h2>';
		while ($result = $query -> fetch(PDO::FETCH_ASSOC)) {
			$output .= '<tr>';
			foreach ($result as $key => $value) {
				if ($key == 'Naam') {
					$output .= '<td>';
					$output .= '<a href="index.php?content=item&action=view&cat=' . $result['id'] . '">' . $value . '</a>';
					$output .= '</td>';
				}
			}
			$output .= '</tr>';
		}
		$output .= '</table>';
		return $output;
	}

	private function viewCategory($id, $edit, $action = false) {
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
						</td>';
		if ($edit) {
			$output .= '
							<td>
								<a href="index.php?content=cat&action=edit&cat=' . $result['id'] . '"><img class="edit" src="images/edit.png" /></a>							
								<a href="index.php?content=cat&action=delete&cat=' . $result['id'] . '" onclick="return checkDelete(' . '\'' . $result['Naam'] . '\'' . ')"><img class="delete" src="images/delete.png" /></a>
							</td>';
		}
		$output .= '</tr>';
		if ($edit) {
			$output .= '<form method="post">
							<tr>
								<td><input type="text" placeholder="Categorie toevoegen" name="name"></td>
								<td><input id="addButton" type="submit" name="add" value=""></td>
							</tr>
						</form>';
		}
		while ($result = $querySub -> fetch(PDO::FETCH_ASSOC)) {
			$output .= '<tr>';
			foreach ($result as $key => $value) {
				if ($key == 'Naam') {
					$output .= '<td><a ' . ($action === false ? '' : 'href="index.php?content=item&action=list&subcat=' . $result['id'] . '"') . '>' . $value . '</a></td>';
					if ($edit) {
						$output .= '<td>';
						$output .= '<a href="index.php?content=cat&action=edit&subcat=' . $result['id'] . '"><img class="edit" src="images/edit.png"></a>';
						$output .= '<a href="index.php?content=cat&action=delete&subcat=' . $result['id'] . '" onclick="return checkDelete(' . '\'' . $value . '\'' . ')"><img class="delete" src="images/delete.png" /></a>';
						$output .= '</td>';
					}
				}
			}
			$output .= '</tr>';
		}
		$output .= '</table>';
		$output .= '</div>';

		return $output;
	}

	private function listItems($id) {
		$output = '';
		$output .= '<center><a href="index.php?content=item&action=add&subcat=' . $_GET['subcat'] . '" ><h2>Product Toevoegen</h2></a></center><hr>';
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('SELECT * FROM `producten` WHERE `parentid` = ?');
		$query -> execute(array($id));
		$itemHeader = '<center><h2>Producten:</h2></center>';
		$i = 0;
		$itemList = '';
		while ($row = $query -> fetch(PDO::FETCH_ASSOC)) {
			$itemList .= '<div class="product"><table id="itemTable">';
			$itemList .= '<tr>
							<td>&nbsp;</td>
							<td><a class="title">' . $row['Naam'] . '</a><hr noshade></td></tr>';
			$itemList .= '<tr>
							<td><a href="index.php?content=item&action=edit&item=' . $row['id'] . '"><img class="edit2" src="images/edit.png"></a></td>
							<td><a><strong>Omschrijving:</strong> ' . $row['Omschrijving'] . '</a></td>
						</tr>';
			$itemList .= '<tr>
							<td><a href="index.php?content=item&action=delete&item=' . $row['id'] . '&parent=' . $id . '" onclick="return checkDelete(\'' . $row['Naam'] . '\')"><img class="delete2" src="images/delete.png"></a></td>
							<td><a><strong>Prijs:</strong> €' . $row['Prijs'] . '</a></td></tr>';
			$itemList .= '<tr>
							<td>&nbsp;</td>
							<td><a><strong>Voorraad:</strong> ' . $row['Voorraad'] . '</a></td>
						</tr>';
			$itemList .= '</table></div>';
			$i++;
		}
		if ($i == 0) {
			$itemHeader = '<center><h2>Geen producten gevonden</h2></center>';
		}

		$output .= $itemHeader;
		$output .= $itemList;

		return $output;
	}

	private function listOrders() {
		$output = '';
		$db = $GLOBALS['DB'];

		if (isset($_POST['orderUpdate'])) {
			$query = $db -> prepare('UPDATE `bestellingen` SET `Status` = ? WHERE `id` = ?');
			$query -> execute(array($_POST['orderStatus'], $_POST['orderID']));
		}

		$query = $db -> prepare('SELECT * FROM `bestellingen`');
		$query -> execute();
		while ($row = $query -> fetch(PDO::FETCH_ASSOC)) {
			$output .= '<div class="order"><table>';
			$continue = false;
			foreach ($row as $key => $value) {
				switch ($key) {
					case 'id' :
						$key = 'Bestelling ID';
						break;
					case 'accountid' :
						$key = 'Account ID';
						break;
					case 'Status' :
						$continue = true;
						break;
					case 'Bedrag' :
						$value = money_format('%i', $value);
						break;
				}
				if ($continue)
					continue;

				$output .= '<tr><td><strong>' . $key . ':</strong></td><td>' . $value . '</td></tr>';
			}
			$status = $row['Status'];
			$statusArray = array('Verzonden', 'In behandeling');
			$output .= '<tr><td><strong>Status: </strong></td>
							<td>
								<form method="post">
								<input type="hidden" name="orderID" value="' . $row['id'] . '" />
								<select name="orderStatus">';

			for ($i = 0; $i < count($statusArray); $i++)
				$output .= '<option ' . ($statusArray[$i] == $status ? 'selected' : '') . '>' . $statusArray[$i] . '</option>';

			$output .= '</select>
						<input type="submit" name="orderUpdate" value="Bijwerken" />
						</form>
					</td>
				</tr>
			</table></div>';
		}
		return $output;
	}

	private function editItem() {
		$output = '';
		if (isset($_POST['itemEdit'])) {
			$id = $_POST['itemID'];
			$name = clean($_POST['itemName']);
			$description = clean($_POST['itemDescription']);
			$price = clean($_POST['itemPrice']);
			$amount = clean($_POST['itemAmount']);
			if (!is_numeric($id)) {
				$output .= 'Er ging iets fout in uw bewerking.';
				return $output;
			}
			$db = $GLOBALS['DB'];
			$query = $db -> prepare('UPDATE `producten` 
									SET `Naam` = ?, `Omschrijving` = ?, `Prijs` = ?, `Voorraad` = ? 
									WHERE `id` = ?');
			$params = array($name, $description, $price, $amount, $id);
			$query -> execute($params);
			header('Location: index.php?content=item&action=list&subcat=' . $_POST['itemParent']);
			exit();
		} else {
			$db = $GLOBALS['DB'];
			$query = $db -> prepare('SELECT * FROM `producten` WHERE `id` = ?');
			$query -> execute(array($_GET['item']));
			$row = $query -> fetch(PDO::FETCH_ASSOC);
			$name = $row['Naam'];
			$description = $row['Omschrijving'];
			$price = $row['Prijs'];
			$amount = $row['Voorraad'];
			$output .= '<form method="post"><table>
							<input type="hidden" name="itemID" value="' . $_GET['item'] . '" >
							<input type="hidden" name="itemParent" value="' . $row['parentid'] . '" >
							<tr>
								<td>Naam:</td>
								<td><input type="text" name="itemName" value="' . $name . '" ></td>
							</tr>
							<tr>
								<td>Omschrijving:</td>
								<td><input type="text" name="itemDescription" value="' . $description . '" ></td>
							</tr>
							<tr>
								<td>Prijs:</td>
								<td><input type="text" name="itemPrice" value="' . $price . '" ></td>
							</tr>
							<tr>
								<td>Voorraad:</td>
								<td><input type="text" name="itemAmount" value="' . $amount . '" ></td>
							</tr>
							<tr>
								<td>
								<input type="submit" name="itemEdit" value="Wijzigen" >
								</td>
							</tr>';
			$output .= '</table></form>';
		}
		return $output;
	}

	private function editCategory() {
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
				$output .= $this -> editCategoryForm($row, $type);
			}
			$output .= '</table></form>';

		}
		return $output;
	}

	private function editCategoryForm($row, $type) {
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

	private function addItem() {
		$output = '';
		if (isset($_POST['itemAdd'])) {
			$db = $GLOBALS['DB'];
			$query = $db -> prepare('INSERT INTO `producten` (`Naam`, `Omschrijving`, `Prijs`, `Voorraad`, `parentid`)
									 VALUES (?, ?, ?, ?, ?)');
			$params = array($_POST['itemName'], $_POST['itemDescription'], $_POST['itemPrice'], $_POST['itemAmount'], $_GET['subcat']);
			$query -> execute($params);
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["image"]["name"]);
			$extension = end($temp);
			$query = $db -> prepare('SELECT * FROM `producten` ORDER BY `id` DESC');
			$query -> execute(array());
			$fetch = $query -> fetch(PDO::FETCH_ASSOC);
			$imageName = 'item' . $fetch['id'];
			if ((($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/jpg") || ($_FILES["image"]["type"] == "image/pjpeg") || ($_FILES["image"]["type"] == "image/x-png") || ($_FILES["image"]["type"] == "image/png")) && ($_FILES["image"]["size"] < 2000000) && in_array($extension, $allowedExts)) {
				if ($_FILES["image"]["error"] > 0) {
					echo "Error: " . $_FILES["image"]["error"] . "<br>";
				} else {
					echo "Upload: " . $_FILES["image"]["name"] . "<br>";
					echo "Type: " . $_FILES["image"]["type"] . "<br>";
					echo "Size: " . ($_FILES["image"]["size"] / 1024) . " kB <br>";
					if (file_exists("../images/Items/" . $imageName)) {
						echo $_FILES["image"]["name"] . " already exists. ";
					} else {
						if (file_exists('../images/preview/')) {
							if (!is_dir('../images/preview/'))
								mkdir('../images/preview/', 0777);
						} else {
							mkdir('../images/preview/', 0777);
						}
						$image = new Image();
						$image -> load($_FILES['image']['tmp_name']);
						$image -> resize(100, 100);
						$image -> save('../images/preview/' . $imageName . '.jpg');
						move_uploaded_file($_FILES["image"]["tmp_name"], "../images/Items/" . $imageName . '.jpg');
						echo "Stored in: " . "images/" . strtolower($imageName) . '.' . $extension;
					}
				}
			} else {
				echo "Invalid file";
			}
			//header('Location: index.php?content=item&action=list&subcat=' . $_GET['subcat']);
			exit();
		} else {
			$output .= '<form method="post" id="addForm" enctype="multipart/form-data"><table>
							<tr>
								<td>Naam: </td>
								<td><input type="text" name="itemName"></td>
							</tr>
							<tr>
								<td>Omschrijving: </td>
								<td><textarea name="itemDescription"></textarea></td>
							</tr>
							<tr>
								<td>Afbeelding: </td>
								<td><input type="file" name="image" id="file"></td>
							</tr>						
							<tr>
								<td>Prijs:</td>
								<td><input type="text" data-symbol="€" name="itemPrice"></td>
							</tr>
							<tr>
								<td>Voorraad:</td>
								<td><input type="text" name="itemAmount"></td>
							</tr>
							<tr>
								<td><input type="submit" name="itemAdd" value="Toevoegen" ></td>
							</tr>';
			$output .= '</table></form>';
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

	private function deleteItem() {
		$db = $GLOBALS['DB'];
		$query = $db -> prepare('DELETE FROM `producten` WHERE `id` = ?');
		$query -> execute(array($_GET['item']));
		header('Location: index.php?content=item&action=list&subcat=' . $_GET['parent']);
		exit();
	}

}
?>