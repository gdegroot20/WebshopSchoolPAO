<?php
session_start();
$removeId = explode("item",$_GET['id']);
foreach ($_SESSION['Items'] as $key => $value) {

	if($key == $removeId[1]){
		$_SESSION['Items'][$key] = '';
		unset($_SESSION['Items'][$key]);
	}
}

