<?php

$to='mail@schoenen.nl';

$name=htmlentities($_POST['name']);
$email=htmlentities($_POST['email']);
$subject=htmlentities($_POST['subject']);
$message=htmlentities($_POST['message']);


if(!empty($name) && !empty($email) && !empty($subject) && !empty($message)){
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		//$error="invalid email";
	}else{
		
		$headers  = "From: $email\r\n"; 
		$headers .= "Content-type: text/html\r\n"; 
		$message='From: $name<BR>'.$message;
		//mail($to, $subject, $message,$headers);

  		echo "mail Send";

		//header("location:..")
	}
	
	
	
	
}
else{
	//$error="Please fill in all required Elements";
}






/*
$db = new PDO('mysql:host=localhost;dbname=webshop;charset=utf8', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("INSERT INTO `emails` (`from`, `email`, `subject`, `message`) VALUES (?,?,?,?)");

$param=array($name,$email,$subject,$message);

$stmt->execute($param);

//$f=$stmt->fetch();
*/

?>