<?php

class Content {

	private $content, $action;

	function __construct() {
	}

	public function loadContent() {
		$output = '';
		$menu = new Menu();
		$output .= "<div id='contentWrapper'>";
		$output .= $menu -> load();
		$output .= $this -> load();
		$output .= "<div class='clear'></div></div>";
		return $output;
	}

	public function load() {
		$output = '<div id="content">';
		
		if (isset($_GET['content'])) {
			$shoppingCart = new shoppingcart();
			if ($_GET['content'] == 'register') {
				$register = new Register();
				if(isset($_POST['register'])){
					$output.= $register -> checkRegister($_POST);
				}else{
					$output .= $register -> load();
				}
			} else if ($_GET['content'] == 'nav') {
				$nav = new navigate();
				if(isset($_GET['subCat'])){
					$output .= $nav -> getProducts();
					if(isset($_POST['inShoppingCart'])){
						$shoppingCart->addItemToCart($_POST['inShoppingCart']);
					}
				}
			}else if($_GET['content'] == 'confirmCheckout'){
				if(isset($_SESSION['account'])){
					$account= $_SESSION['account'];
					$output.=$account->confirmCheckout();	
				}else{
					$output.="U moet eerst inloggen";
				}
			}else if($_GET['content'] == 'checkout'){
				if(isset($_SESSION['account'])){
					$account= $_SESSION['account'];
					$output.=$account->checkout();	
				}else{
					$output.="U moet eerst inloggen";
				}
			}else if($_GET['content'] == 'shoppingcart'){
				$output.=$shoppingCart->showCart();
			}else if ($_GET['content'] == 'contact') {
				$output.= contactForm();
			} else if ($_GET['content'] == 'manage') {
				header('Location: admin');
				exit();
			} else if ($_GET['content'] == 'customerPage') {
				if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
					
					if (isset($_GET["page"])) {
						$acc = $_SESSION['account'];
						if ($_GET["page"] == "adjustInfo") {
							//($_POST);
							if (isset($_POST['adjustAddressInfo'])) {
									$output .= $acc -> changeAddress($_POST["firstName"],$_POST["middleName"],$_POST["surName"],$_POST["streetName"],$_POST["homeNumber"],$_POST["zipCode"],$_POST["city"]);
							} else if (isset($_POST['adjustPassword'])) {
								if (!empty($_POST["passOld"]) && !empty($_POST["passNew"]) && !empty($_POST["passNewCheck"]))
									$output .= $acc -> changePassword($_POST["passOld"], $_POST["passNew"], $_POST["passNewCheck"]);
							}
	
							$output .= $acc -> changeAddressForm();
							$output .= $acc -> changePasswordForm();
	
						} else if ($_GET["page"] == "viewOrders") {
							$output .= $acc -> showOrders();
						}
					} else {
						$output .= "Welkom hier kunt u account dingen doen";
					}
				}else{
					header("location:index.php");
					exit;
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