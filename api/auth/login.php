<?php
require_once "method.php";
$login = new Auth();
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
	case 'POST':
			if(!empty($_POST["username"])&&!empty($_POST["password"]))
			{
				$id=$_POST["username"];
				$pass = $_POST["password"];
				$login->signIn($id,$pass);
			}
			else
			{
				$login->showError('something went wrong...');
			}		
			break; 
	default:
		// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
		break;
}

?>