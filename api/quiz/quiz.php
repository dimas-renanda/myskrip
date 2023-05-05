<?php
require_once "method.php";
$quiz = new Quiz();
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
	case 'GET':
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				$quiz->getSomeQuizNumber($id);
			}
			else
			{
				$quiz->getQuizNumber();
			}
			break;
	case 'POST':
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				$quiz->update_mhs($id);
			}
			else
			{
				$quiz->insert_mhs();
			}		
			break; 
	case 'DELETE':
		    $id=intval($_GET["id"]);
            $quiz->delete_mhs($id);
            break;
	default:
		// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
		break;
}




?>