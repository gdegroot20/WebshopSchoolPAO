<?php

if(isset($_POST['product']) && !empty($_POST['product'])) {

require '../functions/main/init.php';
require '../functions/main/dbcon.php';
init("../ini_files");
$db = dbConnect();


$stmt = $db->prepare("SELECT Naam FROM producten WHERE Naam LIKE :product ");
$param=array(":product" => $_POST['product'].'%' );

$stmt->execute($param);	
$fetch=$stmt->fetchAll();


$output='';

foreach($fetch as $key => $product){
	$output.= "<a href='#' >".$product['Naam']."</a><br />";
}

echo $output;

}
?>