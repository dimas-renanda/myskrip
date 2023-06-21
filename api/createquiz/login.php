<?php
require_once "method.php";
$login = new Auth();
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
	case 'POST':
			if(!empty($_POST["id"])&&!empty($_POST["eval"]))
			{
				$id=$_POST["eval"];
				$pass = $_POST["id"];
				$login->createQuiz($id,$pass);
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