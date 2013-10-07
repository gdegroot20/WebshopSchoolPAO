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
			$content="<table>";
			$totaalprijs=0;
			foreach($_SESSION['Items'] as $item => $amount){
				$fetch=$this->getItem($item);
				$prijs=$amount * $fetch['Prijs'];
				$totaalprijs+=$prijs;
				$content.="<TR><TD>".$fetch['Naam']."</TD><TD>".$amount."</TD><TD>€ ".$prijs.",00</TD></TR>";
			}

			$content.="<TR><TD></TD><TD></TD><TD>€ $totaalprijs,00 </TD></TR></table>";
			$content.="<TR><TD></TD><TD></TD><TD><form method='POST' action='".$_SERVER['PHP_SELF']."'><button name='checkOut'>afrekenen</button></TD></form></TR></table>";
			
			return $content;
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
		
	private function checkItemInCart($item){
		if(in_array($item, $_SESSION['Items'])){
			$_SESSION['Items'][$item]+=1;
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
	
	public function checkOut(){
		
	}
	
}

?>