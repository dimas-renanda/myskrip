<?php
require_once "method.php";
$mhs = new Course();
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
	case 'POST':
			if(!empty($_GET["email"])&&!empty($_GET["password"]))
			{
				$id=intval($_GET["id"]);
				$mhs->update_mhs($id);
			}
			else
			{
				$mhs->insert_mhs();
			}		
			break; 
	default:
		// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
		break;
}




?>