<?php
require_once "method.php";
$mhs = new Evaluation();
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
	case 'GET':
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				$mhs->getSomeEval($id);
			}
			else
			{
				$mhs->getEval();
			}
			break;
	default:
		// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
		break;
}




?>