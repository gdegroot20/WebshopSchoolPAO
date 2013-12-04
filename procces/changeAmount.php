<?php

$item = explode('item',$_POST['item']);
$item = $item[1];
$amount = $_POST['amount'];

if(ctype_digit($item) && ctype_digit($amount)){
	
	session_start();
	$_SESSION['Items'][$item] = $amount;
	
}



?>