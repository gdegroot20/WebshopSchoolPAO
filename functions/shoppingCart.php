<?php
/* 
 * items worden in variable gplaats als   Naam=>hoeveelheid 
 */
class shoppingcart {
	private $db;
	
	function __construct(){
			$this->db=dbConnect();	
	}
		
	public function showCart(){
		if(isset($_SESSION['Items']) && !empty($_SESSION['Items'])){
			$content="<div id='shoppingcart'>
			<form method='POST' action='".$_SERVER['PHP_SELF']."?content=confirmCheckout'><table >";
			$content.="<TR><TD class='cartHeaderLeft' id='shoppingcartImgTD'></TD><TD class='cartHeader' id='shoppingcartNameTD'>Naam</TD><TD class='cartHeader' id='shoppingcartAmountTD'>hoeveelheid</TD><TD class='cartHeader' id='shoppingcartPriceTD'>prijs</TD><TD class='cartHeader' id=''>totaal</TD><TD class='cartHeaderRight'></TD></TR>";
			$totaalprijs=0;
			foreach($_SESSION['Items'] as $item => $amount){
				$fetch=$this->getItem($item);
				$prijs=$amount * $fetch['Prijs'];
				$totaalprijs+=$prijs;
				$image = searchImage($fetch['id']);
				
				
				$content.="<TR id='item".$fetch['id']."'><TD class='cartLeft'><img src='$image' /></TD><TD class='cart'>".$fetch['Naam']."</TD><TD class='cart'><input type='text' name='amount_".$fetch['id']."' class='itemAmount' value='".$amount."' /> </TD><TD class='cart'>€ <span class='itemPrice'>".$fetch['Prijs'].",00</span></TD><TD class='cart'>€ <span class='itemTotalPrice'>".$prijs.",00</span></TD><td class='cartRight'><a href='#' class='cartRemove' title='verwijder item'>X</a></td></TR>";
			}

			$content.="<TR><TD></TD><TD></TD><TD></TD><TD></TD><TD class='cartTotal'>€ <span id='shoppingcartTotalPrice'>$totaalprijs,00</TD></TR></table>";
			$content.="<TR><TD></TD><TD></TD><TD><button name='checkOut'>afrekenen</button></TD></TR></table></form></div>";
			$content.="<script>setEventsShoppingCart();</script>";
			return $content;
		}else{
			return "Er zitten op het moment geen items in uw winkelmandje.";
		}
	}

	public function showFinalOrder(){
		
		if(isset($_SESSION['Items']) && !empty($_SESSION['Items'])){
			$content="<div id='shoppingcart'>
			<form method='POST' action='".$_SERVER['PHP_SELF']."?content=checkout'><table >";
			$content.="<TR><TD class='cartHeaderLeft' id='shoppingcartImgTD'></TD><TD class='cartHeader' id='shoppingcartNameTD'>Naam</TD><TD class='cartHeader' id='shoppingcartAmountTD'>hoeveelheid</TD><TD class='cartHeader' id='shoppingcartPriceTD'>prijs</TD><TD class='cartHeaderRight' id=''>totaal</TD></TR>";
			$totaalprijs=0;
			foreach($_SESSION['Items'] as $item => $amount){
				$fetch=$this->getItem($item);
				$prijs=$amount * $fetch['Prijs'];
				$totaalprijs+=$prijs;
				
				$image = searchImage($fetch['id']);
				
				$content.="<TR id='item".$fetch['id']."'><TD class='cartLeft'><img src='$image' /></TD><TD class='cart'>".$fetch['Naam']."</TD><TD class='cart'>$amount</TD><TD class='cart'>€ <span class='itemPrice'>".$fetch['Prijs'].",00</span></TD><TD class='cartRight'>€ <span class='itemTotalPrice'>".$prijs.",00</span></TD>";
			}

			$content.="<TR><TD colspan='4'></TD><TD class='cartTotal'>€ <span id='shoppingcartTotalPrice'>$totaalprijs,00</TD></TR></table>";
			$content.="<TR><TD colspan='2'></TD><TD><button name='checkOut'>bevestig</button></TD></TR></table></form></div>";
			return $content;
		}else{
			header('location:index.php');
			exit();
		}
			
	}
	
	private function getItem($item){

		$stmt = $this->db->prepare("SELECT * FROM producten WHERE id=?");
		$param=array($item);
		
		$stmt->execute($param);	
		$fetch=$stmt->fetch();
		
		return $fetch;
	}
		
	public function addItemToCart($item){
		if($this->checkValidItem($item)){
			if(isset($_SESSION['Items'])){
				if(!$this->checkItemInCart($item)){
					$_SESSION['Items'][$item]=1;
				}
			}else{
				$_SESSION['Items']=array();
				$_SESSION['Items'][$item]=1;
			}
		}
	}	
	
	public function totalPriceCart(){
		
			$totalprice=0;
			if(isset($_SESSION['Items'])){
				foreach($_SESSION['Items'] as $item => $amount){
					$fetch=$this->getItem($item);
					$prijs=$amount * $fetch['Prijs'];
					$totalprice+=$prijs;
				}
			}
			return $totalprice;
	}
	
	public function countItemsInCart(){
		if(isset($_SESSION['Items'])){
			$count = count($_SESSION['Items']);
			if($count == 1){
				return $count.' Artikel';
			}else if($count > 1){
				return $count.' Artikellen';
			}
		}
			return 'Geen artikellen';
		
	}
	
	private function checkItemInCart($item){
		if(in_array($item, $_SESSION['Items'])){
			//$_SESSION['Items'][$item]+=1;
			return true;
		}
		else{
			return false;
		}
	}
	
	
	private function checkValidItem($id){

		$stmt = $this->db->prepare("SELECT * FROM producten WHERE id=?");
		$param=array($id);
		
		$stmt->execute($param);	
		$fetch=$stmt->fetch();
		if($fetch['id'] == $id){
			return true;
		}
		else{
			return false;
		}
	}
	/*
	public function checkOut(){
		if(isset($_SESSION['account']) && !emtpy($_SESSION['account'])){
			header("location:index.php?content=checkout");
		}else{
			$output="U moet eerst inloggen om te kunnen afrekenen.";
		}
		return $output;
	}
	 *
	 */
	
}

?>