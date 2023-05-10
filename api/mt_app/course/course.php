<?php
require_once "method.php";
$course = new Course();
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
	case 'GET':
			if(!empty($_GET["id"]))
			{
				$id=$_GET["id"];
				$course->getSomeCourse($id);
			}
			else
			{
				$course->getCourse();
			}
			break;
	case 'POST':
				if(!empty($_GET["id"]))
				{
					$id=intval($_GET["id"]);
					$sgrade->update_sgrade($id);
				}
				else
				{
					$sgrade->insert_sgrade();
				}		
				break; 
	case 'DELETE':
				$id=intval($_GET["id"]);
				$sgrade->delete_sgrade($id);
				break;
	default:
		// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
		break;
}




?>