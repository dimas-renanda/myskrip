<?php
require_once "method.php";
$sgrade = new Student();
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
	case 'GET':
		if(!empty($_GET["id"]) && !empty($_GET["eval"]) )//courseid
		{
			$id=intval($_GET["id"]);
			$eval = intval($_GET["eval"]);
			$sgrade->getSomeStudentMarkGradeEval($id,$eval);
		}
		if(!empty($_GET["id"]) && @$_GET["mark"] == 'true')//courseid
		{
			$id=intval($_GET["id"]);
			$sgrade->getSomeStudentMarkGrade($id);
		}
		if(@$_GET["mark"] != true && !empty($_GET["id"]) && empty($_GET["eval"]))//studentid
		{
				$id=intval($_GET["id"]);
				$sgrade->getSomeStudent($id);
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