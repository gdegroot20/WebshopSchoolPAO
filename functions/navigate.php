<?php
class navigate{
	private $db;
	
	public function __construct(){
		$this->db=dbConnect();
	}
	
	public function getCat(){
		$content='';
		$stmt = $this->db->prepare("SELECT * FROM categorieën");
		//$param=array($name,$email,$subject,$message);
		$stmt->execute();
		while($fetch=$stmt->fetch()){
			if(isset($_GET['cat']) && $_GET['cat'] == $fetch['id']){
				$content.="<li><a href='".$_SERVER['PHP_SELF']."?content=nav&cat=".$fetch['id']."'>".$fetch['Naam']."</a></li>";
				$content.=$this->getSubCat();
				
			}else{
				$content.="<li><a href='".$_SERVER['PHP_SELF']."?content=nav&cat=".$fetch['id']."'>".$fetch['Naam']."</a></li>";
			}
		}
		
		return $content;
	}
	
	
	private function getSubCat(){
		$content='';
		$stmt = $this->db->prepare("SELECT * FROM subcategorieën WHERE parentid = ?");
		$param=array($_GET['cat']);
		$stmt->execute($param);
		while($fetch=$stmt->fetch()){
				$content.="<li class='subItem'><a href='".$_SERVER['PHP_SELF']."?content=nav&cat=".$_GET['cat']."&subCat=".$fetch['id']."'>".$fetch['Naam']."</a></li>";
		}
		
		return $content;
	}
	
	public function getProducts(){
		$content='<table id="item_list"> <form method="POST" action="#">';
		$stmt = $this->db->prepare("SELECT * FROM producten WHERE parentid=?");
		$param=array($_GET['subCat']);
		
		$stmt->execute($param);	
		
		while($fetch=$stmt->fetch()){
			
			if($fetch['Voorraad'] > 1){
				$indicator='images/icons/bullet_green.png';
				$title='Op voorraad';
			}else{
				$indicator='images/icons/bullet_red.png';
				$title='Niet op voorraad';
			}
			
			$content.=	'<TR>
							<td class="item_image"  rowspan="2"><img src="images/Items/noImageAvailable.jpg" /></td>
							<td class="item_name" colspan="2"><h2>'.$fetch['Naam'].'</h2></td>
						</TR>
						<TR>
							<td class="item_description" colspan="2">'.$fetch['Omschrijving'].'</td>
							<td><table class="item_price_table">
									<tr>
										<td>Nu voor:</td>
									</tr>
									<tr>
										<td>€ '.$fetch['Prijs'].',00</td>
										<td><img src="'.$indicator.'" title="'.$title.'"/></td>
									</tr>
									<tr>
										<td><button name="inShoppingCart" value="'.$fetch['id'].'">Toevoegen</button></td>
									</tr>
								</table>
							</td>
						</TR>';
		}
		$content.='</table></form>';

		return $content;
		
	}
	
	
	public function customerMenu(){
		$output= "	
						<li><a href='".$_SERVER["PHP_SELF"]."?content=customerPage&page=adjustInfo'>Gegevens wijzigen</a></li>
						<li><a href='".$_SERVER["PHP_SELF"]."?content=customerPage&page=viewOrders'>Overzicht bestellingen</a></li>
						<li><a href='".$_SERVER["PHP_SELF"]."'>Terug naar winkel.</a></li>
				";
		return $output;
	}
	

}
?>