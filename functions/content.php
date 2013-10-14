<?php

class Content {

	private $content, $action;

	function __construct() {
	}

	public function loadContent() {
		$output = '';
		$menu = new Menu();
		$output .= $menu -> getMenu();
		$output .= $this -> fillContent();
		return $output;
	}

	public function fillContent() {
		$output = '<div id="content">';

		if (isset($_GET['content'])) {
			if ($_GET['content'] == 'register') {
				$register = new Register();
				$output .= $register -> getForm();
			} else if ($_GET['content'] == 'nav') {
				$nav = new navigate();
				$output .= $nav -> getProducts();
			} else if ($_GET['content'] == 'nav') {
				$nav = new navigate();
				$output .= $nav -> getProducts();
			}else if ($_GET['content'] == 'customerPage') {
				if(isset($_GET["page"])){
					$acc = $_SESSION['account'];
					if($_GET["page"] == "viewOrders"){
						$output.=$acc->showOrders();
					}
					if($_GET["page"] == "adjustInfo"){
						//($_POST);
						if(isset($_POST['adjustAddressInfo'])){
							
						}
						else if(isset($_POST['adjustPassword'])){
							if(!empty($_POST["passOld"]) && !empty($_POST["passNew"]) && !empty($_POST["passNewCheck"]))
								$output.= $acc->changePassword($_POST["passOld"],$_POST["passNew"],$_POST["passNewCheck"]);
						}
						
						$output.= $acc->changeAddressForm();
						$output.= $acc->changePasswordForm();
						
					}else if($_GET["page"] == "viewOrders"){
						
					}
				}else{
					$output.= "Welkom hier kunt u account dingen doen";
				}
			}
		} else {
			$output .= '
					<table id="itemList">
							<tr>
								<td class="item_image"  rowspan="2"><img src="" /></td>
								<td class="item_name" colspan="2"><b>title</b></td>
							</tr>
							<tr>
								<td class="item_description" colspan="2"> description negerin enzo </td>
								<td>
								<table class="item_price_table">
									<tr>
										<td> Nu voor: </td>
									</tr>
									<tr>
										<td> € 300, </td>
										<td> 00 </td>
									</tr>
									<tr>
										<td>
										<button>
											bestellen
										</button></td>
									</tr>
								</table></td>
							</tr>
							<tr>
								<td class="item_image"  rowspan="2"><img src="" /></td>
								<td class="item_name" colspan="2"> title </td>
							</tr>
							<tr>
								<td class="item_description" colspan="2"> description negerin enzo </td>
								<td>
								<table class="item_price_table">
									<tr>
										<td> Nu voor: </td>
									</tr>
									<tr>
										<td> € 300, </td>
										<td> 00 </td>
									</tr>
									<tr>
										<td>
										<button>
											bestellen
										</button></td>
									</tr>
								</table></td>
							</tr>
							<tr>
								<td class="item_image"  rowspan="2"><img src="" /></td>
								<td class="item_name" colspan="2"><b>title</b></td>
							</tr>
							<tr>
								<td class="item_description" colspan="2"> description negerin enzo </td>
								<td>
								<table class="item_price_table">
									<tr>
										<td> Nu voor: </td>
									</tr>
									<tr>
										<td> € 300, </td>
										<td> 00 </td>
									</tr>
									<tr>
										<td>
										<button>
											bestellen
										</button></td>
									</tr>
								</table></td>
							</tr>
					</table>
			';
		}
		return $output . '</div>';
	}

}
?>